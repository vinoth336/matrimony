<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'state_id'];

    protected $table = 'cities';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->state_id) {
                $model->state_id = 1;
            }
        });
    }
}
