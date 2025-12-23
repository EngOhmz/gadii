<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controller\Orders_Client_ManipulationsController;
use App\Http\Controller\Truck_Management_ApiController;
use App\Http\Controller\Driver_Management_ApiController;
use App\Http\Controller\Fuel_Management_ApiController;
use App\Http\Controller\Auth_ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//-------********* start Azampesa Route  ***********----------------------------------

 Route::post('get_call_back_data','AzamPesa\IntegrationDepositController@get_call_back_data');
 Route::get('get_token','AzamPesa\IntegrationDepositController@get_token');
 
 //-------********* end Azampesa Route  ***********----------------------------------


//Azampesa Route
//  Route::post('get_call_back_data','AzamPesa\IndexController@get_call_back_data');
//  Route::get('get_token','AzamPesa\IndexController@get_token');
 
 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//global routes 
Route::post('signin','Api_controllers\Auth_ApiController@login22');
Route::post('signup','Api_controllers\Auth_ApiController@register22');
Route::get('all_test_users','Api_controllers\Auth_ApiController@testusers');

//global routes 
Route::post('login','Api_controllers\Auth_ApiController@login');
Route::post('register','Api_controllers\Auth_ApiController@register');

Route::post('pms/register','Api_controllers\Pms\Auth_ApiController@register');

Route::post('pms_login','Api_controllers\Pms\Auth_ApiController@login');

Route::post('azampay_store','AzamPesa\IntegrationDepositController@store_api');

Route::post('pms_register','Api_controllers\Pms\Auth_ApiController@register');


Route::get('register_as','Api_controllers\Auth_ApiController@register_as');

Route::get('payroll_acc','Api_controllers\Auth_ApiController@payroll_acc');

Route::get('get_regions','Api_controllers\MazaoHub\Farmer\FarmerController@get_regions');

Route::get('get_agronomy','Api_controllers\MazaoHub\Farmer\FarmerController@get_agronomy');

Route::get('get_agronomy/{lastId}/index','Api_controllers\MazaoHub\Farmer\FarmerController@get_agronomyOff');

Route::get('get_Alldistricts','Api_controllers\MazaoHub\Farmer\FarmerController@get_Alldistricts');

Route::get('get_Allwards','Api_controllers\MazaoHub\Farmer\FarmerController@get_Allwards');

Route::get('get_version','Api_controllers\MazaoHub\Farmer\Farmer_assetsController@get_version2');


Route::get('get_districts/{id}/find','Api_controllers\MazaoHub\Farmer\FarmerController@get_districts');


Route::get('get_wards/{id}/find','Api_controllers\MazaoHub\Farmer\FarmerController@get_wards');


Route::get('user_email/{email}/find','Api_controllers\Auth_ApiController@user_email');

Route::get('item_find/{id}/{name}/find','Api_controllers\Auth_ApiController@item_find');



