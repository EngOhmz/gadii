<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\GoodReallocation;
use App\Models\Inventory;
use App\Models\InventoryList;
use App\Models\Truck;
use Illuminate\Http\Request;

class GoodReallocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inventory= Inventory::all();
        $staff=FieldStaff::all();
        $truck=Truck::all();
        $reallocation= GoodReallocation::all();
       return view('inventory.good_reallocation',compact('reallocation','inventory','staff','truck'));
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
        //

        $data = $request->all();
        $data['added_by']=auth()->user()->id;
  
        $reallocation=GoodReallocation::create($data);
       
        return redirect(route('good_reallocation.index'))->with(['success'=>'Good Reallocation  Created Successfully']);
      
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
        $inventory= Inventory::all();
        $staff=FieldStaff::all();
        $truck=Truck::all();
        $data= GoodReallocation::find($id);
      $list= InventoryList::where('truck_id',$data->source_truck)->where('status','1')->get();
        $dest_list= InventoryList::where('truck_id',$data->destination_truck)->where('status','1')->get();
       return view('inventory.good_reallocation',compact('data','inventory','staff','truck','id','list','dest_list'));
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
        $reallocation =GoodReallocation::find($id);

        $data = $request->all();       
        $reallocation->update($data);
       
        return redirect(route('good_reallocation.index'))->with(['success'=>'Good Reallocation  Updated Successfully']);
     
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
        $reallocation =  GoodReallocation::find($id);
        $reallocation->delete();

        return redirect(route('good_reallocation.index'))->with(['success'=>'Good Reallocation  Deleted Successfully']);
    }

    public function approve($id){
        //
        $item =  GoodReallocation::find($id);
        $data['status'] = 1;
       $item->update($data);
        
      InventoryList::where('id',$item->source_item)->update(['truck_id' => $item->destination_truck]);
    

       if(!empty($item->destination_item)){
        $list['truck_id']=NULL;
        $list['status']='2';
        InventoryList::where('id',$item->destination_item)->update($list);
    
        $name= InventoryList::where('id',$item->destination_item)->first();

        $inv= Inventory::where('id',$name->brand_id)->first();
        $q=$inv->quantity + 1;
        Inventory::where('id',$name->brand_id)->update(['quantity' => $q]);
       }


     
 
        return redirect(route('good_reallocation.index'))->with(['success'=>'Item Reallocation Approved Successfully']);
    }

}
