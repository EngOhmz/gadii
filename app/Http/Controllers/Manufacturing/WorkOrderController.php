<?php

namespace App\Http\Controllers\Manufacturing;

use App\Http\Controllers\Controller;
use App\Models\Manufacturing\WorkOrder;
use App\Models\Manufacturing\Inventory;
use App\Models\Manufacturing\Issue;
use App\Models\Manufacturing\Location;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $work_order= WorkOrder::all();
        
        $location = Location::all()->where('store_type',3);
           $item = Inventory::all()->where('product_type',1);
      
        return view('manufacturing.work_order',compact('work_order','item','location'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $work_order= WorkOrder::all();
        
        $location = Location::all()->where('store_type',3);
        $item = Inventory::all()->where('product_type',1);
      
        return view('manufacturing.work_order_details',compact('work_order','item','location'));
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

        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $work_order = WorkOrder::create($data);
 
        return redirect(route('work_order.index'))->with(['success'=>'Work Order Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
   {
        $location = Location::all()->where('store_type',3);
        $work_centre = Location::all()->where('store_type',1);
       switch ($request->type) {
        case 'show':
               
                return view('manufacturing.issue',compact('id','location','work_centre'));
                break;
         default:
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
        //
        $data =  WorkOrder::find($id);
        return view('manufacturing.work_order',compact('data','id'));
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
        $work_order =  WorkOrder::find($id);
        $data=$request->post();
        $data['added_by']=auth()->user()->id;
        $work_order->update($data);
 
        return redirect(route('work_order.index'))->with(['success'=>'Work Order Updated Successfully']);
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
        $work_order =  WorkOrder::find($id);
        $work_order->delete();
 
        return redirect(route('work_order.index'))->with(['success'=>'Work Order Deleted Successfully']);
    }
    
    public function issue(Request $request,$id){
        
        $data = $request->all();
        $data['added_by']=auth()->user()->id;
        Issue::create($data);
        
        $work_order =  WorkOrder::find($id);
        
        $data2['status']=1;
        $work_order->update($data2);
        
    return redirect(route('work_order.index'))->with(['success'=>'Work Issued Successfully']);
    }

}
