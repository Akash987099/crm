<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\AdminMarketMeeting_Controller;
use App\Http\Controllers\leadcontroller;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\telemarketController;
use App\Http\Controllers\backend\marketController;
use App\Http\Controllers\backend\ServicesController;
use App\Http\Controllers\backend\ManagerController;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\bdeController;
use App\Http\Controllers\backend\CallingController;
use App\Http\Controllers\frontend\TeleCallingController;
use App\Http\Controllers\frontend\LoginController;
use App\Http\Controllers\frontend\ClientController;
use App\Http\Controllers\backend\Admin_client_controller;
use App\Http\Controllers\backend\StaffController;
use App\Http\Controllers\frontend\TeleProfileController;
use App\Http\Controllers\marketend\MrLogin_controller;
use App\Http\Controllers\marketend\MrProfileController;
use App\Http\Controllers\marketend\Cold_Call_controller;
use App\Http\Controllers\marketend\Assign_MeatingController;
use App\Http\Controllers\marketend\MeetingController;
use App\Http\Controllers\backend\ColdCallcontroller;
use App\Http\Controllers\backend\Meeting_Controller;
use App\Http\Controllers\backend\CustomersController;
use App\Http\Controllers\managerend\ManagerLoginController;
use App\Http\Controllers\managerend\ManagerProfileController;
use App\Http\Controllers\managerend\ManagerColdCallController;
use App\Http\Controllers\managerend\ManagerAssignMeetingController;
use App\Http\Controllers\managerend\Manager_Tele_teamController;
use App\Http\Controllers\managerend\Manager_market_teamController;
use App\Http\Controllers\managerend\ManagerMeetingController;
use App\Http\Controllers\bde\BdeLoginController;
use App\Http\Controllers\bde\BdeColdcallController;
use App\Http\Controllers\bde\BdeMeetingController;
use App\Http\Controllers\bde\BdeProfileController;
use App\Http\Controllers\marketend\BillPayController;
use App\Http\Controllers\managerend\ManagerBillPayController;
use App\Http\Controllers\bde\BdeBillPayController;
use App\Http\Controllers\bde\AssignMeetingBdeController;
use App\Http\Controllers\backend\AdminBillPayController;
use App\Http\Controllers\backend\HomeController;
use App\Http\Controllers\bde\BdeAssignMeetingController;
use App\Http\Controllers\bde\Bde_Meeting_reportController;
use App\Http\Controllers\marketend\Market_Meeting_ReportController;
use App\Http\Controllers\managerend\Manager_meeting_ReportController;
use App\Http\Controllers\backend\Meetings_ReportController;
use App\Http\Controllers\marketend\Home_Controller;
use App\Http\Controllers\managerend\ManagerHomeController;
use App\Http\Controllers\bde\Bde_HomeController;
use App\Http\Controllers\frontend\Tele_HomeController;
use App\Http\Controllers\employeecontroller;
use App\Http\Controllers\lettercontroller;
use App\Http\Controllers\attendancecontroller;
use App\Http\Controllers\leavecontroller;
use App\Http\Controllers\agentcontroller;
use App\Http\Controllers\statusController;
use App\Http\Controllers\ForgotPasswordController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cache', function () {
    Artisan::call('view:clear');
    Artisan::call('route:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('storage:link');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    echo "cache cleared !";
});

/////////////////////////////////////////TELEMARKETING/////////////////////////////////////////////
/**************************LOGIN SYSTEM******************************************* */
// Route::get('/', function () {
//     return view('frontend.login');
// });

Route::get('view/clients', [ClientController::class, 'View_clients'])->name('frontend.View_clients');

Route::controller(ForgotPasswordController::class)->group(function(){

    Route::match(['get', 'post'], '/ForgetPassword', 'ForgetPassword')->name('ForgetPassword');
    Route::match(['get', 'post'], '/ForgetPasswordPost', 'ForgetPasswordPost')->name('ForgetPasswordPost');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'ResetPassword'])->name('ResetPasswordGet');
    Route::post('reset-password', [ForgotPasswordController::class, 'ResetPasswordStore'])->name('ResetPasswordPost');

    Route::match(['get' , 'post'] , 'coming/soon' , 'comingsoon')->name('coming-soon');


});

Route::get('/login', [LoginController::class, 'login']);

Route::controller(LoginController::class)->group(function(){

    Route::match(['get', 'post'], '/login', 'login')->name('frontend.login');

});

Route::match(['get', 'post'], '/telemarketingUser', [LoginController::class, 'TeleUserLogin'])->name('TeleUserLogin');
// Route::post('/telemarketingUser', [LoginController::class, 'TeleUserLogin']);
Route::get('/telelogout', [LoginController::class, 'telemarketlogout']);

Route::get('view-client', [Admin_client_controller::class, 'view_client'])->name('backend.view-client');
Route::get('view-clients', [Admin_client_controller::class, 'Show_client']);
Route::get('client-add', [Admin_client_controller::class, 'create_client'])->name('backend.client');
Route::post('client-add', [Admin_client_controller::class, 'Post_client'])->name('backend.client-submit');
Route::get('client-edit/{id}', [Admin_client_controller::class, 'Client_edit'])->name('backend.edit-client');
Route::post('client-update', [Admin_client_controller::class, 'Client_Update'])->name('backend.update-client');
Route::get('client-delete/{id}', [Admin_client_controller::class, 'Client_Admin_Delete'])->name('backend.client-delete');
Route::get('view-archive-client', [Admin_client_controller::class, 'View_Archive_Client'])->name('backend.archive-client');
Route::get('active-archive-client/{id}', [Admin_client_controller::class, 'Active_archive_client'])->name('backend.active-client');
Route::post('views-clients-data', [Admin_client_controller::class, 'Views_client_Modal'])->name('backend.lead.views-clients-data');
   Route::get('view-clients', [ClientController::class, 'View_client'])->name('frontend.view-clients');
   Route::get('clients-delete/{id}', [ClientController::class, 'client_delete_data']);
   Route::get('edit-teleclient/{id}', [ClientController::class, 'Edit_TeleClient']);
   Route::post('Client-update', [ClientController::class, 'Update_TeleClient']);
   Route::get('view-clients-list', [ClientController::class, 'ViewClientList'])->name('telemarket.view-clients-list');
   Route::get('client-details', [ClientController::class, 'Client']);
   Route::post('client-details', [ClientController::class, 'Add_client'])->name('telemarket.client-details');
   Route::get('view-archive-client', [ClientController::class, 'View_archive_client']);
   Route::get('active-archive-client/{id}', [ClientController::class, 'Active_archiveClient']);
   

Route::controller(employeecontroller::class)->group(function(){
    
    Route::match(['get', 'post'], 'employeeLogin', 'employeeLogin')->name('employeeLogin');
    Route::match(['get', 'post'], 'employeeLogins', 'employeeLogins')->name('employeeLogins');
    
});

Route::controller(agentcontroller::class)->group(function(){

    Route::match(['get', 'post'], '/add/agents', 'addagents')->name('addagents');
    Route::match(['get', 'post'], '/agent/view', 'Addview')->name('Add-view');
    Route::match(['get', 'post'], '/view/agent', 'viewagent')->name('view-agent');
    Route::match(['get', 'post'], '/delete/agent', 'deleteagent')->name('deleteagent');
    Route::match(['get', 'post'], '/update/agent', 'updateagents')->name('updateagents');
    Route::match(['get', 'post'], 'importagents', 'importagents')->name('importagents');
    Route::match(['get', 'post'], 'get-pincode',  'getpincode')->name('get-pincode');
    

});

Route::controller(employeecontroller::class)->group(function(){

    Route::match(['get', 'post'], '/agent/list', 'agentmaster')->name('agent-master');
    Route::match(['get', 'post'], '/agent/Add', 'AddAgent')->name('Add-agent');
    

});

/**************************END LOGIN SYSTEM******************************************* */

Route::controller(employeecontroller::class)->group(function(){

    // Route::match(['get', 'post'], '/', 'index')->name('index');

});

Route::prefix('employee')->middleware(['auth:employee'])->group(function () {

    Route::controller(attendancecontroller::class)->group(function(){
    Route::match(['get', 'post'], 'employee/file/{parentId?}', 'employee_file')->name('employee_file');
    Route::post('employee/files/folder','EcreateFolder')->name('employee_file.createFolder');
    Route::post('employee/files/upload', 'EuploadFile')->name('employee_file.uploadFile');
    Route::delete('employee/files/{id}',  'EdeleteFile')->name('employee_file.deleteFile');

    Route::get('employee/files/views',  'employee_file_view')->name('employee_file_view');

    });

    Route::controller(agentcontroller::class)->group(function(){

        Route::match(['get', 'post'], '/getMessages', 'getMessages')->name('getMessages');

        Route::get('employee/notifications/list',  'employee_notification_view')->name('employee_notification_view');
        Route::get('employee/notifications/view',  'notification_viewGet')->name('notification_viewGet');
        Route::get('employee/notifications/views',  'notification_viewGetID')->name('notification_viewGetID');

    });


    Route::controller(employeecontroller::class)->group(function(){

        Route::match(['get', 'post'], '/', 'index')->name('index');
        Route::match(['get', 'post'], '/employee-profile', 'employeeprofile')->name('employee-profile');
        Route::match(['get', 'post'], '/employee-profile/update', 'Eprofileupdate')->name('Eprofile-update');
       Route::match(['get', 'post'] , 'employee/logout', 'employeelogout')->name('employee.logout');

        // akash

    });

    Route::controller(attendancecontroller::class)->group(function(){

        Route::match(['get', 'post'], 'employee/attendance', 'Eattendance')->name('Eattendance');
        Route::match(['get', 'post'], 'employee/attendance/list', 'EattendanceList')->name('EattendanceList');
        Route::match(['get', 'post'], 'employee/attendance/capture', 'upload_image')->name('upload.image');
        Route::match(['get', 'post'], 'employee/attendance/capture/save', 'employee_save_attendane')->name('employee.save.attendane');

    });

    Route::controller(leavecontroller::class)->group(function(){

        Route::match(['get', 'post'], '/leave', 'leave')->name('leave');
        Route::match(['get', 'post'], '/Addleave', 'Addleave')->name('add-leave');
        Route::match(['get', 'post'], '/leaveAjax', 'leaveAjax')->name('leave-leave');

    });


});


