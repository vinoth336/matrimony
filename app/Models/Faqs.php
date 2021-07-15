<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Faqs extends Model
{

    use SoftDeletes;


    protected $table = 'faqs';

    protected $fillable = ['question', 'answer', 'sequence'];

    public $timestamps = true;

    public static function boot()
    {

        parent::boot();
        static::creating(function($model)
        {

        });
    }

}
