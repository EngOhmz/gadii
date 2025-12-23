<?php

namespace App\Http\Controllers\Restaurant\POS;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\LocationManager;
use App\Models\Restaurant\POS\Menu;
use App\Models\Restaurant\POS\MenuComponent;
use App\Models\Restaurant\POS\Order;
use App\Models\Restaurant\POS\OrderItem;
use App\Models\Restaurant\POS\OrderHistory;
use App\Models\Restaurant\POS\OrderPayments;
use App\Models\POS\PurchaseHistory;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\SerialList;
use App\Models\POS\GoodIssue;
use App\Models\POS\GoodIssueItem;
use App\Models\POS\StockMovement;
use App\Models\POS\StockMovementItem;
use App\Models\POS\GoodDisposal;
use App\Models\POS\GoodDisposalItem;
use App\Models\POS\Items;
use App\Models\Client;
use App\Models\POS\Activity as POSActivity;
use App\Models\Restaurant\POS\Activity;
use App\Models\AccountCodes;
use App\Models\Accounts;
use App\Models\Currency;
use App\Models\Payment_methodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use PDF;
use DB;

class OrderController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           $index=Order::where('added_by',auth()->user()->added_by)->orderBy('created_at','desc')->get();
          $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
         $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();    
        $name =Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('bar','1')->where('disabled','0')->get();   
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $currency= Currency::all();
          $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
            $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
          $type="";
            return view('restaurant.orders.index', compact('index','type','location','bank_accounts','currency','client','name','user','branch'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(6/strlen($x)) )),1,6);
        
        $data['reference_no']= $random;
       $data['client_id']=$request->client_id;
        $data['user_type']=$request->user_type;
        $data['invoice_date']=date('Y-m-d');
        $data['location']=$request->location;
        $data['account_id']=$request->account_id;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
      $data['notes']=$request->notes;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['status']='0';
        $data['good_receive']='0';
        $data['invoice_status']=1;
         $data['user_agent']= $request->user_agent;
          $data['branch_id']=$request->branch_id;
         $data['user_id']= auth()->user()->id;
        $data['added_by']= auth()->user()->added_by;

        $invoice = Order::create($data);
        
       

        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $typeArr = $request->type  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $savedArr =$request->item_name ;
        
        
        $subArr = str_replace(",","",$request->subtotal);
        $totalArr =  str_replace(",","",$request->tax);
        $amountArr = str_replace(",","",$request->amount);
        $disArr =  str_replace(",","",$request->discount);

     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $subArr[$i],
                     'invoice_tax' =>  $totalArr[$i],                     
                      'discount' => $disArr[$i] ,
                   'due_amount' =>  $amountArr[$i]);

                       Order::where('id',$invoice->id)->update($t);  


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
                         'type' => $typeArr[$i],
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                       'due_quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id);
                       
                       OrderItem::create($items);  ;
    
    
                }
            }

            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
           OrderItem::where('id',$invoice->id)->update($cost);
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

       
        return redirect(route('orders.show',$invoice->id))->with(['success'=>'Order Created Successfully']);
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
        $invoices =Order::find($id);
        $invoice_items=OrderItem::where('invoice_id',$id)->get();
       $payments=OrderPayments::where('invoice_id',$id)->get();
       return view('restaurant.orders.order_details',compact('invoices','invoice_items','payments'));

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $data=Order::find($id);
        $items=OrderItem::where('invoice_id',$id)->get();
        $type="";
       $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
          $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get(); 
        $name =Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('bar','1')->where('disabled','0')->get();           
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $currency= Currency::all();
          $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
           $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('restaurant.orders.index',compact('currency','data','id','items','type','location','bank_accounts','client','name','user','branch'));

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
       
