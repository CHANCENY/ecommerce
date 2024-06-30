<?php

namespace Mini\Cms\Web\Controllers;

use Mini\Cms\Controller\ContentType;
use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Controller\StatusCode;
use Mini\Cms\Modules\FileSystem\FileSystem;
use Mini\Modules\contrib\dashboard\src\Modal\Category;
use Mini\Modules\contrib\order\src\Modal\OrderModal;
use Mini\Modules\contrib\order\src\Plugin\OrderHandler;
use Mini\Modules\contrib\products\src\Plugin\Products;
use Mini\Modules\contrib\reviews\src\Plugin\Reviews;

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
        //'https://dummyjson.com/products?limit=10&skip=10&select=title,price'
        $curl = curl_init('https://dummyjson.com/products?skip=20');
        curl_setopt_array($curl,[
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $response = json_decode(curl_exec($curl) , true)['products'] ?? [];

        $catrgory_modal = new Category();
        $product_plugin = new Products();

        if(!empty($response)) {

            foreach ($response as $product) {
                $images = $product['images'] ?? [];
                $images[] = $product['thumbnail'];
                $product_images = [];
                if($images) {
                    $file = new FileSystem();
                    $file->prepareUpload($images,false);
                    $file->save();
                    $images_fids = $file->getUpload();
                    if(!empty($images_fids)) {
                       $product_images = array_map(function($filee){
                           return $filee['fid'];
                       }, $images_fids);
                    }
                }
                $cate =  [
                    "category_name" => $product['category'],
                    "category_slug" => reset($product['tags']),
                    "category_parent" => 'Fruits & Vegetables',
                    "category_description" => "fake",
                    "category_status" => 1,
                    "category_image" => 49,
                    'category_vendor' => 6,
                ];
                $record = $catrgory_modal->store($cate);
                $cate = $record->getAt(0);

                $product_item = [
                    'product_name' => $product['title'],
                    'product_description' => $product['description'],
                    'product_category' => $cate->category_id ?? 3,
                    'product_vendor' => 6,
                    'product_weight' => $product['weight'],
                    'product_sku' => $product['sku'],
                    'product_status' => 1,
                    'product_in_stock' => 1,
                    'product_sizes' => 'small',
                    'product_unit' => 2,
                    'product_normal_price' => $product['price'],
                    'product_discount_price'=> 0,
                    'product_image' => $product_images
                ];
                $product_plugin->newProduct($product_item);
            }
        }

    }
}