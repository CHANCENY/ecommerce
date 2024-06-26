<?php

namespace Mini\Modules\contrib\sellers\src\Routes;

use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;
use Symfony\Component\HttpFoundation\RedirectResponse;

class VendorCreation implements ControllerInterface
{

    public function __construct(private Request &$request, private Response &$response)
    {
    }

    /**
     * @inheritDoc
     */
    public function isAccessAllowed(): bool
    {
        return true;
    }

    public function writeBody(): void
    {
        if($this->request->isMethod('POST')) {

            $current_user = new CurrentUser();

            // Checking if this is first vendor creation.
            $vendor = [
                'vendor_name' => $this->request->getPayload()->get('vendor_name'),
                'vendor_phone_number' => $this->request->getPayload()->get('vendor_phone_number'),
                'vendor_logo' => $this->request->getPayload()->get('vendor_logo'),
                'vendor_email_address' => $this->request->getPayload()->get('vendor_email_address'),
                'vendor_slogan' => $this->request->getPayload()->get('vendor_slogan'),
                'vendor_owner' => $current_user->id(),
            ];

            foreach ($vendor as $k=>$item) {
                if(empty($item)) {
                    return;
                }
            }

            // Create vendor.
            $vendor_modal = new Vendor();
            if($vendor_modal->store($vendor)) {
                (new RedirectResponse('/shop/vendors'))->send();
                exit;
            }

        }
        $this->response->write(Services::create('render')->render('vendor_creation.php'));
    }
}