//dd($request->edit_type);

         if($request->edit_type == 'receive'){
            $invoice  =Order::find($id);

        $data['client_id']=$request->client_id;
        $data['user_type']=$request->user_type;
        $data['invoice_date']=date('Y-m-d');
        $data['location']=$request->location;
        $data['account_id']=$request->account_id;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['notes']=$request->notes;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['good_receive']='1';
        $data['status']='1';
        $data['branch_id']=$request->branch_id;
         $data['user_agent']= $request->user_agent;
        $data['added_by']= auth()->user()->added_by;
    
            $invoice->update($data);
            

    
        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $typeArr = $request->type  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
            $remArr = $request->removed_id ;
            $expArr = $request->saved_items_id ;
            $savedArr =$request->item_name ;
            
            
            $subArr = str_replace(",","",$request->subtotal);
        $totalArr =  str_replace(",","",$request->tax);
        $amountArr = str_replace(",","",$request->amount);
        $disArr =  str_replace(",","",$request->discount);
            
            $cost['invoice_amount'] = 0;
            $cost['invoice_tax'] = 0;
            
            
     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $subArr[$i],
                     'invoice_tax' =>  $totalArr[$i],                     
                      'discount' => $disArr[$i] ,
                   'due_amount' =>  $amountArr[$i]);

                       Order::where('id',$id)->update($t);  


            }
        }
    }
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                   OrderItem::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['invoice_amount'] +=$costArr[$i];
                        $cost['invoice_tax'] +=$taxArr[$i];
                        
    
                        $items = array(
                        'type' => $typeArr[$i],
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                       'due_quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                        'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                          'order_no' => $i,
                          'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$id);
                           
                            if(!empty($expArr[$i])){
                                OrderItem::where('id',$expArr[$i])->update($items);  
          
          }
          else{
              OrderItem::create($items);   
          }
                      
               
         
  
                    }
                }
                $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
              
            }    
    
            
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
    
                            if($typeArr[$i] == 'Bar'){
                        $saved=Items::find($savedArr[$i]);
                        
                        $cr=$qtyArr[$i]/$saved->bottle;
                         $cq=round($cr, 1);
                        
                        $lists= array(
                            'price' =>   $priceArr[$i],
                               'quantity' =>   $cq,
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'client_id' =>   $request->client_id,
                             'invoice_date' =>  $data['invoice_date'],
                             'location' =>    $data['location'],
                            'type' =>   'Sales',
                            'invoice_id' =>$id);
                           
                         //InvoiceHistory::create($lists);   
          
                        $inv=Items::where('id',$nameArr[$i])->first();
                        $q=$inv->quantity - $cq;
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);

                        $loc=Location::where('id',$data['location'])->first();
                        $lq['crate']=$loc->crate - $cq;
                        $lq['bottle']=$loc->bottle - $qtyArr[$i];
                        $lq['quantity']=$loc->quantity - $cq;
                        Location::where('id',$data['location'])->update($lq);
                        
                          /* 
                         $date = today()->format('Y-m');
                       
       $chk=SerialList::where('brand_id',$nameArr[$i])->where('location',$request->location)->where('added_by',auth()->user()->added_by)->where('bar','1')->where('crate_status','0')->where('expire_date', '>=', $date)
        ->orWhereNull('expire_date')->where('brand_id',$nameArr[$i])->where('location',$request->location)->where('added_by',auth()->user()->added_by)->where('bar','1')->where('crate_status','0')->get();
        
        if(!empty($chk[0])){
            $balance= $qtyArr[$i];
            
        foreach($chk as $ck)   {
            
             if ($ck->due_quantity >= $balance) {
        $series['due_quantity'] = $ck->due_quantity  - $balance;
        $balance = 0;
      if($series['due_quantity'] > 0){
        $series['status']='2'; 
        $series['crate_status']='0';
      }
      
      else{
        $series['status']='2'; 
        $series['crate_status']='1';   
      }
        
    } else {
        // allocate everything available
        $balance = $balance -$ck->due_quantity;
       
       $series['due_quantity'] = 0;
      $series['status']='2'; 
        $series['crate_status']='1'; 
    }
   


 $sql=SerialList::find($ck->id)->update($series);
 
 // we have already allocated required stock so no need to continue
    if ($balance === 0) {
        break;
    }
            
        } 
        }
        
        */
                    }
                }
            
            }    



           if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        
                        $x_lists= array(
                            'quantity' =>   $qtyArr[$i],
                            'price' =>   $priceArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'client_id' =>   $request->client_id,
                             'invoice_date' =>  $data['invoice_date'],
                             'location' =>    $data['location'],
                            'type' =>   'Sales',
                              'item_type' =>  $typeArr[$i],
                            'invoice_id' =>$id);
                           
                         OrderHistory::create($x_lists);   

                    }
                }
            
            }    
    
           
