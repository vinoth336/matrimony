<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zodiac extends Model
{
    public function getNameAttribute($value)
    {
        return __('rasi.' . $value);
    }
}
