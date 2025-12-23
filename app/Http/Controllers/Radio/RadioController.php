<?php

namespace App\Http\Controllers\Radio;

use App\Http\Controllers\Controller;
use App\Models\Radio\Radio;
use App\Models\Radio\RadioItem;
use App\Models\Radio\RadioProgram;
use App\Models\Radio\RadioPayment;
use App\Models\Radio\RadioDueList;
use App\Models\Client;
use App\Models\Payment_methodes;
use Illuminate\Http\Request;
use PDF;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\Region;
use App\Models\District;
use Carbon\Carbon;
use  DateTime;



class RadioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         if(auth()->user()->client_id != null){
            $courier = Radio::where('owner_id',auth()->user()->client_id)->where('pickup','2')->get();     
         }else{
          $courier = Radio::where('added_by',auth()->user()->added_by)->where('pickup','2')->get();
         }

        $users = Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
       
        return view('radio.quotation',compact('courier','users'));
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
        $purchases = Radio::find($id);
        $purchase_items=RadioProgram::where('pacel_id',$id)->where('child','0')->get();
      $child=RadioItem::where('pacel_id',$id)->where('child','1')->where('start','0')->get();
     $chk=RadioItem::where('pacel_id',$id)->where('child','1')->first(); 
          $close=RadioItem::where('pacel_id',$id)->where('child','1')->where('start','1')->first(); 
        $payments=RadioPayment::where('pacel_id',$id)->get();
        
        return view('radio.quotation_details',compact('purchases','purchase_items','child','chk','close','payments'));
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
        $items = CourierItem::find($id);
        $data =  Courier::find($items->pacel_id);
        $route = Route::all();
          $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
        $name = CourierList::all();       
         $currency = Currency::all();
         $tariff= Tariff::where('client_id',$data->owner_id)->get();
         $from_district= District::where('region_id', $data->from_region_id)->get(); 
         $to_district= District::where('region_id', $items->to_region_id)->get();   
         $region = Region::all();
            $value='1';
        return view('courier.quotation',compact('data','id','users','name','route','items','currency','tariff','from_district','to_district','region','value'));
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
        $purchases=CourierItem::find($id);
       
    }




   public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
                if($type == 'client'){
               return view('radio.client_modal');
               
                }
             
              elseif($type == 'wbn'){
                    $old = Radio::find($id);
                    
                    $startDate = Carbon::parse($old->from_date);
                    $endDate = Carbon::parse($old->to_date);
                   $diff = $startDate->diffInDays($endDate);
                return view('radio.wbn',compact('id','old','diff'));   
                }
           
               
            elseif($type == 'view-child'){
              $old = RadioProgram::find($id);
               $items =RadioItem::where('parent_id',$id)->where('child','1')->where('disabled','0')->get();   
                return view('radio.view-child',compact('id','items','old'));   
                }
                
                elseif($type == 'approve'){
                    $old = Radio::find($id);
 
                return view('radio.approve',compact('id','old'));   
                }
            
                elseif($type == 'finish'){
                    $old = Radio::find($id);
 
                return view('radio.finish',compact('id','old'));   
                }
                
                 elseif($type == 'reject'){
                    $old = Radio::find($id);
 
                return view('radio.reject',compact('id','old'));   
                }

       
   }
   
   
    public function save_wbn(Request $request)
   {
       //
      $id=$request->id;
       $purchase = Radio::find($id);
       
       
        $begin = new DateTime($purchase->from_date);
          $end = new DateTime($purchase->to_date);
          
   //daily
if($request->type == 'Daily'){

    for($date = $begin; $date <= $end; $date->modify('+1 day')){
    if (date('N', strtotime($date->format('Y-m-d'))) <= 7) {
        $daterange[]=[
            'date'=>$date->format('Y-m-d'),
            'day'=>$date->format('l'),
        ];
    }
}

}

//weekday
elseif($request->type == 'Weekday'){
    for($date = $begin; $date <= $end; $date->modify('+1 day')){
    if (date('N', strtotime($date->format('Y-m-d'))) < 6) {
        $daterange[]=[
            'date'=>$date->format('Y-m-d'),
            'day'=>$date->format('l'),
        ];
    }
}
}

//weekend
elseif($request->type == 'Weekend'){
for($date = $begin; $date <= $end; $date->modify('+1 day')){
    if (date('N', strtotime($date->format('Y-m-d'))) >= 6) {
        $daterange[]=[
            'date'=>$date->format('Y-m-d'),
            'day'=>$date->format('l'),
        ];
    }
}
}

//dd($daterange);
$diff=count($daterange);
       
           $tx=1+0.18;
            $before_tax= $request->amount/$tx;
             $tax= $request->amount - $before_tax;
                         
        $data['pickup'] = 2;
         $data['wbn'] = $diff;
        $data['transmission'] = $request->transmission;
         $data['type'] = $request->type;
         $data['amount'] = $request->amount;
         $data['tax'] = $tax;
         $data['due_amount'] = $request->amount;
          $data['guest'] = $request->guest;
          $data['institution'] = $request->institution;
       $purchase->update($data);
       
       
                   


$nameArr =$request->transmission ;
$trackingArr =$request->tracking_id ;
$categoryArr =$request->category ;
$durArr =$request->duration ;
$timeArr =$request->air_time;
$programArr =$request->program;

    
      $i=0;
    if(!empty($diff)){
        foreach($daterange as $dr){
            
         
               $pro=$i+1;
              $reference=$purchase->confirmation_number.'/'.$pro;
               
                $items = array(
                 'wbn_no' =>$reference,
                 'date'=>$dr['date'],
                 'repetitive' =>$request->repetitive,
                  'added_by' => auth()->user()->added_by,
                   'order_no' =>$i,
                    'pacel_id' =>$id);

                RadioProgram::create($items);  ;
                
                $i++;
                
        }
        
        }
        
        
        $parent=RadioProgram::where('pacel_id',$id)->get();
       
        foreach($parent as $it){
                
         if(!empty($nameArr)){
        for($x = 0; $x < count($trackingArr); $x++){
              if(!empty($trackingArr[$x])){
                  
                  
              
            $before=RadioItem::where('parent_id',$it->id)->where('child','1')->latest('id')->first();
               if(!empty($before)){
               $xpro=$before->order_no + 1  ;           
              }
            else{
            $xpro=1;
              }
              
              
                if($it->order_no == 0){
                      
                      $time=$timeArr[$x];
                      
                      
                  }
                  
                  else{
                  
              if($request->repetitive == 'No'){
                  
                   $time='';   
                  }
                  
                  else{
                    $time=$timeArr[$x];  
                  }
                  
              }
              
              
             
              
              
               
                $xitems = array(
                 
                  'child' => 1,
                 'parent_id' => $it->id,
                'wbn_no' =>$it->wbn_no,
                'tracking_id' => $trackingArr[$x],
                'category' => $categoryArr[$x],
                'air_time' => $time,
                 'duration' => $durArr[$x],
                 'program' => $programArr[$x],
                 'date'=> $it->date,
                  'added_by' => auth()->user()->added_by,
                   'order_no' =>$x,
                    'pacel_id' =>$id);

                $new= RadioItem::create($xitems);  ;

            }
        }
        
         } 
                
                
                
                
        }              

         
       
  
 
       
           
      
       return redirect(route('radio_quotation.index'))->with(['success'=>'Created Successfully']);
   }


 
 public function receive($id)
    {
        //
         $it =  RadioProgram::find($id);
        $data =  Radio::find($it->pacel_id);
        $items =  RadioItem::where('pacel_id',$it->pacel_id)->where('parent_id',$id)->where('disabled','0')->get();;
          $users = Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
        
        return view('radio.quotation',compact('data','id','users','items','it'));
    }

  public function save_receive(Request $request)
    {
        //

if($request->update == '1'){


       

  return redirect(route('radio_quotation.show',$pacel->id))->with(['success'=>'Updated Successfully']);
}



else{
  $pacel= Radio::find($request->pacel_id);
 $trackingArr =$request->tracking_id ;
$categoryArr =$request->category ;
$durArr =$request->duration ;
$timeArr =$request->air_time;
$programArr =$request->program;
$expArr =$request->saved_id;
$remArr = $request->removed_id ;

if($request->amount > 0){
  $amount=  $request->amount;
   $due_amount=$request->amount; 
   
    $tx=1+0.18;
$before_tax= $request->amount/$tx;
$tax= $request->amount - $before_tax;
}

else{
  $amount=  $pacel->amount;
  $due_amount=$pacel->due_amount; 
$tax= $pacel->tax;  
}


if($pacel->status == 2 && $pacel->finish == 0){
 $status=0;
}

else{
  $status=$pacel->status;
}

 
                $t = array(
                   'request_date' => $request->request_date ,
                    'instructions' => $request->instructions ,
                    'amount' =>  $amount ,
                    'status' =>  $status ,
                    'due_amount' =>  $due_amount ,
                    'tax' =>    $tax);

                      Radio::where('id',$pacel->id)->update($t);  
                      
                      
                      
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    RadioItem::where('id',$remArr[$i])->update(['disabled'=> '1']);;        
                       }
                   }
               }



