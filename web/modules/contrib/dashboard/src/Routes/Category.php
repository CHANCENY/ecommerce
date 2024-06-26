<?php

namespace Mini\Modules\contrib\dashboard\src\Routes;

use Mini\Cms\Controller\ContentType;
use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\sellers\src\Modals\Vendor;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Category implements ControllerInterface
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
        $category_modal = new \Mini\Modules\contrib\dashboard\src\Modal\Category();
        if($this->request->query->has('category_new')) {

            $vendor_modal = new Vendor();
            $vendors = $vendor_modal->get((new CurrentUser())->id(), 'vendor_owner')->getRecords();
            $this->newCategory();
            $this->response->write(Services::create('render')->render('new_category.php',['vendors' => $vendors]));
            return;
        }
        if($this->request->isMethod('POST') && $this->request->headers->get('Content-Type') === 'application/json') {
            $data = json_decode($this->request->getContent(),true);
            if(!empty($data)) {
                $flags = [];
                foreach($data as $name => $value) {
                    if($category_modal->update(['category_status' => $value['status']], $value['cate_id'])) {
                        $flags[] = true;
                    }
                }
                $this->response->write(['status' => in_array(true, $flags), 'd'=>$data]);
            }
            else {
                $this->response->write(['status' => FALSE]);
            }
            $this->response->setContentType(ContentType::APPLICATION_JSON);
            return;
        }
        $categories = $category_modal->all()->getRecords();
        $this->response->write(Services::create('render')->render('categories.php',['categories' => $categories]));
    }

    private function newCategory(): void
    {
        if($this->request->request->has('new_category')) {
            $category_modal = new \Mini\Modules\contrib\dashboard\src\Modal\Category();
            if($category_modal->store($this->request->request->all())) {
                (new RedirectResponse('/shop/categories'))->send();
                exit;
            }
        }
    }
}