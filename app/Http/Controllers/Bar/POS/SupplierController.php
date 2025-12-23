<?php

namespace App\Http\Controllers\Bar\POS;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Bar\POS\Supplier as POSSupplier;
use App\Models\Bar\POS\Activity;
use App\Models\User;


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
        
        $supply=POSSupplier::where('user_id',auth()->user()->added_by)->get();
        return view('bar.pos.supplier.manage-supplier')->with("supply",$supply);
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
        $result=POSSupplier::create($data);

if(!empty($result)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
'user_id'=>auth()->user()->id,
                            'module_id'=>$result->id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $result->name. "  Created",
                        ]
                        );                      
       }


       return redirect(route('store_pos_supplier.index'))->with(['success'=>' Supplier Created Successfully']);
     
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
 $data=POSSupplier::find($id);
 return view('bar.pos.supplier.manage-supplier',compact('data','id'));
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
        
        $data=POSSupplier::find($id);
        $result=$request->all();
        $data->update($result);

if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $request->name. "  Updated",
                        ]
                        );                      
       }

       return redirect(route('store_pos_supplier.index'))->with(['success'=>' Supplier Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data=POSSupplier::find($id);
        $data->delete();

if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $data->name. "  Deleted",
                        ]
                        );                      
       }

         return redirect(route('store_pos_supplier.index'))->with(['success'=>' Supplier Deleted Successfully']);
    }
}
