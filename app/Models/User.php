<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users'; 
    protected $fillable = ['id', 'type', 'staff_id' , 'role_type' , 'company_id' , 'name' , 'email' , 'password', 'profile_pic' , 'desiganation' , 'address' , 'city' , 'pincode' , 'state' , 'country' , 'phone' , 'joining_date' , 'archive' , 'ip_address',  'social_link', 'created_date' , 'created_time' ,'created_at' , 'updated_at'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Optionally, you can add casts for specific fields
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