// ------restaurant apis  ***start***** store_api  other_index --------------------------------------------------------------------
    
    //bank accounts
    Route::get('get_orders_accounts/{id}/index','Api_controllers\Pms\POS\OrderController@account_code');
    
    //sales(order)
    
    Route::get('get_menu_items/{id}/{type}/index','Api_controllers\Pms\POS\OrderController@menu_items');
    
    //menu
    
    // kitchen inventory
    
    Route::get('menus/{id}/index','Api_controllers\Pms\POS\MenuItemController@index');

    Route::post('menus/save','Api_controllers\Pms\POS\MenuItemController@store');


    Route::get('shopkeeper_sales_orders/{id}/index','Api_controllers\Pms\POS\OrderController@shopkeeper_index');
    
    Route::get('sales_orders/{id}/index','Api_controllers\Pms\POS\OrderController@index');
    
    Route::get('bar_orders/{id}/index','Api_controllers\Pms\POS\OrderController@bar_index');
    
    Route::get('kitchen_orders/{id}/index','Api_controllers\Pms\POS\OrderController@kitchen_index');
    
    
    Route::get('branches/{id}/index','Api_controllers\Pms\POS\OrderController@branch_index');
    
    Route::get('sales_point/{id}/index','Api_controllers\Pms\POS\LocationController@sales_point');
    


    Route::get('sales_orders/{id}/{lastId}/index','Api_controllers\Pms\POS\OrderController@indexOff');
    
    Route::get('bar_orders/{id}/{lastId}/index','Api_controllers\Pms\POS\OrderController@bar_indexOff');
    
    Route::get('kitchen_orders/{id}/{lastId}/index','Api_controllers\Pms\POS\OrderController@kitchen_indexOff');

    Route::post('sales_orders/save','Api_controllers\Pms\POS\OrderController@store');


    Route::get('sales_orders_items/{id}/index','Api_controllers\Pms\POS\OrderController@item_index');

    Route::get('sales_orders_items/{id}/{lastId}/index','Api_controllers\Pms\POS\OrderController@item_indexOff');



    Route::post('sales_orders_items/save','Api_controllers\Pms\POS\OrderController@item_store');
    


    
    Route::get('sales_orders_items_delete/{id}/index','Api_controllers\Pms\POS\OrderController@item_sales_delete');


    Route::post('sales_orders_items_update/update','Api_controllers\Pms\POS\OrderController@item_sales_update');
    
    
    // 123432234
    
    
    Route::get('get_inventory/{id}/index','Api_controllers\Pms\POS\ItemsController@index');
    Route::get('get_category/{id}/index','Api_controllers\Pms\POS\ItemsController@category');

    Route::get('get_inventory/{id}/{lastId}/index','Api_controllers\Pms\POS\ItemsController@indexOff');
    Route::get('get_category/{id}/{lastId}/index','Api_controllers\Pms\POS\ItemsController@categoryOff');


    Route::post('get_inventory/save','Api_controllers\Pms\POS\ItemsController@store');
    Route::post('quantity/update','Api_controllers\Pms\POS\ItemsController@quantity_update');
    Route::post('get_category/save','Api_controllers\Pms\POS\ItemsController@addCategory');

    
    Route::post('get_inventory/{id}/update','Api_controllers\Pms\POS\ItemsController@update');
    Route::get('get_inventory/{id}/delete','Api_controllers\Pms\POS\ItemsController@destroy');
    
    // 123432234
    
    
    
    // ----------------------------------------------------------------------------------------------------------------------------