$it=RadioProgram::find($request->id);

    if(!empty($trackingArr)){
        for($x = 0; $x < count($trackingArr); $x++){
           if(!empty($trackingArr[$x])){
                 

                $items = array(
               'child' => 1,
              'parent_id' => $request->id,
             'wbn_no' =>$it->wbn_no,
             'tracking_id' => $trackingArr[$x],
             'category' => $categoryArr[$x],
             'air_time' => $timeArr[$x],
              'duration' => $durArr[$x],
              'program' => $programArr[$x],
              'date'=> $it->date,
               'added_by' => auth()->user()->added_by,
                'order_no' =>$x,
                 'pacel_id' =>$pacel->id);
                 
                 if(!empty($expArr[$x])){
                                 RadioItem::where('id',$expArr[$x])->update($items);  
          
          }
          else{
            RadioItem::create($items);   
          }

              


                  


            }
        }
       
         
    }    
       

  return redirect(route('radio_quotation.show',$pacel->id))->with(['success'=>'Saved Successfully']);
}


    

    }



  public function approve(Request $request)
   {
       //
       
       $nameArr =$request->due_list ;
       
         if(!empty($nameArr)){
       
       $purchase = Radio::find($request->id);
        $data['status'] = 1;
       $purchase->update($data);
       
       
       


                
       
        for($x = 0; $x < count($nameArr); $x++){
              if(!empty($nameArr[$x])){
                  
               
                $xitems = array(
                 
                  'due_list' =>$nameArr[$x],
                  'added_by' => auth()->user()->added_by,
                   'order_no' =>$x,
                    'pacel_id' =>$request->id);

                $new= RadioDueList::create($xitems);  ;

            }
        }
        
        return redirect(route('radio_quotation.index'))->with(['success'=>'Approved Successfully.']);
        
         } 

else{
    return redirect(route('radio_quotation.index'))->with(['error'=>'You have not entered the due list.']);
}
           
        
       
   }
  

  public function cancel(Request $request)
   {
       //
       $purchase = Radio::find($request->id);
       $data['status'] = 2;
       $data['reject'] = $request->reject;
       $purchase->update($data);


           
        
       return redirect(route('radio_quotation.index'))->with(['success'=>'Rejected Successfully.']);
   }

