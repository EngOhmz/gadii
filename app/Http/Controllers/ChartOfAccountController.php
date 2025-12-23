<?php

namespace App\Http\Controllers;
use App\Models\ClassAccount;
use App\Models\GroupAccount;
use App\Models\AccountCodes;
use App\Models\AccountType;
use App\Models\ChartOfAccount;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;
use DB;

class ChartOfAccountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // $data = AccountType::all();
        $data = AccountType::where('added_by',auth()->user()->added_by)->get();

   $class_account = DB::table('gl_account_class')->select('gl_account_class.class_type')->groupBy('class_type')->where('added_by',auth()->user()->added_by)->get();
        return view('chart_of_account.data', compact('data','class_account'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Sentinel::hasAccess('capital.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        return view('chart_of_account.create', compact(''));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Sentinel::hasAccess('capital.create')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $rules = array(
            'name' => 'required',
            'gl_code' => 'required|unique:chart_of_accounts',
            'account_type' => 'required'
        );
        $messages = [
            'name.required' => 'Name is required',
            'gl_code.required' => 'GL Code is required',
            'mobile_phone.required' => 'Mobile number is required',
            'gl_code.unique' => 'The GL Code already exists',
            'account_type.required' => 'Account type is required',
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            Flash::warning(trans('general.validation_error'));
            return redirect()->back()->withInput()->withErrors($validator);

        } else {
            $chart_of_account = new ChartOfAccount();
            $chart_of_account->name = $request->name;
            $chart_of_account->parent_id = $request->parent_id;
            $chart_of_account->gl_code = $request->gl_code;
            $chart_of_account->account_type = $request->account_type;
            $chart_of_account->notes = $request->notes;
            $chart_of_account->save();
            Flash::success(trans('general.successfully_saved'));
            return redirect('chart_of_account/data');
        }
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


    public function edit($chart_of_account)
    {
        if (!Sentinel::hasAccess('capital.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        return View::make('chart_of_account.edit', compact('chart_of_account'))->render();
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
        if (!Sentinel::hasAccess('capital.update')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        $chart_of_account = ChartOfAccount::find($id);
        $chart_of_account->name = $request->name;
        $chart_of_account->parent_id = $request->parent_id;
        $chart_of_account->gl_code = $request->gl_code;
        $chart_of_account->account_type = $request->account_type;
        $chart_of_account->notes = $request->notes;
        $chart_of_account->save();
        Flash::success(trans('general.successfully_saved'));
        return redirect('chart_of_account/data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        if (!Sentinel::hasAccess('capital.delete')) {
            Flash::warning("Permission Denied");
            return redirect('/');
        }
        ChartOfAccount::destroy($id);
        Flash::success(trans('general.successfully_deleted'));
        return redirect('chart_of_account/data');
    }
    
    
    
    public function discountModal(Request $request)
    {
              $id=$request->id;
                 $type = $request->type;
                  $user=auth()->user()->added_by;

          switch ($type) {      
     case 'class':
            return view('chart_of_account.class_modal', compact('id'));
                    break;
 
      case 'group':
             $class_account = ClassAccount::where('added_by',$user)->where('disabled','0')->get();;
              return view('chart_of_account.group_modal', compact('class_account','id'));
                    break;

         case 'codes':
              $group_account = GroupAccount::where('added_by',$user)->where('disabled','0')->get();;
              return view('chart_of_account.codes_modal', compact('group_account','id'));
                    break;
   
         default:
             break;

            }


  
                 }

         
          public function save_class(Request $request){
       
    
      //dd($request->all());

            $added_by = auth()->user()->added_by;
            $class_account = new ClassAccount();
            $class_account->class_name = $request->class_name;           
            $class_account->class_type = $request->class_type;
            $class_account->added_by = auth()->user()->added_by;

           $class_value=AccountType::where('type',$request->class_type)->where('added_by',$added_by)->first();
     
         $before=ClassAccount::where('class_type',$request->class_type)->where('added_by',$added_by)->latest('id')->first();
          if(!empty($before)){
         $count=ClassAccount::where('class_type',$request->class_type)->where('added_by',$added_by)->count();

                if($count == '9'){
            $response=['success'=>false,'error'=>true,'message'=>'You have exceeded the limit for the class.'] ;       
            return response()->json($response,200);

}
            else{
          $class_account->class_id =    $before->class_id +1000;
          $class_account->order_no = $before->order_no +1;
}

}
 else{
         $class_account->class_id =    $class_value->value +1000;
          $class_account->order_no = '0';

}

            $class_account->save();
            
    
        $response=['success'=>true,'error'=>false,'message'=>'Class Account Created.','class_account'=>$class_account] ;       
            return response()->json($response,200);
       
       
        
   }

 public function save_group(Request $request){
       
    
      //dd($request->all());

        $added_by = auth()->user()->added_by;
 
       $group_account = new GroupAccount();
        $group_account->name = $request->name;
        $group_account->class = $request->class;
        $group_account->added_by = auth()->user()->added_by;;

       $class=ClassAccount::where('id', $request->class)->where('added_by',$added_by)->first();                     
          $group_account->type= $class->class_type;

     
         $before=GroupAccount::where('class',$request->class)->where('added_by',$added_by)->latest('id')->first();
          if(!empty($before)){
         $count=GroupAccount::where('class',$request->class)->where('added_by',$added_by)->count();
                if($count == '9'){
                    
                     return response()->json([
             'error'=>'You have exceeded the limit for the group.'
                   ]);


}
            else{
         $group_account->group_id =    $before->group_id +100;
         $group_account->order_no = $before->order_no +1;
}
}
 else{
           $group_account->group_id=    $class->class_id +100;
             $group_account->order_no = '0';

}
           
            $group_account->save();
            
           
        $response=['success'=>true,'error'=>false,'message'=>'Group Account Created.','group_account'=>$group_account] ;       
            return response()->json($response,200);
        
        
      
       
   }
    
    
 
  public function save_codes(Request $request){
       
    
      //dd($request->all());

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
                    
                     return response()->json([
             'error'=>'You have exceeded the limit for the group.'
                   ]);


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
            
             
        $response=['success'=>true,'error'=>false,'message'=>'Account Codes Created.','account_codes'=>$account_codes] ;       
            return response()->json($response,200);
       
        
      
       
   }
    
 
 
    
    
    
}
