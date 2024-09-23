<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telemarketing extends Model
{
    use HasFactory;
    protected $table = "tele_person";
    protected $primarykey = "id";
}
