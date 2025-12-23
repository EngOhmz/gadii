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
use App\Models\User;
use App\Models\Payment_methodes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;
use App\Models\Fuel\Refill;
use App\Models\Supplier;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use App\Imports\ImportExpenses ;
use App\Models\Branch;
use Response;
use PDF;

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
      $expense = Expenses::where('multiple','0')->where('added_by',auth()->user()->added_by)->orderBy('date', 'DESC')->get();;
      $currency = Currency::all();
     $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
     $chart_of_accounts =AccountCodes::all()->whereIn('account_type', ['Expense','Liability'])->whereNotIn('account_name', ['Deffered Tax','Value Added Tax (VAT)'])->where('disabled','0')->where('added_by',auth()->user()->added_by)->groupBy('account_type');;
     $client=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
    $group_account = GroupAccount::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
    $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
    $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
            
        return view('expenses.data', compact('expense','group_account','chart_of_accounts','payment_method','bank_accounts','currency','client','users','branch'));
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

      if($request->type =='multiple'){

     $nameArr =$request->account_id ;
     $suppArr =$request->supplier_id ;
 $amountArr = str_replace(',', '', $request->amount)  ;
 $notesArr = $request->notes;



$cost['amount'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                   $cost['amount'] += $amountArr[$i];
                  
                }
            }

             $items = array(
                  'name' =>  $request->name,
                    'ref' =>   $request->ref ,
                    'type' =>  'Expenses',
                    'amount' =>   $cost['amount'] ,
                     'date' => $request->date , 
                     'bank_id' =>  $request->bank_id ,
                     'branch_id' =>  $request->branch_id ,
                    'status'  => '0' ,
                     'view'  => '1' ,
                      'multiple'  => '0' ,
                      'user_id' => $request->user_id,
                    'added_by' => auth()->user()->added_by,
                    'payment_method' =>  $request->payment_method

);

                    $total_expenses = Expenses::create($items);  ; 
         
        }    


  if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
             $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
            
                $t = array(
                   'name' =>  $request->name,
                    'ref' =>   $request->ref ,
                    'type' =>  'Expenses',
                    'amount' =>  $amountArr[$i] ,
                     'date' => $request->date , 
                     'bank_id' =>  $request->bank_id ,
                     'branch_id' =>  $request->branch_id ,
                     'account_id' =>  $nameArr[$i] , 
                     'notes'  => $notesArr[$i] , 
                    'exchange_code' =>   $request->exchange_code,
                   'exchange_rate'=>  $request->exchange_rate,
                    'status'  => '0' ,
                      'view'  => '1' ,
                      'multiple'  => '1' ,
                      'multiple_id'  =>  $total_expenses->id ,
                    'trans_id' => 'TRANS_EXP_'.$random,
                   'user_id' => $request->user_id,
                   'supplier_id' => $suppArr[$i] ,
                    'added_by' => auth()->user()->added_by,
                    'payment_method' =>  $request->payment_method
                        );

                     $expenses = Expenses::create($t);  ; 

            }
        }
    }    

 return redirect(route('expenses.index'))->with(['success'=>'Payment Added successfully']);
           
}



 else if($request->type =='overhead'){

    $nameArr =$request->account_id ;
     $suppArr =$request->supplier_id ;
 $amountArr = str_replace(',', '', $request->amount)  ;
 $notesArr = $request->notes;



$cost['amount'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                   $cost['amount'] += $amountArr[$i];
                  
                }
            }

             $items = array(
                  'name' =>  $request->name,
                    'ref' =>   $request->ref ,
                    'type' =>  'Expenses',
                    'amount' =>   $cost['amount'] ,
                     'date' => $request->date , 
                     'bank_id' =>  $request->bank_id ,
                     'branch_id' =>  $request->branch_id ,
                    'status'  => '0' ,
                     'view'  => '1' ,
                      'multiple'  => '0' ,
                      'user_id' => auth()->user()->id,
                    'added_by' => auth()->user()->added_by,
                    'payment_method' =>  $request->payment_method

);

                    $total_expenses = Expenses::create($items);  ; 
         
        }    


  if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
             $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
            
                $t = array(
                    'name' =>  $request->name,
                     'ref' =>   $request->ref ,
                     'type' =>  'Expenses',
                     'amount' =>  $amountArr[$i] ,
                     'date' => $request->date , 
                     'bank_id' =>  $request->bank_id ,
                     'branch_id' =>  $request->branch_id ,
                     'account_id' =>  $nameArr[$i] , 
                     'notes'  => $notesArr[$i] , 
                     'exchange_code' =>   $request->exchange_code,
                     'exchange_rate'=>  $request->exchange_rate,
                     'status'  => '0' ,
                     'view'  => '1' ,
                     'work_id'  => $request->work,
                     'multiple'  => '1' ,
                     'multiple_id'  =>  $total_expenses->id ,
                     'trans_id' => 'TRANS_EXP_'.$random,
                     'supplier_id' => $suppArr[$i] ,
                    'user_id' => auth()->user()->id,
                    'added_by' => auth()->user()->added_by,
                    'payment_method' =>  $request->payment_method
                        );

                     $expenses = Expenses::create($t);  ; 

            }
        }
    }    

 return redirect(route('work_order.index'))->with(['success'=>'Overhead Cost Added successfully']);
           
}

