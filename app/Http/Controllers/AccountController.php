<?php

namespace App\Http\Controllers;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\Expenses;
use App\Models\Accounts;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Models\JournalEntry;
use App\Http\Requests;
use App\Models\Currency;
use App\Models\Payment_methodes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;

class AccountController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
      $account = Accounts::all();
 $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
     $currency = Currency::all();
          $group_account = GroupAccount::all();
        return view('account.data', compact('currency','account','group_account','bank_accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
       $group_account = GroupAccount::all();
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

          $cr= AccountCodes::where('id',$request->account_id)->first();

         $data=$request->post();
       $data['account_name']= $cr->account_name;
        $data['added_by']=auth()->user()->id;

$a=Accounts::where('account_id',$request->account_id)->first();

if(!empty($a)){
 return redirect(route('account.index'))->with(['error'=>'Account already exists']);
}

else{
        $account = Accounts::create($data);
     return redirect(route('account.index'))->with(['success'=>'Account Created Successfully']);
 }      

     
        }
   

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
       $data= Accounts::find($id);


 $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
     $currency = Currency::all();
            $group_account = GroupAccount::all();
        return View::make('account.data', compact('data','currency','group_account','id','bank_accounts'))->render();
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
       
          $account= Accounts::find($id);

    
          $cr= AccountCodes::where('id',$request->account_id)->first();

         $data=$request->post();
       $data['account_name']= $cr->account_name;
        $account->update($data);


 return redirect(route('account.index'))->with(['success'=>'Account Updated Successfully']);
     
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        Accounts::destroy($id);
        //Flash::success(trans('general.successfully_deleted'));
   return redirect(route('account.index'))->with(['success'=>'Account Deleted Successfully']);
    }

   

   
}
