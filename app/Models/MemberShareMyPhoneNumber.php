<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class MemberShareMyPhoneNumber extends Model
{
    use HasUuid;

    protected $table = 'member_share_my_phone_number_to_partner';

    protected $guarded = [];
    public function fromMemberProfile()
    {
        return $this->belongsTo(Member::class, 'from_member_id');
    }
    public function toMemberProfile() {
        return $this->belongsTo(Member::class, 'to_member_id');
    }
}
