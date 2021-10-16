<?php

namespace App\Console\Commands;

use App\Mail\SendMailToUserVerificationPending;
use App\Models\MemberRegistrationRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailForUserPendingEmailVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:user_verification_pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail to user whos are having email verification pending';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = now()->format('Y-m-d');
        $memberRegistrationPending = MemberRegistrationRequest::verificationPendingAccount()
        ->whereRaw("DATEDIFF('$today', created_at) > 1")
        ->get();
        foreach($memberRegistrationPending as $member) {
            $mailstatus =  Mail::send(new SendMailToUserVerificationPending($member));
        }
    }
}
