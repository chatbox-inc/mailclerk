<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/03/09
 * Time: 1:44
 */

namespace Chatbox\MailClerk;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Mail\Mailer;

class MailClerk
{
    /** @var Mailer  */
    protected $mailer;

    protected $queue = null;

    /**
     * MailSender constructor.
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     */
    public function setQueue($useQueue)
    {
        $this->queue = $useQueue;
    }

    public function publish(Mailable $mailable){
        if($this->queue && $this->mailer instanceof Mailer){
            $delay = env("MAIL_DEFAULT_DELAY",0);
            return $this->mailer->laterOn($this->queue,$delay,$mailable);
        }else{
            $this->mailer->send($mailable);
        }
    }
}