<?php

namespace Mini\Cms\Web\Controllers;

use Mini\Cms\Controller\ContentType;
use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Controller\StatusCode;
use Mini\Modules\contrib\order\src\Modal\OrderModal;
use Mini\Modules\contrib\order\src\Plugin\OrderHandler;

class Sample implements ControllerInterface
{

    public function __construct(private Request &$request, private Response &$response)
    {
    }

    /**
     * @inheritDoc
     */
    public function isAccessAllowed(): bool
    {
        return true;
    }

    public function writeBody(): void
    {
        $order_items = array(
            [
                'vendor_id' => 6,
                'product_id' => 1,
                'product_name'=>'Mango Juice',
                'product_quantity' => 2,
                'product_size' => 'large',
                'product_weight'=> null,
            ],
            [
            'vendor_id' => 6,
            'product_id' => 2,
            'product_quantity' => 2,
            'product_size' => 'large',
            'product_weight'=> null,
            ],
            [
                'vendor_id' => 6,
                'product_id' => 2,
                'product_quantity' => 2,
                'product_size' => 'large',
                'product_weight'=> null,
            ]
        );

        try {
            $ordr_handler = new OrderHandler();
            $ordr_handler->addNewOrder($order_items, 1);
        }catch (\Throwable $e) {
            $this->response->write($e->getMessage());
        }


    }
}