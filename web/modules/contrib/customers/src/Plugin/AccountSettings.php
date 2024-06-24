<?php

namespace Mini\Modules\contrib\customers\src\Plugin;

use Exception;
use Mini\Cms\Connections\Database\Database;
use Mini\Cms\Entities\User;

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
}