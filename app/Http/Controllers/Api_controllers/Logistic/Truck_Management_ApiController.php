<?php

namespace App\Http\Controllers\Api_controllers\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Driver;
class Truck_Management_ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $user_id=auth()->user()->id;
        $trucks = Truck::with(['driver'])->where('added_by',$user_id)->get(); 
        $drivers=Driver::all();
        $response=['success'=>true,'error'=>false,'message'=>'successfully','trucks'=>$trucks,'drivers'=>$drivers];
        return response()->json($response,200);
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
        
         $data = $request->all();
         $driver=Driver::where('id',$request->driver)->first();
         $data['driver_status']=$driver->driver_status;
         $data['added_by']=auth()->user()->id;
         $truck= Truck::create($data);
         if($truck){
            $response=['success'=>true,'error'=>false,'message'=>'Truck Registered Successfully','truck'=>$truck];
            return response()->json($response,200);
         }else{
            $response=['success'=>false,'error'=>true,'message'=>'Truck Registered Failed'];
            return response()->json($response,400);
         }
        
         
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