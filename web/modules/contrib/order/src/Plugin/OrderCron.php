<?php

namespace Mini\Modules\contrib\order\src\Plugin;

use Mini\Cms\Connections\Smtp\MailManager;
use Mini\Cms\Connections\Smtp\Receiver;
use Mini\Cms\Entities\User;
use Mini\Cms\Modules\Cron\CronInterface;
use Mini\Cms\Modules\Modal\RecordCollection;
use Mini\Modules\contrib\order\src\Modal\OrderStatusEmailModal;

class OrderCron implements CronInterface
{

    /**
     * @inheritDoc
     */
    public function when(): int
    {
        return 20;
    }

    /**
     * @inheritDoc
     */
    public function cronId(): string
    {
        return "order_status_cron";
    }

    /**
     * @inheritDoc
     */
    public function execute(): void
    {
        $mail_order_modal = new OrderStatusEmailModal();
        $mails = $mail_order_modal->all()->getRecords();

        foreach ($mails as $mail) {
            if($mail instanceof RecordCollection) {
                $user = User::load($mail->mail_to);
                if(!empty($user->getEmail())) {
                    $receiver = new Receiver([
                        [
                            'name'=> $user->getFirstname() .' '.$user->getLastname(),
                            'mail'=> $user->getEmail(),
                        ]
                    ]);
                    $send = MailManager::mail($receiver)
                        ->send([
                            'subject' => $mail->mail_subject,
                            'body' => $mail->mail_body,
                        ]);
                    if($send) {
                        $mail_order_modal->delete($mail->order_mail_id);
                    }
                }
            }
        }
    }
}