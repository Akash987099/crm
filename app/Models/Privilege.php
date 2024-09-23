<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $table = 'privileges';
    protected $fillable = [
        'program_id',
        'user_id',
        'view_priv',
        'add_priv',
        'modify_priv',
        'del_priv',
    ];
    
}
