<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\UserDetails\BasicDetails;
use App\Models\UserDetails\BankDetails;


class UserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $type = Session::get('success');
        if(empty($type))
        $type = "basic";

        $basic_details = auth()->user()->basic_details;
        $bank_details = auth()->user()->bank_details;
        return view('user_details.index',compact('type','basic_details','bank_details'));
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
        $type = $request->type;
        $id = auth()->user()->id;
        $data = $request->except('type','_token','_method');
        $data['user_id'] = $id;
         if($type == "basic"){ 
        $detail = BasicDetails::all()->where('user_id',$id);
        if(count($detail) > 0)
        $basic = BasicDetails::where('user_id',$id)->update($data);
        else
        $basic = BasicDetails::create($data);
        }elseif($type == "bank"){
            $detail = BankDetails::all()->where('user_id',$id);
            if(count($detail) > 0)
            $basic = BankDetails::where('user_id',$id)->update($data);
            else
            $basic = BankDetails::create($data);
        }

        return redirect(route('user_details.index'))->with(['success'=>$type]);
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
        //
       
        
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
    }
}
