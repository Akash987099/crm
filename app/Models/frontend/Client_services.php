<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client_services extends Model
{
    use HasFactory;
    protected $table = "clients_services";
    protected $primarykey = "id";
}
