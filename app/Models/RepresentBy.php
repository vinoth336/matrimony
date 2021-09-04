<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Jamesh\Uuid\HasUuid;

class RepresentBy extends Model
{
    use HasUuid;
    protected $fillable = ['id', 'name', 'slug'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

}
