<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\MileagePayment;
use App\Models\JournalEntry;
use App\Models\Payment_methodes;
use App\Models\PurchaseInventory;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Accounts;
use Illuminate\Http\Request;
use App\Models\Mileage;
use App\Models\Truck;
use App\Models\Driver;

class MileagePaymentController extends Controller
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
        $sales =Mileage::find($request->mileage_id);

        if(($receipt['amount'] <= $sales->total_mileage)){
            if( $receipt['amount'] >= 0){
                $receipt['trans_id'] = "TRANS_MLG-".$request->mileage_id.'-'. substr(str_shuffle(1234567890), 0, 1).'-'.date('d/m/y');
                $receipt['added_by'] = auth()->user()->id;
                 $receipt['movement_id'] =$sales->movement_id;

                //update due amount from invoice table
                $data['due_mileage'] =  $sales->due_mileage-$receipt['amount'];
                if($data['due_mileage'] != 0 ){
                $data['payment_status'] = 1;
                }else{
                    $data['payment_status'] = 2;
                }
                $sales->update($data);
                 
                $payment = MileagePayment::create($receipt);

                 $driver=Driver::find( $sales->driver_id);
   $truck=Truck::find( $sales->truck_id);

               $codes= AccountCodes::where('account_name','Payables')->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
               $journal->transaction_type = 'mileage_payment';
                $journal->name = 'Mileage Payment';
                $journal->debit =$receipt['amount']   ;
                  $journal->payment_id= $payment->id;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
               $journal->added_by=auth()->user()->id;
                   $journal->notes= "Clear Creditor  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name ;
                $journal->save();
          
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
               $journal->transaction_type = 'mileage_payment';
                $journal->name = 'Mileage Payment';
              $journal->credit = $receipt['amount'] ;
              $journal->payment_id= $payment->id;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
                    $journal->added_by=auth()->user()->id;
                 $journal->notes= "Payment for Clear Credit   to Driver  ". $driver->driver_name ." driving Truck ".$truck->truck_name ;
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
                                'module' => 'Mileage Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Mileage Payment to  driver ' .$driver->driver_name,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from mileage payment. Driver ' .$driver->driver_name ." driving Truck ".$truck->truck_name ,
                                'added_by' =>auth()->user()->id,
                            ]);
                              


                return redirect(route('mileage'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('mileage'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('mileage'))->with(['error'=>'Amount should  be less than Purchase amount ']);

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
        $invoice = Mileage::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('mileage.mileage_payment',compact('invoice','payment_method','bank_accounts'));
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
      
     if($request->type == 'adjustment'){
            $adjust =  Mileage::find($id);
            $item['fuel_adjustment']=$request->fuel_adjustment;
            $item['reason']=$request->reason;
            $item['status_approve']='0';
            $adjust->update($item);

            return redirect(route('mileage'))->with(['success'=>'Mileage Adjustment Updated Successfully']);

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

public function mileage()
    {
        //
        $fuel = Mileage::all();    
        return view('mileage.mileage',compact('fuel'));
    }

 public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                 $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
                 if($type == 'refill'){
                    return view('fuel.addrefill',compact('id','bank_accounts'));
                
                 }elseif($type == 'adjustment'){
                    $data = Mileage::find($id);
                 return view('mileage.addadjustment',compact('id','data'));  
                 }

                 }


           public function approve($id)
    {
        //
        $fuel = Mileage::find($id);

        $data['status_approve'] = 1;
         $data['approved_by'] = auth()->user()->id;;
        $data['total_mileage']=$fuel->total_mileage + $fuel->fuel_adjustment;
        $data['due_mileage']=$fuel->due_mileage + $fuel->fuel_adjustment;
        $fuel->update($data);

    $driver=Driver::find( $fuel->driver_id);
   $truck=Truck::find( $fuel->truck_id);

              
    $journal = JournalEntry::where('transaction_type','mileage')->where('income_id', $id)->whereNotNull('debit')->first();
  $journal->debit = $fuel->total_mileage ;
  $journal->update();


 
  $journal = JournalEntry::where('transaction_type','mileage')->where('income_id', $id)->whereNotNull('credit')->first();
  $journal->credit =$fuel->total_mileage ;
  $journal->update();

        return redirect(route('mileage'))->with(['success'=>'Approved Successfully']);
    }


}
