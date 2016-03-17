<?php
namespace Chatbox\Mail\Drivers;
use Chatbox\Mail\MailDriverInterface;
use Chatbox\Mail\MessageInterface;


use Psr\Log\LoggerInterface;
/**
 * To activate, use composer require sendgrid/sendgrid
 */
class Sendgrid implements MailDriverInterface
{
    use MailDriverTrait;

    public function send(MessageInterface $message)
    {
        if(count($message->getToList()) === 0){
            // TODO FIXED EXCEPTION
            throw new \Exception();
        }
        foreach ($message->getToList() as $email) {
            if(!$this->validateEmail($email)){
                // TODO FIXED EXCEPTION
                throw new \Exception;
            }
        }

        $sendgrid = new \SendGrid(env("SENDGRID_USERNAME"), env("SENDGRID_PASSWORD"));

        $email = new \SendGrid\Email();
        $email
            ->addTo($message->getToList())
            ->setFrom($message->getFrom())
            ->setSubject($message->getSubject())
            ->setText($message->getTextBody())
            ->setHtml($message->getHtmlBody());

        if(is_array($message->getBccList())){
            $email->addBcc($message->getBccList());
        }

        $email->setAttachments($message->getAttachments());

        try{
            $sendgrid->send($email);
        }catch (\Exception $e){
            throw $e;
        }
    }
}