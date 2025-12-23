<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Hotel\Client;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelItems;
use App\Models\Hotel\HouseType;
use App\Models\Hotel\RoomType;
use App\Models\Hotel\Invoice;
use App\Models\Hotel\InvoiceItems;
use App\Models\Hotel\InvoicePayments;
use App\Models\Hotel\InvoiceHistory;
use App\Models\Restaurant\POS\Activity;
use App\Models\Hotel\Booked;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Payment_methodes;
use App\Models\Branch;
use App\Models\User;
use PDF;
use DB;
use DateTime;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currency= Currency::all();
        $invoices=Invoice::where('added_by',auth()->user()->added_by)->orderBy('created_at', 'desc')->get();
        $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();    
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
          $location=Hotel::where('status',1)->where('added_by', auth()->user()->added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        $type="";
       return view('hotel.booking.invoice',compact('client','currency','invoices','type','bank_accounts','user','branch','location'));
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
        $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(6/strlen($x)) )),1,6);
        $count=Invoice::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $hx=Hotel::find($request->hotel_id);
        
        $words = preg_split("/\s+/", $hx->name);
        $acronym = "";
        
        foreach ($words as $w) {
          $acronym .= mb_substr($w, 0, 1);
        }
        $a=strtoupper($acronym);
        //dd($a);
        
        
        $count=Invoice::where('added_by', auth()->user()->added_by)->count();
        $data['reference_no']=  $a.$random.$pro;
         $data['check_in']=$request->start_date;
        $data['client_id']=$request->client_id;
        $data['invoice_date']=date('Y-m-d');
        $data['hotel_id']=$request->hotel_id;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['branch_id']=$request->branch_id;
        $data['invoice_tax']='1';
        $data['status']='0';
        $data['sales_type']=$request->sales_type;
        $data['bank_id']=$request->bank_id;
       //$data['status']='1';

       $data['user_id']= auth()->user()->id;
       $data['user_agent']= $request->user_agent;
        $data['added_by']= auth()->user()->added_by;

        $invoice = Invoice::create($data);
        

        $nameArr =$request->room_name ;
        $priceArr =$request->price ;
        $nightsArr =$request->nights ;
        $typeArr =$request->room_type ;
        $dateArr = $request->end_date  ;
        $timeArr = $request->checkout_time;
        $costArr = str_replace(",","",$request->total_cost)  ;


      $amountArr = str_replace(",","",$request->subtotal);
  

     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $amountArr[$i],
                     'invoice_tax' => '0',                     
                        'due_amount' =>  $amountArr[$i]);

                       Invoice::where('id',$invoice->id)->update($t);  


            }
        }
    } 

        

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                
                /*    
                $var = explode('-',$dateArr[$i]);
               $start_date = date('Y-m-d',strtotime($var[0]));
               $end_date = date('Y-m-d',strtotime($var[1]));
               */
               
               $se=$request->start_date ." - ".$dateArr[$i] ;
                    
                    $items = array(
                    'room_id' => $nameArr[$i],
                    'room_type' =>$typeArr[$i],
                    'dates' =>  $se,
                    'check_in' =>  $request->start_date,
                    'check_out' => $dateArr[$i],
                    'checkout_time' =>  $timeArr[$i],
                    'price' =>  $priceArr[$i],
                    'nights' =>  $nightsArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'items_id' => $nameArr[$i],
                    'order_no' => $i,
                    'added_by' => auth()->user()->added_by,
                    'hotel_id' =>$request->hotel_id,
                    'invoice_id' =>$invoice->id);
                       
                    InvoiceItems::create($items);  ;
    
    
                }
            }
            
           
        }  
        
        
 
    if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                            'user_id'=>auth()->user()->id,
                            'module_id'=>$invoice->id,
                             'module'=>'Property',
                            'activity'=>"Property Invoice with reference no  " .  $invoice->reference_no. "  is Created",
                        ]
                        );                      
       }

         
         
 if($invoice->sales_type == 'Cash Sales'){

            
            
            $it=InvoiceItems::where('invoice_id',$invoice->id)->get();
            foreach($it as $i){
               
               
               if($i->check_in == date('Y-m-d') ){
                   $status = 1;
               }
               else{
                    $status = 0;
               }
               
                $lists= array(
                        'quantity' =>  1,
                        'price' =>  $i->total_cost,
                        'room_type'=>$i->room_type,
                        'room_id' => $i->room_id,
                         'added_by' => auth()->user()->added_by,
                         'client_id' =>   $data['client_id'],
                         'hotel_id' =>   $data['hotel_id'],
                         'invoice_date' =>  $data['invoice_date'],
                        'type' =>   'Sales',
                         'invoice_item_id' =>$i->id,
                        'invoice_id' =>$invoice->id);
                           
         
                       InvoiceHistory::create($lists);
                       
                       
                       
    
                        $new= array(
                        'check_in' =>  $i->check_in,
                         'check_out' => $i->check_out,
                        'room_id' => $i->room_id,
                        'hotel_id' =>   $data['hotel_id'],
                         'added_by' => auth()->user()->added_by,
                         'status' =>   $status,
                         'invoice_item_id' =>$i->id,
                        'invoice_id' =>$invoice->id);
                           
         
                       Booked::create($new); 
                       
                       
                       
                
            }
           
             
    
  
    
            $inv = Invoice::find($invoice->id);
            $supp=Client::find($inv->client_id);
            
            $cr= AccountCodes::where('account_name','Property Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'book_rooms';
          $journal->name = 'Booking';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
           $journal->notes= "Sales of Property " .$hx->name ." with Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
       
        
          $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'book_rooms';
          $journal->name = 'Booking';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->debit =($inv->invoice_amount + $inv->invoice_tax)  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Receivables for Sales of Property " .$hx->name ." with Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
       
          


              $sales =Invoice::find($inv->id);
            $method= Payment_methodes::where('name','Cash')->first();
             $count=InvoicePayments::where('added_by',auth()->user()->added_by)->count();
            $pro=$count+1;

              $rm = substr(str_shuffle(str_repeat($x='0123456789', ceil(4/strlen($x)) )),1,4);
               
                $receipt['trans_id'] = $a."P".$rm.$pro;
                $receipt['invoice_id'] = $inv->id;
              $receipt['amount'] = $inv->due_amount;
                $receipt['date'] = $inv->invoice_date;
               $receipt['account_id'] = $request->bank_id;
                 $receipt['payment_method'] = $method->id;
                  $receipt['user_id'] = $sales->user_agent;
                $receipt['added_by'] = auth()->user()->added_by;
                
                //update due amount from invoice table
                $b['due_amount'] =  0;
               $b['status'] = 3;
              
                $sales->update($b);
                 
                $payment = InvoicePayments::create($receipt);

                $supp=Client::find($sales->client_id);

               $cr= AccountCodes::where('id','$request->bank_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->bank_id;
        $date = explode('-',$inv->invoice_date);
        $journal->date =   $inv->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'book_rooms_payment';
          $journal->name = 'Booking Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
        $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $sales->branch_id;
           $journal->notes= "Deposit for Sales of Property " .$hx->name ." with Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();


        $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
        $journal->date =   $inv->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'book_rooms_payment';
          $journal->name = 'Booking Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
      $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $sales->branch_id;
         $journal->notes= "Clear Receivable of Property " .$hx->name ." for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();
        



        if(!empty($payment)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$payment->id,
                             'module'=>'Property Payment',
                            'activity'=>"Property Invoice with reference no  " .  $sales->reference_no. "  is Paid",
                        ]
                        );                      
       }        

}

      
        
        return redirect(route('booking.show',$invoice->id))->with(['success'=>'Created Successfully']);
        
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
        $invoices = Invoice::find($id);
        $invoice_items=InvoiceItems::where('invoice_id',$id)->get();
        $payments=InvoicePayments::where('invoice_id',$id)->get();
        $check=Booked::where('invoice_id',$id)->whereIn('status', [0,1])->first();
        
        return view('hotel.booking.invoice_details',compact('invoices','invoice_items','payments','check'));
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
        $currency= Currency::all();
         $client=Client::where('user_id',auth()->user()->added_by)->where('disabled','0')->get(); 
        $name =Items::whereIn('type', [1,2,4])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get();        
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
         
         $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
      $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         //$location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $type="";
         $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('pos.sales.invoice',compact('name','client','currency','data','id','items','type','bank_accounts','location','user','branch'));
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

       
        $invoice = Invoice::find($id);

           $old_qty=InvoiceItems::where('invoice_id',$id)->sum('due_quantity');
           $old=InvoiceItems::where('invoice_id',$id)->get();

