<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        'date',
        'dayName',
        'mount',
        'advanceSum',
        'salaryMount',
        'DayAttendance',
        'startDate',
        'endDate',
        'user_id',
        'salary_cycle_id',
    ];
}
