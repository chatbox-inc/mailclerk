<?php
namespace Chatbox\MailClerk\Transport;

use GuzzleHttp\Client;
use Illuminate\Mail\Transport\Transport;
use Psr\Http\Message\ResponseInterface;
use Swift_Mime_Message;

class SlackTransport extends Transport
{
    protected $token;
    protected $channel;

    /**
     * SlackTransport constructor.
     * @param $token
     * @param $channel
     */
    public function __construct($token, $channel)
    {
        $this->token = $token;
        $this->channel = $channel;
    }


    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $client = new Client();
        $url = "https://slack.com/api/chat.postMessage";

        foreach ($message->getFrom() as $fromAddress => $fromName) {}
        foreach ($message->getTo() as $toAddress => $toName) {}

        $attachment = [
            "title" => $message->getSubject(),
            "text" => $message->getBody(),
            "color" => "#fe4621",
            "pretext" => "
            FROM: {$fromName} {$fromAddress}
            TO: {$toName} {$toAddress}
            ",

        ];
        $slackMessage = [
            "token" => $this->token,
            "channel" => $this->channel,
            "username" => "slackmailer",
            "icon_emoji" => ":mailbox:",
            "text" => "mail published",
            "attachments" => json_encode([$attachment])
        ];

        $res = $client->get($url,[
            "query" => $slackMessage
        ]);

        if($res instanceof ResponseInterface){
            $rawBody = $res->getBody()->getContents();
            $body = json_decode($rawBody,true);
            if(is_array($body) && array_get($body,"ok") === true){
                return true;
            }elseif(array_get($body,"error")){
                $error = array_get($body,"error");
            }
        }
        throw new \Exception($error);

        return $res;
    }
}

