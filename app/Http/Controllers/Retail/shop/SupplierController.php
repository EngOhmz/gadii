<?php

namespace App\Http\Controllers\Retail\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Retail\Supplier;
use App\Models\Retail\Activity;
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
        return view('retail.agrihub.manage-supplier')->with("supply",$supply);
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

if(!empty($result)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$result->id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $result->name. "  Created",
                        ]
                        );                      
       }

       return redirect(route('retail_supplier.index'))->with(['success'=>'Supplier Created Successfully']);
     
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
 return view('retail.agrihub.manage-supplier',compact('data','id'));
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
        
        $data=Supplier::find($id);
        $result=$request->all();
        $data->update($result);

     if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $request->name. "  Updated",
                        ]
                        );                      
       }
        return redirect(route('retail_supplier.index'))->with(['success'=>'Supplier Updated Successfully']);
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

         if(!empty($data)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Supplier',
                            'activity'=>"Supplier " .  $data->name. "  Deleted",
                        ]
                        );                      
       }

        $data->delete();
         return redirect(route('retail_supplier.index'))->with(['success'=>'Supplier Deleted Successfully']);
    }
}
