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
class WarehouseController extends Controller
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
        $warehouse =Warehouse::all();
        $user=User::all();
        $insurance=Insurance::all();
        $group=USer::find($user_id)->group;
        
        return view('warehouses.manage-warehouse')->with('insurances',$insurance)->with('warehouse',$warehouse)->with('farmer',$warehouse)->with('users',$user);
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

    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warehouse =Warehouse::find($id);
        if(!empty($warehouse))
        {
        return view('warehouses.manage-single-warehouse',compact('warehouse'));

        }
        else
        {
            return abort(404);
        }
  
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