///////////////////////////////////START TELEMARKETING MIDDLEWARE//////////////////////////////////

Route::prefix('telecaller')->middleware(['auth:telecaller'])->name('telecaller.')->group(function () {

    Route::get('/index', [Tele_HomeController::class, 'TELE_HOME'])->name('index');
    // Route::get('/agent', [Tele_HomeController::class, 'agent'])->name('agent');
    // Route::get('/agent/list', [Tele_HomeController::class, 'agentList'])->name('agent-list');
    // Route::get('/agent/list/invoice', [Tele_HomeController::class, 'agentGetbyid'])->name('agent-Getbyid');
    // Route::get('/agent/list/single', [Tele_HomeController::class, 'exportSingle'])->name('exportSingle');

    Route::get('/asset/track', [Tele_HomeController::class, 'asset'])->name('asset');
    // Route::get('home', [Tele_HomeController::class, 'TELE_HOME']);
    Route::post('recent-lead', [Tele_HomeController::class, 'RECENT_LEAD']);
  
    // Route::post('view-telemarketing-modal', [ClientController::class, 'view_telemarketing_details'])->name('frontend.view-telemarketing-details');
    Route::post('select-service-getprice', [ClientController::class, 'select_service_getprice']);
    Route::post('typeofuser', [ClientController::class, 'TYPEOFUSER'])->name('telemarket.typeofuser');

    Route::get('add-client-service', [ClientController::class, 'AddClientService'])->name('frontend.add-client-service');
    Route::post('addClient-servicedata', [ClientController::class, 'AddClientserviceData'])->name('frontend.addClient-servicedata');
    Route::post('client-service-discount', [ClientController::class, 'ClientServiceDiscount'])->name('frontend.client-service-discount');
    Route::post('client-delete-service', [ClientController::class, 'ClientServiceDelete'])->name('frontend.client-delete-service');
    Route::get('client-sevice-data', [ClientController::class, 'ViewClientData'])->name('frontend.client-sevice-data');
  
    Route::get('client-calling', [TeleCallingController::class, 'Client_calling'])->name('client-calling');

    Route::post('calling-data', [TeleCallingController::class, 'Add_calling']);

    Route::get('call-list', [TeleCallingController::class, 'Call_list']);

    Route::get('View-call-list', [TeleCallingController::class, 'view_call_list']);

    Route::get('edit-call/{id}', [TeleCallingController::class, 'Edit_call']);

    Route::post('update-call', [TeleCallingController::class, 'Update_call']);

    Route::get('delete-client/{id}', [TeleCallingController::class, 'Client_delete']);
   
    Route::get('my-profile', [TeleProfileController::class, 'Myprofile']);
    Route::post('profile-update', [TeleProfileController::class, 'Myprofile_Update']);

    Route::match(['get', 'post'], 'tele-pass-update', [TeleProfileController::class, 'telePass_change']);
});
// Route::middleware('telemarketingWebgaurd')->group(function () {
//     Route::group(
//         ['prefix' => '/'],
//         function () {
            
            // Route::get('home', [Tele_HomeController::class, 'TELE_HOME']);
            // Route::post('recent-lead', [Tele_HomeController::class, 'RECENT_LEAD']);
          
            // Route::post('view-telemarketing-modal', [ClientController::class, 'view_telemarketing_details'])->name('frontend.view-telemarketing-details');
            // Route::post('select-service-getprice', [ClientController::class, 'select_service_getprice']);
            // Route::post('typeofuser', [ClientController::class, 'TYPEOFUSER'])->name('telemarket.typeofuser');



            // Route::get('add-client-service', [ClientController::class, 'AddClientService'])->name('frontend.add-client-service');
            // Route::post('addClient-servicedata', [ClientController::class, 'AddClientserviceData'])->name('frontend.addClient-servicedata');
            // Route::post('client-service-discount', [ClientController::class, 'ClientServiceDiscount'])->name('frontend.client-service-discount');
            // Route::post('client-delete-service', [ClientController::class, 'ClientServiceDelete'])->name('frontend.client-delete-service');
            // Route::get('client-sevice-data', [ClientController::class, 'ViewClientData'])->name('frontend.client-sevice-data');
          
            // Route::get('client-calling', [TeleCallingController::class, 'Client_calling']);

            // Route::post('calling-data', [TeleCallingController::class, 'Add_calling']);

            // Route::get('call-list', [TeleCallingController::class, 'Call_list']);

            // Route::get('View-call-list', [TeleCallingController::class, 'view_call_list']);

            // Route::get('edit-call/{id}', [TeleCallingController::class, 'Edit_call']);

            // Route::post('update-call', [TeleCallingController::class, 'Update_call']);

            // Route::get('delete-client/{id}', [TeleCallingController::class, 'Client_delete']);
           
            // Route::get('my-profile', [TeleProfileController::class, 'Myprofile']);
            // Route::post('profile-update', [TeleProfileController::class, 'Myprofile_Update']);

            // Route::post('tele-pass-update', [TeleProfileController::class, 'telePass_change']);
//         }
//     );
// });
///////////////////////////////////END TELEMARKETING MIDDLEWARE//////////////////////////////////
/////////////////////////////////////////END TELEMARKETING/////////////////////////////////////////////

////////////////////////////////////// START MARKETING////////////////////////////////////////////////////////

/////////////////////////////////MARKETING MIDDLEWARE/////////////////////////////////////////////////
Route::get('marketing/', function () {
    return redirect('marketing/login');
});
Route::get('marketing/login', [MrLogin_controller::class, 'marketing_login']);
Route::post('marketing/marketing-login', [MrLogin_controller::class, 'Login_marketing']);

