<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\backend\Settings;
use App\Models\backend\Users;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;



class SettingController extends Controller
{
    public function Setting()
    {
        return view('backend.setting.site-setting');
    }
    public function updateSetting(Request $request){
    // Validate the request
    $request->validate([
        'company_name' => 'required',
        'company_title' => 'required',
        'company_website' => 'required',
        'address' => 'required',
        'country' => 'required',
        'state' => 'required',
        'city' => 'required',
        'zipcode' => 'required',
        'telephone' => 'required|numeric|digits:10',
        'site_logo' => 'mimes:jpeg,png,jpg',
    ]);

    // Decrypt the session ID
    $sid = Crypt::decryptString($request->input('setting_id'));

    // Find the settings record by company_id
    $setting = Settings::where('company_id', $sid)->first();

    // If a record does not exist, create a new one
    if (!$setting) {
        $setting = new Settings;
        $setting->company_id = $sid;
    }

    // Handle the site logo upload if provided
    if ($request->hasFile('site_logo')) {
        // Delete the old logo if it exists
        if ($setting->site_logo) {
            $path = "public/assets/uploads/logo/" . $setting->site_logo;
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        // Upload the new logo
        $file = $request->file('site_logo');
        $exte = $file->getClientOriginalExtension();
        $rename = time() . "." . $exte;
        $file->move('public/assets/uploads/logo/',$rename);
        $setting->site_logo = $rename;
    }

    // Update the settings record
    $setting->company_name = $request->company_name;
    $setting->company_title = $request->company_title;
    $setting->company_website = $request->company_website;
    $setting->address = $request->address;
    $setting->country = $request->country;
    $setting->state = $request->state;
    $setting->city = $request->city;
    $setting->zipcode = $request->zipcode;
    $setting->telephone = $request->telephone;
    $setting->created_date = date('d-m-Y');
    $setting->created_time = time();
    $setting->ip_address = $_SERVER['REMOTE_ADDR'];

    // Save the settings record
    $insert = $setting->save();

    // Redirect back with a success message
    if ($insert) {
        return back()->with('success', 'Settings updated successfully!');
    } else {
        return back()->with('error', 'Failed to update settings.');
    }
}
}
