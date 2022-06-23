<?php

namespace App\Http\Controllers;
use App\Models\ClassAccount;
use App\Models\JournalEntry;
use Aloha\Twilio\Twilio;
use App\Helpers\BulkSms;
use App\Helpers\GeneralHelper;
use App\Models\Borrower;
use App\Traits\Calculate_netProfitTrait2;
use App\Traits\Calculate_netProfitTrait5;
use App\Models\ChartOfAccount;
use App\Models\Collateral;
use App\Models\CollateralType;
use App\Models\CustomField;
use App\Models\CustomFieldMeta;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Loan;
use App\Models\LoanProduct;
use App\Models\LoanRepayment;
use App\Models\LoanSchedule;
use App\Models\OtherIncome;
use App\Models\Payroll;
use App\Models\SavingTransaction;
use App\Models\Setting;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Clickatell\Api\ClickatellHttp;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\AccountCodes;
use App\Models\BankReconciliation;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use App\Models\Transaction;
use App\Models\Accounts;

class AccountingController extends Controller
{
  


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trial_balance(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        return view('accounting.trial_balance',
            compact('start_date',
                'end_date'));
    }
    public function journal(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (ChartOfAccount::all() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        if($request->isMethod('post')){
            $data=JournalEntry::where('reversed', 0)->where('account_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
        }else{
            $data=[];
        }
        return view('accounting.journal',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }

      use Calculate_netProfitTrait2;
     use Calculate_netProfitTrait5;
    public function ledger(Request $request)
    {
       
        $start_date = $request->start_date;
        $second_date = $request->second_date;
        $end_date = $request->end_date;

  $income = ClassAccount::where('class_type','Income')->get();
           $cost = ClassAccount::where('class_type','Expense')->get();
           $expense= ClassAccount::where('class_type','Expense')->get();


        
              if(!empty($start_date) || !empty($end_date)){
          $net_profit = $this->get_netProfit5($start_date, $second_date,$end_date);
          $net_tax= $this->get_netProfit5($start_date, $second_date,$end_date);
        }
        
else{
     $net_profit ='';    
  $net_tax ='';       
}

        
         $net_p = $this->get_netProfit2();
         $net_t = $this->get_netProfit2();

        return view('accounting.ledger',
            compact('start_date','second_date','income','expense','end_date',
                'cost' ,'net_profit','net_p' ,'net_tax','net_t'));
    }
    public function create_manual_entry()
    {
       
         $journal =  JournalEntry::all();
        $chart_of_accounts = [];
        foreach (ChartOfAccount::all() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
        return view('accounting.create_manual_entry',
            compact('chart_of_accounts','journal'));
    }
    public function store_manual_entry(Request $request)
    {
       

        $cr_journal = new JournalEntry();
       $cr_journal->account_id = $request->credit_account_id;
        $date = explode('-', $request->date);
         $cr_journal->date = $request->date;
         $cr_journal->year = $date[0];
         $cr_journal->month = $date[1];
         $cr_journal->transaction_type = 'manual_entry';
         $cr_journal->name = $request->name;
         $cr_journal->credit = $request->amount;
         $cr_journal->reference = $request->reference;
       $cr_journal->added_by=auth()->user()->id;
        $cr_journal->save();

        $journal = new JournalEntry();
        $journal->account_id = $request->debit_account_id;
        $date = explode('-', $request->date);
        $journal->date = $request->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'manual_entry';
        $journal->name = $request->name;
        $journal->reference = $request->reference;
        $journal->debit = $request->amount;
       $journal->added_by=auth()->user()->id;
        $journal->save();
        //Flash::success(trans('general.successfully_saved'));
        //GeneralHelper::audit_trail("Added Journal Manual Entry  with id:" . $journal->id);

    $credit=AccountCodes::find($request->credit_account_id);
    if($credit->account_group == 'Cash and Cash Equivalent'){

     $account= Accounts::where('account_id',$request->credit_account_id)->first();

if(!empty($account)){
$balance=$account->balance - $request->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->credit_account_id)->first();

     $new['account_id']=$request->credit_account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$request->amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->id;
$balance=0-$request->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Journal Entry',
                                 'module_id' =>  $cr_journal->id,
                               'account_id' => $request->credit_account_id,
                                'code_id' => $request->debit_account_id,
                                'name' => 'Journal Entry Payment',
                                'type' => 'Expense',
                                'amount' =>$request->amount ,
                                'debit' => $request->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from journal entry payment.' ,
                                'added_by' =>auth()->user()->id,
                            ]);


}
    

  $debit=AccountCodes::find($request->debit_account_id);
    if($debit->account_group == 'Cash and Cash Equivalent'){

     $account= Accounts::where('account_id',$request->debit_account_id)->first();

if(!empty($account)){
$balance=$account->balance + $request->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->debit_account_id)->first();

     $new['account_id']=$request->debit_account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0+$request->amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->id;
$balance=0+$request->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Journal Entry',
                                 'module_id' =>  $journal->id,
                               'account_id' => $request->debit_account_id,
                                'code_id' => $request->credit_account_id,
                                'name' => 'Journal Entry Payment',
                                'type' => 'Income',
                                'amount' =>$request->amount ,
                                'credit' => $request->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                   'status' => 'paid' ,
                                'notes' => 'This income is from journal entry payment.' ,
                                'added_by' =>auth()->user()->id,
                            ]);


}
        return redirect('accounting/manual_entry');
    }


