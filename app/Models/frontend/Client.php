<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients'; 
    
    protected $fillable = [
        'id', 'clients', 'company_id', 'staff_id', 'user_type', 'client_name', 'company_name', 
        'email', 'phone', 'meating_time', 'address', 'blance', 'temp_value', 'discount', 
        'typeofuser', 'assign_meating', 'client_potential', 'archive', 'meeting_status', 'followup_date', 'reschedule', 
        'remark', 'ip_address', 'created_at', 'updated_at', 'created_date' , 'created_time'
    ];
}