foreach($old as $o){

                      $oinv=Items::where('id',$o->item_name)->first();
                      if($oinv->type != '4'){
                        $oq=$oinv->quantity + $o->due_quantity;
                       Items::where('id',$o->item_name)->update(['quantity' => $oq]);
                        
                        $oloc=Location::where('id', $invoice->location)->first();
                         $olq['quantity']=$oloc->quantity + $o->due_quantity;
                         Location::where('id', $invoice->location)->update($olq);
}


}

$date = today()->format('Y-m');
$old_chk=SerialList::where('invoice_id',$id)->where('location', $invoice->location)->where('status','2')->where('added_by',auth()->user()->added_by)->where('expire_date', '>=', $date)
->orWhereNull('expire_date')->where('invoice_id',$id)->where('location', $invoice->location)->where('status','2')->where('added_by',auth()->user()->added_by)->take($old_qty)->update(['status'=> '0']) ;

        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        $data['due_date']=$request->due_date;
         $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['sales_type']=$request->sales_type;
        $data['bank_id']=$request->bank_id;
        $data['user_agent']= $request->user_agent;
        $data['added_by']= auth()->user()->added_by;

        $invoice->update($data);

        $nameArr =$request->item_name ;
      $descArr =$request->description ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        $imgArr =$request->filename ;
        $ogArr =$request->original_filename ;

   $subArr = str_replace(",","",$request->subtotal);
        $totalArr =  str_replace(",","",$request->tax);
        $amountArr = str_replace(",","",$request->amount);
        $disArr =  str_replace(",","",$request->discount);
        $shipArr =  str_replace(",","",$request->shipping_cost);

     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $subArr[$i],
                     'invoice_tax' =>  $totalArr[$i],                     
                     'shipping_cost' =>   $shipArr[$i],
                      'discount' => $disArr[$i] ,
                   'due_amount' =>  $amountArr[$i]);

                       Invoice::where('id',$invoice->id)->update($t);  


            }
        }
    } 



        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                InvoiceItems::where('id',$remArr[$i])->delete();        
                   }
               }
           }


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                      'description' =>$descArr[$i],
                        'quantity' =>   $qtyArr[$i],
                             'due_quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$id);
                       
                        if(!empty($expArr[$i])){
                             InvoiceItems::where('id',$expArr[$i])->update($items);  
      
      }
      else{
        InvoiceItems::create($items);   
      }
                    
                }
            }
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }    
        
      
       InvoiceAttachment::where('invoice_id',$id)->delete();  
         if(!empty($imgArr)){
            for($i = 0; $i < count($imgArr); $i++){
                if(!empty($imgArr[$i])){

                    
                    InvoiceAttachment::create([
                        'filename' =>$imgArr[$i],
                        'original_filename' =>$ogArr[$i],
                        'order_no' => $i,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$id
                                ]);
                    
                }
            }
            
        } 

 InvoiceHistory::where('invoice_id',$id)->delete();
