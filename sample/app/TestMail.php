<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/09/30
 * Time: 18:14
 */

namespace App;


use GuzzleHttp\Client;
use Illuminate\Mail\Mailable;

class TestMail extends Mailable
{

    public function build(){
        $this->to(env("TEST_MAIL_TO"));
        $this->from(env("TEST_MAIL_FROM"));
        $this->view("sample_mail");
        $this->subject("メールテスト送信メール");

        $client = new Client();
        $res = $client->get("http://connpass.com/api/v1/event/");
        $eventData = json_decode($res->getBody()->getContents(),true);
        $this->with("events",array_get($eventData,"events"),"[]");
    }

}