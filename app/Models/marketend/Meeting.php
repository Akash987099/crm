<?php

namespace App\Models\marketend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $table = "meetings";
    protected $primarykey = "id";
}
