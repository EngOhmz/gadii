<?php

namespace App\Http\Controllers\warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Warehouse;
use App\Models\Insurance;
use App\Models\User;
use App\Models\Farmer_account;
use App\Models\Deposite_withdraw;
use App\Models\Crops_type;
use App\Models\Group;
use App\Models\Region;
use App\Models\District;
class Warehouse_backendController extends Controller
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
        $warehouse =Warehouse::with(['user','region','district'])->where('added_by',$user_id)->get();
        $region=Region::with(['districts'])->get();
        $district=District::all();
        $user=User::all();
        $insurance=Insurance::all();
        $data=['insurances'=>$insurance,'warehouse'=>$warehouse,'users'=>$user,'user_id'=>$user_id,'regions'=>$region,'districts'=>$district];
            return response()
            ->json($data);
        
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
        

        $user_id =auth()->user()->id;
         if($request->input('type')=="addInsurance"){
        $this->validate($request,[
            'insurancename'=>'required',
            'insuranceamount'=>'required',
            'assetvalue'=>'required',
            'insurancetype'=>'required',
            'coveringage'=>'required',
            'startdate'=>'required',
            'enddate'=>'required'
        ]); 
        
        //$data=$this->request();
        //$farmer= Farmer::create($data);
      
        $insurance= new Insurance();

        $insurance->insurance_name=$request->input('insurancename');
        $insurance->insurance_amount=$request->input('insuranceamount');
        $insurance->asset_value=$request->input('assetvalue');
        $insurance->insurance_type=$request->input('insurancetype');
        $insurance->cover_age=$request->input('coveringage');
        $insurance->start_date=$request->input('startdate');
        $insurance->end_date=$request->input('enddate');
        $insurance->save();
        if($insurance)
        {
            $message="New insurance is registered successful";
            return response()
            ->json(['message'=>$message]);
        }
        else
        {
            $message="Failed to register new insurance";
            return response()
            ->json(['message'=>$message])->with('error',$message);
        }
    }


    if($request->input('type')=="addWarehouse"){
         // $this->validate($request,[
        //     'warehousename'=>'required',
        //     'region_id'=>'required',
        //     'district_id'=>'required',
        //     'insurence'=>'required',
        //     'managercontact'=>'required',
        //     'warehousemanager'=>'required'
        // ]); 
        
        //$data=$this->request();
        //$data['user_id'] =auth()->user()->id;
        //$farmer= Farmer::create($data);
      
        $warehouse= new Warehouse();
        $warehouse->warehouse_name=$request->input('warehousename');
        $warehouse->region_id=$request->input('region_id');
        $warehouse->district_id=$request->input('district_id');
        $warehouse->added_by=$user_id;
        $warehouse->warehouse_manager=$request->input('warehousemanager');
        $warehouse->insurance_id=$request->input('insurence');
        $warehouse->manager_contact=$request->input('managercontact');
        $warehouse->save();
        if($warehouse)
        {
            $message="New warehouse registered successful";
            return response()
            ->json(['message'=>$message]);
        }
        else
        {
            $message="Failed to register new warehouse";
            return response()
            ->json(['message'=>$message]);
        }

    }


       
    }
    
    
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {

        $user_id=auth()->user()->id;
        if($request->input('require')=="accounts_data"){
        $history=Deposite_withdraw::with([
            'farmer_account' => function($query){
                $query->with(['farmer', 'crops_type', 'warehouse']);
            }
            ])->where('warehouse_id',$id)->get();
        $crops_types=Crops_type::all();
        $farmers=Farmer::all();
        $accounts=Farmer_account::with(['farmer','crops_type'])->where('warehouse_id',$id)->get();
        $accounts_data=['id'=>$id,'history'=>$history,'crops_types'=>$crops_types,'farmers'=>$farmers,'accounts'=>$accounts];
        return response()
        ->json($accounts_data);
        }
        // $order =order::with('crop_types','user','warehouse')->where('warehouse_id', "=", $id)->get();
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