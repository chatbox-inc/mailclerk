<?php
use Illuminate\Support\Str;

use Chatbox\MailClerk\Transport\ArrayTransport;
/**
 * ログイン・ログアウトからのシナリオ
 */
class ArrayTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        putenv("MAIL_DRIVER=array");
        $this->app->register(\Chatbox\MailClerk\MailClerkServiceProvider::class);
    }

    public function testMail(){
        $this->assertEquals([],ArrayTransport::$mailbox);
        /** @var \Chatbox\MailClerk\MailClerk $mail */
        $mail = app(Chatbox\MailClerk\MailClerk::class);
        $result = $mail->publish(new \App\TestMail());
        $this->assertEquals(1,count(ArrayTransport::$mailbox));
    }


}