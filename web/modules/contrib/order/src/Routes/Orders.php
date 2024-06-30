<?php

namespace Mini\Modules\contrib\order\src\Routes;

use Mini\Cms\Configurations\ConfigFactory;
use Mini\Cms\Controller\ContentType;
use Mini\Cms\Controller\ControllerInterface;
use Mini\Cms\Controller\Request;
use Mini\Cms\Controller\Response;
use Mini\Cms\Controller\StatusCode;
use Mini\Cms\Modules\CurrentUser\CurrentUser;
use Mini\Cms\Modules\Messenger\Messenger;
use Mini\Cms\Services\Services;
use Mini\Modules\contrib\order\src\Modal\OrderModal;
use Mini\Modules\contrib\order\src\Plugin\OrderHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Orders implements ControllerInterface
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
        $order_plugin = new OrderHandler();

        if($this->request->isMethod('POST') && $this->request->request->has('order_note')) {

            if($order_plugin->addOrderNote($this->request->get('common_id'), $this->request->request->get('order_note_value')))
            {
                (new Messenger())->addMessage("Order note added");
                (new RedirectResponse('/shop/orders/'.$this->request->get('common_id')))->send();
                exit;
            }
        }

        if($this->request->query->has('common_id')) {
            $order = $order_plugin->getOrder($this->request->get('common_id'));
            $this->response->write(Services::create('render')->render('dashboard_order.php',$order));
            return;
        }
        if($this->request->headers->get('Content-Type') === 'application/json') {
            $orders = json_decode($this->request->getContent(), true) ?? [];
            if(!empty($orders['actions'])) {
                if($order_plugin->updateOrderStatus($orders['actions'])){
                    $this->response->setStatusCode(StatusCode::OK)
                        ->setContentType(ContentType::APPLICATION_JSON)
                        ->write(['status' => true]);
                }
                else {
                    $this->response->setStatusCode(StatusCode::NOT_FOUND)
                        ->setContentType(ContentType::APPLICATION_JSON)
                        ->write(['status' => false]);
                }
            }
            return;
        }
        $order_list = $order_plugin->getOrders((new CurrentUser())->id());
        $this->response->write(Services::create('render')->render('dashboard_orders.php',['orders'=>$order_list]));
    }
}