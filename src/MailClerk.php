<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/03/09
 * Time: 1:44
 */

namespace Chatbox\MailClerk;

use Illuminate\Mail\Mailer;
use Illuminate\Contracts\Mail\Mailer as MailerContract;

class MailClerk
{
    protected $mailer;

    protected $queue = null;

    /**
     * MailSender constructor.
     */
    public function __construct(MailerContract $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     */
    public function setQueue($useQueue)
    {
        $this->queue = $useQueue;
    }

    public function publish($view,$data,$cb){
        if($this->queue && $this->mailer instanceof Mailer){
            return $this->mailer->queue($view,$data,$cb,$this->queue);
        }else{
            $this->mailer->send($view,$data,$cb);
        }
    }
}