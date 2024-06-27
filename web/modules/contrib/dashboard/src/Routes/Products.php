<?php

namespace Mini\Modules\contrib\dashboard\src\Routes;

use Mini\Cms\Controller\ContentType;
use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Controller\StatusCode;
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
        $product_plugin = new \Mini\Modules\contrib\products\src\Plugin\Products();
        if($this->request->isMethod('POST')) {
            $data = json_decode($this->request->getContent(),true) ?? [];
            if(isset($data['actions'])) {
                if($product_plugin->updateProductStatus($data['actions'])){
                    $this->response->setContentType(ContentType::APPLICATION_JSON)
                        ->setStatusCode(StatusCode::OK)
                        ->write(['status'=>true]);
                }
                else {
                    $this->response->setContentType(ContentType::APPLICATION_JSON)
                        ->setStatusCode(StatusCode::NOT_ACCEPTABLE)
                        ->write(['status'=>false]);
                }
                return;
            }
        }
        if($this->request->headers->get('Content-Type') === 'application/json') {
            $vendor = json_decode($this->request->getContent(), true);
            $this->response->setStatusCode(StatusCode::OK)->setContentType(ContentType::APPLICATION_JSON);
            $this->response->write($product_plugin->availableCategories($vendor['vendor_id'] ?? null));
            return;
        }
        if($this->request->query->has('new_product')) {
            if($this->request->isMethod('POST')) {
                $product_plugin->newProduct($this->request->request->all());
            }
            $vendor_modal = new Vendor();
            $vendors = $vendor_modal->get((new CurrentUser())->id(), 'vendor_owner');
            $fist_vendor = $vendors->getAt(0)?->vendor_id;
            $categories = [];
            if($fist_vendor) {
                $categories = $product_plugin->availableCategories($fist_vendor);
            }
            $this->response->write(Services::create('render')->render('add_products.php',['vendors' => $vendors->getRecords(),'categories'=>$categories]));
            return;
        }

        $products = $product_plugin->productsAll((new CurrentUser())->id());
       $this->response->write(Services::create('render')->render('products.php',['products'=>$products]));
    }
}