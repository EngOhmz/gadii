<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\GoodReturn;
use App\Models\GoodReturnItem;
use App\Models\Inventory;
use App\Models\InventoryList;
use App\Models\Location;
use App\Models\Maintainance;
use App\Models\Service;
use App\Models\Truck;
use Illuminate\Http\Request;

class GoodReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $inventory= Inventory::where('added_by',auth()->user()->added_by)->get();
        $staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();
      $location=Location::where('added_by',auth()->user()->added_by)->get();
        $truck=Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get();
        $return= GoodReturn::where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_return',compact('return','inventory','staff','location','truck'));
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
        $name=InventoryList::find($request->item_id);
        $data['date']=$request->date;
        $data['staff']=$request->staff;
        $data['location']=$name->location;
        $data['truck']=$request->truck;
       $data['item_id']=$request->item_id;

        $data['added_by']= auth()->user()->added_by;

        $return = GoodReturn::create($data);
        
       

        return redirect(route('good_return.index'))->with(['success'=>'Good Return Created Successfully']);
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
        $data=GoodReturn::find($id);
         $items=GoodReturnItem::where('return_id',$id)->get();
         $inventory= Inventory::where('added_by',auth()->user()->added_by)->get();
        $staff=FieldStaff::where('added_by',auth()->user()->added_by)->get();
      $location=Location::where('added_by',auth()->user()->added_by)->get();
        $truck=Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get(); 
      $list=InventoryList::where('truck_id',$data->truck)->where('status','1')->where('added_by',auth()->user()->added_by)->get();
       return view('inventory.good_return',compact('items','inventory','data','id','staff','location','truck','list'));
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

        $return=GoodReturn::find($id);

        $name=InventoryList::find($request->item_id);
        $data['date']=$request->date;
        $data['staff']=$request->staff;
        $data['location']=$name->location;
          $data['truck']=$request->truck;
       $data['item_id']=$request->item_id;


        $return->update($data);
        
       

      
        return redirect(route('good_return.index'))->with(['success'=>'Good Return Updated Successfully']);
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

        GoodReturnItem::where('return_id', $id)->delete();

        $return=  GoodReturn::find($id);
        $return->delete();

        return redirect(route('good_return.index'))->with(['success'=>'Good Return Deleted Successfully']);
    }

    public function findService(Request $request)
    {

    $price= InventoryList::where('truck_id',$request->id)->where('status','1')->get();
                return response()->json($price);

}
    
 public function approve($id){
        //
        $return =  GoodReturn::find($id);
        $data['status'] = 1;
        $return->update($data);

        $name=InventoryList::where('id',$return->item_id)->first();
        $list['truck_id']=NULL;
        $list['status']='2';
      InventoryList::where('id',$return->item_id)->update($list);
        
        
        $inv= Inventory::where('id',$name->brand_id)->first();
        $q=$inv->quantity + 1;
       Inventory::where('id',$name->brand_id)->update(['quantity' => $q]);

        return redirect(route('good_return.index'))->with(['success'=>'Return of Item Approved Successfully']);
    }


}
