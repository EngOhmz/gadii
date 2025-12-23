<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\POS;

use App\Http\Controllers\Controller;
use App\Models\Retail\Activity;
use App\Models\Retail\Location;
use App\Models\Retail\Purchase;
use App\Models\Retail\PurchaseItems;
use App\Models\Retail\Invoice;
use App\Models\Retail\InvoiceItems;
use App\Models\Retail\Supplier;
use App\Models\Retail\Client;
use App\Models\Region;
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

       $location = Location::where('added_by', $id)->orderBy('created_at', 'desc')->get(); 

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


    public function indexOff(int $id, int $lastId)
    {
        //

       $location = Location::where('added_by', $id)->where('id', '>', $lastId)->orderBy('created_at', 'desc')->get(); 

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
    
    public function get_store_report($id, $date){

        $location = Location::find($id); 

       if(!empty($location)){
           

            $purchases = Purchase::where('location', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->get();

            if($purchases->isNotEmpty()){


                $purchase_quantity = Purchase::where('location', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->count('id');

                $data44['total_purchase'] = $purchase_quantity;

                $purchase_due_amount = Purchase::where('location', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->sum('due_amount');

                $data44['total_purchase_due_amount'] = $purchase_due_amount;

                $purchase_paid_amount = Purchase::where('location', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->sum('paid_amount');

                $data44['total_purchase_paid_amount'] = $purchase_paid_amount;


              
            }
            else{
               
                $data44['total_purchase'] = 0;

                $data44['total_purchase_due_amount'] = "0.00";

                $data44['total_purchase_paid_amount'] = "0.00";



            }
            $invoices = Invoice::where('store_id', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->get();

            if($invoices->isNotEmpty()){

                $sales_quantity = Invoice::where('store_id', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->count('id');

                $data44['total_sales'] = $sales_quantity;

                $sales_due_amount = Invoice::where('store_id', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->sum('due_amount');

                $data44['total_sales_due_amount'] = $sales_due_amount;
                
                $purchase_sales_amount = Invoice::where('store_id', $id)->where('status', '!=', 0)->whereDate('created_at', $date)->sum('paid_amount');

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
           
        $invoices = Invoice::where('invoice_status',1)->where('location', $id)->whereDate('created_at', $date)->get();
        
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
        
        
        $data= new Location();
        $data->name=$request->input('name');
        $data->location=$request->input('location');
        $data->added_by=$request->input('id');
    
        $data->save();
    
        // $dt = $data->id;
    
        if(!empty($data)){
            $activity =Activity::create(
                [ 
                    'added_by'=> $data->added_by,
                    'module_id'=>$data->id,
                    'module'=>'Location(Store)',
                    'activity'=>"Location(Store) " .  $data->name. "  Created",
                ]
                );                      
            }
    
        
    
    
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
