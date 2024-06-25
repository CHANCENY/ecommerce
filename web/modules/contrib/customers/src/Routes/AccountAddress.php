<?php

namespace Mini\Modules\contrib\customers\src\Routes;

use Exception;
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
use Mini\Cms\Modules\Respositories\Territory\Country;
use Mini\Cms\Modules\Respositories\Territory\State;
use Mini\Cms\Modules\Respositories\Territory\States;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\customers\src\Modal\Address;
use Mini\Modules\contrib\customers\src\Plugin\AccountSettings;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AccountAddress implements ControllerInterface
{

    private AccountSettings $accountSetting;


    /**
     * @throws Exception
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

        if($this->request->query->has('address_view_id')) {
            $this->viewAddress();
            return;
        }
        elseif ($this->request->query->has('address_delete_id')) {
            $this->deleteAddress();
            (new RedirectResponse('/user/account/address'))->send();
            exit;
        }
        elseif ($this->request->query->has('address_default_id')) {

            $this->setDefaultAddress();
            (new RedirectResponse('/user/account/address'))->send();
            exit;
        }

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

    /**
     * View an address route handler
     * @return void
     * @throws Exception
     */
    private function viewAddress(): void
    {
        $address_id = $this->request->query->get('address_view_id');
        $modal = new Address();

        $address = $modal->get($address_id)->getAt(0);
        $address_field_id = $address->address_field_id ?? null;
        $field = null;
        $field_data = [];
        if($address_field_id) {
            $field_data = $modal->address($address_field_id);
            $addressField = new AddressField();
            $addressField->setLabel('Address field');
            $addressField->setName('address_field');
            $addressField->setDisplayFormat([
                'label' => 'Full detailed address',
                'name' => 'full_address',
            ]);
            $field = $addressField->markUp([['value'=>$field_data]]);
        }
        $this->response->write(Services::create('render')->render('account_address_view.php',[
            'address' => $address,
            'address_field' => $field,
            'country' => new Country($field_data['country_code']),
            'state' => new State($field_data['country_code'], $field_data['state_code']),
            'more' => $field_data,
        ]));
    }

    /**
     * Delete address.
     * @return void
     */
    private function deleteAddress(): void
    {
        $address_id = $this->request->query->get('address_delete_id');
        if($address_id) {
            $modal = new Address();
            $modal->delete($address_id);
        }
    }

    private function setDefaultAddress(): void
    {
        $address_id = $this->request->query->get('address_default_id');
        if($address_id) {
            $modal = new Address();
            $address = $modal->get($address_id)->getAt(0);
            $address_owner = $address->address_owner ?? null;
            if($address_owner) {
                $modal->unDefaultAddress((int) $address_owner);
                $modal = new Address();
                $modal->update(['is_default' => 1],$address_id);
            }
        }
    }

}