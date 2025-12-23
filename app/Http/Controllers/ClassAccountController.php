<?php

namespace App\Http\Controllers;
use App\Models\AccountType;
use App\Models\ClassAccount;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Alert;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;

class ClassAccountController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $added_by = auth()->user()->added_by;
        $class = ClassAccount::where('added_by',$added_by)->where('disabled','0')->get();
        return view('class_account.data', compact('class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('class_account.create', compact(''));
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
            'class_name' => 'required',
            'class_type' => 'required', 
          
        ]);
        
        $added_by = auth()->user()->added_by;
            $class_account = new ClassAccount();
            $class_account->class_name = $request->class_name;           
            $class_account->class_type = $request->class_type;
            $class_account->added_by = auth()->user()->added_by;

           $class_value=AccountType::where('type',$request->class_type)->where('added_by',$added_by)->first();
     
         $before=ClassAccount::where('class_type',$request->class_type)->where('added_by',$added_by)->where('disabled','0')->latest('id')->first();
          if(!empty($before)){
         $count=ClassAccount::where('class_type',$request->class_type)->where('added_by',$added_by)->where('disabled','0')->count();

                if($count == '9'){
  return redirect(route('class_account.index'))->with(['error'=>'You have exceeded the limit for the class.']);

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
          // Alert::success('class account created');
               return redirect(route('class_account.index'))->with(['success'=>'Class Account Created.']);
           
        
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
        $data =   ClassAccount::find($id);
        return View::make('class_account.data', compact('data','id'))->render();
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
      
        $class_account = ClassAccount::find($id);
       $class_account->class_name = $request->class_name;
       $class_account->class_id = $request->class_id;
        $class_account->class_type = $request->class_type;
 
 $added_by = auth()->user()->added_by;

         $old = ClassAccount::find($id);

if($old->class_type != $request->class_type){

      $class_value=AccountType::where('type',$request->class_type)->first();
     
         $before=ClassAccount::where('class_type',$request->class_type)->where('added_by',$added_by)->where('disabled','0')->latest('id')->first();
          if(!empty($before)){
               $count=ClassAccount::where('class_type',$request->class_type)->where('added_by',$added_by)->where('disabled','0')->count();
                if($count == '9'){
  return redirect(route('class_account.index'))->with(['error'=>'You have exceeded the limit for the class.']);

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
}

else{
  $class_account->class_id =   $old->class_id;
}
        $class_account->save();
        //Flash::success(trans('general.successfully_saved'));
        return redirect(route('class_account.index'))->with(['success'=>'Class Account Updated.']);

 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $class=ClassAccount::find($id);
        $class->update(['disabled'=>'1']);
        //Flash::success(trans('general.successfully_deleted'));
        return redirect(route('class_account.index'))->with(['success'=>'Class Account Deleted.']);
    }
}