public function finish(Request $request)
   {
       //
       $purchase = Radio::find($request->id);
        $data['action_point'] = $request->action_point;
         $data['finish'] = 1;
       $purchase->update($data);
       
       if($purchase->program_type == 'Commercial'){
       
        $quot = Radio::find($id);
            $client=Client::find($quot->owner_id);
            
           $cr= AccountCodes::where('account_name','Radio Sales')->where('added_by', auth()->user()->added_by)->first();
          $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',$quot->request_date);
        $journal->date =   $quot->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'radio';
        $journal->name = 'Radio Invoice';
        $journal->credit = ($quot->amount - $quot->tax) *  $quot->exchange_rate;
        $journal->income_id= $id;
         $journal->branch_id= $quot->branch_id;
         if($quot->sales_type == 'Cash Sales'){
         $journal->user_id= $quot->user_id;
         }
         else{
          $journal->client_id= $quot->owner_id;   
         }
         $journal->currency_code =   $quot->currency_code;
        $journal->exchange_rate=  $quot->exchange_rate;
 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Radio Invoice with reference no " .$quot->confirmation_number. "  by Client ".  $client->name ;
        $journal->save();

if($quot->tax > 0){
       $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by', auth()->user()->added_by)->first();
          $journal = new JournalEntry();
        $journal->account_id = $tax->id;
          $date = explode('-',$quot->request_date);
        $journal->date =   $quot->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'radio';
        $journal->name = 'Radio Invoice';
        $journal->credit = $quot->tax *  $quot->exchange_rate;
        $journal->income_id= $id;
         $journal->branch_id= $quot->branch_id;
        if($quot->sales_type == 'Cash Sales'){
         $journal->user_id= $quot->user_id;
         }
         else{
          $journal->client_id= $quot->owner_id;   
         }
         $journal->currency_code =   $quot->currency_code;
        $journal->exchange_rate=  $quot->exchange_rate;
 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Radio Invoice Tax with reference no " .$quot->confirmation_number. "  by Client ".  $client->name ;
        $journal->save();
}

        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$quot->request_date);
        $journal->date =   $quot->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'radio';
        $journal->name = 'Radio Invoice';
        $journal->debit =$quot->amount  *  $quot->exchange_rate;
        $journal->income_id= $id;
        $journal->branch_id= $quot->branch_id;
            if($quot->sales_type == 'Cash Sales'){
         $journal->user_id= $quot->user_id;
         }
         else{
          $journal->client_id= $quot->owner_id;   
         }
         $journal->currency_code =   $quot->currency_code;
        $journal->exchange_rate=  $quot->exchange_rate;
 $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Radio Debit Receivables for Invoice with reference no " .$quot->confirmation_number. "  by Client ".  $client->name ;
        $journal->save();

       }           
      
       return redirect(route('radio_quotation.index'))->with(['success'=>'Closed Successfully']);
   }

 


  

  
   
   public function courier_pdfview(Request $request)
   {
       //
       $purchases = Radio::find($request->id);
       $purchase_items=RadioItem::where('pacel_id',$request->id)->where('disabled','0')->orderBy('date')->get();

       view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

       if($request->has('download')){
           if($purchases->finish == '1'){
       $pdf = PDF::loadView('radio.quotation_pdf')->setPaper('a4', 'potrait');
           }
           else{
            $pdf = PDF::loadView('radio.order_pdf')->setPaper('a4', 'potrait');   
               
           }
      return $pdf->download('RADIO ORDER NO # ' .  $purchases->confirmation_number . ".pdf");
       }
       return view('courier_pdfview');
   }