Route::middleware(['marketingWebgaurd'])->group(function () {
    Route::group(
        ['prefix' => 'marketing/'],
        function () {

            Route::get('home', [Home_Controller::class, 'HOME']);
            Route::post('views-recent-meeting-data', [Home_Controller::class, 'Recent_Meeting_marketing'])->name('market.views-recent-meeting-data');
            Route::get('logout-users', [MrLogin_controller::class, 'Marketing_user_logout']);

            /*****************************USER PROFILE******************************************/
            Route::get('profile-market', [MrProfileController::class, 'Marketing_profile']);
            Route::post('profile-market-update', [MrProfileController::class, 'Marketing_profile_update']);
            Route::post('market-pass', [MrProfileController::class, 'Marketing_pass_change']);
            /*****************************END USER PROFILE**************************************/

            /*****************************COLD CALL**************************************** */
            Route::get('view-cold-call', [Cold_Call_controller::class, 'View_cold_Call'])->name('market.view-cold-call');
            Route::get('view-cold-list', [Cold_Call_controller::class, 'View_cold_list']);

            Route::get('cold-call', [Cold_Call_controller::class, 'Cold_Call'])->name('market.add-coldcall');
            Route::post('cold-calls', [Cold_Call_controller::class, 'Add_Cold_Call']);

            Route::get('edit-cold-call/{id}', [Cold_Call_controller::class, 'Edit_cold_call']);
            Route::post('cold-call-update', [Cold_Call_controller::class, 'Cold_col_update'])->name('market.cold-call-update');

            Route::get('delete-cold-col/{id}', [Cold_Call_controller::class, 'Delete_cold_call']);

            Route::get('coldcall-view-details', [Cold_Call_controller::class, 'View_coldcall_details'])->name('market.coldcall-view-details');

            Route::get('archive-cold-call', [Cold_Call_controller::class, 'Archive_ColdCall'])->name('market.archive-coldcall');
            Route::get('activate-cold-call/{id}', [Cold_Call_controller::class, 'ActiveColdCall']);


            Route::get('add-services', [Cold_Call_controller::class, 'COLDCALL_SERVICE_ADD'])->name('market.add-service');
            Route::post('service-data', [Cold_Call_controller::class, 'MEETING_SERVICE_SUBMIT'])->name('market.service-data-submit');
            Route::post('delete-service-data', [Cold_Call_controller::class, 'DELETE_SERVICE_DATA'])->name('market.service-data-delete');

            Route::post('service-price-discount', [Cold_Call_controller::class, 'SERVICE_PRICE_DISCOUNT'])->name('market.service-price-discount');
            /*****************************END COLD CALL*********************************************************************/

            /**************************ASSIGN MEATING******************************************** */
            Route::get('view-assign-meating', [Assign_MeatingController::class, 'View_assign_meating'])->name('market.View-assign-meating');
            Route::get('edit-assign-meating/{id}', [Assign_MeatingController::class, 'Edit_Assign_meating']);
            Route::post('update-assign-meating', [Assign_MeatingController::class, 'Update_Assign_meating']);

            Route::post('selectservice-getprice', [Assign_MeatingController::class, 'Select_servicePrice']);
            /**************************END ASSIGN MEATING**************************************** */

            /********************************MEETING ******************************************************** */
            Route::get('view-meeting', [MeetingController::class, 'All_Meeting'])->name('market.view-attend-meeting');
            Route::get('archive-meeting', [MeetingController::class, 'Archive_meeting'])->name('market.archive-meeting');

            Route::get('add-meeting', [MeetingController::class, 'Add_Meeting']);
            Route::post('add-meeting', [MeetingController::class, 'Create_Meeting'])->name('meeting.add-meeting');

            Route::get('edit-meeting/{id}', [MeetingController::class, 'Edit_Meeting']);
            Route::post('edit-meeting', [MeetingController::class, 'Update_Meeting_data'])->name('market.update-meeting');
            Route::get('meeting-delete/{id}', [MeetingController::class, 'Meeting_delete']);
            Route::get('active-meating/{id}', [MeetingController::class, 'Meeting_Active']);

            Route::post('view-meeting-data', [MeetingController::class, 'View_meeting_modal'])->name('market.view-meeting-data');

            Route::get('will-pay/{id}', [BillPayController::class, 'Bill_payment'])->name('market.will-pay');
            Route::post('add-payment', [BillPayController::class, 'Add_payment'])->name('market.add_payment');

            /**********************************add service*********************************************************************** */
            Route::get('add-meeting-service', [MeetingController::class, 'MeetingServiceAdd'])->name('market.add-meeting-service');
            Route::post('add-meeting-service', [MeetingController::class, 'MeetingServiceSubmit'])->name('market.submit-meeting-service');
            Route::post('delete-meeting-service', [MeetingController::class, 'DeleteMeeting_Service'])->name('delete-meeting-service');
            Route::post('meeting-service-discount', [MeetingController::class, 'MeetingServiceDiscount'])->name('market.meeting-service-discount');
            Route::get('view-meeting-details', [MeetingController::class, 'ViewMeetingDetails'])->name('market.view-meeting-details');
            /********************************END MEETING **************************************************** */

            /********************************REPORT MEETING **************************************************** */
            Route::get('check-meeting-details', [Market_Meeting_ReportController::class, 'Check_Meeting_availability'])->name('market.check-meeting-details');
            Route::post('check-meeting-details', [Market_Meeting_ReportController::class, 'Check_Meeting'])->name('market.filter-meeting');
            Route::get('coldcall-report', [Market_Meeting_ReportController::class, 'MARKETING_COLDCALL_REPORT'])->name('market.coldcall-report');
            Route::post('coldcall-report', [Market_Meeting_ReportController::class, 'MARKETING_COLDCALL_REPORT_GENERATE'])->name('market.coldcall-mreport');

            Route::get('total-meeting-report', [Market_Meeting_ReportController::class, 'MARKETING_TOTAL_REPORT'])->name('market.total-meeting-mreport');
            Route::post('total-meeting-report', [Market_Meeting_ReportController::class, 'MARKETING_TOTAL_REPORT_GENERATE'])->name('market.total-meeting');
            /********************************END REPORT MEETING **************************************************** */

            /******************************** SELECT SERVICE GET PRICE **************************************************** */
            Route::post('select-service-getprice', [MeetingController::class, 'Select_service_get_price']);
            /********************************END SELECT SERVICE GET PRICE **************************************************** */

            /******************************select client get company name**************************************** */
            Route::post('selectclientcompany', [MeetingController::class, 'SelectClientGetCompany']);

            /**********************************end*************************************************************** */
        }
    );
});
///////////////////////////////// END MARKETING MIDDLEWARE/////////////////////////////////////////////////
////////////////////////////////////////END MARKETING//////////////////////////////////////////////////





////////////////////////////////////START BACKEND CODE ROUTE////////////////////////////////////////
Route::get('admin/', function () {
    return redirect('admin/login');
});

Route::get('admin/leads/client', [Admin_client_controller::class, 'backend_leads'])->name('backend.leads');
Route::get('admin/leadclient', [Admin_client_controller::class, 'backend_lead'])->name('backend.lead');
Route::get('admin/lead/client', [Admin_client_controller::class, 'viewlistlead'])->name('viewlist.lead');
Route::get('admin/lead/add', [Admin_client_controller::class, 'leadclient'])->name('leadclient');
Route::post('admin/lead/add/ajax', [Admin_client_controller::class, 'lead_client_submit'])->name('lead.client-submit');
Route::get('admin/lead/update', [Admin_client_controller::class, 'lead_client_update'])->name('lead.update-submit');
Route::post('admin/lead/update/ajax', [Admin_client_controller::class, 'lead_update_ajax'])->name('lead.update-ajax');


Route::controller(agentcontroller::class)->group(function(){

    Route::match(['get', 'post'], '/admin/agent', 'adminagent')->name('adminagent');
    Route::match(['get', 'post'], '/admin/agent/view/list', 'agent_view')->name('agent-view');
    Route::match(['get', 'post'], '/admin/agent/add', 'admin_Add_agent')->name('admin-Add-agent');
    Route::match(['get', 'post'], '/admin/agent/view', 'admin_view_agent')->name('admin-view-agent');

    
    Route::post('view-telemarketing-modal', [ClientController::class, 'view_telemarketing_details'])->name('frontend.view-telemarketing-details');

    Route::match(['get', 'post'], '/admin/messages/send', 'admin_messages')->name('admin_messages');
    Route::match(['get', 'post'], '/admin/messages/save', 'messagessave')->name('messagessave');
    Route::match(['get', 'post'], '/admin/messages/view', 'view_messages')->name('view-messages');
    Route::match(['get', 'post'], '/admin/messages/sends', 'sendmailajax')->name('sendmailajax');

});

Route::controller(statusController::class)->group(function(){

    Route::match(['get', 'post'], '/admin/Privilege', 'Privilege')->name('Privilege');
    
    Route::match(['get', 'post'], '/admin/Privilege/view', 'privilegeview')->name('privilege-view');
    Route::match(['get', 'post'], '/admin/Privilege/handle', 'handleprivilege')->name('handleprivilege');

    Route::match(['get', 'post'], 'status', 'status')->name('status');
    Route::match(['get', 'post'], 'add/sattus', 'addsattus')->name('addsattus');
    Route::match(['get', 'post'], 'view/sattus', 'viewstatus')->name('viewstatus');
    Route::match(['get', 'post'], 'view/delete', 'deletestatus')->name('deletestatus');
    Route::match(['get', 'post'], 'view/update', 'updatestatus')->name('updatestatus');

    Route::match(['get', 'post'], 'admin/device/access', 'admindivice')->name('admin.divice');
    Route::match(['get', 'post'], 'admin/device/add', 'adddivice')->name('add.divice');
    Route::match(['get', 'post'], 'admin/device/adds', 'adddivices')->name('adddivice');
    Route::match(['get', 'post'], 'admin/device/list', 'assestviewDevice')->name('assest-viewDevice');
    Route::match(['get', 'post'], 'admin/device/delete', 'assestdelete')->name('assest-delete');
    Route::match(['get', 'post'], 'admin/device/edit', 'assetedit')->name('assetedit');
    Route::match(['get', 'post'], 'admin/device/update', 'updatedeive')->name('updatedeive');

});

Route::controller(lettercontroller::class)->group(function(){

    Route::match(['get', 'post'], 'letter', 'letter')->name('letter');
    Route::match(['get', 'post'], 'letter/save', 'lettersave')->name('letter-save');
    Route::match(['get', 'post'], 'letter/send', 'sendletter')->name('send-letter');

});

Route::controller(employeecontroller::class)->group(function(){

    Route::match(['get', 'post'], '/Product/list', 'Product')->name('Product');
    Route::match(['get', 'post'], '/Product/Add', 'AddProduct')->name('AddProduct');
    Route::match(['get', 'post'], '/VIEWProduct', 'VIEWProduct')->name('VIEWProduct');
    Route::match(['get', 'post'], '/deleteProduct', 'deleteProduct')->name('deleteProduct');
    Route::match(['get', 'post'], '/updateproduct', 'updateproduct')->name('update-eProduct');
    
    Route::match(['get', 'post'], '/userChangepass', 'userChangepass')->name('userChangepass');

    Route::match(['get', 'post'], 'admin/employees', 'employee')->name('employee');
    Route::match(['get', 'post'], 'add/employee', 'addemployee')->name('add-employee');
    Route::match(['get', 'post'], 'addemployees', 'addemployees')->name('addemployees');
    Route::match(['get', 'post'], 'view/employee', 'viewemployee')->name('view-employee');
    Route::match(['get', 'post'], 'delet/employee', 'deleteemployee')->name('deleteemployee');
    Route::match(['get', 'post'], 'delete/employee', 'archiveemployee')->name('archiveemployee');
    Route::match(['get', 'post'], 'delete/employee/view', 'archiveemployeeview')->name('archiveemployeeview');
    Route::match(['get', 'post'], 'admin/employee/edit', 'update_employee')->name('update_employee');
    Route::match(['get', 'post'], 'admin/employee/update', 'adminupdateemp')->name('adminupdateemp');

    Route::match(['get', 'post'], 'admin/employees/change/status', 'employeechangeStatus')->name('employee-changeStatus');



//   akash
    // Designation 
    Route::match(['get', 'post'], 'Designation', 'Designation')->name('Designation');
    Route::match(['get', 'post'], 'saveDesignation', 'saveDesignation')->name('saveDesignation');
    Route::match(['get', 'post'], 'Desinationlist', 'Desinationlist')->name('Desinationlist');
    Route::match(['get', 'post'], 'Designationid', 'Designationid')->name('Designationid');
    Route::match(['get', 'post'], 'Designationupdate', 'Designationupdate')->name('Designationupdate');

});
Route::get('admin/login', [UserController::class, 'login'])->name('backend.admin-login');
Route::match(['get' , 'post'] ,'admin/logins', [UserController::class, 'userlogin'])->name('userlogin');
/////////////////////////////END LOGIN /////////////////////////////////////////

