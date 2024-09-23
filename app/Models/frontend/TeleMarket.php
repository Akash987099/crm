<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TeleMarket extends Model
{
    use HasFactory;
    protected $table = "tele_person";

    protected $fillable = [
        'id', 'user_id', 'user_type', 'user_type', 'firstname', 'lastname', 'email', 
        'phone', 'joining_date', 'address', 'city', 'pincode', 'state', 'document_file', 
        'status', 'staff_id', 'staff_role', 'password', 'archive', 'created_date', 'created_time', 
        'ip_address', 'created_at', 'updated_at'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    // Optionally, you can add casts for specific fields
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