public function schedule_pdfview(Request $request)
 {
       //
       $purchases = Radio::find($request->id);
       $purchase_items=RadioItem::where('pacel_id',$request->id)->where('disabled','0')->orderBy('date')->get();

       view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

       if($request->has('download')){
       $pdf = PDF::loadView('radio.schedule_pdf')->setPaper('a4', 'potrait');
      return $pdf->download('RADIO ORDER TRANSMISSION # ' .  $purchases->confirmation_number . ".pdf");
       }
       return view('schedule_pdfview');
   }




 public function make_payment($id)
   {
       //
       $invoice = Radio::find($id);
       $payment_method = Payment_methodes::all();
  $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
       return view('radio.payment',compact('invoice','payment_method','bank_accounts'));
   }


public function save_payment(Request $request)
    {
        //

   $receipt = $request->all();
        $sales =Radio::find($request->pacel_id);


        if(($receipt['amount'] <= $sales->amount)){
            if( $receipt['amount'] > 0){
                $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
                $receipt['trans_id'] = $random;
                $receipt['added_by'] = auth()->user()->added_by;
                
                //update due amount from invoice table
                $data['due_amount'] =  $sales->due_amount-$receipt['amount'];
                if($data['due_amount'] != 0 ){
                $data['status'] = 1;
                }else{
                    $data['status'] = 2;
                }
                $sales->update($data);

               
                 
                $payment = RadioPayment::create($receipt);
                $client=Client::find($sales->owner_id);

        $cr= AccountCodes::where('id','$request->account_id')->first();
        $journal = new JournalEntry();
        $journal->account_id = $request->account_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'radio_payment';
        $journal->name = 'Invoice Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
        $journal->branch_id= $sales->branch_id;
        $journal->client_id= $sales->owner_id;
        $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
        $journal->notes= "Radio Payment for Clear Credit  with reference no " .$sales->confirmation_number. "  by Client ".  $client->name ;  
        $journal->save();


        $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'radio_payment';
        $journal->name = 'Invoice Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
        $journal->branch_id= $sales->branch_id;
        $journal->client_id= $sales->owner_id;
        $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
        $journal->notes= "Clear Radio Debtor  with reference no " .$sales->confirmation_number. "  by Client ".  $client->name ;   ;
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
                                'module' => 'Radio Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Radio Payment with reference' .$payment->trans_id,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Income',
                                'amount' =>$payment->amount ,
                                'credit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'paid_by' => $sales->owner_id,
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from radio payment.The Reference is ' .$sales->confirmation_number ,
                                'added_by' =>auth()->user()->added_by,
                            ]);

                return redirect(route('radio_quotation.index'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('radio_quotation.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('radio_quotation.index'))->with(['error'=>'Amount should  be less than Purchase amount ']);

        }


            }

 public function multiple_payment()
    {
        //
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
           $supplier=Driver::where('added_by',auth()->user()->added_by)->where('disabled', '0')->get(); 

        return view('courier.multiple_payment',compact('supplier','payment_method','bank_accounts'));
    }       


 public function save_multiple_payment(Request $request)
    {
        //

  $refill=PickupCosts::where('supplier',$request->supplier)->where('status','!=','2')->orderBy('date', 'asc')->where('added_by',auth()->user()->added_by)->get() ;

if(!empty($refill[0])){

                 $balance= str_replace(",","",$request->amount);
               foreach($refill as $rfl){

    // check to see if there is enough to satisfy order amount

    if ($rfl->due_cost >= $balance) {
        $data['due_cost'] = $rfl->due_cost  - $balance;
         $cost=$balance;
        $balance = 0;
         $data['status']='1';
    } else {
        // allocate everything available
        $balance = $balance - $rfl->due_cost;
      $cost=$rfl->due_cost;
       $data['due_cost'] = 0;
      $data['status']='2';
    }
   
//dd($cost);

 $sql=PickupCosts::find($rfl->id)->update($data);


 $receipt['trans_id'] = "TRANS_CPC-".$rfl->id.'-'. substr(str_shuffle(1234567890), 0, 1);
                $receipt['added_by'] = auth()->user()->added_by;
                $receipt['pacel_id'] =$rfl->pacel_id;
            $receipt['pickup_id'] =$rfl->id;
                $receipt['amount']=$cost;
                  $receipt['date']=$request->date;
                 $receipt['payment_method']=$request->payment_method;
              $receipt['notes']=$request->notes;
            $receipt['account_id']=$request->account_id;
           $receipt['supplier_id']=$request->supplier;
                 
                $payment = PickupPayment::create($receipt);

 
               $t=Driver::find($rfl->supplier);
                $movement=Courier::find($rfl->pacel_id);


               $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
                $journal = new JournalEntry();
                $journal->account_id = $codes->id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
                $journal->transaction_type = 'courier';
              $journal->name = 'Courier '.$rfl->type.'  Payment';
                $journal->debit =$receipt['amount']   ;
                  $journal->payment_id= $payment->id;
                 $journal->supplier_id=$request->supplier;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
               $journal->added_by=auth()->user()->added_by;
                  $journal->notes= 'Courier '.$rfl->type.'  with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
                $journal->save();
            
        
                $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
                $journal->transaction_type = 'courier';
              $journal->name = 'Courier '.$rfl->type.'  Payment';
              $journal->credit = $receipt['amount'] ;
              $journal->payment_id= $payment->id;
               $journal->supplier_id=$request->supplier;
                 $journal->currency_code =   'TZS';
                $journal->exchange_rate=  '1';
                   $journal->added_by=auth()->user()->added_by;
                  $journal->notes=  'Courier '.$rfl->type.'   with reference no ' .$movement->confirmation_number.' on Cash Payment to  '.$t->driver_name;
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
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->id;
$account_balance=0-$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Courier '.$rfl->type.'  Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
                                'code_id' => $codes->id,
                                'name' => 'Courier '.$rfl->type.'  Payment with reference no ' .$movement->confirmation_number. ' to ' .$t->driver_name,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Expense',
                                'amount' =>$payment->amount ,
                                'debit' => $payment->amount,
                                 'total_balance' =>$account_balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'payment_methods_id' =>$request->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from Courier '.$rfl->type.'  Payment . The reference is  ' .$movement->confirmation_number.' to '.$t->driver_name ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
                              

   // we have already allocated required stock so no need to continue
    if ($balance === 0) {
        break;
    }


}

      
                return redirect(route('courier.payment_list'))->with(['success'=>'Payment Added successfully']);
}

else{

  return redirect(route('courier.multiple_payment_list'))->with(['error'=>'Entries Not Found']);
}


            }






}