///////////////////////////////SIGNUP///////////////////////////////////////////
Route::get('admin/signup', [UserController::class, 'signup']);
Route::post('admin/signup', [UserController::class, 'create_account']);
//////////////////////////////END SIGNUP////////////////////////////////////////composer dump-autoload

///////////////////////////MIDDLEWARE START///////////////////////////////////////////////////////

Route::controller(attendancecontroller::class)->group(function(){

    Route::match(['get', 'post'], 'admin/leave/list/ajax', 'admin_leaveAjax')->name('admin_leaveAjax');
    Route::match(['get' , 'post'] , 'approved-leave' , 'approvedleave')->name('approved-leave');
    Route::match(['get' , 'post'] , 'reject-leave' , 'rejectleave')->name('reject-leave');

});

Route::controller(attendancecontroller::class)->group(function(){
    Route::match(['get', 'post'], 'admin/attendance/list', 'Admin_attendance_view')->name('Admin_attendance_view');

    });



Route::middleware(['guard'])->group(function () {

    Route::group(['prefix' => 'admin/'], function () {


         Route::get('/agents', [Tele_HomeController::class, 'agent'])->name('agent');
    Route::get('/agent/lists', [Tele_HomeController::class, 'agentList'])->name('agent-list');
    Route::get('/agent/list/invoices', [Tele_HomeController::class, 'agentGetbyid'])->name('agent-Getbyid');
    Route::get('/agent/list/singles', [Tele_HomeController::class, 'exportSingle'])->name('exportSingle');


        Route::controller(attendancecontroller::class)->group(function(){

            Route::match(['get', 'post'], 'admin/attendance', 'Admin_attendance')->name('Admin_attendance');
            Route::match(['get' , 'post'], 'admin/delete-attenance' , 'deleteattenance')->name('delete-attenance');
            // Route::match(['get', 'post'], 'admin/attendance/list', 'Admin_attendance_view')->name('Admin_attendance_view');
            Route::match(['get', 'post'], 'admin/leave/list', 'admin_leave')->name('admin_leave');
           

            Route::match(['get', 'post'], 'admin/Employee/report', 'admin_Allemployee')->name('admin_Allemployee');
            Route::match(['get', 'post'], 'admin/Employee/report/ajax', 'admin_Allemployee_Ajax')->name('admin_Allemployee_Ajax');

            Route::match(['get', 'post'], 'admin/file/{parentId?}', 'admin_file')->name('admin_file');

            // Route::get('files/{parentId?}', [FileController::class, 'index'])->name('file.index');
            Route::post('files/folder','createFolder')->name('file.createFolder');
            Route::post('files/upload', 'uploadFile')->name('file.uploadFile');
            Route::delete('files/{id}',  'deleteFile')->name('file.deleteFile');

            Route::get('admin/files/view',  'file_view')->name('file_view');

        });

        Route::get('home', [HomeController::class, 'Admin_Home'])->name('backend.home');
        Route::post('views-leads-data', [HomeController::class, 'Recent_Leatd'])->name('backend.views-leads-data');
        //////////////////////////////ADMIN LOGIN ///////////////////////////////////////////

        //////////////////////////////LOGOUT/////////////////////////////////////////////
        Route::get('logout', [UserController::class, 'logout']);
        /////////////////////////////END LOGOUT/////////////////////////////////////////

        ////////////////////////////ADD LEAD //////////////////////////////////////////
        Route::get('view-lead', [leadcontroller::class, 'viewlead'])->name('view-lead');
        Route::get('add-lead', [leadcontroller::class, 'Add_lead']);
        Route::post('add-lead', [leadcontroller::class, 'create_lead']);
        ////////////////////////////END LEAD//////////////////////////////////////////

        ////////////////////////////EDIT LEAD////////////////////////////////////////
        Route::get('edit-lead/{id}', [leadcontroller::class, 'update_lead']);
        Route::post('edit-lead', [leadcontroller::class, 'edit_lead']);
        ////////////////////////END EDIT LEAD/////////////////////////////////////////

        ////////////////////////////LEAD-ARCHIVE//////////////////////////////////////
        Route::get('lead-archive', [leadcontroller::class, 'lead_archive']);
        Route::get('lead-active/{id}', [leadcontroller::class, 'lead_active']);
        ////////////////////////////END LEAD-ARCHIVE//////////////////////////////////

        ///////////////////////////LEAD DELETE////////////////////////////////////////
        Route::get('lead-delete/{id}', [leadcontroller::class, 'Lead_Delete']);
        ///////////////////////////END LEAD DELETE////////////////////////////////////

        /////////////////////////////MY FROFILE///////////////////////////////////////
        Route::get('profile', [ProfileController::class, 'Profile']);
        Route::post('profile', [ProfileController::class, 'ProfileUpdate']);
        Route::post('change-pass', [ProfileController::class, 'change_password']);
        ///////////////////////////////END MY FROFILE/////////////////////////////////

        ////////////////////////////SITE SETTING ////////////////////////////////////
        Route::get('setting', [SettingController::class, 'Setting']);
        Route::post('setting', [SettingController::class, 'UpdateSetting']);
        ////////////////////////////END SITE SETTING ////////////////////////////////

        ////////////////////////////TELEMARKETING///////////////////////////////////
        Route::get('telemarketing', [telemarketController::class, 'Telemarketing'])->name('backend.telemarket.view-telemarketing');
        Route::get('add-telemarketing', [telemarketController::class, 'create_telemarketing'])->name('backend.add-telemarket');
        Route::post('add-telemarketing', [telemarketController::class, 'AddTelemarketing']);
        Route::get('edit-telemarketing/{id}', [telemarketController::class, 'Edit_telemarketing']);
        Route::post('edit-telemarketing', [telemarketController::class, 'Update_telemarketing']);
        /////////////////////////// DELETE TELEMARKETING /////////////////////////////////////////
        Route::get('delete-tele/{id}', [telemarketController::class, 'Delete_telemarketing']);
        Route::get('archive-telemarketing', [telemarketController::class, 'Archive_telemarketing'])->name('backend.archive-telemarketing');
        Route::get('archive-list-telemarketing', [telemarketController::class, 'Archive_telemarketing_list']);
        Route::get('active-telemarketing/{id}', [telemarketController::class, 'Active_telemarketing']);
        Route::post('telemarketing-pass', [telemarketController::class, 'Change_passwordT']);
        Route::post('view-details-telemarketing', [telemarketController::class, 'view_details_telemarketing_modal']);

        /**************************assign meeting********************************************************/
        Route::get('assign-meeting/{id}', [telemarketController::class, 'Telemarket_Assign_Meeting'])->name('backend.telemarket.assign-meeting');
        Route::get('assign-meeting-details', [telemarketController::class, 'TelemarketAssignMeeting_Details'])->name('backend.telemarket.assign-meetingDetails');
        Route::get('assign-meeting-delete', [telemarketController::class, 'TelemarketAssignMeeting_Delete'])->name('backend.telemarket.assign-meeting-delete');
        Route::get('assign-meeting-archive', [telemarketController::class, 'TelemarketAssignMeeting_Archive'])->name('backend.telemarket.assign-meeting-archive');
        Route::get('assign-meeting-active/{id}', [telemarketController::class, 'TelemarketAssignMeeting_Active'])->name('backend.telemarket.assign-meeting-active');
        Route::get('call-history', [telemarketController::class, 'TeleCall_History'])->name('backend.tele.call-history');
        /**************************assign meeting********************************************************/
        ////////////////////////////END DELETE TELEMARKETING///////////////////////////////////


        ///////////////////////////////MARKETING////////////////////////////////////////////////////////
        Route::get('marketing', [marketController::class, 'View_list'])->name('backend.view-marketing-list');
        Route::get('add-marketing', [marketController::class, 'Add_marketingUser']);
        Route::post('add-marketing', [marketController::class, 'Create_marketingUser']);
        Route::get('marketing-edit/{id}', [marketController::class, 'Edit_MarketingUser']);
        Route::post('edit-marketing', [marketController::class, 'Update_MarketingUser']);

        Route::get('delete-marketing/{id}', [marketController::class, 'Delete_MarketingUser']);

        Route::post('marketing-pass', [marketController::class, 'Change_pass_marketing']);
        //////////////////////////////ARCHIVED MARKETING USER///////////////////////////////////////////
        Route::get('archive-marketing', [marketController::class, 'View_archive_marketing']);
        Route::get('archive-marketing-list', [marketController::class, 'View_archive_marketingList']);
        Route::get('activate-marketing/{id}', [marketController::class, 'Activate_marketing']);
        ///////////////////////////////END ARCHIVED MARKETING USER///////////////////////////////////////
        ////////////////////////////END MARKETING //////////////////////////////////////////////////////

        /************************************MARKET MEETINGS************************************************************************ */
        Route::get('market-meetings/{marketid}', [AdminMarketMeeting_Controller::class, 'MarketPersonMeeting'])->name('backend.marketofmeeting');
        Route::get('market-meetings-delete/{meetingid}', [AdminMarketMeeting_Controller::class, 'MarketMeetingDelete'])->name('backend.market.meetings-delete');
        Route::get('archive-market-meetings', [AdminMarketMeeting_Controller::class, 'MarketMeetingArchive'])->name('backend.market.meetings-archive');
        Route::get('active-market-meetings/{meetingid}', [AdminMarketMeeting_Controller::class, 'MarketMeetingActive'])->name('backend.market.meetings-active');
        Route::get('market-meeting-view-data/{meetingid}', [AdminMarketMeeting_Controller::class, 'MarketMeeting_View_DATA'])->name('backend.market.meetings-view-data');
        Route::get('market-coldcall/{marketid}', [AdminMarketMeeting_Controller::class, 'MarketMeeting_Coldcall'])->name('backend.market.meetings-coldcall');
        Route::get('view-coldcall-details/{coldcalid}', [AdminMarketMeeting_Controller::class, 'MarketColdcall_Details'])->name('backend.market.view-coldcall-details');
        Route::get('view-coldcall-delete/{coldcalid}', [AdminMarketMeeting_Controller::class, 'MarketColdcall_Delete'])->name('backend.market.view-coldcall-delete');
        Route::get('archive-market-coldcall', [AdminMarketMeeting_Controller::class, 'MarketColdcall_Archive'])->name('backend.market.archive-market-coldcall');
        Route::get('market-coldcall-active/{coldid}', [AdminMarketMeeting_Controller::class, 'MarketColdcall_Active'])->name('backend.market.market-coldcall-active');

        /***********************************END MARKET MEETING************************************************************************* */

        ///////////////////////////////SERVICES///////////////////////////////////
        Route::get('services', [ServicesController::class, 'Service']);
        Route::get('add-service', [ServicesController::class, 'Add_service']);
        Route::post('add-service', [ServicesController::class, 'Create_service']);
        Route::get('edit-service/{id}', [ServicesController::class, 'edit_service']);
        Route::post('edit-service', [ServicesController::class, 'update_service']);
        ///////////////////////////////END SERVICES///////////////////////////////////

        /////////////////////////////// SERVICES DELETE///////////////////////////////////
        Route::get('service-delete/{id}', [ServicesController::class, 'service_delete']);

        Route::post('service-view-modal', [ServicesController::class, 'Service_modal_details']);
        ///////////////////////////////END SERVICES DELETE///////////////////////////////////


        //////////////////////////ARCHIVE SERVICE LIST///////////////////////////////////////
        Route::get('archive-service', [ServicesController::class, 'archive_serviceList']);
        Route::get('service-active/{id}', [ServicesController::class, 'ServiceActive']);

        Route::get('active-archive-services/{id}', [ServicesController::class, 'ServiceActive']);

        ////////////////////////////END ARCHIVE SERVICE LIST////////////////////////////////

        /////////////////////////////SALES MANAGER //////////////////////////////////////////
        Route::get('manager', [ManagerController::class, 'View_manager'])->name('backend.manager.view-manager');
        Route::get('add-manager', [ManagerController::class, 'Add_Manager'])->name('backend.manager.add-manager');
        Route::post('add-manager', [ManagerController::class, 'Create_Manager']);
        Route::get('edit-manager/{id}', [ManagerController::class, 'Edit_manager']);
        Route::post('edit-manager', [ManagerController::class, 'Update_manager']);
        Route::get('manager-delete/{id}', [ManagerController::class, 'Delete_manager']);
        Route::post('change-password-manager', [ManagerController::class, 'Manager_passwordChange']);
        Route::get('archive-manager', [ManagerController::class, 'View_Archive_manager'])->name('backend.manager.archive');
        Route::get('manager-archive-list', [ManagerController::class, 'Manager_archive_list']);
        Route::get('active-manager/{id}', [ManagerController::class, 'Activate_manager']);

        Route::get('manager-meetings/{managerid}', [ManagerController::class, 'Manager_Meeting'])->name('backend.manager.meetings');
        Route::get('manager-meetings-details/{meetingid}', [ManagerController::class, 'Manager_Meeting_Details'])->name('backend.manager.meetings-details');
        Route::get('manager-meetings-archive/{meetingid}', [ManagerController::class, 'Manager_Meeting_Archive'])->name('backend.manager.meetings-archive');
        Route::get('manager-meetings-archive-list', [ManagerController::class, 'Manager_Archive_meeting_List'])->name('backend.manager.meetings-archive-list');
        Route::get('manager-meetings-active/{id}', [ManagerController::class, 'Manager_Meeting_Active'])->name('backend.manager.manager-meetings-active');
        Route::get('manager-coldcall/{managerid}', [ManagerController::class, 'Manager_ColdCall'])->name('backend.manager-coldcall');
        Route::get('manager-coldcall-details/{meetingid}', [ManagerController::class, 'Manager_ColdCall_Details'])->name('backend.manager-coldcall-details');
        Route::get('manager-coldcall-delete/{meetingid}', [ManagerController::class, 'Manager_ColdCall_Delete'])->name('backend.manager-coldcall-delete');
        Route::get('manager-archive-coldcall', [ManagerController::class, 'ManagerColdCall_Archive'])->name('backend.manager-archive-coldcall');
        Route::get('manager-active-coldcall', [ManagerController::class, 'ManagerColdCall_Active'])->name('backend.manager-active-coldcall');

        // employess


       

        

        /////////////////////////////END SALES MANAGER //////////////////////////////////////

        ///////////////////////////////SUPER ADMIN/////////////////////////////////////////////
        Route::get('user-admin', [AdminController::class, 'view_adminUsers']);
        //Route::get('list-admin', [AdminController::class, 'GetData']);
        Route::get('create-admin-user', [AdminController::class, 'add_admin']);
        Route::post('create-admin-users', [AdminController::class, 'Create_admin']);

        Route::get('edit-admin/{id}', [AdminController::class, 'Edit_admin']);
        Route::post('edit-admin-data', [AdminController::class, 'Update_Admin']);
        //////////////////////////////////END SUPER ADMIN//////////////////////////////////////

        //////////////////////////////////////BDE MANAGER///////////////////////////////////////////////////
        Route::get('bde', [bdeController::class, 'View_bde'])->name('backend.bde.view-bde');
        Route::get('add-bde', [bdeController::class, 'Add_bde'])->name('backend.add-bde');
        Route::post('add-bde', [bdeController::class, 'Post_bde']);
        Route::get('edit-bde/{id}', [bdeController::class, 'Edit_bde']);
        Route::post('edit-bde', [bdeController::class, 'Update_bde']);
        Route::get('bde-delete/{id}', [bdeController::class, 'BDE_delete']);
        Route::post('change-password-bde', [bdeController::class, 'BDE_password_update']);
        Route::get('archive-bde', [bdeController::class, 'view_archive_bde'])->name('backend.archive-bde');
        Route::get('archive-bdedata', [bdeController::class, 'view_archive_bdedata']);
        Route::get('active-bde/{id}', [bdeController::class, 'Active_bde']);

        Route::get('bde-meetings/{bdeid}', [bdeController::class, 'Bde_Meetings'])->name('backend.bde-meetings');
        Route::get('bde-meetings-details/{meetingid}', [bdeController::class, 'Bde_Meetings_Details'])->name('backend.bde-meeting-details');
        Route::get('bde-meetings-delete/{meetingid}', [bdeController::class, 'Bde_Meetings_Delete'])->name('backend.bde-meeting-delete');
        Route::get('bde-meetings-archive', [bdeController::class, 'Bde_Meetings_Archive'])->name('backend.bde-meetings-archive');
        Route::get('bde-meetings-active/{id}', [bdeController::class, 'Bde_Meetings_Active'])->name('backend.bde-meetings-active');

        Route::get('bde-coldcall', [bdeController::class, 'Bde_ColdCall'])->name('backend.bde-coldcall');
        Route::get('bde-coldcall-details', [bdeController::class, 'Bde_ColdCall_Details'])->name('backend.bde-coldcall-details');
        Route::get('bde-coldcall-delete', [bdeController::class, 'Bde_ColdCall_Delete'])->name('backend.bde-coldcall-delete');
        Route::get('bde-coldcall-archive', [bdeController::class, 'Bde_ColdCall_Archive'])->name('backend.bde-coldcall-archive');
        Route::get('bde-coldcall-active', [bdeController::class, 'Bde_ColdCall_Active'])->name('backend.bde-coldcall-active');
        //////////////////////////////////////END BDE MANAGER///////////////////////////////////////////////////

        /////////////////////////////////////CALLING HISTOEY////////////////////////////////////////////////////
        Route::get('calling-list', [CallingController::class, 'Calling_list'])->name('backend.calllist');
        Route::get('calling-lists', [CallingController::class, 'Calling_list_DataTAble']);
        Route::get('add-call', [CallingController::class, 'Add_call'])->name('backend.addcall');
        Route::post('add-call', [CallingController::class, 'Add_Call_submit']);

        Route::get('edit-call/{id}', [CallingController::class, 'Edit_calling']);
        Route::post('edit-call', [CallingController::class, 'Update_calling']);
        Route::get('delete-call/{id}', [CallingController::class, 'Delete_calling']);
        Route::get('archive-calling', [CallingController::class, 'Archive_callingList'])->name('backend.archive-calling');
        Route::get('Active-call', [CallingController::class, 'Active_callingList'])->name('backend.active-calling');

        /***************************************CHECK-AVAILABLITY***************************/

        Route::get('check-availability', [CallingController::class, 'Check_availability']);
        Route::post('filter-call', [CallingController::class, 'Filter_call_data']);

        /***************************************END CHECK-AVAILABLITY***************************/

        /////////////////////////////////////END CALLING HISTOEY////////////////////////////////////////

        ////////////////////////////////////CLIENT ADD//////////////////////////////////////////////////
      

        

        Route::post('type-of-user', [Admin_client_controller::class, 'Type_Of_UserData'])->name('backend.client.type-of-user');

        ////////////////////////////////////CLIENT ADD//////////////////////////////////////////////////

        ////////////////////////////////////ADD COLD CALL//////////////////////////////////////////////////
        Route::get('view-cold-call', [ColdCallcontroller::class, 'ColdCalls'])->name('backend.view-cold-call');
        Route::get('add-cold-calls', [ColdCallcontroller::class, 'Add_ColdCalls'])->name('backend.add-cold-calls');
        Route::post('add-cold-calls', [ColdCallcontroller::class, 'Create_ColdCalls'])->name('backend.submit-add-coldcall');
        Route::get('edit-coldcall/{id}', [ColdCallcontroller::class, 'Edit_coldcall'])->name('backend.edit-coldcall');
        Route::post('edit-coldcall', [ColdCallcontroller::class, 'update_coldcall'])->name('backend.update-coldcall');
        Route::get('delete-cold-call/{id}', [ColdCallcontroller::class, 'Delete_coldcall'])->name('backend.delete-cold-call');
        Route::get('archive-cold-call', [ColdCallcontroller::class, 'Archive_cold_cold'])->name('backend.archive-cold-call');
        Route::get('active-cold-call/{id}', [ColdCallcontroller::class, 'Active_cold_cold']);

        Route::get('add-service-coldcall', [ColdCallcontroller::class, 'AdminColdCall_AddService'])->name('backend.add-service-coldcall');
        Route::post('service-coldcall-submit', [ColdCallcontroller::class, 'AdminColdCall_ServiceSubmit'])->name('backend.service-coldcall-submit');
        Route::post('service-coldcall-discount', [ColdCallcontroller::class, 'AdminColdCall_ServiceDiscount'])->name('backend.service-coldcall-discount');
        Route::post('service-coldcall-delete', [ColdCallcontroller::class, 'AdminColdCall_ServiceDelete'])->name('backend.service-coldcall-delete');
        Route::get('service-coldcall-details', [ColdCallcontroller::class, 'AdminColdCall_ServiceDetails'])->name('backend.service-coldcall-details');
        ////////////////////////////////////END COLD CALL/////////////////////////////////////////////

        //////////////////////////////MEETING//////////////////////////////////////////////////////////
        Route::get('view-meeting', [Meeting_Controller::class, 'ViewMeeting'])->name('backend.view-meeeting');
        Route::get('add-meeting', [Meeting_Controller::class, 'Add_meeting'])->name('backend.add-meeting');
        Route::post('add-meeting', [Meeting_Controller::class, 'CreateMeeting'])->name('backend.add-meeting-post');
        Route::get('edit-meeting/{id}', [Meeting_Controller::class, 'Edit_meeting_Data'])->name('backend.edit-meeting');
        Route::post('edit-meeting', [Meeting_Controller::class, 'Update_meeting_Data'])->name('backend.update-meeting');

        Route::get('delete-meeting/{id}', [Meeting_Controller::class, 'DeleteMeeting_Data'])->name('backend.delete-meeting');
        Route::get('view-archive-meeting', [Meeting_Controller::class, 'View_archive_meeting'])->name('backend.archive-meeting');
        Route::get('active-meeting/{id}', [Meeting_Controller::class, 'ActiveMeeting'])->name('backend.active-meeting');


        Route::get('add-meeting-service', [Meeting_Controller::class, 'AddMeetingService'])->name('backend.add-meeting-service');
        Route::post('meeting-service-submit', [Meeting_Controller::class, 'AdminMeetingServiceSubmit'])->name('backend.meeting-service-submit');
        Route::post('meeting-service-discount', [Meeting_Controller::class, 'AdminMeetingServiceDiscount'])->name('backend.meeting-service-discount');
        Route::post('meeting-service-delete', [Meeting_Controller::class, 'AdminMeetingServiceDelete'])->name('backend.meeting-service-delete');
        Route::get('meeting-details', [Meeting_Controller::class, 'AdminMeetingDetails'])->name('backend.meeting-details');

        /******************************report meeting************************************************* */
        Route::get('meeting-report', [Meetings_ReportController::class, 'Show_meetingPage'])->name('backend.meeting-report');
        Route::post('report-meeting-data', [Meetings_ReportController::class, 'Check_Meeting_Data'])->name('backend.report-meeting-data');
        Route::post('meeting-report', [Meetings_ReportController::class, 'Filter_Meeting_Data'])->name('backend.filter-meeting');
        /******************************end report meeting********************************************** */

        /******************************report cold call********************************************** */
        Route::get('report-coldcall', [Meetings_ReportController::class, 'REPORT_COLDCALL'])->name('backend.coldcall-report');
        Route::post('filter-coldcall-data', [Meetings_ReportController::class, 'Filter_Coldcall_Data']);
        Route::post('report-coldcall', [Meetings_ReportController::class, 'REPORT_COLDCALL_GENERATE'])->name('backend.filter-coldcall');
        /******************************end report cold call****************************************** */


        //////////////////////////////END MEETING/////////////////////////////////////////////////


        ////////////////////////////STAFF ROLE ///////////////////////////////////////////////////

        Route::get('staff-roles', [StaffController::class, 'view']);
        Route::get('add-roles', [StaffController::class, 'add']);
        Route::post('add-roles', [StaffController::class, 'Add_staff']);

        Route::get('edit-staff-role/{id}', [StaffController::class, 'Edit_Rolls']);
        Route::post('edit-staff-role', [StaffController::class, 'Update_role']);

        Route::get('archive-role-staff', [StaffController::class, 'Archive_role_staff']);
        Route::get('active-roles/{id}', [StaffController::class, 'Active_role']);
        ////////////////////////////END STAFF ROLE /////////////////////////////////////////////////////

        //////////////////////////////CUSTOMERS//////////////////////////////////////////////////////////////////
        Route::get('view-customers', [CustomersController::class, 'Customers'])->name('backend.view-customers');
        Route::get('add-customer', [CustomersController::class, 'Add_Customer'])->name('backend.add-customer');
        Route::post('add-customer', [CustomersController::class, 'Add_Submit_Customer'])->name('backend.submit-customer');

        Route::get('edit-customer/{id}', [CustomersController::class, 'Edit_Customer']);
        Route::post('edit-customer', [CustomersController::class, 'Update_customers']);

        Route::get('delete-customer/{id}', [CustomersController::class, 'delete_customers'])->name('backend.delete-customers');

        Route::get('archive-customers', [CustomersController::class, 'Archive_customers'])->name('backend.archive-customers');
        Route::get('active-customer/{id}', [CustomersController::class, 'Active_Customer'])->name('backend.active-customers');

        Route::post('customer-view-details', [CustomersController::class, 'Customers_details_modal']);

        //////////////////////////////////END CUSTOMERS/////////////////////////////////////////////////////////////

        /////////////////////////////////////BILL PAY//////////////////////////////////////////////////////
        Route::get('bill-pay/{id}', [AdminBillPayController::class, 'Bill_payment_Bde'])->name('backend.bill-pay');
        Route::post('add-mpayment', [AdminBillPayController::class, 'Add_payment_Bde'])->name('backend.add-mpayment');
        /////////////////////////////////////BILL PAY//////////////////////////////////////////////////////

        ///////////////////////////////////END GROUPING/////////////////////////////////////////////////
    });
});




