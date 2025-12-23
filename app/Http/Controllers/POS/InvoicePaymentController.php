<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\POS\InvoicePayments;
use App\Models\JournalEntry;
use App\Models\Payment_methodes;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\POS\Activity;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Accounts;
use PDF;
use DB;

class InvoicePaymentController extends Controller
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
        return view('pos.sales.payments',compact('payments'));
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

    
        $count=InvoicePayments::count();
        $pro=$count+1;

        if(($receipt['amount'] <= $sales->due_amount)){
            if( $receipt['amount'] >= 0){
                $receipt['trans_id'] =  "TSP-".$pro;
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

               $cr= AccountCodes::where('id','$request->account_id')->first();
          $journal = new JournalEntry();
        $journal->account_id = $request->account_id;
        $date = explode('-',$request->date);
        $journal->date =   $request->date ;
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
          $date = explode('-',$request->date);
        $journal->date =   $request->date ;
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

                return redirect(route('invoice.index'))->with(['success'=>'Payment Added successfully']);
            }else{
                return redirect(route('invoice.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('invoice.index'))->with(['error'=>'Amount should  be less than Invoice amount ']);

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
        $customPaper = array(0,0,198.425,494.80);
        $data=InvoicePayments::find($request->id);
        $purchases = Invoice::find($data->invoice_id);

        view()->share(['purchases'=>$purchases,'data'=> $data]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.sales.payments_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('INVOICE PAYMENT REF NO # ' .  $data->trans_id . ".pdf");
        }
        return view('payment_pdfview');
    }
    
    
       public function history_pdfview(Request $request)
    {
        
        
        $payments=InvoicePayments::where('invoice_id',$request->id)->get();
        
        $added_by = auth()->user()->added_by;
    
        
        $a = "SELECT pos_return_invoices.reference_no,pos_return_invoices.return_date,journal_entries.credit,pos_return_invoices.bank_id FROM pos_return_invoices INNER JOIN journal_entries ON pos_return_invoices.id=journal_entries.income_id 
        INNER JOIN pos_invoices ON pos_return_invoices.invoice_id = pos_invoices.id WHERE pos_return_invoices.added_by = '".$added_by."' AND pos_invoices.id = '".$request->id."' AND journal_entries.reference = 'Credit Note Deposit' AND journal_entries.credit IS NOT NULL ";
        
        $deposits = DB::select($a);
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items,'payments'=> $payments,'deposits'=> $deposits]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.sales.history_payments_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('PAYMENT HISTORY NO # ' .  $invoices->reference_no . ".pdf");
        }
        return view('history_pdfview');
    }


    public function history_delivery_pdfview(Request $request)
    {
                
        $payments=InvoicePayments::where('invoice_id',$request->id)->get();
        
        $added_by = auth()->user()->added_by;
    
        
        $a = "SELECT pos_return_invoices.reference_no,pos_return_invoices.return_date,journal_entries.credit,pos_return_invoices.bank_id FROM pos_return_invoices INNER JOIN journal_entries ON pos_return_invoices.id=journal_entries.income_id 
        INNER JOIN pos_invoices ON pos_return_invoices.invoice_id = pos_invoices.id WHERE pos_return_invoices.added_by = '".$added_by."' AND pos_invoices.id = '".$request->id."' AND journal_entries.reference = 'Credit Note Deposit' AND journal_entries.credit IS NOT NULL ";
        
        $deposits = DB::select($a);
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items,'payments'=> $payments,'deposits'=> $deposits]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.sales.history_delivery_payments_pdf')->setPaper('a4', 'portrait');
        
        // Get dompdf instance and add page numbers
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        
        // Add page numbers - this will be executed for each page
        $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $font = $fontMetrics->get_font("helvetica", "normal");
            $size = 8;

            // Page number (right aligned at bottom)
            $pageText = "Page $pageNumber of $pageCount";
            $pageWidth = $fontMetrics->get_text_width($pageText, $font, $size);
            $xPage = $canvas->get_width() - $pageWidth - 20; // right margin
            $yPage = $canvas->get_height() - 20; // push up from bottom
            $canvas->text($xPage, $yPage, $pageText, $font, $size, [0, 0, 0]);
        });
        
         return $pdf->download('DELIVERY NOTE NO # ' .  $invoices->reference_no . ".pdf");
        }
        return view('history_delivery_pdfview');
    }


}

