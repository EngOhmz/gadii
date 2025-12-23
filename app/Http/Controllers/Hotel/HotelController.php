<?php

namespace App\Http\Controllers\Hotel;

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
     public function index()
    {
        
        
            
        $hotels = Hotel::where('status',1)->where('added_by', auth()->user()->added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        $items = HouseType::where('added_by', 1)->get();
        
        $room = RoomType::where('added_by', auth()->user()->added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        return view('hotel.items.home',compact('items','hotels','room'));
         
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
  
        $count=Hotel::where('added_by', auth()->user()->added_by)->count();
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
        $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;
        //dd($data);

        $invoice = Hotel::create($data);
    
    
        $nameArr =$request->room_name ;
        $descArr =$request->description ;
        $toilArr = $request->toilet  ;
        $priceArr = $request->price;
        $typArr = $request->room_type ;
        $srvArr = $request->service  ;


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    
                    $items = array(
                        'name' => $nameArr[$i],
                          'description' =>$request->notes,
                        'toilet' =>   $toilArr[$i],
                       'service' =>   $request->offers,
                        'room_type' =>  $typArr[$i],
                        'room_status' =>  1,
                           'price' =>  $priceArr[$i],
                           'user_id' => auth()->user()->id,
                           'added_by' => auth()->user()->added_by,
                        'hotel_id' =>$invoice->id);
                       
                        HotelItems::create($items);  ;
    
    
                }
            }
            
        } 
        
        
        return redirect(route('hotel.index'))->with(['success'=>'Created Successfully']);
        
        

    }
    
    
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //
    //     $invoices = Invoice::find($id);
    //     $invoice_items=InvoiceItems::where('invoice_id',$id)->where('due_quantity','>', '0')->get();
    //     $payments=InvoicePayments::where('invoice_id',$id)->get();
        
    //     return view('pos.sales.invoice_details',compact('invoices','invoice_items','payments'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
               
        $data = Hotel::find($id);
        
        $hotel_items = HotelItems::where('hotel_id',$id)->get();
         
        $hotels = Hotel::where('status',1)->where('added_by', auth()->user()->added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        $items = HouseType::where('added_by', 1)->get();
        
        $room = RoomType::where('added_by', auth()->user()->added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        
        return view('hotel.items.home',compact('id','data', 'hotel_items', 'items', 'hotels','room'));
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
        $invoice = Hotel::find($id);
        
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
        $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;
        

        $invoice->update($data);
    
    
        $nameArr =$request->room_name ;
        $descArr =$request->description ;
        $toilArr = $request->toilet  ;
        $priceArr = $request->price;
        $typArr = $request->room_type ;
        $srvArr = $request->service  ;
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        
        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                 HotelItems::where('id',$remArr[$i])->delete();        
                   }
               }
           }


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    
                    $items = array(
                        'name' => $nameArr[$i],
                          'description' =>$request->notes,
                        'toilet' =>   $toilArr[$i],
                       'service' =>   $request->offers,
                        'room_type' =>  $typArr[$i],
                        'room_status' =>  1,
                           'price' =>  $priceArr[$i],
                           'user_id' => auth()->user()->id,
                           'added_by' => auth()->user()->added_by,
                        'hotel_id' =>$invoice->id);
                       
                        // HotelItems::create($items);  ;
                        
                        if(!empty($expArr[$i])){
                            HotelItems::where('id',$expArr[$i])->update($items);  
      
                          }
                          else{
                            HotelItems::create($items);   
                          }
    
    
                }
            }
            
        } 

        return redirect(route('hotel.index'))->with(['success'=>'Updated Successfully']);

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
