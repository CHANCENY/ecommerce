<?php

namespace Mini\Modules\contrib\products\src\Plugin;

use Mini\Cms\Modules\FileSystem\File;
use Mini\Cms\Modules\Messenger\Messenger;
use Mini\Cms\Modules\Modal\MissingDefaultValueForUnNullableColumn;
use Mini\Cms\Modules\Modal\RecordCollection;
use Mini\Modules\contrib\dashboard\src\Modal\Category;
use Mini\Modules\contrib\products\src\Modal\ProductImageModal;
use Mini\Modules\contrib\products\src\Modal\ProductModal;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;

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

    /**
     * Get all products belongs to vendors that belongs to this current user.
     * @param int $current_uid
     * @return array
     */
    public function productsAll(int $current_uid): array
    {
        $vendor_modal = new Vendor();
        $vendors = $vendor_modal->get($current_uid, 'vendor_owner')->getRecords();
        if($vendors) {
            $products_list = [];
            foreach ($vendors as $vendor) {
                if($vendor instanceof RecordCollection) {
                    $vendor_id = $vendor->vendor_id ?? null;
                    if($vendor_id) {
                        $prods = $this->productModal->get($vendor_id, 'product_vendor')->getRecords();
                        $products_list = array_merge($products_list, $prods);
                    }
                }
            }
            return $products_list;
        }
        return  array();
    }

    /**
     * Getting images paths of products.
     * @param int $product_image
     * @return array
     */
    public static function productImages(int $product_image): array
    {
        $product_images_modal = new ProductImageModal();
        $images = $product_images_modal->get($product_image, 'common_id')->getRecords();
        $images_paths = [];

        foreach ($images as $image) {
            if($image instanceof RecordCollection) {
                $file = File::load($image->fid);
                $images_paths[] = '/'. $file->getFilePath(true);
            }
        }
        return $images_paths;
    }

    /**
     * Getting all category belongs to vendor.
     * @param int|null $vendor
     * @return array
     */
    public function availableCategories(int|null $vendor): array
    {
        $category_list = [];
        if($vendor) {
            $category = new Category();
            $categories = $category->get($vendor,'category_vendor')->getRecords();

            foreach ($categories as $cate) {
                $category_list[] = [
                    'category_id' => $cate->category_id,
                    'category_name' => $cate->category_name
                ];
            }
        }
        return $category_list;
    }

    /**
     * Get product category.
     * @param int $category_id
     * @return RecordCollection|null
     */
    public static function getProductCategory(int $category_id): RecordCollection|null
    {
        $modal_category = new Category();
        return $modal_category->get($category_id)->getAt(0);

    }

    /**
     * Get vendor details using vendor id from product modal.
     * @param int $vendor_id
     * @return RecordCollection|null
     */
    public static function getProductVendor(int $vendor_id): ?RecordCollection
    {
        $vendor_modal = new Vendor();
         return $vendor_modal->get($vendor_id)->getAt(0);
    }

    /**
     * Updating product statuses as follows.
     * @param array $data This contains array of arrays with each array having product_id key and action key
     * NOTE: action values are 1 to 4 ie active, deactivate, out stock and In stock.
     * @return bool
     */
    public function updateProductStatus(array $data): bool
    {
        $flag = [];
        foreach ($data as $datum) {
            $column_to_update = null;
            $column_value = 0;
            switch ($datum['action']) {
                case '1':
                    $column_to_update =  'product_status';
                    $column_value = 1;
                    break;
                case '2':
                    $column_to_update =  'product_status';
                    break;
                case '3':
                    $column_to_update =  'product_in_stock';
                    break;
                case '4':
                    $column_to_update = 'product_in_stock';
                    $column_value = 1;
            }
            if($this->productModal->update([$column_to_update => $column_value],$datum['product_id'])) {
                $flag[] = true;
            }
        }
        return in_array(true, $flag);
    }
}