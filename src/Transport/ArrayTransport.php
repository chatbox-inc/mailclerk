<?php
namespace Chatbox\MailClerk\Transport;

use Illuminate\Mail\Transport\Transport;
use Swift_Mime_Message;

class ArrayTransport extends Transport
{
    static public $mailbox = [];

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {
        static::$mailbox[] = $message;
    }
}
