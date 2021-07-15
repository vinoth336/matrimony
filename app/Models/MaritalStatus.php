<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class MaritalStatus extends Model
{
    use HasUuid;

    protected $table = 'marital_status';
}
