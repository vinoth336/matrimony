<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    protected $fillable = ['name', 'position'];

    public function getNameAttribute($value)
    {
        return __('star.' . $value);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->position) {
                $model->position = Star::count() + 1;
            }
        });
    }
}
