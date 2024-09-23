<?php
use App\Models\Privilege;
use App\Models\Program;
use App\Models\HistoryReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function ViewPermission($programId)
{
    $userid = Auth::guard('employee')->user()->id;

    $privilege = Privilege::where('program_id', $programId)
                         ->where('user_id', $userid)
                         ->first();

    if ($privilege != null && $privilege != "") {
        if ($privilege->view_priv == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function AddPermission($programId){

    $userid = Auth::guard('employee')->user()->id;

    $privilege = Privilege::where('program_id', $programId)
                         ->where('user_id', $userid)
                         ->first();

    if ($privilege != null && $privilege != "") {
        if ($privilege->add_priv == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }

}

function EditPermission($programId){

    $userid = Auth::guard('employee')->user()->id;

    $privilege = Privilege::where('program_id', $programId)
                         ->where('user_id', $userid)
                         ->first();

    if ($privilege != null && $privilege != "") {
        if ($privilege->modify_priv == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
    
}

function DeletePermission($programId){
    $userid = Auth::guard('employee')->user()->id;

    $privilege = Privilege::where('program_id', $programId)
                         ->where('user_id', $userid)
                         ->first();

    if ($privilege != null && $privilege != "") {
        if ($privilege->del_priv == 1) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
   
}