if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'price' =>   $priceArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'client_id' =>   $data['client_id'],
                             'location' =>   $data['location'],
                             'invoice_date' =>  $data['invoice_date'],
                            'type' =>   'Sales',
                            'invoice_id' =>$id);
                           
         
                       InvoiceHistory::create($lists);   
          
                        $inv=Items::where('id',$nameArr[$i])->first();
                        
                        if($inv->type != '4'){
                        $q=$inv->quantity - $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);
                        
                        $loc=Location::where('id', $invoice->location)->first();
                         $lq['quantity']=$loc->quantity - $qtyArr[$i];
                         Location::where('id', $invoice->location)->update($lq);
                        }
                         
                         
                          $date = today()->format('Y-m');
                         
$chk=SerialList::where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->where('expire_date', '>=', $date)
->orWhereNull('expire_date')->where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($qtyArr[$i])->update(['status'=> '2','invoice_id'=>$invoice->id]) ; 
                    }
                }
            
            }    

JournalEntry::where('income_id',$id)->where('transaction_type','pos_invoice')->where('added_by', auth()->user()->added_by)->delete();


 $total_cost=0;
  
     $x_items=InvoiceItems::where('invoice_id',$invoice->id)->get()  ;
     foreach($x_items as $x){
       $a=Items::where('id',$x->item_name)->first(); 
       if($a->type == '4'){
        $total_cost=0;   
       }
       else{
        $total_cost+=$a->cost_price * $x->quantity;
       }
         
     }

  $inv = Invoice::find($id);
            $supp=Client::find($inv->client_id);
            
            $cr= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
        if($inv->invoice_tax > 0){
         $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
             $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Sales Tax for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        }
        
          $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->debit =($inv->invoice_amount + $inv->invoice_tax)  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
            $journal->notes= "Receivables for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
            if($total_cost > 0){
         $stock= AccountCodes::where('account_name','Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $total_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Reduce Stock  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $total_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Cost of Goods Sold  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
            }
          
          if($inv->discount > 0){    
        $cr= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->discount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
       
     
          $disc= AccountCodes::where('account_name','Sales Discount')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $disc->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->discount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

        }


     if($inv->shipping_cost > 0){    

      $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Sales Shipping Cost for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
         
          $shp= AccountCodes::where('account_name','Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $shp->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Credit Shipping Cost for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
          
     }   


        if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Updated",
                        ]
                        );                      
       }



