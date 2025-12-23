<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\UserDetails\BasicDetails;
use App\Models\UserDetails\BankDetails;
use App\Models\UserDetails\SalaryDetails;

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
        $data = $request->except('type','_token','_method');
        $data['added_by'] = auth()->user()->added_by;
         if($type == "basic"){ 
        $detail =BasicDetails::where('user_id',$request->user_id)->first();
        if(!empty($detail))
        $basic = BasicDetails::where('user_id',$request->user_id)->update($data);
        else
        $basic = BasicDetails::create($data);

        }elseif($type == "bank"){
            $detail = BankDetails::where('user_id',$request->user_id)->first();
              if(!empty($detail))
            $basic = BankDetails::where('user_id',$request->user_id)->update($data);
            else
            $basic = BankDetails::create($data);

        }elseif($type == "salary"){
            $detail = SalaryDetails::where('user_id',$request->user_id)->first();
               if(!empty($detail))
            $basic = SalaryDetails::where('user_id',$request->user_id)->update($data);
            else
            $basic = SalaryDetails::create($data);
        }

        return redirect(route('user.details',$request->user_id))->with(['success'=>"User Details Updated Successfully",'type'=>$type]);
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
