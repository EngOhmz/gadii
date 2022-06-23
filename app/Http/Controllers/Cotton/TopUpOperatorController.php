<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\Expenses;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Cotton\TopUpOperator;
use App\Models\Cotton\ReverseTopUpCenter;
use App\Models\Cotton\ReverseTopUpOperator;
use App\Models\Cotton\CollectionCenter;
use App\Models\Cotton\Operator;
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



class TopUpOperatorController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       $banks= AccountCodes::where('account_group','Cash and Cash Equivalent')->get();
      $transfer=TopUpOperator::where('status','0')->orwhere('status','1')->get();
  $operator=Operator::all() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
        return view('cotton.top_up_operator', compact('payment_method','transfer','currency','operator','banks'));
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


         $data=$request->post();
         $data['reference'] = $request->reference;
         $data['due_amount'] =$request->amount;
         $data['reference_no'] =$request->reference_no;
        $data['added_by']=auth()->user()->id;
           $data['from_account_id']= $request->from_account_id;
       $transfer=TopUpOperator::create($data);
     return redirect(route('top_up_operator.index'))->with(['success'=>'Transaction Created Successfully']);


     
        }
   

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
         $data=TopUpOperator::find($id);
 $operator=Operator::all() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
      $banks= AccountCodes::where('account_group','Cash and Cash Equivalent')->get();
        return View::make('cotton.top_up_operator', compact('data','currency','payment_method','id','operator','banks'))->render();

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
       
          $transfer= TopUpOperator::find($id);

         $data=$request->post();
       $data['due_amount'] =$request->amount;
          $data['reference'] = $request->reference;
        $data['added_by']=auth()->user()->id;
            $data['from_account_id']= $request->from_account_id;
      $transfer->update($data);
     return redirect(route('top_up_operator.index'))->with(['success'=>'Transaction Updated Successfully']);


     
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
       TopUpOperator::destroy($id);
        //Flash::success(trans('general.successfully_deleted'));
   return redirect(route('top_up_operator.index'))->with(['success'=>'Transaction Deleted Successfully']);
    }

public function findOperator(Request $request)
    {
 
$user_id=$request->user;


$top= TopUpOperator::where('id',$user_id)->first();


if($request->id > $top->due_amount){
$price="You have exceeded your Balance. Choose amount less than ".  number_format($top->due_amount,2) ;

}
else{
$price='' ;
 }




                return response()->json($price);	                  
 
    }


     public function approve($id)
    {
        //
        $transfer= TopUpOperator::find($id);
        $data['status'] = 1;
        $data['approve_by']=auth()->user()->id;
        $transfer->update($data);






  $from= AccountCodes::where('id',$transfer->from_account_id)->first();
  $to= Operator::where('id',$transfer->to_account_id)->first();

   $cr= AccountCodes::where('account_name','Operator Account')->first();

        $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'operator';
        $journal->name = 'Top Up Operator';
        $journal->payment_id =    $transfer->id;
       $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
        $journal->notes='Top Up From '.$from->account_name.' to Operator ' .$to->name;
        $journal->debit=     $transfer->amount;
            $journal->added_by=auth()->user()->id;
           $journal->operator_id= $transfer->to_account_id;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $transfer->from_account_id;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'operator';
        $journal->name = 'Top Up Operator';
        $journal->payment_id =    $transfer->id;
         $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
           $journal->notes='Top Up From '.$from->account_name.' to Operator ' .$to->name;
        $journal->credit=    $transfer->amount;
     $journal->operator_id= $transfer->to_account_id;
 $journal->added_by=auth()->user()->id;
        $journal->save();
    
       
$account= Accounts::where('account_id',$transfer->from_account_id)->first();
if(!empty($account)){
$balance=$account->balance - $transfer->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$transfer->from_account_id)->first();

     $new['account_id']= $transfer->from_account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$transfer->amount;
       $new[' exchange_code']=$transfer->exchange_code;
        $new['added_by']=auth()->user()->id;
$balance= 0-$transfer->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Top Up Operator',
                                 'module_id' => $id,
                               'account_id' => $transfer->from_account_id,
                                'code_id' => $cr->id,
                                'name' => 'Top Up Operator with reference  ' .$transfer->reference_no,
                                'type' => 'Expense',
                                'amount' =>$transfer->amount ,
                                'debit' => $transfer->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($transfer->date)),
                                'payment_methods_id' =>$transfer->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from top up operator. The Reference is ' .$transfer->reference_no ,
                                'added_by' =>auth()->user()->id,
                            ]);


      

        return redirect(route('top_up_operator.index'))->with(['success'=>'Approved Successfully']);
    }

 public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
                if($type == 'operator'){
                $payment_method= Payment_methodes::all();
                 $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
               return view('cotton.addReversedOperator',compact('id','payment_method','bank_accounts'));
     }          
       
   }


 public function newdiscount(Request $request)
    {
        //
        $transfer= TopUpOperator::find($request->id);
   $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);

