<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class EmailMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $email_id;
    public $email;
    public $messageContent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_id, $email, $messageContent)
    {
        $this->email_id = $email_id;
        $this->email = $email;
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from(Auth::user()->email)->view('emails.message');

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader(
                'X-Mailgun-Variables',
                '{"email_id": "' .  $this->email_id . '" }'
            );
        });

        return $this;
    }
}
