<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class MemberOccupation extends Model
{
    use HasUuid;

    protected $fillable = ['organisation', 'role', 'organisation_details', 'job_location'];


    public function getRoleAttribute()
    {
        return ucwords($this->attributes['role']);
    }

    public function employee_in()
    {
        return $this->belongsTo(EmployeeIn::class, 'employee_id', 'id');
    }
}
