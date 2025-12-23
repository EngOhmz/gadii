<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\GroupAccount;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\InvoicePayments;
use App\Models\InvoiceHistory;
use App\Models\MasterHistory;
use App\Models\InventoryList;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\Branch;
use App\Models\User;
use App\Models\System;
use PDF;
use DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class InvoiceController extends Controller
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
        
        $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();    
        $name =InventoryList::where('status','0')->where('added_by',auth()->user()->added_by)->get();
         $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
        $type="";
        
        if(auth()->user()->added_by == auth()->user()->id){
        $invoices=Invoice::where('invoice_status',1)->where('disabled','0')->where('added_by',auth()->user()->added_by)->latest()->get();
         $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->count();
         $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','1')->count();
         $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','2')->count();
         $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','3')->count();
        }
        
        else{
        $invoices=Invoice::where('invoice_status',1)->where('disabled','0')->where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->latest()->get();
         $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->count();
         $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','1')->count();
         $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','2')->count();
         $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','3')->count(); 
            
        }
        
         //dd($unpaid);
       return view('inventory.sales.invoice',compact('name','client','currency','invoices','type','bank_accounts','location','user','branch',
       'pos_invoice','pos_due','total','unpaid','part','paid'
       
       ));
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
          $count=Invoice::where('added_by', auth()->user()->added_by)->count();
        $pro=$count+1;
        $data['reference_no']= "SINV0".$pro;
        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        $data['due_date']=$request->due_date;
      $data['location']=$request->location;
      $data['notes']=$request->notes;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
         $data['branch_id']=$request->branch_id;
        $data['invoice_tax']='1';
        // $data['status']='0';
        $data['sales_type']=$request->sales_type;
        $data['bank_id']=$request->bank_id;
        $data['good_receive']='1';
        $data['invoice_status']=1;
    //   $data['status']='1';
      
      
            $data['status']=1;

          
          
       $data['user_id']= auth()->user()->id;
       $data['user_agent']= $request->user_agent;
        $data['added_by']= auth()->user()->added_by;

        $invoice = Invoice::create($data);
        

        $nameArr =$request->item_name ;
          $descArr =$request->description ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );        
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
                        'tax_rate' =>  $rateArr[$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id);
                       
                        InvoiceItems::create($items);  ;
    
    
                }
            }
            
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }  
        
        
 
         
         


 if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                      $ba=InventoryList::find($nameArr[$i]);
                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'price' =>   $priceArr[$i],
                             'item_id' => $savedArr[$i],
                              'brand_id' => $ba->brand_id,
                              'user_id' => auth()->user()->id,
                               'added_by' => auth()->user()->added_by,
                               'client_id' =>   $data['client_id'],
                             'location' =>   $data['location'],
                             'invoice_date' =>  $data['invoice_date'],
                            'type' =>   'Sales',
                            'invoice_id' =>$invoice->id);
                           
         
                       InvoiceHistory::create($lists);
                       
                       
                       $mlists = [
                        'out' => $qtyArr[$i],
                        'price' => $priceArr[$i],
                        'serial_id' => $savedArr[$i],
                        'item_id' => $ba->brand_id,
                        'added_by' => auth()->user()->added_by,
                        'client_id' =>   $data['client_id'],
                        'location' =>   $data['location'],
                        'date' =>$data['invoice_date'],
                        'type' =>   'Sales',
                        'invoice_id' =>$invoice->id,
                    ];

                    MasterHistory::create($mlists);
                       
                       
                        $ss=InventoryList::where('id',$nameArr[$i])->first();
                        $inv=Inventory::where('id',$ss->brand_id)->first();
                       
                        $q=$inv->quantity - $qtyArr[$i];
                        Inventory::where('id',$ss->brand_id)->update(['quantity' => $q]);
                        
                        $loc=Location::where('id', $invoice->location)->first();
                         $lq['quantity']=$loc->quantity - $qtyArr[$i];
                         Location::where('id', $invoice->location)->update($lq);
                        
                         
                        
                         
                    $chk=InventoryList::where('id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($qtyArr[$i])->update(['status'=> '2','invoice_id'=>$invoice->id]) ; 
                        
                   
                   
                    }
                }
            
            }    
   
    
  $total_cost=0;
  
     $x_items=InvoiceItems::where('invoice_id',$invoice->id)->get()  ;
     foreach($x_items as $x){
        $bb=InventoryList::find($x->item_name);
       $a=Inventory::where('id',$bb->brand_id)->first(); 
      
        $total_cost+=$a->price * $x->quantity;
       
         
     }
    
            $inv = Invoice::find($invoice->id);
            $supp=Client::find($inv->client_id);
            $staff=User::find($inv->user_agent);
            
            $cr= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $inv->branch_id;
             $journal->notes= "Inventory Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
        if($inv->invoice_tax > 0){
         $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
             $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by=auth()->user()->added_by;
          $journal->branch_id= $inv->branch_id;
             $journal->notes= "Inventory Sales Tax for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        }
        
          $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->debit =$inv->due_amount  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Receivables for Inventory Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
       if($total_cost > 0){
         $stock= AccountCodes::where('account_name','Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit = $total_cost;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Reduce Stock  for Inventory Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->debit = $total_cost ;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Cost of Goods Sold  for Inventory Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
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
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->debit = $inv->discount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Inventory Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
       
     
          $disc= AccountCodes::where('account_name','Sales Discount')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $disc->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit = $inv->discount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
          $journal->notes= "Inventory Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

        }


     if($inv->shipping_cost > 0){ 
         
         $shp= AccountCodes::where('account_name','Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $shp->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Shipping Cost for Inventory Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

      $pc=AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $pc->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Inventory Sales Shipping Cost for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
         
          
          
     }   


    

  

//invoice payment
 if($inv->sales_type == 'Cash Sales'){

              $sales =Invoice::find($inv->id);
            $method= Payment_methodes::where('name','Cash')->first();
             $count=InvoicePayments::count();
            $pro=$count+1;

                $receipt['trans_id'] = "TINVSP-".$pro;
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
       $journal->transaction_type = 'inventory_invoice_payment';
        $journal->name = 'Inventory Invoice Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
        $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $sales->branch_id;
           $journal->notes= "Deposit for Inventory Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();


        $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->invoice_date);
        $journal->date =   $request->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'inventory_invoice_payment';
        $journal->name = 'Inventory Invoice Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
      $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $sales->branch_id;
         $journal->notes= "Clear Receivable for Inventory Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
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
                                'module' => 'Inventory Invoice Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Inventory Invoice Payment with reference ' .$payment->trans_id,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Income',
                                'amount' =>$payment->amount ,
                                'credit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'paid_by' => $sales->client_id,
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from Inventory invoice  payment. The Reference is ' .$sales->reference_no .' by Client '. $supp->name  ,
                                'added_by' =>auth()->user()->added_by,
                            ]);

    

}

      
        
        return redirect(route('inventory_invoice.show',$invoice->id))->with(['success'=>'Created Successfully']);
        
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
        $invoice_items=InvoiceItems::where('invoice_id',$id)->where('due_quantity','>', '0')->get();
        $payments=InvoicePayments::where('invoice_id',$id)->get();
        
        $added_by = auth()->user()->added_by;
    
        
        $a = "SELECT inventory_return_invoices.reference_no,inventory_return_invoices.return_date,journal_entries.credit,inventory_return_invoices.bank_id FROM inventory_return_invoices INNER JOIN journal_entries ON inventory_return_invoices.id=journal_entries.income_id 
        INNER JOIN inventory_invoices ON inventory_return_invoices.invoice_id = inventory_invoices.id WHERE inventory_return_invoices.added_by = '".$added_by."' AND inventory_invoices.id = '".$id."' AND journal_entries.reference = 'Inventory Credit Note Deposit' AND journal_entries.credit IS NOT NULL ";
        
        $deposits = DB::select($a);
        
        return view('inventory.sales.invoice_details',compact('invoices','invoice_items','payments','deposits'));
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
         $data=Invoice::find($id);
         
        $currency= Currency::all();
         $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get(); 
        $name =InventoryList::where('location',$data->location)->where('added_by',auth()->user()->added_by)->whereIn('status', [0,2])->get();      
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
         
         
          if(auth()->user()->added_by == auth()->user()->id){
       
         $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->count();
         $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','1')->count();
         $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','2')->count();
         $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('status','3')->count();
        }
        
        else{
        $invoices=Invoice::where('invoice_status',1)->where('disabled','0')->where('added_by',auth()->user()->added_by)->where('user_agent',auth()->user()->id)->latest()->get();
         $pos_invoice= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw(' ((invoice_amount +invoice_tax + shipping_cost)  - discount)  * exchange_rate'));
         $pos_due= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->sum(\DB::raw('due_amount * exchange_rate')); 
        
         $total= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->count();
         $unpaid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','1')->count();
         $part= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','2')->count();
         $paid= Invoice::where('added_by',auth()->user()->added_by)->where('invoice_status','1')->where('user_agent',auth()->user()->id)->where('status','3')->count(); 
            
        }
         
       return view('inventory.sales.invoice',compact('name','client','currency','data','id','items','type','bank_accounts','location','user','branch',
       'pos_invoice','pos_due','total','unpaid','part','paid'
       ));
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
             
                      $bb=InventoryList::find($o->item_name);
                      $oinv=Inventory::where('id',$bb->brand_id)->first();
                      
                     
                     
                        $oq=$oinv->quantity + $o->due_quantity;
                       Inventory::where('id',$bb->brand_id)->update(['quantity' => $oq]);
                       
                      
                         
                        $oloc=Location::where('id', $invoice->location)->first();
                         $olq['quantity']=$oloc->quantity + $o->due_quantity;
                         Location::where('id', $invoice->location)->update($olq);



}


