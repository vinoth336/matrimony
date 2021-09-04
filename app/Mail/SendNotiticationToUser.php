<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNotiticationToUser extends Mailable
{
    use Queueable, SerializesModels;
    protected $notificationType;
    protected $profiles;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $profiles, $notificationType)
    {
        $this->notificationType = $notificationType;
        $this->profiles = $profiles instanceof \Illuminate\Database\Eloquent\Collection ? $profiles : [$profiles];

        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->notificationType == 'profile_request_send') {
            info('am inside');
            return $this->to($this->user->email)
            ->view('mail.profile_interest_request_received')
            ->with([
                'user' => $this->user,
                'profiles' => $this->profiles
            ]);
        } elseif ($this->notificationType == 'profile_request_accept') {
            return $this->to($this->user->email)
            ->view('mail.profile_interest_request_accepted')
            ->with([
                'user' => $this->user,
                'profiles' => $this->profiles
            ]);
        } elseif ($this->notificationType == 'photo_request_send') {
            return $this->to($this->user->email)
            ->view('mail.phone_number_request_received')
            ->with([
                'user' => $this->user,
                'profiles' => $this->profiles
            ]);
        } elseif ($this->notificationType == 'photo_request_accept') {
            return $this->to($this->user->email)
            ->view("mail.phone_number_request_accepted")
            ->with([
                'user' => $this->user,
                'profiles' => $this->profiles
            ]);
        } elseif ($this->notificationType == 'phone_number_request_send') {
            return $this->to($this->user->email)
            ->view('mail.phone_number_request_received')
            ->with([
                'user' => $this->user,
                'profiles' => $this->profiles
            ]);
        } elseif ($this->notificationType == 'phone_number_request_accept') {
            return $this->to($this->user->email)
            ->view('mail.phone_number_request_accepted')
            ->with([
                'user' => $this->user,
                'profiles' => $this->profiles
            ]);
        }
    }
}
