<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\GroupAccount;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\POS\Activity;
use App\Models\POS\InvoicePayments;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\MasterHistory;
use App\Models\POS\SerialList;
use App\Models\POS\GoodIssue;
use App\Models\POS\GoodIssueItem;
use App\Models\POS\StockMovement;
use App\Models\POS\StockMovementItem;
use App\Models\POS\GoodDisposal;
use App\Models\POS\GoodDisposalItem;
use App\Models\POS\Items;
use App\Models\POS\Category ;
use App\Models\POS\Color ;
use App\Models\POS\Size ;
use App\Models\JournalEntry;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Client;
use App\Models\InventoryList;
use App\Models\ServiceType;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\POS\InvoiceAttachment;
use App\Models\Branch;
use App\Models\User;
use App\Models\System;
use PDF;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

use Illuminate\Http\Request;

class InvoiceController2 extends Controller
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
        $name =Items::whereIn('type', [1,2,4])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get(); 
         $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->orderBy('id','asc')->get();
       $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                            ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                           ->orderBy('locations.created_at','asc')
                              ->get()  ;
                              
         $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
          $type="receive";
        
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
       return view('pos.sales2.invoice',compact('name','client','currency','invoices','type','bank_accounts','location','user','branch',
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
        $data['reference_no']= "S0".$pro;
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
        $priceArr = str_replace(",","",$request->price);
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
        $adjArr =  str_replace(",","",$request->adjustment);

     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $subArr[$i],
                     'invoice_tax' =>  $totalArr[$i],                     
                     'shipping_cost' =>   $shipArr[$i],
                      'discount' => $disArr[$i] ,
                      'adjustment' => $adjArr[$i] ,
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
        
        
 
         
         
             if(!empty($imgArr)){
            for($i = 0; $i < count($imgArr); $i++){
                if(!empty($imgArr[$i])){

                    
                    InvoiceAttachment::create([
                        'filename' =>$imgArr[$i],
                        'original_filename' =>$ogArr[$i],
                        'order_no' => $i,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id
                                ]);
                    
                }
            }
            
        } 


 if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'price' =>   $priceArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                               'client_id' =>   $data['client_id'],
                             'location' =>   $data['location'],
                             'invoice_date' =>  $data['invoice_date'],
                            'type' =>   'Sales',
                            'invoice_id' =>$invoice->id);
                           
         
                       InvoiceHistory::create($lists);
                       
                       
                       $mlists = [
                        'out' => $qtyArr[$i],
                        'price' => $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'client_id' =>   $data['client_id'],
                        'location' =>   $data['location'],
                        'date' =>$data['invoice_date'],
                        'type' =>   'Sales',
                        'invoice_id' =>$invoice->id,
                    ];

                    MasterHistory::create($mlists);
                       
                       
          
                        $inv=Items::where('id',$nameArr[$i])->first();
                        if($inv->type != '4'){
                        $q=$inv->quantity - $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);
                        
                        $loc=Location::where('id', $invoice->location)->first();
                         $lq['quantity']=$loc->quantity - $qtyArr[$i];
                         Location::where('id', $invoice->location)->update($lq);
                        
                         /*
                         $date = today()->format('Y-m');
                         
                    $chk=SerialList::where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->where('expire_date', '>=', $date)
                    ->orWhereNull('expire_date')->where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($qtyArr[$i])->update(['status'=> '2','invoice_id'=>$invoice->id]) ; 
                        */
                        }
                   
                   
                    }
                }
            
            }    
   
    
  $total_cost=0;
  
     $x_items=InvoiceItems::where('invoice_id',$invoice->id)->get()  ;
     foreach($x_items as $x){
       $a=Items::where('id',$x->item_name)->first(); 
       if($a->type == '4'){
        $total_cost=0;   
       }
       else{
           
         $tt=PurchaseHistory::where('item_id', $x->item_name)->where('location',$invoice->location)->where('type','Purchases')->latest('id')->first(); 
         
         if(!empty($tt)){
          $total_cost+=$tt->price * $x->quantity;   
         }
           
         else{  
        $total_cost+=$a->cost_price * $x->quantity;
         }
         
         
       }
         
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
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
         $journal->branch_id= $inv->branch_id;
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
          $journal->branch_id= $inv->branch_id;
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
          $journal->debit =$inv->due_amount  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
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
          $journal->credit = $total_cost;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
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
          $journal->debit = $total_cost ;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
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
           $journal->branch_id= $inv->branch_id;
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
           $journal->branch_id= $inv->branch_id;
          $journal->notes= "Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
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
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
         $journal->branch_id= $inv->branch_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Shipping Cost for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

      $pc=AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $pc->id;
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
         $journal->branch_id= $inv->branch_id;
             $journal->notes= "Sales Shipping Cost for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
     }   

 if(!empty($inv->adjustment) && $inv->adjustment != '0'){
        $cr= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->adjustment *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Sales Adjustment for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
       
     
          $adj= AccountCodes::where('account_name','Adjustment')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $adj->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->adjustment *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
          $journal->notes= "Sales Adjustment for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

        }

    

    if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$invoice->id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Created",
                        ]
                        );                      
       }


