<?php

namespace Mini\Modules\contrib\products\src\Plugin;

use Mini\Cms\Modules\Messenger\Messenger;
use Mini\Cms\Modules\Modal\MissingDefaultValueForUnNullableColumn;
use Mini\Modules\contrib\products\src\Modal\ProductImageModal;
use Mini\Modules\contrib\products\src\Modal\ProductModal;

class Products
{

    private ProductModal $productModal;

    private ProductImageModal $productImageModal;

    public function __construct()
    {
        $this->productModal = new ProductModal();
        $this->productImageModal = new ProductImageModal();
    }

    /**
     * @throws MissingDefaultValueForUnNullableColumn
     */
    public function newProduct(array $product): bool
    {
        $common_id = time();
        foreach ($product as $key=>$item) {
            if(empty($item)) {
                (new Messenger())->addErrorMessage("Error: field empty note all fields are required");
                return false;
            }
        }
        $images = explode(',', gettype( $product['product_image']) == 'array' ? implode(',', $product['product_image']) :  $product['product_image']);
        $images = array_filter($images,'strlen');
        $images_list = array_map(function ($item) use ($common_id){
            return ['common_id' => $common_id, 'fid'=> $item];
        },$images);
        $product['product_image'] = $common_id;

        $this->productImageModal->massStore($images_list);
        return !empty($this->productModal->store($product));
    }
}