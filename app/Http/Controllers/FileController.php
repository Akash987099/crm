<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\employee;
use App\Models\leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Crypt;
use App\Models\frontend\Client;
use App\Models\File;


class FileController extends Controller
{
    
    public function fileMange($parentId = null){

        $parent = File::find($parentId);
        $files = File::where('parent_id', $parentId)->where('user_id' , Auth::guard('manager')->user()->id)->get();

        return view('pages.file' , compact('parent' , 'files'));

    }

    public function filecreateFolder(Request $request){

        // dd($request->all());

        $staffid = $request->staffid;
        $staffpath = str_replace('#', '', $staffid);
        $request->validate([
            'name' => 'required|string|max:255',
            'staffid'  => 'required',
        ]);

        $check = File::where('staff_id' , $staffid)->first();
      
        // dd($check);

        if($check){
            //  return "1111";
            return back()->with('error', 'Staff Id Already  exit!!');
           
        }else{
               
            // return "2222";
                $file =  File::create([
                    'user_id' => Auth::guard('manager')->user()->id,
                    'name' => $request->name,
                    'path' => '',
                    'is_folder' => true,
                    'staff_id' => $staffpath,
                    'parent_id' => $request->parent_id,
                ]);
        
                if($file){
                    return back()->with('success', 'Folder created successfully');
                }else{
                    return back()->with('error', 'Failed!!');
                }
            }$staffid = $request->staffid;
            $staffpath = str_replace('#', '', $staffid);
            $request->validate([
                'name' => 'required|string|max:255',
                'staffid'  => 'required',
            ]);
    
            $check = File::where('staff_id' , $staffid)->first();
          
            // dd($check);
    
            if($check){
                //  return "1111";
                return back()->with('error', 'Staff Id Already  exit!!');
               
            }else{
                   
                // return "2222";
                    $file =  File::create([
                        'user_id' => Auth::guard('manager')->user()->id,
                        'name' => $request->name,
                        'path' => '',
                        'is_folder' => true,
                        'staff_id' => $staffpath,
                        'parent_id' => $request->parent_id,
                    ]);
            
                    if($file){
                        return back()->with('success', 'Folder created successfully');
                    }else{
                        return back()->with('error', 'Failed!!');
                    }
                }
    }

    public function manager_file_view(Request $request){

        $id = $request->id;

        $filenew =  DB::table('images')->where('staff_id' , $id)->get();

        // dd($filenew);

        return view('pages.file_view' , compact('filenew'));

    }

    public function MuploadFile(Request $request){

        $parent_id = $request->parent_id;

        $request->validate([
            'file' => 'required',
             'parent_id' => 'required',
        ]);
    
        // $parent = File::find($request->parent_id);
    
        $folderName = $parent_id ;
        $staffpath = str_replace('#', '', $folderName);
    
        $directory = 'uploads/' . $staffpath;
        if (!Storage::disk('public')->exists($directory)) {
            Storage::disk('public')->makeDirectory($directory);
        }
    
        $file = $request->file('file');
        $path = $file->store($directory, 'public');
    
        $filenew =  DB::table('images')->insert([
            'user_id' => Auth::guard('manager')->user()->id,
            'image' => $file->getClientOriginalName(),
            'path' => $path,
            'staff_id' => $parent_id,
            'path' => $path,
            // 'parent_id' => $request->parent_id,
        ]);

        if($filenew){
            return response()->json(['status' =>  'success']);
        }else{
            return response()->json(['status' => 'error']);
        }

    }

}
