<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Accounts;
use App\Models\Currency;
use App\Models\JournalEntry;
use App\Models\Retail\Location;
use App\Models\ServiceType;
use App\Models\Payment_methodes;
use App\Models\Retail\Supplier;
use App\Models\Retail\InventoryList;
use App\Models\Retail\Activity;
use App\Models\Retail\Purchase;
use App\Models\Retail\PurchaseItems;
use App\Models\Retail\Items;
use App\Models\Retail\PurchaseHistory;
use App\Models\Retail\PurchasePayments;
use App\Models\Retail\PurchaseSerial;
use App\Models\Retail\PurchaseSerialItems;
use App\Models\Retail\PurchaseSerialList;
use App\Models\Retail\PurchaseSerialHistory;
use App\Models\Retail\PurchaseSerialPayments;
use App\Models\User;
use PDF;
use App\Models\MechanicalItem;
use App\Models\MechanicalRecommedation;
use App\Models\Retail\Client;
use App\Models\Retail\Invoice;
use App\Models\Retail\PurchaseHistoryAll;
use App\Models\Region;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Exception;

use function PHPSTORM_META\type;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        //
    //    $data=Purchase::where('added_by', $id);
    //    $purchases=PurchaseSerial::where('added_by', $id)->union($data)->get();

          $purchases = Purchase::join('retail_locations', 'retail_locations.added_by', '=', 'retail_pos_purchases.added_by')
                                    ->whereIn('retail_locations.added_by', [$id]) 
                                    ->select('*','retail_pos_purchases.id as purchase_id')
                                    ->orderBy('retail_pos_purchases.created_at', 'desc')
                                    ->get();
        
        if($purchases->isNotEmpty()){

            foreach($purchases as $row){


                // $data['purchase_id'] = intval($row->purchase_id);
                
                // $location2222 = Location::find(intval($row->location));
                
                

                // if ($row->name == $location2222->name) {
                    
                    $data = $row;

                $data['id'] = intval($row->purchase_id);


                if (!empty($row->location)) {

                    $data['location_id'] = intval($row->location);

                    $location = Location::find(intval($row->location));
                    if(!empty($location)){
                        $loc2= Location::where('id', $row->location)->value('name');


                        $data['location'] = $loc2;
                    }

                    else{
                        $data['location'] = null;

                    }

                    
                }
                else{
                    $data['location_id'] = null;

                    // $loc2= Location::where('id', $row->location)->value('name');


                    $data['location'] = null;
                }

                 if(!empty($row->supplier_id)){
                    $data['supplier_id'] = intval($row->supplier_id);


                    $data['supplier'] = $row->supplier->name;
                }
                else{
                    $data['supplier_id'] = null;


                    $data['supplier'] = null;
                }

               

                // $loc= Location::where('id', $row->location)->value('name');

               


                if($row->status == 0){
                    $data['status'] = 'Not Approved';
                }
                elseif($row->status == 1){
                    $data['status'] = 'Not Paid';
                }
                elseif($row->status == 2){
                    $data['status'] = 'Partially Paid';
                }
                elseif($row->status == 3){
                    $data['status'] = 'Fully Paid';
                }
                elseif($row->status == 4){
                    $data['status'] = 'Cancelled';
                }
                elseif($row->status == 5){
                    $data['status'] = 'Received';
                }

                elseif($row->status == 6){
                    $data['status'] = 'Scanned and Paid';
                }
                
                $farmers[] = $data;
                // }
    
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','purchase'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Purchase found'];
            return response()->json($response,200);
        } 
    }

    public function indexOff(int $id, int $lastId)
    {
        //
    //    $data=Purchase::where('added_by', $id)->where('id', '>', $lastId);
    //    $purchases=PurchaseSerial::where('added_by', $id)->union($data)->get();


       $purchases = Purchase::join('retail_locations', 'retail_locations.added_by', '=', 'retail_pos_purchases.added_by')
                                    ->where('retail_pos_purchases.added_by', $id) 
                                    ->where('retail_pos_purchases.id', '>',  $lastId) 
                                    ->select('*','retail_pos_purchases.id as purchase_id')
                                    ->orderBy('retail_pos_purchases.created_at', 'desc')
                                    ->get();
        
        if($purchases->isNotEmpty()){

            foreach($purchases as $row){

                // $data['id'] = intval($row->purchase_id);

        // $location2222 = Location::find(intval($row->location));

                // if ($row->name == $location2222->name) {

                    $data = $row;

                    $data['id'] = intval($row->purchase_id);


                    if (!empty($row->location)) {
                        $data['location_id'] = intval($row->location);
                        $location = Location::find(intval($row->location));
                        if (!empty($location)) {
                            $loc2= Location::where('id', $row->location)->value('name');


                            $data['location'] = $loc2;
                        } else {
                            $data['location'] = null;
                        }
                    } else {
                        $data['location_id'] = null;

                        // $loc2= Location::where('id', $row->location)->value('name');


                        $data['location'] = null;
                    }

                if(!empty($row->supplier_id)){
                    $data['supplier_id'] = intval($row->supplier_id);


                    $data['supplier'] = $row->supplier->name;
                }
                else{
                    $data['supplier_id'] = null;


                    $data['supplier'] = null;
                }



                    if ($row->status == 0) {
                        $data['status'] = 'Not Approved';
                    } elseif ($row->status == 1) {
                        $data['status'] = 'Not Paid';
                    } elseif ($row->status == 2) {
                        $data['status'] = 'Partially Paid';
                    } elseif ($row->status == 3) {
                        $data['status'] = 'Fully Paid';
                    } elseif ($row->status == 4) {
                        $data['status'] = 'Cancelled';
                    } elseif ($row->status == 5) {
                        $data['status'] = 'Received';
                    } elseif ($row->status == 6) {
                        $data['status'] = 'Scanned and Paid';
                    }

                    $farmers[] = $data;
                // }
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','purchase'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Purchase found'];
            return response()->json($response,200);
        } 
    }


    public function  get_items(int $id){

        $items = PurchaseItems::where('purchase_id', $id)->orderBy('created_at', 'asc')->get();

        if($items->isNotEmpty()){

            
            foreach($items as $row){

                $data = $row;

                $data['purchase_item_id'] = intval($row->id);


                $data['id'] = intval($row->items_id);

                $data['purchase_id'] = intval($row->purchase_id);

                $data['inventory_id'] = intval($row->items_id);




                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','items'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Items found'];
            return response()->json($response,200);
        }

    }

    public function  get_itemsOff(int $id, int $lastId){

        // $items = PurchaseItems::where('purchase_id', $id)->where('id', '>', $lastId)->get();
        $items_last = PurchaseItems::where('purchase_id', $id)->where('items_id', $lastId)->orderBy('created_at', 'desc')->first();

        if(!empty($items_last)){

            $items = PurchaseItems::where('purchase_id', $id)->where('id', '>', $items_last->id)->get();


            if($items->isNotEmpty()){
    
                
                foreach($items as $row){
    
                    $data = $row;
    
                    $data['purchase_item_id'] = intval($row->id);
    
                    $data['purchase_id'] = intval($row->purchase_id);
    
    
                    $data['id'] = intval($row->items_id);
    
                    $data['inventory_id'] = intval($row->items_id);
    
    
    
                    $farmers[] = $data;
         
                }
    
                $response=['success'=>true,'error'=>false,'message'=>'successfully','items'=>$farmers];
                return response()->json($response,200);
            }
            else{
    
                $response=['success'=>false,'error'=>true,'message'=>'No Items found'];
                return response()->json($response,200);
            }
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Items found'];
            return response()->json($response,200);
        }

       

    }

    public function get_currency(){

        $currency= Currency::all();

        if($currency->isNotEmpty()){

            
            $response=['success'=>true,'error'=>false,'message'=>'successfully','currency'=>$currency];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Currency found'];
            return response()->json($response,200);
        } 

    }

    public function get_barcode(int $id, int $purchase_id){

        // $items= PurchaseHistoryAll::where('purchase_id', $purchase_id)->where('item_id', $id)->get();

        $items = PurchaseItems::where('purchase_id', $purchase_id)->where('items_id', $id)->orderBy('created_at', 'desc')->get();


        if($items->isNotEmpty()){

            foreach($items as $dt){

                // $data = $row;

                

                // if($dt2->isNotEmpty()){


                // foreach($dt2 as $dt){

                    $data2['purchase_item_id']  = $dt->id;

                    $data2['purchase_id'] = intval($dt->purchase_id);

                    $data2['id'] = intval($dt->items_id);

                    $data2['inventory_id'] = intval($dt->items_id);

                    $data2['expire_date'] = $dt->expire_date;

                    // $data2['item_id'] = intval($dt->item_id);

                    $inv_qnt = Items::find(intval($dt->items_id))->quantity;


                    $data['inventory_quantity'] = $inv_qnt;



                    $data2['barcode'] = $dt->barcode;

                    $purchase = Purchase::find(intval($dt->purchase_id));

                    if(!empty($purchase)){

                        $data2['type'] = $purchase->type;

                        $data2['purchase_date'] = $purchase->purchase_date;
                    }
                    else{

                        $data2['type'] = null;

                        $data2['purchase_date'] = null;
                    }


                    $data2['added_by'] = $dt->added_by;




                    $data2['quantity'] = $dt->quantity;

                    $data2['due_quantity'] = $dt->due_quantity;
                    $data2['category'] = $dt->category;
                    $data2['unit'] = $dt->unit;
                    $data2['price'] = $dt->price;
                    $data2['total_cost'] = $dt->total_cost;
                    $data2['total_tax'] = $dt->total_tax;
                    $data2['tax_rate'] = $dt->tax_rate;
                    $data2['item_name'] = $dt->item_name;

                    $farmers[] = $data2;

                // }




     
            }


            $response=['success'=>true,'error'=>false,'message'=>'successfully','data'=>$farmers];
            return response()->json($response,200);
            
            
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Barcode by that id found'];
            return response()->json($response,200);
        } 

    }


    public function get_barcode_item($id, $user_id){

        // $items= PurchaseHistoryAll::where('barcode', $id)
        //                             ->orderBy('created_at', 'desc')->limit(1)->get();

        $items = PurchaseItems::where('added_by', $user_id)->where('barcode', $id)->orderBy('created_at', 'desc')->get();


        if($items->isNotEmpty()){

            foreach($items as $dt){

                // $data = $row;


                // if($dt2->isNotEmpty()){


                    // foreach($dt2 as $dt){
    
                        $data2['purchase_item_id']  = $dt->id;
    
                        $data2['purchase_id'] = intval($dt->purchase_id);
    
                        $data2['id'] = intval($dt->items_id);

                        // $data2['item_id'] = intval($dt->item_id);


                        $data2['expire_date'] = $dt->expire_date;

                        $data2['inventory_id'] = intval($dt->items_id);


                        


                        

    
    
                        $data2['barcode'] = $dt->barcode;

                        $purchase = Purchase::find(intval($dt->purchase_id));

                        if(!empty($purchase)){

                            $data2['type'] = $purchase->type;

                            $data2['purchase_date'] = $purchase->purchase_date;
                        }
                        else{

                            $data2['type'] = null;

                            $data2['purchase_date'] = null;
                        }
                        
                        $inv_qnt = Items::find(intval($dt->items_id));


                        $data['inventory_quantity'] = $inv_qnt;
                        
                        $data2['name']=$inv_qnt->name;
                        $data2['cost_price']=$inv_qnt->cost_price;
                        $data2['sales_price']=$inv_qnt->sales_price;
                        $data2['unit']= $inv_qnt->unit;
                        $data2['description']=$inv_qnt->description;
                        $data2['manufacturer']=$inv_qnt->manufacturer;
                        $data2['user_id']=$inv_qnt->user_id;
                        

                        $data2['added_by'] = $dt->added_by;
    
                        $data2['quantity'] = $inv_qnt->quantity;
    
                        $data2['due_quantity'] = $dt->due_quantity;
                        $data2['category'] = $dt->category;
                        // $data2['unit'] = $dt->unit;
                        $data2['price'] = $dt->price;
                        $data2['total_cost'] = $dt->total_cost;
                        $data2['total_tax'] = $dt->total_tax;
                        $data2['tax_rate'] = $dt->tax_rate;
                        $data2['item_name'] = $dt->item_name;
    
                        $farmers = $data2;
    
                    // }
    
    
    
                    
                    
                    
                // }
    
                // else{
    
                //     $response=['success'=>false,'error'=>true,'message'=>'No Barcode by that id found'];
                //     return response()->json($response,200);
                // }

                // if(!empty($dt2)){
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','data'=>$farmers];
            return response()->json($response,200);

            
            // $response=['success'=>true,'error'=>false,'message'=>'successfully','data'=>$farmers];
            // return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Barcode by that id found'];
            return response()->json($response,200);
        } 

    }

    public function get_store_item(int $id, String $date){

        // $purchases = Purchase::join('locations', 'locations.added_by', '=', 'pharmacy_pos_purchases.added_by')
        //                             ->join('pharmacy_pos_invoices', 'pharmacy_pos_purchases.added_by', '=', 'pharmacy_pos_invoices.added_by')
        //                             ->where('locations.added_by', $id)
        //                             ->whereDate('pharmacy_pos_purchases.created_at', $date)
        //                             ->whereDate('pharmacy_pos_invoices.created_at', $date) 
        //                             ->get();

        $locations = Location::where('added_by', $id)->get();

        if($locations->isNotEmpty()){

            foreach($locations as $location){

                $data44['location_id'] = intval($location->id);

                $data44['location'] = $location->name;

                $data44['date'] = $date;

                $farmers1 = [];

                $farmers23 = [];
                



            $purchases = Purchase::where('location', $location->id)->where('added_by', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->get();

            if($purchases->isNotEmpty()){


                $purchase_quantity = Purchase::where('location', $location->id)->where('added_by', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->count('id');

                $data44['total_purchase'] = $purchase_quantity;

                $purchase_due_amount = Purchase::where('location', $location->id)->where('added_by', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->sum('due_amount');

                $data44['total_purchase_due_amount'] = $purchase_due_amount;

                $purchase_paid_amount = Purchase::where('location', $location->id)->where('added_by', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->sum('paid_amount');

                $data44['total_purchase_paid_amount'] = $purchase_paid_amount;


                // foreach($purchases as $row){

                //     // $data['id'] = intval($row->purchase_id);
    
    
                //     $data = $row;
    
                //     $data['id'] = intval($row->id);
    
                //     $data['supplier_id'] = intval($row->supplier_id);
    
                //     $data['supplier'] = $row->supplier->name;
    
                   
    
                //     if($row->status == 0){
                //         $data['status'] = 'Not Approved';
                //     }
                //     elseif($row->status == 1){
                //         $data['status'] = 'Not Paid';
                //     }
                //     elseif($row->status == 2){
                //         $data['status'] = 'Partially Paid';
                //     }
                //     elseif($row->status == 3){
                //         $data['status'] = 'Fully Paid';
                //     }
                //     elseif($row->status == 4){
                //         $data['status'] = 'Cancelled';
                //     }
                //     elseif($row->status == 5){
                //         $data['status'] = 'Received';
                //     }
    
                //     elseif($row->status == 6){
                //         $data['status'] = 'Scanned and Paid';
                //     }
    
    
                //     $farmers1[] = $data;
         
                // }
            }
            else{
               
                $data44['total_purchase'] = 0;

                $data44['total_purchase_due_amount'] = "0.00";

                $data44['total_purchase_paid_amount'] = "0.00";



            }
            $invoices = Invoice::where('location', $location->id)->where('added_by', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->get();

            if($invoices->isNotEmpty()){

                $sales_quantity = Invoice::where('location', $location->id)->where('added_by', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->count('id');

                $data44['total_sales'] = $sales_quantity;

                $sales_due_amount = Invoice::where('location', $location->id)->where('added_by', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->sum('due_amount');

                $data44['total_sales_due_amount'] = $sales_due_amount;

                // foreach($invoices as $row2){

                //     $data23 = $row2;
    
                //     $data23['client_id'] =  intval($row2->client_id);
    
                //     $client_id = Client::find($row2->client_id);
                //     if(!empty($client_id)){
    
                //     $data23['client'] =  Client::find($row2->client_id)->name;
    
                //     $data23['client_tin'] =  Client::find($row2->client_id)->TIN;
    
                //     $data23['client_email'] =  Client::find($row2->client_id)->email;
    
                //     $data23['client_phone'] =  Client::find($row2->client_id)->phone;
    
                //     $data23['client_address'] =  Client::find($row2->client_id)->address;
                //     }
                //     else{
    
                //         $data23['client'] =  null;
    
                //         $data23['client_tin'] =  null;
        
                //         $data23['client_email'] =  null;
        
                //         $data23['client_phone'] =  null;
        
                //         $data23['client_address'] =  null;
                //     }
                //     $region = Region::find($row2->region);
    
                    
                //     if(!empty($region)){
    
                //         $data23['region']  = Region::find($row2->region)->name;
    
                //     }
                //     else{
                //         $data23['region']  = null;
    
                //     }
    
    
                //     if(!empty($row2->attach_reference)){
    
                //     $data23['attach_reference'] = url('season_images/'.$row2->attach_reference);
    
                //     }
    
    
                //     else{
                //     $data23['attach_reference'] = null;
    
                //     }
    
                //     // $data23['supplier'] = $row2->supplier->name;
    
                   
    
                //     // $loc= Location::where('id', $row2->location)->value('name');
    
                   
    
    
                //     if($row2->status == 0){
                //         $data23['status'] = 'Not Approved';
                //     }
                //     elseif($row2->status == 1){
                //         $data23['status'] = 'Not Paid';
                //     }
                //     elseif($row2->status == 2){
                //         $data23['status'] = 'Partially Paid';
                //     }
                //     elseif($row2->status == 3){
                //         $data23['status'] = 'Fully Paid';
                //     }
                //     elseif($row2->status == 4){
                //         $data23['status'] = 'Cancelled';
                //     }
                //     elseif($row2->status == 5){
                //         $data23['status'] = 'Received';
                //     }
    
                //     elseif($row2->status == 6){
                //         $data23['status'] = 'Scanned and Paid';
                //     }
    
                //     $farmers23[] = $data23;
         
                // }

            }

            else{

                $data44['total_sales'] = 0;


                $data44['total_sales_due_amount'] = "0.00";
            }



            // $data44['purchases'] = $farmers1;

            // $data44['sales'] = $farmers23;

            $farmers[] = $data44;




            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','purchase_sales'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Purchase found'];
            return response()->json($response,200);

        }                           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request,[
            'purchase_date'=>'required',
            'due_date'=>'required',
            'exchange_code'=>'required',
            'exchange_rate'=>'required',
            'id'=>'required',
            
        ]); 


        // error_log('------------------------');

        // error_log($request->purchase_type);


        // error_log('------------------------');


        // error_log($request->sub_total);


        // error_log('------------------------');



        // error_log($request->location);


        // error_log('------------------------');


        // error_log($request->due_date);


        // error_log('------------------------');


        // error_log($request->purchase_date);


        // error_log('------------------------');


        // error_log($request->exchange_code);


        // error_log('------------------------');

        // error_log($request->exchange_rate);


        // error_log('------------------------');

        // error_log($request->shipping_cost);


        // error_log('------------------------');

        // error_log($request->due_amount);


        // error_log('------------------------');

        // error_log($request->total_tax);


        // error_log('------------------------');

        // error_log($request->id);


        // error_log('------------------------');
         
           

        

           
        $count=Purchase::where('added_by', $request->id)->count();
        $pro=$count+1;
        $data['reference_no']= "BPH0".$pro;
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        // $data['purchase_amount']='1';
        // $data['due_amount']='1';
        // $data['purchase_tax']='1';
        // $data['shipping_cost']='1';

        $subtotal = $request->sub_total;

        //purchase_amount
        $data['purchase_amount'] = $subtotal;
        //purchase_tax
        $data['purchase_tax'] = $request->total_tax;
        //shipping_cost
        $data['shipping_cost'] = $request->shipping_cost;
        //subtotal+total+shipcost
        $data['due_amount'] = $request->due_amount;


        // $data['status']='0';
        // $data['good_receive']='0';
        // ---ALREADY APPROVED
        $data['status'] = 1;
        $data['good_receive'] = 1;

        // ---------

         $data['purchase_type']=$request->purchase_type;
        $data['added_by']= $request->id;


        // try {
            //code...
             $purchase = Purchase::create($data);

            


             
        
        // if(!empty($purchase->supplier_id)){
        //     $supp=Supplier::find($purchase->supplier_id);
        // }
        // else{
        //     $supp = "GENERAL SUPPLIER FOR"
        // }

        // error_log('------------------------');


        // error_log('------------------------');


        // error_log($supp);


        // error_log('------------------------');

        if($purchase->purchase_type == 'Local'){
       $cr= AccountCodes::where('account_name','Purchases Local')->first();
         }

      elseif($purchase->purchase_type == 'International'){
       $cr= AccountCodes::where('account_name','Purchases International')->first();
         }
        
        $supp=Supplier::find($purchase->supplier_id);
        if(!empty($supp)){
            
                   $journal = new JournalEntry();
     $journal->account_id = $cr->id;
     $date = explode('-',$purchase->purchase_date);
     $journal->date =   $purchase->purchase_date ;
     $journal->year = $date[0];
     $journal->month = $date[1];
   $journal->transaction_type = 'pos_retail_purchase';
     $journal->name = 'Purchases';
     $journal->debit = $purchase->purchase_amount *  $purchase->exchange_rate;
     $journal->income_id= $purchase->id;
      $journal->currency_code =  $purchase->exchange_code;
     $journal->exchange_rate= $purchase->exchange_rate;
    $journal->added_by=$purchase->added_by;
        $journal->notes= "Purchase for Purchase Order " .$purchase->reference_no ." by Supplier ". $supp->name ;
     $journal->save();
   
   if($purchase->purchase_tax > 0){
    $tax= AccountCodes::where('account_name','VAT IN')->first();
       $journal = new JournalEntry();
     $journal->account_id = $tax->id;
     $date = explode('-',$purchase->purchase_date);
     $journal->date =   $purchase->purchase_date ;
     $journal->year = $date[0];
     $journal->month = $date[1];
       $journal->transaction_type = 'pos_retail_purchase';
     $journal->name = 'Purchases';
     $journal->debit = $purchase->purchase_tax *  $purchase->exchange_rate;
     $journal->income_id= $purchase->id;
      $journal->currency_code =  $purchase->exchange_code;
     $journal->exchange_rate= $purchase->exchange_rate;
     $journal->added_by=$purchase->added_by;
        $journal->notes= "Purchase Tax for Purchase Order " .$purchase->reference_no ." by Supplier ".  $supp->name ;
     $journal->save();
   }
if($purchase->shipping_cost > 0){
    $ship= AccountCodes::where('account_name','Shipping Cost')->first();
       $journal = new JournalEntry();
     $journal->account_id = $ship->id;
     $date = explode('-',$purchase->purchase_date);
     $journal->date =   $purchase->purchase_date ;
     $journal->year = $date[0];
     $journal->month = $date[1];
       $journal->transaction_type = 'pos_retail_purchase';
     $journal->name = 'Purchases';
     $journal->debit = $purchase->shipping_cost *  $purchase->exchange_rate;
     $journal->income_id= $purchase->id;
      $journal->currency_code =  $purchase->exchange_code;
     $journal->exchange_rate= $purchase->exchange_rate;
     $journal->added_by=$purchase->added_by;
        $journal->notes= "Shipping Cost for Purchase Order " .$purchase->reference_no ." by Supplier ".  $supp->name ;
     $journal->save();
   }
   
     $codes= AccountCodes::where('account_name','Payables')->first();
     $journal = new JournalEntry();
     $journal->account_id = $codes->id;
     $date = explode('-',$purchase->purchase_date);
     $journal->date =   $purchase->purchase_date ;
     $journal->year = $date[0];
     $journal->month = $date[1];
    $journal->transaction_type = 'pos_retail_purchase';
     $journal->name = 'Purchases';
     $journal->income_id= $purchase->id;
     $journal->credit =$purchase->due_amount *  $purchase->exchange_rate;
     $journal->currency_code =  $purchase->exchange_code;
     $journal->exchange_rate= $purchase->exchange_rate;
    $journal->added_by=$purchase->added_by;
        $journal->notes= "Credit for Purchase Order  " .$purchase->reference_no ." by Supplier ".  $supp->name ;
     $journal->save();


        }
        else{
            
            
        $journal = new JournalEntry();
     $journal->account_id = $cr->id;
     $date = explode('-',$purchase->purchase_date);
     $journal->date =   $purchase->purchase_date ;
     $journal->year = $date[0];
     $journal->month = $date[1];
   $journal->transaction_type = 'pos_retail_purchase';
     $journal->name = 'Purchases';
     $journal->debit = $purchase->purchase_amount *  $purchase->exchange_rate;
     $journal->income_id= $purchase->id;
      $journal->currency_code =  $purchase->exchange_code;
     $journal->exchange_rate= $purchase->exchange_rate;
    $journal->added_by=$purchase->added_by;
        $journal->notes= "Purchase for Purchase Order " .$purchase->reference_no ." by Supplier ". "NO SUPPLIER CHOSEN" ;
     $journal->save();
   
   if($purchase->purchase_tax > 0){
    $tax= AccountCodes::where('account_name','VAT IN')->first();
       $journal = new JournalEntry();
     $journal->account_id = $tax->id;
     $date = explode('-',$purchase->purchase_date);
     $journal->date =   $purchase->purchase_date ;
     $journal->year = $date[0];
     $journal->month = $date[1];
       $journal->transaction_type = 'pos_retail_purchase';
     $journal->name = 'Purchases';
     $journal->debit = $purchase->purchase_tax *  $purchase->exchange_rate;
     $journal->income_id= $purchase->id;
      $journal->currency_code =  $purchase->exchange_code;
     $journal->exchange_rate= $purchase->exchange_rate;
     $journal->added_by=$purchase->added_by;
        $journal->notes= "Purchase Tax for Purchase Order " .$purchase->reference_no ." by Supplier ".  "NO SUPPLIER CHOSEN" ;
     $journal->save();
   }
if($purchase->shipping_cost > 0){
    $ship= AccountCodes::where('account_name','Shipping Cost')->first();
       $journal = new JournalEntry();
     $journal->account_id = $ship->id;
     $date = explode('-',$purchase->purchase_date);
     $journal->date =   $purchase->purchase_date ;
     $journal->year = $date[0];
     $journal->month = $date[1];
       $journal->transaction_type = 'pos_retail_purchase';
     $journal->name = 'Purchases';
     $journal->debit = $purchase->shipping_cost *  $purchase->exchange_rate;
     $journal->income_id= $purchase->id;
      $journal->currency_code =  $purchase->exchange_code;
     $journal->exchange_rate= $purchase->exchange_rate;
     $journal->added_by=$purchase->added_by;
        $journal->notes= "Shipping Cost for Purchase Order " .$purchase->reference_no ." by Supplier ".  "NO SUPPLIER CHOSEN" ;
     $journal->save();
   }
   
     $codes= AccountCodes::where('account_name','Payables')->first();
     $journal = new JournalEntry();
     $journal->account_id = $codes->id;
     $date = explode('-',$purchase->purchase_date);
     $journal->date =   $purchase->purchase_date ;
     $journal->year = $date[0];
     $journal->month = $date[1];
    $journal->transaction_type = 'pos_retail_purchase';
     $journal->name = 'Purchases';
     $journal->income_id= $purchase->id;
     $journal->credit =$purchase->due_amount *  $purchase->exchange_rate;
     $journal->currency_code =  $purchase->exchange_code;
     $journal->exchange_rate= $purchase->exchange_rate;
    $journal->added_by=$purchase->added_by;
        $journal->notes= "Credit for Purchase Order  " .$purchase->reference_no ." by Supplier ".  "NO SUPPLIER CHOSEN" ;
     $journal->save();


        }





        //    } 
        //    catch (\Exception $e) {
        //     //throw $th;

        //     $message = $e->getMessage();
        //     error_log('Exception Message: '. $message);


        //     $code = $e->getCode();       
        //     error_log('Exception Code: '. $code);
  
        //     $string = $e->__toString();       
        //     error_log('Exception String: '. $string);

        //     exit;
        //    }

        // ----------------------------GOOD RECEIVE-----------




        // -------------------------------------

        
        if(!empty($purchase)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>$purchase->added_by,
                            'module_id'=>$purchase->id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchase->reference_no. "  is Created",
                        ]
                        );                      
       }

    //    $itemsSS = PurchaseItems::where('purchase_id', $purchase->id)->get();

                $purchase['location_id'] = intval($purchase->location);

                $loc2= Location::where('id', $purchase->location)->value('name');


                $purchase['location'] = $loc2;
                
                if(!empty($purchase->supplier_id)){
                    $purchase['supplier_id'] = intval($purchase->supplier_id);


                    $purchase['supplier'] = $purchase->supplier->name;
                }
                else{
                    $purchase['supplier_id'] = null;


                    $purchase['supplier'] = null;
                }

                

                if($purchase->status == 0){
                    $purchase['status'] = 'Not Approved';
                }
                elseif($purchase->status == 1){
                    $purchase['status'] = 'Not Paid';
                }
                elseif($purchase->status == 2){
                    $purchase['status'] = 'Partially Paid';
                }
                elseif($purchase->status == 3){
                    $purchase['status'] = 'Fully Paid';
                }
                elseif($purchase->status == 4){
                    $purchase['status'] = 'Cancelled';
                }
                elseif($purchase->status == 5){
                    $purchase['status'] = 'Received';
                }

                elseif($purchase->status == 6){
                    $purchase['status'] = 'Scanned and Paid';
                }

       if($purchase)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Purchase Created successful', 'purchase' => $purchase];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Purchase Successfully'];
            return response()->json($response,200);
        }

        
       

        // return redirect(route('pharmacy_purchase.show',$purchase->id));
        
    }

    public function item_purchase_index(int $id){

        $purchase=PurchaseItems::where('purchase_id', $id)->get();
        
        if($purchase->isNotEmpty()){

            foreach($purchase as $row){

                $data = $row;




                $data['purchase_item_id']  = $row->id;

                $data['purchase_id'] = intval($row->purchase_id);

                $data['id'] = intval($row->items_id);

                $data['inventory_id'] = intval($row->items_id);



                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','purchase_item'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Purchase Item found'];
            return response()->json($response,200);
        } 
    }

    public function item_purchase_store(Request $request){

        $this->validate($request,[
            'item_id' => 'required',
            // 'item_name' => 'required',
            'item_name' => 'required',

            'tax_rate' => 'required',

            'price' => 'required',
            'total_cost' => 'required',
            'tax' =>'required',

            'purchase_id' => 'required',

        ]);
        // error_log("++++++++++++++++++++++++++++   purchase_item  ========================");

        // error_log("++++++++++++++++++++++++++++ item_id     ========================");

        // error_log($request->item_id);

        // error_log("++++++++++++++++++++++++++++   quantity   ========================");

        // error_log($request->quantity);

        // error_log("++++++++++++++++++++++++++++   purchase_id   ========================");


        // error_log($request->purchase_id);

        // error_log("++++++++++++++++++++++++++++  tax    ========================");


        // error_log($request->tax);

        // error_log("++++++++++++++++++++++++++++  total_cost    ========================");


        // error_log($request->total_cost);

        // error_log("++++++++++++++++++++++++++++  tax_rate    ========================");

        // error_log($request->tax_rate);

        // error_log("++++++++++++++++++++++++++++  price    ========================");

        // error_log($request->price);

        // error_log("++++++++++++++++++++++++++++  item_name    ========================");


        // error_log( $request->item_name);

            $itm = Items::where('id',$request->item_id)->first();

            if(!empty($itm)){

                    $purchase = Purchase::find($request->purchase_id);


                    if (!empty($purchase)) {
                        $iyt = PurchaseItems::where('purchase_id', $purchase->id)->orderBy('created_at', 'desc')->first();

                        if (!empty($iyt)) {
                            $iy = $iyt->order_no + 1;
                        } else {
                            $iy = 1;
                        }

                        $d=Items::where('id', $request->item_id)->first();

                        $items23 = array(
                            // 'item_name' => $request->item_name,

                            'category' => $d->category,
                                'item_name' => $request->item_name,
                                'quantity' =>   $request->quantity,
                                'due_quantity' => $request->quantity,
                                'tax_rate' =>  $request->tax_rate,
                                'unit' =>$d->unit,
                                'price' =>  $request->price,
                                'total_cost' =>  $request->total_cost,
                                'total_tax' =>   $request->tax,
                                'items_id' => $request->item_id,
                                'expire_date' => $request->expire_date,

                                'barcode' =>  $request->barcode,

                            'order_no' => $iy,
                            'added_by' => $purchase->added_by,

                            'reference_no' => $purchase->reference_no,

                            'purchase_amount' => $purchase->purchase_amount,
                            'purchase_tax' => $purchase->purchase_tax,
                                'shipping_cost' => $purchase->shipping_cost,
                            //subtotal+total+shipcost
                            'due_amount' => $purchase->due_amount,
                            'purchase_id' =>$purchase->id);

                        $pt =  PurchaseItems::create($items23);;

                        // --------------------


                        $inv=Items::where('id',$request->item_id)->first();
                     $q=$inv->quantity + $request->quantity;
                     
                     if(!empty($request->barcode)){
                          $itm_new =     Items::where('id',$request->item_id)->update(['quantity' => $q, 'barcode' => $request->barcode]);
                     }
                     else{
                            $itm_new =  Items::where('id',$request->item_id)->update(['quantity' => $q]);
                     }
                
        
        
                  $loc=Location::where('id',$purchase->location)->first();
                     $lq['quantity']=$loc->quantity + $request->quantity;
                 $loc_qun =   Location::where('id',$purchase->location)->update($lq);


                        // --------------------------------

                        $activity =Activity::create(
                            [
                                'added_by'=>$purchase->added_by,
                                'module_id'=>$purchase->id,
                                'module'=>'Purchase',
                                'activity'=>"Purchase with reference no " .  $purchase->reference_no." with a item_id is". $pt->id."  is Created",
                            ]
                        );

                        if ($pt) {

                                $pt['expire_date'] = $pt->expire_date;

                                $pt['quantity'] = $q;

                                $pt['rem_location_quantity'] = $lq['quantity'];


                            // $pt['purchase_id'] = intval($pt->purchase_id);


                            // $pt['id'] = intval($pt->items_id);


                            $response=['success'=>true,'error'=>false, 'message' => 'Purchase Created successful', 'purchase_item' => $pt];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Purchase Successfully'];
                            return response()->json($response,200);
                        }
                    }
                        else
                        {
                            
                            $response=['success'=>false,'error'=>true,'message'=>'Purchase Not found'];
                            return response()->json($response,200);
                        }
            }
            else{

                $response=['success'=>false,'error'=>true,'message'=>'Items not found'];
                return response()->json($response,200);
            }

       
    }

    public function item_purchase_delete(int $id){

        $purchase_item = PurchaseItems::find($id);

        $purchase_id = $purchase_item->purchase_id; 

        $purchase = Purchase::find($purchase_id);






        $data['purchase_amount'] = $purchase->purchase_amount -  $purchase_item->total_cost;

        $data['purchase_tax'] = $purchase->purchase_tax - $purchase_item->total_tax;

        $data['due_amount'] = $purchase->due_amount - $purchase_item->total_tax - $purchase_item->total_cost;


       


                if(!empty($purchase_item)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>$purchase->added_by,
                            'module_id'=>$purchase_item->id,
                            'module'=>'Purchase',
                            'activity'=>"Purchase Item with reference no " .  $purchase->reference_no." and with purchase item id". $purchase_item->id ."  is Deleted",
                        ]
                        );                      
                    }


                    $purchase->update($data);

                    $purchase_items12 = PurchaseItems::where('purchase_id', $purchase_id)->update($data);


                    $inv=Items::where('id',$purchase_item->items_id)->first();
                    $q=$inv->quantity - $purchase_item->quantity;
                    Items::where('id',$purchase_item->items_id)->update(['quantity' => $q]);
       
       
                 $loc=Location::where('id',$purchase->location)->first();
                    $lq['quantity']=$loc->quantity - $purchase_item->quantity;
                   Location::where('id',$purchase->location)->update($lq);

            
            
                  $purchase_items99 =  $purchase_item->delete();


        if($purchase_items99)
        {
            

            $response=['success'=>true,'error'=>false,'message'=>'Deleted Successfully'];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Deleted Successfully'];
            return response()->json($response,200);
        }

    }

    public function item_purchase_update(Request $request){

        $this->validate($request,[
            'item_id' => 'required',
            // 'item_name' => 'required',
            'item_name' => 'required',

            'tax_rate' => 'required',

            'price' => 'required',
            'total_cost' => 'required',
            'tax' =>'required',

            'purchase_id' => 'required',


        ]);
        // error_log("++++++++++++++++++++++++++++   purchase_item  ========================");

        // error_log("++++++++++++++++++++++++++++ item_id     ========================");

        // error_log($request->item_id);

        // error_log("++++++++++++++++++++++++++++   quantity   ========================");

        // error_log($request->quantity);

        // error_log("++++++++++++++++++++++++++++   purchase_id   ========================");


        // error_log($request->purchase_id);

        // error_log("++++++++++++++++++++++++++++  tax    ========================");


        // error_log($request->tax);

        // error_log("++++++++++++++++++++++++++++  total_cost    ========================");


        // error_log($request->total_cost);

        // error_log("++++++++++++++++++++++++++++  tax_rate    ========================");

        // error_log($request->tax_rate);

        // error_log("++++++++++++++++++++++++++++  price    ========================");

        // error_log($request->price);

        // error_log("++++++++++++++++++++++++++++  item_name    ========================");


        // error_log( $request->item_name);

            $itm = Items::where('id',$request->item_id)->first();

            if(!empty($itm)){

                    $purchase = Purchase::find($request->purchase_id);
                    

                    if (!empty($purchase)) {




                        if(!empty($request->purchase_item_id)){

                        $purchase_item = PurchaseItems::find($request->purchase_item_id);


                        $d=Items::where('id', $request->item_id)->first();

                        $items23 = array(
                            // 'item_name' => $request->item_name,

                            'category' => $d->category,
                                'item_name' => $request->item_name,
                                'quantity' =>   $request->quantity,
                                'due_quantity' => $request->quantity,
                                'tax_rate' =>  $request->tax_rate,
                                'unit' =>$d->unit,
                                'price' =>  $request->price,
                                'total_cost' =>  $request->total_cost,
                                'total_tax' =>   $request->tax,
                                'items_id' => $request->item_id,
                                'expire_date' => $request->expire_date,

                                'barcode' => $request->barcode,


                            
                            'added_by' => $purchase->added_by,

                            'reference_no' => $purchase->reference_no,

                            'purchase_amount' => $purchase->purchase_amount,
                            'purchase_tax' => $purchase->purchase_tax,
                                'shipping_cost' => $purchase->shipping_cost,
                            //subtotal+total+shipcost
                            'due_amount' => $purchase->due_amount,
                            'purchase_id' =>$purchase->id);

                        $purchase_item_updated =  PurchaseItems::where('id',$purchase_item->id)->update($items23);

                        // $purchase_item_updated = $pt122->update($items23);

                        // $pt =  PurchaseItems::create($items23);;

                        $inv=Items::where('id',$request->item_id)->first();
                        $q=$inv->quantity + $request->quantity;
                        
                        if(!empty($request->barcode)){
                          $itm_new =     Items::where('id',$request->item_id)->update(['quantity' => $q, 'barcode' => $request->barcode]);
                         }
                         else{
                                $itm_new =  Items::where('id',$request->item_id)->update(['quantity' => $q]);
                         }
           
           
                     $loc=Location::where('id',$purchase->location)->first();
                        $lq['quantity']=$loc->quantity + $request->quantity;
                       Location::where('id',$purchase->location)->update($lq);

                        $activity =Activity::create(
                            [
                                'added_by'=>$purchase->added_by,
                                'module_id'=>$purchase_item->id,
                                'module'=>'Purchase',
                                'activity'=>"Purchase Item with reference no " .  $purchase->reference_no." with Purchase item_id is". $purchase_item->id."  is Updated",
                            ]
                        );

                        if ($purchase_item_updated) {
                            $response=['success'=>true,'error'=>false, 'message' => 'Purchase Item Updated successful',];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Update Purchase Item Successfully'];
                            return response()->json($response,200);
                        }

                        // --------------------------------------------

                        }
                        else{

                            
                        // ----------------------------
                        $iyt = PurchaseItems::where('purchase_id', $purchase->id)->orderBy('created_at', 'desc')->first();

                        if (!empty($iyt)) {
                            $iy = $iyt->order_no + 1;
                        } else {
                            $iy = 1;
                        }

                        $d=Items::where('id', $request->item_id)->first();

                        $items23 = array(
                            // 'item_name' => $request->item_name,

                            'category' => $d->category,
                                'item_name' => $request->item_name,
                                'quantity' =>   $request->quantity,
                                'due_quantity' => $request->quantity,
                                'tax_rate' =>  $request->tax_rate,
                                'unit' =>$d->unit,
                                'price' =>  $request->price,
                                'total_cost' =>  $request->total_cost,
                                'total_tax' =>   $request->tax,
                                'items_id' => $request->item_id,
                                'expire_date' => $request->expire_date,

                                'barcode' => $request->barcode,


                            'order_no' => $iy,
                            'added_by' => $purchase->added_by,

                            'reference_no' => $purchase->reference_no,

                            'purchase_amount' => $purchase->purchase_amount,
                            'purchase_tax' => $purchase->purchase_tax,
                                'shipping_cost' => $purchase->shipping_cost,
                            //subtotal+total+shipcost
                            'due_amount' => $purchase->due_amount,
                            'purchase_id' =>$purchase->id);

                        $pt =  PurchaseItems::create($items23);;

                        $inv=Items::where('id',$request->item_id)->first();
                        $q=$inv->quantity + $request->quantity;
                        
                        if(!empty($request->barcode)){
                          $itm_new =     Items::where('id',$request->item_id)->update(['quantity' => $q, 'barcode' => $request->barcode]);
                         }
                         else{
                                $itm_new =  Items::where('id',$request->item_id)->update(['quantity' => $q]);
                         }
           
           
                     $loc=Location::where('id',$purchase->location)->first();
                        $lq['quantity']=$loc->quantity + $request->quantity;
                       Location::where('id',$purchase->location)->update($lq);

                        $activity =Activity::create(
                            [
                                'added_by'=>$purchase->added_by,
                                'module_id'=>$purchase->id,
                                'module'=>'Purchase',
                                'activity'=>"Purchase with reference no " .  $purchase->reference_no." with a item_id is". $pt->id."  is Created",
                            ]
                        );

                        if ($pt) {
                            $response=['success'=>true,'error'=>false, 'message' => 'Purchase Created successful'];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Purchase Successfully'];
                            return response()->json($response,200);
                        }

                        // --------------------------------------------
                        }


                    }
                        else
                        {
                            
                            $response=['success'=>false,'error'=>true,'message'=>'Purchase Not found'];
                            return response()->json($response,200);
                        }
            }
            else{

                $response=['success'=>false,'error'=>true,'message'=>'Items not found'];
                return response()->json($response,200);
            }
    }



    public function good_receive_new(int $id){

        $inv = Purchase::find($id);

        // $date = explode('-',$inv->purchase_date);
        // dd($date[2]);

        $data['status']= 5;
    
        $inv->update($data);


        $supp=Supplier::find($inv->supplier_id);

         if($inv->purchase_type == 'Local'){
        $cr= AccountCodes::where('account_name','Purchases Local')->first();
          }

       elseif($inv->purchase_type == 'International'){
        $cr= AccountCodes::where('account_name','Purchases International')->first();
          }

        $journal = new JournalEntry();
      $journal->account_id = $cr->id;
      $date = explode('-',$inv->purchase_date);
      $journal->date =   $inv->purchase_date ;
      $journal->year = $date[0];
      $journal->month = $date[1];
    $journal->transaction_type = 'pos_retail_purchase';
      $journal->name = 'Purchases';
      $journal->debit = $inv->purchase_amount *  $inv->exchange_rate;
      $journal->income_id= $inv->id;
       $journal->currency_code =  $inv->exchange_code;
      $journal->exchange_rate= $inv->exchange_rate;
     $journal->added_by=$inv->added_by;
         $journal->notes= "Purchase for Purchase Order " .$inv->reference_no ." by Supplier ". $supp->name ;
      $journal->save();
    
    if($inv->purchase_tax > 0){
     $tax= AccountCodes::where('account_name','VAT IN')->first();
        $journal = new JournalEntry();
      $journal->account_id = $tax->id;
      $date = explode('-',$inv->purchase_date);
      $journal->date =   $inv->purchase_date ;
      $journal->year = $date[0];
      $journal->month = $date[1];
        $journal->transaction_type = 'pos_retail_purchase';
      $journal->name = 'Purchases';
      $journal->debit = $inv->purchase_tax *  $inv->exchange_rate;
      $journal->income_id= $inv->id;
       $journal->currency_code =  $inv->exchange_code;
      $journal->exchange_rate= $inv->exchange_rate;
      $journal->added_by=$inv->added_by;
         $journal->notes= "Purchase Tax for Purchase Order " .$inv->reference_no ." by Supplier ".  $supp->name ;
      $journal->save();
    }
if($inv->shipping_cost > 0){
     $ship= AccountCodes::where('account_name','Shipping Cost')->first();
        $journal = new JournalEntry();
      $journal->account_id = $ship->id;
      $date = explode('-',$inv->purchase_date);
      $journal->date =   $inv->purchase_date ;
      $journal->year = $date[0];
      $journal->month = $date[1];
        $journal->transaction_type = 'pos_retail_purchase';
      $journal->name = 'Purchases';
      $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
      $journal->income_id= $inv->id;
       $journal->currency_code =  $inv->exchange_code;
      $journal->exchange_rate= $inv->exchange_rate;
      $journal->added_by=$inv->added_by;
         $journal->notes= "Shipping Cost for Purchase Order " .$inv->reference_no ." by Supplier ".  $supp->name ;
      $journal->save();
    }
    
      $codes= AccountCodes::where('account_name','Payables')->first();
      $journal = new JournalEntry();
      $journal->account_id = $codes->id;
      $date = explode('-',$inv->purchase_date);
      $journal->date =   $inv->purchase_date ;
      $journal->year = $date[0];
      $journal->month = $date[1];
     $journal->transaction_type = 'pos_retail_purchase';
      $journal->name = 'Purchases';
      $journal->income_id= $inv->id;
      $journal->credit =$inv->due_amount *  $inv->exchange_rate;
      $journal->currency_code =  $inv->exchange_code;
      $journal->exchange_rate= $inv->exchange_rate;
     $journal->added_by=$inv->added_by;
         $journal->notes= "Credit for Purchase Order  " .$inv->reference_no ." by Supplier ".  $supp->name ;
      $journal->save();


if(!empty($inv)){
                $activity =Activity::create(
                    [ 
                        'added_by'=>$inv->added_by,
                        'module_id'=>$inv->id,
                         'module'=>'Purchase',
                        'activity'=>"Purchase with reference no " .  $inv->reference_no. "  is Received",
                    ]
                    );                      
   }

                        $inv['location_id'] = intval($inv->location);

                        $loc2= Location::where('id', $inv->location)->value('name');


                        $inv['location'] = $loc2;

                        $inv['supplier_id'] = intval($inv->supplier_id);


                        $inv['supplier'] = $inv->supplier->name;

                        if($inv->status == 0){
                            $inv['status'] = 'Not Approved';
                        }
                        elseif($inv->status == 1){
                            $inv['status'] = 'Not Paid';
                        }
                        elseif($inv->status == 2){
                            $inv['status'] = 'Partially Paid';
                        }
                        elseif($inv->status == 3){
                            $inv['status'] = 'Fully Paid';
                        }
                        elseif($inv->status == 4){
                            $inv['status'] = 'Cancelled';
                        }
                        elseif($inv->status == 5){
                            $inv['status'] = 'Received';
                        }

                        elseif($inv->status == 6){
                            $data['status'] = 'Scanned and Paid';
                        }


            if($inv)
            {
                
            
                $response=['success'=>true,'error'=>false,'message'=>'Good Receive Updated registered', 'purchase' => $inv];
                return response()->json($response,200);
            }
            else
            {
                
                $response=['success'=>false,'error'=>true,'message'=>'Failed to Good Receive'];
                return response()->json($response,200);
            }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idP)
    {
    //idP == purchase id

    // error_log($idP);
    $this->validate($request, [
        'supplier_id'=>'required',
        'purchase_date'=>'required',
        'due_date'=>'required',
        'exchange_code'=>'required',
        'exchange_rate'=>'required',
        'id'=>'required',


    ]);



    $purchase = Purchase::find($idP);
    $data['supplier_id']=$request->supplier_id;
    $data['purchase_date']=$request->purchase_date;
    $data['due_date']=$request->due_date;
    $data['location']=$request->location;
    $data['exchange_code']=$request->exchange_code;
    $data['exchange_rate']=$request->exchange_rate;

    $subtotal = $request->sub_total;

     //purchase_amount
     $data['purchase_amount'] = $subtotal;

    //  $data['paid_amount'] = $;

     //purchase_tax
     $data['purchase_tax'] = $request->total_tax;
     //shipping_cost
     $data['shipping_cost'] = $request->shipping_cost;
     //subtotal+total+shipcost
     $data['due_amount'] = $request->due_amount;



    $data['status']='1';
    $data['purchase_type']=$request->purchase_type;
    $data['added_by']= $request->id;

    $purchase->update($data);

        if (!empty($purchase)) {
            $activity =Activity::create(
                [
                    'added_by'=>$purchase->added_by,
                    'module_id'=>$purchase->id,
                     'module'=>'Purchase',
                    'activity'=>"Purchase with reference no " .  $purchase->reference_no. "  is Updated",
                ]
            );
        }

        $purchase['location_id'] = intval($purchase->location);

        $loc2= Location::where('id', $purchase->location)->value('name');


        $purchase['location'] = $loc2;

        $purchase['supplier_id'] = intval($purchase->supplier_id);

        $purchase['supplier'] = $purchase->supplier->name;

        if ($purchase->status == 0) {
            $purchase['status'] = 'Not Approved';
        } elseif ($purchase->status == 1) {
            $purchase['status'] = 'Not Paid';
        } elseif ($purchase->status == 2) {
            $purchase['status'] = 'Partially Paid';
        } elseif ($purchase->status == 3) {
            $purchase['status'] = 'Fully Paid';
        } elseif ($purchase->status == 4) {
            $purchase['status'] = 'Cancelled';
        } elseif ($purchase->status == 5) {
            $purchase['status'] = 'Received';
        }elseif ($purchase->status == 6) {
            $purchase['status'] = 'Scanned and Paid';
        }

        


        if ($purchase) {
            $response=['success'=>true,'error'=>false,'message'=>'Purchase Updated registered', 'purchase' => $purchase];
            return response()->json($response, 200);
        } else {
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Update Purchase'];
            return response()->json($response, 200);
        }
    
}

    public function payment_method(){
        $payment_method = Payment_methodes::all();

        if($payment_method->isNotEmpty()){

            
            foreach($payment_method as $row){

                $data['id'] = $row->id;


                $data['name'] = $row->name;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','payment_method'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Payment Method found'];
            return response()->json($response,200);
        }
    }


    public function account_code(int $id){

        $bank_accounts = AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by', $id)->orderBy('id', 'desc')->get();

        if($bank_accounts->isNotEmpty()){

            
            foreach($bank_accounts as $row){

                $data['id'] = $row->id;


                $data['account_name'] = $row->account_name;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','bank_accounts'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Bank Accounts found'];
            return response()->json($response,200);
        }
    }

    public function account_codeOff(int $id, int $lastId){

        $bank_accounts = AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by', $id)->where('id', '>', $lastId)->orderBy('id', 'desc')->get();

        if($bank_accounts->isNotEmpty()){

            
            foreach($bank_accounts as $row){

                $data['id'] = $row->id;


                $data['account_name'] = $row->account_name;

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','bank_accounts'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Bank Accounts found'];
            return response()->json($response,200);
        }
    }

    public function pay_purchase(Request $request){

        $this->validate($request,[
            'amount'=>'required',
            'payment_date'=>'required',
            'payment_method'=>'required',
            'account_id'=>'required',
            'id'=>'required',

            
        ]);

        // $receipt = $request->all();

        
        $sales = Purchase::find($request->id);

        // dd($sales);

       

         $count = PurchasePayments::where('added_by', $sales->added_by)->count();
        $pro=$count+1;
        $trans_id = "TBPH-".$pro;


        // if(($request->amount <= $sales->due_amount)){
        //     if( $request->amount > 0){
                // $receipt['added_by'] = auth()->user()->added_by;

                

         
                
                //update due amount from invoice table
                // $data['due_amount'] =  $sales->due_amount-$request->amount;

                $data['paid_amount'] = $sales->paid_amount + $request->amount;
                if($data['paid_amount'] < $sales->due_amount ){
                $data['status'] = 2;
                }else{
                    $data['status'] = 3;
                }
                $sales->update($data);


                //insert to purchase history if category or batch
               $items =  PurchaseItems::where('purchase_id', $sales->id)->get();
            //    dd($items->item_id);

               if(!empty($items)){
                foreach($items as $row){

                    // dd($row->items_id);

                    $d=Items::where('id',$row->items_id)->first();

            //         if($d->category == 'Serial'){     
            //             if(!empty($row->quantity)){
            //       for($x = 1; $x <= $row->quantity; $x++){    
            //           $dt=date('Y',strtotime($sales->purchase_date));
            //               $lists = array(
            //                   'serial_no' => $d->name."_" .$sales->id."_".$x,                      
            //                    'brand_id' => $row->items_id,
            //                      'added_by' => $sales->added_by,
            //                      'purchase_id' =>   $sales->id,
            //                    'purchase_date' =>  $sales->purchase_date,
            //                      'location' => $sales->location,
            //                      'status' => '0');
                             
                          
            //               PurchaseSerialList::create($lists);   
      
            //             //   $loc=Location::where('id',$sales->location)->first();
            //             //       $lq['quantity']=$loc->quantity + $row->quantity;
            //             //      Location::where('id',$sales->location)->update($lq);
            
            //           }

            //           $s_lists= array(
            //             'quantity' =>   $row->quantity,
            //              'due_quantity' =>   $row->quantity,
            //              'item_id' => $row->items_id,
            //                'added_by' => $sales->added_by,
            //                'supplier_id' => $sales->supplier_id,
            //               'location' =>    $sales->location,
            //              'purchase_date' =>  $sales->purchase_date,
            //             'type' =>   'Purchases',
            //             'purchase_id' =>$sales->id);
                       
            //          PurchaseSerialHistory::create($s_lists);   
      
            //         // $inv=Items::where('id',$row->items_id)->first();
            //         // $q=$inv->quantity + $row->quantity;
            //         // Items::where('id',$row->items_id)->update(['quantity' => $q]);
            //       }

                  
            //  }

            //  elseif($d->category == 'Batch'){
                       
                    $lists= array(
                         'quantity' =>   $row->quantity,
                          'due_quantity' =>   $row->quantity,
                         //'batch_number' =>  $batchArr[$i],
                         //'expire_date' =>  $expireArr[$i],
                          'item_id' => $row->items_id,
                            'added_by' => $sales->added_by,
                            'supplier_id' => $sales->supplier_id,
                           'location' =>    $sales->location,
                          'purchase_date' =>  $sales->purchase_date,
                         'type' =>   'Purchases',
                         'purchase_id' =>$sales->id);
                        
                      PurchaseHistory::create($lists);   
        
                //      $inv=Items::where('id',$row->items_id)->first();
                //      $q=$inv->quantity + $row->quantity;
                //      Items::where('id',$row->items_id)->update(['quantity' => $q]);
        
        
                //   $loc=Location::where('id',$sales->location)->first();
                //      $lq['quantity']=$loc->quantity + $row->quantity;
                //     Location::where('id',$sales->location)->update($lq);
                 }

                // }
               }
                

                $receipt = array(
                    'purchase_id' => $request->id,
                    'trans_id' => $trans_id,
                    'account_id' => $request->account_id,
                    'amount' => $request->amount,
                    'date' => $request->payment_date,
                    'payment_method' => $request->payment_method,
                    'notes' => $request->notes,
                    'added_by' => $sales->added_by);
                 
                $payment = PurchasePayments::create($receipt);

                $supp=Supplier::find($sales->supplier_id);

                $codes= AccountCodes::where('account_name','Payables')->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->payment_date);
                $journal->date =   $request->payment_date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
              $journal->transaction_type = 'pos_retail_purchases_payment';
               $journal->name = 'Purchases Payment';
                $journal->debit =$request->amount *  $sales->exchange_rate;
                  $journal->payment_id= $payment->id;
                 $journal->currency_code =   $sales->exchange_code;
                $journal->exchange_rate=  $sales->exchange_rate;
                  $journal->added_by=$sales->added_by;
                   $journal->notes= "Clear Creditor Purchase Order " .$sales->reference_no. " by Supplier ".  $supp->name ; ;
                $journal->save();
          
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->payment_date);
              $journal->date =   $request->payment_date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
              $journal->transaction_type = 'pos_retail_purchases_payment';
               $journal->name = 'Purchases Payment';
              $journal->credit = $request->amount *  $sales->exchange_rate;
              $journal->payment_id= $payment->id;
               $journal->currency_code =   $sales->exchange_code;
              $journal->exchange_rate=  $sales->exchange_rate;
               $journal->added_by=$sales->added_by;
                 $journal->notes= "Payment for Clear Credit Purchase Order " .$sales->reference_no. " by Supplier ".  $supp->name ; ;
              $journal->save();
    
 $account= Accounts::where('account_id',$request->account_id)->first();

