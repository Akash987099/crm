<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agent extends Model
{
    use HasFactory;
    protected $table = 'agent'; 
    protected $fillable = ['id', 'name', 'user_id' , 'contact' , 'lead_source' , 'pan_card' , 'aadhar_card' , 'pincode', 'document_add' , 'email' , 'district' , 'state' , 'project' , 'employee' , 'rrn_no' , 'payment_re' , 'payment_due' , 'document_name' , 'docuemnts',  'created_at', 'updated_at'];
}
