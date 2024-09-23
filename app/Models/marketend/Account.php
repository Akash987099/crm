<?php

namespace App\Models\marketend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = "payment_details";
    protected $primarykey = "id";
}
