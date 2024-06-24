<?php

namespace Mini\Modules\contrib\sellers\src\Modals;

use Mini\Cms\Modules\Modal\ColumnClassNotFound;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Modal;
use Mini\Cms\Modules\Modal\PrimaryKeyColumnMissing;

/**
 * @class VendorLicense is required to be subscribed to only then user can start selling.
 * products.
 */
class VendorLicense extends Modal
{
    protected string $main_table = "vendors_license";

    /**
     * @throws ColumnClassNotFound
     * @throws PrimaryKeyColumnMissing
     */
    public function __construct()
    {
        $this->columns = array(
            self::buildColumnInstance(Number::class)->primary(true)->name('license_id')->autoIncrement(true)->size(11)->parent($this),
            self::buildColumnInstance(Number::class)->name('owner')->parent($this)->size(11)->description("User who has agreed to term and condition of doing business")->unique(true),
            self::buildColumnInstance(Number::class)->name('approved')->size(11)->parent($this)->description("Approved by administration to start posting products."),
        );

        parent::__construct();
    }
}