<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/03/17
 * Time: 13:48
 */

namespace Chatbox\Mail\Drivers;


//use Illuminate\Support\Facades\Validator;
use Psr\Log\LoggerInterface;

trait MailDriverTrait
{
    protected function validateEmail($email){
        return (preg_match('|@|', $email));
    }

    protected function getLogger():LoggerInterface{
        return app(LoggerInterface::class);
    }

}