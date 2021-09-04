<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Dhosam extends Model
{
    protected $fillable = ['name', 'sequence'];
    protected $table = 'dhosams';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sequence) {
                $model->sequence = Dhosam::count() + 1;
            }
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }

        });
    }
}
