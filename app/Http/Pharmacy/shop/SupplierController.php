<?php

namespace App\Http\Controllers\Pharmacy\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Pharmacy\Supplier;
//use App\Models\FarmLand;

class SupplierController extends Controller
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
        
        $supply=Supplier::where('user_id',auth()->user()->added_by)->get();
        return view('pharmacy.agrihub.manage-supplier')->with("supply",$supply);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data= new Supply();
        $this->validate($request,[
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
            
        ]); 
        
           
        $data=$request->all();
        $data['user_id']=auth()->user()->added_by;
        $result=Supplier::create($data);
       return redirect(route('pharmacy_supplier.index'))->with(['success'=>'Supplier Created Successfully']);
     
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
 $data=Supplier::find($id);
 return view('pharmacy.agrihub.manage-supplier',compact('data','id'));
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
        
        $this->validate($request,[
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required',
           
        ]); 
        
        $data=Supplier1::find($id);
        $result=$request->all();
        $data->update($result);
        return redirect(route('pharmacy_supplier.index'))->with(['success'=>'Supplier Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=Supplier::find($id);
        $data->delete();
         return redirect(route('pharmacy_supplier.index'))->with(['success'=>'Supplier Deleted Successfully']);
    }
}
