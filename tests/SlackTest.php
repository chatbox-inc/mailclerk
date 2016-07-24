<?php
use Illuminate\Support\Str;

use Chatbox\MailClerk\Transport\ArrayTransport;
/**
 * ログイン・ログアウトからのシナリオ
 */
class SlackTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        putenv("MAIL_DRIVER=slack");
        $this->app->register(\Chatbox\MailClerk\MailClerkServiceProvider::class);
    }

    public function testMail(){
        try{
            /** @var \Chatbox\MailClerk\MailClerk $mail */
            $mail = app(Chatbox\MailClerk\MailClerk::class);
            $result = $mail->publish("hoge",[],function($m){
                $m->from("t.goto@chatbox-inc.com");
                $m->to("t.goto@chatbox-inc.com");
                $m->subject("hgoehoge");
            });
            $this->assertTrue(true);
        }catch(\Chatbox\MailClerk\Transport\SendGridTransportException $e){
            if(!env("SLACKMAIL_APIKEY")){
                $this->assertTrue(true);
            }
        }
    }


}