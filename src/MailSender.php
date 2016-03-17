<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/03/09
 * Time: 1:44
 */

namespace Chatbox\Mail;


class MailSender
{
    /** @var MailDriverInterface[] */
    protected $drivers = [];

    public function push(MailDriverInterface $driver){
        array_push($this->drivers,$driver);
    }

    public function send(MessageInterface $message)
    {
        error_log("send message");
        foreach ($this->drivers as $driver) {
            error_log("send message");
            $driver->send($message);
        }
    }

}