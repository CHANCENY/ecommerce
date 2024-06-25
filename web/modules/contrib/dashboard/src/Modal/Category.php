<?php

namespace Mini\Modules\contrib\dashboard\src\Modal;

use Mini\Cms\Modules\FileSystem\File;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Columns\VarChar;
use Mini\Cms\Modules\Modal\Modal;

/**
 * @class Category modal
 */
class Category extends Modal
{
    /**
     * @var string
     */
    protected string $main_table = "products_categories";


    public function __construct()
    {
        $this->columns = array(
            self::buildColumnInstance(Number::class)->parent($this)->name('category_id')->size(11)->primary(true)->autoIncrement(true)->description("This is category id"),
        );

        $list = array(
            "category_name",
            "category_slug",
            "category_parent",
            "category_date",
            "category_description",
            "category_status",
            "category_image"
        );

        foreach ($list as $name) {
            $this->columns[] = self::buildColumnInstance(VarChar::class)->name($name)->size(255)->description("This is category " . $name)
                ->parent($this);
        }

        parent::__construct();
    }

    public static function categoryImage(int $category_image_id): string
    {
        $file = File::load($category_image_id);
        return  '/'. $file->getFilePath(true);
    }
}