<?php

namespace Mini\Modules\contrib\front\src\Plugin;


use Mini\Cms\Connections\Database\Database;
use Mini\Modules\contrib\dashboard\src\Modal\Category;
use Mini\Modules\contrib\order\src\Modal\OrderItemModal;
use Mini\Modules\contrib\order\src\Modal\OrderModal;
use Mini\Modules\contrib\products\src\Modal\ProductImageModal;
use Mini\Modules\contrib\products\src\Modal\ProductModal;

/**
 * @class ProductAccess will give how to handle products
 */
class ProductsAccess
{

    private ProductModal $productModal;

    private ProductImageModal $productImageModal;

    private OrderModal $orderModal;

    private OrderItemModal $orderItemModal;

    public function __construct()
    {
        $this->productModal = new ProductModal();
        $this->productImageModal = new ProductImageModal();
        $this->orderModal = new OrderModal();
        $this->orderItemModal = new OrderItemModal();
    }

    /**
     * Getting products which have been ordered before.
     * @return array
     */
    public function getPopularProducts(): array
    {
        // Query line building.
        $query = "SELECT product_id, COUNT(*) AS order_count FROM order_items WHERE order_items_created BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() GROUP BY product_id ORDER BY order_count DESC LIMIT 10";
        $query = Database::database()->prepare($query);
        $query->execute();
        $products = $query->fetchAll();

        // Processing products
        $products_records = array();
        if(!empty($products)) {
            $flag= 0;
            foreach ($products as $product) {
                $prod = $this->productModal->get($product['product_id'])->getAt(0);
                if($prod) {
                    $products_records[] = $this->productModal->get($product['product_id'])->getAt(0);
                }
            }
        }

        if(count($products_records) < 10) {
            $products = $this->productModal->range(10 - count($products_records),0)->getRecords();
            $products_records = array_merge($products_records, $products);
        }

        return $products_records;
    }

    /**
     * Get products by sells.
     * @return array
     */
    public function getTodayBestSells(): array
    {
        $query = "SELECT product_id, SUM(product_price) AS total_price FROM order_items GROUP BY product_id ORDER BY total_price DESC LIMIT 3";
        $query = Database::database()->prepare($query);
        $query->execute();
        $products = $query->fetchAll();

        // Processing products
        $products_records = array();
        if(!empty($products)) {
            $flag= 0;
            foreach ($products as $product) {
                $prod = $this->productModal->get($product['product_id'])->getAt(0);
                if($prod) {
                    $products_records[] = $this->productModal->get($product['product_id'])->getAt(0);
                }
            }
        }

        if(count($products_records) < 3) {
            $products = $this->productModal->range(3 - count($products_records),0)->getRecords();
            $products_records = array_merge($products_records, $products);
        }

        return $products_records;
    }

    /**
     * Get latest 20 categories.
     * @return array
     */
    public function getCategories(): array
    {
        $query = "SELECT category_id FROM products_categories GROUP BY category_name ORDER BY products_categories_created DESC LIMIT 20";
        $query = Database::database()->prepare($query);
        $query->execute();
        $data = $query->fetchAll();
        $category_modal = new Category();
        foreach ($data as $key=>$datum) {
            $data[$key] = $category_modal->get($datum['category_id'])->getAt(0);
        }
        return $data;
    }

    public function getParentCategories(): array
    {
        $query = "SELECT category_id FROM products_categories GROUP BY category_parent ORDER BY products_categories_created DESC LIMIT 20";
        $query = Database::database()->prepare($query);
        $query->execute();
        $data = $query->fetchAll();
        $category_modal = new Category();
        foreach ($data as $key=>$datum) {
            $data[$key] = $category_modal->get($datum['category_id'])->getAt(0);
        }
        return $data;
    }

    public function getMegaMenu(): array
    {
        $parent_categories = $this->getParentCategories();
        $parents = [];
        foreach ($parent_categories as $parent_category) {
            $parents[$parent_category->category_parent] = [];
        }

        $query = "SELECT category_id FROM (SELECT category_id, category_name, products_categories_created FROM products_categories WHERE category_parent = :pa ORDER BY RAND()) subquery GROUP BY category_name ORDER BY products_categories_created DESC LIMIT 8";
        foreach ($parents as $key=>&$parent) {
            $query1 = Database::database()->prepare($query);
            $query1->execute(['pa'=>$key]);
            $data = $query1->fetchAll();
            if($data) {
                foreach ($data as $datum) {
                    $parent[] = (new Category())->get($datum['category_id'])->getAt(0);
                }
            }
        }
        return $parents;
    }
}