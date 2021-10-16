<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class MemberProfilePhotoRequest extends Model
{
    use HasUuid;

    protected $fillable = ['profile_member_id', 'member_id', 'request_status'];

    public function member_profile()
    {
        return $this->belongsTo(Member::class, 'profile_member_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
