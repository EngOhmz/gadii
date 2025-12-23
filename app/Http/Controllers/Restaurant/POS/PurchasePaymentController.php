<?php

namespace App\Http\Controllers\Restaurant\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Restaurant\POS\Activity;
use App\Models\Restaurant\POS\PurchasePayments;
use App\Models\JournalEntry;
use App\Models\Payment_methodes;
use App\Models\Restaurant\POS\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\Restaurant\POS\Supplier as POSSupplier;
use App\Models\User;
use PDF;

class PurchasePaymentController extends Controller
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
        $sales =Purchase::find($request->purchase_id);

          $count=PurchasePayments::count();
        $pro=$count+1;

        if(($receipt['amount'] <= $sales->due_amount)){
            if( $receipt['amount'] >= 0){
                $receipt['trans_id'] = "TRANS_RPP_".$pro;
                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['account_id'] = $request->account_id;

                $payment = PurchasePayments::create($receipt);


                    return redirect(route('restaurant_purchase.show',$request->purchase_id))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('restaurant_purchase.show',$request->purchase_id))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
             return redirect(route('restaurant_purchase.show',$request->purchase_id))->with(['error'=>'Amount should  be less than Purchase amount']);

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
        $data=PurchasePayments::find($id);
        $invoice = Purchase::find($data->purchase_id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
        return view('restaurant.pos.purchases.purchase_edit_payments',compact('invoice','payment_method','data','id','bank_accounts'));
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
      $payment=PurchasePayments::find($id);

        $receipt = $request->all();
        $sales =Purchase::find($request->purchase_id);
       
        if(($receipt['amount'] <= $sales->due_amount)){
            if( $receipt['amount'] >= 0){

                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['account_id'] = $request->account_id;
                $receipt['added_by'] = auth()->user()->added_by;
                
                 
                $payment->update($receipt);

                return redirect(route('restaurant_purchase.show',$request->purchase_id))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('restaurant_purchase.show',$request->purchase_id))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('restaurant_purchase.show',$request->purchase_id))->with(['error'=>'Amount should  be less than Purchase amount ']);

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

     $purchase = PurchasePayments::find($id);        
   PurchasePayments::find($id)->delete();

       return redirect(route('restaurant_purchase.show',$purchase->purchase_id))->with(['success'=>'Deleted successfully']);
    }


    public function first_approval($id)
    {
        //
        $purchase = PurchasePayments::find($id);
        $data['approval_1'] = auth()->user()->id;
        $data['approval_1_date'] =date('Y-m-d');
        $purchase->update($data);

    if(!empty($purchase)){
             $p=PurchasePayments::find($id);
               $user=User::find($p->approval_1);
                 $sales =Purchase::find($p->purchase_id);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase Payments',
                            'activity'=>"First Approval of Purchase Payment with reference no " .  $sales->reference_no. " by " .$user->name ,
                        ]
                        );                      
       }

         return redirect(route('restaurant_purchase.show',$purchase->purchase_id))->with(['success'=>'First Approval is  successfully']);

    }

    public function final_approval($id)
    {
        //
       $purchase = PurchasePayments::find($id);
        $data['approval_2'] = auth()->user()->id;
      $data['approval_2_date'] =date('Y-m-d');
        $purchase->update($data);

    if(!empty($purchase)){
             $p=PurchasePayments::find($id);
               $user=User::find($p->approval_2);
                 $sales =Purchase::find($p->purchase_id);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase Payments',
                            'activity'=>"Final Approval of Purchase Payment with reference no " .  $sales->reference_no. " by " .$user->name ,
                        ]
                        );                      
       }

      return redirect(route('restaurant_purchase.show',$purchase->purchase_id))->with(['success'=>'Final Approval is  successfully']);
    }



    public function first_disapproval($id)
    {
        //
        $purchase =PurchasePayments::find($id);
          $data['approval_1'] = '';
      $data['approval_1_date'] ='';
        $purchase->update($data);

    if(!empty($purchase)){
               $user=User::find(auth()->user()->id);
               $sales =Purchase::find($purchase->purchase_id);
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                           'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Purchase Payments',
                            'activity'=>"First Approval has been reversed for Purchase Payment with reference no " .  $sales->reference_no. " by " .$user->name ,
                        ]
                        );                      
       }

      return redirect(route('restaurant_purchase.show',$purchase->purchase_id))->with(['success'=>'Disapproval is  successfully']);
    }



    public function confirm($id)
    {
        //
         
          $receipt=PurchasePayments::find($id);
           $sales =Purchase::find($receipt->purchase_id);

        if(($receipt->amount <= $sales->due_amount)){
            if( $receipt->amount >= 0){

                //update due amount from invoice table
                $data['due_amount'] =  $sales->due_amount-$receipt->amount;
                if($data['due_amount'] != 0 ){
                $data['status'] = 2;
                }else{
                    $data['status'] = 3;
                }

                $sales->update($data);                 
                 PurchasePayments::where('id',$id)->update(['status' => '1']);

                $payment = PurchasePayments::find($id);

                $supp=Supplier::find($sales->supplier_id);

                $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$payment->date);
                $journal->date =   $payment->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
              $journal->transaction_type = 'restaurant_pos_purchases_payment';
               $journal->name = 'Restaurant Purchases Payment';
                $journal->debit =$receipt->amount *  $sales->exchange_rate;
                $journal->payment_id= $payment->id;
              $journal->supplier_id= $sales->supplier_id;
                 $journal->currency_code =   $sales->exchange_code;
                $journal->exchange_rate=  $sales->exchange_rate;
                  $journal->added_by=auth()->user()->added_by;
                   $journal->notes= "Clear Creditor Purchase Order " .$sales->reference_no. " by Supplier ".  $supp->name ; ;
                $journal->save();
          
        
                $journal = new JournalEntry();
              $journal->account_id = $payment->account_id;
              $date = explode('-',$payment->date);
              $journal->date =   $payment->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
              $journal->transaction_type = 'restaurant_pos_purchases_payment';
               $journal->name = 'Restaurant Purchases Payment';
              $journal->credit = $receipt->amount *  $sales->exchange_rate;
              $journal->payment_id= $payment->id;
           $journal->supplier_id= $sales->supplier_id;
               $journal->currency_code =   $sales->exchange_code;
              $journal->exchange_rate=  $sales->exchange_rate;
               $journal->added_by=auth()->user()->added_by;
                 $journal->notes= "Payment for Clear Credit Purchase Order " .$sales->reference_no. " by Supplier ".  $supp->name ; ;
              $journal->save();
    
 $account= Accounts::where('account_id',$payment->account_id)->first();

if(!empty($account)){
$balance=$account->balance - $payment->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$payment->account_id)->first();

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
                               'module' => 'Restaurant POS Purchases Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $payment->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Restaurant POS Purchases Payment with reference no ' .$sales->reference_no,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($payment->date)),
                                'payment_methods_id' =>$payment->payment_method,
                               'paid_by' => $sales->supplier_id,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from bar pos purchases Payment. The Reference is ' .$sales->reference_no . ' by Supplier '.  $supp->name  ,
                                'added_by' =>auth()->user()->added_by,
                            ]);

             
           if(!empty($payment)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
 'user_id'=>auth()->user()->id,
                            'module_id'=>$payment->id,
                             'module'=>'Purchase Payment',
                            'activity'=>"Purchase with reference no  " .  $sales->reference_no. "  is Paid",
                        ]
                        );                      
       }

                
                return redirect(route('restaurant_purchase.index'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('restaurant_purchase.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('restaurant_purchase.index'))->with(['error'=>'Amount should  be less than Purchase amount ']);

        }

    }



public function inv_pdfview(Request $request)
    {
        //
          $data=PurchasePayments::find($request->id);
        $purchase = Purchase::find($data->purchase_id);
      

        view()->share(['purchase'=>$purchase,'data'=> $data]);

        if($request->has('download')){
        $pdf = PDF::loadView('restaurant.pos.purchases.payment_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('ORDER PURCHASES PAYMENT REF NO # ' .  $data->trans_id . ".pdf");
        }
        return view('inv_pdfview');
    }


}