//invoice payment
 if($inv->sales_type == 'Cash Sales'){

              $sales =Invoice::find($inv->id);
            $method= Payment_methodes::where('name','Cash')->first();
             $count=InvoicePayments::count();
            $pro=$count+1;

                $receipt['trans_id'] = "TBSPH-".$pro;
                $receipt['invoice_id'] = $inv->id;
              $receipt['amount'] = $inv->due_amount;
                $receipt['date'] = $inv->invoice_date;
               $receipt['account_id'] = $request->bank_id;
                 $receipt['payment_method'] = $method->id;
                  $receipt['user_id'] = $sales->user_agent;
                $receipt['added_by'] = auth()->user()->added_by;
                
                //update due amount from invoice table
                $b['due_amount'] =  0;
               $b['status'] = 3;
              
                $sales->update($b);
                 
                $payment = InvoicePayments::create($receipt);

                $supp=Client::find($sales->client_id);

               $cr= AccountCodes::where('id','$request->bank_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->bank_id;
        $date = explode('-',$request->invoice_date);
        $journal->date =   $request->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'pos_invoice_payment';
        $journal->name = 'Invoice Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
        $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();


        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->invoice_date);
        $journal->date =   $request->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'pos_invoice_payment';
        $journal->name = 'Invoice Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
      $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
         $journal->notes= "Clear Receivable for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();
        
$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance + $payment->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']= $request->bank_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= $payment->amount;
       $new[' exchange_code']= $sales->currency_code;
        $new['added_by']=auth()->user()->added_by;
$balance=$payment->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction

                             $transaction= Transaction::create([
                                'module' => 'POS Invoice Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'POS Invoice Payment with reference ' .$payment->trans_id,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Income',
                                'amount' =>$payment->amount ,
                                'credit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'paid_by' => $sales->client_id,
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from pos invoice  payment. The Reference is ' .$sales->reference_no .' by Client '. $supp->name  ,
                                'added_by' =>auth()->user()->added_by,
                            ]);


        if(!empty($payment)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$payment->id,
                             'module'=>'Invoice Payment',
                            'activity'=>"Invoice with reference no  " .  $sales->reference_no. "  is Paid",
                        ]
                        );                      
       }        



}



        return redirect(route('invoice.show',$id))->with(['success'=>'Updated Successfully']);

    



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

   
    
    
    
    public function check_availability(Request $request)
    {
    
     $start_date = $request->start_date;
    $end_date = $request->end_date; 
    $location_id = $request->location_id;
    
    $user=auth()->user()->added_by;
    $location=Hotel::where('status',1)->where('added_by', auth()->user()->added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
    
          if($request->isMethod('post')){  
        
        $data=DB::select('SELECT * FROM hotel_items WHERE hotel_id = "'.$location_id.'" AND added_by = "'.$user.'" AND disabled = "0"  AND id NOT IN(SELECT room_id FROM hotel_booked_rooms 
        WHERE status IN (0,1) AND added_by = "'.$user.'" AND check_in BETWEEN  "'.$start_date.'" AND "'.$end_date.'"  OR  
        check_out BETWEEN  "'.$start_date.'" AND "'.$end_date.'" AND status IN (0,1) AND added_by = "'.$user.'"  ) ');
        //dd($data);
   $count=count($data);
          }else{
                    $data=[];
                     $count=[];
                }    


        return view('hotel.booking.availability',
          compact('data','start_date','end_date','location','location_id','count'));
    
    }
    
    public function save_availability(Request $request){
        
       $start_date = $request->start_date;
    $end_date = $request->end_date;
        $hotel_id=$request->location;
        $items=$request->trans_id;
        
        $currency= Currency::all();
        $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();    
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $location=Hotel::where('status',1)->where('added_by', auth()->user()->added_by)->where('disabled','0')->orderBy('created_at', 'desc')->get();
        $type="";
        $room_type=RoomType::where('added_by',auth()->user()->added_by)->get();
        $room=HotelItems::where('added_by',auth()->user()->added_by)->get();
        

            
            $dateCheckin = new DateTime($start_date);
            $dateCheckout = new DateTime($end_date);  //next Day Morning

            $nights = $dateCheckin->diff($dateCheckout)->format("%a");
            //dd($nights);
       
        return view('hotel.booking.new_booking',
          compact('items','start_date','end_date','hotel_id','client','currency','type','bank_accounts','user','branch','location','room_type','room','nights'));
        
    }


public function showType(Request $request)
    {
        
        
        $var = explode('-',$request->id);
       $start_date = $request->date;
       $end_date = $request->id;
       
       //dd($start_date);
   
         $user=auth()->user()->added_by;
        $item=DB::select('SELECT * FROM hotel_room_type WHERE ID IN (SELECT room_type  FROM hotel_items WHERE hotel_id = "'.$request->location.'" AND added_by = "'.$user.'" AND disabled = "0"  AND id NOT IN(SELECT room_id FROM hotel_booked_rooms 
        WHERE status IN (0,1) AND added_by = "'.$user.'" AND check_in BETWEEN  "'.$start_date.'" AND "'.$end_date.'"  OR  
        check_out BETWEEN  "'.$start_date.'" AND "'.$end_date.'" AND status IN (0,1) AND added_by = "'.$user.'"  ) GROUP BY room_type) ');
        
                                                                                          
               return response()->json($item);

}

