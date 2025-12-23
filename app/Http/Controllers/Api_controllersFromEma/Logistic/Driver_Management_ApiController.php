<?php

namespace App\Http\Controllers\Api_controllers\Logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Driver;
class Driver_Management_ApiController extends Controller
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
        $drivers=Driver::where('added_by',$user_id)->get();
        $response=['success'=>true,'error'=>false,'message'=>'successfully','drivers'=>$drivers];
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
        
       //

       $this->validate($request,[
        'profile' => 'image|required|max:1999',
    ]);

     //handle file upload
     if($request->hasFile('profile')){
        $filenameWithExt=$request->file('profile')->getClientOriginalName();
        $filename=pathinfo($filenameWithExt,PATHINFO_FILENAME);
        $extension=$request->file('profile')->getClientOriginalExtension();
        $fileNameToStore=$filename.'_'.time().'.'.$extension;
        $path=$request->file('profile')->storeAs('public/assets/img/driver',$fileNameToStore);
    }

    $data['driver_name']=$request->driver_name;
    $data['address']=$request->address;
    $data['referee']=$request->referee;
    $data['experience']=$request->experience;
    $data['driver_status']=$request->driver_status;
    $data['profile']=$fileNameToStore;
    $data['added_by']=auth()->user()->id;
    $driver= Driver::create($data);

    if($driver){
        $response=['success'=>true,'error'=>false,'message'=>'Driver Registered Successfully','driver'=>$driver];
        return response()->json($response,200);
    }else{
        $response=['success'=>false,'error'=>true,'message'=>'Registering Driver Fail'];
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