else{
           $expenses = new Expenses();
            $expenses->name = $request->name;
        $expenses->ref = $request->ref;

             $expenses->type='Expenses';
             $expenses->amount = str_replace(',', '', $request->amount) ;
             $expenses->date  = $request->date  ;
             $expenses->account_id  = $request->account_id  ;
             $expenses->bank_id  = $request->bank_id ;
             $expenses->branch_id =  $request->branch_id ;
             $expenses->supplier_id  = $request->supplier_id ;
             $expenses->notes  = $request->notes ;
             $expenses->status  = '0' ;
             $expenses->view  = '0' ;
             $expenses->multiple = '0' ;
             $expenses->exchange_code =   $request->exchange_code;
             $expenses->exchange_rate=  $request->exchange_rate;
             $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
             $expenses->trans_id = "EXP_".$random;
             $expenses->user_id = $request->user_id;
             $expenses->added_by = auth()->user()->added_by;
             $expenses->payment_method =  $request->payment_method;
             $expenses->save();

 return redirect(route('expenses.index'))->with(['success'=>'Payment Added successfully']);
}
           
        }
   

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
       $data= Expenses::find($id);


$bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
     $chart_of_accounts =AccountCodes::all()->whereIn('account_type', ['Expense','Liability'])->whereNotIn('account_name', ['Deffered Tax','Value Added Tax (VAT)'])->where('disabled','0')->where('added_by',auth()->user()->added_by)->groupBy('account_type');;
         $client=Supplier::where('user_id',auth()->user()->added_by)->where('disabled', '0')->get();
          $group_account = GroupAccount::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
      $users = User::all()->where('disabled', '0')->where('added_by', auth()->user()->added_by);
      $branch = Branch::where('disabled', '0')->where('added_by', auth()->user()->added_by)->get();
        return View::make('expenses.data', compact('data','currency','group_account','payment_method','id','chart_of_accounts','bank_accounts','client','users','branch'))->render();
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
             $expenses->amount = str_replace(',', '', $request->amount) ;
             $expenses->date  = $request->date  ;
             $expenses->account_id  = $request->account_id  ;
             $expenses->bank_id  = $request->bank_id ;
             $expenses->branch_id =  $request->branch_id ;
             $expenses->supplier_id  = $request->supplier_id ;
             $expenses->user_id = $request->user_id;
             $expenses->notes  = $request->notes ;
             $expenses->exchange_code =   $request->exchange_code;
             $expenses->exchange_rate=  $request->exchange_rate;
             $expenses->added_by = auth()->user()->added_by;
             $expenses->payment_method =  $request->payment_method;
             $expenses->save();


$total_multiple=Expenses::find($expenses->multiple_id);
if(!empty($total_multiple)){
$multiple=Expenses::where('multiple_id',$total_multiple->id)->sum('amount');
$m['amount']=$multiple;
$total_multiple->update($m);
}


            return redirect(route('expenses.index'))->with(['success'=>'Payment Updated successfully']);


     
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
       
           $expenses=Expenses::find($id);

  $total_multiple=Expenses::find($expenses->multiple_id);
if(!empty($total_multiple)){
$multiple=Expenses::where('multiple_id',$total_multiple->id)->sum('amount');
$m['amount']=$multiple -$expenses->amount;
$total_multiple->update($m);
}
    JournalEntry::where('payment_id', $expenses->id )->where('transaction_type', 'expense_payment')->delete();

 $bank_accounts=AccountCodes::where('id',$expenses->bank_id)->first() ;
if($bank_accounts->account_status == 'Bank'){
   Transaction::where('transaction_prefix',$expenses->trans_id)->delete();

$x_account= Accounts::where('account_id',$expenses->bank_id)->first();

if(!empty($x_account)){
$x_balance=$x_account->balance + $expenses->amount;
$x_item['balance']=$x_balance;
$x_account->update($x_item);
}
  }    

        Expenses::destroy($id);

     return redirect(route('expenses.index'))->with(['success'=>'Payment Deleted successfully']);
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
         if( $expenses->work_id == NULL){
        $journal->transaction_type = 'expense_payment';
        $journal->name = 'Expense Payment';
         }
             else{
              $journal->transaction_type = 'manufacturing_overhead';
        $journal->name = 'Manufacturing Overhead Payment';
            }

        $journal->payment_id=    $expenses->id;
        $journal->notes= 'Expense Payment with transaction id ' .$expenses->name;
        $journal->added_by=auth()->user()->added_by;
        $journal->supplier_id= $expenses->supplier_id;
        $journal->branch_id= $expenses->branch_id;
        $journal->debit =   $expenses->amount;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $expenses->bank_id;
        $date = explode('-',  $expenses->date);
        $journal->date = $expenses->date;
        $journal->year = $date[0];
        $journal->month = $date[1];

        if( $expenses->work_id == NULL){
        $journal->transaction_type = 'expense_payment';
        $journal->name = 'Expense Payment';
         }
             else{
              $journal->transaction_type = 'manufacturing_overhead';
        $journal->name = 'Manufacturing Overhead Payment';
            }

        $journal->credit =    $expenses->amount;
        $journal->payment_id=    $expenses->id;
        $journal->supplier_id= $expenses->supplier_id;
        $journal->branch_id= $expenses->branch_id;
        $journal->added_by=auth()->user()->added_by;
        $journal->notes= 'Expense Payment with transaction id ' .$expenses->name;
        $journal->save();

 $bank_accounts=AccountCodes::where('id',$expenses->bank_id)->first() ;