public function showName(Request $request)
    {
        
        //dd($request->all());
        $var = explode('-',$request->date);
       $start_date = $request->sdate;
       $end_date = $request->edate;
       
       //dd($start_date);
   
         $user=auth()->user()->added_by;
        $item=DB::select('SELECT * FROM hotel_items WHERE hotel_id = "'.$request->location.'"  AND room_type = "'.$request->id.'" AND added_by = "'.$user.'" AND disabled = "0"  AND id NOT IN(SELECT room_id FROM hotel_booked_rooms 
        WHERE status IN (0,1) AND added_by = "'.$user.'" AND check_in BETWEEN  "'.$start_date.'" AND "'.$end_date.'"  OR  
        check_out BETWEEN  "'.$start_date.'" AND "'.$end_date.'" AND status IN (0,1) AND added_by = "'.$user.'"  ) ');

        
                //dd($item);                                                                          
               return response()->json($item);

}


public function findPrice(Request $request)
    {

       $price= HotelItems::where('id',$request->id)->get(); 
         
                                                                                          
               return response()->json($price);

} 

     


   public function discountModal(Request $request)
    {

          $id=$request->id;
                 $type = $request->type;

          switch ($type) {      
     case 'cancel':
            return view('hotel.booking.cancel_booking',compact('id'));
                    break;
                    
                    
     case 'cancel_room':
            return view('hotel.booking.cancel_room',compact('id'));
                    break;
                    
                    case 'adjust':
                        $data=InvoiceItems::find($id);
            return view('hotel.booking.adjust',compact('id','data'));
                    break;

 default:
             break;

            }

                       }

     
     
         



 public function approve($id)
    {
        //
       $invoice=Invoice::find($id);
       $data['status']='1';
       $invoice->update($data);
       return redirect(route('booking.index'))->with(['success'=>'Approved Successfully']);
    }
    
     public function cancel($id)
    {
        //
       $invoice=Invoice::find($id);
       $data['status']='4';
        $invoice->update($data);
       return redirect(route('booking.index'))->with(['success'=>'Cancelled Successfully']);
    }
    
     public function adjust(Request $request)
    {
        //
       $invoice=InvoiceItems::find($request->id);
       $data=$request->all();
        $invoice->update($data); 
       
        return redirect(route('booking.show',$invoice->invoice_id))->with(['success'=>'Adjusted Successfully']);
    }
    
     public function cancel_room(Request $request)
    {
        //
       $invoice=InvoiceItems::find($request->id);
       Booked::where('invoice_item_id',$request->id)->where('invoice_id',$invoice->invoice_id)->update(['status'=>'3']); 
       
       $data=$request->all();
        $data['cancel_by'] = auth()->user()->id;
        $invoice->update($data); 
        
        if($request->cancel_percent > 0){
            
            $cost=(1-($request->cancel_percent/100)) * $invoice->total_cost;
            
            $inv = Invoice::find($invoice->invoice_id);
            $supp=Client::find($inv->client_id);
            $hx=Hotel::find($inv->hotel_id);
            
            $cr= AccountCodes::where('account_name','Property Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',date('Y-m-d'));
          $journal->date =   date('Y-m-d') ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'cancel_rooms';
          $journal->name = 'Cancelled Room';
          $journal->debit =  $cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
           $journal->notes= "Cancelled Room of Property " .$hx->name ." with Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
       
        
          $codes=AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',date('Y-m-d'));
          $journal->date =   date('Y-m-d') ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'cancel_rooms';
          $journal->name = 'Cancelled Room';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->credit = $cost  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Cancelled Room  of Property " .$hx->name ." with Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        }
      
       return redirect(route('booking.show',$inv->id))->with(['success'=>'Room Cancelled Successfully']);
    }
    
    
     public function cancel_booking(Request $request)
    {
        //
       $invoice=Invoice::find($request->id);
       
       Booked::where('invoice_id',$request->id)->update(['status'=>'3']); 
       
       $data=$request->all();
        $data['cancel_by'] = auth()->user()->id;
        $data['status'] = '4';
        $invoice->update($data); 
        
        if($request->cancel_percent > 0){
            
            $invoice_amount=InvoiceItems::whereNull('cancel_percent')->where('invoice_id',$request->id)->sum('total_cost');
            $cost=(1-($request->cancel_percent/100)) * $invoice_amount;
            
            $inv = Invoice::find($invoice->id);
            $supp=Client::find($inv->client_id);
            $hx=Hotel::find($inv->hotel_id);
            
            $cr= AccountCodes::where('account_name','Property Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',date('Y-m-d'));
          $journal->date =   date('Y-m-d') ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'cancel_booking';
          $journal->name = 'Cancelled Booking';
          $journal->debit =  $cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
           $journal->notes= "Cancelled Booking of Property " .$hx->name ." with Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
       
        
          $codes=AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',date('Y-m-d'));
          $journal->date =   date('Y-m-d') ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'cancel_booking';
          $journal->name = 'Cancelled Booking';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->credit = $cost  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Cancelled Booking of Property " .$hx->name ." with Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        }
       
       return redirect(route('booking.index'))->with(['success'=>'Booking Cancelled Successfully']);
    }
    
     public function checkout($id)
    {
        //
       $invoice=InvoiceItems::find($id);
       Booked::where('invoice_item_id',$id)->where('invoice_id',$invoice->invoice_id)->update(['status'=>'2']); 
       
      return redirect(route('booking.show',$invoice->id))->with(['success'=>'Checkout Successfully']);
    }
    
   
   
    public function receive($id)
    {
        //
        $currency= Currency::all();
        $client=Client::where('user_id',auth()->user()->added_by)->get(); 
        $name =Items::whereIn('type', [1,2,4])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get();    
        $bank_accountsAccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get(); 
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
    //$location=Location::where('added_by',auth()->user()->added_by)->get();;
         $location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $type="receive";
       return view('pos.sales.invoice',compact('name','client','currency','data','id','items','type','bank_accounts','location'));
    }

 
    public function make_payment($id)
    {
        //
        $invoice = Invoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        return view('hotel.booking.invoice_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    
    public function save_client(Request $request){
       
      //dd($request->all());

       $data = $request->all();   
    $data['user_id'] = auth()->user()->id;
$data['owner_id'] = auth()->user()->added_by;
        $client = Client::create($data);
        
      

  if(!empty($client)){
              $activity =Activity::create(
                  [ 
                       'added_by'=>auth()->user()->added_by,
                        'user_id'=>auth()->user()->id,
                      'module_id'=>$client->id,
                       'module'=>'Client',
                      'activity'=>"Client " .  $client->name. "  Created",
                  ]
                  );
    
            return response()->json($client);
         }

       
   }
    
    public function orders_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('hotel.booking.invoice_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('BOOKING INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('orders_pdfview');
    }
    
     public function orders_receipt(Request $request){

        //if landscape heigth * width but if portrait widht *height      // dd($dataResult);
        $customPaper = array(0,0,198.425,494.80);

        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->get();
     

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('hotel.booking.invoice_receipt_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('BOOKING RECEIPT INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('orders_receipt');

    }

public function orders_payment_pdfview(Request $request)
    {
        //
        //if landscape heigth * width but if portrait widht *height      // dd($dataResult);
        $customPaper = array(0,0,198.425,494.80);
        
          $data=InvoicePayments::find($request->id);
        $invoice = Invoice::find($data->invoice_id);
      

        view()->share(['invoice'=>$invoice,'data'=> $data]);

        if($request->has('download')){
        $pdf = PDF::loadView('hotel.booking.payment_receipt_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('BOOKING RECEIPT PAYMENT  NO # ' .  $data->trans_id . ".pdf");
        }
        return view('orders_payment_pdfview');
    }




}
