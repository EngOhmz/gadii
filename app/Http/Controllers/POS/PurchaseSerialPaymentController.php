<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\POS\PurchasePayments;
use App\Models\POS\PurchaseSerialPayments;
use App\Models\JournalEntry;
use App\Models\Payment_methodes;
use App\Models\POS\Purchase;
use App\Models\POS\PurchaseSerial;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Accounts;

class PurchaseSerialPaymentController extends Controller
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
        $sales =PurchaseSerial::find($request->purchase_id);

         $count=PurchaseSerialPayments::count();
        $pro=$count+1;

        if(($receipt['amount'] <= $sales->due_amount)){
            if( $receipt['amount'] > 0){
                $receipt['trans_id'] = "TRANS_PS_".$pro;
                $receipt['added_by'] = auth()->user()->added_by;
                
                //update due amount from invoice table
                $data['due_amount'] =  $sales->due_amount-$receipt['amount'];
                if($data['due_amount'] != 0 ){
                $data['status'] = 2;
                }else{
                    $data['status'] = 3;
                }
                $sales->update($data);
                 
                $payment = PurchaseSerialPayments::create($receipt);

                $supp=Supplier::find($sales->supplier_id);

                $codes= AccountCodes::where('account_name','Payables')->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
              $journal->transaction_type = 'pos_serial_purchases_payment';
               $journal->name = 'Purchases Payment';
                $journal->debit =$receipt['amount'] *  $sales->exchange_rate;
                  $journal->payment_id= $payment->id;
                 $journal->currency_code =   $sales->exchange_code;
                $journal->exchange_rate=  $sales->exchange_rate;
                  $journal->added_by=auth()->user()->added_by;
                   $journal->notes= "Clear Creditor Purchase Order " .$sales->reference_no. " by Supplier ".  $supp->name ; ;
                $journal->save();
          
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
               $journal->transaction_type = 'pos_serial_purchases_payment';
               $journal->name = 'Purchases Payment';
              $journal->credit = $receipt['amount'] *  $sales->exchange_rate;
              $journal->payment_id= $payment->id;
               $journal->currency_code =   $sales->exchange_code;
              $journal->exchange_rate=  $sales->exchange_rate;
               $journal->added_by=auth()->user()->added_by;
                 $journal->notes= "Payment for Clear Credit Purchase Order " .$sales->reference_no. " by Supplier ".  $supp->name ; ;
              $journal->save();
    
 $account= Accounts::where('account_id',$request->account_id)->first();

if(!empty($account)){
$balance=$account->balance - $payment->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$payment->amount;
       $new[' exchange_code']=$sales->exchange_code;
        $new['added_by']=auth()->user()->added_by;
$balance=0-$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                               'module' => 'POS Serial Purchases Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'POS Purchases Payment with reference no ' .$sales->reference_no,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$payment->payment_method,
                               'paid_by' => $sales->supplier_id,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from pos purchases Payment. The Reference is ' .$sales->reference_no . ' by Supplier '.  $supp->name  ,
                                'added_by' =>auth()->user()->added_by,
                            ]);

                return redirect(route('purchase_serial.index'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('purchase_serial.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('purchase_serial.index'))->with(['error'=>'Amount should  be less than Purchase amount ']);

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
        $data=PurchaseSerialPayments::find($id);
        $invoice = PurchaseSerial::find($data->purchase_id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('pos.serial.purchase_edit_payments',compact('invoice','payment_method','data','id','bank_accounts'));
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
        $payment=PurchaseSerialPayments::find($id);

        $receipt = $request->all();
        $sales =PurchaseSerial::find($request->purchase_id);
       
        if(($receipt['amount'] <= $sales->due_amount)){
            if( $receipt['amount'] > 0){
                $receipt['added_by'] = auth()->user()->added_by;
                
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
                    $balance=$account->balance - $diff;
                }

                if($payment->amount > $receipt['amount']){
                    $diff=$payment->amount - $receipt['amount'];
                $balance =  $account->balance + $diff;
                }

$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$receipt['amount'];
       $new[' exchange_code']=$sales->exchange_code;
        $new['added_by']=auth()->user()->added_by;

$balance=0-$receipt['amount'];
     Accounts::create($new);
}
               
                if($data['due_amount'] != 0 ){
                $data['status'] = 2;
                }else{
                    $data['status'] = 3;
                }
                $sales->update($data);
                 
                $payment->update($receipt);

                $supp=Supplier::find($sales->supplier_id);

                 $codes= AccountCodes::where('account_name','Payables')->first();
                $journal = JournalEntry::where('transaction_type','inventory_payment')->where('payment_id', $payment->id)->whereNotNull('debit')->first();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
             $journal->transaction_type = 'pos_serial_purchases_payment';
               $journal->name = 'Purchases Payment';
                $journal->debit =$receipt['amount'] *  $sales->exchange_rate;
                  $journal->payment_id= $payment->id;
                 $journal->currency_code =   $sales->exchange_code;
                $journal->exchange_rate=  $sales->exchange_rate;
                  $journal->added_by=auth()->user()->added_by;
                   $journal->notes= "Clear Creditor Purchase Order " .$sales->reference_no. " by Supplier ".  $supp->name ; ;
                $journal->update();
          
        

                $journal = JournalEntry::where('transaction_type','inventory_payment')->where('payment_id', $payment->id)->whereNotNull('credit')->first();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
          $journal->transaction_type = 'pos_serial_purchases_payment';
               $journal->name = 'Purchases Payment';
              $journal->credit = $receipt['amount'] *  $sales->exchange_rate;
              $journal->payment_id= $payment->id;
               $journal->currency_code =   $sales->exchange_code;
              $journal->exchange_rate=  $sales->exchange_rate;
               $journal->added_by=auth()->user()->added_by;
                 $journal->notes= "Payment for Clear Credit Purchase Order " .$sales->reference_no. " by Supplier ".  $supp->name ; ;
              $journal->update();

 // save into tbl_transaction
                            $transaction= Transaction::where('module','POS Serial Purchases Payment')->where('module_id',$id)->update([
                             'module' => 'POS Serial Purchases Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'POS Purchases Payment with reference no ' .$sales->reference_no,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$payment->payment_method,
                               'paid_by' => $sales->supplier_id,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from pos purchases Payment. The Reference is ' .$sales->reference_no . ' by Supplier '.  $supp->name  ,
                                'added_by' =>auth()->user()->added_by,
                            ]);

                return redirect(route('purchase_serial.index'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('purchase_serial.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('purchase_serial.index'))->with(['error'=>'Amount should  be less than Purchase amount ']);

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