$old_chk=InventoryList::where('invoice_id',$id)->where('location', $invoice->location)->where('status','2')->where('added_by',auth()->user()->added_by)->take($old_qty)->update(['status'=> '0']) ;

        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        $data['due_date']=$request->due_date;
         $data['location']=$request->location;
         $data['notes']=$request->notes;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['sales_type']=$request->sales_type;
         $data['branch_id']=$request->branch_id;
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
        
      
     
 InvoiceHistory::where('invoice_id',$id)->delete();
 MasterHistory::where('invoice_id',$id)->delete();
if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        $ba=InventoryList::find($nameArr[$i]);
                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'price' =>   $priceArr[$i],
                             'item_id' => $savedArr[$i],
                             'brand_id' => $ba->brand_id,
                               'added_by' => auth()->user()->added_by,
                               'client_id' =>   $data['client_id'],
                             'location' =>   $data['location'],
                             'invoice_date' =>  $data['invoice_date'],
                            'type' =>   'Sales',
                            'invoice_id' =>$id);
                           
         
                       InvoiceHistory::create($lists);  
                       
                       
                        $mlists = [
                        'out' => $qtyArr[$i],
                        'price' => $priceArr[$i],
                        'serial_id' => $savedArr[$i],
                        'item_id' => $ba->brand_id,
                        'added_by' => auth()->user()->added_by,
                        'client_id' =>   $data['client_id'],
                        'location' =>   $data['location'],
                        'date' =>$data['invoice_date'],
                        'type' =>   'Sales',
                        'invoice_id' =>$invoice->id,
                    ];

                    MasterHistory::create($mlists);
                       
                        $ss=InventoryList::where('id',$nameArr[$i])->first();
                        $inv=Inventory::where('id',$ss->brand_id)->first();
                        
                        $q=$inv->quantity - $qtyArr[$i];
                        Inventory::where('id',$ss->brand_id)->update(['quantity' => $q]);
                        
          
                        
                        $loc=Location::where('id', $invoice->location)->first();
                         $lq['quantity']=$loc->quantity - $qtyArr[$i];
                         Location::where('id', $invoice->location)->update($lq);
                        
                         
                         
                         
                         
  $chk=InventoryList::where('id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($qtyArr[$i])->update(['status'=> '2','invoice_id'=>$invoice->id]) ; 
                    }
                }
            
            }    

