<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/03/09
 * Time: 1:45
 */

namespace Chatbox\Mail;


interface MailDriverInterface
{
    public function send(MessageInterface $message);
}