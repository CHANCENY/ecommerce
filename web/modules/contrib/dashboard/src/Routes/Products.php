<?php

namespace Mini\Modules\contrib\dashboard\src\Routes;

use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\products\src\Modal\ProductModal;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;

class Products implements ControllerInterface
{

    public function __construct(private Request &$request, private Response &$response)
    {
    }

    /**
     * @inheritDoc
     */
    public function isAccessAllowed(): bool
    {
        return TRUE;
    }

    public function writeBody(): void
    {
        if($this->request->query->has('new_product')) {
            if($this->request->isMethod('POST')) {
                $product_plugin = new \Mini\Modules\contrib\products\src\Plugin\Products();
                $product_plugin->newProduct($this->request->request->all());
            }
            $vendor_modal = new Vendor();
            $vendors = $vendor_modal->get((new CurrentUser())->id(), 'vendor_owner');
            $this->response->write(Services::create('render')->render('add_products.php',['vendors' => $vendors->getRecords()]));
            return;
        }
       $this->response->write(Services::create('render')->render('products.php'));
    }
}