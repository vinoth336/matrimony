<?php

namespace App\Jobs;

use App\Models\MemberRegistrationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailForUserPendingEmailVerification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = now();
        $memberRegistrationPending = MemberRegistrationRequest::whereRaw("DATEDIFF(created_at, '$today') > 1")->get();
        foreach($memberRegistrationPending as $member) {
             dd($member);
        }

    }
}
