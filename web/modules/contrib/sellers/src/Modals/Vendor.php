<?php

namespace Mini\Modules\contrib\sellers\src\Modals;

use Mini\Cms\Modules\FileSystem\File;
use Mini\Cms\Modules\Modal\ColumnClassNotFound;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Columns\Text;
use Mini\Cms\Modules\Modal\Columns\VarChar;
use Mini\Cms\Modules\Modal\Modal;
use Mini\Cms\Modules\Modal\PrimaryKeyColumnMissing;
use Mini\Modules\contrib\products\src\Modal\ProductModal;

/**
 * @class Vendor is modal for seller storage.
 */

class Vendor extends Modal
{
    /**
     * Seller storage table.
     * @var string
     */
    protected string $main_table = "shop_vendors";

    /**
     * Construct to build storage fields.
     * @throws ColumnClassNotFound
     * @throws PrimaryKeyColumnMissing
     */
    public function __construct()
    {

        // Fields of table main_table.
        $this->columns = array(
            self::buildColumnInstance(Number::class)->primary(true)->autoIncrement(true)->size(11)->name("vendor_id")->parent($this),
            self::buildColumnInstance(VarChar::class)->nullable(false)->name('vendor_name')->size(255)->parent($this)->description("vendor name is seller shop"),
            self::buildColumnInstance(VarChar::class)->nullable(false)->name('vendor_email_address')->size(255)->description("vendor email address")->parent($this),
            self::buildColumnInstance(VarChar::class)->nullable(false)->name('vendor_phone_number')->parent($this)->description("vendor phone number")->nullable(false)->size(25),
            self::buildColumnInstance(Number::class)->name('vendor_owner')->size(11)->nullable(false)->description("This is uid of vendor owner")->parent($this),
            self::buildColumnInstance(Text::class)->name('vendor_slogan')->size(500)->parent($this)->description("vendor slogan")->nullable(true),
            self::buildColumnInstance(Number::class)->name("vendor_logo")->nullable(true)->size(11)->parent($this)->description("vendor logo"),
        );

        // Running parent construct..
        parent::__construct();
    }

    public static function vendorLogo(int $logo_id): string
    {
        $file = File::load($logo_id);
        return '/'. $file->getFilePath(true);
    }

    public static function vendorProductCount(int $vendor_id): string
    {
        $product_modal = new ProductModal();
        $products = $product_modal->get($vendor_id,'product_vendor')->getRecords();
        return count($products);
    }
}