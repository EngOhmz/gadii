<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\FieldStaff;
use App\Models\GoodDisposal;
use App\Models\Inventory;
use App\Models\InventoryList;
use Illuminate\Http\Request;

class GoodDisposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inventory=InventoryList::where('status','0')->orwhere('status','2')->get();
        $staff=FieldStaff::all();
        $disposal= GoodDisposal::all();
       return view('inventory.good_disposal',compact('disposal','inventory','staff'));
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
        $disposal= GoodDisposal::create($data);  
    
        return redirect(route('good_disposal.index'))->with(['success'=>'Good Disposal Created Successfully']);
      
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
        $inventory= InventoryList::where('status','0')->orwhere('status','2')->get();
        $staff=FieldStaff::all();
        $data= GoodDisposal::find($id);
       return view('inventory.good_disposal',compact('data','inventory','staff','id'));
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
        $disposal=GoodDisposal::find($id);

        $data = $request->all();
        $disposal->update($data);
       
        return redirect(route('good_disposal.index'))->with(['success'=>'Good Disposal Updated Successfully']);
       
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
        $disposal=GoodDisposal::find($id);
        $disposal->delete();

        return redirect(route('good_disposal.index'))->with(['success'=>'Good Disposal Deleted Successfully']);
    }

   public function approve($id)
    {
        //

        $disposal = GoodDisposal::find($id);
        $data['status'] = 1;
        $disposal->update($data);


        $name=InventoryList::where('id', $disposal->item_id)->first();
        $inv=Inventory::where('id',$name->brand_id)->first();
        $q=$inv->quantity - 1;
       Inventory::where('id',$name->brand_id)->update(['quantity' => $q]);

      InventoryList::where('id', $disposal->item_id)->update(['status' => '3']);

     

       
        return redirect(route('good_disposal.index'))->with(['success'=>'Good Disposal Approved Successfully']);
    }

}
