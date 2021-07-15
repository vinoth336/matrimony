<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jamesh\Uuid\HasUuid;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MemberRegistrationRequest extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, HasUuid, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'dob',
        'religion',
        'mother_tongue_id',
        'password',
        'blood_id',
        'gender',
        'phone_no',
    ];

    protected $dates = [
        'dob'
    ];
}
