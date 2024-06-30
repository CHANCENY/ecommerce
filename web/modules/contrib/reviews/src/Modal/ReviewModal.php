<?php

namespace Mini\Modules\contrib\reviews\src\Modal;

use Mini\Cms\Modules\Modal\ColumnClassNotFound;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Columns\Text;
use Mini\Cms\Modules\Modal\Modal;
use Mini\Cms\Modules\Modal\PrimaryKeyColumnMissing;

/**
 * @class ReviewModal will handle reviews.
 */
class ReviewModal extends Modal
{
    protected string $main_table = "products_reviews";

    /**
     * @throws PrimaryKeyColumnMissing
     * @throws ColumnClassNotFound
     */
    public function __construct()
    {
        $this->columns = array(
            self::buildColumnInstance(Number::class)->name('review_id')->primary(true)->autoIncrement(true)->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('product_id')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('reviewer')->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('rating')->size(11)->setAsDefined(1)->parent($this),
            self::buildColumnInstance(Number::class)->name('vendor_id')->size(11)->parent($this),
            self::buildColumnInstance(Text::class)->name('comment')->nullable(true)->parent($this),
        );

        parent::__construct();
    }
}