$total_cost=0;
  
     $x_items= OrderItem::where('invoice_id',$id)->get()  ;
     foreach($x_items as $x){
       $a=Items::where('id',$x->item_name)->first(); 
          if($x->type == 'Bar'){
              $bottle=number_format($a->cost_price/$a->bottle,2);
            $total_cost+= $bottle * $x->quantity;
         
       }
       else{
       $total_cost=0; 
       }
         
     }
    
     //dd($total_cost);
            $inv =Order::find($id);
       
            $supp=Client::find($inv->client_id);
            if(!empty($supp)){
           $user=$supp->name;
            }        

            $cr= AccountCodes::where('account_name','Sales')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type ='orders';
          $journal->name = 'Orders';
          $journal->credit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
          $journal->client_id= $inv->client_id;
           $journal->branch_id= $inv->branch_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Order Sales for Invoice No " .$inv->reference_no  ;
          $journal->save();

        
        if($inv->invoice_tax > 0){
         $tax= AccountCodes::where('account_name','VAT OUT')->where('added_by',auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'orders';
          $journal->name = 'Orders';
          $journal->credit= $inv->invoice_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
            $journal->client_id= $inv->client_id;
             $journal->branch_id= $inv->branch_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
           $journal->added_by=auth()->user()->added_by;
        $journal->notes= "Order Sales Tax for Invoice No " .$inv->reference_no ;
          $journal->save();
        }
        
          $codes=AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
           $journal->transaction_type = 'orders';
          $journal->name = 'Orders';
          $journal->income_id= $inv->id;
          $journal->client_id= $inv->client_id;
           $journal->branch_id= $inv->branch_id;
          $journal->debit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
            $journal->notes= "Receivables for Order Sales Invoice No " .$inv->reference_no ;
          $journal->save();
          
          
           if($total_cost > 0){
               
           $stock= AccountCodes::where('account_name','Inventory')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'orders';
          $journal->name = 'Orders';
          $journal->credit = $total_cost;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
          $journal->branch_id= $inv->branch_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Reduce Stock  for Order Sales Invoice No " .$inv->reference_no ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'orders';
          $journal->name = 'Orders';
          $journal->debit = $total_cost;
          $journal->income_id= $inv->id;
           $journal->branch_id= $inv->branch_id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Cost of Goods Sold for Sales  Invoice No " .$inv->reference_no ;
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
         $journal->transaction_type = 'orders';
          $journal->name = 'Orders';
          $journal->debit = $inv->discount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
          $journal->branch_id= $inv->branch_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Sales Discount for for Sales  Invoice No " .$inv->reference_no ;
          $journal->save();
       
     
          $disc= AccountCodes::where('account_name','Sales Discount')->where('added_by', auth()->user()->added_by)->first();
            $journal = new JournalEntry();
          $journal->account_id = $disc->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'orders';
          $journal->name = 'Orders';
          $journal->credit = $inv->discount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
          $journal->branch_id= $inv->branch_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
          $journal->notes= "Sales Discount for for Sales  Invoice No " .$inv->reference_no ;
          $journal->save();

        }
    

 if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Order with reference no  " .  $invoice->reference_no. "  is Delivered",
                        ]
                        );                      
       }


          //invoice payment


          $sales =Order::find($id);
          $method= Payment_methodes::where('name','Cash')->first();
    
          $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(4/strlen($x)) )),1,4);

          $receipt['trans_id'] = "OP-".$random;
          $receipt['invoice_id'] = $inv->id;
          $receipt['account_id'] = $request->account_id;
          $receipt['amount'] = $inv->due_amount;
          $receipt['date'] = $inv->invoice_date;
          $receipt['payment_method'] = $method->id;
          $receipt['added_by'] = auth()->user()->added_by;
          
          //update due amount from invoice table
          $b['due_amount'] =  0;
          $b['status'] = 3;
  
          
                  $sales->update($b);
                   
                  $payment = OrderPayments::create($receipt);
  
                  
  
                 $cr= AccountCodes::where('id',$request->account_id)->first();
            $journal = new JournalEntry();
          $journal->account_id = $request->account_id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =  $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'orders_payments';
          $journal->name = 'Orders Payment';
          $journal->debit = $receipt['amount'] *  $sales->exchange_rate;
          $journal->payment_id= $payment->id;
           $journal->client_id= $inv->client_id;
            $journal->branch_id= $sales->branch_id;
           $journal->currency_code =   $sales->currency_code;
          $journal->exchange_rate=  $sales->exchange_rate;
            $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Deposit for Order Sales Invoice No " .$sales->reference_no  ;
          $journal->save();
  
  
          $codes= AccountCodes::where('account_name','Receivable and Prepayments')->where('added_by',auth()->user()->added_by)->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
            $journal->transaction_type =  'orders_payments';
          $journal->name = 'Orders Payment';
          $journal->credit =$receipt['amount'] *  $sales->exchange_rate;
            $journal->payment_id= $payment->id;
         $journal->client_id= $inv->client_id;
          $journal->branch_id= $sales->branch_id;
           $journal->currency_code =   $sales->currency_code;
          $journal->exchange_rate=  $sales->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Clear Receivable for Order Sales Invoice No  " .$sales->reference_no  ;
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
                                  'module' => 'Orders Payment',
                                   'module_id' => $payment->id,
                                 'account_id' => $request->account_id,
                                  'code_id' => $codes->id,
                                  'name' => 'Order Payment with reference ' .$payment->trans_id,
                                   'transaction_prefix' => $payment->trans_id,
                                  'type' => 'Income',
                                  'amount' =>$payment->amount ,
                                  'credit' => $payment->amount,
                                   'total_balance' =>$balance,
                                  'date' => date('Y-m-d', strtotime($request->invoice_date)),
                                  'paid_by' => $sales->client_id,
                                  'payment_methods_id' =>$payment->payment_method,
                                     'status' => 'paid' ,
                                'notes' => 'This deposit is from order sales payment. The Order Reference is ' .$sales->reference_no   ,
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

            return redirect(route('orders.show',$id))->with(['success'=>'Order Delivered Successfully']);
    

        }

        else{
        $invoice = Order::find($id);
          $data['client_id']=$request->client_id;
        $data['user_type']=$request->user_type;
        $data['invoice_date']=date('Y-m-d');
        $data['location']=$request->location;
        $data['account_id']=$request->account_id;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
      $data['notes']=$request->notes;
            $data['invoice_amount']='1';
            $data['due_amount']='1';
            $data['invoice_tax']='1';
            $data['branch_id']=$request->branch_id;
             $data['user_agent']= $request->user_agent;
            $data['added_by']= auth()->user()->added_by;
    
            $invoice->update($data);
            
            $amountArr = str_replace(",","",$request->amount);
            $totalArr =  str_replace(",","",$request->tax);
    
            $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $typeArr = $request->type  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
            $remArr = $request->removed_id ;
            $expArr = $request->saved_items_id ;
            $savedArr =$request->item_name ;
            
            
             $subArr = str_replace(",","",$request->subtotal);
        $totalArr =  str_replace(",","",$request->tax);
        $amountArr = str_replace(",","",$request->amount);
        $disArr =  str_replace(",","",$request->discount);

     if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'invoice_amount' =>  $subArr[$i],
                     'invoice_tax' =>  $totalArr[$i],                     
                      'discount' => $disArr[$i] ,
                   'due_amount' =>  $amountArr[$i]);

                       Order::where('id',$id)->update($t);  


            }
        }
    } 
            
            $cost['invoice_amount'] = 0;
            $cost['invoice_tax'] = 0;
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                   OrderItem::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['invoice_amount'] +=$costArr[$i];
                        $cost['invoice_tax'] +=$taxArr[$i];
    
                        $items = array(
                          'type' => $typeArr[$i],
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                       'due_quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                             'items_id' => $savedArr[$i],
                               'order_no' => $i,
                               'added_by' => auth()->user()->added_by,
                            'invoice_id' =>$id);
                           
                            if(!empty($expArr[$i])){
                                OrderItem::where('id',$expArr[$i])->update($items);  
          
          }
          else{
              OrderItem::create($items);   
          }
                      
                 
  
                    }
                }
                $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
                Order::where('id',$id)->update($cost);
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

              return redirect(route('orders.show',$id))->with(['success'=>'Order Updated Successfully']);

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

       OrderItem::where('invoice_id', $id)->delete();
       OrderPayments::where('invoice_id', $id)->delete();
       
        $invoices =Order::find($id);


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

         return redirect(route('orders.index'))->with(['success'=>'Order Deleted Successfully']);
    }


 public function cancel($id)
    {
        //
        $invoice = Order::find($id);
        $data['status'] = 4;
        $invoice->update($data);

if(!empty($invoice)){
                    $activity =Activity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$id,
                             'module'=>'Invoice',
                            'activity'=>"Invoice with reference no  " .  $invoice->reference_no. "  is Cancelled",
                        ]
                        ); 
}

         return redirect(route('orders.index'))->with(['success'=>'Cancelled Successfully']);
    }
   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $data=Order::find($id);
        $items=OrderItem::where('invoice_id',$id)->get();
        $type="receive";
           $location = Location::leftJoin('location_manager', 'locations.id','location_manager.location_id')
                          ->where('locations.disabled','0')
                          ->where('locations.added_by',auth()->user()->added_by)
                           ->where('location_manager.manager',auth()->user()->id)     
                           ->select('locations.*')
                              ->get()  ;
          $client=Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get(); 
        $name =Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('bar','1')->where('disabled','0')->get();          
        $bank_accounts=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
         $user =User::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();;
          $branch = Branch::where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
       return view('restaurant.orders.index',compact('currency','data','id','items','type','location','bank_accounts','client','name','user','branch'));
    }


  
    
    public function orders_pdfview(Request $request)
    {
        //
        $invoices =Order::find($request->id);
        $invoice_items=OrderItem::where('invoice_id',$request->id)->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('restaurant.orders.order_details_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('ORDER NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('orders_pdfview');
    }
    
    public function orders_receipt(Request $request){

        //if landscape heigth * width but if portrait widht *height      // dd($dataResult);
        $customPaper = array(0,0,198.425,494.80);

        $invoices =Order::find($request->id);
        $invoice_items=OrderItem::where('invoice_id',$request->id)->get();
     

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
            
            if($invoices->good_receive ==0){
        $pdf = PDF::loadView('restaurant.orders.order_receipt_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('ORDER RECEIPT NO # ' .  $invoices->reference_no . ".pdf");
            }
            
            else{
                $pdf = PDF::loadView('restaurant.orders.bill_receipt_pdf')->setPaper($customPaper, 'portrait');
         return $pdf->download('BILL RECEIPT NO # ' .  $invoices->reference_no . ".pdf");  
            }
        }
       return view('orders_receipt');

    }


public function orders_payment_pdfview(Request $request)
    {
        //
          $data=OrderPayments::find($request->id);
        $invoice = Order::find($data->invoice_id);
      
      //if landscape heigth * width but if portrait widht *height      // dd($dataResult);
        $customPaper = array(0,0,198.425,494.80);

        view()->share(['invoice'=>$invoice,'data'=> $data]);

        if($request->has('download')){
        $pdf = PDF::loadView('restaurant.orders.payment_pdf')->setPaper($customPaper, 'potrait');
         return $pdf->download('ORDER PAYMENT REF NO # ' .  $data->trans_id . ".pdf");
        }
        return view('orders_payment_pdfview');
    }

   
   
      public function discountModal(Request $request)
    {

          $id=$request->id;
        $modal_type = $request->modal_type;

          switch ($modal_type) {      
     case 'client':
            return view('restaurant.orders.client_modal');
                    break;
                    
                 case 'edit':
            
            //dd($request->all());         
          $type=$request->type[0];
          $name=$request->item_name[0];
          $qty=$request->quantity[0];
          $price=str_replace(",","",$request->price[0]);
          $cost=$request->total_cost[0];
          $tax=$request->total_tax[0];
          $order=$request->no[0];
          $unit=$request->unit[0];
          $rate=$request->tax_rate[0];
          
          if(!empty($request->saved_items_id[0])){
            $saved=$request->saved_items_id[0];
            }
            else{
            $saved='';   
                  }
                     
        if($request->type[0] == 'Bar'){
            $item= Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('bar','1')->where('disabled','0')->get();
        }        
        elseif($request->type[0] == 'Kitchen'){
              $item=Menu::where('status','1')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get(); 
        }        
            
         
                return view('restaurant.orders.edit_modal', compact('item','name','qty','price','cost','tax','unit','rate','order','type','saved'));
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
          
            
                
        if($request->checked_type[0] == 'Bar'){
            $type='Drinks';
            $type2='Bar';
            
            $it=Items::where('id',$request->checked_item_name)->first();
                $a =  $it->name ;
        }        
        elseif($request->checked_type[0] == 'Kitchen'){
            $type='Food';
             $type2='Kitchen';
            
            $it=Menu::where('id',$request->checked_item_name)->first();

                $a =  $it->name ;
        } 
       
          $name=$request->checked_item_name[0];
          $qty=$request->checked_quantity[0];
          $price=str_replace(",","",$request->checked_price[0]);
          $cost=$request->checked_total_cost[0];
          $tax=$request->checked_total_tax[0];
          $order=$request->checked_no[0];
          $unit=$request->checked_unit[0];
          $rate=$request->checked_tax_rate[0];
          
          if(!empty($request->saved_items_id[0])){
            $saved=$request->saved_items_id[0];
            }
            else{
            $saved='';   
                  }
          
          if(!empty($request->modal_type) && $request->modal_type == 'edit'){
            $list .= '<td>'.$type.'</td>';
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$tax.'</td>';
             if(!empty($saved)){
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger rem" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '" value="'.$saved.'"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
                }
            else{
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            }
            
            $list1 .= '<input type="hidden" name="type[]" class="form-control item_type" id="type lst'.$order.'"  value="'.$type2.'" required />';
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="modal_type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            $list1 .= '<input type="hidden"  class="form-control item_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
            $list1 .= '<input type="hidden" class="form-control type_idlst'.$order.'" id="type_id"  value="'.$type2.'" required />';
            
            if(!empty($saved)){
            $list1 .= '<input type="hidden" name="saved_items_id[]" class="form-control item_saved'.$order.'" value="'.$saved.'"  required/>';
                }
          }
            else{
            $list .= '<tr class="trlst'.$order.'">';
             $list .= '<td>'.$type.'</td>';
            $list .= '<td>'.$a.'</td>';
            $list .= '<td>'.number_format($qty,2).'<div class=""> <span class="form-control-static errorslst'.$order.'" id="errors" style="text-align:center;color:red;"></span></div></td>';
            $list .= '<td>'.number_format($price,2).'</td>';
            $list .= '<td>'.$cost.'</td>';
            $list .= '<td>'.$tax.'</td>';
            $list .='<td><a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="' .$order.'"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove1" title="Delete" href="javascript:void(0)" data-button_id="' .$order. '"><i class="icon-trash" style="font-size:18px;"></i></a></td>';
            $list .= '</tr>';
                    
            $list1 .= '<div class="line_items" id="lst'.$order.'">';
            $list1 .= '<input type="hidden" name="type[]" class="form-control item_type" id="type lst'.$order.'"  value="'.$type2.'" required />';
            $list1 .= '<input type="hidden" name="item_name[]" class="form-control item_name" id="name lst'.$order.'"  value="'.$name.'" required />';
            $list1 .= '<input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty lst'.$order.'"  data-category_id="lst'.$order.'" value="'.$qty.'" required />';
            $list1 .= '<input type="hidden" name="price[]" class="form-control item_price" id="price lst'.$order.'" value="'.$price.'" required />';
            $list1 .= '<input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst'.$order.'" value="'.$rate.'" required />';
            $list1 .= '<input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst'.$order.'"  value="'.$cost.'" required />';
            $list1 .= '<input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst'.$order.'"  value="'.$tax.'" required />';
            $list1 .= '<input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst'.$order.'"  value="'.$unit.'"  />';
            $list1 .= '<input type="hidden" name="modal_type" class="form-control item_type" id="type lst'.$order.'"  value="edit"  />';
            $list1 .= '<input type="hidden" name="no[]" class="form-control item_type" id="no lst'.$order.'"  value="'.$order.'"  />';
            $list1 .= '<input type="hidden"  class="form-control item_idlst'.$order.'" id="item_id "  value="'.$name.'"  />';
            $list1 .= '<input type="hidden" class="form-control type_idlst'.$order.'" id="type_id"  value="'.$type2.'" required />';
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


  public function showType(Request $request)
    {
         if($request->id == 'Bar'){
       $item= Items::whereIn('type', [1,4])->where('added_by',auth()->user()->added_by)->where('bar','1')->where('disabled','0')->get();
         }

         else if($request->id == 'Kitchen'){

           $item=Menu::where('status','1')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get(); 
        
                 }
                                                                                          
               return response()->json($item);

}

 

 public function findPrice(Request $request)
    {
         if($request->type == 'Bar'){
       $price= Items::where('id',$request->id)->get(); 
         }

         else if($request->type == 'Kitchen'){

           $price=Menu::where('id',$request->id)->get(); 
        
                 }
                                                                                          
               return response()->json($price);

} 



public function findQuantity(Request $request)
    {
 
$item=$request->item;
$type=$request->type;
$location=$request->location;



 if($type == 'Bar'){
$item_info=Items::where('id', $item)->first();  
$location_info=Location::find($request->location);

 if ($item_info->quantity > 0) {

$due=PurchaseHistory::where('item_id',$item)->where('location',$location)->where('type', 'Purchases')->where('added_by',auth()->user()->added_by)->sum('quantity');
$return=PurchaseHistory::where('item_id',$item)->where('location',$location)->where('type', 'Debit Note')->where('added_by',auth()->user()->added_by)->sum('quantity');    
$dgood=StockMovementItem::where('item_id',$item)->where('destination_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');    

$sgood=StockMovementItem::where('item_id',$item)->where('source_store',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');
$issue=GoodIssueItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum(\DB::raw('quantity - returned'));
$sqty= OrderHistory::where('item_id', $item)->where('location',$location)->where('type', 'Sales')->where('item_type', 'Bar')->where('added_by',auth()->user()->added_by)->sum('quantity'); 
 $cn= OrderHistory::where('item_id', $item)->where('location',$location)->where('type', 'Credit Note')->where('item_type', 'Bar')->where('added_by',auth()->user()->added_by)->sum('quantity');
  $disposal=GoodDisposalItem::where('item_id',$item)->where('location',$location)->where('status',1)->where('added_by',auth()->user()->added_by)->sum('quantity');

$qty=($due-$return) * $item_info->bottle;
$inv=$sqty-$cn;


$b=($qty + ($dgood * $item_info->bottle)) - ( ($issue  * $item_info->bottle) + ($disposal  * $item_info->bottle) + ($sgood  * $item_info->bottle) + $inv );
$balance=floor($b);

 if ($balance > 0) {

if($request->id >  $balance){
$price="You have exceeded your Stock. Choose quantity between 1.00 and ".  number_format($balance,2) ;
}
else if($request->id <=  0){
$price="Choose quantity between 1.00 and ".  number_format($balance,2) ;
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

  else if($type == 'Kitchen'){

 if($request->id <=  0){
$price="You cannot chose quantity below zero"  ;
}
else{
$price='' ;
 }


}


                return response()->json($price);                      
 
    }


 public function findQuantity2(Request $request)
    {
 
$item=$request->item;
$type=$request->type;
$location=$request->location;



 if($type == 'Bar'){
$item_info=Items::where('id', $item)->first();  
$location_info=Location::find($request->location);
$date = today()->format('Y-m');

 if ($item_info->quantity > 0) {
     
     
$a=SerialList::where('brand_id',$item)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('crate_status',0)->whereNull('expire_date')->sum('due_quantity');  
 $b=SerialList::where('brand_id',$item)->where('location',$location)->where('added_by',auth()->user()->added_by)->where('crate_status',0)->whereNotNull('expire_date')->where('expire_date', '>=', $date)->sum('due_quantity'); 


 $balance=$a + $b;


 if ($balance > 0) {

if($request->id >  $balance){
$price="You have exceeded your Stock. Choose quantity between 1.00 and ".  number_format($balance,2) ;
}
else if($request->id <=  0){
$price="Choose quantity between 1.00 and ".  number_format($balance,2) ;
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

  else if($type == 'Kitchen'){

 if($request->id <=  0){
$price="You cannot chose quantity below zero"  ;
}
else{
$price='' ;
 }


}


                return response()->json($price);                      
 
    }







 
}
