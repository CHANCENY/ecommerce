<?php

namespace Mini\Modules\contrib\customers\src\Routes;

use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Field;
use Mini\Cms\Fields\AddressField;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Modules\Respositories\Territory\AddressFormat;
use Mini\Cms\Modules\Respositories\Territory\Countries;
use Mini\Cms\Modules\Respositories\Territory\States;
use Mini\Cms\Services\Services;

class AccountAddress implements ControllerInterface
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
        $states = new States();
        $states = $states->getStates('IN');
        $countries = new Countries();
        $countries = $countries->getCountries();
        $addreesField = new AddressField();
        $addreesField->setLabel('Your address');
        $addreesField->setName('customer_address');
        $addreesField->setDefaultValue('IN');
        $addreesField->setEntityID(0);
        $markup = Field::markUp($addreesField->getType());
        $address_field = $markup->buildMarkup($addreesField,['value'=>'IN']);
        $this->response->write(Services::create('render')->render('account_address.php',[
            'countries' => $countries,
            'states' => $states,
            'address_field' => $address_field,
            'current_user' => new CurrentUser(),
        ]));
    }
}