<?php

namespace Mini\Modules\contrib\dashboard\src\Routes;

use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Services\Services;

class Customers implements ControllerInterface
{

    public function __construct(private Request &$request, private Response &$response)
    {
    }

    public function isAccessAllowed(): bool
    {
        return true;
    }

    public function writeBody(): void
    {
        $customer_plugin = new \Mini\Modules\contrib\customers\src\Plugin\Customers();
        $customers = $customer_plugin->getMyCustomers((new CurrentUser())->id());
        $this->response->write(Services::create('render')->render('customers.php',['customers'=>$customers]));
    }
}