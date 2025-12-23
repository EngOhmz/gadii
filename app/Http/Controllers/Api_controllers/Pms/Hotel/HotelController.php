<?php

namespace App\Http\Controllers\Api_controllers\Pms\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Carbon\Carbon;

use App\Models\POS\Items;

use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelItems;
use App\Models\Hotel\HouseType;
use App\Models\Hotel\RoomType;

use App\Models\Restaurant\POS\Order;
use App\Models\Restaurant\POS\OrderItem;

use App\Models\Restaurant\POS\OrderFet;
use App\Models\Restaurant\POS\OrderItemFet;

use App\Models\Restaurant\POS\OrderHistory;
use App\Models\Restaurant\POS\OrderPayments;
use App\Models\Restaurant\POS\Client;

use App\Models\Restaurant\POS\Menu;
use App\Models\Restaurant\POS\MenuComponent;

use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\JournalEntry;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Payment_methodes;
use App\Models\User;

use Illuminate\Http\Request;

class HotelController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(int $id)
    {
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
            
        $invoices=Hotel::where('status',1)->where('added_by', $added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;
                
                $client_id = $row->type;
                if(!empty($client_id)){

                $data['house_type_name'] =  HouseType::find(intval($row->type))->name;
                
                }
                else{

                    $data['house_type_name'] =  null;
                }
               


                if($row->status == 0){
                    $data['status'] = 'Inactive';
                }
                elseif($row->status == 1){
                    $data['status'] = 'Active';
                }

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','hotel'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Hotel found'];
            return response()->json($response,200);
        } 
        
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       } 
    }
    
    
    public function shopkeeper_index(int $id)
    {
        

        $invoices=Hotel::where('status',1)->where('manager_id', $id)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        
        if($invoices->isNotEmpty()){

             foreach($invoices as $row){

                $data = $row;
                
                $client_id = $row->type;
                if(!empty($client_id)){

                $data['type'] =  HouseType::find(intval($row->type))->name;
                
                }
                else{

                    $data['type'] =  null;
                }
               


                if($row->status == 0){
                    $data['status'] = 'Inactive';
                }
                elseif($row->status == 1){
                    $data['status'] = 'Active';
                }

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','hotel'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Hotel found managed by that id'];
            return response()->json($response,200);
        } 
        
        
       
       
    }

    public function indexOff(int $id, int $lastId)
    {
        
        $usr = User::find($id);
       
       if(!empty($usr)){
           
           
            $added_by = $usr->added_by;
        
        
        $invoices= Hotel::where('status',1)->where('added_by', $added_by)->where('id', '>' ,$lastId)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;
                
                $client_id = $row->type;
                if(!empty($client_id)){

                $data['type'] =  HouseType::find(intval($row->type))->name;
                
                }
                else{

                    $data['type'] =  null;
                }
               


                if($row->status == 0){
                    $data['status'] = 'Inactive';
                }
                elseif($row->status == 1){
                    $data['status'] = 'Active';
                }

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','hotel'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Hotel found'];
            return response()->json($response,200);
        } 
        
        
       }
       else{
                $response=['success'=>false,'error'=>true,'message'=>'No User found by that id'];
                return response()->json($response,200);
       } 
       
    }
    
    public function house_items(){
        
        // $date = Carbon::now()->format('Y-m-d');
        
        $items = HouseType::where('added_by', 1)->get();
        
        if($items->isNotEmpty()){

        foreach($items as $row){

            $data = $row;

            $farmers[] = $data;
 
        }

        $response=['success'=>true,'error'=>false,'message'=>'successfully','house_type'=>$farmers];
        return response()->json($response,200);
        }
        else{
    
            $response=['success'=>false,'error'=>true,'message'=>'No House Type  found'];
            return response()->json($response,200);
        }
        
    }
    
    public function room_items(){
        
        // $date = Carbon::now()->format('Y-m-d');
        
        $items = RoomType::where('added_by', 1)->get();
        
        if($items->isNotEmpty()){

        foreach($items as $row){

            $data = $row;

            $farmers[] = $data;
 
        }

        $response=['success'=>true,'error'=>false,'message'=>'successfully','room_type'=>$farmers];
        return response()->json($response,200);
        }
        else{
    
            $response=['success'=>false,'error'=>true,'message'=>'No Room Type  found'];
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nowDate = Carbon::now()->format('Y-m-d');
        
        $usr = User::find($request->id);
       
       if($usr){
           
       $added_by =  $usr->added_by;
  
        $count=Hotel::where('added_by', $added_by)->count();
        $pro=$count+1;
        $data['reference_no']= "H0".$pro;
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['type']=$request->type;
        $data['google_location']=$request->google_location;
        $data['offers']=$request->offers;
        $data['address']=$request->address;
        $data['phone1']=$request->phone1;
        $data['phone2']=$request->phone2;
        $data['website_link']=$request->website_link;
        $data['notes']=$request->notes;
        $data['status']= 1 ;
        $data['user_id']= $usr->id;
        $data['added_by']= $added_by;
        

        $invoice = Hotel::create($data);
        
                  
     
        if($invoice)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Hotel Created successful', 'hotel' => $invoice];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Hotel Successfully'];
            return response()->json($response,200);
        }
        
    }
            else{
                
                $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Hotel Cause User ID not found on users table Successfully'];
                return response()->json($response,200);
            }

    }
    
    public function item_index(int $id){
        $invoices=HotelItems::where('hotel_id', $id)->orderBy('created_at', 'desc')->get();
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;

                $data['hotel_id'] = intval($row->hotel_id);


                $data['purchase_item_id'] = intval($row->id);
                
                $client_id2 = $row->room_type;
                
                
                if(!empty($client_id2)){

                $data['type_name'] =  RoomType::find(intval($row->room_type))->name;
                
                }
                else{

                    $data['type_name'] =  null;
                }
               


                // $data['id'] = intval($row->items_id);
                
                // $data['item_name'] = Items::find(intval($row->items_id))->name;

                // $data['inventory_id'] = intval($row->items_id);

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','hotel_room'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Hotel Room  found'];
            return response()->json($response,200);
        } 
    }
    
    
     public function item_indexOff(int $id, int $lastId){

        $invoices=HotelItems::where('hotel_id', $id)->where('id', '>', $lastId)->orderBy('created_at', 'desc')->get();
        
        if($invoices->isNotEmpty()){

            foreach($invoices as $row){

                $data = $row;

                $data['hotel_id'] = intval($row->hotel_id);


                $data['purchase_item_id'] = intval($row->id);
                
                $client_id2 = $row->room_type;
                
                
                if(!empty($client_id2)){

                $data['type_name'] =  RoomType::find(intval($row->room_type))->name;
                
                }
                else{

                    $data['type_name'] =  null;
                }
                
                // $data['item_name'] = Items::find(intval($row->items_id))->name;


                // $data['id'] = intval($row->items_id);

                // $data['inventory_id'] = intval($row->items_id);

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','hotel_room'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Hotel Room found'];
            return response()->json($response,200);
        } 

    }
    
   
      public function item_store(Request $request){

        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'room_type' => 'required',

            'hotel_id' => 'required',

        ]);

        

        $invoice = Hotel::find(intval($request->hotel_id));



        if(!empty($invoice)){

                              $items23 = array(
                                 'room_type' => $request->room_type,
                                 'room_status' => 1,
                                  'name' => $request->name,
                                  'service' => $request->service,
                                  'description' => $request->description,
                                  'toilet' =>   $request->toilet,
                                   'price' =>  $request->price,
                                     'added_by' => $invoice->added_by,
                                     'user_id' => $invoice->user_id,
                                  'hotel_id' =>$invoice->id);
                                 
                               $dt2 =   HotelItems::create($items23);  
       
      
          
                        $response=['success'=>true,'error'=>false, 'message' => 'Hotel Rooms Created successful', 'hotel_room' => $dt2];
                        return response()->json($response, 200);


                     
 
                    

        }
        else
        {
                      
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Invoice Items Successfully'];
             return response()->json($response,200);
        } 
    }

    
    public function item_sales_delete(int $id){

        $invoice_item = HotelItems::find($id);

        $invoice_id = $invoice_item->hotel_id; 

        $invoice = Hotel::find($invoice_id);

        $invoice_items99 =  $invoice_item->delete();


        if($invoice_items99)
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

    public function item_sales_update(Request $request){

        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'room_type' => 'required',

            'hotel_id' => 'required',

        ]);
      

                    $invoice = Hotel::find($request->hotel_id);
                    

                    if (!empty($invoice)) {




                        if(!empty($request->purchase_item_id)){

                        $invoice_item = HotelItems::find($request->purchase_item_id);


                        $items23 = array(
                             'room_type' => $request->room_type,
                             'room_status' => 1,
                                  'name' => $request->name,
                                  'toilet' =>   $request->toilet,
                                  'service' => $request->service,
                                   'description' => $request->description,
                                   'price' =>  $request->price,
                                     'added_by' => $invoice->added_by,
                                     'user_id' => $invoice->user_id,
                                  'hotel_id' =>$invoice->id);

                        $invoice_item_updated =  HotelItems::where('id',$invoice_item->id)->update($items23);

                       

                        if ($invoice_item_updated) {
                            $response=['success'=>true,'error'=>false, 'message' => 'Hotel Room Updated successful',];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Update Hotel Room Successfully'];
                            return response()->json($response,200);
                        }

                        // --------------------------------------------

                        }
                        else{

                            
                        // ----------------------------
                     

                        $items23 = array(
                            'room_type' => $request->room_type,
                            'room_status' => 1,
                                  'name' => $request->name,
                                   'description' => $request->description,
                                  'toilet' =>   $request->toilet,
                                  'service' => $request->service,
                                   'price' =>  $request->price,
                                     'added_by' => $invoice->added_by,
                                     'user_id' => $invoice->user_id,
                                  'hotel_id' =>$invoice->id);

                        $pt =  HotelItems::create($items23);;


                        if ($pt) {
                            $response=['success'=>true,'error'=>false, 'message' => 'Hotel Room Created successful'];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Hotel Room Successfully'];
                            return response()->json($response,200);
                        }

                        // --------------------------------------------
                        }


                    }
                        else
                        {
                            
                            $response=['success'=>false,'error'=>true,'message'=>'Hotel Not found'];
                            return response()->json($response,200);
                        }
          
    }
    
    
    public function order_receive(int $id){
        
           $invoice  = Order::find($id);
         
            $data['status']= 5;
    
          $inv =  $invoice->update($data);
          
          
          if($invoice->status == 0){
                    $invoice['status'] = 'Not Approved';
                }
                elseif($invoice->status == 1){
                    $invoice['status'] = 'Not Paid';
                }
                elseif($invoice->status == 2){
                    $invoice['status'] = 'Partially Paid';
                }
                elseif($invoice->status == 3){
                    $invoice['status'] = 'Fully Paid';
                }
                elseif($invoice->status == 4){
                    $invoice['status'] = 'Cancelled';
                }
                elseif($invoice->status == 7){
                    $invoice['status'] = 'Paid';
                }
                elseif($invoice->status == 5){
                    $invoice['status'] = 'Delivered';
                }
          
          if ($inv) {

                               

          $response=['success'=>true,'error'=>false, 'message' => 'Order Delivered successful', 'order' => $invoice];
          return response()->json($response, 200);
        }
         else{
                                                
              $response=['success'=>false,'error'=>true,'message'=>'Failed to  Delivered Order Successfully'];
              return response()->json($response,200);
             }
        
    }
    
    public function order_cancel(int $id){
        
           $invoice  = Order::find($id);
         
            $data['status']= 4;
    
          $inv =  $invoice->update($data);
          
          if($invoice->status == 0){
                    $invoice['status'] = 'Not Approved';
                }
                elseif($invoice->status == 1){
                    $invoice['status'] = 'Not Paid';
                }
                elseif($invoice->status == 2){
                    $invoice['status'] = 'Partially Paid';
                }
                elseif($invoice->status == 3){
                    $invoice['status'] = 'Fully Paid';
                }
                elseif($invoice->status == 4){
                    $invoice['status'] = 'Cancelled';
                }
                elseif($invoice->status == 7){
                    $invoice['status'] = 'Paid';
                }
                elseif($invoice->status == 5){
                    $invoice['status'] = 'Delivered';
                }
          
          if ($inv) {

          $response=['success'=>true,'error'=>false, 'message' => 'Order Delivered successful', 'order' => $invoice];
          return response()->json($response, 200);
        }
         else{
                                                
              $response=['success'=>false,'error'=>true,'message'=>'Failed to  Delivered Order Successfully'];
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

       OrderItem::where('invoice_id', $id)->delete();
       OrderPayments::where('invoice_id', $id)->delete();
       
        $invoices =Order::find($id);
        $invoices->delete();

        Toastr::success('Order Deleted Successfully','Success');
        return redirect(route('orders.index'));
    }


  public function showType(Request $request)
    {
         if($request->id == 'Bar'){
       $item= Items::all(); 
         }

         else if($request->id == 'Kitchen'){

           $item=Menu::where('status','1')->get(); 
        
                 }
                                                                                          
               return response()->json($item);

}

 



 
}
