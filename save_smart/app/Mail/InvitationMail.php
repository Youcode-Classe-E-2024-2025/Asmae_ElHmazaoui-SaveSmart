<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitationLink;

    /**
     * Create a new message instance.
     */
    public function __construct($invitationLink)
    {
        $this->invitationLink = $invitationLink;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Invitation à rejoindre SaveSmart')
                    ->view('emails.invitation');
    }
}
