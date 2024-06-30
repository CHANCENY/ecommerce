<?php

namespace Mini\Modules\contrib\order\src\Plugin;

use Mini\Cms\Connections\Database\Database;
use Mini\Cms\Connections\Smtp\MailManager;
use Mini\Cms\Connections\Smtp\Receiver;
use Mini\Cms\Entities\User;
use Mini\Cms\Modules\Modal\MissingDefaultValueForUnNullableColumn;
use Mini\Cms\Modules\Modal\RecordCollection;
use Mini\Modules\contrib\order\src\Modal\OrderItemModal;
use Mini\Modules\contrib\order\src\Modal\OrderModal;
use Mini\Modules\contrib\order\src\Modal\OrderStatusEmailModal;
use Mini\Modules\contrib\products\src\Modal\ProductModal;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;
use Mini\Modules\contrib\sellers\src\Modals\VendorLicense;
use Mini\Modules\contrib\sellers\src\Plugin\PartnerShip;

/**
 * @class OrderHandler for handling order for sellers.
 */
class OrderHandler
{
    private OrderModal $orderModal;

    private OrderItemModal $orderItemModal;

    public function __construct()
    {
        $this->orderModal = new OrderModal();
        $this->orderItemModal = new OrderItemModal();
    }

    /**
     * Adding new order to orders storage.
     * @param array $orders
     * @param int $order_by
     * @return bool
     * @throws \Exception
     */
    public function addNewOrder(array $orders, int $order_by): bool
    {

        // First lets validate the order ie thr $orders array need to be of arrays
        if(!empty($orders) && is_array($orders[0])) {

            // Lets validate customer who has made order.
            $user = User::load($order_by);
            if(!$user->getEmail()) {
                throw new \Exception("Customer not found in system or customer email is not valid");
            }

            // Now let's reorganize the orders as per the vendor given

            // Extracting vendor id
            $vendors = array_map(function ($order) {
                $vendor = new Vendor();
                if($vendor->get($order['vendor_id'])->getAt(0)) {
                    return $order['vendor_id'];
                }
                return null;
            },$orders);

            // Removing nulls
            $vendors = array_filter($vendors,function ($item){ return $item !== null; });

            // Populating ids need for creating orders in storage.
            $common_id = array_map(function () {
                sleep(1);
                return time();
            }, $vendors);

            // Grouping orders
            $group_array = [];
            $product = new ProductModal();
            $actual_saved_order = [];

            foreach ($orders as $order) {

                if(!empty($order['vendor_id']) && in_array($order['vendor_id'], $vendors)) {
                    $pro = $product->get($order['product_id'])->getAt(0);

                    if($pro instanceof RecordCollection && $pro->product_status === 1 && $pro->product_in_stock === 1) {

                        $item = [
                            'product_id' => $order['product_id'] ?? $pro->product_id,
                            'product_quantity' => $order['product_quantity'] ?? 1,
                            'product_price' => $order['product_price'] ?? $pro->product_normal_price,
                            'product_name' => $order['product_name'] ?? $pro->product_name,
                            'product_size' => $order['product_size'] ?? null,
                            'product_weight'=> $order['product_weight'] ?? null,
                            'product_vendor' => $order['vendor_id'],
                            'common_id' => $common_id[array_search($order['vendor_id'],$vendors)],
                        ];
                        if(empty($group_array[$order['vendor_id']]['common_id'])) {
                            $group_array[$order['vendor_id']] = [
                                'common_id' => $common_id[array_search($order['vendor_id'],$vendors)],
                                'order_by' => $order_by,
                                'order_status' => 'ordered',
                                'vendor_id' => $order['vendor_id'],
                                'item_line' => [$item],
                            ];
                            $actual_saved_order[] = $common_id[array_search($order['vendor_id'],$vendors)];
                        }
                        else {
                            $group_array[$order['vendor_id']]['item_line'][] = $item;
                        }
                    }
                }

            }

            if(!$group_array) {
                throw new \Exception("Ordering has failed due to lack of item in vendors shops");
            }

            foreach ($group_array as $item) {
                $item_line = $item['item_line'] ?? null;

                $this->orderItemModal->massStore($item_line);
                $this->orderModal->store($item);
            }

            // Sending email to customer.
            $receiver = new Receiver(array(['name'=>$user->getFirstname().' '.$user->getLastname(), 'mail'=>$user->getEmail()]));
            foreach ($actual_saved_order as $item) {
                MailManager::mail($receiver)->send([
                    'subject' => "Placed order #".$item,
                    'body' => "<p>Hello {$user->getFirstname()}<br>Thank you for placing your order, our vendor will confirm your order shortly</p><br><p>Order ID: ".$item . "</p>"
                ]);
            }

            // Sending mails to vendors whose item have just been placed.
            foreach ($vendors as $vendor) {
                $vendor_modal = new Vendor();
                $v = $vendor_modal->get($vendor)->getAt(0);
                if($v) {
                    $receiver = new Receiver(array([
                        'name' => $v->vendor_name,
                        'mail' => $v->vendor_email_address,
                    ]));
                    MailManager::mail($receiver)->send([
                        'subject' => "Order Notification",
                        'body'=> "<p>Hello {$v->vendor_name}<br>You have received order from customer please confirm the order on site dashboard thank you.</p>",
                    ]);
                }
            }
        }

        return false;
    }

