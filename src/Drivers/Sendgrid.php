<?php
namespace Chatbox\Mail\Drivers;
use Chatbox\Mail\MailDriverInterface;
use Chatbox\Mail\MessageInterface;

/**
 * To activate, use composer require sendgrid/sendgrid
 */
class Sendgrid implements MailDriverInterface
{



    public function send(MessageInterface $message)
    {
        if(count($message->getToList()) === 0){
            return null;
        }

        if (!preg_match('|@|', $envelope->getTo())) {
            return null;
        }

        $sendgrid = new \SendGrid(env("SENDGRID_USERNAME"), env("SENDGRID_PASSWORD"));

        $email = new \SendGrid\Email();
        $email
            ->addTo($envelope->getTo())
            ->setFrom($envelope->getFrom())
            ->setSubject($envelope->getSubject())
            ->setText($envelope->getTextBody())
            ->setHtml($envelope->getHtmlBody());

        if(is_array($envelope->getBcc())){
            $email->addBcc($envelope->getBcc());
        }

        $email->setAttachments($envelope->getAttatchment());

        try{
            $sendgrid->send($email);
        }catch (\Exception $e){
            app(LoggerInterface::class)->error("cant send email ".serialize($envelope));
        }
    }
}