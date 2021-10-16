<?php

namespace App\Jobs;

use App\Mail\SendNotiticationToUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotificationToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $notificationType;
    protected $profiles;
    protected $user;
    protected $tries = 3;

    public function __construct($notificationType, $profiles, $user)
    {
        $this->notificationType = $notificationType;
        $this->profiles = $profiles;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->user->email == null) {
                info("User mail is not have");
                return true;
        }
        if($this->notificationType == 'profile_request_send') {
            return Mail::send(new SendNotiticationToUser ($this->user, $this->profiles, $this->notificationType));
        } elseif ($this->notificationType == 'profile_request_accept') {
            return Mail::send(new SendNotiticationToUser($this->user, $this->profiles, $this->notificationType));
        } elseif ($this->notificationType == 'photo_request_send') {
            return Mail::send(new SendNotiticationToUser($this->user, $this->profiles, $this->notificationType));
        } elseif ($this->notificationType == 'photo_request_accept') {
            return Mail::send(new SendNotiticationToUser($this->user, $this->profiles, $this->notificationType));
        } elseif ($this->notificationType == 'phone_number_request_received') {
            return Mail::send(new SendNotiticationToUser($this->user, $this->profiles, $this->notificationType));
        } elseif ($this->notificationType == 'phone_number_request_accepted') {
            return Mail::send(new SendNotiticationToUser($this->user, $this->profiles, $this->notificationType));
        }

        return null;
    }
}
