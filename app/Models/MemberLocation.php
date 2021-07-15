<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class MemberLocation extends Model
{
    use HasUuid;

    protected $fillable = ['address', 'city_id', 'state_id', 'pincode', 'landmark'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
}
