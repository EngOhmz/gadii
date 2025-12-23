<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controller\FarmerController;
use App\Http\Controller\CargoController;
use App\Http\Controller\CF\CFserviceController;
use App\Http\Controller\GroupController;
use App\Http\Controller\MemberController;
use App\Http\Controller\LandController;
use App\Http\Controller\SupplierController;
use App\Http\Controller\ProductController;
use App\Http\Controller\UnitController;
use App\Http\Controller\PurchaseController;
use App\Http\Controller\SalesController;
use App\Http\Controllers\AzamPesa\IndexController; 
use App\Http\Controllers\AzamPesa\IntegrationDepositController;
use App\Http\Controller\Single_warehouseController;
use App\Http\Controller\Orders_Client_ManipulationsController;
use App\Http\Controller\Warehouse_backendController;
use App\Http\Controllers\ManagementIssue\ExpireUserController;

use App\Http\Controllers\SmsController;

//use ;
use App\Models\Counter;
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




Route::get('/send-sms', [SmsController::class, 'showForm'])->name('sms.form');
Route::post('/send-sms/single', [SmsController::class, 'sendSingle'])->name('send.sms.single');
Route::post('/send-sms/bulk', [SmsController::class, 'sendBulk'])->name('send.sms.bulk');

Auth::routes();
Route::get('/',"HomeController@index")->name('home')->middleware('auth');
Route::any('tracking',"Courier\CourierMovementController@tracking")->name('tracking');
Route::get('view_features',"RoleController@view")->name('view_features');
Route::get('format_number',"HomeController@format_number")->name('format_number')->middleware('auth');

Route::resource('addShortCut',"ShortCutController")->middleware('auth');
Route::get('shortCutModal', 'ShortCutController@discountModal')->middleware('auth');
Route::post('shortCut_details', 'ShortCutController@save_details')->name('save.shortCut_details')->middleware('auth');
Route::get('save_shortCut_supplier', 'ShortCutController@save_supplier')->middleware('auth');

Route::get('subscribe', 'ShortCutController@subscribe')->name('subscribe')->middleware('auth');
Route::get('forgetPassword', 'Auth\RegisterController@forgetPassword')->name('forgetPassword');
Route::get('verify_user', 'Auth\RegisterController@verify_user')->name('verify_user');
Route::get('otp', 'Auth\RegisterController@otp')->name('otp');
Route::post('get_otp', 'Auth\RegisterController@get_otp')->name('get_otp');
Route::get('verify_otp', 'Auth\RegisterController@verify_otp')->name('verify_otp');
Route::post('update_user', 'Auth\RegisterController@update_user')->name('update_user');

Route::group(['prefix' => 'subscription'], function () {
Route::any('subscription_list',"ReportController@subscription")->name('subscription')->middleware('auth');;
Route::any('subscription_report',"ReportController@subscription_report")->name('subscription_report')->middleware('auth');;
Route::any('expired_users',"ReportController@expired_users")->name('expired_users')->middleware('auth');
Route::get('subModal', 'ReportController@discountModal')->middleware('auth');
Route::post('adjust','ReportController@adjust')->name('subscription.adjust')->middleware('auth');
Route::get('deposit', 'ReportController@deposit')->name('subscription.deposit')->middleware('auth');
Route::post('save_deposit','ReportController@save_deposit')->name('subscription.save_deposit')->middleware('auth');
Route::post('send_sms','ReportController@send_sms')->name('subscription.send_sms')->middleware('auth');

Route::get('expire', [ExpireUserController::class, 'sms_index'])->name('expired_users.index'); 
Route::post('expire_store', [ExpireUserController::class, 'sms_store'])->name('expired_users.store');
 
 
});
Route::get('enhacement', 'RoleController@enhacement')->name('enhacement')->middleware('auth');

//testing input
Route::group(['prefix' => 'testing_input'], function () {
Route::get('file-import','Admin\JournalImportController@importView')->name('import-view');
Route::post('import','Admin\JournalImportController@import')->name('import');
Route::post('sample','Admin\JournalImportController@sample')->name('sample');
});

//change password

Route::get('change_password', 'HomeController@showChangePswd');

Route::post('change_password_store', 'HomeController@changePswd')->name('changePswdPost');

//get email and phone  

Route::get('register/phonefind', 'Auth\RegisterController@phonefind'); 

Route::get('register/emailfind', 'Auth\RegisterController@emailfind');



//madekenya

Route::resource('list_ya_wateja','CargoAgency\Customer\CustomerList');
Route::get('list_ya_wateja/{id}/detail','CargoAgency\Customer\CustomerList@detail')->name('list_ya_wateja.detail')->middleware('auth');
Route::get('/sajili_mizigo','CargoAgency\HomeController@index')->name('sajili_mizigo');

Route::get('list_ya_wateja/{id}/editmzigo','CargoAgency\DashboardController@editmzigo')->name('list_ya_wateja.editmzigo')->middleware('auth');
Route::post('mizigo_update','CargoAgency\DashboardController@editmzigolist')->name('mizigo.kuongeza');



Route::resource('users', 'UsersController');
Route::get('auditing', 'SysAuditingController@index')->name('system.auditing');



Route::group(['prefix' => 'staffs'], function(){
    
Route::resource('dashboard','CargoAgency\DashboardController');

    });

Route::get('temp_pacel_delete/{id}/delete','CargoAgency\DashboardController@temp_pacel_delete')->name('temp_pacel_delete');


// Route::get('schedule', )  
// Route::get('/schedule', [App\Http\Controllers\CompanyDeclarationController::class, 'schedule'])->name('schedule');


//management driver and car route

Route::group(['prefix' => 'management'], function(){


Route::resource('assets', 'Assets\AssetsController')->middleware('auth');


Route::resource('car','CargoAgency\Management\CarController');
Route::get('arrived_car','CargoAgency\Management\CarController@arrived')->name('arrived_car');

Route::post('arrived_car_store','Management\CarController@arrived_car_store')->name('arrived_car_store');

Route::get('all_car','CargoAgency\Management\CarController@all')->name('all_car');
Route::get('car_today2','CargoAgency\Management\CarController@car_today')->name('car_today2');
Route::get('car_today_routes/{id}/show','CargoAgency\Management\CarController@car_today_routes')->name('car_today_routes');

Route::get('car_pacel_detail/{id}/{date}/{date2}/index','CargoAgency\Management\CarController@car_pacel_detail')->name('car_pacel_detail');


 Route::get('findNameItem', 'CargoAgency\DashboardController@findNameItem')->name('findNameItem');

 Route::get('findNameItem2', 'CargoAgency\DashboardController@findNameItem2')->name('findNameItem2');


Route::get('old_car','CargoAgency\Management\CarController@old')->name('old_car');
Route::get('car_routes','CargoAgency\Management\CarController@car_routes')->name('car_routes');
Route::get('car_pacel','CargoAgency\Management\CarController@car_pacel')->name('car_pacel');
Route::get('search_store', 'CargoAgency\Management\CarController@customer_history')->name('search_view');
Route::get('search_store/{id}/show', 'CargoAgency\Management\CarController@delivery_show')->name('delivery_show'); 

Route::get('print_pacel_registered/{id}/show', 'CargoAgency\Management\CarController@print_pacel_registered')->name('print_pacel_registered'); 
    
Route::get('pacel_reg/{customer_ID}/show', 'CargoAgency\Management\CarController@pacel_reg')->name('pacel_reg'); 


Route::get('pacel_delete/{id}/delete','CargoAgency\Management\CarController@pacel_delete')->name('pacel_delete');


Route::get('pacel_edit/{id}/edit','CargoAgency\Management\CarController@pacel_edit')->name('pacel.edit');
Route::post('pacel_update','CargoAgency\Management\CarController@pacel_update')->name('pacel.update');

Route::get('money_edit/{id}/edit','CargoAgency\Management\CarController@money_edit')->name('money.edit');
Route::post('money_update','CargoAgency\Management\CarController@money_update')->name('money.update');


// Route::get('gymkhana_test', 'Management\CarController@gymkhana_test')->name('gymkhana_test'); 
// Route::get('gymkhana_test2', 'Management\CarController@gymkhana_test2')->name('gymkhana_test2'); 

Route::get('car_manifest/{id}/{date}/{date2}/show', 'CargoAgency\Management\CarController@car_manifest')->name('car_manifest'); 
    
Route::get('car_manifest22/{id}/{date}/{date2}/show', 'CargoAgency\Management\CarController@car_manifest22')->name('car_manifest22'); 
    
Route::get('car_manifest23/{id}/{date}/{date2}/show', 'CargoAgency\Management\CarController@car_manifest23')->name('car_manifest23'); 
    
Route::get('car_manifest24/{id}/{date}/{date2}/show', 'CargoAgency\Management\CarController@car_manifest24')->name('car_manifest24'); 
    
Route::get('car_manifestAll/{id}/{date}/{date2}/show', 'CargoAgencyManagement\CarController@car_manifestAll')->name('car_manifestAll'); 
    
Route::get('car_invoice/{id}/{date}/{date2}/show', 'CargoAgency\Management\CarController@car_invoice')->name('car_invoice');
    
Route::get('car_invoice22/{id}/{date}/{date2}/show', 'CargoAgency\Management\CarController@car_invoice22')->name('car_invoice22');
    
Route::get('car_invoice23/{id}/{date}/{date2}/show', 'CargoAgency\Management\CarController@car_invoice23')->name('car_invoice23');
    
Route::get('car_invoice24/{id}/{date}/{date2}/show', 'CargoAgency\Management\CarController@car_invoice24')->name('car_invoice24');
    
Route::get('car_invoiceAll/{id}/{date}/{date2}/show', 'CargoAgency\Management\CarController@car_invoiceAll')->name('car_invoiceAll');
    
Route::get('car_single_invoice/{id}/{date}/{date2}/{pacel_id}/show', 'CargoAgency\Management\CarController@car_single_invoice')->name('car_single_invoice'); 

Route::get('search_user', 'CargoAgency\Management\CarController@test')->name('search_user');
Route::get('search', 'CargoAgency\Management\CarController@search_store')->name('search_store');  
Route::get('search/{id}/show', 'CargoAgency\Management\CarController@customer_show')->name('customer_show'); 
Route::get('pacel_store', 'CargoAgency\Management\CarController@pacel_store')->name('pacel_store'); 
Route::get('pacel_show/{id}/show', 'CargoAgency\Management\CarController@pacel_show')->name('pacel_show'); 
Route::get('test1', 'CargoAgency\Management\CarController@test1')->name('test1'); 
Route::resource('driver','CargoAgency\Management\DriverController');               
}); 

//mwisho madekenya


// start affiliate routes
Route::group(['prefix' => 'affiliate'], function () {
    
Route::get('users', 'Affiliate\UsersController@affiliate')->name('affiliate.users')->middleware('auth');

Route::get('register', 'Auth\RegisterController@affiliate_register')->name('affiliate.register_view');

Route::post('register','Auth\RegisterController@affiliate_register_store')->name('affiliate.register');

Route::get('withdraw/methods', 'Affiliate\UsersController@withdraw_methods')->name('affiliate.withdraw_methods')->middleware('auth');

Route::get('withdraw/request', 'Affiliate\UsersController@withdraw_request')->name('affiliate.withdraw_request')->middleware('auth');

Route::get('withdraw/settings', 'Affiliate\UsersController@withdraw_settings')->name('affiliate.withdraw_settings')->middleware('auth');

});


// start affiliate routes
Route::group(['prefix' => 'ema80x'], function () {
    
Route::get('users', 'Affiliate\UsersController@ema80x_register')->name('ema80x.users')->middleware('auth');

Route::get('register', 'Auth\RegisterController@ema80x_register')->name('ema80x.register_view');

Route::post('register','Auth\RegisterController@ema80x_register_store')->name('ema80x.register');
});

/*
Route::group(['prefix'=>'farmer'],function()
{
    Route::get('register','FarmerController@register')->middleware('auth');
})->middleware('auth');
*/


//my rooot


// start farming routes
// Route::group(['prefix' => 'farmings'], function () {
// Route::resource('/farming_cost','farming\Farming_costController')->middleware('auth');
// Route::resource('/cost_centre','farming\Cost_CentreController')->middleware('auth');
// Route::resource('/farming_process','farming\Farming_processController')->middleware('auth');
// Route::resource('/crop_type','farming\CropTypeController')->middleware('auth');
// Route::resource('/seed_type','farming\FeedTypeController')->middleware('auth');
// Route::resource('/farm_program','farming\FarmProgramController')->middleware('auth');
// Route::resource('/crops_monitoring','farming\Crops_MonitoringController')->middleware('auth');
// Route::resource('/register_assets','farming\Farmer_assetsController')->middleware('auth');
// Route::resource('/lime_base','farming\LimeBaseController')->middleware('auth');
// Route::get('/landview',"farming\Farmer_assetsController@index1" )->middleware('auth');
// Route::get('/landdelete/{$id}',"farming\Farmer_assetsController@destroy2" )->middleware('auth');
// Route::get('getFarm',"farming\Farmer_assetsController@getFarm" )->middleware('auth');

// Route::resource('seeds_type',"farming\Seeds_TypesController" )->middleware('auth');
// Route::resource('pesticide_type',"farming\PesticideTypeController" )->middleware('auth');
// Route::get('download',array('as'=>'download','uses'=>'farming\Crops_MonitoringController@download'))->middleware('auth');
// // end farming routes
// });

// start crop life cycle routes
// Route::group(['prefix' => 'crop_lifecycles'], function () {
// Route::resource('irrigation','CropLifeCycle\IrrigationController')->middleware('auth');
// // end crop life cycle routes
// });

// start shop routes
Route::group(['prefix' => 'shops'], function () {
Route::resource('items', 'shop\ItemsController')->middleware('auth');
Route::resource('purchase','shop\PurchaseController')->middleware('auth');
Route::get('findPrice', 'shop\PurchaseController@findPrice')->middleware('auth');  
Route::resource('sales','shop\SalesController')->middleware('auth');
Route::resource('payments', 'shop\PaymentsController')->middleware('auth');
Route::resource('invoice_payment', 'shop\Invoice_paymentController')->middleware('auth');
Route::resource('invoicepdf', 'shop\PDFController')->middleware('auth');
Route::get('pdfview',array('as'=>'pdfview','uses'=>'PDFController@pdfview'))->middleware('auth');
});


// start AzamPesa routes

 Route::any('/index', [IntegrationDepositController::class, 'index'])->name('azampay.index');
 Route::any('/index2', [IntegrationDepositController::class, 'index2'])->name('azampay.index2');
 Route::any('/store', [IntegrationDepositController::class, 'store'])->name('azampesa.store');
 Route::get('findMinimum', [IntegrationDepositController::class, 'findMinimum'])->middleware('auth');  
 
//  //management issues  ExpireUserController
//  Route::get('management_issues/expire', [ExpireUserController::class, 'sms_index'])->name('expired_users.index'); subscription
//  Route::post('management_issues/expire_store', [ExpireUserController::class, 'sms_store'])->name('expired_users.store');
 
 
//Route::group(['prefix' => 'azampesa'], function () {
//Route::resource('azampesa2', 'AzamPesa\IndexController')->middleware('auth');
//});

//Orders Routes
Route::group(['prefix' => 'orders'], function () {
Route::resource('orders','orders\OrdersController')->middleware('auth');
Route::any('quotationList','orders\OrdersController@quotationList')->middleware('auth');
Route::any('quotationDetails/{id}','orders\OrdersController@quotationDetails')->middleware('auth');
});

//Seasson Routes
Route::group(['prefix' => 'farming_season'], function () {

Route::resource('/seasson','farming\SeassonController')->middleware('auth');
Route::resource('/cropslifecycle','farming\CropsLifeCycleController')->middleware('auth');
Route::any('editLifeCycle',array('as'=>'editLifeCycle','uses'=>'farming\CropsLifeCycleController@editLifeCycle'))->middleware('auth');
Route::any('deleteLifeCycle',array('as'=>'deleteLifeCycle','uses'=>'farming\CropsLifeCycleController@deleteLifeCycle'))->middleware('auth');
Route::get('findFarm',"farming\SeassonController@findFarm" )->middleware('auth');
Route::get('findLime',"farming\CropsLifeCycleController@findLime" )->middleware('auth');
Route::get('findSeed',"farming\CropsLifeCycleController@findSeed" )->middleware('auth');
Route::get('findPesticide',"farming\CropsLifeCycleController@findPesticide" )->middleware('auth');
Route::get('monitorModal', 'farming\CropsLifeCycleController@discountModal')->middleware('auth');
Route::post('save_monitor', 'farming\CropsLifeCycleController@save_monitor')->name('monitor.save')->middleware('auth');
});

Route::get('home',"HomeController@index" )->middleware('auth');