//////////////////////////////////////////////END BACKEND CODE/////////////////////////////////////////////







///////////////////////////////////START MANAGEREND ////////////////////////////////////////////////////////

/*************************MANAGER LOGIN*********************************** */
Route::get('manager/', function () {
    return redirect('manager/login');
    // akash
});
Route::get('manager/login', [ManagerLoginController::class, 'Manager_Login'])->name('Manager_Login');
Route::match(['get' , 'post'] ,'manager/logins', [ManagerLoginController::class, 'Manager_Login_submit'])->name('Manager_Login_submit');

/*************************END MANAGER LOGIN*********************************** */
Route::prefix('manager')->middleware(['auth:manager'])->group(function () {
// Route::middleware('managerwebgaurd')->group(function () {

    // Route::group(['prefix' => 'manager/'], function () {

        // Route::get('deshboard', function () {
        //     return view('managerend.manager-desh');
        // });

        Route::controller(attendancecontroller::class)->group(function(){

            Route::match(['get' , 'post'], 'hiring' , 'hiring')->name('hiring');
            Route::match(['get' , 'post'], 'hiring/save' , 'hiringSave')->name('hiring-save');
    
        });


        
Route::controller(statusController::class)->group(function(){

    Route::match(['get', 'post'], 'manager/device/access', 'managerdivice')->name('manager.divice');
    Route::match(['get', 'post'], 'manager/device/add', 'add_divice')->name('add_divice');
    // Route::match(['get', 'post'], 'admin/device/adds', 'adddivices')->name('adddivice');
    // Route::match(['get', 'post'], 'admin/device/list', 'assestviewDevice')->name('assest-viewDevice');

});

        Route::controller(leavecontroller::class)->group(function(){

            Route::match(['get', 'post'], '/leave', 'managerleave')->name('managerleave');
            Route::match(['get', 'post'], '/Addleave', 'managerAddleave')->name('manageradd-leave');
            Route::match(['get', 'post'], '/leaveAjax', 'managerleaveAjax')->name('managerleave-leave');
    
        });

        Route::controller(attendancecontroller::class)->group(function(){

            Route::match(['get', 'post'], 'manager/attendances', 'manager_attendance')->name('manager_attendance');
            // Route::match(['get' , 'post'], 'admin/delete-attenance' , 'deleteattenance')->name('delete-attenance');
            // Route::match(['get', 'post'], 'admin/attendance/list', 'Admin_attendance_view')->name('Admin_attendance_view');

            Route::match(['get' , 'post'], 'hiring' , 'hiring')->name('hiring');
    
        });

        
Route::controller(employeecontroller::class)->group(function(){

    
    // Route::match(['get', 'post'], '/userChangepass', 'userChangepass')->name('userChangepass');

    Route::match(['get', 'post'], '/employees', 'manageremployee')->name('manager-employee');
    Route::match(['get', 'post'], '/add/employee', 'manageraddemployee')->name('manager-add-employee');
    Route::match(['get', 'post'], '/addemployees', 'manageraddemployees')->name('manager-addemployees');
    Route::match(['get', 'post'], '/view/employee', 'managerviewemployee')->name('manager-view-employee');
    Route::match(['get', 'post'], '/delet/employee', 'managerdeleteemployee')->name('managermanager-deleteemployee');
    Route::match(['get', 'post'], '/delete/employee', 'managerarchiveemployee')->name('manager-archiveemployee');
    Route::match(['get', 'post'], '/delete/employee/view', 'managerarchiveemployeeview')->name('manager-archiveemployeeview');
    Route::match(['get', 'post'], '/employee/edit', 'managerupdate_employee')->name('manager-update_employee');
    Route::match(['get', 'post'], '/employee/update', 'managerupdateemp')->name('manager-adminupdateemp');

    Route::match(['get', 'post'], '/employees/change/status', 'manageremployeechangeStatus')->name('manager-employee-changeStatus');



});

        Route::get('deshboard', [ManagerHomeController::class, 'MANAGER_HOME'])->name('manager.home');
        Route::post('recent-manager-meeting-data', [ManagerHomeController::class, 'RECENT_MEETING_MANAGER'])->name('manager.recent-meeting-data');

        Route::get('logout-manager', [ManagerLoginController::class, 'Manager_logout']);

        /***********************PROFILE UPDATE**************************************************** */
        Route::get('m-profile', [ManagerProfileController::class, 'Manager_Profile']);
        Route::post('m-profile', [ManagerProfileController::class, 'Manager_Profile_Update']);
        /*********************** END PROFILE UPDATE************************************************* */
        /*****************************cold call***************************************************** */
        Route::get('cold-call', [ManagerColdCallController::class, 'ManagerColdCall'])->name('manager.coldcall');
        Route::post('cold-call', [ManagerColdCallController::class, 'Create_ManagerColdCall'])->name('manager.coldcall-submit');
        Route::get('view-cold-call', [ManagerColdCallController::class, 'View_Manager_coldcall'])->name('manager.view-coldcall');
        Route::get('edit-mcold-call/{id}', [ManagerColdCallController::class, 'Edit_Manager_coldcall'])->name('manager.edit-mcold-call');
        Route::post('edit-mcold-call', [ManagerColdCallController::class, 'Update_Manager_coldcall'])->name('manager.update-coldcall');

        Route::get('mcold-call-delete/{id}', [ManagerColdCallController::class, 'ManagerColdCall_delete'])->name('manager.delete-coldcall');
        Route::get('archive-cold-call', [ManagerColdCallController::class, 'Archive_Mcold_Call'])->name('manager.archive-coldcall');
        Route::get('mcold-call-active/{id}', [ManagerColdCallController::class, 'Active_Mcold_Call'])->name('manager.active-coldcall');

        /************************************ service add**************************************** */
        Route::get('add-coldcall-service', [ManagerColdCallController::class, 'AddManagerColdcallService'])->name('manager.add-coldcall-service');
        Route::post('add-coldcall-submit', [ManagerColdCallController::class, 'ManagerColdCallServiceSUBMIT'])->name('manager.add-coldcall-submit');
        Route::post('coldcall-service-discount', [ManagerColdCallController::class, 'ManagerColdCallServiceDiscount'])->name('manager.coldcall-service-discount');
        Route::post('coldcall-service-delete', [ManagerColdCallController::class, 'ManagerColdCallServiceDelete'])->name('manager.coldcall-service-delete');
        Route::get('manager-coldcall-details', [ManagerColdCallController::class, 'ManagerColdCallDetails'])->name('manager.manager-coldcall-details');

        /************************************end service add*************************************** */

        /*****************************cold call******************************************************** */
        /*************************manager assign meeting*********************************************** */
        Route::get('view-massign-meeting', [ManagerAssignMeetingController::class, 'View_Manager_Assign_Meating'])->name('manager.massign-meeting');
        Route::get('edit-massign-meeting/{id}', [ManagerAssignMeetingController::class, 'Edit_Massign_meeting'])->name('manager.edit-massign-meeting');
        Route::post('edit-massign-meeting', [ManagerAssignMeetingController::class, 'Add_assign_meeting'])->name('manager.attend-meeeting');

        Route::match(['get' , 'post'] ,'manager/report/employee', [ManagerAssignMeetingController::class, 'manager_repoer'])->name('manager.report');
        Route::match(['get' , 'post'] ,'manager/report/employee/data', [ManagerAssignMeetingController::class, 'manager_data'])->name('manager_data');

        Route::post('selectservice-getprice', [ManagerAssignMeetingController::class, 'Select_servicePrice'])->name('manager.select-service-getPrice');

        Route::post('views-clients-data', [ManagerAssignMeetingController::class, 'Model_viewClientData']);
        /************************* end manager assign meeting****************************************** */

        /**********************************manager telemarketing team*************************************** */
        Route::get('view-tele-team', [Manager_Tele_teamController::class, 'Manager_Tele_team']);
        Route::get('madd-tele-team', [Manager_Tele_teamController::class, 'Add_Manager_Tele_team']);
        Route::post('madd-tele-team', [Manager_Tele_teamController::class, 'Submit_Manager_Tele_team']);
        Route::get('edit-mtele-team/{id}', [Manager_Tele_teamController::class, 'Edit_Manager_Tele_team']);
        Route::post('edit-mtele-team', [Manager_Tele_teamController::class, 'Update_Manager_Tele_team']);

        Route::get('mtele-delete-team/{id}', [Manager_Tele_teamController::class, 'Manager_Tele_Delete']);
        Route::get('archive-mtele-team', [Manager_Tele_teamController::class, 'Manager_Tele_Archive']);
        Route::get('mactive-tele-team/{id}', [Manager_Tele_teamController::class, 'Manager_Tele_Active']);

        Route::get('password-tele-team', [Manager_Tele_teamController::class, 'Manager_Tele_Password']);

        Route::post('view-details-tele-team', [Manager_Tele_teamController::class, 'view_details_teleMteam_modal']);
        /**********************************manager telemarketing team*************************************** */




        /**********************************manager marketing team*************************************** */

        Route::controller(attendancecontroller::class)->group(function(){

            Route::match(['get', 'post'], 'manager/attendance', 'mattendance')->name('mattendance');

        });


        Route::get('view-market-mteam', [Manager_market_teamController::class, 'Manager_View_marketTeam']);
        Route::get('add-market-mteam', [Manager_market_teamController::class, 'Manager_Market_team']);
        Route::post('add-market-mteam', [Manager_market_teamController::class, 'Manager_Market_team_submit']);
        Route::get('edit-market-mteam/{id}', [Manager_market_teamController::class, 'Edit_market_manager_team']);
        Route::post('edit-market-mteam', [Manager_market_teamController::class, 'Update_market_manager_team']);
        Route::get('delete-market-mteam/{id}', [Manager_market_teamController::class, 'Delete_market_manager_team']);

        Route::get('archive-market-mteam', [Manager_market_teamController::class, 'Archive_market_manager_team']);
        Route::get('active-market-mteam/{id}', [Manager_market_teamController::class, 'Active_market_manager_team']);

        Route::post('change-pass-market-mteam', [Manager_market_teamController::class, 'Password_market_manager_team']);

        Route::post('view-details-market-mteam', [Manager_market_teamController::class, 'view_details_market_Mteam_modal']);
        /**********************************manager marketing team*************************************** */

        /********************************meeting manager************************************************ */
        Route::get('view-meeting-manager', [ManagerMeetingController::class, 'View_meeting_manager'])->name('manager.view-meeting-manager');
        Route::get('edit-meeting-manager/{id}', [ManagerMeetingController::class, 'Edit_meeting_manager'])->name('manager.Edit-meeting-manager');
        Route::post('edit-meeting-manager', [ManagerMeetingController::class, 'Update_meeting_manager'])->name('manager.meeting-update');
        Route::get('archive-meeting-manager', [ManagerMeetingController::class, 'Archive_meeting_manager'])->name('manager.archive-meeting');
        Route::get('delete-meeting-manager/{id}', [ManagerMeetingController::class, 'Delete_meeting_manager']);
        Route::get('active-meeting-manager/{id}', [ManagerMeetingController::class, 'Active_meeting_manager']);
        Route::post('meeting-view-data', [ManagerMeetingController::class, 'MeetinModalData'])->name('manager.meeting-modelData');

        Route::get('add-meeting-service', [ManagerMeetingController::class, 'ManagerAddMeetingService'])->name('manager.add-meeting-service');
        Route::post('meeting-service-submit', [ManagerMeetingController::class, 'ManagerAddMeetingSubmit'])->name('manager.submit-meeting-service');
        Route::post('meeting-service-discount', [ManagerMeetingController::class, 'ManagerAddMeetingDiscount'])->name('manager.discount-meeting-service');
        Route::post('delete-meeting-service', [ManagerMeetingController::class, 'ManagerAddMeetingDelete'])->name('manager.delete-meeting-service');
        Route::get('manager-meeting-details', [ManagerMeetingController::class, 'ManagerAddMeetingDetails'])->name('manager.manager-meeting-details');


        /************************************select service get price**************************************** */
        Route::post('meeting-service-getprice', [ManagerMeetingController::class, 'SelectServiceGet_price'])->name('manager.meeting.select-service-getprice');
        /************************************end select service get price*************************************** */
        /********************************end meeting manager************************************************ */


        /********************************manager bill pay******************************************************* */
        Route::get('bill-pay/{id}', [ManagerBillPayController::class, 'Bill_payment_Manager'])->name('manager.bill-payment');
        Route::post('add-mpayment/{meeting_id}', [ManagerBillPayController::class, 'Add_payment_manager']);
        /**********************************end manager bill pay************************************************* */
        /****************************select client get company**************************************** */
        Route::post('selectclientcompany', [ManagerMeetingController::class, 'Select_ClientGet_Company']);
        /*****************************end client get company****************************************** */

        /********************************manager meeting report**************************************** */
        Route::get('meeting-report', [Manager_meeting_ReportController::class, 'MANAGER_MEETING_REPORT'])->name('manager.meeting-report');
        Route::post('meeting-report', [Manager_meeting_ReportController::class, 'MANAGER_MEETING_REPORT_GENERATE'])->name('manager.meeting-report-generate');
        Route::get('coldcall-report', [Manager_meeting_ReportController::class, 'MANAGER_COLDCALL_REPORT'])->name('manager.coldcall-report');
        Route::post('coldcall-report', [Manager_meeting_ReportController::class, 'MANAGER_COLDCALL_REPORT_GENERATE'])->name('manager.coldcall-reportGenerate');
        Route::get('total-meetings-report', [Manager_meeting_ReportController::class, 'MANAGER_TOTAL_REPORT_MEETINGS'])->name('manager.total-mettingReport');
        Route::post('total-meetings-report', [Manager_meeting_ReportController::class, 'MANAGER_TOTAL_REPORT_GENERATE'])->name('manager.total-meeting-Generate');


        /********************************end manager meeting report**************************************************** */
    // });
});
///////////////////////////////////END MANAGEREND ////////////////////////////////////////////////////////




