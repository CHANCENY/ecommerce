<?php

namespace Mini\Modules\contrib\customers\src\Plugin;

use Exception;
use Mini\Cms\Connections\Database\Database;
use Mini\Cms\Entities\User;
use Mini\Cms\Fields\AddressField;
use Mini\Cms\Modules\Modal\MissingDefaultValueForUnNullableColumn;
use Mini\Cms\Modules\Modal\RecordCollections;
use Mini\Cms\Modules\Respositories\Territory\AddressFormat;
use Mini\Modules\contrib\customers\src\Modal\Address;

/**
 * @class AccountSettings for handling customer account settings.
 */

class AccountSettings
{
    /**
     * User property.
     * @var User
     */
    private User $user;

    /**
     * Construct for account settings.
     * @param int $uid
     * @throws Exception
     */
    public function __construct(int $uid)
    {
        $user = User::load($uid);
        if ($user->getUid()) {
            $this->user = $user;
        }
        else {
            throw new Exception('User not found.');
        }
    }

    /**
     * Update default user information.
     * @param array $user_info
     * @return bool
     */
    public function normalUpdate(array $user_info): bool
    {

        $placeholders = array_map(function ($item) {
            return "$item = :$item";
        },array_keys($user_info));

        $query = "UPDATE `users` SET " . implode(', ', $placeholders) . " WHERE `uid` = :uid";
        $query = Database::database()->prepare($query);
        foreach ($user_info as $key => $value) {
           $query->bindValue(':' . $key, $value);
        }
        $query->bindValue(':uid', $this->user->getUid());
        return $query->execute();
    }

    /**
     * Password updating.
     * @param float|bool|int|string $new_password
     * @return bool
     */
    public function passwordUpdate(float|bool|int|string $new_password): bool
    {
        $query = "UPDATE `users` SET `password` = :new_password WHERE `uid` = :uid";
        $query = Database::database()->prepare($query);
        $query->bindValue(':uid', $this->user->getUid());
        $query->bindValue(':new_password', password_hash($new_password, PASSWORD_BCRYPT));
        return $query->execute();
    }

    /**
     * Create address.
     * @param array $data
     * @param array $address_field
     *
     * @return bool|RecordCollections|void
     * @throws MissingDefaultValueForUnNullableColumn
     */
    public function addressUpdateCreation(array $data, array $address_field)
    {
        if($address_field && $data) {
            $place_holders = array_map(function ($item){
                return ":$item";
            }, array_keys($address_field));

            $query = "INSERT INTO address_fields_data (".implode(', ', array_keys($address_field)). ", country_code) VALUES (".implode(', ', $place_holders). ", :country_code)";
            $con = Database::database();
            $query = $con->prepare($query);
            foreach ($address_field as $key=>$value) {
               $query->bindValue(':'.$key, $value);
            }
            $query->bindValue(':country_code', $data['field_customer_address___country']);
            $query->execute();
            $address_id = $con->lastInsertId();
            $address = new Address();

            if(!empty($data['is_default']) == 1) {
                $query = Database::database()->prepare("UPDATE customer_address SET is_default = :de WHERE address_owner = :ow");
                $query->execute([
                    'de' => 0,
                    'ow' => $this->user->getUid(),
                ]);
            }

            return $address->store([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'is_default' => $data['is_default'] ?? 0,
                'address_type' => $data['address_type'],
                'address_field_id' => $address_id,
                'address_owner' => $this->user->getUid(),
                'phone_number' => $data['phone_number'],
            ]);
        }
    }
}