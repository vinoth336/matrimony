<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zodiac extends Model
{
    protected $fillable = ['name', 'order'];

    public function getNameAttribute($value)
    {
        return __('rasi.' . $value);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->order) {
                $model->order = Zodiac::count() + 1;
            }
        });
    }
}
