<?php
namespace Chatbox\MailClerk\Transport;

use Illuminate\Mail\Transport\Transport;

use SendGrid\Content;
use SendGrid\Mail;
use SendGrid\Personalization;
use SendGrid\Response;
use Swift_Mime_Message;

class SendGridTransport extends Transport
{
    protected $sendgrid;

    public function __construct(\SendGrid $sendGrid)
    {
        $this->sendgrid = $sendGrid;
    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $mail = new Mail();
        $from = $message->getFrom();
        $subject = $message->getSubject();
        $content = new Content("text/html",$message->getBody());
        foreach ($from as $fromAddress => $name) {
            $mail->setFrom([
                "name" => $name,
                "email" => $fromAddress
            ]);
        }
        $mail->setSubject($subject);
        $mail->addContent($content);

        $to = $message->getTo();
        $person = new Personalization();
        foreach ($to as $toAddress => $name) {
            $person->addTo([
                "name" => $name,
                "email" => $toAddress
            ]);
        }
        $mail->addPersonalization($person);


        /** @var Response $result */
        $result = $this->sendgrid->client->mail()->send()->post($mail);
        if(
            $result instanceof Response &&
            $result->statusCode() >= 200 &&
            $result->statusCode() < 300
        ){
            return $result;
        }else{
            throw new SendGridTransportException($result);
        }
    }
}

class SendGridTransportException extends \Exception
{
    protected $response;

    /**
     * SendGridTransportException constructor.
     * @param $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
        parent::__construct("fail to send mail");
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}