<?php

namespace Mini\Modules\contrib\order\src\Plugin;

use Mini\Cms\Connections\Smtp\MailManager;
use Mini\Cms\Connections\Smtp\Receiver;
use Mini\Cms\Entities\User;
use Mini\Cms\Modules\Modal\RecordCollection;
use Mini\Modules\contrib\order\src\Modal\OrderItemModal;
use Mini\Modules\contrib\order\src\Modal\OrderModal;
use Mini\Modules\contrib\products\src\Modal\ProductModal;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;

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
}