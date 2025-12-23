<?php

namespace App\Http\Controllers\Fuel;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Payment_methodes;
use App\Models\PurchaseInventory;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Accounts;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\Fuel\Fuel;
use App\Models\Fuel\Refill;
use App\Models\Fuel\RefillPayment;

class RefillPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

                
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
        $sales =Refill::find($request->refill_id);

        if(($receipt['amount'] <= $sales->due_cost)){
            if( $receipt['amount'] >= 0){
                $receipt['trans_id'] = "TRFL".$request->refill_id. substr(str_shuffle(1234567890), 0, 4);
                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['fuel_id'] =$sales->fuel_id;
                 $receipt['supplier_id'] =$sales->supplier;

                //update due amount from invoice table
                $data['due_cost'] =  $sales->due_cost-$receipt['amount'];
                if($data['due_cost'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;
                }
                $sales->update($data);
                 
                $payment = RefillPayment::create($receipt);

                $truck=Truck::find($sales->truck);
                 $supp = Supplier::find($sales->supplier);
                  
               $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Payment';
                $journal->debit =$receipt['amount']   ;
                  $journal->payment_id= $payment->id;
                 $journal->truck_id=$sales->truck;
                 $journal->supplier_id= $sales->supplier;
               $journal->added_by=auth()->user()->added_by;
                  $journal->notes= 'Payment for Fuel Refill to Supplier ' . $supp->name.' for Truck '.$truck->truck_name. ' - '. $truck->reg_no;
                $journal->save();
            
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
               $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Payment';
              $journal->credit = $receipt['amount'] ;
              $journal->payment_id= $payment->id;
               $journal->supplier_id= $sales->supplier;
                  $journal->truck_id=$sales->truck;
                   $journal->added_by=auth()->user()->added_by;
                  $journal->notes= 'Payment for Fuel Refill to Supplier ' . $supp->name.' for Truck '.$truck->truck_name. ' - '. $truck->reg_no;
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
        $new['added_by']=auth()->user()->id;
$balance=0-$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Fuel Refill Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Fuel Refill Payment for truck ' .$truck->reg_no,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from fuel refill payment. Payment to Truck ' .$truck->reg_no ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
                              


                return redirect(route('refill_list'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('refill_list'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('refill_list'))->with(['error'=>'Amount should  be less than Total amount ']);

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
        $invoice = Refill::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get() ;
        return view('fuel.refill_payment',compact('invoice','payment_method','bank_accounts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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



      public function multiple_refill_payment()
    {
        //
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get() ;
           $supplier=Supplier::where('user_id',auth()->user()->added_by)->get() ;

        return view('fuel.multiple_refill_payment',compact('supplier','payment_method','bank_accounts'));
    }       


 public function save_multiple_payment(Request $request)
    {
        //

  $refill=Refill::where('supplier',$request->supplier)->where('status','!=','2')->orderBy('date', 'asc')->where('added_by',auth()->user()->added_by)->get() ;

if(!empty($refill[0])){
    
     $supp_name = Supplier::find($request->supplier);

                 $balance= str_replace(",","",$request->amount);
                  $remaining = 0;
               foreach($refill as $rfl){

    // check to see if there is enough to satisfy order amount

    if ($rfl->due_cost >= $balance) {
        $data['due_cost'] = $rfl->due_cost  - $balance;
         $cost=$balance;
        $balance = 0;
         $rem_balance = $balance;
         
      if( $data['due_cost'] > 0){
        $data['status']='1';   
      }
      
      else{
        $data['status']='2';   
      }
    } else {
        // allocate everything available
        $balance = $balance - $rfl->due_cost;
          $rem_balance = $balance;
      $cost=$rfl->due_cost;
       $data['due_cost'] = 0;
      $data['status']='2';
    }
   
//dd($cost);

 $sql=Refill::find($rfl->id)->update($data);


 $receipt['trans_id'] = "TRFL".$rfl->id.substr(str_shuffle(1234567890), 0, 4);
                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['fuel_id'] =$rfl->fuel_id;
                  $receipt['refill_id'] =$rfl->id;
                $receipt['amount']=$cost;
                  $receipt['date']=$request->date;
                 $receipt['payment_method']=$request->payment_method;
              $receipt['notes']=$request->notes;
            $receipt['account_id']=$request->account_id;
           $receipt['supplier_id']=$request->supplier;
                 
                $payment = RefillPayment::create($receipt);

 
                $truck=Truck::find($rfl->truck);
                    $supp = Supplier::find($request->supplier);
               $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Payment';
                $journal->debit =$receipt['amount']   ;
                  $journal->payment_id= $payment->id;
                   $journal->truck_id= $rfl->truck;
                 $journal->supplier_id=$request->supplier;
               $journal->added_by=auth()->user()->added_by;
                  $journal->notes= 'Payment for Fuel Refill to Supplier ' . $supp->name.' for Truck '.$truck->truck_name. ' - '. $truck->reg_no;
                $journal->save();
            
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
               $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Payment';
              $journal->credit = $receipt['amount'] ;
              $journal->payment_id= $payment->id;
               $journal->truck_id= $rfl->truck;
               $journal->supplier_id=$request->supplier;
                   $journal->added_by=auth()->user()->added_by;
                  $journal->notes= 'Payment for Fuel Refill to Supplier ' . $supp->name.' for Truck '.$truck->truck_name. ' - '. $truck->reg_no;
              $journal->save();

                
$account= Accounts::where('account_id',$request->account_id)->first();

if(!empty($account)){
$account_balance=$account->balance - $payment->amount ;
$item_to['balance']=$account_balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$payment->amount;
       $new[' exchange_code']=$sales->exchange_code;
        $new['added_by']=auth()->user()->id;
$account_balance=0-$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Fuel Refill Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Fuel Refill Payment for truck ' .$truck->reg_no,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$account_balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from fuel refill payment. Payment to Truck ' .$truck->reg_no ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
       
        if ($rem_balance != 0) {
        
        $remaining = $rem_balance;
    }                          
                       

   // we have already allocated required stock so no need to continue
    if ($balance === 0) {
        break;
    }


}

$rmb = $remaining;

if($rmb > 0){
$codes= AccountCodes::where('account_name','Refill Balance')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Balance';
                $journal->debit =$rmb ;
                 $journal->supplier_id=$request->supplier;
               $journal->added_by=auth()->user()->added_by;
                $journal->notes=  'Fuel Refill Balance to Supplier ' . $supp_name->name;
                $journal->save();
            
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
              $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Balance';
              $journal->credit =$rmb ;
             $journal->supplier_id=$request->supplier;
           $journal->added_by=auth()->user()->added_by;
            $journal->notes=  $journal->notes=  'Fuel Refill Balance to Supplier ' . $supp_name->name;
          $journal->save();

}

      
                return redirect(route('refill_list'))->with(['success'=>'Payment Added successfully']);
}

else{

  return redirect(route('multiple_refill_list'))->with(['error'=>'Entries Not Found']);
}


            }

   
     


}
