<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasDefaultSorting {

    public static function bootHasDefaultSorting()
    {
         // Order by name ASC
         static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }

}
