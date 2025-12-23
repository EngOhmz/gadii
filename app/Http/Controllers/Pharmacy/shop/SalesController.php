<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Grocery;
use App\Models\Supplier1;
use App\Models\User;
use App\Models\Product;
use App\Models\order;
use App\Models\Balance;
use App\Models\Items;
use App\Models\Farmer;
use App\Models\Currency;
use App\Models\Sales_items;
use App\Models\Sales;
class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user_id=auth()->user()->id;
        //$confirmed="confirmed";
        $product=User::find($user_id)->product;
        $farmer=User::find($user_id)->farmer;
        $sales=Sales::all()->where('user_id',$user_id);
        $currency = Currency::all();
        
        $name = Items::all();
        
       return view("sales.manage_sales",compact('name','farmer','currency','sales'));
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
        $farmer=User::find($user_id)->farmer;
        $output =Sale::where('user_id', "=",$user_id)->where('status', "=", $status)->get();
       
        

    return Response()->json(["userdata"=>$output,"product"=>$product,"farmer"=>$farmer]);

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
        
        $data['reference_no']=$request->reference_no;
        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        $data['due_date']=$request->due_date;
        $data['currency_code']=$request->currency_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['user_id']= auth()->user()->id;

        $sales = Sales::create($data);
        
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
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];

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
                        'invoice_id' =>$sales->id);
                       
                     Sales_items::create($items);  ;
    
    
                }
            }
            $cost['reference_no']= "INV-".$sales->id."-".$data['invoice_date'];
            $cost['due_amount'] =  $cost['invoice_amount'];
            Sales::where('id',$sales->id)->update($cost);
        }    

        
        $sales = Sales::find($sales->id);
        

        return view('sales.sales_details',compact('sales'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales = Sales::find($id);
        

        return view('sales.sales_details',compact('sales'));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        
        $update=Sale::where('user_id', '=', $id)->update(['status' => 'confirmed']);
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
    public function destroy($id,$product,$sale)
    {
        $user_id=auth()->user()->id;
    
        $data=Sale::find($id);
        $data->delete();
       
        
        $available_stock=Balance::where('product_id','=',$product)->get();
        if(count($available_stock)>0)
        {
             foreach($available_stock as $stk)
             {
                 if($product==$stk->product_id)
                 {
                    $stock=($stk->purchase)+$sale;
                    $new_sales=($stk->similar_text)-$sale;
                    $update=Balance::where('product_id', '=', $product)->update(['purchase' => $stock,'sale'=>$new_sales]);
                      
                       
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
}
