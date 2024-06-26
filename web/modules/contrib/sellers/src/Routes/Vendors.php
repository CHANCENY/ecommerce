<?php

namespace Mini\Modules\contrib\sellers\src\Routes;

use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;

class Vendors implements ControllerInterface
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
        $vendor_modal = new Vendor();
        $vendors = $vendor_modal->get((new CurrentUser())->id(), 'vendor_owner');
        $this->response->write(Services::create('render')->render('vendor_grid.php',['vendors' => $vendors->getRecords()]));
    }
}