JournalEntry::where('income_id',$id)->where('transaction_type','inventory_invoice')->where('added_by', auth()->user()->added_by)->delete();


 $total_cost=0;
  
     $x_items=InvoiceItems::where('invoice_id',$invoice->id)->get()  ;
     foreach($x_items as $x){
       $bb=InventoryList::find($x->item_name);
       $a=Inventory::where('id',$bb->brand_id)->first(); 
      
        $total_cost+=$a->price * $x->quantity;
       
         
     }

             $inv = Invoice::find($id);
            $supp=Client::find($inv->client_id);
            $staff=User::find($inv->user_agent);
            
           $cr= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $inv->branch_id;
             $journal->notes= "Inventory Sales for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        
        if($inv->invoice_tax > 0){
         $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
             $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by=auth()->user()->added_by;
          $journal->branch_id= $inv->branch_id;
             $journal->notes= "Inventory Sales Tax for Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
        }
        
          $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->income_id= $inv->id;
        $journal->client_id= $inv->client_id;
          $journal->debit =$inv->due_amount  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Receivables for Inventory Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
       if($total_cost > 0){
         $stock= AccountCodes::where('account_name','Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit = $total_cost;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Reduce Stock  for Inventory Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->debit = $total_cost ;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Cost of Goods Sold  for Inventory Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
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
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->debit = $inv->discount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Inventory Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
       
     
          $disc= AccountCodes::where('account_name','Sales Discount')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $disc->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit = $inv->discount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
          $journal->notes= "Inventory Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

        }


     if($inv->shipping_cost > 0){    

          $shp= AccountCodes::where('account_name','Shipping Cost')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $shp->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Shipping Cost for Inventory Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

      $pc=AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $pc->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory_invoice';
          $journal->name = 'Inventory Invoice';
          $journal->credit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Inventory Sales Shipping Cost for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
          
     }   


     
    

 $old_pay=InvoicePayments::where('invoice_id',$id)->get();

            if(!empty($old_pay[0])){
            foreach($old_pay as $o_pay){
            JournalEntry::where('payment_id', $o_pay->id)->where('transaction_type','inventory_invoice_payment')->where('added_by', auth()->user()->added_by)->delete();
            }
            }
            

    InvoicePayments::where('invoice_id', $id)->delete();

      

//invoice payment
 if($inv->sales_type == 'Cash Sales'){

              $sales =Invoice::find($inv->id);
            $method= Payment_methodes::where('name','Cash')->first();
             $count=InvoicePayments::count();
            $pro=$count+1;

                $receipt['trans_id'] = "TINVSP-".$pro;
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
       $journal->transaction_type = 'inventory_invoice_payment';
        $journal->name = 'Inventory Invoice Payment';
        $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
        $journal->payment_id= $payment->id;
        $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $sales->branch_id;
           $journal->notes= "Deposit for Inventory Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();


        $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
          $date = explode('-',$request->invoice_date);
        $journal->date =   $request->invoice_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'inventory_invoice_payment';
        $journal->name = 'Inventory Invoice Payment';
        $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
      $journal->client_id= $sales->client_id;
         $journal->currency_code =   $sales->currency_code;
        $journal->exchange_rate=  $sales->exchange_rate;
        $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $sales->branch_id;
         $journal->notes= "Clear Receivable for Inventory Invoice No  " .$sales->reference_no ." by Client ". $supp->name ;
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
                                'module' => 'Inventory Invoice Payment',
                                 'module_id' => $payment->id,
                               'account_id' => $request->bank_id,
                                'code_id' => $codes->id,
                                'name' => 'Inventory Invoice Payment with reference ' .$payment->trans_id,
                                 'transaction_prefix' => $payment->trans_id,
                                'type' => 'Income',
                                'amount' =>$payment->amount ,
                                'credit' => $payment->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($request->date)),
                                'paid_by' => $sales->client_id,
                                'payment_methods_id' =>$payment->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This deposit is from Inventory invoice  payment. The Reference is ' .$sales->reference_no .' by Client '. $supp->name  ,
                                'added_by' =>auth()->user()->added_by,
                            ]);






        return redirect(route('inventory_invoice.show',$id))->with(['success'=>'Updated Successfully']);

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
        
          $invoices = Invoice::find($id);
          
          $old_qty=InvoiceItems::where('invoice_id',$id)->sum('due_quantity');
          $old=InvoiceItems::where('invoice_id',$id)->get();
          $old_pay=InvoicePayments::where('invoice_id',$id)->get();
         

         foreach($old as $o){

                       $aa=InventoryList::where('id',$o->item_name)->first();
                      $oinv=Inventory::where('id',$aa->brand_id)->first();
                     
                      $oq=$oinv->quantity + $o->due_quantity;
                       Inventory::where('id',$aa->brand_id)->update(['quantity' => $oq]);
                        
                        $oloc=Location::where('id', $invoices->location)->first();
                        $olq['quantity']=$oloc->quantity + $o->due_quantity;
                        Location::where('id', $invoices->location)->update($olq);


}


