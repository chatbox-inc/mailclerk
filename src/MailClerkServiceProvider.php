<?php
namespace Chatbox\MailClerk;

use Chatbox\MailClerk\Transport\ArrayTransport;
use Illuminate\Contracts\Foundation\Application;
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

                return new ArrayTransport();

            });
            $manager->extend("sendgrid",function(){
                return new ArrayTransport();

            });
            $manager->extend("array",function(){

                return new ArrayTransport();

            });
            return $manager;
        });


    }


}