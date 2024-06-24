<?php

namespace Mini\Modules\contrib\sellers\src\Routes;

use Mini\Cms\Connections\Smtp\MailManager;
use Mini\Cms\Connections\Smtp\Receiver;
use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;
use Mini\Modules\contrib\sellers\src\Modals\VendorLicense;
use Mini\Modules\contrib\sellers\src\Plugin\PartnerShip;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PartnerShipRequest implements ControllerInterface
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

            if(!PartnerShip::isPartner($current_user->id())) {
                $license = [
                    'owner' => $current_user->id(),
                    'approved' => 2
                ];

                $modal_license = new VendorLicense();
                if($modal_license->store($license)) {

                    $receiver = new Receiver([
                        [
                            'name' => $current_user->getFirstName(),
                            'mail' => $current_user->getAccountEmail(),
                        ]
                    ]);

                    $mail = new MailManager($receiver);
                    $mail->send([
                        'subject' => "Partnership Request.",
                        'body' => "<p>Hi {$vendor['vendor_name']},<br> Thank you for applying to become seller on our site, your request is under review which should take take not more than 2 hours<br>
                                      <br><br>Thank you for your patience<br><br>Administrator</p>"
                    ]);
                }
            }

            // Create vendor.
            $vendor_modal = new Vendor();
            if($vendor_modal->store($vendor)) {
                (new RedirectResponse('/'))->send();
                exit;
            }

        }
        $this->response->write(Services::create('render')->render('request_partnership_form.php'));
    }
}