<?php

namespace Mini\Modules\contrib\products\src\Modal;

use Mini\Cms\Modules\Modal\ColumnClassNotFound;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Columns\Text;
use Mini\Cms\Modules\Modal\Columns\VarChar;
use Mini\Cms\Modules\Modal\Modal;
use Mini\Cms\Modules\Modal\PrimaryKeyColumnMissing;

/**
 * @class ProductModal is product modal.
 */
class ProductModal extends Modal
{
    protected string $main_table = "products";

    /**
     * @throws PrimaryKeyColumnMissing
     * @throws ColumnClassNotFound
     */
    public function __construct()
    {

        $this->columns = array(
            self::buildColumnInstance(Number::class)->parent($this)->name('product_id')->autoIncrement(true)->primary(true)->size(11),
            self::buildColumnInstance(VarChar::class)->parent($this)->size(255)->name('product_name')->nullable(false),
            self::buildColumnInstance(VarChar::class)->parent($this)->size(255)->name('product_weight'),
            self::buildColumnInstance(VarChar::class)->parent($this)->name('product_code')->size(25),
            self::buildColumnInstance(VarChar::class)->parent($this)->name('product_sku')->size(25),
            self::buildColumnInstance(Number::class)->parent($this)->name('product_unit')->size(11),
            self::buildColumnInstance(Number::class)->parent($this)->name('product_status')->size(11),
            self::buildColumnInstance(Number::class)->parent($this)->name('product_normal_price')->size(11),
            self::buildColumnInstance(Number::class)->parent($this)->name('product_discount_price')->size(11),
            self::buildColumnInstance(Number::class)->parent($this)->name('product_image')->size(11),
            self::buildColumnInstance(Text::class)->parent($this)->name('product_description'),
            self::buildColumnInstance(Number::class)->parent($this)->name('product_in_stock')->size(11),
        );
        parent::__construct();
    }
}