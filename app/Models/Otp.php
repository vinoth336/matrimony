<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Otp extends Model
{
    protected $fillable=['phone_number','otp','expires_at'];

    /**
     * Send OTP SMS
     */
    public static function sendSMS($toNumber,$otp) {
        try {
            Log::debug($toNumber);
            $response=Http::withHeaders([
                'Content-Type'=>'application/json',
                'authorization'=>env('SMS_KEY')
            ])->post(
                env('SMS_URL'),
                [
                    'route'=>'otp',
                    'variables_values'=>$otp,
                    'numbers'=>$toNumber
                ]
            );
            Log::debug($response);
        } catch (\Throwable $th) {
            throw $th;
            Log::debug($th);
        }
    }
}