Route::group(['prefix' => 'farmer_management'], function () {

Route::get('farmer','FarmerController@index')->middleware('auth');
//Route::post('save','FarmerController@store')->middleware('auth');
Route::get('farmer/{id}/edit','FarmerController@edit')->middleware('auth');
//Route::resource('farmer','FarmerController')->middleware('auth');
Route::post('farmer/update/{id}','FarmerController@update')->middleware('auth');
Route::post('farmer/save','FarmerController@store')->middleware('auth');
Route::get('farmer/{id}/delete','FarmerController@destroy')->middleware('auth');
Route::get('farmer/{id}/show','FarmerController@show')->middleware('auth');
Route::get('findRegion', 'FarmerController@findRegion')->middleware('auth');  
Route::get('findDistrict', 'FarmerController@findDistrict')->middleware('auth');  
Route::get('assign_farmer','FarmerController@assign_farmer')->middleware('auth');
Route::post('save_farmer', 'FarmerController@save_farmer')->name('farmer.save')->middleware('auth');
Route::get('farmerModal', 'FarmerController@discountModal')->middleware('auth');


Route::post('group/{id}/update','GroupController@update')->middleware('auth');
Route::get('manage-group','GroupController@index')->middleware('auth');
Route::post('group/save','GroupController@store')->middleware('auth');
Route::get('group/{id}/delete','GroupController@destroy')->middleware('auth');

Route::get('farmer/group/{id}/add','MemberController@index')->middleware('auth');
Route::get('farmer/group/','MemberController@show')->middleware('auth');

route::post('save','MemberController@store')->middleware('auth');

route::get('land','LandController@index')->middleware('auth');
route::post('land/save','LandController@store')->middleware('auth');
route::get('land/{id}/delete','LandController@destroy')->middleware('auth');
route::post('land/{id}/edit','LandController@update')->middleware('auth');
//oute::get('test',[App\Http\Livewire\Counter::class, 'render'])->middleware('auth');

});

Route::group(['prefix' => 'project'], function () {
Route::resource('project', 'Project\ProjectController')->middleware('auth');
Route::resource('project_categories', 'Project\ProjectCategoriesController')->middleware('auth');

Route::get('project_change_status/{id}/{status}', 'Project\ProjectController@change_status')->name('project.change_status')->middleware('auth');

Route::get('projectModal', 'Project\ProjectController@discountModal')->middleware('auth'); 
   
Route::post('saveCategory', 'Project\ProjectController@saveCategory')->name('project.saveCategory')
->middleware('auth');

    
Route::post('assign_user', 'Project\ProjectController@assign_user')->name('project.assign_user')->middleware('auth');

Route::post('save_project_details', 'Project\ProjectController@save_details')->name('save.project_details')->middleware('auth');
Route::get('edit_project_details/{type}/{type_id}', 'Project\ProjectController@edit_details')->name('edit.project_details')->middleware('auth'); 
Route::post('update_project_details', 'Project\ProjectController@update_details')->name('update.project_details')->middleware('auth');
Route::get('delete_project_details/{type}/{type_id}', 'Project\ProjectController@delete_details')->name('delete.project_details')->middleware('auth'); 
Route::post('grn','Project\ProjectController@grn')->name('project.purchase_grn')->middleware('auth');
Route::get('issue_supplier/{id}', 'Project\ProjectController@issue')->name('project.purchase_issue')->middleware('auth'); 
Route::get('convert_to_invoice/{id}', 'Project\ProjectController@convert_to_invoice')->name('project.convert_to_invoice')->middleware('auth'); 
Route::get('findInvoice', 'Project\ProjectController@findInvoice')->middleware('auth'); 
Route::post('multiple_approve', 'Project\ProjectController@multiple_approve')->name('project_expenses.approve')->middleware('auth');
Route::any('project_file_preview', 'Project\ProjectController@file_preview')->name('project_file.preview');

Route::resource('milestone', 'Project\MilestoneController')->middleware('auth');
Route::resource('ticket', 'Project\TicketController')->middleware('auth');
Route::get('ticket.ticketDet/{id}', 'Project\TicketController@showDet')->name('ticket.ticketDet')->middleware('auth'); 
Route::resource('calendar', 'Project\CalendarController')->middleware('auth');
Route::get('ticket.change_status/{id}/{status}', 'Project\TicketController@change_status')->name('ticket.change_status')->middleware('auth'); 
    
Route::resource('task', 'Project\TaskController')->middleware('auth');
    
Route::get('task_change_status/{id}/{status}', 'Project\TaskController@change_status')->name('task.change_status')->middleware('auth'); 
    
Route::get('taskModal', 'Project\TaskController@discountModal')->middleware('auth'); 
Route::post('assign_user_task', 'Project\TaskController@assign_user')->name('task.assign_user')->middleware('auth');
    
    
Route::post('save_task_details', 'Project\TaskController@save_details')->name('save.task_details')->middleware('auth');
Route::get('edit_task_details/{type}/{type_id}', 'Project\TaskController@edit_details')->name('edit.task_details')->middleware('auth'); 
Route::post('update_task_details', 'Project\TaskController@update_details')->name('update.task_details')->middleware('auth');
Route::get('delete_task_details/{type}/{type_id}', 'Project\TaskController@delete_details')->name('delete.task_details')->middleware('auth'); 
Route::any('task_file_preview', 'Project\TaskController@file_preview')->name('task_file.preview');
 
Route::get('addCategory', 'Project\TaskController@addCategory')->middleware('auth');
    
});

Route::group(['prefix' => 'cf'], function () {
   Route::resource('cargo_type', 'CF\CargoController')->middleware('auth');

    Route::get('/shipment/planning', 'CF\ShipmentPlanningController@index')->name('cf.shipment-planning.index');
    Route::get('/shipment/planning/create', 'CF\ShipmentPlanningController@create')->name('cf.shipment-planning.create');
    Route::post('/shipment/planning', 'CF\ShipmentPlanningController@store')->name('cf.shipment-planning.store');
    Route::get('/shipment/planning/{shipmentPlanning}', 'CF\ShipmentPlanningController@show')->name('show');

    Route::get('/shipment/planning/{shipmentPlanning}/edit', 'CF\ShipmentPlanningController@edit')->name('cf.shipment-planning.edit');
    Route::put('/shipment/planning/{shipmentPlanning}', 'CF\ShipmentPlanningController@update')->name('cf.shipment-planning.update');

    Route::get('/shipment/tracking', 'CF\ShipmentTrackingController@index')->name('cf.tracking.index');
    Route::get('/shipment/tracking/create', 'CF\ShipmentTrackingController@create')->name ('cf.tracking.create');
    Route::post('/shipment/tracking', 'CF\ShipmentTrackingController@store')->name('cf.tracking.store');
    Route::get('/tracking/statuses/{shipment_id}', 'CF\ShipmentTrackingController@getStatuses')->name('cf.tracking.statuses');



   Route::resource('cf_service', 'CF\CFserviceController')->middleware('auth');
   Route::get('findService', 'CF\CFserviceController@findService')->middleware('auth');
   Route::post('cf_store_details', 'CF\CFserviceController@storage_details')->name('save.storage_details')->middleware('auth');
   Route::post('cf_charge_details', 'CF\CFserviceController@charge_details')->name('save.charge_details')->middleware('auth');
   Route::get('update_amount/{id}', 'CF\CFserviceController@updateAmount')->name('update_amount')->middleware('auth');
   Route::get('delete_det/{type}/{type_id}','CF\CFserviceController@delete_details')->name('cf_delete_details')->middleware('auth');
   
  Route::get('cf_warehouse','CF\CFserviceController@warehouse')->name('cf_warehouse')->middleware('auth');
  Route::get('edit_warehouse/{id}', 'CF\CFserviceController@edit_warehouse')->name('edit_warehouse')->middleware('auth');
   
  Route::post('update_det', 'CF\CFserviceController@cf_update_details')->name('update_det')->middleware('auth');
 

   Route::resource('cf', 'CF\ProjectController')->middleware('auth');
   Route::get('_change_status/{id}/{status}', 'CF\ProjectController@change_status')->name('cf.change_status')->middleware('auth'); 
   Route::get('cfModal', 'CF\ProjectController@discountModal')->middleware('auth');   
   Route::get('stockModal', 'CF\ProjectController@stockModal')->middleware('auth'); 
   Route::get('add_inv_item', 'CF\ProjectController@add_inv_item')->middleware('auth');
   Route::get('add_item', 'CF\ProjectController@add_item')->middleware('auth');
 
   Route::get('cf_saveCategory', 'CF\ProjectController@saveCategory')->middleware('auth');
    Route::post('assign_user', 'CF\ProjectController@assign_user')->name('cf.assign_user')->middleware('auth');

    Route::post('save_cf_details', 'CF\ProjectController@save_details')->name('save.cf_details')->middleware('auth');
    Route::get('edit_cf_details/{id}/{type}/{type_id}', 'CF\ProjectController@edit_details')->name('edit.cf_details')->middleware('auth'); 
    Route::post('update_cf_details', 'CF\ProjectController@update_details')->name('update.cf_details')->middleware('auth');
     Route::get('delete_cf_details/{type}/{type_id}', 'CF\ProjectController@delete_details')->name('delete.cf_details')->middleware('auth'); 

Route::get('approve_purchase/{id}', 'CF\ProjectController@approve_purchase')->name('cf.approve_purchase')->middleware('auth'); 
 Route::get('convert_to_invoice/{id}', 'CF\ProjectController@convert_to_invoice')->name('cf.convert_to_invoice')->middleware('auth'); 
  Route::get('approve_invoice/{id}', 'CF\ProjectController@approve_invoice')->name('cf.approve_invoice')->middleware('auth'); 
 Route::get('cf_findInvoice', 'CF\ProjectController@findInvoice')->middleware('auth'); 
  Route::post('multiple_approve', 'CF\ProjectController@multiple_approve')->name('cf_expenses.approve')->middleware('auth');
 Route::any('cf_file_preview', 'CF\ProjectController@file_preview')->name('cf_file.preview');
  Route::get('cf_invoice_pdfview',array('as'=>'cf_invoice_pdfview','uses'=>'CF\ProjectController@invoice_pdfview'))->middleware('auth');
    Route::get('cf_invoice_receipt',array('as'=>'cf_invoice_receipt','uses'=>'CF\ProjectController@invoice_receipt'))->middleware('auth');
  Route::get('cf_invoice_print',array('as'=>'cf_invoice_print','uses'=>'CF\ProjectController@print_pdfview'))->middleware('auth');
  Route::get('cf_receipt_print',array('as'=>'cf_receipt_print','uses'=>'CF\ProjectController@receipt_print_pdfview'))->middleware('auth');
 Route::get('cf_payment_pdfview',array('as'=>'cf_invoice_payment_pdfview','uses'=>'CF\ProjectController@payment_pdfview'))->middleware('auth');
  Route::get('cf_invoice_history_pdfview',array('as'=>'cf_invoice_history_pdfview','uses'=>'CF\ProjectController@history_pdfview'))->middleware('auth');
  
    Route::resource('cf_milestone', 'CF\MilestoneController')->middleware('auth');
    Route::resource('cf_ticket', 'CF\TicketController')->middleware('auth');
    Route::resource('cf_calendar', 'CF\CalendarController')->middleware('auth');
    
    Route::resource('cf_task', 'CF\TaskController')->middleware('auth');
    Route::get('cf_change_status/{id}/{status}', 'CF\TaskController@change_status')->name('task.change_status')->middleware('auth'); 
    
    Route::get('taskModal', 'CF\TaskController@discountModal')->middleware('auth'); 
    Route::post('assign_user_task', 'CF\TaskController@assign_user')->name('task.assign_user')->middleware('auth');
    
    
    Route::post('save_task_cf_details', 'CF\TaskController@save_details')->name('save.task_cf_details')->middleware('auth');
    Route::get('edit_task_cf_details/{type}/{type_id}', 'CF\TaskController@edit_details')->name('edit.task_cf_details')->middleware('auth'); 
    Route::post('update_task_cf_details', 'CF\TaskController@update_details')->name('update.task_cf_details')->middleware('auth');
     Route::get('delete_task_cf_details/{type}/{type_id}', 'CF\TaskController@delete_details')->name('delete.task_cf_details')->middleware('auth'); 
    Route::get('cf_addCategory', 'CF\TaskController@addCategory')->middleware('auth');
    
    Route::resource('pacel_cf', 'CF_Pacel\PacelController')->middleware('auth');
    Route::get('pacel_approve/{id}', 'Pacel\PacelController@approve')->name('cf_pacel.approve')->middleware('auth'); 
    Route::get('pacel_cancel/{id}', 'Pacel\PacelController@cancel')->name('cf_pacel.cancel')->middleware('auth');  
});


//Goal Tracking
    Route::group(['prefix' => 'goalTracking'], function () {
        
    Route::resource('goal', 'GoalTracking\GoalTrackingController')->middleware('auth');
    Route::get('goalEdit/{id}', 'GoalTracking\GoalTrackingController@edit')->name('edit.goal')->middleware('auth'); 
        
    Route::get('goalsDet/{id}', 'GoalTracking\GoalTrackingController@goals_details')->name('goalsDet')->middleware('auth'); 
    Route::get('delete_goal_details/{type}/{type_id}','GoalTracking\GoalTrackingController@delete_goals')->name('delete.goal_details')->middleware('auth'); 
    Route::get('edit_goal_details/{type}/{type_id}','GoalTracking\GoalTrackingController@edit_details')->name('edit.goal_details')->middleware('auth'); 
    Route::post('save_goal_details','GoalTracking\GoalTrackingController@save_details')->name('save.goal_details')->middleware('auth');
    Route::get('addCategory', 'GoalTracking\TaskController@addCategory')->middleware('auth');
    Route::resource('goal_task', 'GoalTracking\TaskController')->middleware('auth');
    Route::get('taskModal', 'GoalTracking\TaskController@discountModal')->middleware('auth'); 
});


//leads
Route::resource('leads', 'Leads\LeadsController')->middleware('auth');
Route::resource('leads_source', 'Leads\LeadsSourceController')->middleware('auth');
Route::resource('leads_status', 'Leads\LeadsStatusController')->middleware('auth');

Route::get('leadsModal', 'Leads\LeadsController@discountModal')->middleware('auth');    
Route::get('addStatus', 'Leads\LeadsController@addStatus')->middleware('auth');
Route::get('leads/{id}/change_status', 'Leads\LeadsController@change_status')->name('leads.change_status')->middleware('auth');
Route::get('addSource', 'Leads\LeadsController@addSource')->middleware('auth');
Route::post('save_lead_details', 'Leads\LeadsController@save_details')->name('save.lead_details')->middleware('auth');
Route::get('edit_lead_details/{type}/{type_id}', 'Leads\LeadsController@edit_details')->name('edit.lead_details')->middleware('auth'); 
Route::post('update_lead_details', 'Leads\LeadsController@update_details')->name('update.lead_details')->middleware('auth');
Route::get('delete_lead_details/{type}/{type_id}', 'Leads\LeadsController@delete_details')->name('delete.lead_details')->middleware('auth'); 
Route::any('leads_file_preview', 'Leads\LeadsController@file_preview')->name('leads_file.preview');




//livewire
Route::view('contacts', 'contacts')->middleware('auth');
Route::view('test','livewiretest')->middleware('auth');
Route::view('input-order','agrihub.iorder')->middleware('auth');

