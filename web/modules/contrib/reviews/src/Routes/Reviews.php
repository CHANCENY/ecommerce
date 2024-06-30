<?php

namespace Mini\Modules\contrib\reviews\src\Routes;

use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Services\Services;

class Reviews implements ControllerInterface
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
        $review_plugin = new \Mini\Modules\contrib\reviews\src\Plugin\Reviews();
        if($this->request->query->has('review_id')) {
            $reviews = $review_plugin->getReview($this->request->get('review_id'));
            $this->response->write(Services::create('render')->render('review_single.php',['review'=>$reviews]));
            return;
        }
        $reviews = $review_plugin->getReviews((new CurrentUser())->id());
        $this->response->write(Services::create('render')->render('reviews.php',['reviews' => $reviews]));
    }
}