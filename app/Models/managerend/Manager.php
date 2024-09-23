<?php

namespace App\Models\managerend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Manager extends Model implements AuthenticatableContract
{
    use Authenticatable;

    use HasFactory;
    protected $table = "managers";
    
    protected $fillable = [
        'id', 'user_id' , 'user_type' , 'company_id' , 'name' , 'email' , 'phone' , 'joining_date' , 'address' , 'city' , 'pincode' , 'state' , 'country' , 'profile_pic' , 'status' , 
        'staff_id' , 'role_type' , 'password' , 'archive' , 'created_date' , 'created_time' , 'ip_address' , 'created_at' , 'updated_at'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Optionally, you can add casts for specific fields
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