//pos
Route::group(['prefix' => 'pos'], function () {

Route::any('activity', 'POS\PurchaseController@summary'); 

Route::group(['prefix' => 'purchases'], function () {
Route::resource('supplier', 'shop\SupplierController')->middleware('auth');
Route::post('import-supplier','shop\SupplierController@import')->name('supplier.import');
Route::post('supplier-sample','shop\SupplierController@sample')->name('supplier.sample');
Route::resource('items', 'POS\ItemsController')->middleware('auth');

Route::post('pos/sales/add_new_item', 'POS\InvoiceController@add_new_item')->name('pos.sales.addNewItem')->middleware('auth');

Route::post('profoma/sales/add_new_item', 'POS\ProfomaInvoiceController@profoma_add_new_item')->name('pos.sales.ProfomAaddNewItem')->middleware('auth');


Route::get('findItem', 'POS\ItemsController@findItem')->middleware('auth'); 
Route::get('findCode', 'POS\ItemsController@findCode')->middleware('auth'); 
Route::post('item_import','POS\ImportItemsController@import')->name('item.import');
Route::post('update_quantity','POS\ItemsController@update_quantity')->name('items.update_quantity');
Route::post('item_sample','POS\ImportItemsController@sample')->name('item.sample');

Route::resource('category', 'POS\CategoryController')->middleware('auth');
Route::resource('size', 'POS\SizeController')->middleware('auth');
Route::resource('color', 'POS\ColorController')->middleware('auth');

Route::get('add_item', 'POS\PurchaseController@add_item')->middleware('auth');
Route::resource('purchase', 'POS\PurchaseController')->middleware('auth');
Route::get('save_supplier', 'POS\PurchaseController@save_supplier')->middleware('auth');
Route::get('save_item', 'POS\PurchaseController@save_item')->middleware('auth');
Route::get('findInvPrice', 'POS\PurchaseController@findPrice')->middleware('auth'); 
Route::get('invModal', 'POS\PurchaseController@discountModal')->middleware('auth');
Route::get('approve_purchase/{id}', 'POS\PurchaseController@approve')->name('purchase.approve')->middleware('auth'); 
Route::get('cancel/{id}', 'POS\PurchaseController@cancel')->name('purchase.cancel')->middleware('auth'); 
Route::get('receive/{id}', 'POS\PurchaseController@receive')->name('purchase.receive')->middleware('auth'); 
Route::post('grn','POS\PurchaseController@grn')->name('purchase.grn')->middleware('auth');
Route::get('issue_supplier/{id}', 'POS\PurchaseController@issue')->name('purchase.issue')->middleware('auth'); 
Route::get('purchase_grn_pdfview',array('as'=>'purchase_grn_pdfview','uses'=>'POS\PurchaseController@grn_pdfview'))->middleware('auth');
Route::get('purchase_issue_pdfview',array('as'=>'purchase_issue_pdfview','uses'=>'POS\PurchaseController@issue_pdfview'))->middleware('auth');
Route::get('make_payment/{id}', 'POS\PurchaseController@make_payment')->name('purchase.pay')->middleware('auth'); 
Route::get('purchase_pdfview',array('as'=>'purchase_pdfview','uses'=>'POS\PurchaseController@inv_pdfview'))->middleware('auth');
Route::get('assign_expire', 'POS\PurchaseController@assign_expire')->name('pos.assign_expire')->middleware('auth');
Route::post('save_expire', 'POS\PurchaseController@save_expire')->name('pos.save_expire')->middleware('auth');
Route::get('expire_list', 'POS\PurchaseController@expire_list')->name('pos.expire')->middleware('auth');
Route::get('dispose_expire/{id}', 'POS\PurchaseController@dispose')->name('pos.dispose_expire')->middleware('auth'); 

Route::resource('purchase_payment', 'POS\PurchasePaymentController')->middleware('auth');
Route::get('payment_pdfview',array('as'=>'payment_pdfview','uses'=>'POS\PurchasePaymentController@payment_pdfview'))->middleware('auth');
Route::any('creditors_report', 'POS\PurchaseController@creditors_report')->middleware('auth');
Route::any('creditors_summary_report', 'POS\PurchaseController@creditors_summary_report')->middleware('auth');
Route::resource('pos_issue', 'POS\GoodIssueController')->middleware('auth');
Route::get('return_issued/{id}', 'POS\GoodIssueController@return')->name('pos_issue.returned')->middleware('auth');
Route::get('disposal_issued/{id}', 'POS\GoodIssueController@disposal')->name('pos_issue.disposed')->middleware('auth');
Route::post('issue_return', 'POS\GoodIssueController@save_return')->name('pos_issue.return')->middleware('auth');
Route::post('issue_disposal', 'POS\GoodIssueController@save_disposal')->name('pos_issue.disposal')->middleware('auth');
Route::get('findQuantity', 'POS\GoodIssueController@findQuantity'); 
Route::get('issue_approve/{id}', 'POS\GoodIssueController@approve')->name('pos_issue.approve')->middleware('auth');
Route::get('good_issue_pdfview',array('as'=>'good_issue_pdfview','uses'=>'POS\GoodIssueController@issue_pdfview'))->middleware('auth');
Route::get('purchaseModal', 'POS\GoodIssueController@discountModal'); 

Route::resource('disposal', 'POS\GoodDisposalController')->middleware('auth');
Route::get('disposalModal', 'POS\GoodDisposalController@discountModal'); 
Route::get('findDQuantity', 'POS\GoodDisposalController@findQuantity'); 
Route::get('disposal_approve/{id}', 'POS\GoodDisposalController@approve')->name('pos_disposal.approve')->middleware('auth');

Route::resource('stock_movement', 'POS\StockMovementController')->middleware('auth');
Route::get('findStockQuantity', 'POS\StockMovementController@findQuantity'); 
Route::get('stock_movement_approve/{id}', 'POS\StockMovementController@approve')->name('stock_movement.approve')->middleware('auth');
Route::get('stockModal', 'POS\StockMovementController@discountModal'); 
Route::get('pos_movement_pdfview',array('as'=>'pos_movement_pdfview','uses'=>'POS\StockMovementController@movement_pdfview'))->middleware('auth');
Route::get('pos_movement_receipt',array('as'=>'pos_movement_receipt','uses'=>'POS\StockMovementController@movement_receipt'))->middleware('auth');


Route::resource('debit_note', 'POS\ReturnPurchasesController')->middleware('auth');
Route::get('findinvoice', 'POS\ReturnPurchasesController@findPrice')->middleware('auth'); 
Route::get('findinvoice2', 'POS\ReturnPurchasesController@findPrice2')->middleware('auth'); 
Route::get('showInvoice', 'POS\ReturnPurchasesController@showInvoice')->middleware('auth'); 
Route::get('editshowInvoice', 'POS\ReturnPurchasesController@editshowInvoice')->middleware('auth'); 
Route::get('findinvQty', 'POS\ReturnPurchasesController@findQty')->middleware('auth'); 
Route::get('approve_debit_note/{id}', 'POS\ReturnPurchasesController@approve')->name('debit_note.approve')->middleware('auth'); 
Route::get('cancel_debit_note/{id}', 'POS\ReturnPurchasesController@cancel')->name('debit_note.cancel')->middleware('auth'); 
Route::get('receive_debit_note/{id}', 'POS\ReturnPurchasesController@receive')->name('debit_note.receive')->middleware('auth'); 
Route::get('make_debit_note_payment/{id}', 'POS\ReturnPurchasesController@make_payment')->name('debit_note.pay')->middleware('auth'); 
Route::resource('debit_note_payment', 'POS\ReturnPurchasesPaymentController')->middleware('auth');
Route::get('debit_note_pdfview',array('as'=>'debit_note_pdfview','uses'=>'POS\ReturnPurchasesController@debit_note_pdfview'))->middleware('auth');
    

});

Route::group(['prefix' => 'sales'], function () {
    
    
  Route::resource('client', 'ClientController')->middleware('auth');
  Route::post('import-client','ClientController@import')->name('client.import');
Route::post('client-sample','ClientController@sample')->name('client.sample');
Route::get('add_inv_item', 'POS\InvoiceController@add_item')->middleware('auth');
Route::get('add_inv_item2', 'POS\InvoiceController2@add_item')->middleware('auth');
  Route::resource('profoma_invoice', 'POS\ProfomaInvoiceController')->middleware('auth');
  Route::get('convert_to_invoice/{id}', 'POS\ProfomaInvoiceController@convert_to_invoice')->name('invoice.convert_to_invoice')->middleware('auth'); 
  Route::get('check_item', 'POS\InvoiceController@check_item')->middleware('auth');
   Route::get('update_item', 'POS\InvoiceController@update_item')->middleware('auth');
  Route::any('debtors_report', 'POS\InvoiceController@debtors_report')->middleware('auth');
  Route::any('commission_report', 'POS\InvoiceController@commission_report')->middleware('auth');
  Route::get('findInvItem', 'POS\InvoiceController@findItem')->middleware('auth');
  Route::any('debtors_summary_report', 'POS\InvoiceController@debtors_summary_report')->middleware('auth');
  Route::get('save_client', 'POS\InvoiceController@save_client')->middleware('auth');

  Route::get('approve_profoma/{id}', 'POS\ProfomaInvoiceController@profoma_approve')->name('profoma.profoma_approve')->middleware('auth');

  Route::get('close_profoma/{id}', 'POS\ProfomaInvoiceController@close_profoma')->name('profoma.close_profoma')->middleware('auth');


  Route::get('create_sales', 'POS\InvoiceController@create_sales')->middleware('auth')->name('invoice_sales.create_sales');
  
  Route::get('modified_sales', 'POS\InvoiceController@modified_sales')->middleware('auth')->name('invoice_sales.modified_sales');


  Route::post('store_sales', 'POS\InvoiceController@store_sales')->middleware('auth')->name('invoice_sales.store_sales');


  Route::post('modified_sales', 'POS\InvoiceController@modified_sales')->middleware('auth')->name('invoice_sales.modified_sales');



  Route::get('pos/delivery/{id}', 'POS\InvoiceController@show_delivery')->middleware('auth')->name('show_delivery');

  Route::post('pos/delivery/{id}/assign-driver', 'POS\InvoiceController@assignDriver')->middleware('auth')->name('assign_driver');

  Route::get('pos/sales/pos/delivery/{id}/notifications', 'POS\InvoiceController@getDeliveryNotifications')->middleware('auth')->name('delivery_notifications');

  Route::resource('invoice', 'POS\InvoiceController')->middleware('auth');
  
  Route::resource('delivery_note', 'POS\DeliveryNoteController')->middleware('auth');
  
  Route::resource('invoice2', 'POS\InvoiceController2')->middleware('auth'); 
  Route::post('save_commission', 'POS\InvoiceController@save_commission')->name('save.commission')->middleware('auth'); 
  Route::post('upload-image-via-ajax', 'POS\InvoiceController@uploadImageViaAjax')->name('uploadImageViaAjax');
  Route::get('delete-image-via-ajax', 'POS\InvoiceController@deleteImageViaAjax')->name('deleteImageViaAjax');
  Route::get('get-image-via-ajax', 'POS\InvoiceController@getImageViaAjax')->name('getImageViaAjax');
  Route::post('save_attachment', 'POS\InvoiceController@save_attachment')->name('save_attachment');
  Route::get('delete_attachment/{id}', 'POS\InvoiceController@delete_attachment')->name('delete_attachment');
  Route::get('download_attachment/{id}', 'POS\InvoiceController@download_attachment')->name('download_attachment');
  Route::get('findInvPrice', 'POS\InvoiceController@findPrice')->middleware('auth'); 
  Route::get('findInvQuantity', 'POS\InvoiceController@findQuantity'); 
  Route::get('invModal', 'POS\InvoiceController@discountModal')->middleware('auth');
  Route::get('invModal2', 'POS\InvoiceController2@discountModal')->middleware('auth');
  Route::get('attachModal', 'POS\InvoiceController@attachModal')->middleware('auth');
  Route::get('approve_purchase/{id}', 'POS\InvoiceController@approve')->name('invoice.approve')->middleware('auth');  
  Route::get('cancel/{id}', 'POS\InvoiceController@cancel')->name('invoice.cancel')->middleware('auth'); 
  Route::get('receive/{id}', 'POS\InvoiceController@receive')->name('invoice.receive')->middleware('auth'); 
  Route::get('make_payment/{id}', 'POS\InvoiceController@make_payment')->name('pos_invoice.pay')->middleware('auth'); 

  Route::get('pos_profoma_pdfview',array('as'=>'pos_profoma_pdfview','uses'=>'POS\ProfomaInvoiceController@invoice_pdfview'))->middleware('auth');
  Route::get('pos_invoice_pdfview',array('as'=>'pos_invoice_pdfview','uses'=>'POS\InvoiceController@invoice_pdfview'))->middleware('auth');
  Route::get('pos_invoice_receipt',array('as'=>'pos_invoice_receipt','uses'=>'POS\InvoiceController@invoice_receipt'))->middleware('auth');
  Route::get('pos_invoice_print',array('as'=>'pos_invoice_print','uses'=>'POS\InvoiceController@print_pdfview'))->middleware('auth');
  Route::get('pos_receipt_print',array('as'=>'pos_receipt_print','uses'=>'POS\InvoiceController@receipt_print_pdfview'))->middleware('auth');
  Route::resource('pos_invoice_payment', 'POS\InvoicePaymentController')->middleware('auth');
  Route::get('payment_pdfview',array('as'=>'invoice_payment_pdfview','uses'=>'POS\InvoicePaymentController@payment_pdfview'))->middleware('auth');
  Route::get('invoice_history_pdfview',array('as'=>'invoice_history_pdfview','uses'=>'POS\InvoicePaymentController@history_pdfview'))->middleware('auth');

  Route::get('invoice_delivery_note',array('as'=>'invoice_delivery_note','uses'=>'POS\InvoicePaymentController@history_delivery_pdfview'))->middleware('auth');

  
  Route::resource('credit_note', 'POS\ReturnInvoiceController')->middleware('auth');
  Route::get('findinvoice', 'POS\ReturnInvoiceController@findPrice')->middleware('auth'); 
    Route::get('findinvoice2', 'POS\ReturnInvoiceController@findPrice2')->middleware('auth'); 
  Route::get('showInvoice', 'POS\ReturnInvoiceController@showInvoice')->middleware('auth'); 
Route::get('editshowInvoice', 'POS\ReturnInvoiceController@editshowInvoice')->middleware('auth'); 
  Route::get('findinvQty', 'POS\ReturnInvoiceController@findQty')->middleware('auth'); 
Route::get('approve_credit_note/{id}', 'POS\ReturnInvoiceController@approve')->name('credit_note.approve')->middleware('auth'); 
Route::get('cancel_credit_note/{id}', 'POS\ReturnInvoiceController@cancel')->name('credit_note.cancel')->middleware('auth'); 
Route::get('receive_credit_note/{id}', 'POS\ReturnInvoiceController@receive')->name('credit_note.receive')->middleware('auth'); 
Route::get('make_credit_note_payment/{id}', 'POS\ReturnInvoiceController@make_payment')->name('credit_note.pay')->middleware('auth'); 
Route::resource('credit_note_payment', 'POS\ReturnInvoicePaymentController')->middleware('auth');
Route::get('credit_note_pdfview',array('as'=>'credit_note_pdfview','uses'=>'POS\ReturnInvoiceController@credit_note_pdfview'))->middleware('auth');

  });
  
  
});



//route for restaurant
Route::group(['prefix' => 'restaurant'], function () {

Route::any('pos_activity', 'Restaurant\POS\ReportController@summary'); 

Route::resource('menu-items', 'Restaurant\POS\MenuItemController');
Route::get('menu-items/change/{id}', 'Restaurant\POS\MenuItemController@change_status')->name('menu-items.change')->middleware('auth');
Route::get('save_client', 'Restaurant\POS\OrderController@save_client')->middleware('auth');
Route::resource('orders', 'Restaurant\POS\OrderController')->middleware('auth'); ;
Route::resource('orders2', 'Restaurant\POS\OrderController2')->middleware('auth'); ;
Route::get('add_order_item', 'Restaurant\POS\OrderController@add_item')->middleware('auth');
Route::get('invModal', 'Restaurant\POS\OrderController@discountModal')->middleware('auth');
Route::get('findPrice', 'Restaurant\POS\OrderController@findPrice')->middleware('auth'); ; 
Route::get('findQuantity', 'Restaurant\POS\OrderController@findQuantity')->middleware('auth'); ; 
Route::get('findUser', 'Restaurant\POS\OrderController@findUser')->middleware('auth'); ;
Route::get('showType', 'Restaurant\POS\OrderController@showType')->middleware('auth'); ;
Route::get('orders_cancel/{id}', 'Restaurant\POS\OrderController@cancel')->name('orders.cancel')->middleware('auth'); 
Route::get('orders_receive/{id}', 'Restaurant\POS\OrderController@receive')->name('orders.receive')->middleware('auth'); 
Route::get('orders_pdfview',array('as'=>'orders_pdfview','uses'=>'Restaurant\POS\OrderController@orders_pdfview'))->middleware('auth');
Route::get('orders_payment_pdfview',array('as'=>'orders_payment_pdfview','uses'=>'Restaurant\POS\OrderController@orders_payment_pdfview'))->middleware('auth'); 
Route::get('orders_receipt',array('as'=>'orders_receipt','uses'=>'Restaurant\POS\OrderController@orders_receipt'))->middleware('auth');
Route::resource('restaurant_items', 'Restaurant\POS\ItemsController')->middleware('auth');
Route::get('findRestaurantItem', 'Restaurant\POS\ItemsController@findItem')->middleware('auth'); 
Route::post('restaurant_item_import','Restaurant\POS\ImportItemsController@import')->name('restaurant_item.import');
Route::post('restaurant_update_quantity','Restaurant\POS\ItemsController@update_quantity')->name('restaurant_item.update_quantity');
Route::post('restaurant_item_sample','Restaurant\POS\ImportItemsController@sample')->name('restaurant_item.sample');
    
  });
  
  
  //route for hotel
