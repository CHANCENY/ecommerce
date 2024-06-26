<?php

namespace Mini\Modules\contrib\products\src\Modal;

use Mini\Cms\Modules\Modal\ColumnClassNotFound;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Modal;
use Mini\Cms\Modules\Modal\PrimaryKeyColumnMissing;

class ProductImageModal extends Modal
{
    protected string $main_table = "products_images";

    /**
     * @throws ColumnClassNotFound
     * @throws PrimaryKeyColumnMissing
     */
    public function __construct()
    {

        $this->columns = array(
            self::buildColumnInstance(Number::class)->parent($this)->name('image_id')->primary(true)->autoIncrement(true)->size(11),
            self::buildColumnInstance(Number::class)->parent($this)->name('fid')->size(11),
            self::buildColumnInstance(Number::class)->parent($this)->name('common_id')->size(15),
        );
        parent::__construct();
    }
}