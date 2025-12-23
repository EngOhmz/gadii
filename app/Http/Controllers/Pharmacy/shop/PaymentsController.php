<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use App\Models\Pacel;
use App\Models\Receipt;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\Payment_methodes;
use App\Models\Payments;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\purchase;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $receipt = Receipt::all();

        return view('admin.receipt.receipt',compact('receipt'));
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
        $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);  
      
        $receipt = $request->all();
        $purchase = purchase::find($request->id);

        if(($receipt['amount'] <= $purchase->purchase_amount)){
            if( $receipt['amount'] >= 0){
                $receipt['due_amount'] = $purchase->purchase_amount - $receipt['amount'];
                $receipt['purchase_id'] = $request->id;
                $receipt['owner_id'] = $purchase->owner_id;
                $receipt['trans_id'] = "TRANS-".$request->id.'-'.date('d/m/y');
                
                //update due amount from invoice table
                $data['due_amount'] = $receipt['due_amount'];
                if($data['due_amount'] != 0 ){
                $data['status'] = 2;
                }else{
                    $data['status'] = 3;
                }
                $purchase->update($data);

                 $cr= AccountCodes::where('account_group','Cash and Cash Equivalent')->first();
          $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-', date('d-m-Y'));
        $journal->date = date('d-m-Y');
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'invoice_payment';
        $journal->name = 'Invoice Payment';
        $journal->debit =   $receipt['amount'];
        $journal->income_id=    $receipt['purchase_id'];
           $journal->notes= "Purchase Payment with trans No " .  $receipt['trans_id']   ;
        $journal->save();

        $codes= AccountCodes::where('account_group','Receivables')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
        $date = explode('-', date('d-m-Y'));
        $journal->date = date('d-m-Y');
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'invoice_payment';
        $journal->name = 'Invoice Payment';
             $journal->income_id=    $receipt['purchase_id'];
           $journal->notes= "Purchase Payment with trans No " .  $receipt['trans_id']   ;
        $journal->credit =  $receipt['amount'];
        $journal->save();

        
                $payment = Payments::create($receipt);

                return redirect(route('purchase.index'))->with(['success'=>'Payment Added successfull']);
            }else{
                return redirect(route('purchase.index'))->with(['error'=>'Amount should not be equal or less to zero']);
            }
       

        }else{
            return redirect(route('purchase.index'))->with(['error'=>'Amount should  be less than Invoiced amount ']);

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
        $data = purchase::find($id);
        $invoice = purchase::all()->where('supplier_id',$data->supplier_id);
        $payment_methode = Payment_methodes::all();

        return view("payment.payment",compact('data','invoice','payment_methode'));

      
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
        $pacel = Pacel::find($id);
        
        $data['pacel_number'] = $pacel->pacel_number;
        $data['user_receipt'] = $request->post('user_receipt');
        $data['amount'] = $request->post('amount');

        $userReceipt = UserReceipts::create($data);
        if(!empty($userReceipt)){
        $pacel->update(['status'=>1]);
        }

       

        return redirect(route('pacel.index'))->with(['success'=>'Request created successfully']);
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
