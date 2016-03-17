<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/03/17
 * Time: 12:47
 */

namespace Chatbox\Mail\Supports;

use Chatbox\Mail\MailSender;

trait SendableTrait
{

    public function send(){
        /** @var MailSender $sender */
        $sender = app(MailSender::class);
        return $sender->send($this);
    }
}