<?php

namespace App\Http\Controllers\Api_controllers\Pms\Outlet;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Carbon\Carbon;

use App\Models\POS\Items;

use App\Models\Restaurant\POS\Order;
use App\Models\Restaurant\POS\OrderItem;
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

class OrderController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        $usr = User::find($id);
       
       if($usr){
           
       $added_by =  $usr->added_by;
       
           $orders = Order::where('added_by', $added_by)->get();
          
          
          if($orders->isNotEmpty()){

            foreach($orders as $row){

                $data = $row;
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


                    $data['location'] = null;
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
                elseif($row->status == 7){
                    $data['status'] = 'Paid';
                }
                elseif($row->status == 5){
                    $data['status'] = 'Delivered';
                }

                $farmers[] = $data;
     
            }

            $response=['success'=>true,'error'=>false,'message'=>'successfully','orders'=>$farmers];
            return response()->json($response,200);
        }
        else{

            $response=['success'=>false,'error'=>true,'message'=>'No Orders found'];
            return response()->json($response,200);
        }
            
            
        
        
        }
        else{
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Return Orders Cause User ID not found on users table Successfully'];
            return response()->json($response,200);
        }
        
            // return view('restaurant.orders.index', compact('index','type','location','bank_accounts','currency'));

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
    
    
    public function account_code(int $id){
        
        $usr = User::find($id);
       
    //   if($usr){
           
       $added_by =  $usr->added_by;

        $bank_accounts = AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by', $added_by)->orderBy('id', 'desc')->get();

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
    
 
    
    public function bar_items(){
        
        // $date = Carbon::now()->format('Y-m-d');
        
        $items = Items::where('quantity', '>', 0)->get();
        
        if($items->isNotEmpty()){

        foreach($items as $row){

            $data = $row;

            $farmers[] = $data;
 
        }

        $response=['success'=>true,'error'=>false,'message'=>'successfully','items'=>$farmers];
        return response()->json($response,200);
        }
        else{
    
            $response=['success'=>false,'error'=>true,'message'=>'No Bar items found'];
            return response()->json($response,200);
        }
        
    }
    
    public function kitchen_items(){
        
        // $date = Carbon::now()->format('Y-m-d');
        
        $items = Menu::where('status','1')->get();
        
        if($items->isNotEmpty()){

        foreach($items as $row){

            $data = $row;

            $farmers[] = $data;
 
        }

        $response=['success'=>true,'error'=>false,'message'=>'successfully','items'=>$farmers];
        return response()->json($response,200);
        }
        else{
    
            $response=['success'=>false,'error'=>true,'message'=>'No Kitchen items found'];
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
        
        $usr = User::find($request['id']);
       
       if($usr){
           
       $added_by =  $usr->added_by;
        
        $count=Order::where('added_by', $added_by)->count();
        $pro=$count+1;
        $data['reference_no']= "DGC-ORD-".$pro;
        
        
        $data['client_id']=$request->client_id;
        $data['user_type']=$request->user_type;
        $data['invoice_date']=date('Y-m-d');
        $data['location']=$request->location;
        $data['account_id']=$request->account_id;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
      $data['notes']=$request->notes;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['status']='0';
        $data['good_receive']='0';
        $data['invoice_status']=1;
        $data['added_by']= $added_by;
        
        
        
        // $data['user_id']=$request['user_id'];
        // $data['user_type']=$request['user_type'];
        // $data['invoice_date']= $nowDate;
        // $data['location']=$request['location'];
        // $data['account_id']=$request['account_id'];
        // $data['exchange_code']=$request['exchange_code'];
        // $data['exchange_rate']=$request['exchange_rate'];
        // $data['notes']=$request['notes'];
        
        // $total_cost = $request['quantity'] * $request['price'];
        
        // $subtotal = $total_cost;
  
        //   //purchase_amount
        // $data['invoice_amount'] = $subtotal;
        //   //purchase_tax
        // // $data['invoice_tax'] = $request->total_tax;
        
        // //  $data['invoice_tax'] = 'invoice_tax';
        
        // $tax = 0.18;
        
        // $total_tax  = $tax * $total_cost;
        
        // $data['invoice_tax'] = $total_tax;
        //   //subtotal+total
        // // $data['due_amount'] = $request->due_amount;
        
        // $data['due_amount'] = $data['invoice_amount'] + $data['invoice_tax'];
          
          
        // // $data['invoice_amount']='1';
        // // $data['due_amount']='16678';
        // // $data['invoice_tax']='1';
        
        // $data['status']='0';
        // $data['good_receive']='0';
        // $data['invoice_status']=1;
        
        // $data['added_by']= $added_by;

        $invoice = Order::create($data);
        
        
        
        
                        $iyt = OrderItem::where('invoice_id', $invoice->id)->orderBy('created_at', 'desc')->first();

                        if (!empty($iyt)) {
                            $iy = $iyt->order_no + 1;
                        } else {
                            $iy = 1;
                        }


                        $items23 = array(
                            'type' => $request['type'],
                        'item_name' => $request['item_name'],
                        'quantity' =>   $request['quantity'],
                       'due_quantity' =>   $request['quantity'],
                        'tax_rate' =>  $tax,
                           'price' =>  $request['price'],
                        'total_cost' =>  $total_cost,
                        'total_tax' =>   $total_tax,
                         'items_id' => $request['item_id'],
                         'reference_no' => $invoice->reference_no,
                         'due_amount' => $invoice->due_amount,
                           'order_no' => $iy,
                           'added_by' => $added_by,
                           'invoice_amount' => $invoice->invoice_amount,
                           'invoice_tax' => $invoice->invoice_tax,
                        'invoice_id' =>$invoice->id);
                       
                     $pt =   OrderItem::create($items23);
                     
                  
     
        if($invoice)
        {
           
        
            $response=['success'=>true,'error'=>false, 'message' => 'Order Created successful', 'order' => $invoice];
            return response()->json($response, 200);
        }
        else
        {
            
            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Order Successfully'];
            return response()->json($response,200);
        }
        
    }
            else{
                
                $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Order Cause User ID not found on users table Successfully'];
                return response()->json($response,200);
            }

    }
    
   
    
    public function items_order(Request $request){
        
        
         $this->validate($request,[
            'item_id' => 'required',
            // 'item_name' => 'required',
            'item_name' => 'required',

            'tax_rate' => 'required',

            'price' => 'required',
            'total_cost' => 'required',
            'tax' =>'required',


        ]);
        
        
        $itm = Items::where('id',$request->item_id)->first();

            if(!empty($itm)){

                    $order = Order::find($request->order_id);


                    if (!empty($order)) {
                        $iyt = OrderItem::where('order_id', $order->id)->orderBy('created_at', 'desc')->first();

                        if (!empty($iyt)) {
                            $iy = $iyt->order_no + 1;
                        } else {
                            $iy = 1;
                        }

                        // $d=Items::where('id', $request->item_id)->first();

                        $items23 = array(
                            'type' => $request->type,
                        'item_name' => $request->item_name,
                        'quantity' =>   $request->quantity,
                       'due_quantity' =>   $request->quantity,
                        'tax_rate' =>  $request->tax_rate,
                           'price' =>  $request->price,
                        'total_cost' =>  $request->total_cost,
                        'total_tax' =>   $request->tax,
                         'items_id' => $request->item_id,
                           'order_no' => $iy,
                           'added_by' => $request->id,
                        'invoice_id' =>$invoice->id);
                       
                     $pt =   OrderItem::create($items);

                        // --------------------


                        if ($pt) {

                               

                            $response=['success'=>true,'error'=>false, 'message' => 'Order Created successful', 'order_item' => $pt];
                            return response()->json($response, 200);
                        }
                        else
                        {
                                                
                            $response=['success'=>false,'error'=>true,'message'=>'Failed to  Create Order Successfully'];
                            return response()->json($response,200);
                        }
                    }
                        else
                        {
                            
                            $response=['success'=>false,'error'=>true,'message'=>'Order Not found'];
                            return response()->json($response,200);
                        }
            }
            else{

                $response=['success'=>false,'error'=>true,'message'=>'Order Items not found'];
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
