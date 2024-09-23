<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeleCalling extends Model
{
    use HasFactory;
    protected $table = "calling";
    protected $primarykey = "id";
}