Route::group(['prefix' => 'ema'], function () {

    Route::group(['prefix' => 'pos'], function () {
        
    Route::get('get_expenses/{id}/index','Api_controllers\MazaoHub\POS\ExpensesController@index');

    Route::get('get_expenses_accounts/{id}/index','Api_controllers\MazaoHub\POS\ExpensesController@expenses_accounts');

    Route::post('get_expenses/save','Api_controllers\MazaoHub\POS\ExpensesController@store');

    Route::get('get_inventory/{id}/index','Api_controllers\MazaoHub\POS\ItemsController@index');
    Route::get('get_category/{id}/index','Api_controllers\MazaoHub\POS\ItemsController@category');

    Route::get('get_inventory/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\ItemsController@indexOff');
    Route::get('get_category/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\ItemsController@categoryOff');


    Route::post('get_inventory/save','Api_controllers\MazaoHub\POS\ItemsController@store');
    Route::post('quantity/update','Api_controllers\MazaoHub\POS\ItemsController@quantity_update');
    Route::post('get_category/save','Api_controllers\MazaoHub\POS\ItemsController@addCategory');

    
    Route::post('get_inventory/{id}/update','Api_controllers\MazaoHub\POS\ItemsController@update');
    Route::get('get_inventory/{id}/delete','Api_controllers\MazaoHub\POS\ItemsController@destroy');


    Route::get('get_supplier/{id}/index','Api_controllers\MazaoHub\POS\SupplierController@index');

    Route::get('get_supplier/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\SupplierController@indexOff');


    Route::post('get_supplier/save','Api_controllers\MazaoHub\POS\SupplierController@store');

    
    Route::post('get_supplier/{id}/update','Api_controllers\MazaoHub\POS\SupplierController@update');
    Route::get('get_supplier/{id}/delete','Api_controllers\MazaoHub\POS\SupplierController@destroy');


    Route::get('get_client/{id}/index','Api_controllers\MazaoHub\POS\ClientController@index');

    Route::get('get_client/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\ClientController@indexOff');


    Route::post('get_client/save','Api_controllers\MazaoHub\POS\ClientController@store');

    
    Route::post('get_client/{id}/update','Api_controllers\MazaoHub\POS\ClientController@update');
    Route::get('get_client/{id}/delete','Api_controllers\MazaoHub\POS\ClientController@destroy');
    
    Route::get('shopkeeper/{id}/index','Api_controllers\MazaoHub\POS\ShopkeeperController@shopkeeper');
    
    Route::post('shop_register','Api_controllers\MazaoHub\POS\ShopkeeperController@store');
    
    Route::get('shopkeeper_delete/{id}/index','Api_controllers\MazaoHub\POS\ShopkeeperController@shopkeeper_delete');
    
    Route::get('get_store_reports2/{id}/{date}/index','Api_controllers\MazaoHub\POS\LocationController@get_store_report');


    Route::get('get_location/{id}/index','Api_controllers\MazaoHub\POS\LocationController@index');

    Route::get('get_location/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\LocationController@indexOff');


    Route::post('get_location/save','Api_controllers\MazaoHub\POS\LocationController@store');
    
    //stockmovemrnt
    
    Route::get('get_stock_movement/{id}/{storeID}/index','Api_controllers\MazaoHub\POS\LocationController@stock_movement_index');
    Route::post('get_stock_movement/save','Api_controllers\MazaoHub\POS\LocationController@stock_movement_store');
    
    //GOODISSUE
    
    Route::get('get_good_issue/{id}/{storeID}/index','Api_controllers\MazaoHub\POS\LocationController@good_issue_index');
    Route::post('get_good_issue/save','Api_controllers\MazaoHub\POS\LocationController@good_issue_store');
    
    
    Route::post('get_location/{id}/update','Api_controllers\MazaoHub\POS\LocationController@update');
    Route::get('get_location/{id}/delete','Api_controllers\MazaoHub\POS\LocationController@destroy');


    Route::get('get_currency','Api_controllers\MazaoHub\POS\PurchaseController@get_currency');


    Route::get('get_items/{id}/index','Api_controllers\MazaoHub\POS\PurchaseController@get_items');

    Route::get('get_items/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\PurchaseController@get_itemsOff');

    Route::get('account_code/{id}/index','Api_controllers\MazaoHub\POS\PurchaseController@account_code');

    Route::get('account_code/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\PurchaseController@account_codeOff');


    Route::get('payment_method','Api_controllers\MazaoHub\POS\PurchaseController@payment_method');


    Route::get('shopkeeper_sales/{id}/index','Api_controllers\MazaoHub\POS\InvoiceController@shopkeeper_index');
    
    Route::get('sales/{id}/index','Api_controllers\MazaoHub\POS\InvoiceController@index');
    
    Route::get('updatelocation/{id}/index','Api_controllers\MazaoHub\POS\InvoiceController@updatelocation');


    Route::get('sales/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\InvoiceController@indexOff');

    Route::post('sales/save','Api_controllers\MazaoHub\POS\InvoiceController@store');


    Route::get('sales_items/{id}/index','Api_controllers\MazaoHub\POS\InvoiceController@item_index');

    Route::get('sales_items/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\InvoiceController@item_indexOff');



    Route::post('sales_items/save','Api_controllers\MazaoHub\POS\InvoiceController@item_store');
    
    
     Route::post('sales_items2222/save','Api_controllers\MazaoHub\POS\InvoiceController@item_store222');

    Route::post('pay_sales/save','Api_controllers\MazaoHub\POS\InvoiceController@pay_sales');


    
    Route::get('sales_items_delete/{id}/index','Api_controllers\MazaoHub\POS\InvoiceController@item_sales_delete');


    Route::post('sales_items_update/update','Api_controllers\MazaoHub\POS\InvoiceController@item_sales_update');



    Route::get('store_reports/{id}/{date}/index','Api_controllers\MazaoHub\POS\PurchaseController@get_store_item'); 
    
    
    Route::get('get_reports_summary/{id}/{date}/{type}/index','Api_controllers\MazaoHub\POS\PurchaseController@get_reports'); 


    Route::get('purchase_items/{id}/index','Api_controllers\MazaoHub\POS\PurchaseController@item_purchase_index');


    Route::post('purchase_items/save','Api_controllers\MazaoHub\POS\PurchaseController@item_purchase_store');



    Route::get('purchase_items_delete/{id}/index','Api_controllers\MazaoHub\POS\PurchaseController@item_purchase_delete');


    Route::post('purchase_items_update/update','Api_controllers\MazaoHub\POS\PurchaseController@item_purchase_update');

    Route::get('get_project/{id}/index','Api_controllers\MazaoHub\POS\PurchaseController@project');


    Route::get('purchase/{id}/index','Api_controllers\MazaoHub\POS\PurchaseController@index');


    Route::get('get_barcode/{id}/{purchase_id}/index','Api_controllers\MazaoHub\POS\PurchaseController@get_barcode');

    Route::get('get_barcode_item/{id}/{user_id}/index','Api_controllers\MazaoHub\POS\PurchaseController@get_barcode_item');


    Route::post('meter/test','Api_controllers\MazaoHub\POS\PurchaseController@meter');


    Route::get('purchase/{id}/{lastId}/index','Api_controllers\MazaoHub\POS\PurchaseController@indexOff');

    Route::post('purchase/save','Api_controllers\MazaoHub\POS\PurchaseController@store');
    
    Route::get('purchase/{id}/approve','Api_controllers\MazaoHub\POS\PurchaseController@approve');

    Route::get('purchase/{id}/cancel','Api_controllers\MazaoHub\POS\PurchaseController@cancel');

    Route::get('purchase/{id}/purchase_list','Api_controllers\MazaoHub\POS\PurchaseController@purchase_list');

    Route::get('purchase/{id}/make_payment','Api_controllers\MazaoHub\POS\PurchaseController@make_payment');

    Route::post('pay_purchase/save','Api_controllers\MazaoHub\POS\PurchaseController@pay_purchase');


    Route::post('batch/save','Api_controllers\MazaoHub\POS\PurchaseController@save_batch');

    Route::get('purchase/{id}/good_receive','Api_controllers\MazaoHub\POS\PurchaseController@good_receive_new');

    Route::post('purchase/{idP}/update','Api_controllers\MazaoHub\POS\PurchaseController@update');

    Route::post('purchase_scan/save','Api_controllers\MazaoHub\POS\PurchaseController@scan_serial_batch');



    Route::get('purchase/{id}/delete','Api_controllers\MazaoHub\POS\PurchaseController@destroy');


    });
    
    Route::group(['prefix' => 'pms'], function () {
        //client
    Route::get('get_client/{id}/index','Api_controllers\Pms\Outlet\ClientController@index');

    Route::get('get_client/{id}/{lastId}/index','Api_controllers\Pms\Outlet\ClientController@indexOff');


    Route::post('client/save','Api_controllers\Pms\Outlet\ClientController@store');

    
    Route::post('get_client/{id}/update','Api_controllers\Pms\Outlet\ClientController@update');
    Route::get('get_client/{id}/delete','Api_controllers\Pms\Outlet\ClientController@destroy');
    
    //store(location)
    Route::get('get_store/{id}/index','Api_controllers\Pms\Outlet\LocationController@index');

    Route::get('get_store/{id}/{lastId}/index','Api_controllers\Pms\Outlet\LocationController@indexOff');


    Route::post('store/save','Api_controllers\Pms\Outlet\LocationController@store');

    
    Route::post('get_store/{id}/update','Api_controllers\Pms\Outlet\LocationController@update');
    Route::get('get_store/{id}/delete','Api_controllers\Pms\Outlet\LocationController@destroy');
    
    
    // inventory bar
    
    
    Route::get('get_inventory/{id}/index','Api_controllers\Pms\Outlet\ItemsController@index');

    Route::get('get_inventory/{id}/{lastId}/index','Api_controllers\Pms\Outlet\ItemsController@indexOff');


    Route::post('inventory/save','Api_controllers\Pms\Outlet\ItemsController@store');

    
    Route::post('get_inventory/{id}/update','Api_controllers\Pms\Outlet\ItemsController@update');
    Route::get('get_inventory/{id}/delete','Api_controllers\Pms\Outlet\ItemsController@destroy');
    
    
    // kitchen inventory
    
    Route::get('get_menus/{id}/index','Api_controllers\Pms\Outlet\MenuItemController@index');

    Route::post('menus/save','Api_controllers\Pms\Outlet\MenuItemController@store');
    
    
    //currency

    Route::get('get_currency','Api_controllers\Pms\Outlet\OrderController@get_currency');
    //bank accounts
    Route::get('get_accounts/{id}/index','Api_controllers\Pms\Outlet\OrderController@account_code');
    
    //payments
    
    Route::get('payment_method','Api_controllers\Pms\Outlet\OrderController@payment_method');
    
    //sales(order)
    
    Route::get('get_kitchen_sales/{id}/index','Api_controllers\Pms\Outlet\OrderController@kitchen_index');

    Route::post('kitchen_sales/save','Api_controllers\Pms\Outlet\OrderController@kitchen_store');


    // Route::post('sales_items/save','Api_controllers\Pms\Outlet\OrderController@item_store');
    
    Route::get('get_bar_sales/{id}/index','Api_controllers\Pms\Outlet\OrderController@bar_index');

    Route::post('bar_sales/save','Api_controllers\Pms\Outlet\OrderController@bar_store');


    // Route::post('sales_items/save','Api_controllers\Pms\Outlet\OrderController@item_store');
    
    //supplier
    
    Route::get('get_supplier/{id}/index','Api_controllers\Pms\Outlet\SupplierController@index');

    Route::post('supplier/save','Api_controllers\Pms\Outlet\SupplierController@store');
        
    //purchase
    
    Route::get('get_kitchen_purchase/{id}/index','Api_controllers\Pms\Outlet\PurchaseController@kitchen_index');

    Route::post('kitchen_purchase/save','Api_controllers\Pms\Outlet\PurchaseController@kitchen_store');


    // Route::post('sales_items/save','Api_controllers\Pms\Outlet\OrderController@item_store');
    
    Route::get('get_bar_purchase/{id}/index','Api_controllers\Pms\Outlet\PurchaseController@bar_index');

    Route::post('bar_purchase/save','Api_controllers\Pms\Outlet\PurchaseController@bar_store');
    
    
    
    
    Route::get('get_purchase/{id}/index','Api_controllers\Pms\Outlet\PurchaseController@index');

    Route::post('purchase/save','Api_controllers\Pms\Outlet\PurchaseController@store');
    
    Route::post('items_purchase/save','Api_controllers\Pms\Outlet\PurchaseController@items_store');
    
    Route::post('purchaseItems/save','Api_controllers\Pms\Outlet\PurchaseController@item_purchase_store');
    
    Route::get('purchase_items/{id}/index','Api_controllers\Pms\Outlet\PurchaseController@item_purchase_index');


    Route::get('purchase_items_delete/{id}/index','Api_controllers\Pms\Outlet\PurchaseController@item_purchase_delete');


    Route::post('purchase_items_update/update','Api_controllers\Pms\Outlet\PurchaseController@item_purchase_update');
    
    //expenses
    
    Route::get('get_expenses/{id}/index','Api_controllers\Pms\Outlet\ExpensesController@index');

    Route::get('get_expenses_accounts/{id}/index','Api_controllers\Pms\Outlet\ExpensesController@expenses_accounts');

    Route::post('expenses/save','Api_controllers\Pms\Outlet\ExpensesController@store');

    });
    
    Route::group(['prefix' => 'farming'], function () {
        
    // start farming routes
    
    Route::get('crop_type','Api_controllers\MazaoHub\Farming\CropTypeController@index');
    Route::get('seed_type','Api_controllers\MazaoHub\Farming\FeedTypeController@index');

    Route::get('crop_type/{lastId}/index','Api_controllers\MazaoHub\Farming\CropTypeController@indexOff');
    Route::get('seed_type/{lastId}/index','Api_controllers\MazaoHub\Farming\FeedTypeController@indexOff');


    Route::post('crop_type/save','Api_controllers\MazaoHub\Farming\CropTypeController@store');
    Route::post('seed_type/save','Api_controllers\MazaoHub\Farming\FeedTypeController@store');

    
    Route::post('crop_type/{id}/update','Api_controllers\MazaoHub\Farming\CropTypeController@update');
    Route::get('crop_type/{id}/delete','Api_controllers\MazaoHub\Farming\CropTypeController@destroy');

    Route::post('seed_type/{id}/update','Api_controllers\MazaoHub\Farming\FeedTypeController@update');
    Route::get('seed_type/{id}/delete','Api_controllers\MazaoHub\Farming\FeedTypeController@destroy');


    Route::get('pesticide_type',"Api_controllers\MazaoHub\Farming\PesticideTypeController@index" );

    Route::get('pesticide_type/{lastId}/index',"Api_controllers\MazaoHub\Farming\PesticideTypeController@indexOff" );


    Route::post('pesticide_type/save',"Api_controllers\MazaoHub\Farming\PesticideTypeController@store" );
    Route::get('farming_process','Api_controllers\MazaoHub\Farming\Farming_processController@index');
   
    Route::get('farming_process/{lastId}/index','Api_controllers\MazaoHub\Farming\Farming_processController@indexOff');

   
    Route::post('farming_process/save','Api_controllers\MazaoHub\Farming\Farming_processController@store');
    Route::get('lime_base','Api_controllers\MazaoHub\Farming\LimeBaseController@index');

    Route::get('lime_base/{lastId}/index','Api_controllers\MazaoHub\Farming\LimeBaseController@indexOff');


    Route::post('lime_base/save','Api_controllers\MazaoHub\Farming\LimeBaseController@store');

    //Seasson Routes
    Route::get('get_seassons/{id}/index','Api_controllers\MazaoHub\Farming\SeassonController@get_seassons');

    Route::get('get_seassons/{id}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@get_seassonsOff');


    Route::get('seasson/{id}/{date}/index','Api_controllers\MazaoHub\Farming\SeassonController@index');

    Route::get('seasson/{id}/{lastId}/{date}/index','Api_controllers\MazaoHub\Farming\SeassonController@indexOff');



    Route::post('seasson/save','Api_controllers\MazaoHub\Farming\SeassonController@store');
    
    Route::get('land_preparation/{id}/{landId}/index','Api_controllers\MazaoHub\Farming\SeassonController@land_preparation');

    Route::get('land_preparation/{id}/{landId}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@land_preparationOff');


    Route::post('land_preparation/save','Api_controllers\MazaoHub\Farming\SeassonController@land_preparation_store');
    
    Route::get('farm_program/{id}/{landId}/index','Api_controllers\MazaoHub\Farming\SeassonController@farm_program');

    Route::get('farm_program/{id}/{landId}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@farm_programOff');


    Route::post('farm_program/save','Api_controllers\MazaoHub\Farming\SeassonController@farm_program_store');
    
    Route::get('sowing/{id}/{landId}/index','Api_controllers\MazaoHub\Farming\SeassonController@sowing');

    Route::get('sowing/{id}/{landId}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@sowingOff');


    Route::post('sowing/save','Api_controllers\MazaoHub\Farming\SeassonController@sowing_store');
    
    Route::get('fertilizer/{id}/{landId}/index','Api_controllers\MazaoHub\Farming\SeassonController@fertilizer');
    
    Route::get('fertilizer/{id}/{landId}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@fertilizerOff');

    
    Route::post('fertilizer/save','Api_controllers\MazaoHub\Farming\SeassonController@fertilizer_store');
    

    Route::get('weeding/{id}/{landId}/index','Api_controllers\MazaoHub\Farming\SeassonController@weeding');

    Route::get('weeding/{id}/{landId}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@weedingOff');


    Route::post('weeding/save','Api_controllers\MazaoHub\Farming\SeassonController@weeding_store');
    
    Route::get('pesticide/{id}/{landId}/index','Api_controllers\MazaoHub\Farming\SeassonController@pesticide');

    Route::get('pesticide/{id}/{landId}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@pesticideOff');


    Route::post('pesticide/save','Api_controllers\MazaoHub\Farming\SeassonController@pesticide_store');
    
    Route::get('warehouses','Api_controllers\MazaoHub\Farming\SeassonController@warehouses');


    Route::get('pre_harvests/{id}/{landId}/index','Api_controllers\MazaoHub\Farming\SeassonController@pre_harvests');

    Route::get('pre_harvests/{id}/{landId}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@pre_harvestsOff');


    Route::post('pre_harvests/save','Api_controllers\MazaoHub\Farming\SeassonController@pre_harvests_store');
    
    
    Route::get('post_harvests/{id}/{landId}/index','Api_controllers\MazaoHub\Farming\SeassonController@post_harvests');
    
    Route::get('post_harvests/{id}/{landId}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@post_harvestsOff');

    Route::post('post_harvests/save','Api_controllers\MazaoHub\Farming\SeassonController@post_harvests_store');
    

    Route::get('warehouses/{id}/index','Api_controllers\MazaoHub\Farming\SeassonController@warehouses2');
    Route::get('warehouses/{id}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@warehouses2Off');
   
   
    Route::post('warehouses/save','Api_controllers\MazaoHub\Farming\SeassonController@warehouses_store');
    
    Route::get('storage/{id}/{landId}/index','Api_controllers\MazaoHub\Farming\SeassonController@storage');

    Route::get('storage/{id}/{landId}/{lastId}/index','Api_controllers\MazaoHub\Farming\SeassonController@storageOff');


    Route::post('storage/save','Api_controllers\MazaoHub\Farming\SeassonController@storage_store');
    

    Route::resource('/farming_cost','Api_controllers\MazaoHub\Farming\Farming_costController');
    Route::resource('/cost_centre','Api_controllers\MazaoHub\Farming\Cost_CentreController');
    Route::resource('/farm_program','Api_controllers\MazaoHub\Farming\FarmProgramController');
    Route::resource('/crops_monitoring','Api_controllers\MazaoHub\Farming\Crops_MonitoringController');
    Route::resource('/register_assets','Api_controllers\MazaoHub\Farming\Farmer_assetsController');
    Route::get('/landview',"Api_controllers\MazaoHub\Farming\Farmer_assetsController@index1" );
    Route::get('/landdelete/{$id}',"Api_controllers\MazaoHub\Farming\Farmer_assetsController@destroy2" );
    Route::get('getFarm',"Api_controllers\MazaoHub\Farming\Farmer_assetsController@getFarm" );
    
    Route::resource('seeds_type',"Api_controllers\MazaoHub\Farming\Seeds_TypesController" );
    

    Route::get('download',array('as'=>'download','uses'=>'Api_controllers\MazaoHub\Farming\Crops_MonitoringController@download'));
    // end farming routes
    
    // start crop life cycle routes
    Route::resource('irrigation','Api_controllers\MazaoHub\Farming\CropLifeCycle\IrrigationController');
    // end crop life cycle routes
    
    
    
    


    Route::resource('/cropslifecycle','Api_controllers\MazaoHub\Farming\CropsLifeCycleController');
    Route::any('editLifeCycle',array('as'=>'editLifeCycle','uses'=>'Api_controllers\MazaoHub\Farming\CropsLifeCycleController@editLifeCycle'));
    Route::any('deleteLifeCycle',array('as'=>'deleteLifeCycle','uses'=>'Api_controllers\MazaoHub\Farming\CropsLifeCycleController@deleteLifeCycle'));
    Route::get('findFarm',"Api_controllers\MazaoHub\Farming\SeassonController@findFarm" );
    Route::get('findLime',"Api_controllers\MazaoHub\Farming\CropsLifeCycleController@findLime" );
    Route::get('findSeed',"Api_controllers\MazaoHub\Farming\CropsLifeCycleController@findSeed" );
    Route::get('findPesticide',"Api_controllers\MazaoHub\Farming\CropsLifeCycleController@findPesticide" );
    Route::get('monitorModal', 'Api_controllers\MazaoHub\Farming\CropsLifeCycleController@discountModal');
    Route::post('save_monitor', 'Api_controllers\MazaoHub\Farming\CropsLifeCycleController@save_monitor')->name('monitor.save');
    });
    
    Route::group(['prefix' => 'farmer'], function () {
    Route::get('farmer/{id}/index','Api_controllers\MazaoHub\Farmer\FarmerController@index');

    Route::get('get_farmer/{id}/{lastId}/index','Api_controllers\MazaoHub\Farmer\FarmerController@get_farmer');

    //Route::post('save','FarmerController@store');
    Route::get('farmer/{id}/edit','Api_controllers\MazaoHub\Farmer\FarmerController@edit');
    //Route::resource('farmer','FarmerController');
    Route::post('farmer/update/{id}','Api_controllers\MazaoHub\Farmer\FarmerController@update');
    Route::post('farmer/save','Api_controllers\MazaoHub\Farmer\FarmerController@store');
    Route::get('farmer/{id}/delete','Api_controllers\MazaoHub\Farmer\FarmerController@destroy');
    Route::get('farmer/{id}/show','Api_controllers\MazaoHub\Farmer\FarmerController@show');
   
    Route::get('land_details/{id}/index','Api_controllers\MazaoHub\Farmer\Farmer_assetsController@index');
   
    Route::get('get_land_details/{id}/{lastId}/index','Api_controllers\MazaoHub\Farmer\Farmer_assetsController@indexOff');
   
   
    Route::post('land_details/save','Api_controllers\MazaoHub\Farmer\Farmer_assetsController@store');
    Route::get('farmer_assets/{id}/index','Api_controllers\MazaoHub\Farmer\Farmer_assetsController@index1');
    
    Route::get('get_farmer_assets/{id}/{lastId}/index','Api_controllers\MazaoHub\Farmer\Farmer_assetsController@index1Off');

    
    Route::post('farmer_assets/save','Api_controllers\MazaoHub\Farmer\Farmer_assetsController@store1');
    Route::get('findRegion', 'Api_controllers\MazaoHub\Farmer\FarmerController@findRegion');  
    Route::get('findDistrict', 'Api_controllers\MazaoHub\Farmer\FarmerController@findDistrict');  
    Route::get('assign_farmer','Api_controllers\MazaoHub\Farmer\FarmerController@assign_farmer');
    Route::post('save_farmer', 'Api_controllers\MazaoHub\Farmer\FarmerController@save_farmer')->name('farmer.save');
    Route::get('farmerModal', 'Api_controllers\MazaoHub\Farmer\FarmerController@discountModal');
    
    
    Route::post('group/{id}/update','Api_controllers\MazaoHub\Farmer\GroupController@update');
    Route::get('manage-group','Api_controllers\MazaoHub\Farmer\GroupController@index');
    Route::get('manage-group/{lastId}/index','Api_controllers\MazaoHub\Farmer\GroupController@indexOff');
   

    Route::post('manage-group/save','Api_controllers\MazaoHub\Farmer\GroupController@store');
    Route::get('group/{id}/delete','Api_controllers\MazaoHub\Farmer\GroupController@destroy');
    
    Route::get('farmer/group/{id}/add','Api_controllers\MazaoHub\Farmer\MemberController@index');
    Route::get('farmer/group/','Api_controllers\MazaoHub\Farmer\MemberController@show');
    
    route::post('save','Api_controllers\MazaoHub\Farmer\MemberController@store');
    
    route::get('land/{id}/index','Api_controllers\MazaoHub\Farmer\LandController@index');
    route::post('land/save','Api_controllers\MazaoHub\Farmer\LandController@store');
    route::get('land/{id}/delete','Api_controllers\MazaoHub\Farmer\LandController@destroy');
    route::post('land/{id}/edit','Api_controllers\MazaoHub\Farmer\LandController@update');
    //oute::get('test',[App\Http\Livewire\Counter::class, 'render']);
    
    
    
    //supplier
    Route::view('manage/group','agrihub.manage-group');
    
    Route::get('manage/supplier','Api_controllers\MazaoHub\Farmer\shop\SupplierController@index');
    Route::post('supplier/save','Api_controllers\MazaoHub\Farmer\shop\SupplierController@store');
    Route::get('supplier/{id}/delete','Api_controllers\MazaoHub\Farmer\shop\SupplierController@destroy');
    Route::post('supplier/{id}/edit','Api_controllers\MazaoHub\Farmer\shop\SupplierController@store');
    });
    
    });

//protected routes
Route::group(['middleware'=>['auth:sanctum']],function () {
    Route::resource('truck_management','Api_controllers\Logistic\Truck_Management_ApiController');
    Route::resource('driver_management','Api_controllers\Logistic\Driver_Management_ApiController');
    Route::resource('fuel_management','Api_controllers\Logistic\Fuel_Management_ApiController');
    Route::resource('manipulation','Orders_Client_ManipulationsController');

  
});




    
    // make crops orders
    Route::resource('crops_order','Client_OrderController');
    Route::resource('manipulation','Orders_Client_ManipulationsController');
    
