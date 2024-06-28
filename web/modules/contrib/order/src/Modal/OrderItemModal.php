<?php

namespace Mini\Modules\contrib\order\src\Modal;

use Mini\Cms\Modules\Modal\ColumnClassNotFound;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Columns\VarChar;
use Mini\Cms\Modules\Modal\Modal;

/**
 * @class OrderItemModal will hold order data.
 */
class OrderItemModal extends Modal
{
    protected string $main_table = "order_items";

    /**
     * @throws ColumnClassNotFound|\Mini\Cms\Modules\Modal\PrimaryKeyColumnMissing
     */
    public function __construct()
    {
        $this->columns = array(
            self::buildColumnInstance(Number::class)->name('order_item_id')->size(11)->parent($this)->primary(true)->autoIncrement(true),
            self::buildColumnInstance(Number::class)->name('product_id')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('product_quantity')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('product_price')->size(11)->parent($this),
            self::buildColumnInstance(VarChar::class)->name('product_name')->size(255)->parent($this),
            self::buildColumnInstance(Number::class)->name('product_vendor')->size(11)->parent($this),
            self::buildColumnInstance(VarChar::class)->name('product_size')->size(50)->nullable(true)->parent($this),
            self::buildColumnInstance(VarChar::class)->name('product_weight')->size(50)->nullable(true)->parent($this),
            self::buildColumnInstance(VarChar::class)->name('common_id')->size(50)->nullable(true)->parent($this),
        );

        parent::__construct();
    }

}