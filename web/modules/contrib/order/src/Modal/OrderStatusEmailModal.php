<?php

namespace Mini\Modules\contrib\order\src\Modal;

use Mini\Cms\Modules\Modal\ColumnClassNotFound;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Columns\Text;
use Mini\Cms\Modules\Modal\Columns\VarChar;
use Mini\Cms\Modules\Modal\Modal;
use Mini\Cms\Modules\Modal\PrimaryKeyColumnMissing;

class OrderStatusEmailModal extends Modal
{
    protected string $main_table = "orders_mails_records";

    /**
     * @throws PrimaryKeyColumnMissing
     * @throws ColumnClassNotFound
     */
    public function __construct()
    {
        $this->columns = array(
            self::buildColumnInstance(Number::class)->name('order_mail_id')->parent($this)->size(11)->autoIncrement(true)->primary(true),
            self::buildColumnInstance(Number::class)->name('mail_to')->size(11)->parent($this),
            self::buildColumnInstance(VarChar::class)->name('mail_subject')->size(255)->parent($this),
            self::buildColumnInstance(Text::class)->name('mail_body')->parent($this),
            self::buildColumnInstance(Number::class)->name('attachment')->parent($this)->nullable(true)->size(11),
        );

        parent::__construct();
    }
}