Route::group(['prefix' => 'hotel'], function () {

Route::resource('room_type', 'Hotel\RoomTypeController')->middleware('auth'); ;
Route::resource('hotel', 'Hotel\HotelController')->middleware('auth'); ;
Route::resource('asset', 'Hotel\AssetController')->middleware('auth'); ;
Route::resource('visitor', 'Hotel\ClientController')->middleware('auth'); ;
Route::any('check_availability', 'Hotel\BookingController@check_availability')->name('hotel.check_availability')->middleware('auth'); ;
Route::resource('booking', 'Hotel\BookingController')->middleware('auth');
Route::get('showType', 'Hotel\BookingController@showType')->middleware('auth'); ;
Route::get('showName', 'Hotel\BookingController@showName')->middleware('auth'); ;
Route::get('findPrice', 'Hotel\BookingController@findPrice')->middleware('auth'); ; 
Route::get('approve_booking/{id}', 'Hotel\BookingController@approve')->name('booking.approve')->middleware('auth'); 
Route::get('cancel/{id}', 'Hotel\BookingController@cancel')->name('booking.cancel')->middleware('auth'); 
Route::get('make_payment/{id}', 'Hotel\BookingController@make_payment')->name('booking.pay')->middleware('auth'); 
Route::resource('booking_payment', 'Hotel\BookingPaymentController')->middleware('auth');
Route::get('booking_pdfview',array('as'=>'booking_pdfview','uses'=>'Hotel\BookingController@orders_pdfview'))->middleware('auth');
Route::get('booking_payment_pdfview',array('as'=>'booking_payment_pdfview','uses'=>'Hotel\BookingController@orders_payment_pdfview'))->middleware('auth'); 
Route::get('booking_receipt',array('as'=>'booking_receipt','uses'=>'Hotel\BookingController@orders_receipt'))->middleware('auth');
Route::get('discountModal', 'Hotel\BookingController@discountModal')->middleware('auth'); ;
Route::post('adjust_room', 'Hotel\BookingController@adjust')->name('booking.adjust')->middleware('auth');
Route::post('cancel_room', 'Hotel\BookingController@cancel_room')->name('booking.cancel_room')->middleware('auth');
Route::post('cancel_booking', 'Hotel\BookingController@cancel_booking')->name('booking.cancel_booking')->middleware('auth');
Route::get('checkout_room/{id}', 'Hotel\BookingController@checkout')->name('booking.checkout')->middleware('auth'); 
Route::post('save_availability', 'Hotel\BookingController@save_availability')->name('booking.save_availability')->middleware('auth');
    
  });




//  logistic-truck routes
Route::group(['prefix' => 'logistic_truck'], function () {
Route::resource('truck', 'Truck\TruckController')->middleware('auth');
Route::get('disable/{id}', 'Truck\TruckController@save_disable')->name('truck.disable')->middleware('auth');
Route::get('connect_trailer', 'Truck\TruckController@connect')->name('truck.connect')->middleware('auth');
Route::get('connectModal', 'Truck\TruckController@discountModal')->middleware('auth');
Route::post('save_connect', 'Truck\TruckController@save_connect')->middleware('auth');
Route::get('disconnect/{id}', 'Truck\TruckController@save_disconnect')->name('truck.disconnect')->middleware('auth');
Route::get('connect_driver', 'Truck\TruckController@connect_driver')->name('truck.driver')->middleware('auth');
Route::get('expire_list', 'Truck\TruckController@expire_list')->name('truck.expire')->middleware('auth');
Route::post('save_driver', 'Truck\TruckController@save_driver')->middleware('auth');
Route::any('truck_report', 'Truck\TruckController@truck_report')->name('truck_report')->middleware('auth');
Route::any('truck_summary', 'Truck\TruckController@truck_summary')->name('truck_summary')->middleware('auth');
Route::get('remove_driver/{id}', 'Truck\TruckController@remove_driver')->name('truck.remove')->middleware('auth');
Route::get('truck_sticker/{id}', 'Truck\TruckController@sticker')->name('truck.sticker')->middleware('auth');
Route::get('truck_insurance/{id}', 'Truck\TruckController@insurance')->name('truck.insurance')->middleware('auth');
Route::get('truck_permit/{id}', 'Truck\TruckController@permit')->name('truck.permit')->middleware('auth');
Route::get('truck_comesa/{id}', 'Truck\TruckController@comesa')->name('truck.comesa')->middleware('auth');
Route::get('truck_carbon/{id}', 'Truck\TruckController@carbon')->name('truck.carbon')->middleware('auth');
Route::get('truck_wma/{id}', 'Truck\TruckController@wma')->name('truck.wma')->middleware('auth');
Route::get('truck_device/{id}', 'Truck\TruckController@device')->name('truck.device')->middleware('auth');
Route::post('insurance_import','Truck\ImportInsuranceController@import')->name('insurance.import');
Route::post('insurance_sample','Truck\ImportInsuranceController@sample')->name('insurance.sample');
Route::any('truck_fuel_report/{id}', 'Truck\TruckController@fuel')->name('truck.fuel')->middleware('auth');
Route::any('truck_route/{id}', 'Truck\TruckController@route')->name('truck.route')->middleware('auth');
Route::resource('sticker', 'Truck\StickerController')->middleware('auth');
Route::resource('road_permit', 'Truck\RoadPermitController')->middleware('auth');
Route::resource('comesa', 'Truck\ComesaController')->middleware('auth');
Route::resource('carbon', 'Truck\CarbonController')->middleware('auth');
Route::resource('wma', 'Truck\WMAController')->middleware('auth');
Route::resource('device', 'Truck\DeviceController')->middleware('auth');
Route::resource('truckinsurance', 'Truck\TruckInsuranceController')->middleware('auth');
Route::post('sticker_import','Truck\ImportStickerController@import')->name('sticker.import');
Route::post('sticker_sample','Truck\ImportStickerController@sample')->name('sticker.sample');
Route::post('road_permit_import','Truck\ImportRoadPermitController@import')->name('road_permit.import');
Route::post('road_permit_sample','Truck\ImportRoadPermitController@sample')->name('road_permit.sample');
Route::post('comesa_import','Truck\ImportComesaController@import')->name('comesa.import');
Route::post('comesa_sample','Truck\ImportComesaController@sample')->name('comesa.sample');
Route::post('carbon_import','Truck\ImportCarbonController@import')->name('carbon.import');
Route::post('carbon_sample','Truck\ImportCarbonController@sample')->name('carbon.sample');
Route::get('sdownload',array('as'=>'sdownload','uses'=>'Truck\StickerControllerr@sdownload'))->middleware('auth');
Route::get('tdownload',array('as'=>'tdownload','uses'=>'ruck\TruckInsuranceController@tdownload'))->middleware('auth');
Route::resource('equipment', 'Truck\EquipmentController')->middleware('auth');
Route::post('update_equipment', 'Truck\EquipmentController@update_equipment')->name('equipment.update')->middleware('auth');
Route::resource('assign_equipment', 'Truck\AssignController')->middleware('auth');
Route::get('return_equipment/{id}', 'Truck\AssignController@return')->name('equipment.returned')->middleware('auth');
Route::get('dispose_assign_equipment/{id}', 'Truck\AssignController@disposal')->name('equipment.disposed')->middleware('auth');
Route::get('dispose_equipment/{id}', 'Truck\AssignController@dispose_equipment')->name('dispose_equipment')->middleware('auth');
Route::post('equipment_return', 'Truck\AssignController@save_return')->name('equipment.return')->middleware('auth');
Route::post('equipment_disposal', 'Truck\AssignController@save_disposal')->name('equipment.disposal')->middleware('auth');
Route::post('equipment_approve', 'Truck\AssignController@approve')->name('equipment.approve')->middleware('auth');
Route::any('equipment_report', 'Truck\AssignController@equipment_report')->name('equipment.report')->middleware('auth');


});

//  logistic-driver routes
Route::group(['prefix' => 'logistic_driver'], function () {
Route::resource('driver', 'Driver\DriverController')->middleware('auth');
Route::get('driver_licence/{id}', 'Driver\DriverController@licence')->name('driver.licence')->middleware('auth');
Route::get('driver_performance/{id}', 'Driver\DriverController@performance')->name('driver.performance')->middleware('auth');
Route::resource('licence', 'Driver\LicenceController')->middleware('auth');
Route::resource('performance', 'Driver\PerformanceController')->middleware('auth');
Route::get('ldownload',array('as'=>'ldownload','uses'=>'Driver\LicenceController@ldownload'))->middleware('auth');
Route::get('pdownload',array('as'=>'pdownload','uses'=>'Driver\PerformanceController@pdownload'))->middleware('auth');
Route::any('driver_fuel_report/{id}', 'Driver\DriverController@fuel')->name('driver.fuel')->middleware('auth');
Route::any('driver_route/{id}', 'Driver\DriverController@route')->name('driver.route')->middleware('auth');
});




Route::group(['prefix' => 'manufacturing'], function () {
        
        
Route::get('items2/index', 'POS\ItemsController@manufacture_index')->name('items2.index')->middleware('auth');
Route::post('items2/store', 'POS\ItemsController@store2')->name('items2.store')->middleware('auth');
Route::get('items2/edit/{id}', 'POS\ItemsController@edit2')->name('items2.edit')->middleware('auth'); 
Route::get('items2/show/{id}', 'POS\ItemsController@show2')->name('items2.show')->middleware('auth');
Route::put('items2/{id}/update', 'POS\ItemsController@update2')->name('items2.update')->middleware('auth');
Route::delete('items2/{id}/delete', 'POS\ItemsController@destroy2')->name('items2.destroy')->middleware('auth');
Route::post('items2/update_quantity','POS\ItemsController@update_quantity2')->name('items2.update_quantity');
Route::post('item2_import','POS\ImportItemsController@import2')->name('item2.import');
Route::post('item2_sample','POS\ImportItemsController@sample2')->name('item2.sample');

Route::get('unitModal', 'POS\PurchaseController@discountModal')->middleware('auth');
    
Route::resource('manufacturing_purchase', 'Manufacturing\PurchaseInventoryController')->middleware('auth');
Route::resource('manufacturing_package', 'Manufacturing\PackageController')->middleware('auth');
Route::resource('manufacturing_inventory', 'Manufacturing\InventoryController')->middleware('auth');
Route::resource('manufacturing_location', 'Manufacturing\LocationController')->middleware('auth');
Route::resource('bill_of_material', 'Manufacturing\BillOfMaterialController')->middleware('auth');
Route::get('bill_of_material_inv_pdfview',array('as'=>'bill_of_material_inv_pdfview','uses'=>'Manufacturing\BillOfMaterialController@inv_pdfview'))->middleware('auth');
Route::resource('work_order', 'Manufacturing\WorkOrderController')->middleware('auth');
Route::get('findInvQuantity', 'Manufacturing\WorkOrderController@findQuantity');
Route::get('findWrkQuantity', 'Manufacturing\WorkOrderController@findWrkQuantity'); 
    
Route::get('findInvWrkQuantity', 'Manufacturing\WorkOrderController@findInvWrkQuantity'); 
    
Route::get('workModal', 'Manufacturing\WorkOrderController@discountModal'); 
Route::get('findProduceModal', 'Manufacturing\WorkOrderController@findProduceModal'); 
Route::get('findbillProduct', 'Manufacturing\WorkOrderController@findbillProduct')->middleware('auth'); 
Route::get('work_order_approve/{id}', 'Manufacturing\WorkOrderController@approve')->name('work_order.approve')->middleware('auth'); 
Route::get('work_order_release/{id}', 'Manufacturing\WorkOrderController@release')->name('work_order.release')->middleware('auth');
Route::put('work_order_produce/{id}/produce', 'Manufacturing\WorkOrderController@produce')->name('work_order.produce')->middleware('auth');
Route::put('work_order_produce/{id}/store_produce', 'Manufacturing\WorkOrderController@store_produced')->name('work_order.store_produce')->middleware('auth');
Route::put('work_order_finish/{id}', 'Manufacturing\WorkOrderController@finish')->name('work_order.finish')->middleware('auth');
    
Route::get('manufacturing_approve/{id}', 'Manufacturing\PurchaseInventoryController@approve')->name('manufacturing_inventory.approve')->middleware('auth'); 
Route::get('manufacturing_cancel/{id}', 'Manufacturing\PurchaseInventoryController@cancel')->name('manufacturing_inventory.cancel')->middleware('auth'); 
Route::get('manufacturing_receive/{id}', 'Manufacturing\PurchaseInventoryController@receive')->name('manufacturing_inventory.receive')->middleware('auth'); 
Route::get('manufacturing_make_payment/{id}', 'Manufacturing\PurchaseInventoryController@make_payment')->name('manufacturing_inventory.pay')->middleware('auth'); 
Route::get('manufacturing_inv_pdfview',array('as'=>'manufacturing_inv_pdfview','uses'=>'Manufacturing\PurchaseInventoryController@inv_pdfview'))->middleware('auth');

Route::any('packing_model/{$id}', 'Manufacturing\BillOfMaterialController@packing_model')->name('packing_model')->middleware('auth');

});


//radio
Route::group(['prefix' => 'radio'], function () {
Route::resource('radio_pickup', 'Radio\RadioPickupController')->middleware('auth');
Route::get('radio_pickup_approve/{id}', 'Radio\RadioPickupController@approve')->name('radio_pickup.approve')->middleware('auth'); 
Route::resource('radio_quotation', 'Radio\RadioController')->middleware('auth'); 
Route::post('add_program', 'Radio\RadioController@save_wbn')->name('radio.save_program');  
Route::get('radioModal', 'Radio\RadioController@discountModal')->middleware('auth'); 
Route::get('radio_edit/{id}', 'Radio\RadioController@receive')->name('radio.receive')->middleware('auth'); 
Route::post('radio_approve', 'Radio\RadioController@approve')->name('radio.approve')->middleware('auth'); 
Route::post('radio_cancel', 'Radio\RadioController@cancel')->name('radio.cancel')->middleware('auth'); 
Route::post('radio_finish', 'Radio\RadioController@finish')->name('radio.finish')->middleware('auth'); 
Route::get('radio_pay/{id}', 'Radio\RadioController@make_payment')->name('radio.pay')->middleware('auth'); 
Route::post('radio_payment', 'Radio\RadioController@save_payment')->name('radio.save_payment'); 
Route::post('save_radio_receive', 'Radio\RadioController@save_receive')->name('radio.save_receive')->middleware('auth');
Route::get('radio_pdfview',array('as'=>'radio_pdfview','uses'=>'Radio\RadioController@courier_pdfview'))->middleware('auth');
Route::get('schedule_pdfview',array('as'=>'schedule_pdfview','uses'=>'Radio\RadioController@schedule_pdfview'))->middleware('auth');
});

