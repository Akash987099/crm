<?php

namespace App\Models\marketend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    use HasFactory;
    protected $table = "marketing_users";
    protected $primarykey = "id";
}
