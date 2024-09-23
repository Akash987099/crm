<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class programs extends Model
{
    use HasFactory;
    protected $table = 'programs';
    // replace programs
	
    protected $fillable = [
        'name',
        'user_id',
        'status',
        'created_by',
    ];
}
