<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

use App\Http\Controller\FarmerController;
use App\Http\Controller\GroupController;
use App\Http\Controller\MemberController;
use App\Http\Controller\LandController;
use App\Http\Controller\SupplierController;
use App\Http\Controller\ProductController;
use App\Http\Controller\UnitController;
use App\Http\Controller\PurchaseController;
use App\Http\Controller\SalesController;
use App\Http\Controller\Single_warehouseController;
use App\Http\Controller\Orders_Client_ManipulationsController;
use App\Http\Controller\Warehouse_backendController;

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

Auth::routes();
Route::get('/',"HomeController@index")->middleware('auth');

//testing input
Route::group(['prefix' => 'testing_input'], function () {
Route::get('file-import','Admin\JournalImportController@importView')->name('import-view');
Route::post('import','Admin\JournalImportController@import')->name('import');
Route::post('sample','Admin\JournalImportController@sample')->name('sample');
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


//livewire
Route::view('contacts', 'contacts')->middleware('auth');
Route::view('test','livewiretest')->middleware('auth');
Route::view('input-order','agrihub.iorder')->middleware('auth');

//supplier
Route::group(['prefix' => 'purchases'], function () {
Route::resource('supplier', 'shop\SupplierController')->middleware('auth');
});

//product
Route::group(['prefix' => 'product'], function () {
Route::get('manage/product','ProductController@index')->middleware('auth');
Route::post('product/save','ProductController@store')->middleware('auth');
Route::post('product/{id}/edit','ProductController@update')->middleware('auth');
Route::get('product/{id}/delete','ProductController@destroy')->middleware('auth');
});

//input order management
Route::group(['prefix' => 'order_management'], function () {
//Route::get('purchase/','PurchaseController@index')->middleware('auth');
Route::post('input/add','PurchaseController@store')->middleware('auth');
Route::get('get',"PurchaseController@create")->middleware('auth');
Route::post('ajax-posts/{id}/edit','PurchaseController@edit')->middleware('auth');
Route::get('order/{id}/{product}/{purchase}/delete','PurchaseController@destroy')->middleware('auth');
Route::post('order/{id}/update','PurchaseController@update')->middleware('auth');
Route::get('purchase/{id}/product','PurchaseController@show')->middleware('auth');
});

//output order managemnet
Route::group(['prefix' => 'output_order'], function () {
Route::post('sales/add','SalesController@store')->middleware('auth');
Route::get('get/sales',"SalesController@create")->middleware('auth');
Route::get('sales/{id}/{product}/{sale}/delete','SalesController@destroy')->middleware('auth');
Route::get('sales/{id}/product','SalesController@show')->middleware('auth');
});

// warehouse management
// Route::group(['prefix' => 'warehouse_management'], function () {
// Route::get('warehouse','WarehouseController@index')->middleware('auth');
// Route::post('warehouse/save','WarehouseController@store')->middleware('auth');
// Route::get('warehouse/{id}/show','WarehouseController@show')->middleware('auth');
// Route::resource('singlewarehouse','Single_warehouseController')->middleware('auth');
// Route::resource('warehouse_backend','warehouse\Warehouse_backendController')->middleware('auth');
// });

// make crops orders
Route::group(['prefix' => 'crop_order'], function () {
Route::resource('crops_order','Client_OrderController')->middleware('auth');
Route::resource('manipulation','Orders_Client_ManipulationsController')->middleware('auth');
});

//  logistic routes
//  logistic-truck routes
Route::group(['prefix' => 'logistic_truck'], function () {
Route::resource('truck', 'Truck\TruckController')->middleware('auth');
Route::get('connect_trailer', 'Truck\TruckController@connect')->name('truck.connect')->middleware('auth');
Route::get('connectModal', 'Truck\TruckController@discountModal')->middleware('auth');
Route::post('save_connect', 'Truck\TruckController@save_connect')->middleware('auth');
Route::get('disconnect/{id}', 'Truck\TruckController@save_disconnect')->name('truck.disconnect')->middleware('auth');
Route::get('connect_driver', 'Truck\TruckController@connect_driver')->name('truck.driver')->middleware('auth');
Route::post('save_driver', 'Truck\TruckController@save_driver')->middleware('auth');
Route::any('truck_report', 'Truck\TruckController@truck_report')->middleware('auth');
Route::get('remove_driver/{id}', 'Truck\TruckController@remove_driver')->name('truck.remove')->middleware('auth');
Route::get('truck_sticker/{id}', 'Truck\TruckController@sticker')->name('truck.sticker')->middleware('auth');
Route::get('truck_insurance/{id}', 'Truck\TruckController@insurance')->name('truck.insurance')->middleware('auth');
Route::any('truck_fuel_report/{id}', 'Truck\TruckController@fuel')->name('truck.fuel')->middleware('auth');
Route::any('truck_route/{id}', 'Truck\TruckController@route')->name('truck.route')->middleware('auth');
Route::resource('sticker', 'Truck\StickerController')->middleware('auth');
Route::resource('truckinsurance', 'Truck\TruckInsuranceController')->middleware('auth');
Route::get('sdownload',array('as'=>'sdownload','uses'=>'Truck\StickerControllerr@sdownload'))->middleware('auth');
Route::get('tdownload',array('as'=>'tdownload','uses'=>'ruck\TruckInsuranceController@tdownload'))->middleware('auth');
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
// Manufacturing routes
// Route::group(['prefix' => 'manufacturing'], function () {
// Route::resource('manufacturing_location', 'Manufacturing\LocationController')->middleware('auth');
// Route::resource('manufacturing_inventory', 'Manufacturing\InventoryController')->middleware('auth');
// Route::resource('bill_of_material', 'Manufacturing\BillOfMaterialController')->middleware('auth');
// Route::resource('work_order', 'Manufacturing\WorkOrderController')->middleware('auth');
// });

// inventory routes
Route::group(['prefix' => 'inventory'], function () {
Route::resource('location', 'Inventory\LocationController')->middleware('auth');
Route::resource('inventory', 'Inventory\InventoryController')->middleware('auth');
Route::resource('fieldstaff', 'Inventory\FieldStaffController')->middleware('auth');
Route::resource('requisition', 'Inventory\RequisitionController')->middleware('auth');
Route::resource('purchase_inventory', 'Inventory\PurchaseInventoryController')->middleware('auth');
Route::get('findInvPrice', 'Inventory\PurchaseInventoryController@findPrice')->middleware('auth'); 
Route::get('invModal', 'Inventory\PurchaseInventoryController@discountModal')->middleware('auth');
Route::get('approve/{id}', 'Inventory\PurchaseInventoryController@approve')->name('inventory.approve')->middleware('auth'); 
Route::get('cancel/{id}', 'Inventory\PurchaseInventoryController@cancel')->name('inventory.cancel')->middleware('auth'); 
Route::get('receive/{id}', 'Inventory\PurchaseInventoryController@receive')->name('inventory.receive')->middleware('auth'); 
Route::get('make_payment/{id}', 'Inventory\PurchaseInventoryController@make_payment')->name('inventory.pay')->middleware('auth'); 
Route::get('inv_pdfview',array('as'=>'inv_pdfview','uses'=>'Inventory\PurchaseInventoryController@inv_pdfview'))->middleware('auth');
Route::get('order_payment/{id}', 'orders\OrdersController@order_payment')->name('order.pay')->middleware('auth');
Route::get('inventory_list', 'Inventory\PurchaseInventoryController@inventory_list')->name('inventory.list')->middleware('auth');
Route::post('save_inv_reference', 'Inventory\PurchaseInventoryController@save_reference')->name('reference_inv.save')->middleware('auth');
Route::resource('inventory_payment', 'Inventory\InventoryPaymentController')->middleware('auth');
Route::resource('order_payment', 'orders\OrderPaymentController')->middleware('auth');
Route::resource('maintainance', 'Inventory\MaintainanceController')->middleware('auth');
Route::post('save_mechanical_report', 'Inventory\MaintainanceController@save_report')->name('maintainance.report')->middleware('auth');
Route::get('change_m_status/{id}', 'Inventory\MaintainanceController@approve')->name('maintainance.approve')->middleware('auth'); 
Route::resource('service', 'Inventory\ServiceController')->middleware('auth');
Route::resource('service_type', 'Inventory\ServiceTypeController')->middleware('auth');
Route::get('change_s_status/{id}', 'Inventory\ServiceController@approve')->name('service.approve')->middleware('auth');
Route::resource('good_issue', 'Inventory\GoodIssueController')->middleware('auth');
Route::get('findIssueService', 'Inventory\GoodIssueController@findService')->middleware('auth');
Route::get('issue_approve/{id}', 'Inventory\GoodIssueController@approve')->name('issue.approve')->middleware('auth'); 
Route::resource('good_return', 'Inventory\GoodReturnController')->middleware('auth');
Route::get('return_approve/{id}', 'Inventory\GoodReturnController@approve')->name('return.approve')->middleware('auth');
Route::resource('good_movement', 'Inventory\GoodMovementController')->middleware('auth');
Route::get('movement_approve/{id}', 'Inventory\GoodReturnController@approve')->name('movement.approve')->middleware('auth'); 
Route::resource('good_reallocation', 'Inventory\GoodReallocationController')->middleware('auth');
Route::get('reallocation_approve/{id}', 'Inventory\GoodReallocationController@approve')->name('reallocation.approve')->middleware('auth'); 
Route::resource('good_disposal', 'Inventory\GoodDisposalController')->middleware('auth');
Route::get('disposal_approve/{id}', 'Inventory\GoodDisposalController@approve')->name('disposal.approve')->middleware('auth'); 
Route::get('findReturnService', 'Inventory\GoodReturnController@findService')->middleware('auth');
});

// cotton routes
Route::group(['prefix' => 'cotton_collection'], function () {
Route::resource('costants', 'Cotton\CostantsController')->middleware('auth');
Route::resource('production', 'Cotton\ProductionController')->middleware('auth');
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
Route::get('cotton_movement_approve/{id}', 'Cotton\GoodMovementController@approve')->name('movement.approve')->middleware('auth'); 
Route::get('cotton_check_balance', 'Cotton\GoodMovementController@chekBalance')->name('movement.chekBalance')->middleware('auth'); 
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
Route::any('stock_report', 'Cotton\CollectionCenterController@stock_report')->middleware('auth');
Route::any('invoice_report', 'Cotton\ReportController@invoice_report')->middleware('auth');
Route::any('center_report', 'Cotton\CollectionCenterController@center_report')->middleware('auth');
Route::any('cotton_movement_report', 'Cotton\CollectionCenterController@cotton_movement_report')->middleware('auth');
Route::any('levy_report', 'Cotton\ReportController@levy_report')->middleware('auth');
Route::any('debtors_report', 'Cotton\ReportController@debtors_report')->middleware('auth');
Route::any('general_report', 'Cotton\ReportController@general_report')->middleware('auth');
Route::any('general_report2', 'Cotton\ReportController@general_report2')->middleware('auth');
Route::resource('general_report_table', 'Cotton\ReportController')->middleware('auth');
Route::resource('cotton_client', 'Cotton\CottonClientController')->middleware('auth');
Route::resource('cotton_sales', 'Cotton\InvoiceController')->middleware('auth');
Route::get('findSalesPrice', 'Cotton\InvoiceController@findPrice')->middleware('auth'); 
Route::get('cotton_payment/{id}', 'Cotton\InvoiceController@make_payment')->name('invoice.pay')->middleware('auth'); 
Route::get('sales_pdfview',array('as'=>'sales_pdfview','uses'=>'Cotton\InvoiceController@sales_pdfview'))->middleware('auth');
Route::resource('cotton_sales_payment', 'Cotton\InvoicePaymentController')->middleware('auth');
Route::resource('seed_list', 'Cotton\SeedListController')->middleware('auth');
Route::resource('seed_sales', 'Cotton\SeedInvoiceController')->middleware('auth');
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

//tracking
Route::group(['prefix' => 'tracking'], function () {
Route::get('collection', 'Activity\OrderMovementController@collection')->name('order.collection')->middleware('auth');
Route::get('loading', 'Activity\OrderMovementController@loading')->name('order.loading')->middleware('auth');
Route::get('offloading', 'Activity\OrderMovementController@offloading')->name('order.offloading')->middleware('auth');
Route::get('delivering', 'Activity\OrderMovementController@delivering')->name('order.delivering')->middleware('auth');
Route::get('wb', 'Activity\OrderMovementController@wb')->name('order.wb')->middleware('auth');
Route::post('save_wb', 'Activity\OrderMovementController@save_wb')->name('save.wb')->middleware('auth');
Route::resource('order_movement', 'Activity\OrderMovementController')->middleware('auth');
Route::get('findTruck', 'Activity\OrderMovementController@findTruck')->middleware('auth');  
Route::get('findDriver', 'Activity\OrderMovementController@findDriver')->middleware('auth');  
Route::resource('activity', 'Activity\ActivityController')->middleware('auth');
Route::get('order_report', 'Activity\OrderMovementController@report')->name('order.report')->middleware('auth');
Route::get('findReport', 'Activity\OrderMovementController@findReport')->middleware('auth');
Route::get('findExp', 'Activity\OrderMovementController@findPrice')->middleware('auth');  
Route::get('truck_mileage', 'Activity\OrderMovementController@return')->name('order.return')->middleware('auth');
});

//fuel
Route::group(['prefix' => 'fuel'], function () {
Route::resource('fuel', 'Fuel\FuelController')->middleware('auth');
Route::get('addRoute', 'Fuel\FuelController@route')->middleware('auth');
Route::resource('routes', 'RouteController')->middleware('auth');
Route::get('findFromRegion', 'RouteController@findFromRegion')->middleware('auth');  
Route::get('findToRegion', 'RouteController@findToRegion')->middleware('auth');  
Route::get('fuel_approve/{id}', 'Fuel\FuelController@approve')->name('fuel.approve')->middleware('auth');
Route::get('discountModal', 'Fuel\FuelController@discountModal')->middleware('auth');
});

//leave
Route::group(['prefix' => 'leave'], function () {
Route::resource('leave', 'Leave\LeaveController')->middleware('auth');
Route::post('addCategory', 'Leave\LeaveController@category')->middleware('auth');
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
Route::get('tyre_list', 'Tyre\PurchaseTyreController@tyre_list')->name('tyre.list')->middleware('auth');
Route::resource('purchase_tyre', 'Tyre\PurchaseTyreController')->middleware('auth');
Route::get('findTyrePrice', 'Tyre\PurchaseTyreController@findPrice')->middleware('auth'); 
Route::get('tyre_approve/{id}', 'Tyre\PurchaseTyreController@approve')->name('purchase_tyre.approve')->middleware('auth'); 
Route::get('tyre_cancel/{id}', 'Tyre\PurchaseTyreController@cancel')->name('purchase_tyre.cancel')->middleware('auth'); 
Route::get('tyre_receive/{id}', 'Tyre\PurchaseTyreController@receive')->name('purchase_tyre.receive')->middleware('auth'); 
Route::get('make_tyre_payment/{id}', 'Tyre\PurchaseTyreController@make_payment')->name('purchase_tyre.pay')->middleware('auth'); 
Route::get('tyre_pdfview',array('as'=>'tyre_pdfview','uses'=>'Tyre\PurchaseTyreController@tyre_pdfview'))->middleware('auth');
Route::resource('tyre_payment', 'Tyre\TyrePaymentController')->middleware('auth');
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
Route::get('tyre_return_approve/{id}', 'Tyre\TyreReturnController@approve')->name('tyre_return.approve')->middleware('auth'); 
Route::get('addSupp', 'Tyre\PurchaseTyreController@addSupp')->middleware('auth');
});
//pacel
Route::group(['prefix' => 'pacel'], function () {
Route::resource('pacel_list', 'Pacel\PacelListController')->middleware('auth');
Route::resource('client', 'ClientController')->middleware('auth');
Route::resource('pacel_quotation', 'Pacel\PacelController')->middleware('auth');
Route::get('pacel_invoice', 'Pacel\PacelController@invoice')->name('pacel.invoice')->middleware('auth');
Route::get('invoice_details/{id}', 'Pacel\PacelController@details')->name('invoice.details')->middleware('auth'); 
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
});


//courier

// Route::group(['prefix' => 'courier'], function () {
// Route::resource('courier_list', 'Courier\CourierListController')->middleware('auth');
// Route::resource('courier_client', 'Courier\CourierClientController')->middleware('auth');
// Route::resource('courier_quotation', 'Courier\CourierController')->middleware('auth');
// Route::get('courier_invoice', 'Courier\CourierController@invoice')->name('courier.invoice')->middleware('auth');
// Route::get('findCourierPrice', 'Courier\CourierController@findPrice')->middleware('auth'); 
// Route::get('courier_approve/{id}', 'Courier\CourierController@approve')->name('courier.approve')->middleware('auth'); 
// Route::get('courier_cancel/{id}', 'Courier\CourierController@cancel')->name('courier.cancel')->middleware('auth');  
// Route::get('make_courier_payment/{id}', 'Courier\CourierController@make_payment')->name('courier.pay')->middleware('auth'); 
// Route::get('courier_pdfview',array('as'=>'courier_pdfview','uses'=>'Courier\CourierController@courier_pdfview'))->middleware('auth');
// Route::resource('courier_payment', 'Courier\CourierPaymentController')->middleware('auth');
// Route::get('courierModal', 'Courier\CourierController@discountModal')->middleware('auth');
// Route::post('newCourierDiscount', 'Courier\CourierController@newdiscount')->middleware('auth');
// Route::get('addCourierSupplier', 'Courier\CourierController@addSupplier')->middleware('auth');
// Route::get('addCourierRoute', 'Courier\CourierController@addRoute')->middleware('auth');
// });
//courier tracking
// Route::group(['prefix' => 'courier_tracking'], function () {
// Route::get('courier_collection', 'Courier\CourierMovementController@collection')->name('courier.collection')->middleware('auth');
// Route::get('courier_loading', 'Courier\CourierMovementController@loading')->name('courier.loading')->middleware('auth');
// Route::get('courier_offloading', 'Courier\CourierMovementController@offloading')->name('courier.offloading')->middleware('auth');
// Route::get('courier_delivering', 'Courier\CourierMovementController@delivering')->name('courier.delivering')->middleware('auth');
// Route::resource('courier_movement', 'Courier\CourierMovementController')->middleware('auth'); 
// Route::resource('courier_activity', 'Courier\CourierActivityController')->middleware('auth');
// Route::get('courier_report', 'Courier\CourierMovementController@report')->name('courier.report')->middleware('auth');
// Route::get('findCourierReport', 'Courier\CourierMovementController@findReport')->middleware('auth');
// });
//GL SETUP

Route::group(['prefix' => 'gl_setup'], function () {
Route::resource('class_account', 'ClassAccountController')->middleware('auth');
Route::resource('group_account', 'GroupAccountController')->middleware('auth');
Route::resource('account_codes', 'AccountCodesController')->middleware('auth');
Route::resource('system', 'SystemController')->middleware('auth');
Route::resource('chart_of_account', 'ChartOfAccountController')->middleware('auth');
Route::resource('expenses', 'ExpensesController')->middleware('auth');
Route::get('expenses_approve/{id}', 'ExpensesController@approve')->name('expenses.approve')->middleware('auth');
Route::resource('deposit', 'DepositController')->middleware('auth');
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
    Route::get('manual_entry', 'AccountingController@create_manual_entry')->middleware('auth');
    Route::post('manual_entry/store', 'AccountingController@store_manual_entry')->middleware('auth');
    Route::any('bank_statement', 'AccountingController@bank_statement')->middleware('auth');
    Route::any('bank_reconciliation', 'AccountingController@bank_reconciliation')->middleware('auth');
    Route::any('reconciliation_report', 'AccountingController@reconciliation_report')->name('reconciliation.report')->middleware('auth');;
    Route::post('save_reconcile', 'AccountingController@save_reconcile')->name('reconcile.save')->middleware('auth');
});


//route for payroll
Route::group(['prefix' => 'payroll'], function () {

    Route::resource('salary_template', 'Payroll\SalaryTemplateController')->middleware('auth');
    Route::any('manage_salary','Payroll\ManageSalaryController@getDetails')->middleware('auth');
Route::get('addTemplate', 'Payroll\ManageSalaryController@addTemplate')->middleware('auth');
  Route::get('manage_salary_edit/{id}','Payroll\ManageSalaryController@edit')->name('employee.edit')->middleware('auth');;;;
  Route::delete('manage_salary_delete/{id}','Payroll\ManageSalaryController@destroy')->name('employee.destroy')->middleware('auth');;;;
    Route::get('employee_salary_list','Payroll\ManageSalaryController@salary_list')->name('employee.salary')->middleware('auth');;;
    Route::resource('make_payment', 'Payroll\MakePaymentsController')->middleware('auth');   
  Route::get('make_payment/{user_id}/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@getPayment')->name('payment')->middleware('auth'); 
  Route::post('save_payment','Payroll\MakePaymentsController@save_payment')->name('save_payment')->middleware('auth');;;;
  Route::get('make_payment/{departments_id}/{payment_month}', 'Payroll\MakePaymentsController@viewPayment')->name('view.payment')->middleware('auth'); 
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
   Route::get('findOvertime', 'Payroll\OvertimeController@findAmount')->middleware('auth'); 
 Route::any('nssf', 'Payroll\GetPaymentController@nssf')->middleware('auth'); 
 Route::any('tax', 'Payroll\GetPaymentController@tax')->middleware('auth'); 
 Route::any('nhif', 'Payroll\GetPaymentController@nhif')->middleware('auth'); 
 Route::any('wcf', 'Payroll\GetPaymentController@wcf')->middleware('auth'); 
Route::any('payroll_summary', 'Payroll\GetPaymentController@payroll_summary')->middleware('auth'); 
 Route::any('generate_payslip', 'Payroll\GetPaymentController@generate_payslip')->middleware('auth'); 
 Route::any('received_payslip/{id}', 'Payroll\GetPaymentController@received_payslip')->name('payslip.generate')->middleware('auth'); 
Route::get('payslip_pdfview',array('as'=>'payslip_pdfview','uses'=>'Payroll\GetPaymentController@payslip_pdfview'))->middleware('auth');

Route::post('save_salary_details',array('as'=>'save_salary_details','uses'=>'Payroll\ManageSalaryController@save_salary_details'))->middleware('auth');
    Route::get('employee_salary_list',array('as'=>'employee_salary_list','uses'=>'Payroll\ManageSalaryController@employee_salary_list'))->middleware('auth');
    Route::resource('get_payment2', 'Payroll\GetPayment2Controller')->middleware('auth');
    Route::resource('make_payment2', 'Payroll\MakePayments2Controller')->middleware('auth'); 
   //Route::post('make_payment/store{user_id}{departments_id}{payment_month}', 'Payroll\MakePaymentsController@store')->name('make_payment.store')->middleware('auth'); 
    
});


    Route::group(['prefix' => 'financial_report'], function () {
        Route::any('trial_balance', 'ReportController@trial_balance')->middleware('auth');
         Route::any('trial_balance_summary', 'ReportController@trial_balance_summary')->middleware('auth');
        Route::any('trial_balance/pdf', 'ReportController@trial_balance_pdf')->middleware('auth');
        Route::any('trial_balance/excel', 'ReportController@trial_balance_excel')->middleware('auth');
        Route::any('trial_balance/csv', 'ReportController@trial_balance_csv')->middleware('auth');
        Route::any('ledger', 'ReportController@ledger')->middleware('auth');
        Route::any('journal', 'ReportController@journal')->middleware('auth');
        Route::any('income_statement', 'ReportController@income_statement')->middleware('auth');
         Route::any('income_statement_summary', 'ReportController@income_statement_summary')->middleware('auth');
        Route::any('income_statement/pdf', 'ReportController@income_statement_pdf')->middleware('auth');
        Route::any('income_statement/excel', 'ReportController@income_statement_excel')->middleware('auth');
        Route::any('income_statement/csv', 'ReportController@income_statement_csv')->middleware('auth');
        Route::any('balance_sheet', 'ReportController@balance_sheet')->middleware('auth');
        Route::any('balance_sheet_summary', 'ReportController@balance_sheet_summary')->middleware('auth');
        Route::any('balance_sheet/pdf', 'ReportController@balance_sheet_pdf')->middleware('auth');
        Route::any('balance_sheet/excel', 'ReportController@balance_sheet_excel')->middleware('auth');
        Route::any('balance_sheet/csv', 'ReportController@balance_sheet_csv')->middleware('auth');
         Route::any('summary', 'ReportController@summary')->middleware('auth');
        Route::any('summary/pdf', 'ReportController@summary_pdf')->middleware('auth');
        Route::any('summary/excel', 'ReportController@summary')->middleware('auth');
        Route::any('summary/csv', 'ReportController@summary')->middleware('auth');
        Route::any('cash_flow', 'ReportController@cash_flow')->middleware('auth');
        Route::any('provisioning', 'ReportController@provisioning')->middleware('auth');
        Route::any('provisioning/pdf', 'ReportController@provisioning_pdf')->middleware('auth');
        Route::any('provisioning/excel', 'ReportController@provisioning_excel')->middleware('auth');
        Route::any('provisioning/csv', 'ReportController@provisioning_csv')->middleware('auth');
    });

    Route::group(['prefix' => 'access_control'], function () {
Route::resource('permissions', 'PermissionController')->middleware('auth');
Route::resource('departments', 'DepartmentController')->middleware('auth');
Route::resource('designations', 'DesignationController')->middleware('auth');
Route::resource('roles', 'RoleController')->middleware('auth');

Route::resource('users', 'UsersController')->middleware('auth'); 
Route::get('findDepartment', 'UsersController@findDepartment')->middleware('auth');  
Route::resource('users_details', 'User\UserDetailsController')->middleware('auth');

Route::resource('clients', 'ClientController')->middleware('auth');

Route::resource('system', 'SystemController')->middleware('auth');

//user Details
Route::resource('user_details', 'UserDetailsController')->middleware('auth');
    });
