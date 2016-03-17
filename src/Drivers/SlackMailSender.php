<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/06/15
 * Time: 16:23
 */

namespace Chatbox\Mail\Drivers;


use Chatbox\Mail\MailDriverInterface;
use Chatbox\Mail\MessageInterface;

class SlackMailSender implements MailDriverInterface
{
    use MailDriverTrait;

    public function send(MessageInterface $envelope)
    {
        foreach ($envelope->getToList() as $email) {
            $this->_send($email,$envelope);
        }
    }

    protected function _send($email,MessageInterface $message)
    {
        $slackApiKey = env("SLACK_APIKEY"); //上で作成したAPIキー
        $channel = env("SLACK_CHANNEL");
        $time = date("Y-m-d H:i:s");

        $text = "
MESSAGE DERIVERED AT $time
[TO] {$email}      [FROM] {$message->getFrom()}
SUBJECT: {$message->getSubject()}
TEXT: {$message->getTextBody()}
        ";

        $data = [
            "token" => $slackApiKey,
            "text" => $text,
            "channel" => $channel,
        ];
        $url = "https://slack.com/api/chat.postMessage?".http_build_query($data);
        $res = file_get_contents($url);
        $this->getLogger()->debug("slack $slackApiKey");
        $this->getLogger()->debug("slack $channel");
        $this->getLogger()->debug("slack $res");
    }
}