<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailToUserVerificationPending extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Account Verification Pending';

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
        $to = $this->member->email;
        $to = 'vinoth336@gmail.com';
        return $this->to($to)
        ->view('mail.email_verification_pending')
        ->with('hash', encrypt($this->member->id));
    }
}
