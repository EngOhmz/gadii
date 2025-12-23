<?php

namespace App\Http\Controllers\Pacel;

use App\Http\Controllers\Controller;
use App\Models\orders\OrderMovement;
use App\Models\Pacel\Pacel;
use App\Models\Pacel\PacelPayment;
use App\Models\Pacel\PacelInvoice;
use App\Models\Pacel\PacelInvoiceItem;
use App\Models\Payment_methodes;
use App\Models\Route;
use Illuminate\Http\Request;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;

class PacelPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $receipt = $request->all();
        $sales =PacelInvoice::find($request->pacel_id);

        if(($receipt['amount'] <= $sales->amount)){
            if( $receipt['amount'] >= 0){
                $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                $receipt['trans_id'] = "TPCL".$request->pacel_id.$random;
                $receipt['added_by'] = auth()->user()->added_by;
                
                //update due amount from invoice table
                $data['due_amount'] =  $sales->due_amount-$receipt['amount'];
                if($data['due_amount'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;
                }
                $sales->update($data);

               
                 
                $payment = PacelPayment::create($receipt);

          $cr= AccountCodes::where('id','$request->account_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->account_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'cargo_payment';
        $journal->name = 'Cargo Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Payment for Clear Credit  with reference no " .$sales->pacel_number  ;
        $journal->save();


        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'cargo_payment';
        $journal->name = 'Cargo Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
                 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Clear Debitor  with reference no " .$sales->pacel_number  ;
        $journal->save();


$account= Accounts::where('account_id',$request->account_id)->first();

if(!empty($account)){
$balance=$account->balance + $payment->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= $payment->amount;
       $new[' exchange_code']= $sales->currency_code;
        $new['added_by']=auth()->user()->added_by;
$balance=$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'Cargo Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Cargo Payment with reference' .$payment->trans_id,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Income',
                                'amount' =>$payment->amount ,
                                'credit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'paid_by' => $sales->owner_id,
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from cargo payment.The Reference is ' .$sales->pacel_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
                            

                return redirect(route('pacel.invoice'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('pacel.invoice'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('pacel.invoice'))->with(['error'=>'Amount should  be less than Purchase amount ']);

        }
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
        $data=PacelPayment::find($id);
        $invoice = PacelInvoice::find($data->pacel_id);
        $payment_method = Payment_methodes::all();
       $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('pacel.pacel_edit_payment',compact('invoice','payment_method','data','id','bank_accounts'));
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
        $payment=PacelPayment::find($id);

        $receipt = $request->all();
        $sales =PacelInvoice::find($request->pacel_id);

        if(($receipt['amount'] <= $sales->amount)){
            if( $receipt['amount'] >= 0){
                $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                $receipt['added_by'] = auth()->user()->id;
                
                //update due amount from invoice table
                if($payment->amount <= $receipt['amount']){
                    $diff=$receipt['amount']-$payment->amount;
                $data['due_amount'] =  $sales->due_amount-$diff;
                }

                if($payment->amount > $receipt['amount']){
                    $diff=$payment->amount - $receipt['amount'];
                $data['due_amount'] =  $sales->due_amount + $diff;
                }

$account= Accounts::where('account_id',$request->account_id)->first();

if(!empty($account)){

    if($payment->amount <= $receipt['amount']){
                    $diff=$receipt['amount']-$payment->amount;
                    $balance=$account->balance + $diff;
                }

                if($payment->amount > $receipt['amount']){
                    $diff=$payment->amount - $receipt['amount'];
                $balance =  $account->balance - $diff;
                }

$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= $receipt['amount'];
       $new[' exchange_code']=$sales->exchange_code;
        $new['added_by']=auth()->user()->id;

$balance=$receipt['amount'];
     Accounts::create($new);
}

              
                if($data['due_amount'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;
                }
                $sales->update($data);

              
                 
                $payment->update($receipt);

                     $cr= AccountCodes::where('id','$request->account_id')->first();
          $journal =JournalEntry::where('transaction_type','cargo_payment')->where('payment_id', $payment->id)->whereNotNull('debit')->first();
        $journal->account_id = $request->account_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'cargo_payment';
        $journal->name = 'Invoice Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
           $journal->notes= "Payment for Clear Credit  with reference no " .$sales->pacel_number  ;
        $journal->update();


        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
         $journal =JournalEntry::where('transaction_type','cargo_payment')->where('payment_id', $payment->id)->whereNotNull('credit')->first();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'cargo_payment';
        $journal->name = 'Invoice Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
           $journal->notes= "Clear Creditor  with reference no " .$sales->pacel_number  ;
       $journal->update();



        
   // save into tbl_transaction
                             $transaction= Transaction::where('module','Cargo Payment')->where('module_id',$id)->update([
                                'module' => 'Cargo Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Cargo Payment with reference ' .$payment->trans_id,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Income',
                                'amount' =>$payment->amount ,
                                'credit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'paid_by' => $sales->owner_id,
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from cargo payment.The Reference is ' .$sales->pacel_number ,
                                'added_by' =>auth()->user()->id,
                            ]);


                return redirect(route('pacel.invoice'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('pacel.invoice'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('pacel.invoice'))->with(['error'=>'Amount should  be less than Purchase amount ']);

        }
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