//invoice payment
 if($inv->sales_type == 'Cash Sales'){

              $sales =Invoice::find($inv->id);
            $method= Payment_methodes::where('name','Cash')->first();
             $count=InvoicePayments::count();
            $pro=$count+1;

                $receipt['trans_id'] = "TSP-".$pro;
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
           $journal->branch_id= $sales->branch_id;
           $journal->notes= "Deposit for Sales Invoice No " .$sales->reference_no ." by Client ". $supp->name ;
        $journal->save();


        $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
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
         $journal->branch_id= $sales->branch_id;
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

      
        
        return redirect(route('invoice.show',$invoice->id))->with(['success'=>'Created Successfully']);
        
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
    
        
        $a = "SELECT pos_return_invoices.reference_no,pos_return_invoices.return_date,journal_entries.credit,pos_return_invoices.bank_id FROM pos_return_invoices INNER JOIN journal_entries ON pos_return_invoices.id=journal_entries.income_id 
        INNER JOIN pos_invoices ON pos_return_invoices.invoice_id = pos_invoices.id WHERE pos_return_invoices.added_by = '".$added_by."' AND pos_invoices.id = '".$id."' AND journal_entries.reference = 'Credit Note Deposit' AND journal_entries.credit IS NOT NULL ";
        
        $deposits = DB::select($a);
        
        return view('pos.sales2.invoice_details',compact('invoices','invoice_items','payments','deposits'));
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
        
         $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get(); 
        $name =Items::whereIn('type', [1,2,4])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get();        
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
         
         $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->orderBy('id','asc')->get();
      $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         //$location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
         $type="receive";
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
         
       return view('pos.sales2.invoice',compact('name','client','currency','data','id','items','type','bank_accounts','location','user','branch',
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

                      $oinv=Items::where('id',$o->item_name)->first();
                      if($oinv->type != '4'){
                        $oq=$oinv->quantity + $o->due_quantity;
                       Items::where('id',$o->item_name)->update(['quantity' => $oq]);
                        
                        $oloc=Location::where('id', $invoice->location)->first();
                         $olq['quantity']=$oloc->quantity + $o->due_quantity;
                         Location::where('id', $invoice->location)->update($olq);
}


}

/*
$date = today()->format('Y-m');
$old_chk=SerialList::where('invoice_id',$id)->where('location', $invoice->location)->where('status','2')->where('added_by',auth()->user()->added_by)->where('expire_date', '>=', $date)
->orWhereNull('expire_date')->where('invoice_id',$id)->where('location', $invoice->location)->where('status','2')->where('added_by',auth()->user()->added_by)->take($old_qty)->update(['status'=> '0']) ;
*/

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
        $data['bank_id']=$request->bank_id;
        $data['user_agent']= $request->user_agent;
        $data['added_by']= auth()->user()->added_by;

        $invoice->update($data);

        $nameArr =$request->item_name ;
      $descArr =$request->description ;
        $qtyArr = $request->quantity  ;
        $priceArr =str_replace(",","",$request->price);
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
      $adjArr =  str_replace(",","",$request->adjustment);
      
     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $subArr[$i],
                     'invoice_tax' =>  $totalArr[$i],                     
                     'shipping_cost' =>   $shipArr[$i],
                      'discount' => $disArr[$i] ,
                      'adjustment' => $adjArr[$i] ,
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
MasterHistory::where('invoice_id',$id)->delete();
if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'price' =>   $priceArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                                'user_id' => auth()->user()->id,
                               'client_id' =>   $data['client_id'],
                             'location' =>   $data['location'],
                             'invoice_date' =>  $data['invoice_date'],
                            'type' =>   'Sales',
                            'invoice_id' =>$id);
                           
         
                       InvoiceHistory::create($lists);   
                       
                       
                        $mlists = [
                        'out' => $qtyArr[$i],
                        'price' => $priceArr[$i],
                        'item_id' => $savedArr[$i],
                        'added_by' => auth()->user()->added_by,
                        'client_id' =>   $data['client_id'],
                        'location' =>   $data['location'],
                        'date' =>$data['invoice_date'],
                        'type' =>   'Sales',
                        'invoice_id' =>$invoice->id,
                    ];

                    MasterHistory::create($mlists);
          
                        $inv=Items::where('id',$nameArr[$i])->first();
                        
                        if($inv->type != '4'){
                        $q=$inv->quantity - $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);
                        
                        $loc=Location::where('id', $invoice->location)->first();
                         $lq['quantity']=$loc->quantity - $qtyArr[$i];
                         Location::where('id', $invoice->location)->update($lq);
                        }
                         
                         /*
                          $date = today()->format('Y-m');
                         
$chk=SerialList::where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->where('expire_date', '>=', $date)
->orWhereNull('expire_date')->where('brand_id',$nameArr[$i])->where('location',$invoice->location)->where('added_by',auth()->user()->added_by)->where('status','0')->take($qtyArr[$i])->update(['status'=> '2','invoice_id'=>$invoice->id]) ; 
   */
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
            $staff=User::find($inv->user_agent);
            
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
         $journal->branch_id= $inv->branch_id;
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
          $journal->branch_id= $inv->branch_id;
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
          $journal->debit =$inv->due_amount  *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
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
          $journal->credit = $total_cost;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
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
          $journal->debit = $total_cost ;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
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
           $journal->branch_id= $inv->branch_id;
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
           $journal->branch_id= $inv->branch_id;
          $journal->notes= "Sales Discount for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
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
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->shipping_cost *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
         $journal->branch_id= $inv->branch_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Shipping Cost for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

      $pc=AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $pc->id;
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
         $journal->branch_id= $inv->branch_id;
             $journal->notes= "Sales Shipping Cost for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
     }  
      if(!empty($inv->adjustment) && $inv->adjustment != '0'){
        $cr= AccountCodes::where('account_name','Sales')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->adjustment *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
             $journal->notes= "Sales Adjustment for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
       
     
          $adj= AccountCodes::where('account_name','Adjustment')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $adj->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->credit = $inv->adjustment *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
          $journal->notes= "Sales Adjustment for for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
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


 $old_pay=InvoicePayments::where('invoice_id',$id)->get();

            if(!empty($old_pay[0])){
            foreach($old_pay as $o_pay){
            JournalEntry::where('payment_id', $o_pay->id)->where('transaction_type','pos_invoice_payment')->where('added_by', auth()->user()->added_by)->delete();
            }
            }
            

    InvoicePayments::where('invoice_id', $id)->delete();

//invoice payment
 if($inv->sales_type == 'Cash Sales'){

              $sales =Invoice::find($inv->id);
            $method= Payment_methodes::where('name','Cash')->first();
             $count=InvoicePayments::count();
            $pro=$count+1;

                $receipt['trans_id'] = "TSP-".$pro;
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
        
          $invoices = Invoice::find($id);
          
          $old_qty=InvoiceItems::where('invoice_id',$id)->sum('due_quantity');
          $old=InvoiceItems::where('invoice_id',$id)->get();
          $old_pay=InvoicePayments::where('invoice_id',$id)->get();
          $old_file=InvoiceAttachment::where('invoice_id',$id)->get();

         foreach($old as $o){

                      $oinv=Items::where('id',$o->item_name)->first();
                      if($oinv->type != '4'){
                      $oq=$oinv->quantity + $o->due_quantity;
                       Items::where('id',$o->item_name)->update(['quantity' => $oq]);
                        
                        $oloc=Location::where('id', $invoices->location)->first();
                        $olq['quantity']=$oloc->quantity + $o->due_quantity;
                        Location::where('id', $invoices->location)->update($olq);
}

}

/*
$chk=SerialList::where('invoice_id',$id)->where('location', $invoices->location)->where('status','2')->where('added_by',auth()->user()->added_by)->get();
if(!empty($chk)){
$old_chk=SerialList::where('invoice_id',$id)->where('location', $invoices->location)->where('status','2')->where('added_by',auth()->user()->added_by)->take($old_qty)->update(['status'=> '0']) ;
}
*/
            JournalEntry::where('income_id',$id)->where('transaction_type','pos_invoice')->where('added_by', auth()->user()->added_by)->delete();
            JournalEntry::where('income_id',$id)->where('transaction_type','pos_commission')->where('added_by', auth()->user()->added_by)->delete();
            if(!empty($old_pay[0])){
            foreach($old_pay as $o_pay){
            JournalEntry::where('payment_id', $o_pay->id)->where('transaction_type','pos_invoice_payment')->where('added_by', auth()->user()->added_by)->delete();
            }
            }
            
             if(!empty($old_file[0])){
            foreach($old_file as $o_file){
            $filename =  $o_file->filename;
        	$path = public_path('pos/').$filename;
        	if (file_exists($path)) {
        		unlink($path);
        	}
            }
            }
            
            InvoiceAttachment::where('invoice_id',$id)->delete(); 
            InvoiceHistory::where('invoice_id',$id)->delete();
            MasterHistory::where('invoice_id',$id)->delete();
            InvoiceItems::where('invoice_id', $id)->delete();
            InvoicePayments::where('invoice_id', $id)->delete();
            DB::table('invoice_commission')->where('invoice_id', $id)->delete();   
                
           
       
      

                     if(!empty($invoices)){
                    $activity =Activity::create(
                        [ 
                        'added_by'=>auth()->user()->added_by,
                        'user_id'=>auth()->user()->id,
                        'module_id'=>$id,
                         'module'=>'Invoice',
                        'activity'=>"Invoice with reference no  " .  $invoices->reference_no. "  is Deleted",
                        ]
                        );                      
                        }
                        
                        $invoices->delete();
                        
        return redirect(route('invoice.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Items::where('id',$request->id)->get();
                return response()->json($price);                      

    }
    
public function findQuantity2(Request $request)
   {

  $item=$request->item;
 $location=$request->location;
 $date = today()->format('Y-m');

 $item_info=Items::where('id', $item)->first();  
 $location_info=Location::find($request->location);
 if ($item_info->type == '4') {
 $price='' ;
 }
 else{
  if ($item_info->quantity > 0) {

 $a=SerialList::where('brand_id',$item)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->whereNull('expire_date')->sum('due_quantity');  
 $b=SerialList::where('brand_id',$item)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('status',0)->whereNotNull('expire_date')->where('expire_date', '>=', $date)->sum('due_quantity'); 


 $quantity=$a + $b;

  if ($quantity > 0) {

 if($request->id >  $quantity){
 $price="You have exceeded your Stock. Choose quantity between 1.00 and ".  number_format($quantity,2) ;
 }
 else if($request->id <=  0){
 $price="Choose quantity between 1.00 and ".  number_format($quantity,2) ;
 }

 else{
 $price='' ;
  }

 }

 else{
 $price=$location_info->name . " Stock Balance  is Zero." ;

 }



 }



 else{
 $price="Your Stock Balance is Zero." ;

 }

 
 }               

 return response()->json($price);                      
 
     }
     
     
     
     


   public function discountModal(Request $request)
    {

          $id=$request->id;
                 $type = $request->type;

          switch ($type) {      
     case 'client':
            return view('pos.sales2.client_modal');
                    break;
                    
                    
     case 'scan':
            return view('pos.sales2.scan_modal',compact('id'));
                    break;
                    
                                   
     case 'commission':
         $data=Invoice::find($id);
         $items= DB::table('invoice_commission')->where('invoice_id',$id)->select("*")->select("*")->get();
         $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
          $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
          
          $name = Items::leftJoin('pos_invoice_items', 'tbl_items.id','pos_invoice_items.item_name')
                          ->where('pos_invoice_items.invoice_id',$id)
                          ->whereIn('tbl_items.type', [1,2,4])
                           ->where('pos_invoice_items.due_quantity','>', '0')
                          ->where('tbl_items.added_by',auth()->user()->added_by)
                          ->where('tbl_items.restaurant','0')
                          ->select('tbl_items.*')
                              ->get();
                              

            return view('pos.sales2.commission_modal',compact('id','items','user','bank_accounts','data','name'));
                    break;
                    
                    case 'edit':
                  $item = Items::whereIn('type', [1,2,4 ])->where('added_by', auth()->user()->added_by)->where('disabled', '0')->get();
                  $name=$request->item_name[0];
                  $desc=$request->description[0];
                  $qty=$request->quantity[0];
                  $price=str_replace(",","",$request->price[0]);
                  $cost=$request->total_cost[0];
                  $tax=$request->total_tax[0];
                  $unit=$request->unit[0];
                  $rate=$request->tax_rate[0];
                  $order=$request->no[0];
                  if(!empty($request->saved_items_id[0])){
                  $saved=$request->saved_items_id[0];
                  }
                  else{
                   $saved='';   
                  }
                return view('pos.sales2.edit_modal', compact('item','name','desc','qty','price','cost','tax','unit','rate','order','type','saved'));
                break;
                
                 

 default:
             break;

            }

                       }

     
   
public function findItem(Request $request){
       
      //dd($request->all());

        $items =  InvoiceItems::where('invoice_id', $request->invoice)->where('item_name', $request->id)->where('added_by',auth()->user()->added_by)->first();

            return response()->json($items);
         

       
   }
   
   public function check_item(Request $request){
       
      //dd($request->all());

        $list = '';
         $list1 = ''; 
        $it = Items::where('barcode', $request->barcode)->where('added_by',auth()->user()->added_by)->where('disabled','0')->whereNotNull('barcode')->first();
        
        $c = Color::find($it->color);
            $s = Size::find($it->size);
                    
           if(!empty($c) && empty($s)){
             $a = $it->name .' - '.$c->name;  
           }
              
          elseif(empty($c) && !empty($s)){
             $a =  $it->name .' - '.$s->name;   
           } 
           
           elseif(!empty($c) && !empty($s)){
           $a =  $it->name .' - '.$c->name . ' - '.$s->name;
           } 
           
           else{
                $a =  $it->name ; 
           }
                   
          $name=$it->id;
          $desc=$it->description;
          $qty=1;
          $price=str_replace(",","",$it->sales_price);
          $cost=$price;
          $tax=$it->tax_rate * $price;
          $order=$request->order_no;
          $unit=$it->unit;
          $rate=$it->tax_rate;
          
          
          $list .= '<tr class="trlst'.$order.'">';
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.number_format($cost,2).'</td>';
            $list .= '<td>'.number_format($tax,2).'</td>';
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            $list .= '</tr>';
                    
            $list1 .= '<div class="line_items" id="lst'.$order.'">';
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
             $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
             $list1 .= '<input type="hidden"  class="form-control item_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
            $list1 .= '</div>';
        
        
        

          return response()->json([
            'list'          => $list,
            'list1' => $list1
    ]);
         

       
   }
        
        
        
 public function add_item(Request $request)
    {
        //dd($request->all());

       $data=$request->all();
       
       
        
          $list = '';
          $list1 = ''; 
          
           $it=Items::where('id',$request->checked_item_name)->first();
            $c = Color::find($it->color);
            $s = Size::find($it->size);
                    
           if(!empty($c) && empty($s)){
             $a = $it->name .' - '.$c->name;  
           }
              
          elseif(empty($c) && !empty($s)){
             $a =  $it->name .' - '.$s->name;   
           } 
           
           elseif(!empty($c) && !empty($s)){
           $a =  $it->name .' - '.$c->name . ' - '.$s->name;
           } 
           
           else{
                $a =  $it->name ; 
           }
                   
          $name=$request->checked_item_name[0];
          $desc=$request->checked_description[0];
          $qty=$request->checked_quantity[0];
          $price=str_replace(",","",$request->checked_price[0]);
          $order=$request->checked_no[0];
          $unit=$request->checked_unit[0];
          $rate=$request->checked_tax_rate[0];
          
           if($rate == '0'){
             $r='Inclusive';
             $sub=(($qty * $price)/1.18);
             $tax=($qty * $price) - $sub;
             $cost=$qty * $price;
             
          }
         else if($rate == '0.18'){
              $r='Exclusive';
              $sub=$qty * $price;
              $tax=($qty * $price) * 0.18;
              $cost=($qty * $price) + $tax;

          }
          
          if(!empty($request->saved_items_id[0])){
            $saved=$request->saved_items_id[0];
            }
            else{
            $saved='';   
                  }
          
          if(!empty($request->type) && $request->type == 'edit'){
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$r.'</td>';
            $list .= '<td>'.number_format($tax,2).'</td>';
            $list .= '<td>'.number_format($cost,2).'</td>';
             if(!empty($saved)){
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger rem" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '" value="'.$saved.'"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
                }
            else{
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            }
            
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="sub[]" class="form-control item_sub" id="sub lst'.$order.'"  value="'.$sub.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            $list1 .= '<input type="hidden"  class="form-control item_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
            
            if(!empty($saved)){
            $list1 .= '<input type="hidden" name="saved_items_id[]" class="form-control item_saved'.$order.'" value="'.$saved.'"  required/>';
                }
          }
            else{
            $list .= '<tr class="trlst'.$order.'">';
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$r.'</td>';
            $list .= '<td>'.number_format($tax,2).'</td>';
            $list .= '<td>'.number_format($cost,2).'</td>';
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            $list .= '</tr>';
                    
            $list1 .= '<div class="line_items" id="lst'.$order.'">';
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="description[]" class="form-control item_desc" id="desc lst'.$order.'"  value="'.$desc.'"  />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="sub[]" class="form-control item_sub" id="sub lst'.$order.'"  value="'.$sub.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
             $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
             $list1 .= '<input type="hidden"  class="form-control item_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
            $list1 .= '</div>';
            }


             return response()->json([
            'list'          => $list,
            'list1' => $list1
    ]);
        
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

     if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Approved",
                        ]
                        );                      
       }
        return redirect(route('invoice.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);
       if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Cancelled",
                        ]
                        ); 
}
        return redirect(route('invoice.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $client=Client::where('owner_id',auth()->user()->added_by)->get(); 
        $name =Items::whereIn('type', [1,2,4])->where('added_by',auth()->user()->added_by)->where('restaurant','0')->where('disabled','0')->get();    
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->orderBy('id','asc')->get(); 
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
    //$location=Location::where('added_by',auth()->user()->added_by)->get();;
         $location=LocationManager::where('manager',auth()->user()->id)->where('disabled','0')->get();
        $type="receive";
       return view('pos.sales2.invoice',compact('name','client','currency','data','id','items','type','bank_accounts','location'));
    }

 
    public function make_payment($id)
    {
        //
        $invoice = Invoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
        return view('pos.sales2.invoice_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function invoice_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.sales2.invoice_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('SALES INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('inv_pdfview');
    }
    
     public function invoice_receipt(Request $request){

        //if landscape heigth * width but if portrait widht *height;
        $customPaper = array(0,0,198.425,494.80);

        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();
     

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pos.sales2.invoice_receipt_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('SALES RECEIPT INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('invoice_receipt');

    }
    
      public function print_pdfview(Request $request)
    {
        
        //if landscape heigth * width but if portrait widht *height;
        $customPaper = array(0,0,198.425,494.80);
        
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();
        
        $pdf = PDF::loadView('pos.sales2.invoice_details_pdf', compact('invoices','invoice_items'));
        $output = $pdf->output();
       
       return new Response($output, 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' =>  'inline; filename="invoice.pdf"',
]);

       
    }
    
    
     public function receipt_print_pdfview(Request $request)
    {
        //
        //if landscape heigth * width but if portrait widht *height;
        $customPaper = array(0,0,198.425,494.80);
        
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->where('due_quantity','>', '0')->get();
        
        $pdf = PDF::loadView('pos.sales2.invoice_receipt_pdf', compact('invoices','invoice_items'))->setPaper($customPaper, 'portrait');
        $output = $pdf->output();
       
       return new Response($output, 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' =>  'inline; filename="invoice_receipt.pdf"',
]);

       
    }
    

public function debtors_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
       $account_id=$request->account_id;
        $currency=$request->currency;
        $chart_of_accounts = [];
         $accounts = [];

        foreach (Client::where('owner_id',auth()->user()->added_by)->where('disabled',0)->get() as $key) {
            $chart_of_accounts[$key->id] = $key->name;
        }
         foreach (Currency::all() as $key) {
            $accounts[$key->code] = $key->name;
        }
        if($request->isMethod('post')){
         $data=Invoice::where('client_id', $request->account_id)->where('exchange_code', $request->currency)->whereBetween('invoice_date',[$start_date,$end_date])->where('status','!=',0)->where('added_by',auth()->user()->added_by)->get();
        }else{
            $data=[];
        }

       

        return view('pos.sales2.debtors_report',
            compact('start_date',
                'end_date','chart_of_accounts','data','account_id','currency','accounts'));
    }

