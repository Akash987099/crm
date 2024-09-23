<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leave extends Model
{
    use HasFactory;
    protected $table = 'leave_master'; 
    protected $fillable = ['id', 'employee_id' ,  'subject' , 'reason', 'updated_at' , 'type'];
}
