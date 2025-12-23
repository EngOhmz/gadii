<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\POS;

use App\Http\Controllers\Controller;
// use App\Models\Retail\Activity;
// use App\Models\Retail\Location;
use App\Models\POS\Activity;
use App\Models\Location;
use App\Models\POS\Purchase;
use App\Models\POS\Items;

use App\Models\POS\StockMovement;

use App\Models\POS\StockMovementItem;

use App\Models\POS\GoodIssue;

use App\Models\POS\GoodIssueItem;

use App\Models\LocationManager;

use App\Models\POS\PurchaseItems;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\Supplier;
use App\Models\Client;
use App\Models\Region;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        //
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;

           $location = Location::where('added_by', $added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get(); 
    
           if($location->isNotEmpty()){
    
            foreach($location as $row){
    
                $data = $row;
    
                $farmers[] = $data;
     
            }
    
                $response=['success'=>true,'error'=>false,'message'=>'successfully','location'=>$farmers];
                return response()->json($response,200);
            }
            else{
    
                $response=['success'=>false,'error'=>true,'message'=>'No Location found'];
                return response()->json($response,200);
            }
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
    }
    
    public function stock_movement_index(int $id, int $storeID)
    {
        //
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;

           $location = StockMovement::where('added_by', $added_by)->where('source_store', $storeID)->orWhere('destination_store', $storeID)->where('disabled','0')->orderBy('created_at', 'desc')->get(); 
    
           if($location->isNotEmpty()){
    
            foreach($location as $row){
                
                    
                    $data = $row;
                
                
                    $data['staff'] = User::find($row->staff)->name;
                    
                    $data['source_store_name'] = Location::find($data->source_store)->name;
                
                    $data['destination_store_name'] = Location::find($data->destination_store)->name;
                    
                    $stit = StockMovementItem::where('movement_id', $location->id)->first();
                    
                    
                    $data['item_name'] = Items::find($stit->item_id)->name;
                    
                    $loc = Location::find($storeID)->name;
                    
                    
                    
                    if($data['source_store'] == $loc){
                        $data['status'] = 'Sent';
                    }
                    elseif($data['destination_store'] == $loc){
                        $data['status'] = 'Received';
                    }
        
                    $farmers[] = $data;
                
               
                
     
            }
    
                $response=['success'=>true,'error'=>false,'message'=>'successfully','movement'=>$farmers];
                return response()->json($response,200);
            }
            else{
    
                $response=['success'=>false,'error'=>true,'message'=>'No Stock Movement found'];
                return response()->json($response,200);
            }
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
    }
    
    
    public function good_issue_index(int $id, int $storeID)
    {
        //
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;

           $location = GoodIssue::where('added_by', $added_by)->where('source_store', $storeID)->where('disabled','0')->orderBy('created_at', 'desc')->get(); 
    
           if($location->isNotEmpty()){
    
            foreach($location as $row){
    
                $data = $row;
                
                $data['source_store'] = Location::find($row->source_store)->name;
                
                $data['staff'] = User::find($data->staff_id)->name;
    
                $farmers[] = $data;
     
            }
    
                $response=['success'=>true,'error'=>false,'message'=>'successfully','good_issue'=>$farmers];
                return response()->json($response,200);
            }
            else{
    
                $response=['success'=>false,'error'=>true,'message'=>'No Good issue found'];
                return response()->json($response,200);
            }
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
    }


    public function indexOff(int $id, int $lastId)
    {
        //
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;

           $location = Location::where('added_by', $id)->where('disabled','0')->where('id', '>', $lastId)->orderBy('created_at', 'desc')->get(); 
    
           if($location->isNotEmpty()){
    
            foreach($location as $row){
    
                $data = $row;
    
                $farmers[] = $data;
     
            }
    
                $response=['success'=>true,'error'=>false,'message'=>'successfully','location'=>$farmers];
                return response()->json($response,200);
            }
            else{
    
                $response=['success'=>false,'error'=>true,'message'=>'No Location found'];
                return response()->json($response,200);
            }
            
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }        
    }
    
    public function get_store_report($id, $date){

        $location = Location::find($id); 

       if(!empty($location)){
           

            $purchases = Purchase::where('location', $id)->where('disabled','0')->where('status', '!=', 0)->whereDate('created_at', $date)->get();

            if($purchases->isNotEmpty()){


                $purchase_quantity = Purchase::where('location', $id)->where('disabled','0')->where('status', '!=', 0)->whereDate('created_at', $date)->count('id');

                $data44['total_purchase'] = $purchase_quantity;

                $purchase_due_amount = Purchase::where('location', $id)->where('disabled','0')->where('status', '!=', 0)->whereDate('created_at', $date)->sum('due_amount');

                $data44['total_purchase_due_amount'] = $purchase_due_amount;

                $purchase_paid_amount = Purchase::where('location', $id)->where('disabled','0')->where('status', '!=', 0)->whereDate('created_at', $date)->sum('paid_amount');

                $data44['total_purchase_paid_amount'] = $purchase_paid_amount;


              
            }
            else{
               
                $data44['total_purchase'] = 0;

                $data44['total_purchase_due_amount'] = "0.00";

                $data44['total_purchase_paid_amount'] = "0.00";



            }
            $invoices = Invoice::where('store_id', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->get();

            if($invoices->isNotEmpty()){

                $sales_quantity = Invoice::where('store_id', $id)->where('disabled','0')->where('status', '!=', 0)->whereDate('created_at', $date)->count('id');

                $data44['total_sales'] = $sales_quantity;

                $sales_due_amount = Invoice::where('store_id', $id)->where('disabled','0')->where('status', '!=', 0)->whereDate('created_at', $date)->sum('due_amount');

                $data44['total_sales_due_amount'] = $sales_due_amount;
                
                $purchase_sales_amount = Invoice::where('store_id', $id)->where('disabled','0')->where('status', '!=', 0)->whereDate('created_at', $date)->sum('paid_amount');

                $data44['total_sales_paid_amount'] = $purchase_sales_amount;

       

            }

            else{

                $data44['total_sales'] = 0;


                $data44['total_sales_due_amount'] = "0.00";
                
                $data44['total_sales_paid_amount'] = "0.00";
            }



            // $data44['purchases'] = $farmers1;

            // $data44['sales'] = $farmers23;

            $farmers = $data44;




            
            

            $response=['success'=>true,'error'=>false,'message'=>'successfully','purchase_sales'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Location found'];
            return response()->json($response,200);
        }                         
    }
    
    public function purchase_sales_date($id, $date){
        
        
        $location = Location::find($id); 

       if(!empty($location)){
           
        $invoices = Invoice::where('invoice_status',1)->where('disabled','0')->where('location', $id)->whereDate('created_at', $date)->get();
        
        if($invoices->isNotEmpty()){
            $sale = [];
            
            foreach($invoices as $row){

                $data = $row;
                if (!empty($row->location)) {
                    $data['location_id'] = intval($row->location);
                    $location = Location::find($row->location);
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
                if(!empty($row->client_id)){
                    $data['client_id'] =  intval($row->client_id);
                }
                else{
                    $data['client_id'] =  null;
                }

                

                $client_id = Client::find(intval($row->client_id));
                if(!empty($client_id)){

                $data['client'] =  Client::find(intval($row->client_id))->name;

                $data['client_tin'] =  Client::find(intval($row->client_id))->TIN;

                $data['client_email'] =  Client::find(intval($row->client_id))->email;

                $data['client_phone'] =  Client::find(intval($row->client_id))->phone;

                $data['client_address'] =  Client::find(intval($row->client_id))->address;
                }
                else{

                    $data['client'] =  null;

                    $data['client_tin'] =  null;
    
                    $data['client_email'] =  null;
    
                    $data['client_phone'] =  null;
    
                    $data['client_address'] =  null;
                }

                // $region = Region::find($row->region);
                
                if(!empty($row->region)){

                    $data['region']  = $row->region;

                }
                else{
                    $data['region']  = null;

                }

               


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
                elseif($row->status == 7){
                    $data['status'] = 'Paid';
                }

                $sale[] = $data;
     
            }
        }
        else{
            $data = [];
            $sale[] = $data;
        }
        
        
                $purchases = Purchase::where('location', $id)->whereDate('created_at', $date)->get();
                
                
                
                if($purchases->isNotEmpty()){
                    
                    $purchase = [];
                    
                foreach($purchases as $row){
                    
                    $data2 = $row;



                if (!empty($row->location)) {

                    $data2['location_id'] = intval($row->location);

                    $location = Location::find(intval($row->location));
                    if(!empty($location)){
                        $loc2= Location::where('id', $row->location)->value('name');


                        $data2['location'] = $loc2;
                    }

                    else{
                        $data2['location'] = null;

                    }

                    
                }
                else{
                    $data2['location_id'] = null;

                    // $loc2= Location::where('id', $row->location)->value('name');


                    $data2['location'] = null;
                }

                 if(!empty($row->supplier_id)){
                    $data2['supplier_id'] = intval($row->supplier_id);


                    $data2['supplier'] = $row->supplier->name;
                }
                else{
                    $data2['supplier_id'] = null;


                    $data2['supplier'] = null;
                }

               

                // $loc= Location::where('id', $row->location)->value('name');

               


                if($row->status == 0){
                    $data2['status'] = 'Not Approved';
                }
                elseif($row->status == 1){
                    $data2['status'] = 'Not Paid';
                }
                elseif($row->status == 2){
                    $data2['status'] = 'Partially Paid';
                }
                elseif($row->status == 3){
                    $data2['status'] = 'Fully Paid';
                }
                elseif($row->status == 4){
                    $data2['status'] = 'Cancelled';
                }
                elseif($row->status == 5){
                    $data2['status'] = 'Received';
                }

                elseif($row->status == 6){
                    $data2['status'] = 'Scanned and Paid';
                }
                
                $purchase[] = $data2;
                
                
                
                }
                    
                    
                
                }
                else{
                    $data2 = [];
                    $purchase[] = $data2;
                }
        
               
    
     
            
            
            $purchase_sale['sale'] = $sale;
            
            $purchase_sale['purchase'] = $purchase;
            
            $items = $purchase_sale;

        
  
            

            $response=['success'=>true,'error'=>false,'message'=>'successfully','location_date'=>$items];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Location found'];
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
            'name'=>'required',
            'id'=>'required',
            
        ]);
        
        $usr = User::find($request->input('id'));
    
        if($usr){
            
             
        $added_by =  $usr->added_by;
        
        
        $data= new Location();
        $data->name=$request->input('name');
        $data->location=$request->input('location');
        $data->type= 3;
        $data->added_by= $added_by;
    
        $data->save();
        
        $items = array(
                        'manager' => $usr->id,
                        'name' =>   $request->input('name'),
                    //   'main' =>   $request->main,
                       'location_id'=>$data->id,
                         'order_no' => 1,
                        'added_by' => $data->added_by);
                       
                      $manager55 = LocationManager::create($items);
    
        // $dt = $data->id;
    
        // if(!empty($data)){
        //     $activity =Activity::create(
        //         [ 
        //             'added_by'=> $data->added_by,
        //             'module_id'=>$data->id,
        //             'module'=>'Location(Store)',
        //             'activity'=>"Location(Store) " .  $data->name. "  Created",
        //         ]
        //         );                      
        //     }
    
        
    
    
        if($data)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Location Created successful', 'location' => $data];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Location Successfully'];
            return response()->json($response,200);
        }
        
        
        }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }

    }
    
    
    public function stock_movement_store(Request $request)
    {
        //

        $this->validate($request,[
            'item_id'=>'required',
            'quantity'=>'required',
            'source_store'=>'required',
            'destination_store'=>'required',
            'id'=>'required',
            
        ]);
       
            
             
        $usr = User::find($request->input('id'));
    
        if($usr){
            
             
        $added_by =  $usr->added_by;
        
        $item = Items::find($request->input('item_id'));
        
        if(!empty($item)){
            
            if($item->quantity  >= $request->quantity){
                
                
                $count=StockMovement::where('added_by', $added_by)->count();
                $pro=$count+1;
                
                $data = new StockMovement();
                $data->destination_store = $request->input('destination_store');
                $data->source_store = $request->input('source_store');
                // $data->item_id = $request->input('item_id');
                $data->movement_date = Carbon::now()->format('Y-m-d');
                $data->staff = $request->input('id');
                $data->quantity = $request->input('quantity');
                // $data->item_name = $item->name;
                 $data->name = "STM0".$pro;
                $data->user_id = $request->input('id');
                $data['status']= 1;
                $data->added_by= $added_by;
            
                $data->save();
            
                
                
            $iyt = StockMovementItem::where('movement_id', $data->id)->orderBy('created_at', 'desc')->first();

            if(!empty($iyt)){
                $iy = $iyt->order_no + 1;
            }
            else{

                $iy = 1;
            }
            
             $items3334 = array(
                        'item_id' => $request->input('item_id'),
                        'status' => 1,
                        'destination_store' =>$request->input('destination_store'),
                        'source_store' => $request->input('source_store'),   
                        'quantity' =>    $request->input('quantity'),
                           'order_no' => $iy,
                           'added_by' => $added_by,
                        'movement_id' => $data->id);

                    
                $stit =  StockMovementItem::create($items3334);
        
        
            
                if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=> $data->added_by,
                            'user_id'=> $data->staff,
                            'module_id'=>$data->id,
                            'module'=>'StockMovement',
                            'activity'=>"StockMovement" .  $data->id. "  Created",
                        ]
                        );                      
                    }
                    
                    //reduce from source
                    $loc2=Location::find($request->input('source_store'));
                    $lq2['quantity']=$loc2->quantity - $request->quantity;
                    Location::where('id', $request->input('source_store'))->update($lq2);
                
                
                           
                    //add to destination
                    $loc=Location::find($request->input('destination_store'));
                    $lq['quantity']=$loc->quantity + $request->quantity;
                    Location::where('id', $request->input('destination_store'))->update($lq);
                    
                    $data['staff'] = User::find($data->staff)->name;
                    
                    $data['source_store_name'] = Location::find($data->source_store)->name;
                
                $data['destination_store_name'] = Location::find($data->destination_store)->name;
                
                $data['item_name'] = Items::find($stit->item_id)->name;
                
                // $data['status'] = 'Sent';
         
                  
                
                $response=['success'=>true,'error'=>false, 'message' => 'Stock Movement Done successful', 'movement' => $data];
                return response()->json($response, 200);
            }
            else{
                
                $response=['success'=>false,'error'=>true,'message'=>'Insufficient Quantity'];
                return response()->json($response,200);
            }
            
        }
        else{
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  find Item on Inventory'];
            return response()->json($response,200);
        }
        
        }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       }
       

    }
    
    
    public function good_issue_store(Request $request)
    {
        //

        $this->validate($request,[
            'item_id'=>'required',
            'quantity'=>'required',
            'staff'=>'required',
            'id'=>'required',
            
        ]);
       
            
             
        $usr = User::find($request->input('id'));
    
        if($usr){
            
             
        $added_by =  $usr->added_by;
        
        $item = Items::find($request->input('item_id'));
        
        if(!empty($item)){
            
            if($item->quantity  >= $request->quantity){
                
                $count=GoodIssue::where('added_by', $added_by)->count();
              $pro=$count+1;
                
                $data = new GoodIssue();
                $data->source_store = $request->input('source_store');
                $data->location = $request->input('source_store');
                $data->reason = $request->input('reason');
                $data->item_id = $request->input('item_id');
                $data->date = Carbon::now()->format('Y-m-d');
                $data->item_name = $item->name;
                $data->name = "GDIS0".$pro;
                $data->quantity = $request->input('quantity');
                $data->staff = $request->input('staff');
                $data->staff_id = $request->input('staff');
                $data->status= 1;
                $data->user_id = $request->input('id');
                $data->added_by= $added_by;
            
                $data->save();
                
                
                
                $items = array(
                        'item_id' => $request->input('item_id'),
                        'status' => 1,
                        'location' => $request->input('source_store'),
                         'truck_id' => $request->input('truck_id'),
                        'quantity' =>    $request->input('quantity'),
                           'order_no' => 1,
                           'added_by' => $added_by,
                        'issue_id' =>$data->id);

                    
                   GoodIssueItem::create($items);
             
        
        
            
                // $dt = $data->id;
            
                if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=> $data->added_by,
                            'user_id'=> $data->staff,
                            'module_id'=>$data->id,
                            'module'=>'Good issue',
                            'activity'=>"Good issue" .  $data->id. "  Created",
                        ]
                        );                      
                    }
                    
                    //reduce from source
                    $loc2=Location::find($request->input('source_store'));
                    $lq2['quantity']=$loc2->quantity - $request->quantity;
                    Location::where('id', $request->input('source_store'))->update($lq2);
                    
                    
                    
                    $data['source_store'] = Location::find($data->source_store)->name;
                    
                    $data['staff'] = User::find($data->staff)->name;
         
                  
                
                $response=['success'=>true,'error'=>false, 'message' => 'Good issue Done successful', 'good_issue' => $data];
                return response()->json($response, 200);
            }
            else{
                
                $response=['success'=>false,'error'=>true,'message'=>'Insufficient Quantity'];
                return response()->json($response,200);
            }
            
        }
        else{
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  find Item on Inventory'];
            return response()->json($response,200);
        }
        
        }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
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
    public function update(Request $request, $id)
    {
        //

        
       $this->validate($request,[
        'name'=>'required',
        'id'=>'required',
       
    ]); 
    
    $data=Location::find($id);
    $data->name=$request->input('name');
    $data->added_by=$request->input('id');
    $data->type= 3;

    $seed =  $data->update();


    if(!empty($data)){
        $activity =Activity::create(
            [ 
                'added_by'=> $data->added_by,
                'module_id'=>$data->id,
                 'module'=>'Location(Store)',
                'activity'=>"Location(Store) " .  $data->name. "  Updated",
            ]
            );                      
        }

    


    if($seed)
    {
       
    
        $response=['success'=>true,'error'=>false, 'message' => 'Location Updated successful', 'location' => $data];
        return response()->json($response, 200);
    }
    else
    {
        
        $response=['success'=>false,'error'=>true,'message'=>'Failed to Update Location Successfully'];
        return response()->json($response,200);
    }

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
        $data = Location::find($id);

       if(!empty($data)){
                  $activity =Activity::create(
                      [ 
                          'added_by'=>   $data->added_by,
                          'module_id'=>$id,
                           'module'=>'Location(Store)',
                          'activity'=>"Location(Store) " .  $data->name. "  Deleted",
                      ]
                      );                      
     }

      $crop = $data->delete();

      if($crop)
      {
         
      
          $response=['success'=>true,'error'=>false,'message'=>'Location deleted'];
          return response()->json($response,200);
      }
      else
      {
          
          $response=['success'=>false,'error'=>true,'message'=>'Failed to delete Location'];
          return response()->json($response,200);
      }
 
    }
}
