<?php

namespace App\Http\Controllers\Api_controllers;;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Warehouse;
use App\Models\Insurance;
use App\Models\User;
use App\Models\Farmer_account;
use App\Models\Deposite_withdraw;
use App\Models\Crops_type;
use App\Models\Group;
use App\Models\orders\Order;
use App\Models\Region;
class Home_ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions=Region::with(['districts'])->get();
        $accounts = Farmer_account::groupBy('warehouse_id','crops_type_id')->selectRaw('sum(total_quantity) as total_quantity, warehouse_id,crops_type_id')->with(['crops_type','warehouse'=>function($warehouse){
            $warehouse->with('region','district');
        }])->where('total_quantity', ">", 0)->get();
        return response()->json(["regions"=>$regions,"accounts"=>$accounts]);
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
        
        // $this->validate($request,[
        //     'warehouse_id'=>'required',
        //     'quantity'=>'required',
        //     'user_id'=>'required',
        //     'client_id'=>'required',
        //     'offer_amount'=>'required',
        //     'crop_type'=>'required',
        //     'start_location'=>'required',
        //     'end_location'=>'required',
        //     'route_type'=>'requied',
        //     'status'=>'required'
        // ]); 
        // $user_id=auth()->user()->id;
        // $order= new Order();
        // $order->warehouse_id=$request->input('warehouse_id');
        // $order->quantity=$request->input('quantity');
        // $order->client_id=$user_id;
        // $order->user_id=0;
        // $order->offered_amount=$request->input('offer_amount');
        // $order->crop_type=$request->input('crop_type');
        // $order->start_location=$request->input('start_location');
        // $order->end_location=$request->input('end_location');
        // $order->route_type=1;
        // $order->status=1;
        // $order->save();
        // if($order)
        // {
        //     return response()
        //     ->json(" Order created successfull");
        // }
        // else
        // {
        //     return ;
        // }

      
    }
    
    
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $orders =Order::with('crop_types','user','warehouse')->where('warehouse_id', "=", $id)->get();
        // if($orders)
        // {
        // return response()
        // ->json($orders);
        // }
        // else
        // {
        //     return ;
        // }
        
    } 
    
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      
      
        
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
       
        $user_id=auth()->user()->id;
        $order= Order::find($id);
        $order->user_id=$user_id;
        $order->logistic_id=$user_id;
        $order->status=2;
        $order->update();
        if($order){
            return response()
            ->json(" Order updated successfuly");
        }
        else{
            return response()
            ->json(" Order updated fail");
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
       
    }
}