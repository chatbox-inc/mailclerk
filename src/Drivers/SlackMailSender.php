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


        ";

        $data = [
            "token" => $slackApiKey,
            "text" => $text,
            "channel" => $channel,
        ];
        $data["icon_emoji"] = ":mailbox_with_mail:";
        $data["username"] = "Debug Mail";
        $data["text"] = "SLACK DEBUG MAILER";
        $data["attachments"] = json_encode([
            [
                "color"=> "#36a64f",
                "pretext"=> "MESSAGE DERIVERED AT $time",
                "title"=> "[TO] {$email}      [FROM] {$message->getFrom()}",
                "title_link"=> "",
                "text"=> "
SUBJECT: {$message->getSubject()}
TEXT: {$message->getTextBody()}
                "
            ]
        ]);

        $url = "https://slack.com/api/chat.postMessage?".http_build_query($data);
        $res = file_get_contents($url);
    }
}