<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Cotton\CottonPayment;
use App\Models\Cotton\SeedPayment;
use App\Models\JournalEntry;
use App\Models\Payment_methodes;
use App\Models\Cotton\InvoiceCotton;
use App\Models\Cotton\CottonClient;
use App\Models\Cotton\InvoiceSeed;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Accounts;

class SeedPaymentController extends Controller
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
        $sales =InvoiceSeed::find($request->invoice_id);

        if(($receipt['amount'] <= $sales->purchase_amount + $sales->purchase_tax)){
            if( $receipt['amount'] >= 0){
                $receipt['trans_id'] = "TRANS_SEED_".$request->invoice_id.'_'. substr(str_shuffle(1234567890), 0, 1);
                $receipt['added_by'] = auth()->user()->id;
                
                //update due amount from invoice table
                $data['due_amount'] =  $sales->due_amount-$receipt['amount'];
                if($data['due_amount'] != 0 ){
                $data['status'] = 2;
                }else{
                    $data['status'] = 3;
                }
                $sales->update($data);
                 
                $payment =SeedPayment::create($receipt);

                $supp=AccountCodes::find($sales->supplier_id);
                $journal = new JournalEntry();
                $journal->account_id =$sales->supplier_id;;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
               $journal->transaction_type = 'cotton_seed_payment';
                $journal->name = 'Cotton Seed Payment';
                $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
                  $journal->payment_id= $payment->id;
                 $journal->currency_code =   $sales->exchange_code;
                $journal->exchange_rate=  $sales->exchange_rate;
               $journal->client_id= $sales->supplier_id;
                     $journal->added_by=auth()->user()->id;
                   $journal->notes= "Clear Debtor  with reference no " .$sales->reference. " by Debtor ".  $supp->account_name ; ;
                $journal->save();
          
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
              $journal->transaction_type = 'cotton_seed_payment';
                $journal->name = 'Cotton Seed Payment';
              $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
              $journal->payment_id= $payment->id;
                $journal->client_id= $sales->supplier_id;
               $journal->currency_code =   $sales->exchange_code;
              $journal->exchange_rate=  $sales->exchange_rate;
                   $journal->added_by=auth()->user()->id;
                 $journal->notes= "Payment for Clear Credit  with reference no " .$sales->reference. "  by Debtor ".  $supp->account_name ; ;
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
       $new[' exchange_code']=$sales->exchange_code;
        $new['added_by']=auth()->user()->id;
$balance=$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Cotton Seed Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                  'code_id' => $sales->supplier_id,
                                'name' => 'Cotton Seed Payment with reference  ' .$sales->reference,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Income',
                                'amount' =>$payment->amount ,
                                'credit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$payment->payment_method,
                               'paid_by' => $sales->supplier_id,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from cotton seed payment. The Reference is ' .$sales->reference ,
                                'added_by' =>auth()->user()->id,
                            ]);

                return redirect(route('seed_sales.index'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('seed_sales.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('seed_sales.index'))->with(['error'=>'Amount should  be less than Purchase amount ']);

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
        $data=SeedPayment::find($id);
        $invoice =InvoiceSeed::find($data->invoice_id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('cotton.seed_edit_payment',compact('invoice','payment_method','data','id','bank_accounts'));
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
        $payment=SeedPayment::find($id);

        $receipt = $request->all();
        $sales =InvoiceSeed::find($request->invoice_id);
       
        if(($receipt['amount'] <= $sales->purchase_amount + $sales->purchase_tax)){
            if( $receipt['amount'] >= 0){
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
                $data['status'] = 2;
                }else{
                    $data['status'] = 3;
                }
                $sales->update($data);
                 
                $payment->update($receipt);

                $supp=AccountCodes::find($sales->supplier_id);
                $journal = JournalEntry::where('transaction_type','cotton_seed_payment')->where('payment_id', $payment->id)->whereNotNull('credit')->first();
               $journal->account_id =$sales->supplier_id;;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
               $journal->transaction_type = 'cotton_seed_payment';
                $journal->name = 'Cotton Seed Payment';
                $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
                  $journal->payment_id= $payment->id;
                 $journal->currency_code =   $sales->exchange_code;
                $journal->exchange_rate=  $sales->exchange_rate;
               $journal->client_id= $sales->supplier_id;
                     $journal->added_by=auth()->user()->id;
                   $journal->notes= "Clear Debtor  with reference no " .$sales->reference. " by Debtor ".  $supp->account_name ; ;
                $journal->update();
          
        

                $journal = JournalEntry::where('transaction_type','cotton_seed_payment')->where('payment_id', $payment->id)->whereNotNull('debit')->first();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
              $journal->transaction_type = 'cotton_seed_payment';
                $journal->name = 'Cotton Seed Payment';
              $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
              $journal->payment_id= $payment->id;
                $journal->client_id= $sales->supplier_id;
               $journal->currency_code =   $sales->exchange_code;
              $journal->exchange_rate=  $sales->exchange_rate;
                   $journal->added_by=auth()->user()->id;
                 $journal->notes= "Payment for Clear Credit  with reference no " .$sales->reference. "  by Debtor ".  $supp->account_name ; ;
              $journal->update();

 // save into tbl_transaction
                            $transaction= Transaction::where('module','Cotton Seed Payment')->where('module_id',$id)->update([
                                'module' => 'Cotton Seed Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                  'code_id' => $sales->supplier_id,
                                'name' => 'Cotton Seed Payment with reference  ' .$sales->reference,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Income',
                                'amount' =>$payment->amount ,
                                'credit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$payment->payment_method,
                               'paid_by' => $sales->supplier_id,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from cotton seed payment. The Reference is ' .$sales->reference ,
                                'added_by' =>auth()->user()->id,
                            ]);

                return redirect(route('seed_sales.index'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('seed_sales.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('seed_sales.index'))->with(['error'=>'Amount should  be less than Purchase amount ']);

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
