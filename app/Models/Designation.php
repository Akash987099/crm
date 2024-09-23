<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $table = 'designation'; 
    protected $fillable = ['id', 'Designation', 'user_id' ,  'created_at', 'updated_at'];
}