// inventory routes
Route::group(['prefix' => 'inventory'], function () {
Route::resource('location', 'Inventory\LocationController')->middleware('auth');
Route::resource('inventory', 'Inventory\InventoryController')->middleware('auth');
Route::post('inventory_import','Inventory\ImportItemsController@import')->name('inventory.import');
Route::post('inventory_sample','Inventory\ImportItemsController@sample')->name('inventory.sample');
Route::get('findItem', 'Inventory\InventoryController@findItem')->middleware('auth'); 
Route::post('update_quantity','Inventory\InventoryController@update_quantity')->name('inventory.update_quantity');
Route::resource('fieldstaff', 'Inventory\FieldStaffController')->middleware('auth');
Route::post('save_requisition', 'Inventory\MaintainanceController@save_requisition')->name('requisition.save');
Route::get('add_inventory_item', 'Inventory\PurchaseInventoryController@add_item')->middleware('auth');
Route::resource('requisition', 'Inventory\RequisitionController')->middleware('auth');
Route::get('requisition_cancel/{id}', 'Inventory\RequisitionController@cancel')->name('requisition.cancel')->middleware('auth'); 
Route::get('requisition_receive/{id}', 'Inventory\RequisitionController@receive')->name('requisition.receive')->middleware('auth');  
Route::get('requisition_pdfview',array('as'=>'requisition_pdfview','uses'=>'Inventory\RequisitionController@requisition_pdfview'))->middleware('auth');
Route::resource('purchase_inventory', 'Inventory\PurchaseInventoryController')->middleware('auth');
Route::get('findInvPrice', 'Inventory\PurchaseInventoryController@findPrice')->middleware('auth'); 
Route::get('invModal', 'Inventory\PurchaseInventoryController@discountModal')->middleware('auth');
Route::get('approve/{id}', 'Inventory\PurchaseInventoryController@approve')->name('inventory.approve')->middleware('auth'); 
Route::get('cancel/{id}', 'Inventory\PurchaseInventoryController@cancel')->name('inventory.cancel')->middleware('auth'); 
Route::get('receive/{id}', 'Inventory\PurchaseInventoryController@receive')->name('inventory.receive')->middleware('auth');
Route::post('grn','Inventory\PurchaseInventoryController@grn')->name('inventory.grn')->middleware('auth');
Route::get('issue/{id}', 'Inventory\PurchaseInventoryController@issue')->name('inventory.issue')->middleware('auth'); 
Route::get('make_payment/{id}', 'Inventory\PurchaseInventoryController@make_payment')->name('inventory.pay')->middleware('auth'); 
Route::get('inv_pdfview',array('as'=>'inv_pdfview','uses'=>'Inventory\PurchaseInventoryController@inv_pdfview'))->middleware('auth');
Route::get('inv_issue_pdfview',array('as'=>'inv_issue_pdfview','uses'=>'Inventory\PurchaseInventoryController@inv_issue_pdfview'))->middleware('auth');

Route::resource('inventory_debit_note', 'Inventory\ReturnPurchasesController')->middleware('auth');
Route::get('findinvoice', 'Inventory\ReturnPurchasesController@findPrice')->middleware('auth'); 
Route::get('showInvoice', 'Inventory\ReturnPurchasesController@showInvoice')->middleware('auth'); 
Route::get('editshowInvoice', 'Inventory\ReturnPurchasesController@editshowInvoice')->middleware('auth'); 
Route::get('findinvQty', 'Inventory\ReturnPurchasesController@findQty')->middleware('auth'); 
Route::get('approve_debit_note/{id}', 'Inventory\ReturnPurchasesController@approve')->name('inventory_debit_note.approve')->middleware('auth'); 
Route::get('cancel_debit_note/{id}', 'Inventory\ReturnPurchasesController@cancel')->name('inventory_debit_note.cancel')->middleware('auth'); 
Route::get('receive_debit_note/{id}', 'Inventory\ReturnPurchasesController@receive')->name('inventory_debit_note.receive')->middleware('auth'); 
Route::get('debit_note_pdfview',array('as'=>'inventory_debit_note_pdfview','uses'=>'Inventory\ReturnPurchasesController@debit_note_pdfview'))->middleware('auth');
Route::get('order_payment/{id}', 'orders\OrdersController@order_payment')->name('order.pay')->middleware('auth');
Route::get('inventory_list', 'Inventory\PurchaseInventoryController@inventory_list')->name('inventory.list')->middleware('auth');
Route::post('save_inv_reference', 'Inventory\PurchaseInventoryController@save_reference')->name('reference_inv.save')->middleware('auth');
Route::resource('inventory_payment', 'Inventory\InventoryPaymentController')->middleware('auth');
Route::get('payment_pdfview',array('as'=>'inventory_payment_pdfview','uses'=>'Inventory\InventoryPaymentController@payment_pdfview'))->middleware('auth');
Route::resource('order_payment', 'orders\OrderPaymentController')->middleware('auth');
Route::resource('maintainance', 'Inventory\MaintainanceController')->middleware('auth');
Route::post('save_mechanical_report', 'Inventory\MaintainanceController@save_report')->name('maintainance.report')->middleware('auth');
Route::get('change_m_status/{id}', 'Inventory\MaintainanceController@approve')->name('maintainance.approve')->middleware('auth'); 
Route::resource('service', 'Inventory\ServiceController')->middleware('auth');
Route::resource('service_type', 'Inventory\ServiceTypeController')->middleware('auth');
Route::get('change_s_status/{id}', 'Inventory\ServiceController@approve')->name('service.approve')->middleware('auth');
Route::post('save_purchase', 'Inventory\ServiceController@save_purchase')->name('service.save_purchase')->middleware('auth');
Route::resource('good_issue', 'Inventory\GoodIssueController')->middleware('auth');
Route::get('issue_approve/{id}', 'Inventory\GoodIssueController@approve')->name('good_issue.approve')->middleware('auth'); 
Route::get('return_issued/{id}', 'Inventory\GoodIssueController@return')->name('good_issue.returned')->middleware('auth');
Route::get('disposal_issued/{id}', 'Inventory\GoodIssueController@disposal')->name('good_issue.disposed')->middleware('auth');
Route::post('issue_return', 'Inventory\GoodIssueController@save_return')->name('good_issue.return')->middleware('auth');
Route::post('issue_disposal', 'Inventory\GoodIssueController@save_disposal')->name('good_issue.disposal')->middleware('auth');
Route::get('findIssueItem', 'Inventory\GoodIssueController@findItem')->middleware('auth');
Route::get('issueModal', 'Inventory\GoodIssueController@discountModal'); 
Route::get('findIssueService', 'Inventory\GoodIssueController@findService')->middleware('auth');
Route::resource('good_return', 'Inventory\GoodReturnController')->middleware('auth');
Route::get('return_approve/{id}', 'Inventory\GoodReturnController@approve')->name('return.approve')->middleware('auth');

Route::resource('good_movement', 'Inventory\GoodMovementController')->middleware('auth');
Route::get('movement_approve/{id}', 'Inventory\GoodMovementController@approve')->name('good_movement.approve')->middleware('auth'); 
Route::get('findMovementQuantity', 'Inventory\GoodMovementController@findQuantity'); 
Route::get('movementModal', 'Inventory\GoodMovementController@discountModal'); 

Route::resource('good_reallocation', 'Inventory\GoodReallocationController')->middleware('auth');
Route::get('reallocation_approve/{id}', 'Inventory\GoodReallocationController@approve')->name('good_reallocation.approve')->middleware('auth'); 
Route::get('getInventory', 'Inventory\GoodReallocationController@getInventory'); 
Route::resource('good_disposal', 'Inventory\GoodDisposalController')->middleware('auth');
Route::get('disposal_approve/{id}', 'Inventory\GoodDisposalController@approve')->name('good_disposal.approve')->middleware('auth'); 
Route::get('findReturnService', 'Inventory\GoodReturnController@findService')->middleware('auth');


Route::get('findInvItem', 'Inventory\InvoiceController@findItem')->middleware('auth');
Route::get('add_sales_inventory_item', 'Inventory\InvoiceController@add_item')->middleware('auth');
Route::resource('inventory_invoice', 'Inventory\InvoiceController')->middleware('auth');  
Route::get('inventory_findInvPrice', 'Inventory\InvoiceController@findPrice')->middleware('auth'); 
Route::get('salesModal', 'Inventory\InvoiceController@discountModal')->middleware('auth');
Route::get('invoice_make_payment/{id}', 'Inventory\InvoiceController@make_payment')->name('inventory_invoice.pay')->middleware('auth'); 
Route::get('inventory_invoice_pdfview',array('as'=>'inventory_invoice_pdfview','uses'=>'Inventory\InvoiceController@invoice_pdfview'))->middleware('auth');
Route::get('inventory_invoice_receipt',array('as'=>'inventory_invoice_receipt','uses'=>'Inventory\InvoiceController@invoice_receipt'))->middleware('auth');
Route::resource('inventory_invoice_payment', 'Inventory\InvoicePaymentController')->middleware('auth');
Route::get('invoice_payment_pdfview',array('as'=>'inventory_invoice_payment_pdfview','uses'=>'Inventory\InvoicePaymentController@payment_pdfview'))->middleware('auth'); 
Route::resource('inventory_credit_note', 'Inventory\ReturnInvoiceController')->middleware('auth');
Route::get('inventory_findinvoice', 'Inventory\ReturnInvoiceController@findPrice')->middleware('auth'); 
Route::get('inventory_showInvoice', 'Inventory\ReturnInvoiceController@showInvoice')->middleware('auth'); 
Route::get('inventory_editshowInvoice', 'Inventory\ReturnInvoiceController@editshowInvoice')->middleware('auth'); 
Route::get('inventory_findinvQty', 'Inventory\ReturnInvoiceController@findQty')->middleware('auth'); 
Route::get('approve_credit_note/{id}', 'Inventory\ReturnInvoiceController@approve')->name('inventory_credit_note.approve')->middleware('auth'); 
Route::get('cancel_credit_note/{id}', 'Inventory\ReturnInvoiceController@cancel')->name('inventory_credit_note.cancel')->middleware('auth'); 
Route::get('receive_credit_note/{id}', 'Inventory\ReturnInvoiceController@receive')->name('inventory_credit_note.receive')->middleware('auth'); 
Route::get('credit_note_pdfview',array('as'=>'inventory_credit_note_pdfview','uses'=>'Inventory\ReturnInvoiceController@credit_note_pdfview'))->middleware('auth');




});

// cotton routes
Route::group(['prefix' => 'cotton_production'], function () {
Route::resource('costants', 'Cotton\CostantsController')->middleware('auth');
Route::resource('production', 'Cotton\ProductionController')->middleware('auth');
});

Route::group(['prefix' => 'cotton_invoice'], function () {
Route::resource('cotton_sales', 'Cotton\InvoiceController')->middleware('auth');
Route::resource('seed_list', 'Cotton\SeedListController')->middleware('auth');
Route::resource('seed_sales', 'Cotton\SeedInvoiceController')->middleware('auth');
});

Route::group(['prefix' => 'report'], function () {
Route::any('stock_report', 'Cotton\CollectionCenterController@stock_report')->middleware('auth');
Route::any('invoice_report', 'Cotton\ReportController@invoice_report')->middleware('auth');
Route::any('center_report', 'Cotton\CollectionCenterController@center_report')->middleware('auth');
Route::any('cotton_movement_report', 'Cotton\CollectionCenterController@cotton_movement_report')->middleware('auth');
Route::any('levy_report', 'Cotton\ReportController@levy_report')->middleware('auth');
//Route::any('debtors_report', 'Cotton\ReportController@debtors_report')->middleware('auth');
Route::any('general_report', 'Cotton\ReportController@general_report')->middleware('auth');
Route::any('general_report2', 'Cotton\ReportController@general_report2')->middleware('auth');
});


Route::group(['prefix' => 'cotton_collection'], function () {
Route::get('production_pdfview',array('as'=>'production_pdfview','uses'=>'Cotton\ProductionController@inv_pdfview'))->middleware('auth');
Route::resource('operator', 'Cotton\OperatorController')->middleware('auth');
Route::resource('collection_center', 'Cotton\CollectionCenterController')->middleware('auth');
Route::resource('district', 'Cotton\DistrictController')->middleware('auth');
Route::get('findCenterDistrict', 'Cotton\CollectionCenterController@findRegion')->middleware('auth');
Route::get('findCenterRegion', 'Cotton\CollectionCenterController@findDistrict')->middleware('auth');
Route::get('centerModal', 'Cotton\CollectionCenterController@discountModal')->middleware('auth');
Route::get('addOperator', 'Cotton\CollectionCenterController@addOperator')->middleware('auth');
Route::get('addLicence', 'Cotton\CollectionCenterController@addLicence')->middleware('auth');
Route::resource('top_up_operator', 'Cotton\TopUpOperatorController')->middleware('auth');
Route::get('complete_operator', 'Cotton\TopUpOperatorController@complete_operator')->middleware('auth');
Route::get('complete_center', 'Cotton\TopUpCenterController@complete_center')->middleware('auth');
Route::get('top_up_operator_approve/{id}', 'Cotton\TopUpOperatorController@approve')->name('operator.approve')->middleware('auth');
Route::get('findOperator', 'Cotton\TopUpOperatorController@findOperator')->middleware('auth');
Route::get('findCenter', 'Cotton\TopUpCenterController@findCenter')->middleware('auth');
Route::get('findCenterName', 'Cotton\TopUpCenterController@findCenterName')->middleware('auth');
Route::resource('top_up_center', 'Cotton\TopUpCenterController')->middleware('auth');
Route::get('top_up_center_approve/{id}', 'Cotton\TopUpCenterController@approve')->name('center.approve')->middleware('auth');
Route::resource('cotton_list', 'Cotton\CottonController')->middleware('auth');
Route::resource('levy_list', 'Cotton\LevyController')->middleware('auth');
Route::resource('purchase_cotton', 'Cotton\PurchaseCottonController')->middleware('auth');
Route::get('findStock', 'Cotton\PurchaseCottonController@findStock')->middleware('auth'); 
Route::get('findCottonPrice', 'Cotton\PurchaseCottonController@findPrice')->middleware('auth'); 
Route::get('cotton_approve/{id}', 'Cotton\PurchaseCottonController@approve')->name('cotton.approve')->middleware('auth'); 
Route::get('cotton_cancel/{id}', 'Cotton\PurchaseCottonController@cancel')->name('cotton.cancel')->middleware('auth'); 
Route::get('cotton_receive/{id}', 'Cotton\PurchaseCottonController@receive')->name('cotton.receive')->middleware('auth'); ; 
Route::get('cotton_pdfview',array('as'=>'cotton_pdfview','uses'=>'Cotton\PurchaseCottonController@inv_pdfview'))->middleware('auth');
Route::resource('cotton_movement', 'Cotton\GoodMovementController')->middleware('auth');
Route::get('cotton_movement_approve/{id}', 'Cotton\GoodMovementController@approve')->name('cotton_movement.approve')->middleware('auth'); 
Route::get('cotton_check_balance', 'Cotton\GoodMovementController@chekBalance')->name('cotton_movement.chekBalance')->middleware('auth'); 
Route::get('findQuantity', 'Cotton\GoodMovementController@findQuantity')->middleware('auth'); 
Route::get('findPurchase', 'Cotton\GoodMovementController@findPurchase')->middleware('auth'); 
Route::get('itemsModal', 'Cotton\GoodMovementController@discountModal')->middleware('auth');
Route::get('reverseCenterModal', 'Cotton\TopUpCenterController@discountModal')->middleware('auth');
Route::post('newreverseCenter', 'Cotton\TopUpCenterController@newdiscount')->middleware('auth');
Route::get('center_complete/{id}', 'Cotton\TopUpCenterController@complete')->name('center.complete')->middleware('auth'); 
Route::get('reverse_top_up_center', 'Cotton\TopUpCenterController@reverse_top_center')->middleware('auth'); 
Route::get('reverseOperatorModal', 'Cotton\TopUpOperatorController@discountModal')->middleware('auth');
Route::post('newreverseOperator', 'Cotton\TopUpOperatorController@newdiscount')->middleware('auth');
Route::get('operator_complete/{id}', 'Cotton\TopUpOperatorController@complete')->name('operator.complete')->middleware('auth'); 
Route::get('reverse_top_up_operator', 'Cotton\TopUpOperatorController@reverse_top_operator')->middleware('auth'); 


Route::resource('general_report_table', 'Cotton\ReportController')->middleware('auth');
Route::resource('cotton_client', 'Cotton\CottonClientController')->middleware('auth');

Route::get('findSalesPrice', 'Cotton\InvoiceController@findPrice')->middleware('auth'); 
Route::get('cotton_payment/{id}', 'Cotton\InvoiceController@make_payment')->name('invoice.pay')->middleware('auth'); 
Route::get('sales_pdfview',array('as'=>'sales_pdfview','uses'=>'Cotton\InvoiceController@sales_pdfview'))->middleware('auth');
Route::resource('cotton_sales_payment', 'Cotton\InvoicePaymentController')->middleware('auth');

Route::get('findSeedPrice', 'Cotton\SeedInvoiceController@findPrice')->middleware('auth'); 
Route::get('seed_payment/{id}', 'Cotton\SeedInvoiceController@make_payment')->name('seed.pay')->middleware('auth'); 
Route::get('seed_pdfview',array('as'=>'seed_pdfview','uses'=>'Cotton\SeedInvoiceController@seed_pdfview'))->middleware('auth');
Route::resource('seed_sales_payment', 'Cotton\SeedPaymentController')->middleware('auth');
Route::resource('assign_driver', 'Cotton\AssignDriverController')->middleware('auth');
Route::get('assign_driver_approve/{id}', 'Cotton\AssignDriverController@approve')->name('assign_driver.approve')->middleware('auth'); 
Route::post('newreverseDriver', 'Cotton\AssignDriverController@newdiscount')->middleware('auth');
Route::get('reverse_assign_driver', 'Cotton\AssignDriverController@reverse_assign_driver')->middleware('auth'); 
Route::resource('assign_center', 'Cotton\AssignCenterController')->middleware('auth');
Route::get('assign_center_approve/{id}', 'Cotton\AssignCenterController@approve')->name('assign_center.approve')->middleware('auth'); 
Route::post('newreverseAssignCenter', 'Cotton\AssignCenterController@newdiscount')->middleware('auth');
Route::get('reverse_assign_center', 'Cotton\AssignCenterController@reverse_assign_center')->middleware('auth'); 
});




Route::group(['prefix' => 'fuel'], function () {
Route::get('findFromRegion', 'RouteController@findFromRegion')->middleware('auth');  
Route::get('findToRegion', 'RouteController@findToRegion')->middleware('auth'); 
});

//fuel
Route::resource('fuel', 'Fuel\FuelController')->middleware('auth');
Route::get('return_fuel', 'Fuel\FuelController@return_fuel')->name('fuel.return')->middleware('auth');
Route::any('fuel_report', 'Fuel\FuelController@fuel_report')->name('fuel.report')->middleware('auth');
Route::resource('refill_payment', 'Fuel\RefillPaymentController')->middleware('auth');
Route::get('refill_list', 'Fuel\FuelController@refill_list')->name('refill_list')->middleware('auth'); ;
Route::get('multiple_refill_payment', 'Fuel\RefillPaymentController@multiple_refill_payment')->name('multiple_refill_list')->middleware('auth');
Route::post('save_multiple_payment', 'Fuel\RefillPaymentController@save_multiple_payment')->name('save_multiple_refill')->middleware('auth');
Route::get('fuel_approve/{id}', 'Fuel\FuelController@approve')->name('fuel.approve')->middleware('auth');
Route::get('discountModal', 'Fuel\FuelController@discountModal')->middleware('auth');
Route::get('addRoute', 'Fuel\FuelController@route')->middleware('auth');


Route::resource('routes', 'RouteController')->middleware('auth');
Route::get('addLocation', 'RouteController@addlocation')->middleware('auth');
Route::get('findLocation', 'RouteController@findlocation')->middleware('auth');
Route::get('locationModal', 'RouteController@discountModal')->middleware('auth');
Route::get('routes_delete/{id}', 'RouteController@delete')->name('routes.delete')->middleware('auth');
Route::resource('destination', 'DestinationController')->middleware('auth');



