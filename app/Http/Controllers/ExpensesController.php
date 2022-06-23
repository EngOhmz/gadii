<?php

namespace App\Http\Controllers;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\Expenses;
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
use App\Models\Fuel\Refill;

class ExpensesController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment_method = Payment_methodes::all();
      $expense = Expenses::all();
      $currency = Currency::all();
 $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->orwhere('account_name','Payables')->get() ;
     $chart_of_accounts =AccountCodes::where('account_group','!=','Cash and Cash Equivalent')->get() ;
       
          $group_account = GroupAccount::all();
        return view('expenses.data', compact('expense','group_account','chart_of_accounts','payment_method','bank_accounts','currency'));
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

            $expenses = new Expenses();
            $expenses->name = $request->name;
        $expenses->ref = $request->ref;

             $expenses->type='Expenses';
       $expenses->amount = $request->amount ;
         $expenses->date  = $request->date  ;
         $expenses->account_id  = $request->account_id  ;
             $expenses->bank_id  = $request->bank_id ;
             $expenses->notes  = $request->notes ;
             $expenses->status  = '0' ;
             $expenses->exchange_code =   $request->exchange_code;
             $expenses->exchange_rate=  $request->exchange_rate;
             $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
             $expenses->trans_id = "TRANS_EXP_".$random;
             $expenses->added_by = auth()->user()->id;
             $expenses->payment_method =  $request->payment_method;
             $expenses->save();

        

            return redirect('expenses');
        }
   

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
       $data= Expenses::find($id);


 $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->orwhere('account_name','Payables')->get() ;
     $chart_of_accounts =AccountCodes::where('account_group','!=','Cash and Cash Equivalent')->get() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
            $group_account = GroupAccount::all();
        return View::make('expenses.data', compact('data','currency','group_account','payment_method','id','chart_of_accounts','bank_accounts'))->render();
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
       
          $expenses= Expenses::find($id);
            $expenses->name = $request->name;
           $expenses->ref = $request->ref;

             $expenses->type='Expenses';
       $expenses->amount = $request->amount ;
         $expenses->date  = $request->date  ;
         $expenses->account_id  = $request->account_id  ;
             $expenses->bank_id  = $request->bank_id ;
             $expenses->notes  = $request->notes ;
             $expenses->exchange_code =   $request->exchange_code;
             $expenses->exchange_rate=  $request->exchange_rate;
             $expenses->added_by = auth()->user()->id;
             $expenses->payment_method =  $request->payment_method;
            $expenses->save();

        //Flash::success(trans('general.successfully_saved'));
        return redirect('expenses');
     
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        Expenses::destroy($id);
        //Flash::success(trans('general.successfully_deleted'));
        return redirect('expenses');
    }

    public function approve($id)
    {
        //
        $expenses= Expenses::find($id);
        $data['status'] = 1;
        $expenses->update($data);
   
   if( $expenses->refill_id == NULL){
        $journal = new JournalEntry();
        $journal->account_id =    $expenses->account_id;
      $date = explode('-',  $expenses->date);
        $journal->date = $expenses->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'expense_payment';
        $journal->name = 'Expense Payment';
             $journal->payment_id=    $expenses->id;
             $journal->notes= 'Expense Payment with transaction id ' .$expenses->name;
        $journal->added_by=auth()->user()->id;
        $journal->debit =   $expenses->amount;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $expenses->bank_id;
        $date = explode('-',  $expenses->date);
        $journal->date = $expenses->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'expense_payment';
        $journal->name = 'Expense Payment';
        $journal->credit =    $expenses->amount;
        $journal->payment_id=    $expenses->id;
        $journal->added_by=auth()->user()->id;
        $journal->notes= 'Expense Payment with transaction id ' .$expenses->name;
        $journal->save();

    $account= Accounts::where('account_id', $expenses->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $expenses->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id', $expenses->bank_id)->first();

     $new['account_id']=  $expenses->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0- $expenses->amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->id;
$balance= 0-$expenses->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Expenses',
                                 'module_id' => $expenses->id,
                               'account_id' =>  $expenses->bank_id,
                                'code_id' =>  $expenses->account_id,
                                'name' => 'Expense Payment with reference' .$expenses->trans_id,
                                 'transaction_prefix' =>  $expenses->name,
                                'type' => 'Expense',
                                'amount' => $expenses->amount ,
                                'debit' =>  $expenses->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime( $expenses->date)),

                                   'status' => 'paid' ,
                                'notes' => 'Expense Payment with transaction id ' . $expenses->name ,
                                'added_by' =>auth()->user()->id,
                            ]);
                            

}

 else {

 $refill = Refill::find($expenses->refill_id);
 $t=Truck::find($refill->truck);

        $journal = new JournalEntry();
        $journal->account_id =    $expenses->account_id;
      $date = explode('-',  $expenses->date);
        $journal->date = $expenses->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Credit';
             $journal->payment_id=    $expenses->refill_id;
           $journal->truck_id= $refill->truck;
              $journal->notes= 'Fuel Refill On Credit Payment for Truck '.$t->truck_name. ' - '. $t->reg_no. ' with transaction id ' .$expenses->trans_id;
              $journal->currency_code =   $expenses->exchange_code;
              $journal->exchange_rate=  $expenses->exchange_rate;
        $journal->added_by=auth()->user()->id;
        $journal->debit =   $expenses->amount * $expenses->exchange_rate;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $expenses->bank_id;
        $date = explode('-',  $expenses->date);
        $journal->date = $expenses->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Credit';
             $journal->payment_id=    $expenses->refill_id;
         $journal->truck_id= $refill->truck;
        $journal->credit =    $expenses->amount* $expenses->exchange_rate;
        $journal->currency_code =   $expenses->exchange_code;
        $journal->exchange_rate=  $expenses->exchange_rate;
      $journal->added_by=auth()->user()->id;
      $journal->notes= 'Fuel Refill On Credit Payment for Truck '.$t->truck_name. ' - '. $t->reg_no. ' with transaction id ' .$expenses->trans_id;
        $journal->save();


    $account= Accounts::where('account_id', $expenses->bank_id)->first();

if(!empty($account)){
$balance=$account->balance -  $expenses->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id', $expenses->bank_id)->first();

     $new['account_id']=  $expenses->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0- $expenses->amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->id;
$balance= 0-$expenses->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Fuel Refill',
                                 'module_id' => $expenses->refill_id,
                               'account_id' =>  $expenses->bank_id,
                                'code_id' =>  $expenses->account_id,
                                'name' => 'Fuel Refill Payment with transaction id ' .$expenses->name,
                                 'transaction_prefix' =>  $expenses->trans_id,
                                'type' => 'Expense',
                                'amount' => $expenses->amount ,
                                'debit' =>  $expenses->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime( $expenses->date)),
                                   'status' => 'paid' ,
                                'notes' => 'Fuel Refill Payment with transaction id ' . $expenses->name ,
                                'added_by' =>auth()->user()->id,
                            ]);

}



        return redirect(route('expenses.index'))->with(['success'=>'Approved Successfully']);
    }

}
