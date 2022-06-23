<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\GoodMovement;
use App\Models\Inventory;
use App\Models\Location;
use Illuminate\Http\Request;

class GoodMovementController extends Controller
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
        $location=Location::all();
        $movement= GoodMovement::all();
       return view('inventory.good_movement',compact('movement','inventory','staff','location'));
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
     if(($request->source_location == $request->destination_location)){  
    return redirect(route('good_movement.index'))->with(['error'=>'You have chosen the same location']);

}

else{
        $data = $request->all();
        $data['added_by']=auth()->user()->id;

        $inv=Inventory::where('id',$request->item_id)->first();
 
        if(($request->quantity <= $inv->quantity)){  
        $movement= GoodMovement::create($data);
        return redirect(route('good_movement.index'))->with(['success'=>'Good Movement Created Successfully']);
        }

        else{
            return redirect(route('good_movement.index'))->with(['error'=>'You have exceeded the Quantity']);
        }
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
        $location=Location::all();
        $data= GoodMovement::find($id);
       return view('inventory.good_movement',compact('data','inventory','staff','location','id'));
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
        $movement=GoodMovement::find($id);

     if(($request->source_location == $request->destination_location)){  
    return redirect(route('good_movement.index'))->with(['error'=>'You have chosen the same location']);

}

else{
        $data = $request->all();
        $data['added_by']=auth()->user()->id;

        $inv=Inventory::where('id',$request->item_id)->first();
 
        if(($request->quantity <= $inv->quantity)){  
        $movement->update($data);
        return redirect(route('good_movement.index'))->with(['success'=>'Good Movement Updated Successfully']);
        }

        else{
            return redirect(route('good_movement.index'))->with(['error'=>'You have exceeded the Quantity']);
        }
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
        //
        $movement =  GoodMovement::find($id);
        $movement->delete();

        return redirect(route('good_movement.index'))->with(['success'=>'Good Movement  Deleted Successfully']);
    }

 public function approve($id)
    {
        //
        $movement =  GoodMovement::find($id);
        $list['status']='1';
        $movement->update($list);
 
    
      $inv=Inventory::where('id', $movement->item_id)->first();
  
        $q=$inv->quantity - $movement->quantity;
        Inventory::where('id', $movement->item_id)->update(['quantity' => $q]);

        return redirect(route('good_movement.index'))->with(['success'=>'Good Movement Approved Successfully']);
    }

}