public function debtors_summary_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $currency=$request->currency;
         $accounts = [];

     foreach (Currency::all() as $key) {
            $accounts[$key->code] = $key->name;
        }
        if($request->isMethod('post')){
       $data= Invoice::where('exchange_code', $request->currency)->whereBetween('invoice_date',[$start_date,$end_date])->where('status','!=',0)->where('added_by',auth()->user()->added_by)->groupBy('client_id')->get();
        }else{
            $data=[];
        }

       

        return view('pos.sales2.debtors_summary_report',
            compact('start_date',
                'end_date','data','currency','accounts'));
    }



public function findQuantity(Request $request)
   {

  $item=$request->item;
 $location=$request->location;
 $date = today()->format('Y-m');

 $item_info=Items::where('id', $item)->first();  
 $location_info=Location::find($request->location);
 
 //a
 if ($item_info->type == '4') {
 $price='' ;
 }
 //b
 else{
 

 $pqty= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
 $dn= PurchaseHistory::where('item_id', $item)->where('location',$location)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');  
 $dgood=StockMovementItem::where('item_id',$item)->where('destination_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

$sgood=StockMovementItem::where('item_id',$item)->where('source_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');
 $issue=GoodIssueItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum(\DB::raw('quantity - returned'));
 $sqty= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Sales')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
  $cn= InvoiceHistory::where('item_id', $item)->where('location',$location)->where('type', 'Credit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');  
   $disposal=GoodDisposalItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

 $qty=$pqty-$dn;
 $inv=$sqty-$cn ;

 //$quantity=($pqty-$dn)-($sqty-$cn);

 $quantity=($qty + $dgood) - ($issue +$inv + $sgood + $disposal);;

//c
  if ($quantity > 0) {

//d
 if($request->id >  $quantity){
 $price="You have exceeded your Stock. Choose quantity between 0.00 and ".  number_format($quantity,2) ;
 }
 //e
 else if($request->id <=  0){
 $price="Choose quantity between 0.00 and ".  number_format($quantity,2) ;
 }
//f
 else{
 $price='' ;
  }

 }

 else{
 $price=$location_info->name . " Stock Balance  is Zero." ;

 }



 }


 return response()->json($price);                      
 
     }
     
     
     
     public function uploadImageViaAjax(Request $request)
{
    $name = [];
    $original_name = [];
    foreach ($request->file('file') as $key => $value) {
        $image = uniqid() . time() . '.' . $value->getClientOriginalExtension();
        $destinationPath = public_path().'/pos/';
        $value->move($destinationPath, $image);
        $name[] = $image;
        $original_name[] = $value->getClientOriginalName();
        
        
 
	
    }

    return response()->json([
        'name'          => $name,
        'original_name' => $original_name
    ]);
}


 public function deleteImageViaAjax(Request $request)
{
    $filename =  $request->get('filename');
	//Gallery::where('filename',$filename)->delete();
	$path = public_path('pos/').$filename;
	if (file_exists($path)) {
		unlink($path);
	}
	return response()->json(['success'=>$filename]);
}


public function getImageViaAjax(Request $request)
{
	$images = InvoiceAttachment::all()->where('invoice_id',$request->id)->toArray();
	foreach($images as $image){
		$tableImages[] = $image['filename'];
	}
	$storeFolder = public_path('pos');
	$file_path = public_path('pos');
	$files = scandir($storeFolder);
	foreach ( $files as $file ) {
		if ($file !='.' && $file !='..' && in_array($file,$tableImages)) { 
		    $og=InvoiceAttachment::where('invoice_id',$request->id)->where('filename',$file)->first();
			$obj['name'] = $og->original_filename;
			$file_path = public_path('pos/').$file;
			$obj['size'] = filesize($file_path);          
			$obj['path'] = url('public/pos/'.$file);
			$obj['img'] = $file;
			$data[] = $obj;
		}
		
	}
	//dd($data);
	return response()->json($data);
}


 public function attachModal(Request $request)
    {

          $id=$request->id;
                 $type = $request->type;

          switch ($type) {      
     case 'attach':
         $images = InvoiceAttachment::where('invoice_id',$id)->get();
            return view('pos.sales2.attachment_modal',compact('id','images'));
                    break;

 default:
             break;

            }

                       }
                       
                       
                       
 public function save_attachment(Request $request)
    {
        //
  
        $imgArr =$request->filename ;
         $ogArr =$request->original_filename ;

             if(!empty($imgArr)){
            for($i = 0; $i < count($imgArr); $i++){
                if(!empty($imgArr[$i])){

                    
                    InvoiceAttachment::create([
                        'filename' =>$imgArr[$i],
                        'original_filename' =>$ogArr[$i],
                        'order_no' => $i,
                        'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$request->invoice_id
                                ]);
                    
                }
            }
            
             return redirect(route('invoice.index'))->with(['success'=>'Uploaded Successfully']);
        } 

       else{
           
            return redirect(route('invoice.index'))->with(['error'=>'No File Uploaded ']);
       }
        
      
        
    }
                       
   
   
   public function download_attachment($id)
{
    $data=InvoiceAttachment::find($id);

        $file = $data->filename;
        $myFile = public_path("pos/".$file);

        $newName = $data->original_filename;

    	return response()->download($myFile, $newName);
     
}                    
                       
public function delete_attachment($id)
{
    $data=InvoiceAttachment::find($id);
    $filename =  $data->filename;
	$path = public_path('pos/').$filename;
	if (file_exists($path)) {
		unlink($path);
	}
	$data->delete();
	
 return redirect(route('invoice.index'))->with(['success'=>'Deleted Successfully']);
}


public function save_commission(Request $request)
    {
        //
  
     
        $nameArr =$request->user_id ;
        $itemArr =$request->item_name;
        $costArr =  str_replace(",","",$request->total_cost);
        $totalArr =  str_replace(",","",$request->amount);
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;

       $subArr = str_replace(",","",$request->subtotal);


      
     if(!empty($nameArr)){
        for($i = 0; $i < count($subArr); $i++){
            if(!empty($subArr[$i])){
                $t = array(
                'commission_bank'=>   $request->bank_id,  
                   'commission' =>  $subArr[$i]);
                   
                  

                       Invoice::where('id',$request->id)->update($t);  
                       


            }
        }
    } 



       

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){ 
                DB::table('invoice_commission')->where('id',$remArr[$i])->delete(); 
                   }
               }
           }


        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                   
                    $x=Invoice::find($request->id);   

                    $items = array(
                   'user_id' => $nameArr[$i],
                    'invoice_date' =>  $x->invoice_date,
                    'item_name' =>$itemArr[$i],
                     'total_cost' =>$costArr[$i],
                    'amount' =>$totalArr[$i],
                    'bank_id' =>  $request->bank_id,
                    'added_by' => auth()->user()->added_by,
                    'invoice_id' =>$request->id);
                       
                        if(!empty($expArr[$i])){
                            DB::table('invoice_commission')->where('id',$expArr[$i])->update($items);  
                            
                            }
                            else{
                           DB::table('invoice_commission')->insert($items);   
                            }
                            
                          
                }
            }
            
        }   
                            
                            
                $comm= DB::table('invoice_commission')->where('invoice_id', $request->id)->get(); 
                
                JournalEntry::where('income_id',$request->id)->where('transaction_type','pos_commission')->where('added_by', auth()->user()->added_by)->delete();
                
                foreach($comm as $c){
                    
                 $inv = Invoice::find($request->id);    
                $staff=User::find($c->user_id);  
                
             $cm= AccountCodes::where('account_name','Sales Commission')->where('added_by', auth()->user()->added_by)->first();      
            $journal = new JournalEntry();
          $journal->account_id = $cm->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_commission';
          $journal->name = 'Sales Commission';
          $journal->debit = $c->amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
            $journal->notes= "Commission for Sales  Invoice No " .$inv->reference_no ." to user ". $staff->name ;
          $journal->save();
       
     
        
            $journal = new JournalEntry();
          $journal->account_id = $request->bank_id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_commission';
          $journal->name = 'Sales Commission';
          $journal->credit =$c->amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->branch_id= $inv->branch_id;
          $journal->notes= "Commission for Sales  Invoice No " .$inv->reference_no ." to user ". $staff->name ;
          $journal->save();
                    
                }        
                    
      
        
       return redirect(route('invoice.index'))->with(['success'=>'Created Successfully']);
      
      
        
    }
                       
   

 public function commission_report(Request $request)
    {
       
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        
        
        //$data = User::whereColumn('added_by', 'id')->get();
        
        $data = DB::table('users')->leftJoin('invoice_commission', 'invoice_commission.user_id','users.id')
                           ->whereBetween('invoice_commission.invoice_date',[$start_date,$end_date])
                            ->where('users.added_by',auth()->user()->added_by)
                           ->select('users.*','invoice_commission.*')
                           ->groupBy('invoice_commission.user_id')
                             ->get() ;
                             
                            //dd ($data);
                            
            
        
        return view('pos.sales2.commission_report',
            compact('start_date',
                'end_date','data'));
    }
    




}
