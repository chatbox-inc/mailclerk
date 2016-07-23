<?php
namespace Chatbox\Clerk\Transport;

use Illuminate\Mail\Transport\Transport;

class SlackTransport extends Transport
{
    /**
     * The Amazon SES instance.
     *
     * @var \Aws\Ses\SesClient
     */
    protected $ses;

    /**
     * Create a new SES transport instance.
     *
     * @param  \Aws\Ses\SesClient  $ses
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_Message $message, &$failedRecipients = null)
    {


        $this->beforeSendPerformed($message);

        return $this->ses->sendRawEmail([
            'Source' => key($message->getSender() ?: $message->getFrom()),
            'RawMessage' => [
                'Data' => $message->toString(),
            ],
        ]);
    }
}
