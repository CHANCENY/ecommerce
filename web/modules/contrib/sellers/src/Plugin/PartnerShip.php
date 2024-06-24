<?php

namespace Mini\Modules\contrib\sellers\src\Plugin;

use Mini\Modules\contrib\sellers\src\Modals\VendorLicense;

/**
 * @class PartnerShip contains only static methods for handle partnership.
 */
class PartnerShip
{
    /**
     * Check if user is partner.
     * @param int $current_user
     * @return bool
     */
    public static function isPartner(int $current_user): bool
    {
        $modal = new VendorLicense();

        $status = $modal->get($current_user, 'owner')->getAt(0)?->approved ?? false;
        if($status === 1) {
            return true;
        }

        return false;
    }
}