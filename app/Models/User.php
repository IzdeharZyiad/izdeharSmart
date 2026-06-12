<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'idNumber',
        'phoneNumber',
        'joinDate',
        'salary_type',
        'salary_amount',
        'admin_id',
    ];

    public function salaryCycles()
    {
        return $this->hasMany(SalaryCycle::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function advance()
    {
        return $this->hasMany(Advance::class);
    }
}