    /**
     * Getting orders from orders storage.
     * @param int $current_uid
     * @return array
     */
    public function getOrders(int $current_uid): array
    {
        // If is pattern which means we will use vendor ids to get orders if not the use current user id
        if(PartnerShip::isPartner($current_uid))
        {
            $vendors_modal = new Vendor();
            $vendors = $vendors_modal->get($current_uid, 'vendor_owner')->getRecords();
            $orders = [];
            foreach ($vendors as $vendor) {
                $order_on_vendor = $this->orderModal->get($vendor->vendor_id,'vendor_id')->getRecords();
                $orders = array_merge($orders, $order_on_vendor);
            }
            return $orders;
        }

        return $this->orderModal->get($current_uid, 'order_by')->getRecords();
    }

    /**
     * Updating order status
     * @param mixed $orders array of arrays with each array with key order_id and status (int)
     * @return bool
     * @throws MissingDefaultValueForUnNullableColumn
     */
    public function updateOrderStatus(mixed $orders): bool
    {
        $flag = [];
        if(is_array($orders)) {
            foreach ($orders as $order) {
                if($this->orderModal->update(['order_status'=>$order['status']],$order['order_id'])) {
                    $this->queueStatusMail($order['order_id'], $order['status']);
                    $flag[] = true;
                }

            }
        }
        return in_array(true, $flag);
    }

    /**
     * Adding email of order status to queue.
     * @param mixed $order_id
     * @param mixed $status
     * @return void
     * @throws MissingDefaultValueForUnNullableColumn
     */
    public function queueStatusMail(mixed $order_id, mixed $status): void
    {
        if(!empty($order_id) && !empty($status)) {

            $common_id = $this->orderModal->get($order_id)->getAt(0)?->common_id;
            $order_by = $this->orderModal->get($order_id)->getAt(0)?->order_by;
            $created_at = $this->orderModal->get($order_id)->getAt(0)?->customer_orders_created;
            $user = User::load($order_by);
            if($common_id && !empty($user->getEmail())) {
                $mail = [];
                switch((int)$status) {

                    case 1:
                        $mail['mail_subject'] = "Order Confirmation #".$common_id;
                        $mail['mail_body'] = "<p>Hello {$user->getFirstname()},<br>The order you placed on {$created_at} has been confirmed by our seller.<br>This email is confirmation that order #$common_id is ready for shipping to your address<br>
                                              <br>Thank you.";
                        $mail['attachment'] = null;
                        $mail['mail_to'] = $user->getUid();
                        break;
                    case 2:
                        $mail['mail_subject'] = "Shipping #".$common_id;
                        $mail['mail_body'] = "<p>Hello {$user->getFirstname()},<br>The order you placed on {$created_at} has been dispatched by our seller.<br>This email is confirmation of dispatchement of the order #$common_id to your address<br>
                                              <br>Thank you.";
                        $mail['attachment'] = null;
                        $mail['mail_to'] = $user->getUid();
                        break;
                    case 3:
                        $mail['mail_subject'] = "Delivered #".$common_id;
                        $mail['mail_body'] = "<p>Hello {$user->getFirstname()},<br>The order #{$common_id} has been delivered by our delivery partner.<br>This email is confirmation that order #$common_id has been delivered successfully.<br>
                                              <br>Thank you.";
                        $mail['attachment'] = null;
                        $mail['mail_to'] = $user->getUid();
                        break;
                    case 4:
                        $mail['mail_subject'] = "Order Cancelled #".$common_id;
                        $mail['mail_body'] = "<p>Hello {$user->getFirstname()},<br>The order you placed on {$created_at} has been cancelled by our seller.<br>This email is confirmation that order #$common_id has been cancelled and we apologise for incovenience this may have caused.<br>
                                              <br>Thank you.";
                        $mail['attachment'] = null;
                        $mail['mail_to'] = $user->getUid();
                        break;
            }

               if(!empty($mail)) {
                   $mail_order_modal = new OrderStatusEmailModal();
                   $mail_order_modal->store($mail);
               }
            }
        }
    }

    /**
     * Get order
     * @param string $common_id
     * @return array
     */
    public function getOrder(string $common_id): array
    {
        $order = $this->orderModal->get($common_id, 'common_id')->getAt(0);
        if($order) {
            $items = $this->orderItemModal->get($common_id, 'common_id')->getRecords();
            return array(
                'order' => $order,
                'items' => $items
            );
        }
        return [];
    }

    /**
     * Getting customer address.
     * @param int $address_field_id
     * @return array|bool
     */
    public static function shippingAddress(int $address_field_id): array|bool
    {
        $query = Database::database()->prepare('SELECT * FROM address_fields_data WHERE lid = :id');
        $query->execute(['id'=>$address_field_id]);
        return $query->fetch();
    }

    /**
     * Set or update order note.
     * @param string $common_id
     * @param string $note
     * @return bool
     */
    public function addOrderNote(string $common_id, string $note): bool
    {
        if(is_numeric($common_id) && $note) {
            $order = $this->orderModal->get($common_id, 'common_id')->getAt(0);
            if($order &&  $this->orderModal->update(['order_note'=>$note],$common_id)) {
                $user = User::load($order->order_by);
                $receiver = new Receiver([['name'=>$user->getFirstname(), 'mail'=>$user->getEmail()]]);
                MailManager::mail($receiver)
                    ->send(['subject'=>'Note for order #'.$common_id, 'body'=>$note]);
                return true;
            }
        }
        return false;
    }
}