<?php

namespace Mini\Modules\contrib\order\src\Modal;

use Mini\Cms\Modules\Modal\ColumnClassNotFound;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Columns\Text;
use Mini\Cms\Modules\Modal\Columns\VarChar;
use Mini\Cms\Modules\Modal\Modal;
use Mini\Cms\Modules\Modal\PrimaryKeyColumnMissing;

/**
 * @class Order is response for hold orders data.
 */
class OrderModal extends Modal
{
    protected string $main_table = 'customer_orders';

    /**
     * @throws PrimaryKeyColumnMissing
     * @throws ColumnClassNotFound
     */
    public function __construct()
    {
        $this->columns = array(
            self::buildColumnInstance(Number::class)->primary(true)->autoIncrement(true)->name('order_id')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('order_by')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('order_status')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('common_id')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('vendor_id')->size(11)->parent($this),
            self::buildColumnInstance(VarChar::class)->name('amount')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('shipping_address_id')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('payment_id')->size(11)->parent($this)->nullable(true),
            self::buildColumnInstance(Text::class)->name('order_note')->parent($this),
        );

        parent::__construct();
    }

}