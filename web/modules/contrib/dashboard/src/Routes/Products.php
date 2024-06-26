<?php

namespace Mini\Modules\contrib\dashboard\src\Routes;

use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\products\src\Modal\ProductModal;

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
            $this->response->write(Services::create('render')->render('add_products.php'));
            return;
        }
       $this->response->write(Services::create('render')->render('products.php'));
    }
}