$item['from_account_id']=$transfer->to_account_id;
$item['to_account_id']=$request->to_account_id;
$item['due_amount']=$request->amount;
$item['amount']=$request->amount;
$item['exchange_code']=$transfer->exchange_code;
$item['exchange_rate']=$transfer->exchange_rate;
$item['notes']=$request->notes;
$item['date']=$request->date;
$item['status']='1';

 $item['approve_by']=auth()->user()->id;
 $item['added_by']=auth()->user()->id;
$item['top_up_id']=$request->id;
$item['top_up_reference']=$transfer->reference_no;
$item['payment_method']=$request->payment_method;
$item['reference']=$request->reference;

$rev=ReverseTopUpOperator::create($item);

      

$to_account= Accounts::where('account_id',$request->to_account_id)->first();


if(!empty($to_account)){
$to_balance=$request->amount + $to_account->balance;
$item_to['balance']=$to_balance;
$to_account->update($item_to);
}

else{
  $acr= AccountCodes::where('id',$request->to_account_id)->first();

     $new['account_id']= $request->to_account_id;
       $new['account_name']= $acr->account_name;
      $new['balance']= $request->amount;
       $new[' exchange_code']=$transfer->exchange_code;
        $new['added_by']=auth()->user()->id;
     Accounts::create($new);
 $to_balance= $request->amount;
}

        
  


   $dr= AccountCodes::where('account_id',$request->to_account_id)->first();


  $from= Operator::where('id',$transfer->to_account_id)->first();
   $cr= AccountCodes::where('account_name','Operator Account')->first();

        $journal = new JournalEntry();
        $journal->account_id = $request->to_account_id;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'operator';
        $journal->name = 'Reverse Top Up Operator';
        $journal->payment_id =    $rev->id;
       $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
         $journal->notes='Reverse Top Up From Operator '.$from->name.' to ' .$dr->account_name;
        $journal->debit=     $request->amount;
           $journal->added_by=auth()->user()->id;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $cr->id;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
            $journal->transaction_type = 'operator';
        $journal->name = 'Reverse Top Up Operator';
        $journal->payment_id =    $transfer->id;
         $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
           $journal->notes='Reverse Top Up From Operator '.$from->name.' to ' .$dr->account_name;
        $journal->credit=    $request->amount;
          $journal->added_by=auth()->user()->id;
        $journal->save();
    
       
 // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Reversed Top Up Operator',
                                 'module_id' => $rev->id,
                               'account_id' => $transfer->to_account_id,
                                'code_id' => $cr->id,
                                'name' => 'Reversed Top Up Operator with reference  ' .$rev->reference,
                                'type' => 'Income',
                                'amount' =>$request->amount ,
                                'credit' => $request->amount,
                                 'total_balance' =>$to_balance,
                                'date' => date('Y-m-d', strtotime($transfer->date)),
                                'payment_methods_id' =>$request->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This income is from reversed top up operator. The Reference is ' .$rev->reference,
                                'added_by' =>auth()->user()->id,
                            ]);

        $data['due_amount'] = $transfer->due_amount -$request->amount;
     $data['reversed']='1';
        $transfer->update($data);

        return redirect(route('top_up_operator.index'))->with(['success'=>'Reversed Successfully']);
    }
   

 public function complete($id)
    {
        //
        $transfer= TopUpOperator::find($id);
        $data['status'] = 2;
        $transfer->update($data);

        return redirect(route('top_up_operator.index'))->with(['success'=>'Transaction Completed Successfully']);
    }


 public function reverse_top_operator()
    {
      
      $transfer=ReverseTopUpOperator::all();
  $operator=Operator::all() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
        return view('cotton.reverse_top_up_operator', compact('payment_method','transfer','currency','operator'));
    }

       public function complete_operator()
    {
        
       $banks= AccountCodes::where('account_group','Cash and Cash Equivalent')->get();
      $transfer=TopUpOperator::where('status','2')->get();
  $operator=Operator::all() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
        return view('cotton.complete_operator', compact('payment_method','transfer','currency','operator','banks'));
    }
}
