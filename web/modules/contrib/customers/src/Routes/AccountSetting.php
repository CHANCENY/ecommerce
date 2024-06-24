<?php

namespace Mini\Modules\contrib\customers\src\Routes;

use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Modules\Messenger\Messenger;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\customers\src\Plugin\AccountSettings;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AccountSetting extends CurrentUser implements ControllerInterface
{

    private AccountSettings $accountSettings;

    private Messenger $messenger;

    public function __construct(private Request &$request, private Response &$response)
    {
        parent::__construct();

        $this->accountSettings = new AccountSettings((int) $this->id());
        $this->messenger = new Messenger();
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
        $this->normalUpdate();
        $this->passwordChange();
        $this->response->write(Services::create('render')->render('account_settings.php',['settings'=>$this]));
    }

    private function normalUpdate(): void
    {
        if($this->request->isMethod('POST') && $this->request->request->has('normal_update')) {
            $profile = [
                'firstname' => $this->request->request->get('firstname'),
                'lastname' => $this->request->request->get('lastname'),
                'image' => $this->request->request->get('profile'),

            ];
            foreach ($profile as $key => $value) {
                if(empty($value)) {
                    unset($profile[$key]);
                }
            }
            if($this->accountSettings->normalUpdate($profile)) {
                $this->messenger->addMessage("Account settings have been updated.");
                (new RedirectResponse('/'))->send();
                exit;
            }
        }
    }

    /**
     * Change password.
     * @return void
     */
    private function passwordChange(): void
    {
        if($this->request->isMethod('POST') && $this->request->request->has('password_change')) {
            $old_password = $this->getPassword();
            $old_password_given = $this->request->request->get('current_password');
            $new_password = $this->request->request->get('new_password');
            if($old_password && $old_password_given && $new_password) {
                if(password_verify($old_password_given, $old_password)) {
                    if($this->accountSettings->passwordUpdate($new_password)) {
                        $this->messenger->addMessage("Account password changes have been updated.");
                    }
                }
            }
        }
    }
}