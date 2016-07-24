<?php
namespace Chatbox\MailClerk;

use Chatbox\MailClerk\Transport\SlackTransport;
use Chatbox\MailClerk\Transport\SendGridTransport;
use Chatbox\MailClerk\Transport\ArrayTransport;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\ServiceProvider;
use Chatbox\MailClerk\MailClerk;

class MailClerkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->configure("mail");
        $this->app->register(MailServiceProvider::class);
        $this->app->singleton(MailClerk::class,function(){
            return new MailClerk(app("mailer"));
        });

        $this->app->extend("swift.transport",function(TransportManager $manager){
            $manager->extend("slack",function(){
                $token = env("SLACKMAIL_APIKEY");
                $channel = env("SLACKMAIL_CHANNEL");
                return new SlackTransport($token,$channel);
            });
            $manager->extend("sendgrid",function(){
                $sendgrid = new \SendGrid(env("SENDGRID_APIKEY"));
                return new SendGridTransport($sendgrid);
            });
            $manager->extend("array",function(){

                return new ArrayTransport();

            });
            return $manager;
        });
    }
}