if($bank_accounts->account_status == 'Bank'){
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
        $new['added_by']=auth()->user()->added_by;
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
                                'added_by' =>auth()->user()->added_by,
                            ]);
}                            

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
           $journal->branch_id= $expenses->branch_id;
              $journal->notes= 'Fuel Refill On Credit Payment for Truck '.$t->truck_name. ' - '. $t->reg_no. ' with transaction id ' .$expenses->trans_id;
              $journal->currency_code =   $expenses->exchange_code;
              $journal->exchange_rate=  $expenses->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
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
        $journal->branch_id= $expenses->branch_id;
      $journal->added_by=auth()->user()->added_by;
      $journal->notes= 'Fuel Refill On Credit Payment for Truck '.$t->truck_name. ' - '. $t->reg_no. ' with transaction id ' .$expenses->trans_id;
        $journal->save();

 $bank_accounts=AccountCodes::where('account_id',$expenses->bank_id)->first() ;
if($bank_accounts->account_status == 'Bank'){
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
        $new['added_by']=auth()->user()->added_by;
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
                                'added_by' =>auth()->user()->added_by,
                            ]);

}

}

        return redirect(route('expenses.index'))->with(['success'=>'Approved Successfully']);
    }

    public function delete_list($id)
    {

      $expenses=Expenses::find($id);

          $total_multiple=Expenses::find($expenses->multiple_id);
if(!empty($total_multiple)){
$multiple=Expenses::where('multiple_id',$total_multiple->id)->sum('amount');
$m['amount']=$multiple -$expenses->amount;
$total_multiple->update($m);


if($multiple -$expenses->amount == '0'){
  Expenses::destroy($expenses->multiple_id);

}

}

 Expenses::destroy($id);
        return redirect(route('expenses.index'))->with(['success'=>'Deleted Successfully']);

    }


  public function multiple_approve(Request $request)
    {
        //
$trans_id= $request->checked_trans_id;
//dd($trans_id);

  if(!empty($trans_id)){
    for($i = 0; $i < count($trans_id); $i++){
   if(!empty($trans_id[$i])){

        $expenses= Expenses::find($trans_id[$i]);
        $data['status'] = 1;
        $expenses->update($data);
   
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
        $journal->added_by=auth()->user()->added_by;
        $journal->branch_id= $expenses->branch_id;
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
        $journal->branch_id= $expenses->branch_id;
        $journal->added_by=auth()->user()->added_by;
        $journal->notes= 'Expense Payment with transaction id ' .$expenses->name;
        $journal->save();

 $bank_accounts=AccountCodes::where('id',$expenses->bank_id)->first() ;
if($bank_accounts->account_status == 'Bank'){
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
        $new['added_by']=auth()->user()->added_by;
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
                                'added_by' =>auth()->user()->added_by,
                            ]);
}                            



 }
                  }
        return redirect(route('expenses.index'))->with(['success'=>'Approved Successfully']);
    }

else{
  return redirect(route('expenses.index'))->with(['error'=>'You have not chosen an entry']);
}

}
  

 public function findClient(Request $request)
    {
 
  $codes  =AccountCodes::find($request->id);
 if ($codes->account_name == 'Payables') {
$price="OK" ;
}


else{
$price='' ;
 }


                return response()->json($price);                      
 
    } 

public function multiple_pdfview(Request $request)
    {
        //
        $expenses =Expenses::find($request->id);
        if($expenses->view == '1'){
        $items=Expenses::where('multiple_id',$request->id)->get() ;;
        }
        else{
          $items=Expenses::where('id',$request->id)->get() ;;   
        }
        view()->share(['expenses'=>$expenses ,'items'=> $items]);

        if($request->has('download')){
        $pdf = PDF::loadView('expenses.list_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('PAYMENTS REF NO # ' .  $expenses->name . ".pdf");
        }
        return view('multiple_pdfview');
    }


 public function import(Request $request){
      
        
        $data = Excel::import(new ImportExpenses, $request->file('file')->store('files'));
        
        return redirect()->back()->with('success', 'File Imported Successfully');
    }
    
     public function sample(Request $request){

       $filepath = public_path('expense_sample.xlsx');
       return Response::download($filepath);
    }


 public function payment_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        

       
        if($request->isMethod('post')){
            $data=Expenses::where('status','1')->whereBetween('date',[$start_date,$end_date])->where('added_by',auth()->user()->added_by)->groupBy('account_id')->get();
        }else{
            $data=[];
        }
        return view('expenses.payment_report',
            compact('start_date',
                'end_date','data'));
    }

}
