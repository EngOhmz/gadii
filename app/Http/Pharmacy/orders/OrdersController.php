<?php

namespace App\Http\Controllers\orders;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

use App\Models\orders\Order;
use App\Models\orders\Cost_function;
use App\Models\orders\Transport_quotation;
use App\Models\orders\Quotation_cost;
use App\Models\Payment_methodes;

class OrdersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user_id=auth()->user()->id;
  
        
        $orders=Order::all()->where('status',2);
        //$costs = Cost_function::all()->where('user_id',$user_id);
        $costs = Cost_function::all();
       
        
       return view('orders.orders_list',compact('orders','costs'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status="unconfirmed";
        $user_id=auth()->user()->id;
        $product=Product::all();
        $supply=Supply::all();
        $output =order::where('user_id', "=",$user_id)->where('status', "=", $status)->get();
       
        //$arr = array('msg' => 'Your query has been submitted Successfully, we will contact you soon!', 'status' => true,'userdata'=>$output);
    

    return Response()->json(["userdata"=>$output,"product"=>$product,"supply"=>$supply]);

        //return json_encode(array('data'=>$userData));
    }

    /**
     * Store a newly created resource in storage.
     *dashboard/
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id  = $request->id;
        
        $orders = Order::find($id);
        $order = $orders->toArray();
        
        $order['user_id']= auth()->user()->id;
        $order['status']= '0';


        $quotation = Transport_quotation::create($order);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $savedArr =$request->item_name ;
        
        $cost['amount'] = 0;
        $cost['tax'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['amount'] +=$costArr[$i];
                    $cost['tax'] +=$taxArr[$i];
                    $cost['due_amount'] =$cost['amount'] +  $cost['tax'] ;

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                        'quotation_id' =>$quotation->id);
                       
                        Quotation_cost::create($items);  ;
    
    
                }
            }
            $cost = Transport_quotation::where('id',$quotation->id)->update($cost);
   
        }    

        
        $quotation = Transport_quotation::find($quotation->id);
        

        return view('orders.orders_details',compact('quotation'));


    }

    public function quotationList(){
        $user_id=auth()->user()->id;
        $quotation = Transport_quotation::all();
        $costs = Cost_function::all()->where('user_id',$user_id);

        return view('orders.quotation_list',compact('quotation','costs'));

    }

    public function quotationDetails($id){

        $quotation = Transport_quotation::find($id);
        

        return view('orders.orders_details',compact('quotation'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id=auth()->user()->id;
        $costs = Cost_function::all()->where('user_id',$user_id);
        $type = "add";
        
         return view('orders.orders_list',compact('costs','id','type'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        
    }
    
    public function findPrice(Request $request)
    {
               $price= Price::where('id',$request->id)->get();
                return response()->json($price);	                  

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $user_id=auth()->user()->id;

        $update=order::where('user_id', '=', $id)->update(['status' => 'confirmed']);
          #Display Success Message in Blade File
          $arr = array('msg' => 'Purchased product data saved', 'status' => true);
        return Response()->json($arr);
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$product,$purchase)
    {
        $user_id=auth()->user()->id;
    
        $data=order::find($id);
        $data->delete();
        // if($data)
        // {
        //     $output=order::all();
        //   #Display Success Message in Blade File
        //   $arr = array('msg' => 'Your query has been submitted Successfully, we will contact you soon!', 'status' => true);
        // }
        
        
        $available_stock=Balance::where('product_id','=',$product)->get();
        if(count($available_stock)>0)
        {
             foreach($available_stock as $stk)
             {
                 if($product==$stk->product_id)
                 {
                    $stock=($stk->purchase)-$purchase;
                    $update=Balance::where('product_id', '=', $product)->update(['purchase' => $stock]);
                      
                       
                 }
                 
            
             }
             $arr = array('msg' => 'stock updated', 'status' => true);
                           
                        
             return Response()->json($arr);
        }
        else
        {
            $arr = array('msg' => 'failed to update', 'status' => true);
                            return Response()->json($arr);
        }
  
     
    }


    public function order_payment($id)
    {
        //
        $quotation = Transport_quotation::find($id);
        $payment_method = Payment_methodes::all();
        return view('orders.order_payment',compact('quotation','payment_method'));
    }
}
