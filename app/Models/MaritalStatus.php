<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;
use Illuminate\Support\Str;

class MaritalStatus extends Model
{
    protected $fillable = ['name', 'slug', 'order'];

    protected $table = 'marital_status';

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->sequence) {
                $model->sequence = MaritalStatus::count() + 1;
            }
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
