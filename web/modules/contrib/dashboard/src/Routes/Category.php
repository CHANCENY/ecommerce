<?php

namespace Mini\Modules\contrib\dashboard\src\Routes;

use Mini\Cms\Controller\ContentType;
use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Services\Services;
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
        if($this->request->isMethod('POST')) {
            $data = json_decode($this->request->getContent(),true);
            if(!empty($data)) {
                foreach($data as $name => $value) {
                    $category_modal->update(['category_status' => $value['status']], $value['cate_id']);
                }
                $this->response->write(['status' => TRUE]);
            }
            else {
                $this->response->write(['status' => FALSE]);
            }
            $this->response->setContentType(ContentType::APPLICATION_JSON);
            return;
        }
        if($this->request->query->has('category_new')) {

            $this->newCategory();
            $this->response->write(Services::create('render')->render('new_category.php'));
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