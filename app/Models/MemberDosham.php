<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberDosham extends Model
{
    protected $guarded = [];

    protected $table = 'member_dhosams';

    public function member() {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function dosham() {
        return $this->belongsTo(Dosham::class, 'dosham_id', 'id');
    }
}
