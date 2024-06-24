<?php

namespace Mini\Modules\contrib\customers\src\Modal;

use Mini\Cms\Connections\Database\Database;
use Mini\Cms\Modules\Modal\ColumnClassNotFound;
use Mini\Cms\Modules\Modal\Columns\Number;
use Mini\Cms\Modules\Modal\Columns\VarChar;
use Mini\Cms\Modules\Modal\Modal;
use Mini\Cms\Modules\Modal\PrimaryKeyColumnMissing;
use Mini\Cms\Modules\Respositories\Territory\Country;
use Mini\Cms\Modules\Respositories\Territory\State;

class Address extends Modal
{
    protected string $main_table = "customer_address";

    /**
     * @throws ColumnClassNotFound
     * @throws PrimaryKeyColumnMissing
     */
    public function __construct()
    {

        $this->columns = array(
            self::buildColumnInstance(Number::class)->name('address_id')->parent($this)->primary(true)->autoIncrement(true)->size(11)->description("Address id"),
            self::buildColumnInstance(Number::class)->name('address_owner')->size(11)->parent($this)->description('Address owner uid')->nullable(false),
            self::buildColumnInstance(Number::class)->name('address_field_id')->size(11)->parent($this)->description("address field id"),
            self::buildColumnInstance(VarChar::class)->name('firstname')->parent($this)->size(255)->nullable(false)->description('address firstname'),
            self::buildColumnInstance(VarChar::class)->name('lastname')->parent($this)->size(255)->nullable(false)->description('address lastname'),
            self::buildColumnInstance(VarChar::class)->name('address_type')->parent($this)->nullable(false)->description('address type')->size(255),
            self::buildColumnInstance(Number::class)->name('is_default')->description('is default if 1')->nullable(true)->parent($this)->size(11),
            self::buildColumnInstance(VarChar::class)->name('phone_number')->description('address phone number')->nullable(false)->parent($this)->size(255),
        );
        parent::__construct();
    }

    /**
     * Address information
     * @param int $address_field_id
     * @return mixed
     */
    public function address(int $address_field_id): mixed
    {
        $query = Database::database()->prepare("SELECT * FROM address_fields_data WHERE lid = :id");
        $query->execute(['id'=>$address_field_id]);
        $data = $query->fetch();

        $country = new Country($data['country_code']);
        $data['country_name'] = $country->getName();
        if(!empty($data['state_code'])) {
            $state = new State($country->getIso2(),$data['state_code']);
            $data['state_name'] = $state->getName();
        }
        return $data;
    }
}