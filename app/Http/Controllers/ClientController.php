<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\POS\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\Importable;
use App\Imports\ImportClient ;
use Response;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\MasterHistory;
use App\Models\POS\ReturnInvoice;
use App\Models\POS\InvoicePayments;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Deposit;
use Session;
use DB;

class ClientController  extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
   {
       //
       $client = Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();     
       return view('client.client',compact('client'));
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

      $data=$request->post();
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
       }
      return redirect(route('client.index'))->with(['success'=>'Client Created Successfully']);
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
         $data = Client::find($id);

        $type = Session::get('type');
            if(empty($type))
             $type='details';
             
    $purchase = Invoice::where('added_by',auth()->user()->added_by)->where('client_id',$id)->get();;
    $debit = ReturnInvoice::where('added_by',auth()->user()->added_by)->where('client_id',$id)->get();;
    $payment = InvoicePayments::leftJoin('pos_invoices', 'pos_invoices.id', 'pos_invoice_payments.invoice_id')
            ->where('pos_invoices.client_id', $id)
            ->where('pos_invoice_payments.added_by', auth()->user()->added_by)
            ->select('pos_invoice_payments.*','pos_invoices.exchange_code')
            ->get();
    
    

         $added_by = auth()->user()->added_by;
        
         $a = "SELECT  pos_invoices.exchange_code,pos_invoices.exchange_rate,pos_return_invoices.reference_no,pos_return_invoices.return_date,journal_entries.credit,pos_return_invoices.bank_id FROM pos_return_invoices INNER JOIN journal_entries ON pos_return_invoices.id=journal_entries.income_id 
        INNER JOIN pos_invoices ON pos_return_invoices.invoice_id = pos_invoices.id WHERE pos_return_invoices.added_by = '".$added_by."' AND pos_invoices.client_id = '".$id."' AND journal_entries.reference = 'Credit Note Deposit' AND journal_entries.credit IS NOT NULL ";

        $deposits = DB::select($a);
        
        $cos=AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by',auth()->user()->added_by)->first();
        if(!empty($cos)){
         $b = "SELECT  pos_invoices.exchange_code,pos_invoices.exchange_rate,pos_invoices.invoice_date,pos_invoices.reference_no,pos_invoices.status,journal_entries.debit,pos_invoices.id FROM pos_invoices INNER JOIN journal_entries ON pos_invoices.id=journal_entries.income_id 
        WHERE pos_invoices.added_by = '".$added_by."' AND pos_invoices.client_id = '".$id."' AND journal_entries.transaction_type = 'pos_invoice' AND journal_entries.account_id = '".$cos->id."' AND journal_entries.debit IS NOT NULL ";

        $cost = DB::select($b);
        
        }
        
        else{
             $cost=[];
        }
        
        
    $expense =Deposit::where('added_by',auth()->user()->added_by)->where('client_id',$id)->get();;
    $journal = JournalEntry::where('added_by',auth()->user()->added_by)->where('client_id',$id)->whereNotIn('transaction_type', ['pos_invoice','pos_credit_note','pos_invoice_payment','deposit'])->get();;
                
    $purcount=Invoice::where('added_by',auth()->user()->added_by)->where('client_id',$id)->count();                
    $dncount=ReturnInvoice::where('added_by',auth()->user()->added_by)->where('client_id',$id)->count();   
     
    $paycount= InvoicePayments::leftJoin('pos_invoices', 'pos_invoices.id', 'pos_invoice_payments.invoice_id')
            ->where('pos_invoices.client_id', $id)
            ->where('pos_invoice_payments.added_by', auth()->user()->added_by)
            ->select('pos_invoice_payments.*','pos_invoices.exchange_code')->count();   
            
    $expcount =Deposit::where('added_by',auth()->user()->added_by)->where('client_id',$id)->count();  
    $jcount = JournalEntry::where('added_by',auth()->user()->added_by)->where('client_id',$id)->whereNotIn('transaction_type', ['pos_invoice','pos_credit_note','pos_invoice_payment','deposit'])->count();;
   $depcount=count($deposits);
    $costcount=count($cost);
   
      return view('client.client_details',compact
                  ('data','id','type','purchase','debit','payment','deposits','expense','journal','cost',
                    'purcount', 'dncount', 'paycount','depcount', 'expcount','jcount','costcount'));
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       $data =  Client::find($id);
       return view('client.client',compact('data','id'));

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
       $client = Client::find($id);
       $data=$request->post();
       $data['user_id'] = auth()->user()->id;
      $data['owner_id'] = auth()->user()->added_by;
       $client->update($data);


          if(!empty($client)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                               'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Client',
                            'activity'=>"Client " .  $client->name. "  Updated",
                        ]
                        );                      
       }
       return redirect(route('client.index'))->with(['success'=>'Client Updated Successfully']);
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

       $client = Client::find($id);
 if(!empty($client)){
                    $activity =Activity::create(
                        [ 
                             'added_by'=>auth()->user()->added_by,
                             'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Client',
                            'activity'=>"Client " .  $client->name. "  Deleted",
                        ]
                        );                      
       }
       $client->update(['disabled'=> '1']);;

       return redirect(route('client.index'))->with(['success'=>'Client Deleted Successfully']);
   }
   
     public function import(Request $request){
      
        
        $data = Excel::import(new ImportClient, $request->file('file')->store('files'));
        
        return redirect()->back()->with('success', 'File Imported Successfully');
    }
    
     public function sample(Request $request){

       $filepath = public_path('client_sample.xlsx');
       return Response::download($filepath);
    }
   
}