//leave
Route::group(['prefix' => 'leave'], function () {
Route::resource('leave', 'Leave\LeaveController')->middleware('auth');
Route::resource('leave_category', 'Leave\LeaveCategoryController')->middleware('auth');
Route::post('addCategory', 'Leave\LeaveController@category')->middleware('auth');
Route::get('findPaid', 'Leave\LeaveController@findPaid')->middleware('auth');
Route::get('findDays', 'Leave\LeaveController@findDays')->middleware('auth');
Route::get('leave_approve/{id}', 'Leave\LeaveController@approve')->name('leave.approve')->middleware('auth');
Route::get('leave_reject/{id}', 'Leave\LeaveController@reject')->name('leave.reject')->middleware('auth');
});

//training
Route::group(['prefix' => 'training'], function () {
Route::resource('training', 'Training\TrainingController')->middleware('auth');
Route::get('training_start/{id}', 'Training\TrainingController@start')->name('training.start')->middleware('auth');
Route::get('training_approve/{id}', 'Training\TrainingController@approve')->name('training.approve')->middleware('auth');
Route::get('training_reject/{id}', 'Training\TrainingController@reject')->name('training.reject')->middleware('auth');
});

// tyre routes
Route::group(['prefix' => 'tyre'], function () {
Route::resource('tyre_brand', 'Tyre\TyreBrandController')->middleware('auth');
Route::post('tyre_import','Tyre\ImportItemsController@import')->name('tyre.import');
Route::post('tyre_sample','Tyre\ImportItemsController@sample')->name('tyre.sample');
Route::get('findItem', 'Tyre\TyreBrandController@findItem')->middleware('auth'); 
Route::post('update_quantity','Tyre\TyreBrandController@update_quantity')->name('tyre.update_quantity');
Route::get('tyre_list', 'Tyre\PurchaseTyreController@tyre_list')->name('tyre.list')->middleware('auth');
Route::resource('purchase_tyre', 'Tyre\PurchaseTyreController')->middleware('auth');
Route::get('add_tyre_item', 'Tyre\PurchaseTyreController@add_item')->middleware('auth');
Route::get('invModal', 'Tyre\PurchaseTyreController@discountModal')->middleware('auth');
Route::get('findTyrePrice', 'Tyre\PurchaseTyreController@findPrice')->middleware('auth'); 
Route::get('tyre_approve/{id}', 'Tyre\PurchaseTyreController@approve')->name('purchase_tyre.approve')->middleware('auth'); 
Route::get('tyre_cancel/{id}', 'Tyre\PurchaseTyreController@cancel')->name('purchase_tyre.cancel')->middleware('auth'); 
Route::get('tyre_receive/{id}', 'Tyre\PurchaseTyreController@receive')->name('purchase_tyre.receive')->middleware('auth'); 
Route::get('make_tyre_payment/{id}', 'Tyre\PurchaseTyreController@make_payment')->name('purchase_tyre.pay')->middleware('auth'); 
Route::post('grn','Tyre\PurchaseTyreController@grn')->name('tyre.grn')->middleware('auth');
Route::get('issue/{id}', 'Tyre\PurchaseTyreController@issue')->name('tyre.issue')->middleware('auth'); 
Route::get('tyre_issue_pdfview',array('as'=>'tyre_issue_pdfview','uses'=>'Tyre\PurchaseTyreController@inv_issue_pdfview'))->middleware('auth');
Route::get('tyre_pdfview',array('as'=>'tyre_pdfview','uses'=>'Tyre\PurchaseTyreController@tyre_pdfview'))->middleware('auth');
Route::resource('tyre_payment', 'Tyre\TyrePaymentController')->middleware('auth');
Route::get('payment_pdfview',array('as'=>'tyre_payment_pdfview','uses'=>'Tyre\TyrePaymentController@payment_pdfview'))->middleware('auth');
Route::resource('tyre_debit_note', 'Tyre\ReturnPurchasesController')->middleware('auth');
Route::get('findinvoice', 'Tyre\ReturnPurchasesController@findPrice')->middleware('auth'); 
Route::get('showInvoice', 'Tyre\ReturnPurchasesController@showInvoice')->middleware('auth'); 
Route::get('editshowInvoice', 'Tyre\ReturnPurchasesController@editshowInvoice')->middleware('auth'); 
Route::get('findinvQty', 'Tyre\ReturnPurchasesController@findQty')->middleware('auth'); 
Route::get('approve_debit_note/{id}', 'Tyre\ReturnPurchasesController@approve')->name('tyre_debit_note.approve')->middleware('auth'); 
Route::get('cancel_debit_note/{id}', 'Tyre\ReturnPurchasesController@cancel')->name('tyre_debit_note.cancel')->middleware('auth'); 
Route::get('receive_debit_note/{id}', 'Tyre\ReturnPurchasesController@receive')->name('tyre_debit_note.receive')->middleware('auth'); 
Route::get('debit_note_pdfview',array('as'=>'tyre_debit_note_pdfview','uses'=>'Tyre\ReturnPurchasesController@debit_note_pdfview'))->middleware('auth');
Route::get('assign_truck', 'Tyre\PurchaseTyreController@assign_truck')->name('purchase_tyre.assign')->middleware('auth');
Route::get('tyreModal', 'Tyre\PurchaseTyreController@discountModal')->middleware('auth');
Route::post('save_reference', 'Tyre\PurchaseTyreController@save_reference')->name('reference_tyre.save')->middleware('auth');
Route::post('save_truck', 'Tyre\PurchaseTyreController@save_truck')->name('purchase_tyre.save')->middleware('auth');
Route::resource('tyre_reallocation', 'Tyre\TyreReallocationController')->middleware('auth');
Route::get('tyre_reallocation_approve/{id}', 'Tyre\TyreReallocationController@approve')->name('tyre_reallocation.approve')->middleware('auth'); 
Route::resource('tyre_disposal', 'Tyre\TyreDisposalController')->middleware('auth');
Route::get('tyre_disposal_approve/{id}', 'Tyre\TyreDisposalController@approve')->name('tyre_disposal.approve')->middleware('auth'); 
Route::resource('tyre_return', 'Tyre\TyreReturnController')->middleware('auth');
Route::get('findTyreDetails', 'Tyre\TyreReturnController@findPrice')->middleware('auth'); 
Route::get('findTyrePosition', 'Tyre\TyreReallocationController@findPosition')->middleware('auth'); 
Route::get('tyre_return_approve/{id}', 'Tyre\TyreReturnController@approve')->name('tyre_return.approve')->middleware('auth'); 
Route::get('addSupp', 'Tyre\PurchaseTyreController@addSupp')->middleware('auth');


Route::get('findInvItem', 'Tyre\InvoiceController@findItem')->middleware('auth');
Route::get('add_sales_tyre_item', 'Tyre\InvoiceController@add_item')->middleware('auth');
Route::resource('tyre_invoice', 'Tyre\InvoiceController')->middleware('auth');  
Route::get('tyre_findInvPrice', 'Tyre\InvoiceController@findPrice')->middleware('auth'); 
Route::get('salesModal', 'Tyre\InvoiceController@discountModal')->middleware('auth');
Route::get('invoice_make_payment/{id}', 'Tyre\InvoiceController@make_payment')->name('tyre_invoice.pay')->middleware('auth'); 
Route::get('tyre_invoice_pdfview',array('as'=>'tyre_invoice_pdfview','uses'=>'Tyre\InvoiceController@invoice_pdfview'))->middleware('auth');
Route::get('tyre_invoice_receipt',array('as'=>'tyre_invoice_receipt','uses'=>'Tyre\InvoiceController@invoice_receipt'))->middleware('auth');
Route::resource('tyre_invoice_payment', 'Tyre\InvoicePaymentController')->middleware('auth');
Route::get('invoice_payment_pdfview',array('as'=>'tyre_invoice_payment_pdfview','uses'=>'Tyre\InvoicePaymentController@payment_pdfview'))->middleware('auth'); 
Route::resource('tyre_credit_note', 'Tyre\ReturnInvoiceController')->middleware('auth');
Route::get('tyre_findinvoice', 'Tyre\ReturnInvoiceController@findPrice')->middleware('auth'); 
Route::get('tyre_showInvoice', 'Tyre\ReturnInvoiceController@showInvoice')->middleware('auth'); 
Route::get('tyre_editshowInvoice', 'Tyre\ReturnInvoiceController@editshowInvoice')->middleware('auth'); 
Route::get('tyre_findinvQty', 'Tyre\ReturnInvoiceController@findQty')->middleware('auth'); 
Route::get('approve_credit_note/{id}', 'Tyre\ReturnInvoiceController@approve')->name('tyre_credit_note.approve')->middleware('auth'); 
Route::get('cancel_credit_note/{id}', 'Tyre\ReturnInvoiceController@cancel')->name('tyre_credit_note.cancel')->middleware('auth'); 
Route::get('receive_credit_note/{id}', 'Tyre\ReturnInvoiceController@receive')->name('tyre_credit_note.receive')->middleware('auth'); 
Route::get('credit_note_pdfview',array('as'=>'tyre_credit_note_pdfview','uses'=>'Tyre\ReturnInvoiceController@credit_note_pdfview'))->middleware('auth');

});


//cargo management
Route::group(['prefix' => 'pacel'], function () {
Route::resource('pacel_list', 'Pacel\PacelListController')->middleware('auth');
Route::resource('pacel_quotation', 'Pacel\PacelController')->middleware('auth');

Route::get('pacel_disable/{id}', 'Pacel\PacelController@disable')->name('pacel.disable')->middleware('auth'); 
Route::get('pacel_invoice', 'Pacel\PacelController@invoice')->name('pacel.invoice')->middleware('auth');
Route::get('invoice_details/{id}', 'Pacel\PacelController@details')->name('invoice.details')->middleware('auth'); 
Route::get('edit_invoice/{id}', 'Pacel\PacelController@edit_invoice')->name('edit.invoice')->middleware('auth'); 
Route::get('invoice_pdfview',array('as'=>'invoice_pdfview','uses'=>'Pacel\PacelController@invoice_pdfview'))->middleware('auth');
Route::get('findPacelPrice', 'Pacel\PacelController@findPrice')->middleware('auth'); 
Route::get('pacel_approve/{id}', 'Pacel\PacelController@approve')->name('pacel.approve')->middleware('auth'); 
Route::get('pacel_cancel/{id}', 'Pacel\PacelController@cancel')->name('pacel.cancel')->middleware('auth');  
Route::get('make_pacel_payment/{id}', 'Pacel\PacelController@make_payment')->name('pacel.pay')->middleware('auth'); 
Route::get('pacel_pdfview',array('as'=>'pacel_pdfview','uses'=>'Pacel\PacelController@pacel_pdfview'))->middleware('auth');
Route::resource('pacel_payment', 'Pacel\PacelPaymentController')->middleware('auth');
Route::get('pacelModal', 'Pacel\PacelController@discountModal')->middleware('auth');
Route::post('newdiscount', 'Pacel\PacelController@newdiscount')->middleware('auth');
Route::get('addSupplier', 'Pacel\PacelController@addSupplier')->middleware('auth');
//Route::get('addRoute', 'Pacel\PacelController@addRoute')->middleware('auth');
Route::resource('mileage_payment', 'MileagePaymentController')->middleware('auth');
Route::get('mileage', 'MileagePaymentController@mileage')->name('mileage')->middleware('auth'); ;
Route::get('mileageModal', 'MileagePaymentController@discountModal')->middleware('auth');
Route::get('mileage_approve/{id}', 'MileagePaymentController@approve')->name('mileage.approve')->middleware('auth');
Route::get('multiple_mileage', 'MileagePaymentController@multiple_mileage')->name('multiple_mileage')->middleware('auth');
Route::post('multiple_mileage_payment', 'MileagePaymentController@multiple_approve')->name('multiple_mileage_payment')->middleware('auth');
});


//permit
Route::resource('permit_payment', 'Permit\PermitPaymentController')->middleware('auth');
Route::get('permit', 'Permit\PermitPaymentController@permit')->name('permit')->middleware('auth'); ;
Route::get('permitModal', 'Permit\PermitPaymentController@discountModal')->middleware('auth');
Route::get('permit_approve/{id}', 'Permit\PermitPaymentController@approve')->name('permit.approve')->middleware('auth');
Route::get('multiple_permit', 'Permit\PermitPaymentController@multiple_permit')->name('multiple_permit')->middleware('auth');
Route::post('multiple_permit_payment', 'Permit\PermitPaymentController@multiple_approve')->name('multiple_permit_payment')->middleware('auth');

//cargo tracking
Route::group(['prefix' => 'tracking'], function () {
Route::get('collection', 'Activity\OrderMovementController@collection')->name('order.collection')->middleware('auth');
Route::get('loading', 'Activity\OrderMovementController@loading')->name('order.loading')->middleware('auth');
Route::get('offloading', 'Activity\OrderMovementController@offloading')->name('order.offloading')->middleware('auth');
Route::get('delivering', 'Activity\OrderMovementController@delivering')->name('order.delivering')->middleware('auth');
Route::get('driver_checklist_report/{id}', 'Activity\OrderMovementController@driver_checklist_report')->name('driver_checklist_report')->middleware('auth');
Route::get('driver_checklist_report_pdf/{id}', 'Activity\OrderMovementController@driver_checklist_report_pdf')->name('driver_checklist_report_pdf')->middleware('auth');
Route::get('wb', 'Activity\OrderMovementController@wb')->name('order.wb')->middleware('auth');
Route::post('save_wb', 'Activity\OrderMovementController@save_wb')->name('save.wb')->middleware('auth');
Route::get('edit_cargo/{id}', 'Activity\OrderMovementController@edit_cargo')->name('order.edit_cargo')->middleware('auth');
Route::post('update_cargo', 'Activity\OrderMovementController@update_cargo')->name('order.update_cargo')->middleware('auth');
Route::resource('order_movement', 'Activity\OrderMovementController')->middleware('auth');
Route::get('findTruck', 'Activity\OrderMovementController@findTruck')->middleware('auth');  
Route::get('findDriver', 'Activity\OrderMovementController@findDriver')->middleware('auth');  
Route::resource('activity', 'Activity\ActivityController')->middleware('auth');
Route::get('order_report', 'Activity\OrderMovementController@report')->name('order.report')->middleware('auth');
Route::get('findReport', 'Activity\OrderMovementController@findReport')->middleware('auth');
Route::get('findExp', 'Activity\OrderMovementController@findPrice')->middleware('auth');  
Route::get('truck_mileage', 'Activity\OrderMovementController@return')->name('order.return')->middleware('auth');
});







