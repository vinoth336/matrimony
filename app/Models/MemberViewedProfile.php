<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberViewedProfile extends Model
{

    protected $fillable = ['profile_member_id'];

    public function scopeAuthUser()
    {
        return $this->where('member_id', auth()->user()->id);
    }

    public function member_profile()
    {
        return $this->belongsTo(Member::class, 'profile_member_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

}

