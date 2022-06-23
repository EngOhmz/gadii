<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\Cotton\Levy;
use App\Models\AccountCodes;
use Illuminate\Http\Request;

class LevyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $inventory= Levy::all();
       $levy= AccountCodes::where('account_group','Levy')->get();
        return view('cotton.levy',compact('inventory','levy'));
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

        $data=$request->post();
               $levy= AccountCodes::where('account_id',$request->account_id)->first();
              $data['name']= $levy->account_name;
        $data['added_by']=auth()->user()->id;
        $inventory = Levy::create($data);
 
        return redirect(route('levy_list.index'))->with(['success'=>'Item Created Successfully']);
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
        $data =  Levy::find($id);
           $levy= AccountCodes::where('account_group','Levy')->get();
        return view('cotton.levy',compact('data','id','levy'));
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
        $inventory =  Levy::find($id);
       $data=$request->post();
         $levy= AccountCodes::where('account_id',$request->account_id)->first();
          $data['name']= $levy->account_name;
        
        $data['added_by']=auth()->user()->id;
        $inventory->update($data);
 
        return redirect(route('levy_list.index'))->with(['success'=>'Item Updated Successfully']);
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
        $inventory =  Levy::find($id);
        $inventory->delete();
 
        return redirect(route('levy_list.index'))->with(['success'=>'Item Deleted Successfully']);
    }
}