$chk=InventoryList::where('invoice_id',$id)->where('location', $invoices->location)->where('status','2')->where('added_by',auth()->user()->added_by)->get();
if(!empty($chk)){
$old_chk=InventoryList::where('invoice_id',$id)->where('location', $invoices->location)->where('status','2')->where('added_by',auth()->user()->added_by)->take($old_qty)->update(['status'=> '0']) ;
}

            JournalEntry::where('income_id',$id)->where('transaction_type','inventory_invoice')->where('added_by', auth()->user()->added_by)->delete();
           
            if(!empty($old_pay[0])){
            foreach($old_pay as $o_pay){
            JournalEntry::where('payment_id', $o_pay->id)->where('transaction_type','inventory_invoice_payment')->where('added_by', auth()->user()->added_by)->delete();
            }
            }
            
            
            
           
            InvoiceHistory::where('invoice_id',$id)->delete();
             MasterHistory::where('invoice_id',$id)->delete();
            InvoiceItems::where('invoice_id', $id)->delete();
            InvoicePayments::where('invoice_id', $id)->delete();
  
            $invoices->delete();
                        
        return redirect(route('inventory_invoice.index'))->with(['success'=>'Deleted Successfully']);
    }
    
    
    
    
   public function discountModal(Request $request)
    {

          $id=$request->id;
                 $type = $request->type;

          switch ($type) {      
     case 'client':
            return view('pos.sales.client_modal');
                    break;
        
         case 'edit':
             //dd($request->all());
                 
                  $name=$request->item_name[0];
                  $desc=$request->description[0];
                  $qty=$request->quantity[0];
                  $price=str_replace(",","",$request->price[0]) ;
                  $cost=$request->total_cost[0];
                  $tax=$request->total_tax[0];
                  $unit=$request->unit[0];
                  $rate=$request->tax_rate[0];
                  $loc=$request->loc;
                  $order=$request->no[0];
                  if(!empty($request->saved_items_id[0])){
                  $saved=$request->saved_items_id[0];
                   $a=InvoiceItems::where('id', $saved)->first();
                   $item = InventoryList::where('location',$request->loc)->where('added_by',auth()->user()->added_by)->where('status',0)
                   ->orWhere('status', 2)->where('location',$request->loc)->where('added_by',auth()->user()->added_by)->where('invoice_id', $a->invoice_id)->get();
                  }
                  else{
                    $item = InventoryList::where('location',$request->loc)->where('added_by',auth()->user()->added_by)->where('status',0)->get();  
                   $saved='';   
                  }
                  
            return view('inventory.sales.edit_modal', compact('item','name','desc','qty','price','cost','tax','unit','rate','order','type','saved','loc'));
                    break;            

                                   
   
 default:
             break;

            }

                       }
    
    
     public function add_item(Request $request)
    {
        //dd($request->all());

       $data=$request->all();
       
       
        
          $list = '';
          $list1 = ''; 
          
           $it=InventoryList::where('id',$request->checked_item_name[0])->first();
           $og=Inventory::where('id',$it->brand_id)->first();
		   $a = $og->name.' - '.$it->serial_no;
          
          $name=$request->checked_item_name[0];
          $desc=$request->checked_description[0];
          $qty=$request->checked_quantity[0];
          $price=str_replace(",","",$request->checked_price[0]);
          $cost=$request->checked_total_cost[0];
          $tax=$request->checked_total_tax[0];
          $order=$request->checked_no[0];
          $unit=$request->checked_unit[0];
          $rate=$request->checked_tax_rate[0];
          $location=$request->location;
          
          if($rate == '0'){
              $r='0%';
          }
         else if($rate == '0.18'){
              $r='18%';
          }
          
          if(!empty($request->saved_items_id[0])){
            $saved=$request->saved_items_id[0];
            }
            else{
            $saved='';   
                  }
          
          if(!empty($request->type) && $request->type == 'edit'){
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$r.'</td>';
            $list .= '<td>'.$tax.'</td>';
             if(!empty($saved)){
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger rem" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '" value="'.$saved.'"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
                }
            else{
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            }
            
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst'.$order.'"  value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
            $list1 .= '<input type="hidden" name="loc" class="form-control item_loc" id="loc lst'.$order.'"  value="'.$location.'"  />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            $list1 .= '<input type="hidden"  class="form-control item_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
            
            if(!empty($saved)){
            $list1 .= '<input type="hidden" name="saved_items_id[]" class="form-control item_saved'.$order.'" value="'.$saved.'"  required/>';
                }
          }
            else{
            $list .= '<tr class="trlst'.$order.'">';
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$r.'</td>';
            $list .= '<td>'.$tax.'</td>';
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            $list .= '</tr>';
             
            $list1 .= '<div class="line_items" id="lst'.$order.'">';        
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst'.$order.'"  value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
            $list1 .= '<input type="hidden" name="loc" class="form-control item_loc" id="loc lst'.$order.'"  value="'.$location.'"  />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            $list1 .= '<input type="hidden"  class="form-control item_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
            $list1 .= '</div>';
            }


             return response()->json([
            'list'          => $list,
            'list1' => $list1
    ]);
        
    }          
    
    

    public function findPrice(Request $request)
    {
               $a= InventoryList::where('id',$request->id)->first();
               $price=Inventory::find($a->brand_id);
                return response()->json($price);                      

    }
    

     



     
   
public function findItem(Request $request){
       
      //dd($request->all());

      $list = InventoryList::where('location',$request->id)->where('added_by',auth()->user()->added_by)->where('status',0)->get(); 

	foreach ( $list as $l ) {
		    $og=Inventory::where('id',$l->brand_id)->first();
			$obj['name'] = $og->name.' - '.$l->serial_no;
			$obj['id'] = $l->id;          
			$data[] = $obj;
		}
		
	
	//dd($data);
	return response()->json($data);
         

       
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

    public function approve($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 1;
        $invoice->update($data);

     
        return redirect(route('inventory_invoice.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);
      
        return redirect(route('inventory_invoice.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    

 
    public function make_payment($id)
    {
        //
        $invoice = Invoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        return view('inventory.sales.invoice_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function invoice_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('inventory.sales.invoice_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('INVENTORY SALES NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('inv_pdfview');
    }
    
     public function invoice_receipt(Request $request){

        //if landscape heigth * width but if portrait widht *height      // dd($dataResult);
        $customPaper = array(0,0,198.425,494.80);

        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();
     

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('inventory.sales.invoice_receipt_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('INVENTORY SALES RECEIPT NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('invoice_receipt');

    }







}