    public function bank_statement(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (AccountCodes::where('account_group','Cash and Cash Equivalent')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->account_name;
        }
        if($request->isMethod('post')){
            $data=JournalEntry::where('reconcile', 0)->where('account_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
        }else{
            $data=[];
        }

        if($request->isMethod('post')){
            $open_debit=JournalEntry::where('reconcile', 0)->where('account_id', $request->account_id)->where('date','<', $start_date)->sum('debit');
        }else{
            $open_debit=[];
        }

        if($request->isMethod('post')){
            $open_credit=JournalEntry::where('reconcile', 0)->where('account_id', $request->account_id)->where('date','<', $start_date)->sum('credit');
        }else{
            $open_credit=[];
        }
        return view('accounting.bank_statement',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id','open_debit','open_credit'));
    }

    public function bank_reconciliation(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $account_id=$request->account_id;
        $chart_of_accounts = [];
        foreach (AccountCodes::where('account_group','Cash and Cash Equivalent')->get() as $key) {
            $chart_of_accounts[$key->id] = $key->account_name;
        }
        if($request->isMethod('post')){
            $data=JournalEntry::where('reconcile', 0)->where('account_id', $request->account_id)->whereBetween('date',[$start_date,$end_date])->get();
        }else{
            $data=[];
        }

       

        return view('accounting.bank_reconciliation',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id'));
    }


    public function save_reconcile(Request $request)
    {

$trans_id= $request->trans_id;

  if(!empty($trans_id)){
    for($i = 0; $i < count($trans_id); $i++){
   if(!empty($trans_id[$i])){
    
             $acc = JournalEntry::find($trans_id[$i]);       
                  $items = array(
                    'name' =>  $acc->name,
                    'account_id' => $acc->account_id,
                     'transaction_type' => $acc->transaction_type,
                    'date' => date('Y-m-d'),
                    'payment_id' => $acc->payment_id,
                    'debit' =>$acc->debit,
                    'credit' =>   $acc->credit,
                    'currency_code' => $acc->currency_code,
                    'notes' => $acc->notes,
                    'added_by' =>  auth()->user()->id);

                    BankReconciliation::create($items);  ;

                    JournalEntry::where('id',$trans_id[$i])->update(['reconcile' => '1']);

                  }
                  }
                }


                return redirect(route('reconciliation.report'))->with(['success'=>'Reconciled Successfully']);
}

    public function reconciliation_report()
    {
        //
        $data= BankReconciliation::all();
       return view('accounting.reconciliation_report',compact('data'));
    }
}