//////////////////////////////////////// START BDE CODE///////////////////////////////////////////////////
/************************************* bde login***************************************************** */

/************************************* bde login***************************************************** */
Route::get('bde/', function () {
    return redirect('bde/login');
});
Route::get('bde/login', [BdeLoginController::class, 'Bde_Login']);
Route::post('bde/login', [BdeLoginController::class, 'Bde_Login_submit']);

/**********************************end bde login***************************************************** */
Route::middleware('bdewebgaurd')->group(function () {

    Route::group(
        ['prefix' => 'bde/'],
        function () {
            // Route::get('deshboard', function () {
            //     return view('bdend.bde-desh');
            // });
            Route::get('deshboard', [Bde_HomeController::class, 'BDE_HOME']);
            Route::post('recent-bde-meeting-data', [Bde_HomeController::class, 'RECENT_MEETING_BDE'])->name('bde.recent-meeting');

            Route::get('logout-bde', [BdeLoginController::class, 'Bde_logout']);
            /**************************************cold call********************************************************** */

            /**************************************bde assign meeting********************************************************** */
            Route::get('bde-assign-meeting', [BdeAssignMeetingController::class, 'SHOW_BDE_ASSIGN_MEETING'])->name('bde.show-assign-meeting');
            Route::get('assign-meeting/{id}', [BdeAssignMeetingController::class, 'EDIT_BDE_Assign_Meeting'])->name('bde.assign-meeting');
            Route::post('assign-meeting', [BdeAssignMeetingController::class, 'UPDATE_BDE_Assign_Meeting'])->name('bde.update-assign-meeting');
            Route::post('view-client-data', [BdeAssignMeetingController::class, 'ModelBde_viewClientData'])->name('bde.view-client-data');
            Route::post('selectservice-getprice', [BdeAssignMeetingController::class, 'BDESelect_servicePrice']);
            /**************************************end bde-assign meeting********************************************************** */

            Route::get('view-bde-coldcall', [BdeColdcallController::class, 'View_Bde_ColdCall'])->name('bde.view-coldcall');
            Route::get('archive-bde-coldcall', [BdeColdcallController::class, 'Archive_Bde_ColdCAll'])->name('bde.archive-coldcall');
            Route::get('add-bde-coldcall', [BdeColdcallController::class, 'Add_bde_coldcall'])->name('bde.add-bde-coldcall');
            Route::post('add-bde-coldcall', [BdeColdcallController::class, 'Submit_Bde_ColdCall'])->name('bde.coldcall-submit');
            Route::get('edit-bde-coldcall/{id}', [BdeColdcallController::class, 'Edit_Bde_ColdCall']);
            Route::post('edit-bde-coldcall', [BdeColdcallController::class, 'Update_Bde_ColdCall'])->name('bde.update-coldcall');
            Route::get('delete-bde-coldcall/{id}', [BdeColdcallController::class, 'Delete_Bde_ColdCall']);
            Route::get('active-bde-coldcall/{id}', [BdeColdcallController::class, 'Active_Bde_ColdCall']);
            Route::get('coldcall-service', [BdeColdcallController::class, 'AddColdcallService'])->name('bde.add-coldcall-service');
            Route::post('coldcall-service-submit', [BdeColdcallController::class, 'AddColdcallServiceSubmit'])->name('bde.coldcall-service-submit');
            Route::post('coldcall-service-discount', [BdeColdcallController::class, 'AddColdcallServiceDiscount'])->name('bde.coldcall-service-discount');
            Route::post('coldcall-service-delete', [BdeColdcallController::class, 'AddColdcallServiceDelete'])->name('bde.coldcall-service-delete');
            Route::get('coldcall-details', [BdeColdcallController::class, 'BdeColdCallDetails'])->name('bde.coldcall-details');


            /**************************************end cold call****************************************************** */

            /********************************Bde meeting ************************************************************ */
            Route::get('view-bde-meeting', [BdeMeetingController::class, 'View_Bde_Meeting'])->name('bde.view-bde-meeting');
            Route::get('add-bde-meeting', [BdeMeetingController::class, 'Add_Bde_Meeting'])->name('bde.add-bde-meeting');
            Route::post('add-bde-meeting', [BdeMeetingController::class, 'Submit_Bde_Meeting']);
            Route::get('edit-bde-meeting/{id}', [BdeMeetingController::class, 'Edit_Bde_Meeting'])->name('bde.edit-bde-meeting');
            Route::post('edit-bde-meeting', [BdeMeetingController::class, 'Update_Bde_Meeting'])->name('bde.meeting-update');
            Route::get('delete-bde-meeting/{id}', [BdeMeetingController::class, 'Delete_Bde_Meeting']);
            Route::get('archive-bde-meeting', [BdeMeetingController::class, 'Archive_Bde_Meeting'])->name('bde.archive-bde-meeting');
            Route::get('active-bde-meeting/{id}', [BdeMeetingController::class, 'Active_Bde_Meeting']);

            /******************************bde meeting service adding***********************************************************/
            Route::get('add-meeting-service', [BdeMeetingController::class, 'AddBdeMeetingService'])->name('bde.add-meeting-service');
            Route::post('meeting-service-submit', [BdeMeetingController::class, 'BdeMeetingServiceSubmit'])->name('bde.meeting-service-submit');
            Route::post('meeting-service-discount', [BdeMeetingController::class, 'BdeMeetingServiceDiscount'])->name('bde.meeting-service-discount');
            Route::post('meeting-service-delete', [BdeMeetingController::class, 'BdeMeetingServiceDelete'])->name('bde.meeting-service-delete');
            Route::get('meeting-details', [BdeMeetingController::class, 'BdeMeetingDetails'])->name('bde.meeting-details');

            /******************************bde meeting service adding***********************************************************/
            /********************************end Bde meeting********************************************************** */

            /*****************************Bde profile***************************************************** */
            Route::get('profile', [BdeProfileController::class, 'Bde_Profile']);
            Route::post('profile', [BdeProfileController::class, 'Bde_Profile_Submit']);
            /*****************************End Bde profile************************************************* */
            /********************************bde bill pay******************************************************* */
            Route::get('bill-pay-bde/{id}', [BdeBillPayController::class, 'Bill_payment_Bde'])->name('bde.bill-pay');
            Route::post('add-mpayment-bde/{meeting_id}', [BdeBillPayController::class, 'Add_payment_Bde']);
            /**********************************end bde bill pay************************************************* */

            /***********************************meeting report*********************************************** */
            Route::get('meeting-bde-report', [Bde_Meeting_reportController::class, 'MEETING_BDE_REPORT'])->name('bde.meeting-report');
            Route::post('meeting-bde-report', [Bde_Meeting_reportController::class, 'MEETING_BDE_REPORT_GENERATE'])->name('bde.meeting-report-generate');
            Route::get('report-coldcall-bde', [Bde_Meeting_reportController::class, 'COLDCALL_BDE_REPORT'])->name('bde.report-coldcall');
            Route::post('report-coldcall-bde', [Bde_Meeting_reportController::class, 'COLDCALL_BDE_REPORT_GENERATE'])->name('bde.coldcall-report-generate');
            Route::get('total-meeting-report', [Bde_Meeting_reportController::class, 'TOTAL_BDE_REPORT'])->name('bde.total-meeting-report');
            Route::post('total-meeting-report', [Bde_Meeting_reportController::class, 'TOTAL_BDE_REPORT_GENERATE'])->name('bde.total-meeting-report-generate');
            /***********************************end meeting report******************************************** */
        }
    );
});
////////////////////////////////////////BDE CODE///////////////////////////////////////////////////////////
