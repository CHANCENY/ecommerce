<?php

namespace Mini\Modules\contrib\customers\src\Plugin;

use Mini\Cms\Entities\User;
use Mini\Modules\contrib\order\src\Modal\OrderModal;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;

class Customers
{
    private OrderModal $orderModal;
    private Vendor $vendorModal;

    public function __construct()
    {
        $this->orderModal = new OrderModal();
        $this->vendorModal = new Vendor();
    }

    /**
     * Getting all customers that have at least place order from products of your vendors.
     * @param int $current_uid
     * @return array
     */
    public function getMyCustomers(int $current_uid): array
    {
        $vendors = $this->vendorModal->get($current_uid, 'vendor_owner')->getRecords();
        if(empty($vendors)) {
          return [];
        }

        $customers = [];
        foreach ($vendors as $vendor) {
            $orders = $this->orderModal->get($vendor->vendor_id,'vendor_id')->getRecords();
            $customers = array_merge($customers, array_map(function($order){
                if($order->order_status === 3) {
                    return $order->order_by;
                }
                return 0;
            },$orders));
        }

        $customers = array_unique($customers);
        return array_map(function($user_id){
            return User::load($user_id);
        },$customers);
    }

    /**
     * Get how much customer has spent on your product across vendors.
     * @param int $uid
     * @param int $vendor_owner_uid
     * @return int|float
     */
    public static function getCustomerSpending(int $uid, int $vendor_owner_uid): int|float
    {
        $orderModal = new OrderModal();
        $vendorModal = new Vendor();
        $vendors = $vendorModal->get($vendor_owner_uid, 'vendor_owner')->getRecords();
        if(empty($vendors)) {
            return 0;
        }

        $customers = [];
        foreach ($vendors as $vendor) {
            $orders = $orderModal->get($vendor->vendor_id,'vendor_id')->getRecords();
            $customers = array_merge($customers, array_map(function($order){
                if($order->order_status === 3) {
                    return [
                        'uid' => $order->order_by,
                        'amount' => $order->amount,
                    ];
                }
                return [
                    'uid' => 0,
                    'amount' => 0
                ];
            },$orders));
        }

        $amount_spent = 0;
        foreach ($customers as $customer) {
            if($uid === $customer['uid']) {
                $amount_spent += $customer['amount'];
            }
        }
        return $amount_spent;
    }
}