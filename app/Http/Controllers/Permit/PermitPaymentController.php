<?php

namespace App\Http\Controllers\Permit;

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
use App\Models\Permit\Permit;
use App\Models\Permit\PermitType;
use App\Models\Permit\PermitPayment;
use App\Models\Truck;
use App\Models\Driver;
use App\Models\CargoLoading;
use App\Models\CargoCollection;

class PermitPaymentController extends Controller
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
        $sales =Permit::find($request->permit_id);

        if(($receipt['amount'] <= $sales->total_permit)){
            if( $receipt['amount'] >= 0){
                $receipt['trans_id'] = "TPRMT".$request->permit_id.substr(str_shuffle(1234567890), 0, 4);
                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['movement_id'] =$sales->movement_id;

                //update due amount from invoice table
                $data['due_permit'] =  $sales->due_permit-$receipt['amount'];
                if($data['due_permit'] != 0 ){
                $data['payment_status'] = 1;
                }else{
                    $data['payment_status'] = 2;
                }
                $sales->update($data);
                 
                $payment = PermitPayment::create($receipt);

                 $driver=Driver::find( $sales->driver_id);
   $truck=Truck::find( $sales->truck_id);

               $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
               $journal->transaction_type = 'permit_payment';
                $journal->name = 'Permit Payment';
                $journal->debit =$receipt['amount']   ;
                  $journal->payment_id= $payment->id;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
               $journal->added_by=auth()->user()->added_by;
                   $journal->notes= "Clear Creditor  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name ;
                $journal->save();
          
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
               $journal->transaction_type = 'permit_payment';
                $journal->name = 'Permit Payment';
              $journal->credit = $receipt['amount'] ;
              $journal->payment_id= $payment->id;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
                    $journal->added_by=auth()->user()->added_by;
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
        $new['added_by']=auth()->user()->added_by;
$balance=0-$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Permit Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Permit Payment to  driver ' .$driver->driver_name,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from permit payment. Driver ' .$driver->driver_name ." driving Truck ".$truck->reg_no ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
                              


                return redirect(route('permit'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('permit'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('permit'))->with(['error'=>'Amount should  be less than Permit amount ']);

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
        $invoice = Permit::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get() ;
        return view('permit.permit_payment',compact('invoice','payment_method','bank_accounts'));
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
            $adjust =  Permit::find($id);
            
            

             if($request->fuel_adjustment > 0){ 
            $item['permit_adjustment']=$request->fuel_adjustment ;
            }
          else{
          $item['permit_adjustment']= $request->road_toll + $request->toll_gate + $request->council + $request->consultant;
        }

            $item['reason']=$request->reason;
            $item['status_approve']='0';
            $adjust->update($item);

                         if(!empty($request->road_id)){
                       $road= PermitType::find($request->road_id);
                         $rpmt['adjustment']=$request->road_toll;
                          $road->update($rpmt);
                         }
                         
                         if(!empty($request->toll_id)){ 
                       $toll= PermitType::find($request->toll_id);
                         $tpmt['adjustment']=$request->toll_gate;
                          $toll->update($tpmt);
                         }
                         
                          if(!empty($request->council_id)){
                       $cnc= PermitType::find($request->council_id);
                         $cnpmt['adjustment']=$request->council;
                          $cnc->update($cnpmt);
                          }
                          
                         if(!empty($request->consultant_id)){
                       $c= PermitType::find($request->consultant_id);
                         $cpmt['adjustment']=$request->consultant;
                          $c->update($cpmt);
                                        }
      
            return redirect(route('permit'))->with(['success'=>'Permit Adjustment Updated Successfully']);

        }

else if($request->type == 'date'){
            $adjust =  Permit::find($id);
            $item['date']=$request->date;
            $adjust->update($item);
            
              $date = explode('-',$request->date);
    $journal = JournalEntry::where('transaction_type','permit')->where('income_id', $id)->where('added_by',auth()->user()->added_by)->update([
    'date'=>  $request->date,
    'year' => $date[0],
    'month' => $date[1],
    ]);

            return redirect(route('permit'))->with(['success'=>'Date Adjustment Updated Successfully']);

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

public function permit()
    {
        //
        $fuel = Permit::where('added_by', auth()->user()->added_by)->where('total_permit', '!=', '0')->orderBy('date', 'desc')->get();    
        return view('permit.permit',compact('fuel'));
    }

 public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                 $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get() ;
                 if($type == 'refill'){
                    return view('fuel.addrefill',compact('id','bank_accounts'));
                
                 }elseif($type == 'adjustment'){
                    $data = Permit::find($id);
                  $type=PermitType::where('permit_id',$id)->get();
                 return view('permit.addadjustment',compact('id','data','type'));  
                 }
                  elseif($type == 'view'){
                  $type=PermitType::where('permit_id',$id)->get();
                 $total=PermitType::where('permit_id',$id)->sum('value');
                 return view('permit.view_type',compact('id','type','total'));  
                 }
              elseif($type == 'date'){
                    $data = Permit::find($id);
                 return view('permit.edit_date',compact('id','data'));  
                 }
                 
                 }


           public function approve($id)
    {
        //
        $fuel = Permit::find($id);

        $data['status_approve'] = 1;
         $data['approved_by'] = auth()->user()->id;;
        $data['total_permit']=$fuel->total_permit + $fuel->permit_adjustment;
        $data['due_permit']=$fuel->due_permit + $fuel->permit_adjustment;
        $fuel->update($data);

    $driver=Driver::find( $fuel->driver_id);
   $truck=Truck::find( $fuel->truck_id);

         $type=PermitType::where('permit_id',$id)->get();
             foreach($type as $t){      
    $journal = JournalEntry::where('transaction_type','permit')->where('income_id', $id)->where('reference', $t->type)->whereNotNull('debit')->where('added_by',auth()->user()->added_by)->first();
  $journal->debit = $t->value + $t->adjustment;;
  $journal->update();


 
  $journal = JournalEntry::where('transaction_type','permit')->where('income_id', $id)->where('reference', $t->type)->whereNotNull('credit')->where('added_by',auth()->user()->added_by)->first();
  $journal->credit =$t->value + $t->adjustment;;
  $journal->update();

         $items['value']=$t->value + $t->adjustment;;
          PermitType::where('id',$t->id)->update($items);

$p= PermitType::where('id',$t->id)->first();
 $movement=CargoLoading::find($p->movement_id);

                    if($t->type =='Road Toll'){
                          $toll['road_toll']=$p->value;
                       }else if($t->type =='Toll Gate'){
                         $toll['toll_gate']=$p->value;
                        }else if($t->type =='Council'){
                            $toll['council']=$p->value;
                           }else if($t->type =='Consultant'){
                          $toll['consultant']=$p->value;
                        }

                 $movement->update($toll);

}

        return redirect(route('permit'))->with(['success'=>'Approved Successfully']);
    }
    
    
    public function multiple_permit()
    {
        //
        $fuel = Permit::where('added_by',auth()->user()->added_by)->where('total_permit', '!=', '0')->where('payment_status','!=','2')->orderBy('date', 'desc')->get();   
         $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('added_by',auth()->user()->added_by)->get() ; 
        return view('permit.multiple_permit_payment',compact('fuel','payment_method','bank_accounts'));
    }

 public function multiple_approve(Request $request)
    {
        //
$trans_id= $request->checked_trans_id;


  if(!empty($trans_id)){
    for($i = 0; $i < count($trans_id); $i++){
   if(!empty($trans_id[$i])){

        $expenses= Permit::find($trans_id[$i]);
        

          $receipt['trans_id'] = "TPRMT".$trans_id[$i].substr(str_shuffle(1234567890), 0, 4);
          $receipt['added_by'] = auth()->user()->added_by;
          $receipt['movement_id'] =$expenses->movement_id;
          $receipt['amount']=$expenses->due_permit;
           $receipt['date']=$request->date;
          $receipt['payment_method']=$request->payment_method;
           $receipt['notes']=$request->notes;
            $receipt['account_id']=$request->account_id;
        $receipt['permit_id']=$trans_id[$i];

       $payment = PermitPayment::create($receipt);

      $data['payment_status'] = 2;
       $data['due_permit'] = 0 ;
        $expenses->update($data);
   
    $driver=Driver::find($expenses->driver_id);
   $truck=Truck::find( $expenses->truck_id);

               $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
              $journal->transaction_type = 'permit_payment';
                $journal->name = 'Permit Payment';
                $journal->debit =$receipt['amount']   ;
                  $journal->payment_id= $payment->id;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
               $journal->added_by=auth()->user()->added_by;
                   $journal->notes= "Clear Creditor  to Driver  ". $driver->driver_name ." with Truck ".$truck->truck_name ;
                $journal->save();
          
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
              $journal->transaction_type = 'permit_payment';
                $journal->name = 'Permit Payment';
              $journal->credit = $receipt['amount'] ;
              $journal->payment_id= $payment->id;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
                    $journal->added_by=auth()->user()->added_by;
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
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                         $transaction= Transaction::create([
                            'module' => 'Permit Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Permit Payment to  driver ' .$driver->driver_name,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from permit payment. Driver ' .$driver->driver_name ." driving Truck ".$truck->reg_no ,
                                'added_by' =>auth()->user()->added_by,
                            ]);



 }
                  }
        return redirect(route('multiple_permit'))->with(['success'=>'Payment Added Successfully']);
    }

else{
  return redirect(route('multiple_permit'))->with(['error'=>'You have not chosen an entry']);
}

}





}
