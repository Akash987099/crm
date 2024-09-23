<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tele extends Authenticatable
{
    use HasFactory;
    
    protected $table = "tele_person";

    protected $fillable = [
        'id', 'user_id', 'user_type', 'user_type', 'firstname', 'lastname', 'email', 
        'phone', 'joining_date', 'password', 'address', 'city', 'pincode', 'state', 'document_file', 
        'status', 'staff_id', 'staff_role', 'password', 'archive', 'created_date', 'created_time', 
        'ip_address', 'created_at', 'updated_at'
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
