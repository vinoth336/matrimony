<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRegistrationEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Verify Your Email Address';

    public $member;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($member)
    {
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->member->email)
        ->view('mail.email_verify')
        ->with('hash', encrypt($this->member->id));
    }
}
