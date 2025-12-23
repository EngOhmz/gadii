<?php

namespace App\Http\Controllers;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;

class AccountCodesController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=auth()->user()->added_by;
        $codes = AccountCodes::where('added_by',$user)->where('added_by',$user)->whereNotIn('account_name', ['VAT IN', 'VAT OUT'])->where('disabled','0')->orderBy('account_codes','asc')->get();
          $group_account = GroupAccount::where('added_by',$user)->where('disabled','0')->orderBy('group_id','asc')->get();
        return view('account_codes.data', compact('codes','group_account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
       $group_account = GroupAccount::all()->where('added_by',auth()->user()->added_by);
        return view('account_codes.create', compact('group_account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
       $validatedData = $request->validate([
            'account_name' => 'required',
            'account_group' => 'required',
        ]);
        
                $added_by = auth()->user()->added_by;
     
      
            $account_codes = new AccountCodes();
            
             $group=GroupAccount::where('id', $request->account_group)->where('disabled','0')->where('added_by',$added_by)->first();
             if($group->name == 'Cash and Cash Equivalent'){
                 $status='Bank';
             }
             else{
                 $status='Non Bank'; 
             }
            
       $account_codes->account_name = $request->account_name ;
        $account_codes->account_group  = $request->account_group  ;
        $account_codes->account_status  =$status  ;
      $account_codes->account_type= $group->type;
    $account_codes->added_by = auth()->user()->added_by;
  
 $before=AccountCodes::where('account_group',$request->account_group)->where('disabled','0')->where('added_by',$added_by)->latest('id')->first();
          if(!empty($before)){
      $count=AccountCodes::where('account_group',$request->account_group)->where('disabled','0')->where('added_by',$added_by)->count();
                if($count == '99'){
  return redirect(route('account_codes.index'))->with(['error'=>'You have exceeded the limit for the group.']);

}
            else{
          $account_codes->account_codes =    $before->account_codes +1;
         $account_codes->order_no = $before->order_no +1;
}
}
 else{
            $account_codes->account_codes = $group->group_id +1;
         $account_codes->order_no = '0';

}
           


            $account_codes->save();

            AccountCodes::where('id',$account_codes->id)->update(['account_id' => $account_codes->id]);

             
            return redirect(route('account_codes.index'))->with(['success'=>'Account Codes Created.']);
            
        }
   

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
$user=auth()->user()->added_by;

       $data= AccountCodes::find($id);
         $group_account = GroupAccount::where('added_by',$user)->where('disabled','0')->orderBy('group_id','asc')->get();
        return View::make('account_codes.data', compact('data','group_account','id'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
         $account_codes= AccountCodes::find($id);
         
         $added_by = auth()->user()->added_by;
          $group=GroupAccount::where('id', $request->account_group)->where('disabled','0')->where('added_by',$added_by)->first();
             if($group->name == 'Cash and Cash Equivalent'){
                 $status='Bank';
             }
             else{
                 $status='Non Bank'; 
             }
             
         $account_codes->account_codes = $request->account_codes;
       $account_codes->account_name = $request->account_name ;
        $account_codes->account_group  = $request->account_group  ;
        $account_codes->account_status  =$status  ;
      $account_codes->account_type= $group->type;


  $old = AccountCodes::find($id);

          if($old->account_group != $request->account_group){
 $before=AccountCodes::where('account_group',$request->account_group)->where('disabled','0')->where('added_by',$added_by)->latest('id')->first();
          if(!empty($before)){
     $count=AccountCodes::where('account_group',$request->account_group)->where('disabled','0')->where('added_by',$added_by)->count();
                if($count == '99'){
  return redirect(route('account_codes.index'))->with(['error'=>'You have exceeded the limit for the group.']);

}
            else{
          $account_codes->account_codes =    $before->account_codes +1;
         $account_codes->order_no = $before->order_no +1;
}
}
 else{
            $account_codes->account_codes = $group->group_id +1;
         $account_codes->order_no = '0';

}
  }

else{
$account_codes->account_codes =   $old->account_codes;
}         
            $account_codes->save();

         
      return redirect(route('account_codes.index'))->with(['success'=>'Account Codes Updated.']);
  

        
            
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        AccountCodes::find($id)->update(['disabled'=>'1']);
        
        //Flash::success(trans('general.successfully_deleted'));
       return redirect(route('account_codes.index'))->with(['success'=>'Account Codes Deleted.']);
    }
}
