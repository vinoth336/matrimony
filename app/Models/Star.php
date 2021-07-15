<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    //

    public function getNameAttribute($value)
    {
        return __('star.' . $value);
    }
}
