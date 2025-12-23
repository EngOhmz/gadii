<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\purchase;
use App\Models\Supplier1;
use App\Models\User;
use App\Models\Product;
use App\Models\order;
use App\Models\Balance;
use App\Models\Items;
use App\Models\Currency;

use App\Models\Purchase_items;
class PurchaseController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user_id=auth()->user()->id;
        $currency= Currency::all();
        $product=User::find($user_id)->product;
        $purchases=purchase::all()->where('user_id',$user_id);
        $supplier=Supplier1::all()->where('user_id',$user_id);
       // $name = Items::all()->where('user_id',$user_id);
        $name = Items::all();
       return view('purchase.manage_purchase',compact('name','supplier','currency','purchases'));
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
        
        $data['reference_no']=$request->reference_no;
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['currency_code']=$request->currency_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['user_id']= auth()->user()->id;

        $purchase = purchase::create($data);
        
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
        
        $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];

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
                        'purchase_id' =>$purchase->id);
                       
                     Purchase_items::create($items);  ;
    
    
                }
            }
            $cost['reference_no']= "PUR-".$purchase->id."-".$data['purchase_date'];
            $cost['due_amount'] =  $cost['purchase_amount'];
            purchase::where('id',$purchase->id)->update($cost);
        }    

        
        $purchases = purchase::find($purchase->id);
        

        return view('purchase.purchase_details',compact('purchases'));


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchases = purchase::find($id);
        

        return view('purchase.purchase_details',compact('purchases'));
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
               $price= Items::where('id',$request->id)->get();
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
}
