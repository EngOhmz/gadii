<?php

namespace App\Http\Controllers\farming;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Cost_centre;
use App\Models\Farmer;
use App\Models\Items2;
use App\Models\farming\Farming_Costing;
use App\Models\farming\Farming_Costing_Details;

class Farming_costController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       
       
       
       
       
        $name = Items2::all();
         


     
        $farmer = Farmer::all();
          $costs = Cost_centre::all();
          $currency = Currency::all();
        return view('farming_cost.manage_farming_cost',compact('farmer','costs','currency','name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
          $data = Farming_Costing::find(4);
        
         $id = 1;
         $name = Items2::all();
        $farmer = Farmer::all();
          $costs = Cost_centre::all();
          $currency = Currency::all();
        return view('farming_cost.manage_farming_cost',compact('farmer','costs','currency','name','id','data'));
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
        
        $data['farmer_id']=$request->farmer_id;
        $data['farm_id']=$request->farm_id;
       
        $data['user_id']= auth()->user()->id;

        $purchase = Farming_Costing::create($data);
        
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
                        'farming_cost_id' =>$purchase->id);
                       
                     Farming_Costing_Details::create($items);  ;
    
    
                }
            }
            
           
        }    

        
        $data = Farming_Costing::find($purchase->id);
        
         $id = $purchase->id;
         $name = Items::all();
        $farmer = Farmer::all();
          $costs = Cost_centre::all();
          $currency = Currency::all();
        return view('farming_cost.manage_farming_cost',compact('farmer','costs','currency','name','id','data'));
        
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
    }
}
