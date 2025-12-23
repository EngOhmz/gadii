<?php

namespace App\Http\Controllers\Api_controllers\MazaoHub\Farmer\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use App\Models\Supplier;
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
        
        $user_id=auth()->user()->id;
        $supply=Supplier::all();
        //$supply=User::find($user_id)->supply;
        //print_r($supply);
        return view('agrihub.manage-supplier')->with("supply",$supply)->with('supply2',$supply);
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
            'TIN'=>'required'
        ]); 
        
           
        $data=$request->all();
        $data['user_id']=auth()->user()->id;
        $result=Supply::create($data);
        if($result)
        {
            $messagev="Successful Added'";
            return redirect('manage/supplier')->with('messagev',$messagev);
        }
        else
        {
            $messager="Successful Added'";
            return redirect('manage/supplier')->with('messagev',$messager);
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
            'TIN'=>'required'
        ]); 
        $user=User::find($user_id);
        $farmer=Supply::find($id);
        $result=$request->all();
        $data->update($result);
        if($data)
        {
            $messagev="Success Updated'";
            return redirect('manage/supplier')->with('messagev',$messagev);
        }
        else
        {
            $messager="Sorry Failed to update";
            return redirect('manage/supplier')->with('messager',$messager);
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
        $data=Supply::find($id);
        $data->delete();
        if($data)
        {
            $messagev="Success Deleted'";
            return redirect('manage/supplier')->with('messagev',$messagev);
        }
    }
}