//courier
Route::group(['prefix' => 'courier'], function () {
Route::resource('courier_list', 'Courier\CourierListController')->middleware('auth');
Route::resource('courier_client', 'Courier\CourierClientController')->middleware('auth');
Route::resource('zones', 'ZoneController')->middleware('auth');
Route::resource('tariff', 'TariffController')->middleware('auth');
Route::post('tariff_import','TariffController@import')->name('tariff.import');
Route::post('tariff_sample','TariffController@sample')->name('tariff.sample');
Route::resource('courier_pickup', 'Courier\CourierPickupController')->middleware('auth');
Route::get('courier_pickup_approve/{id}', 'Courier\CourierPickupController@approve')->name('courier_pickup.approve')->middleware('auth'); 
Route::resource('courier_quotation', 'Courier\CourierController')->middleware('auth');
Route::get('courier_settings', 'Courier\CourierController@settings')->name('courier.settings')->middleware('auth'); 
Route::post('courier_save_settings', 'Courier\CourierController@add_settings')->name('courier.save_settings');

Route::post('assignCourier', 'Courier\CourierController@assign')->name('courier.assign');
Route::post('addwbn', 'Courier\CourierController@save_wbn')->name('courier.save_wbn');
Route::post('assign_wbn', 'Courier\CourierController@assign_wbn')->name('courier.assign_wbn');
Route::get('add_trip/{id}', 'Courier\CourierController@add_trip')->name('courier.add_trip')->middleware('auth'); 
Route::get('close_trip/{id}', 'Courier\CourierController@close_trip')->name('courier.close_trip')->middleware('auth'); 
Route::delete('delete_parent/{id}', 'Courier\CourierController@delete_parent')->name('courier_quotation.delete_parent')->middleware('auth'); 
Route::resource('courier', 'Courier\NewCourierController')->middleware('auth');
Route::get('addSales', 'Courier\NewCourierController@addSales');
Route::get('addPickup', 'Courier\NewCourierController@addPickup');
Route::get('addFreight', 'Courier\NewCourierController@addFreight');
Route::get('addCommission', 'Courier\NewCourierController@addCommission');
Route::post('addDelivery', 'Courier\NewCourierController@addDelivery')->name('add.delivery')->middleware('auth');
Route::post('addNewSales', 'Courier\NewCourierController@addNewSales')->name('add.sales')->middleware('auth');
Route::get('new_courier_report', 'Courier\NewCourierController@report')->middleware('auth');
Route::get('findNewCourierReport', 'Courier\NewCourierController@findReport')->middleware('auth');
Route::resource('storage_settings', 'Courier\StorageController')->middleware('auth');
Route::get('courier_invoice', 'Courier\CourierController@invoice')->name('courier.invoice')->middleware('auth');
Route::get('courier_invoice_details/{id}', 'Courier\CourierController@details')->name('courier.details')->middleware('auth'); 
Route::get('courier_edit_invoice/{id}', 'Courier\CourierController@edit_invoice')->name('courier_edit.invoice')->middleware('auth'); 
Route::post('courier_save_invoice', 'Courier\CourierController@save_invoice')->name('courier_save.invoice')->middleware('auth');
Route::get('courier_approve/{id}', 'Courier\CourierController@approve')->name('courier.approve')->middleware('auth');
Route::post('courier_reverse', 'Courier\CourierController@reverse')->name('courier.reverse')->middleware('auth');
Route::get('courier_receive/{id}', 'Courier\CourierController@receive')->name('courier.receive')->middleware('auth'); 
Route::post('save_courier_receive', 'Courier\CourierController@save_receive')->name('courier.save_receive')->middleware('auth');
Route::get('courier_start/{id}', 'Courier\CourierController@start')->name('courier.start')->middleware('auth'); 
Route::post('save_courier_start', 'Courier\CourierController@save_start')->name('courier.save_start')->middleware('auth');
Route::get('edit_formula/{id}', 'Courier\CourierController@edit_formula')->name('courier.formula')->middleware('auth'); 
Route::get('findCourierPrice', 'Courier\CourierController@findPrice')->middleware('auth'); 
Route::get('findTariff', 'Courier\CourierController@findTariff')->middleware('auth'); 
Route::get('findTariff2', 'Courier\CourierController@findTariff2')->middleware('auth'); 
Route::get('courier_approve/{id}', 'Courier\CourierController@approve')->name('courier.approve')->middleware('auth'); 
Route::get('courier_cancel/{id}', 'Courier\CourierController@cancel')->name('courier.cancel')->middleware('auth');  
Route::get('make_courier_payment/{id}', 'Courier\CourierController@make_payment')->name('courier.pay')->middleware('auth'); 
Route::get('courier_pdfview',array('as'=>'courier_pdfview','uses'=>'Courier\CourierController@courier_pdfview'))->middleware('auth');
Route::get('courier_invoice_pdfview',array('as'=>'courier_invoice_pdfview','uses'=>'Courier\CourierController@courier_invoice_pdfview'))->middleware('auth');
Route::resource('courier_payment', 'Courier\CourierPaymentController')->middleware('auth');
Route::get('courierModal', 'Courier\CourierController@discountModal')->middleware('auth');
Route::post('newCourierDiscount', 'Courier\CourierController@newdiscount')->middleware('auth');
Route::get('addCourierSupplier', 'Courier\CourierController@addSupplier')->middleware('auth');
Route::get('addCourierRoute', 'Courier\CourierController@addRoute')->middleware('auth');

Route::get('courier_collection', 'Courier\CourierMovementController@collection')->name('courier.collection')->middleware('auth');
Route::get('courier_loading', 'Courier\CourierMovementController@loading')->name('courier.loading')->middleware('auth');
Route::post('save_freight', 'Courier\CourierMovementController@save_freight')->name('save.freight')->middleware('auth');
Route::get('courier_offloading', 'Courier\CourierMovementController@offloading')->name('courier.offloading')->middleware('auth');
Route::get('courier_delivering', 'Courier\CourierMovementController@delivering')->name('courier.delivering')->middleware('auth');
Route::get('courier_delivered', 'Courier\CourierMovementController@delivered')->name('courier.delivered')->middleware('auth');
Route::get('courier_wb', 'Courier\CourierMovementController@wb')->name('wb.courier')->middleware('auth');
Route::post('save_courier_wb', 'Courier\CourierMovementController@save_wb')->name('courier.wb')->middleware('auth');
Route::get('freight_list', 'Courier\CourierMovementController@freight_list')->name('courier.freight')->middleware('auth');
Route::resource('courier_movement', 'Courier\CourierMovementController')->middleware('auth'); 
Route::resource('courier_activity', 'Courier\CourierActivityController')->middleware('auth');
Route::get('courier_report', 'Courier\CourierMovementController@report')->name('courier.report')->middleware('auth');
Route::any('cost_report', 'Courier\CourierMovementController@cost_report')->name('courier.cost_report')->middleware('auth');
Route::any('courier_tracking', 'Courier\CourierMovementController@courier_tracking')->name('courier.tracking')->middleware('auth');
Route::get('findCourierReport', 'Courier\CourierMovementController@findReport')->middleware('auth');

Route::get('payment_list', 'Courier\CourierController@payment_list')->name('courier.payment_list')->middleware('auth'); ;
Route::get('courier_cost_payment/{id}', 'Courier\CourierController@cost_payment')->name('courier_cost.pay')->middleware('auth'); 
Route::get('findAmount', 'Courier\CourierController@findAmount')->middleware('auth');
Route::post('save_payment', 'Courier\CourierController@save_payment')->name('courier.save_payment')->middleware('auth');
Route::get('multiple_payment', 'Courier\CourierController@multiple_payment')->name('courier.multiple_payment_list')->middleware('auth');
Route::post('save_multiple_payment', 'Courier\CourierController@save_multiple_payment')->name('courier.save_multiple_payment')->middleware('auth');

Route::resource('courier_profoma_invoice', 'Courier\ProfomaInvoiceController')->middleware('auth');
 Route::get('courier_profoma_pdfview',array('as'=>'courier_profoma_pdfview','uses'=>'Courier\ProfomaInvoiceController@invoice_pdfview'))->middleware('auth');



});
//courier tracking
// Route::group(['prefix' => 'courier_tracking'], function () {



// });

//school management
Route::group(['prefix' => 'school'], function () {

Route::resource('school_results', 'School\StudentsResultController')->middleware('auth');
Route::get('school_report', 'School\StudentsResultController@school_report')->name('school_report')->middleware('auth');

Route::resource('studentlevels', 'School\StudentLevelController')->middleware('auth');
Route::resource('studentsclass', 'School\StudentsClassController')->middleware('auth');
Route::resource('schoolstreams', 'School\SchoolStreamsController')->middleware('auth');
Route::resource('schoolbranch', 'School\SchoolBranchController')->middleware('auth');
Route::resource('studentsubject', 'School\StudentSubjectController')->middleware('auth');
Route::resource('examtype', 'School\ExamTypeController')->middleware('auth');

Route::resource('academyregisters', 'School\AcademyRegisterController')->middleware('auth');

Route::resource('schoolyears', 'School\SchoolYearController')->middleware('auth');

Route::resource('schoolterms', 'School\SchoolTermController')->middleware('auth');

Route::resource('gradesregister', 'School\GradesRegisterController')->middleware('auth');

Route::resource('teachersregister', 'School\TeachersRegisterController')->middleware('auth');

Route::resource('student', 'School\StudentController')->middleware('auth');
Route::post('disable', 'School\StudentController@disable')->name('student.disable')->middleware('auth');
Route::get('promote/{id}','School\StudentController@promote')->name('student.promote')->middleware('auth');
Route::get('findLevel', 'School\StudentController@findLevel')->middleware('auth');  
Route::any('invoice_general','School\StudentController@general')->name('student.general')->middleware('auth');
Route::any('fees_collection','School\StudentController@payment')->name('student.payment')->middleware('auth');
Route::get('autocomplete','School\StudentController@autocomplete')->name('student.db_payment')->middleware('auth');
Route::get('fees_collection/{id}/action','School\StudentController@action')->name('student.action')->middleware('auth');
Route::post('store_discount', 'School\StudentController@store_discount')->name('student.store_discount')->middleware('auth');
Route::post('store_payment','School\StudentController@store_payment')->name('student.store_payment')->middleware('auth');
Route::get('findStudent', 'School\StudentController@findStudent')->middleware('auth');
Route::get('findFeeAmount', 'School\StudentController@findAmount')->middleware('auth');
Route::get('findFeeDiscount', 'School\StudentController@findDiscount')->middleware('auth');
Route::post('generate_invoice','School\StudentController@generate')->name('student.generate')->middleware('auth');
Route::any('fees_collection_list','School\StudentController@list')->name('student.list')->middleware('auth');
Route::get('fees_collection_list/{student_payment_id}/fee_payment','School\StudentController@fee_payment')->name('student.fee_payment')->middleware('auth');
Route::get('invoice_general/{id}/invoice','School\StudentController@invoice')->name('student.invoice')->middleware('auth');
Route::resource('school', 'School\SchoolController')->middleware('auth');
Route::get('payments', 'School\StudentController@payments')->middleware('auth');
Route::get('payments_receipt',array('as'=>'payments_receipt','uses'=>'School\StudentController@invoice_receipt'))->middleware('auth');
Route::resource('messages', 'School\MessageController')->middleware('auth');
Route::post('import-student','School\StudentImportController@import')->name('student.import');
Route::post('student-sample','School\StudentImportController@sample')->name('student.sample');
Route::post('student-payments-import','School\StudentController@import')->name('student_payments.import');
Route::post('student-payments-sample','School\StudentController@sample')->name('student_payments.sample');
Route::get('import_payments', 'School\StudentController@import_payments')->middleware('auth');
Route::any('promote_students','School\StudentController@promote_students')->name('multiple_student.promote')->middleware('auth');
Route::post('save_promote','School\StudentController@save_promote')->name('student.save_promote');
Route::any('disable_students','School\StudentController@disable_students')->name('multiple_student.disable')->middleware('auth');
Route::post('save_disable','School\StudentController@save_disable')->name('student.save_disable');
Route::get('findPLevel', 'School\StudentController@findPLevel')->middleware('auth');

});

//GL SETUP

Route::group(['prefix' => 'gl_setup'], function () {
Route::resource('class_account', 'ClassAccountController')->middleware('auth');
Route::resource('group_account', 'GroupAccountController')->middleware('auth');
Route::resource('account_codes', 'AccountCodesController')->middleware('auth');
//Route::resource('system', 'SystemController')->middleware('auth');
Route::resource('chart_of_account', 'ChartOfAccountController')->middleware('auth');
Route::get('glModal', 'ChartOfAccountController@discountModal')->middleware('auth');
Route::get('save_class', 'ChartOfAccountController@save_class')->middleware('auth');
Route::get('save_group', 'ChartOfAccountController@save_group')->middleware('auth');
Route::get('save_codes', 'ChartOfAccountController@save_codes')->middleware('auth');
Route::resource('expenses', 'ExpensesController')->middleware('auth');
Route::get('multiple_pdfview',array('as'=>'multiple_pdfview','uses'=>'ExpensesController@multiple_pdfview'))->middleware('auth');
Route::get('findSupplier', 'ExpensesController@findClient')->middleware('auth'); 
Route::get('expenses_approve/{id}', 'ExpensesController@approve')->name('expenses.approve')->middleware('auth');
Route::get('expenses_delete/{id}', 'ExpensesController@delete_list')->name('expenses.delete')->middleware('auth');
  Route::post('multiple_approve', 'ExpensesController@multiple_approve')->name('multiple_expenses.approve')->middleware('auth');
Route::post('import-expenses','ExpensesController@import')->name('expenses.import');
Route::post('expenses-sample','ExpensesController@sample')->name('expenses.sample');
 Route::any('payment_report', 'ExpensesController@payment_report')->name('payment_report')->middleware('auth');
Route::resource('deposit', 'DepositController')->middleware('auth');
Route::get('findClient', 'DepositController@findClient')->middleware('auth'); 
Route::get('deposit_approve/{id}', 'DepositController@approve')->name('deposit.approve')->middleware('auth');
Route::get('findInvoice', 'DepositController@findInvoice')->middleware('auth'); 
Route::resource('account', 'AccountController')->middleware('auth');
Route::resource('transfer', 'TransferController')->middleware('auth');
Route::resource('transfer2', 'TransferController')->middleware('auth');
Route::get('transfer_approve/{id}', 'TransferController@approve')->name('transfer.approve')->middleware('auth');
Route::get('transfer_approve2/{id}', 'TransferController@approve')->name('transfer2.approve')->middleware('auth');
});
//route for reports
Route::group(['prefix' => 'accounting'], function () {

    Route::any('trial_balance', 'AccountingController@trial_balance')->middleware('auth');
    Route::any('ledger', 'AccountingController@ledger')->middleware('auth');
    Route::any('journal', 'AccountingController@journal')->middleware('auth');
    Route::get('manual_entry', 'AccountingController@create_manual_entry')->name('journal.manual')->middleware('auth');
    Route::get('manual_entry2', 'AccountingController@create_manual_entry2')->name('journal.manual2')->middleware('auth');
    Route::get('add_journal_item', 'AccountingController@add_item')->middleware('auth');
    Route::get('journal_modal', 'AccountingController@discountModal')->middleware('auth');
    Route::post('manual_entry/store', 'AccountingController@store_manual_entry')->middleware('auth');
    Route::any('bank_statement', 'AccountingController@bank_statement')->middleware('auth');
    Route::any('bank_reconciliation', 'AccountingController@bank_reconciliation')->name('reconciliation.view')->middleware('auth');
    Route::any('reconciliation_report', 'AccountingController@reconciliation_report')->name('reconciliation.report')->middleware('auth');;
    Route::post('save_reconcile', 'AccountingController@save_reconcile')->name('reconcile.save')->middleware('auth');
    
    Route::resource('budgets', 'BudgetController')->middleware('auth');
    Route::get('findMonth', 'BudgetController@findMonth')->middleware('auth');
    Route::get('discountModal', 'BudgetController@discountModal')->middleware('auth');
     Route::get('save_year', 'BudgetController@save_year')->middleware('auth');
});


//route for payroll
Route::group(['prefix' => 'payroll'], function () {

    Route::resource('salary_template', 'Payroll\SalaryTemplateController')->middleware('auth');
    Route::any('salary_template_import','Payroll\SalaryTemplateController@import')->name('salary_template.import')->middleware('auth');
    Route::post('salary_template_sample','Payroll\SalaryTemplateController@sample')->name('salary_template.sample')->middleware('auth');
    Route::any('manage_salary','Payroll\ManageSalaryController@getDetails')->middleware('auth');
Route::get('addTemplate', 'Payroll\ManageSalaryController@addTemplate')->middleware('auth');
  Route::get('manage_salary_edit/{id}','Payroll\ManageSalaryController@edit')->name('employee.edit')->middleware('auth');;;;
  Route::delete('manage_salary_delete/{id}','Payroll\ManageSalaryController@destroy')->name('employee.destroy')->middleware('auth');;;;
    Route::get('employee_salary_list','Payroll\ManageSalaryController@salary_list')->name('employee.salary')->middleware('auth');;;
    Route::resource('make_payment', 'Payroll\MakePaymentsController')->middleware('auth');   
  Route::get('make_payment/{user_id}/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@getPayment')->name('payment')->middleware('auth'); 
Route::get('edit_make_payment/{user_id}/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@editPayment')->name('payment.edit')->middleware('auth'); 
  Route::post('save_payment','Payroll\MakePaymentsController@save_payment')->name('save_payment')->middleware('auth');;;;
  Route::post('edit_payment','Payroll\MakePaymentsController@edit_payment')->name('edit_payment')->middleware('auth');;;;
  Route::get('make_payment/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@viewPayment')->name('view.payment')->middleware('auth'); 
Route::resource('multiple_payment', 'Payroll\MultiplePaymentsController')->middleware('auth'); 
   Route::post('save_multiple_payment','Payroll\MultiplePaymentsController@save_payment')->name('multiple_save.payment')->middleware('auth');;;;
 Route::get('multiple_payment/{departments_id}/{payment_month}', 'Payroll\MultiplePaymentsController@viewPayment')->name('multiple_view.payment')->middleware('auth'); 
    Route::resource('advance_salary', 'Payroll\AdvanceController')->middleware('auth'); 
   Route::get('findAmount', 'Payroll\AdvanceController@findAmount')->middleware('auth'); 
      Route::get('findMonth', 'Payroll\AdvanceController@findMonth')->middleware('auth');   
  Route::get('advance_approve/{id}', 'Payroll\AdvanceController@approve')->name('advance.approve')->middleware('auth'); 
Route::get('advance_reject/{id}', 'Payroll\AdvanceController@reject')->name('advance.reject')->middleware('auth'); 
Route::resource('employee_loan', 'Payroll\EmployeeLoanController')->middleware('auth'); 
 Route::get('findLoan', 'Payroll\EmployeeLoanController@findLoan')->middleware('auth');  
  Route::get('employee_loan_approve/{id}', 'Payroll\EmployeeLoanController@approve')->name('employee_loan.approve')->middleware('auth'); 
Route::get('employee_loan_reject/{id}', 'Payroll\EmployeeLoanController@reject')->name('employee_loan.reject')->middleware('auth'); 
   Route::resource('overtime', 'Payroll\OvertimeController')->middleware('auth'); 
  Route::get('overtime_approve/{id}', 'Payroll\OvertimeController@approve')->name('overtime.approve')->middleware('auth'); 
Route::get('overtime_reject/{id}', 'Payroll\OvertimeController@reject')->name('overtime.reject')->middleware('auth'); 
Route::any('overtime_import','Payroll\OvertimeController@import')->name('overtime.import')->middleware('auth');
Route::post('overtime_sample','Payroll\OvertimeController@sample')->name('overtime.sample')->middleware('auth');
   Route::get('findOvertime', 'Payroll\OvertimeController@findAmount')->middleware('auth'); 
 Route::any('nssf', 'Payroll\GetPaymentController@nssf')->middleware('auth'); 
 Route::any('tax', 'Payroll\GetPaymentController@tax')->middleware('auth'); 
 Route::any('nhif', 'Payroll\GetPaymentController@nhif')->middleware('auth'); 
 Route::any('wcf', 'Payroll\GetPaymentController@wcf')->middleware('auth'); 
  Route::any('sdl', 'Payroll\GetPaymentController@sdl')->middleware('auth'); 
Route::any('payroll_summary', 'Payroll\GetPaymentController@payroll_summary')->name('payroll_summary')->middleware('auth'); 
Route::any('salary_control', 'Payroll\GetPaymentController@salary_control')->name('salary_control')->middleware('auth'); 
 Route::any('generate_payslip', 'Payroll\GetPaymentController@generate_payslip')->middleware('auth'); 
 Route::any('received_payslip/{id}', 'Payroll\GetPaymentController@received_payslip')->name('payslip.generate')->middleware('auth'); 
Route::get('payslip_pdfview',array('as'=>'payslip_pdfview','uses'=>'Payroll\GetPaymentController@payslip_pdfview'))->middleware('auth');

Route::post('save_salary_details',array('as'=>'save_salary_details','uses'=>'Payroll\ManageSalaryController@save_salary_details'))->middleware('auth');
    Route::get('employee_salary_list',array('as'=>'employee_salary_list','uses'=>'Payroll\ManageSalaryController@employee_salary_list'))->middleware('auth');
    Route::resource('get_payment2', 'Payroll\GetPayment2Controller')->middleware('auth');
    Route::resource('make_payment2', 'Payroll\MakePayments2Controller')->middleware('auth'); 
   //Route::post('make_payment/store{user_id}{departments_id}{payment_month}', 'Payroll\MakePaymentsController@store')->name('make_payment.store')->middleware('auth'); 
    
});

