<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory;
    
    protected $table = 'employee'; 
    
    protected $fillable = [
        'id', 'firstname', 'lastname', 'staffid', 'designation_id', 'email', 'phone', 
        'joiningdate', 'city', 'pincode', 'address', 'password', 'state', 'image', 
        'aadhar', 'pancard', 'aadhardoc', 'pandoc', 'bank', 'bankacc', 'ifsc', 
        'bankdoc', 'checkbook', 'created_at', 'updated_at', 'status' , 'check_status'
    ];

    // Add the hidden property to hide sensitive fields
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Optionally, you can add casts for specific fields
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
