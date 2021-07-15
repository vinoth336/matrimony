<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeIn extends Model
{

    public static function getData()
    {
        DB::table('employee_in')->select('id', 'name')->get();
    }
}