//route for performance
Route::group(['prefix' => 'performance'], function () {

     Route::resource('indicator', 'Performance\PerformanceController')->middleware('auth');
     Route::get('checkDepartment', 'Performance\PerformanceController@checkDepartment')->middleware('auth');
     Route::get('performanceModal', 'Performance\PerformanceController@discountModal')->middleware('auth');
     Route::any('appraisal', 'Performance\PerformanceController@appraisal')->name('appraisal')->middleware('auth');
     Route::post('save_appraisal', 'Performance\PerformanceController@save_appraisal')->name('save_appraisal')->middleware('auth');
     Route::get('edit_appraisal/{id}', 'Performance\PerformanceController@edit_appraisal')->name('edit_appraisal')->middleware('auth');
     Route::put('update_appraisal/{id}', 'Performance\PerformanceController@update_appraisal')->name('update_appraisal')->middleware('auth');
     Route::get('findUser', 'Performance\PerformanceController@findUser')->middleware('auth'); 
     Route::get('findMonth', 'Performance\PerformanceController@findMonth')->middleware('auth');
     Route::any('performance_report', 'Performance\PerformanceController@performance_report')->name('performance_report')->middleware('auth');
     Route::get('checkDesignation', 'Performance\KPIController@checkDesignation')->middleware('auth');
      Route::get('findUser2', 'Performance\KPIController@findUser')->middleware('auth'); 
     Route::resource('kpi', 'Performance\KPIController')->middleware('auth');
     Route::any('assign_kpi', 'Performance\KPIController@assign_kpi')->name('assign_kpi')->middleware('auth');
      Route::get('findPercent', 'Performance\KPIController@findPercent')->middleware('auth');
      Route::get('addGoal', 'Performance\KPIController@save_goal')->middleware('auth');
     Route::post('save_kpi', 'Performance\KPIController@save_kpi')->name('save_kpi')->middleware('auth');
     Route::get('edit_kpi/{id}', 'Performance\KPIController@edit_kpi')->name('edit_kpi')->middleware('auth');
     Route::put('update_kpi/{id}', 'Performance\KPIController@update_kpi')->name('update_kpi')->middleware('auth');
      Route::get('kpi_result', 'Performance\KPIController@kpi_result')->name('kpi_result')->middleware('auth');
    Route::get('close_kpi/{id}', 'Performance\KPIController@close_kpi')->name('close_kpi')->middleware('auth');
});






    Route::group(['prefix' => 'financial_report'], function () {
        Route::any('trial_balance', 'ReportController@trial_balance')->middleware('auth');
         Route::any('trial_balance_summary', 'ReportController@trial_balance_summary')->middleware('auth');
        Route::any('trial_balance/pdf', 'ReportController@trial_balance_pdf')->middleware('auth');
        Route::any('trial_balance/excel', 'ReportController@trial_balance_excel')->middleware('auth');
        Route::any('trial_balance/csv', 'ReportController@trial_balance_csv')->middleware('auth');
     Route::any('trial_balance_summary/pdf', 'ReportController@trial_balance_summary_pdf')->middleware('auth');
        Route::any('trial_balance_summary/excel', 'ReportController@trial_balance_summary_excel')->middleware('auth');
        Route::any('ledger', 'ReportController@ledger')->middleware('auth');
        Route::any('journal', 'ReportController@journal')->middleware('auth');
        Route::any('income_statement', 'ReportController@income_statement')->middleware('auth');
         Route::any('income_statement_summary', 'ReportController@income_statement_summary')->middleware('auth');
        Route::any('income_statement/pdf', 'ReportController@income_statement_pdf')->middleware('auth');
        Route::any('income_statement/excel', 'ReportController@income_statement_excel')->middleware('auth');
        Route::any('income_statement/csv', 'ReportController@income_statement_csv')->middleware('auth');
         Route::any('income_statement_summary/pdf', 'ReportController@income_statement_summary_pdf')->middleware('auth');
        Route::any('income_statement_summary/excel', 'ReportController@income_statement_summary_excel')->middleware('auth');
        Route::any('balance_sheet', 'ReportController@balance_sheet')->middleware('auth');
        Route::any('balance_sheet_summary', 'ReportController@balance_sheet_summary')->middleware('auth');
        Route::any('balance_sheet/pdf', 'ReportController@balance_sheet_pdf')->middleware('auth');
        Route::any('balance_sheet/excel', 'ReportController@balance_sheet_excel')->middleware('auth');
        Route::any('balance_sheet/csv', 'ReportController@balance_sheet_csv')->middleware('auth');
         Route::any('balance_sheet_summary/excel', 'ReportController@balance_sheet_summary_excel')->middleware('auth');
        Route::any('balance_sheet_summary/pdf', 'ReportController@balance_sheet_summary_pdf')->middleware('auth');
         Route::get('reportModal', 'ReportController@reportModal')->middleware('auth');
    });

//reports
    Route::group(['prefix' => 'reports'], function () {
       
Route::group(['prefix' => 'pos'], function () {
Route::any('purchase_report', 'POS\ReportController@purchase_report')->name('pos.purchase_report')->middleware('auth');
Route::any('good_issue_report', 'POS\ReportController@good_issue_report')->name('pos.good_issue_report')->middleware('auth');
Route::any('good_disposal_report', 'POS\ReportController@good_disposal_report')->name('pos.good_disposal_report')->middleware('auth');
Route::any('expire_report', 'POS\ReportController@expire_report')->name('pos.expire_report')->middleware('auth');
Route::any('stock_movement_report', 'POS\ReportController@stock_movement_report')->name('pos.stock_movement_report')->middleware('auth');

Route::any('stock_profit_report', 'POS\ReportController@stock_profit_report')->name('pos.stock_profit_report')->middleware('auth');

Route::any('sales_report', 'POS\ReportController@sales_report')->name('pos.sales_report')->middleware('auth');
Route::any('balance_report', 'POS\ReportController@balance_report')->name('pos.balance_report')->middleware('auth');
Route::any('store_value', 'POS\ReportController@store_value')->name('pos.store_value')->middleware('auth');
Route::any('stock_report', 'POS\ReportNewController@stock_report')->name('pos.stock_report')->middleware('auth');

Route::any('sales_report', 'POS\ReportNewController@sales_report')->name('pos.sales_report')->middleware('auth');

Route::any('min_quantity_report', 'POS\ReportNewController@min_quantity_report')->name('pos.min_quantity_report')->middleware('auth');
Route::any('expire_report', 'POS\ReportNewController@expire_report')->name('expire_report.search')->middleware('auth');


Route::any('report_by_date', 'POS\ReportController@report_by_date')->name('pos.report_by_date')->middleware('auth');

Route::any('general_operation_report', 'POS\ReportController@general_operation_report')->name('pos.general_operation_report')->middleware('auth');

Route::any('profit_report', 'POS\ReportNewController@profit_report')->name('pos.profit_report')->middleware('auth');
Route::any('service_report', 'POS\ReportController@service_report')->name('pos.service_report')->middleware('auth');
Route::any('client_report', 'POS\ReportController@client_report')->name('pos.client_report')->middleware('auth');

Route::any('client_point_report', 'POS\ReportController@client_point_report')->name('pos.client_point_report')->middleware('auth');

Route::get('viewModal', 'POS\ReportController@discountModal')->middleware('auth');
});


Route::group(['prefix' => 'leave'], function () {
    
Route::any('leave_report', 'Leave\LeaveController@leave_report')->name('leave_report')->middleware('auth'); 
Route::any('/leave-report/individual/pdf', 'Leave\LeaveController@generateLeaveReport')->name('leave.report.individual.pdf');


});

Route::group(['prefix' => 'restaurant'], function () {
    Route::any('purchase_report', 'Restaurant\POS\ReportController@purchase_report')->name('restaurant.purchase_report')->middleware('auth');
    Route::any('stock_movement_report', 'Restaurant\POS\ReportController@stock_movement_report')->name('restaurant.stock_movement_report')->middleware('auth');
    Route::any('sales_report', 'Restaurant\POS\ReportController@sales_report')->name('restaurant.sales_report')->middleware('auth');
    Route::any('balance_report', 'Restaurant\POS\ReportController@balance_report')->name('restaurant.balance_report')->middleware('auth');
    Route::any('stock_report', 'Restaurant\POS\ReportController@stock_report')->name('restaurant.stock_report')->middleware('auth');
    Route::any('store_value', 'Restaurant\POS\ReportController@store_value')->name('restaurant.store_value')->middleware('auth');
    Route::any('report_by_date', 'Restaurant\POS\ReportController@report_by_date')->name('restaurant.report_by_date')->middleware('auth');
    Route::any('profit_report', 'Restaurant\POS\ReportController@profit_report')->name('restaurant.profit_report')->middleware('auth');
    Route::any('kitchen_report', 'Restaurant\POS\ReportController@kitchen_report')->name('restaurant.kitchen_report')->middleware('auth');
    Route::any('kitchen_sales', 'Restaurant\POS\ReportController@kitchen_sales')->name('restaurant.kitchen_sales')->middleware('auth');
    Route::any('drink_sales', 'Restaurant\POS\ReportController@drink_sales')->name('restaurant.drink_sales')->middleware('auth');
    Route::any('good_disposal_report', 'Restaurant\POS\ReportController@good_disposal_report')->name('restaurant.good_disposal_report')->middleware('auth');
    Route::any('expire_report', 'Restaurant\POS\ReportController@expire_report')->name('restaurant.expire_report')->middleware('auth');
    Route::get('viewModal', 'Restaurant\POS\ReportController@discountModal')->middleware('auth');
    });
    
    
    Route::group(['prefix' => 'pms'], function () {
Route::any('room_report', 'Hotel\ReportController@room_report')->name('pms.room_report')->middleware('auth');
Route::get('viewModal', 'Hotel\ReportController@discountModal')->middleware('auth');
});
    
Route::group(['prefix' => 'inventory'], function () {
Route::any('good_issue_report', 'Inventory\ReportController@good_issue_report')->name('inventory.good_issue_report')->middleware('auth');
Route::any('good_disposal_report', 'Inventory\ReportController@good_disposal_report')->name('inventory.good_disposal_report')->middleware('auth');
Route::any('stock_movement_report', 'Inventory\ReportController@stock_movement_report')->name('inventory.stock_movement_report')->middleware('auth');
Route::any('stock_report', 'Inventory\ReportController@stock_report')->name('inventory.stock_report')->middleware('auth');
Route::any('report_by_date', 'Inventory\ReportController@report_by_date')->name('inventory.report_by_date')->middleware('auth');
Route::any('profit_report', 'Inventory\ReportController@profit_report')->name('inventory.profit_report')->middleware('auth');
Route::any('requisition_report', 'Inventory\ReportController@requisition_report')->name('inventory.requisition_report')->middleware('auth');
Route::get('viewModal', 'Inventory\ReportController@discountModal')->middleware('auth');
});


Route::group(['prefix' => 'tracking'], function () {
Route::any('debtors_report', 'Activity\OrderMovementController@debtors_report')->name('cargo_debtors_report')->middleware('auth');
Route::any('debtors_summary_report', 'Activity\OrderMovementController@debtors_summary_report')->name('cargo_debtors_summary_report')->middleware('auth');
Route::any('creditors_report', 'Activity\OrderMovementController@creditors_report')->name('creditors_report')->middleware('auth');
Route::any('creditors_refill_report', 'Activity\OrderMovementController@creditors_refill_report')->name('creditors_refill_report')->middleware('auth');
Route::any('client_summary', 'Activity\OrderMovementController@client_summary')->name('client_summary')->middleware('auth');



 });

Route::group(['prefix' => 'school'], function () {
    Route::any('student_report', 'School\StudentController@student_report')->name('student_report')->middleware('auth');
     Route::get('student_report_excel/{name}/{year}', 'School\StudentController@student_report_excel')->name('student_report.excel')->middleware('auth'); 
   Route::any('class_report', 'School\StudentController@class_report')->name('class_report')->middleware('auth');
   Route::any('uncollected_fees', 'School\StudentController@uncollected_fees')->name('uncollected_fees')->middleware('auth');
Route::any('payments_report', 'School\StudentController@payments_report')->middleware('auth');
    
    });



Route::group(['prefix' => 'project'], function () {
  Route::any('profit_report', 'Project\ProjectController@profit_report')->name('profit_report')->middleware('auth');
     Route::get('profit_report_excel/{name}/{start}/{end}', 'Project\ProjectController@profit_report_excel')->name('profit_report.excel')->middleware('auth');
});

    });

Route::group(['prefix' => 'access_control'], function () {
Route::resource('system_module', 'ModuleController')->middleware('auth');
Route::resource('permissions', 'PermissionController')->middleware('auth');
Route::resource('departments', 'DepartmentController')->middleware('auth');
Route::get('save_department', 'DepartmentController@save_department')->middleware('auth');
Route::resource('designations', 'DesignationController')->middleware('auth');
Route::resource('roles', 'RoleController')->middleware('auth');
Route::resource('system_role', 'SystemRoleController')->middleware('auth');
Route::resource('branch', 'BranchController')->middleware('auth');
Route::resource('fiscal_year', 'FiscalController')->middleware('auth');
Route::resource('users', 'UsersController')->middleware('auth');
Route::get('user_disable/{id}', 'UsersController@save_disable')->name('user.disable')->middleware('auth');
Route::get('user_details/{id}', 'UsersController@details')->name('user.details')->middleware('auth');
Route::get('users_all', 'UsersController@users_all')->name('users_all')->middleware('auth');
Route::post('/users/{userId}/update-access', 'UsersController@update_access')->name('user.update.access');

Route::get('affiliate_users_all', 'UsersController@affiliate_users_all')->name('affiliate_users_all')->middleware('auth');
Route::get('affiliate_users_show/{id}/show', 'UsersController@affiliate_users_show')->name('affiliate_users_show')->middleware('auth');

Route::get('findDepartment', 'UsersController@findDepartment')->middleware('auth');  
Route::resource('users_details', 'User\UserDetailsController')->middleware('auth');

Route::resource('clients', 'ClientController')->middleware('auth');

Route::resource('system', 'SystemController')->middleware('auth');

//user Details
Route::resource('details', 'UserDetailsController')->middleware('auth');
Route::any('user_import','UsersController@user_import')->name('user.import')->middleware('auth');
Route::post('user_sample','UsersController@user_sample')->name('user.sample')->middleware('auth');
Route::any('user_details_import','UsersController@details_import')->name('details.import')->middleware('auth');
Route::post('user_details_sample','UsersController@details_sample')->name('details.sample')->middleware('auth');

//notifications
Route::get('mark_as_read/{id}', 'UsersController@mark_as_read')->name('notif.read')->middleware('auth');
Route::get('mark_all_as_read', 'UsersController@mark_all_as_read')->name('notif.read_all')->middleware('auth');
Route::get('view_all/{id}', 'UsersController@view_all')->name('notif.view_all')->middleware('auth');

    });
    
Route::get('auditing_trail', 'AuditingTrailController@index')->name('auditing-trails')->middleware('auth');