if(!empty($account)){
$balance=$account->balance - $payment->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$payment->amount;
       $new[' exchange_code']=$sales->exchange_code;
        $new['added_by']=$sales->added_by;
$balance=0-$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction auth
                            $transaction= Transaction::create([
                               'module' => 'POS Retail Purchases Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'POS Purchases Payment with reference no ' .$sales->reference_no,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->payment_date)),
                                'payment_methods_id' =>$payment->payment_method,
                               'paid_by' => $sales->supplier_id,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from pos purchases Payment. The Reference is ' .$sales->reference_no . ' by Supplier '.  $supp->name  ,
                                'added_by' =>$sales->added_by,
                            ]);

           if(!empty($payment)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>$sales->added_by,
                            'module_id'=>$payment->id,
                             'module'=>'Purchase Payment',
                            'activity'=>"Purchase with reference no  " .  $sales->reference_no. "  is Paid",
                        ]
                        );                      
       }


        //         return redirect(route('pharmacy_purchase.index'))->with(['success'=>'Payment Added successfully']);
        //     }
        //     else{
        //         return redirect(route('pharmacy_purchase.index'))->with(['error'=>'Amount should not be equal or less to zero']);
        //     }
       

        // }else{
        //     return redirect(route('pharmacy_purchase.index'))->with(['error'=>'Amount should  be less than Purchase amount ']);

        // }

                        $sales['location_id'] = intval($sales->location);

                        $loc2= Location::where('id', $sales->location)->value('name');


                        $sales['location'] = $loc2;

                        $sales['supplier'] = $sales->supplier->name;

                        if($sales->status == 0){
                            $sales['status'] = 'Not Approved';
                        }
                        elseif($sales->status == 1){
                            $sales['status'] = 'Not Paid';
                        }
                        elseif($sales->status == 2){
                            $sales['status'] = 'Partially Paid';
                        }
                        elseif($sales->status == 3){
                            $sales['status'] = 'Fully Paid';
                        }
                        elseif($sales->status == 4){
                            $sales['status'] = 'Cancelled';
                        }
                        elseif($sales->status == 5){
                            $sales['status'] = 'Received';
                        }

                        elseif ($sales->status == 6) {
                            $purchase['status'] = 'Scanned and Paid';
                        }



        if($sales)
        {
            
        
            $response=['success'=>true,'error'=>false,'message'=>'Payemnt Successfully', 'purchase' => $sales];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Pay Purchases'];
            return response()->json($response,200);
        }
    }

    public function scan_serial_batch (Request $request){

        $this->validate($request,[
            'purchase_id'=>'required',
            'category'=>'required',
            'item_id'=>'required',

            
        ]);


        // $barcode2=(json_decode($request->barcode));

        // $barcode2=(json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $request->barcode), true));

        $barcode2=(json_decode(utf8_encode($request->barcode), true));



        // dd($barcode2);


        if(!empty($barcode2)){


            for($i = 0; $i < count($barcode2); $i++){



                        // if($request->category == 'Serial'){


                        //     $serial_purchase = PurchaseSerialList::where('purchase_id', $request->purchase_id)->where('brand_id', $request->item_id)->first();
                            
                        //     // $serial_purchase_item = $serial_purchase;
                        //     if(!empty($serial_purchase)){
                        //         $data['serial_no']=$barcode2[$i];

                        //     $data['status']=1;

                        //     $serial_purchase->update($data);


                        //     $purchaseN = Purchase::find($request->purchase_id);

                        //     $added_by = $purchaseN->added_by;

                        //     $purchase_date = $purchaseN->purchase_date;

                        //     $sr1 = new PurchaseHistoryAll();

                        //     $sr1['item_id'] = intval($request->item_id);

                        //     $sr1['type'] = 'Purchase';

                        //     $sr1['category'] = $request->category;

                        //     $sr1['purchase_id'] = intval($request->purchase_id);

                        //     $sr1['barcode'] = $barcode2[$i];

                        //     $sr1['expire_date'] = $request->expire_date;


                        //     $sr1['purchase_date'] = $purchase_date;

                        //     $sr1['added_by'] = $added_by;

                        //     $sr1->save();
                        //     }
                        //     else{

                        //     $purchaseN = Purchase::find($request->purchase_id);

                        //     $added_by = $purchaseN->added_by;

                        //     $purchase_date = $purchaseN->purchase_date;

                        //     $sr1 = new PurchaseHistoryAll();

                        //     $sr1['item_id'] = intval($request->item_id);

                        //     $sr1['type'] = 'Purchase';

                        //     $sr1['category'] = $request->category;

                        //     $sr1['purchase_id'] = intval($request->purchase_id);

                        //     $sr1['barcode'] = $barcode2[$i];

                        //     $sr1['expire_date'] = $request->expire_date;



                        //     $sr1['purchase_date'] = $purchase_date;

                        //     $sr1['added_by'] = $added_by;

                        //     $sr1->save();
                        //     }
                            


                        // }

                        // elseif($request->category == 'Batch'){

                            $inv =   PurchaseHistory::find($request->purchase_id);

                            if(!empty($inv)){


                                $data['purchase_id'] = $request->purchase_id;
                                $data['expire_date']=$request->expire_date;
                                $data['batch_number']=$barcode2[$i];
                                $data['serial_no']=$barcode2[$i];
                                $inv->update($data);
    
                                $purchaseN = Purchase::find($request->purchase_id);
    
                                $added_by = $purchaseN->added_by;
    
                                $purchase_date = $purchaseN->purchase_date;
    
                                $sr1 = new PurchaseHistoryAll();
    
                                $sr1['item_id'] = intval($request->item_id);
    
                                $sr1['type'] = 'Purchase';
    
                                $sr1['category'] = $request->category;
    
                                $sr1['purchase_id'] = intval($request->purchase_id);
    
                                $sr1['barcode'] = $barcode2[$i];

                                $sr1['expire_date'] = $request->expire_date;

    
    
                                $sr1['purchase_date'] = $purchase_date;
    
                                $sr1['added_by'] = $added_by;
    
                                $sr1->save();
    
                            }

                            else{
    
                                $purchaseN = Purchase::find($request->purchase_id);
    
                                $added_by = $purchaseN->added_by;
    
                                $purchase_date = $purchaseN->purchase_date;
    
                                $sr1 = new PurchaseHistoryAll();
    
                                $sr1['item_id'] = intval($request->item_id);
    
                                $sr1['type'] = 'Purchase';
    
                                $sr1['category'] = $request->category;
    
                                $sr1['purchase_id'] = intval($request->purchase_id);
    
                                $sr1['barcode'] = $barcode2[$i];

                                $sr1['expire_date'] = $request->expire_date;

    
    
                                $sr1['purchase_date'] = $purchase_date;
    
                                $sr1['added_by'] = $added_by;
    
                                $sr1->save();
    
                            }
                           

                            // $purchase = Purchase::find($row->purchase_id);

                            // $data34['status'] = 6;

                            // $purchase->update($data34);

                        // }

                        
                        $data34 [] = $sr1;

                        
                        

                    }

                    // $purchase = Purchase::find($request->purchase_id);

                    // $sr1 =  PurchaseHistoryAll::w();


                    

                    // $data34['barcode'] = $request->barcode;



                
                    $response=['success'=>true,'error'=>false,'message'=>'Assigned Successfully', 'data' => $data34];
                    return response()->json($response,200);
        }

       else
       {
           
           $response=['success'=>false,'error'=>true,'message'=>'Failed to Assigned Successfully'];
           return response()->json($response,200);
       }

       //  return redirect(route('pharmacy.purchase_list'))->with(['success'=>' Assigned Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        
       // InventoryHistory::where('purchase_id', $id)->delete();
        $purchases = Purchase::find($id);

       if(!empty($purchases)){

        PurchaseItems::where('purchase_id', $id)->delete();
        PurchasePayments::where('purchase_id', $id)->delete();

        $purchases->delete();


                    $activity =Activity::create(
                        [ 
                            'added_by'=>$purchases->added_by,
                            'module_id'=>$purchases->id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchases->reference_no. "  is Deleted",
                        ]
                        );                      
    //    }

  

        // if($purchases)
        // {
            
        
            $response=['success'=>true,'error'=>false,'message'=>'Deleted Successfully', 'purchase' => $purchases];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Deleted Successfully'];
            return response()->json($response,200);
        }
    }





    public function findPrice(Request $request)
    {
               $price= Items::where('id',$request->id)->get();
                return response()->json($price);                      

    }
 public function addSupplier(Request $request){
       
    
        $client= Supplier::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        'TIN' => $request['TIN'],
        'VRN' => $request['VRN'],
            'user_id'=> auth()->user()->added_by,
        ]);
        
      

        if (!empty($client)) {           
            return response()->json($client);
         }

       
   }

   public function discountModal(Request $request)
    {
               
                 }

           public function save_reference (Request $request){
                     //
                     $inv=   InventoryList::find($request->id);
                     $data['reference']=$request->reference;
                     $data['assign_reference']='1';
                     $inv->update($data);

                     if($inv)
                     {
                         
                     
                         $response=['success'=>true,'error'=>false,'message'=>'Inventory Reference Assigned Successfully', 'purchase' => $inv];
                         return response()->json($response,200);
                     }
                     else
                     {
                         
                         $response=['success'=>false,'error'=>true,'message'=>'Failed to Assigned Inventory Reference  Successfully'];
                         return response()->json($response,200);
                     }


                 }


    public function approve($id)
    {
        //
        $purchase = Purchase::find($id);
        
          if(!empty($purchase)){

            $data['status'] = 1;
            $data['good_receive'] = 1;
            $purchase->update($data);

                    $activity =Activity::create(
                        [ 
                            'added_by'=>$purchase->added_by,
                            'module_id'=>$purchase->id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchase->reference_no. "  is Approved",
                        ]
                        );                      
            // }

            $purchase['location_id'] = intval($purchase->location);

                $loc2= Location::where('id', $purchase->location)->value('name');


                $purchase['location'] = $loc2;

                $purchase['supplier'] = $purchase->supplier->name;

                if($purchase->status == 0){
                    $purchase['status'] = 'Not Approved';
                }
                elseif($purchase->status == 1){
                    $purchase['status'] = 'Not Paid';
                }
                elseif($purchase->status == 2){
                    $purchase['status'] = 'Partially Paid';
                }
                elseif($purchase->status == 3){
                    $purchase['status'] = 'Fully Paid';
                }
                elseif($purchase->status == 4){
                    $purchase['status'] = 'Cancelled';
                }
                elseif($purchase->status == 5){
                    $purchase['status'] = 'Received';
                }
                elseif ($purchase->status == 6) {
                    $purchase['status'] = 'Scanned and Paid';
                }

            // if($purchase)
            // {
                
            
                $response=['success'=>true,'error'=>false,'message'=>'Approved succesfully', 'purchase' => $purchase];
                return response()->json($response,200);
            }
            else
            {
                
                $response=['success'=>false,'error'=>true,'message'=>'Failed to Approve cause id not found'];
                return response()->json($response,200);
            }
    }

    public function cancel($id)
    {
        //
        $purchase = Purchase::find($id);
       

                if(!empty($purchase)){

                    $data['status'] = 4;
                    $purchase->update($data);

                    $activity =Activity::create(
                        [ 
                            'added_by'=>$purchase->added_by,
                            'module_id'=>$purchase->id,
                             'module'=>'Purchase',
                            'activity'=>"Purchase with reference no " .  $purchase->reference_no. "  is Cancelled",
                        ]
                        );                      
                // }

                    // $data['status'] = "Cancelled";

                    $purchase['location_id'] = intval($purchase->location);

                    $loc2= Location::where('id', $purchase->location)->value('name');


                    $purchase['location'] = $loc2;

                    $purchase['supplier'] = $purchase->supplier->name;

                    if($purchase->status == 0){
                        $purchase['status'] = 'Not Approved';
                    }
                    elseif($purchase->status == 1){
                        $purchase['status'] = 'Not Paid';
                    }
                    elseif($purchase->status == 2){
                        $purchase['status'] = 'Partially Paid';
                    }
                    elseif($purchase->status == 3){
                        $purchase['status'] = 'Fully Paid';
                    }
                    elseif($purchase->status == 4){
                        $purchase['status'] = 'Cancelled';
                    }
                    elseif($purchase->status == 5){
                        $purchase['status'] = 'Received';
                    }

                    elseif ($purchase->status == 6) {
                        $purchase['status'] = 'Scanned and Paid';
                    }


                // if($purchase)
                // {
                    
                
                    $response=['success'=>true,'error'=>false,'message'=>'Purchase  Cancelled Successfully', 'purchase' => $purchase];
                    return response()->json($response,200);
                }
                else
                {
                    
                    $response=['success'=>false,'error'=>true,'message'=>'Failed to Cancel Purchase Successfully'];
                    return response()->json($response,200);
                }
    }

   

    public function receive($id)
    {
        //
        // $currency= Currency::all();
        // $supplier=Supplier::all();
        // $name = Items::all();
        // $location = Location::all();
        $data=Purchase::find($id);
        $items=PurchaseItems::where('purchase_id',$id)->get();
        $type="receive";
     $edit="";


     if($items->isNotEmpty()){

            foreach($items as $row){

                $data = $row;

                $farmers[] = $data;
    
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','purchase'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Purchase found'];
            return response()->json($response,200);
        } 



    //    return view('pharmacy.pos.purchases.index',compact('name','supplier','currency','location','data','id','items','type','edit'));
    }



   public function purchase_list()
    {
        //
        $list= PurchaseHistory::where('added_by',auth()->user()->added_by)->get();


        if($list->isNotEmpty()){

            foreach($list as $row){

                $data = $row;

                $farmers[] = $data;
    
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','purchasehistory'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Purchase found'];
            return response()->json($response,200);
        } 


    //    return view('pharmacy.pos.purchases.purchase_list',compact('list'));
    }

    public function make_payment($id)
    {
        //
        $invoice = Purchase::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;

        if($bank_accounts->isNotEmpty()){

            foreach($bank_accounts as $row){

                $data = $row;

                $farmers[] = $data;
    
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','paymnet'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Payemnt found'];
            return response()->json($response,200);
        } 


        // return view('pharmacy.pos.purchases.purchase_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function inv_pdfview(Request $request)
    {
        //
        $purchases = Purchase::find($request->id);
        $purchase_items=PurchaseItems::where('purchase_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pharmacy.pos.purchases.purchase_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('PURCHASES REF NO # ' .  $purchases->reference_no . ".pdf");
        }
        return view('inv_pdfview');
    }
public function creditors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (Supplier::where('user_id',auth()->user()->added_by)->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){
             $purchases= Purchase::where('supplier_id', $request->account_id)->whereBetween('purchase_date',[$start_date,$end_date])->where('status','!=',0);
            $data= PurchaseSerial::where('supplier_id', $request->account_id)->whereBetween('purchase_date',[$start_date,$end_date])->where('status','!=',0)->union($purchases)->get();
        }else{
            $data=[];
        }
        if($data)
        {
            
        
            $response=['success'=>true,'error'=>false,'message'=>'Purchase  Creditor Report Successfully', 'purchase' => $data];
            return response()->json($response,200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to Cancel Creditor Report Successfully'];
            return response()->json($response,200);
        }
    }

            public function save_batch (Request $request){
                     //
                    //  $this->validate($request, [
                    //     'supplier_id'=>'required',
                    //     'purchase_date'=>'required',
                    //     'due_date'=>'required',
                    //     'exchange_code'=>'required',
                    //     'exchange_rate'=>'required',
                    //     'type'=>'required',
                    //     'id'=>'required',
                
                
                    // ]);

                     $inv =   Purchase::find($request->purchase_id);
                     $data['purchase_id'] = $request->purchase_id;
                     $data['expire_date']=$request->expire_date;
                    $data['batch_number']=$request->batch_number;
                    $data['serial_no']=$request->batch_number;
                     $inv->update($data);
                     if($inv)
                    {
                        
                    
                        $response=['success'=>true,'error'=>false,'message'=>'Assigned Successfully', 'batch' => $inv];
                        return response()->json($response,200);
                    }
                    else
                    {
                        
                        $response=['success'=>false,'error'=>true,'message'=>'Failed to Assigned Successfully'];
                        return response()->json($response,200);
                    }

                    //  return redirect(route('pharmacy.purchase_list'))->with(['success'=>' Assigned Successfully']);
                 }

 public function summary(Request $request)
    {
        //

    $all_employee=User::where('id','!=',1)->get();

 $search_type = $request->search_type;
 $check_existing_payment='';
$start_date='';
$end_date='';
$by_month='';
$user_id='';
$flag = $request->flag;

 

if (!empty($flag)) {
            if ($search_type == 'employee') {
             $user_id = $request->user_id;
             $check_existing_payment =Activity::where('added_by', $user_id)->get();
            }
          
            else if ($search_type == 'period') {
              $start_date = $request->start_date;
              $end_date= $request->end_date;
             $check_existing_payment = Activity::all()->whereBetween('date',[$start_date,$end_date]);
            }
           elseif ($search_type == 'activities') {
             $check_existing_payment =Activity::all();
            }
}
    else{
        $check_existing_payment='';
        $start_month='';
        $end_month='';
        $search_type='';
        $by_month='';
        $user_id='';
        }

 

 return view('pharmacy.pos.purchases.summary',compact('all_employee','check_existing_payment','start_date','end_date','search_type','user_id','flag'));
    }

}
