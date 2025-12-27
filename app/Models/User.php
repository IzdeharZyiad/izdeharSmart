<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    
    protected $fillable = [
        'name',
        'idNumber',
        'phoneNumber',
        'joinDate',
        'salary_type',
        'salary_amount',
        'department',
        'balance',

    ];

   
    
}
