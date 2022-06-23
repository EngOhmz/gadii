<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Warehouse;
use App\Models\Insurance;
use App\Models\User;
use App\Models\Farmer_account;
use App\Models\Deposite_withdraw;
use App\Models\Crops_type;
use App\Models\Group;
class Client_OrderController extends Controller
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
        // $user_id=auth()->user()->id;
        // $warehouse =Warehouse::all();
        // $user=User::all();
        // $insurance=Insurance::all();
        // $group=USer::find($user_id)->group;
        $data = Farmer_account::all()->groupBy("warehouse_id")->groupBy("crops_type_id");
        
        return view('orders.client_order',compact('data'));
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
        
        $this->validate($request,[
            'warehousename'=>'required',
            'warehouselocation'=>'required',
            'warehouseowner'=>'required',
            'warehousemanager'=>'required'
        ]); 
        
        //$data=$this->request();
        //$data['user_id'] =auth()->user()->id;
        //$farmer= Farmer::create($data);
      
        $warehouse= new Warehouse();

        $warehouse->warehouse_name=$request->input('warehousename');
        $warehouse->warehouse_location=$request->input('warehouselocation');
        $warehouse->warehouse_owner=$request->input('warehouseowner');
        $warehouse->warehouse_manager=$request->input('warehousemanager');
        $warehouse->insurance_id=$request->input('insurance');
        $warehouse->manager_contact=$request->input('managercontact');
        $warehouse->save();
        if($warehouse)
        {
            $messagev="New warehouse registered successful'";
            return redirect('/warehouse')->with('messagev',$messagev);
        }
        else
        {
            $messager="Failed to register new warehouse'";
            return redirect('/warehouse')->with('messager',$messager);
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