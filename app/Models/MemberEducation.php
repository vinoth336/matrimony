<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class MemberEducation extends Model
{
    use HasUuid;

    protected $fillable = ['degree_id', 'course', 'institute', 'passed_out'];

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'degree_id', 'id');
    }
}
