<?php

namespace Mini\Modules\contrib\reviews\src\Plugin;

use Mini\Cms\Connections\Database\Database;
use Mini\Cms\Entities\User;
use Mini\Cms\Modules\Modal\MissingDefaultValueForUnNullableColumn;
use Mini\Cms\Modules\Modal\RecordCollection;
use Mini\Modules\contrib\products\src\Modal\ProductImageModal;
use Mini\Modules\contrib\products\src\Modal\ProductModal;
use Mini\Modules\contrib\reviews\src\Modal\ReviewModal;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;
use Mini\Modules\contrib\sellers\src\Plugin\PartnerShip;

class Reviews
{
    private ReviewModal $reviewModal;

    private ProductModal $productModal;

    public function __construct()
    {
        $this->productModal = new ProductModal();
        $this->reviewModal = new ReviewModal();
    }

    /**
     * New review of product.
     * @param array $review
     * @return bool
     * @throws MissingDefaultValueForUnNullableColumn
     */
    public function addNewReview(array $review): bool
    {
        if(!empty($review['product_id']) && !empty($review['reviewer']) && $review['rating'] && $review['vendor_id']) {
            if($this->reviewModal->store($review)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get reviews by current user.
     * @param int $current_uid
     * @return array
     */
    public function getReviews(int $current_uid): array
    {
        $reviews_list = [];

        if(PartnerShip::isPartner($current_uid)) {
            $vendor = new Vendor();
            $vendors = $vendor->get($current_uid, 'vendor_owner')->getRecords();

            $vendor_id_list = [];
            foreach($vendors as $vendor_d) {
                $vendor_id_list[] = $vendor_d->vendor_id;
            }

            foreach ($vendor_id_list as $item) {
                $reviews_on_vendor_products = $this->reviewModal->get($item,'vendor_id')->getRecords();
                $reviews_list = array_merge($reviews_list, $reviews_on_vendor_products);
            }

        }
        else {
            $reviews_list = $this->reviewModal->get($current_uid, 'reviewer')->getRecords();
        }
        return $reviews_list;
    }

    /**
     * Get Review.
     * @param int $review_id
     * @return RecordCollection|null
     */
    public function getReview(int $review_id): ?RecordCollection
    {
        return $this->reviewModal->get($review_id)->getAt(0);
    }

    public function getRatingAverage(int $product_id): int
    {
        $query = "SELECT product_id, AVG(rating) AS average_rating FROM products_reviews WHERE product_id = :id GROUP BY product_id";
        $query = Database::database()->prepare($query);
        $query->execute(['id'=>$product_id]);
        $data = $query->fetch();
        return floor($data['average_rating'] ?? 0);
    }
}