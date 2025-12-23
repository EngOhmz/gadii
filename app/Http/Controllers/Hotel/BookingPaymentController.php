<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Hotel\InvoicePayments;
use App\Models\JournalEntry;
use App\Models\Payment_methodes;
use App\Models\Hotel\Invoice;
use App\Models\Restaurant\POS\Activity;
use App\Models\Hotel\Client;
use App\Models\Hotel\InvoiceHistory;
use App\Models\Hotel\Booked;
use App\Models\Hotel\Hotel;
use App\Models\Hotel\HotelItems;
use App\Models\Hotel\HouseType;
use App\Models\Hotel\RoomType;
use App\Models\Hotel\InvoiceItems;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Accounts;
use PDF;

class BookingPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
          $payments=InvoicePayments::where('added_by',auth()->user()->added_by)->get();
        return view('hotel.booking.payments',compact('payments'));
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
        $sales =Invoice::find($request->invoice_id);
        

        $hx=Hotel::find($sales->hotel_id);
        $count=InvoicePayments::where('added_by',auth()->user()->added_by)->count();
        $pro=$count+1;

        $rm = substr(str_shuffle(str_repeat($x='0123456789', ceil(4/strlen($x)) )),1,4);
              
        $words = preg_split("/\s+/", $hx->name);
        $acronym = "";
        
        foreach ($words as $w) {
          $acronym .= mb_substr($w, 0, 1);
        }
        $a=strtoupper($acronym); 
                
        if(($receipt['amount'] <= $sales->due_amount)){
            if( $receipt['amount'] >= 0){
              $receipt['trans_id'] = $a."P".$rm.$pro;

                $receipt['account_id'] = $request->account_id;
                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['user_id'] = $sales->user_agent;
                
                //update due amount from invoice table
                $data['due_amount'] =  $sales->due_amount-$receipt['amount'];
                if($data['due_amount'] != 0 ){
                $data['status'] = 2;
                }else{
                    $data['status'] = 3;
                }
                $sales->update($data);
                 
                $payment = InvoicePayments::create($receipt);

                $supp=Client::find($sales->client_id);
            
             
             $chk_jr=JournalEntry::where('transaction_type','book_rooms')->where('income_id', $sales->id)->where('added_by', auth()->user()->added_by)->first();
             if(empty($chk_jr)){
            $hs= AccountCodes::where('account_name','Property Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $hs->id;
          $date = explode('-',$sales->invoice_date);
          $journal->date =   $sales->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'book_rooms';
          $journal->name = 'Booking';
          $journal->credit = $sales->invoice_amount *  $sales->exchange_rate;
          $journal->income_id= $sales->id;
           $journal->client_id= $sales->client_id;
           $journal->currency_code =  $sales->exchange_code;
          $journal->exchange_rate= $sales->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $sales->branch_id;
           $journal->notes= "Sales of Property " .$hx->name ." with Invoice No " .$sales->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
  
          $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$sales->invoice_date);
          $journal->date =   $sales->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'book_rooms';
          $journal->name = 'Booking';
          $journal->income_id= $sales->id;
        $journal->client_id= $sales->client_id;
          $journal->debit =($sales->invoice_amount + $sales->invoice_tax)  *  $sales->exchange_rate;
          $journal->currency_code =  $sales->exchange_code;
          $journal->exchange_rate= $sales->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $sales->branch_id;
            $journal->notes= "Receivables for Sales of Property " .$hx->name ." with Invoice No " .$sales->reference_no ." to Client ". $supp->name ;
          $journal->save();
             }
           
    
    
        $cr= AccountCodes::where('id','$request->account_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->account_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
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
           $journal->notes= "Deposit for Sales of Property " .$hx->name ." with Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();


        $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
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
       
       
        $chk_his= InvoiceHistory::where('invoice_id', $sales->id)->where('added_by', auth()->user()->added_by)->first();
             if(empty($chk_his)){
                 
        $it=InvoiceItems::where('invoice_id',$sales->id)->get();
            foreach($it as $i){
               
               
               if($i->check_in == date('Y-m-d') ){
                   $status = 1;
               }
               else{
                    $status = 0;
               }
    
                        $new= array(
                        'check_in' =>  $i->check_in,
                         'check_out' => $i->check_out,
                        'room_id' => $i->room_id,
                        'hotel_id' =>  $sales->hotel_id,
                         'added_by' => auth()->user()->added_by,
                         'status' =>   $status,
                         'invoice_item_id' =>$i->id,
                        'invoice_id' =>$sales->id);
                           
         
                       Booked::create($new); 
                       
                       
                        $lists= array(
                        'quantity' =>  1,
                        'price' =>  $i->total_cost,
                        'room_type' => $i->room_type,
                        'room_id' => $i->room_id,
                         'added_by' => auth()->user()->added_by,
                         'client_id' =>   $sales->client_id,
                         'hotel_id' =>   $sales->hotel_id,
                         'invoice_date' =>  $sales->invoice_date,
                        'type' =>   'Sales',
                         'invoice_item_id' =>$i->id,
                        'invoice_id' =>$sales->id);
                           
         
                       InvoiceHistory::create($lists);
                
            }
            
             }

                return redirect(route('booking.index'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('booking.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('booking.index'))->with(['error'=>'Amount should  be less than Invoice amount ']);

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
        $data=InvoicePayments::find($id);
        $invoice = Invoice::find($data->invoice_id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('pos.invoices.invoice_edit_payments',compact('invoice','payment_method','data','id','bank_accounts'));
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
        $payment=InvoicePayments::find($id);

        $receipt = $request->all();
        $sales =Invoice::find($request->invoice_id);
       
        if(($receipt['amount'] <= $sales->due_amount)){
            if( $receipt['amount'] >= 0){
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
        $new['added_by']=auth()->user()->added_by;

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

                $supp=Client::find($sales->client_id);

                $cr= AccountCodes::where('id','$request->account_id')->first();
                $journal = JournalEntry::where('transaction_type','pos_invoice_payment')->where('payment_id', $payment->id)->whereNotNull('debit')->first();
               $journal->account_id = $request->account_id;
                  $date = explode('-',$request->date);
                $journal->date =   $request->date ;
                $journal->year = $date[0];
                $journal->month = $date[1];
          $journal->transaction_type = 'pos_invoice_payment';
        $journal->name = 'Invoice Payment';
                $journal->debit =$receipt['amount'] *  $sales->exchange_rate;
                  $journal->payment_id= $payment->id;
          $journal->client_id= $sales->client_id;
                 $journal->currency_code =   $sales->exchange_code;
                $journal->exchange_rate=  $sales->exchange_rate;
              $journal->added_by=auth()->user()->added_by;
                 $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
                $journal->update();
          
        
                    $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
                $journal = JournalEntry::where('transaction_type','pos_invoice_payment')->where('payment_id', $payment->id)->whereNotNull('credit')->first();
              $journal->account_id = $request->account_id;
              $date = explode('-',$request->date);
              $journal->date =   $request->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
               $journal->transaction_type = 'pos_invoice_payment';
        $journal->name = 'Invoice Payment';
              $journal->credit = $receipt['amount'] *  $sales->exchange_rate;
              $journal->payment_id= $payment->id;
           $journal->client_id= $sales->client_id;
               $journal->currency_code =   $sales->exchange_code;
              $journal->exchange_rate=  $sales->exchange_rate;
                 $journal->added_by=auth()->user()->added_by;
               $journal->notes= "Clear Receivable for Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
              $journal->update();

 // save into tbl_transaction
                            $transaction= Transaction::where('module','POS Invoice Payment')->where('module_id',$id)->update([
                                'module' => 'POS Invoice Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->account_id,
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

                return redirect(route('invoice.index'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('invoice.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('invoice.index'))->with(['error'=>'Amount should  be less than Invoice amount ']);

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
    
     public function payment_pdfview(Request $request)
    {
        //
        $data=InvoicePayments::find($request->id);
        $purchases = Invoice::find($data->invoice_id);

        view()->share(['purchases'=>$purchases,'data'=> $data]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.sales.payments_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('INVOICE PAYMENT REF NO # ' .  $data->trans_id . ".pdf");
        }
        return view('payment_pdfview');
    }
}
