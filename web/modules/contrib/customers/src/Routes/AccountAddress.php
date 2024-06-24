<?php

namespace Mini\Modules\contrib\customers\src\Routes;

use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Field;
use Mini\Cms\Fields\AddressField;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Modules\Messenger\Messenger;
use Mini\Cms\Modules\Modal\MissingDefaultValueForUnNullableColumn;
use Mini\Cms\Modules\Respositories\Territory\AddressFormat;
use Mini\Cms\Modules\Respositories\Territory\Countries;
use Mini\Cms\Modules\Respositories\Territory\States;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\customers\src\Modal\Address;
use Mini\Modules\contrib\customers\src\Plugin\AccountSettings;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AccountAddress implements ControllerInterface
{

    private AccountSettings $accountSetting;


    /**
     * @throws \Exception
     */
    public function __construct(private Request &$request, private Response &$response)
    {
        $this->accountSetting = new AccountSettings((new CurrentUser())->id());
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
        $states = new States();
        $states = $states->getStates('IN');
        $countries = new Countries();
        $countries = $countries->getCountries();
        $addressField = new AddressField();
        $addressField->setLabel('Your address');
        $addressField->setName('customer_address');
        $addressField->setDefaultValue('IN');
        $addressField->setEntityID(0);
        $markup = Field::markUp($addressField->getType());
        $address_field = $markup->buildMarkup($addressField,['value'=>'IN']);

        //POST handling
        $this->addressUpdateCreation();

        $address = new Address();
        $add = $address->get((new CurrentUser())->id(), 'address_owner');
        $this->response->write(Services::create('render')->render('account_address.php',[
            'countries' => $countries,
            'states' => $states,
            'address_field' => $address_field,
            'current_user' => new CurrentUser(),
            'address' => $add->getRecords(),
            'modal'=> $address
        ]));
    }

    /**
     * @throws MissingDefaultValueForUnNullableColumn
     */
    private function addressUpdateCreation(): void
    {
        if($this->request->isMethod('POST') && $this->request->request->has('address'))
        {
            $data = $this->request->request->all();
            $address_field = AddressFormat::filterAddressValues($data, 'field_customer_address');
            $fields = AddressFormat::fieldNames();
            $stable = [];
            foreach ($address_field as $key=>$item) {
                if(isset($fields[$key])) {
                   $stable[$fields[$key]['storage_field_name']] = $item;
                }
            }
            if($this->accountSetting->addressUpdateCreation($data, $stable)) {
                (new Messenger())->addSuccessMessage("Address settings saved");
                (new RedirectResponse('/user/account/address'))->send();
                exit;
            }
        }
    }
}