<?php

namespace App\Http\Controllers\Pharmacy\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Region;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\Pharmacy\Client;
use App\Models\Pharmacy\InventoryList;
use App\Models\Pharmacy\InvoiceSerialPayments;
use App\Models\Pharmacy\InvoiceSerialHistory;
use App\Models\Pharmacy\InvoiceSerial;
use App\Models\Pharmacy\InvoiceSerialItems;
use App\Models\Pharmacy\InvoicePayments;
use App\Models\Pharmacy\InvoiceHistory;
use App\Models\Pharmacy\Invoice;
use App\Models\Pharmacy\InvoiceItems;
use App\Models\Pharmacy\PurchaseHistory;
use App\Models\Pharmacy\PurchaseSerialList;

use App\Models\User;
use PDF;


use Illuminate\Http\Request;

class ProfomaInvoiceController extends Controller
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
       $invoices=Invoice::where('invoice_status',0)->where('added_by',auth()->user()->added_by)->get();
        $client=Client::where('user_id',auth()->user()->added_by)->get(); 
        $name =Items::where('user_id',auth()->user()->added_by)->get(); 
      $s_name =PurchaseSerialList::where('status',0)->where('added_by',auth()->user()->added_by)->get();
       //$bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get(); 
      $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get(); 
     $location =Region::all();
         $edit="";
        $item_type="";
       return view('pharmacy.pos.sales.profoma_invoice',compact('name','client','currency','invoices','item_type','edit','s_name','bank_accounts','location'));
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
          $count=Invoice::count();
        $pro=$count+1;
       $data['reference_no']= "BSPH0".$pro;
        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['notes']=$request->notes;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['status']='0';
        $data['good_receive']='0';
        $data['invoice_status']='0';
        $data['added_by']= auth()->user()->added_by;

        $invoice = Invoice::create($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $typeArr =$request->type ;
        $categoryArr =$request->category ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $shipArr =  str_replace(",","",$request->shipping_cost);
        
        $savedArr =$request->item_name ;
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
         $cost['shipping_cost']=0;

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];
                     $cost['shipping_cost'] =$shipArr[0];

                    $d=Items::where('id',$typeArr[$i])->first();
                     if($categoryArr[$i] == 'Batch'){
                      $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
                      $batch=$bt->batch_number;
                     $expire=$bt->expire_date;
                    $serial='';
                    
                       }
                        else{
                       $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
                      $batch='';
                     $expire='';
                       $serial= $st->serial_no;
                       }
                    $items = array(
                       'type' => $typeArr[$i],
                      'category' => $categoryArr[$i],
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                         'due_quantity' =>   $qtyArr[$i],
                        'batch_number' =>  $batch,                        
                        'expire_date' => $expire,
                         'serial_no' =>  $serial,
                        'tax_rate' =>  $rateArr [$i],
                         'unit' =>$d->unit,
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'purchase_history'=>$nameArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->added_by,
                        'invoice_id' =>$invoice->id);
                       
                        InvoiceItems::create($items);  ;
    
    
                }
            }
           // $cost['reference_no']= "SALES-".$invoice->id."-".$data['invoice_date'];
              $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'] +$cost['shipping_cost'] ;
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }    

        Invoice::find($invoice->id)->update($cost);

        
        return redirect(route('pharmacy_proforma_invoice.show',$invoice->id));
        
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
        
        return view('pharmacy.pos.sales.profoma_invoice_details',compact('invoices','invoice_items','payments'));
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
         $client=Client::where('user_id',auth()->user()->added_by)->get(); 
        $name =Items::where('user_id',auth()->user()->added_by)->get();        
      $s_name =PurchaseSerialList::where('status',0)->where('added_by',auth()->user()->added_by)->get();  
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
         //$bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get(); 
      $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get();  
      $location =Region::all();
         $edit="";
        $item_type="";

       return view('pharmacy.pos.sales.profoma_invoice',compact('name','client','currency','data','id','items','item_type','edit','s_name','bank_accounts','location'));
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

       if($request->item_type == 'receive'){


            $invoice = Invoice::find($id);
            $data['client_id']=$request->client_id;
            $data['invoice_date']=$request->invoice_date;
            $data['due_date']=$request->due_date;
             $data['location']=$request->location;
            $data['exchange_code']=$request->exchange_code;
            $data['exchange_rate']=$request->exchange_rate;
            $data['notes']=$request->notes;
            $data['invoice_amount']='1';
            $data['due_amount']='1';
            $data['invoice_tax']='1';
          $data['status']='0';
        $data['good_receive']='0';
        $data['invoice_status']='0';
            $data['added_by']= auth()->user()->added_by;
    
     

            $invoice->update($data);
            
            $amountArr = str_replace(",","",$request->amount);
            $totalArr =  str_replace(",","",$request->tax);
           
            $nameArr =$request->item_name ;
            $typeArr =$request->type ;
        $categoryArr =$request->category ;
            $qtyArr = $request->quantity  ;
            $priceArr = $request->price;
            $rateArr = $request->tax_rate ;
            $unitArr = $request->unit  ;
            $costArr = str_replace(",","",$request->total_cost)  ;
            $taxArr =  str_replace(",","",$request->total_tax );
        $shipArr =  str_replace(",","",$request->shipping_cost);
            $remArr = $request->removed_id ;
            $expArr = $request->saved_items_id ;
            $savedArr =$request->item_name ;
            
            $cost['invoice_amount'] = 0;
            $cost['invoice_tax'] = 0;
               $cost['shipping_cost']=0;

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
                          $cost['shipping_cost'] =$shipArr[0];

                             
                    $d=Items::where('id',$typeArr[$i])->first();
                     if($categoryArr[$i] == 'Batch'){
                      $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
                      $batch=$bt->batch_number;
                     $expire=$bt->expire_date;
                    $serial='';
                    
                       }
                        else{
                       $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
                      $batch='';
                     $expire='';
                       $serial= $st->serial_no;
                       }

                        
                        $items = array(
                            'item_name' => $nameArr[$i],
                            'quantity' =>   $qtyArr[$i],
                            'due_quantity' =>   $qtyArr[$i],
                            'batch_number' =>  $batch,                        
                        'expire_date' => $expire,
                         'serial_no' =>  $serial,
                        'tax_rate' =>  $rateArr [$i],
                         'unit' =>$d->unit,
                               'price' =>  $priceArr[$i],
                            'total_cost' =>  $costArr[$i],
                            'total_tax' =>   $taxArr[$i],
                             'items_id' => $savedArr[$i],
                               'purchase_history'=>$nameArr[$i],
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
                $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'] +$cost['shipping_cost'] ;
                Invoice::where('id',$id)->update($cost);
            }    
    
            
            return redirect(route('pharmacy_proforma_invoice.show',$id));
    

        }

        else{



        $invoice = Invoice::find($id);
        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        $data['due_date']=$request->due_date;
            $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
      $data['notes']=$request->notes;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['status']='0';
        $data['good_receive']='0';
        $data['invoice_status']='0';
        $data['added_by']= auth()->user()->added_by;



        $invoice->update($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
      $typeArr =$request->type ;
        $categoryArr =$request->category ;
        $qtyArr = $request->quantity  ;
        //$batchArr = $request->batch_number;
        //$expireArr = $request->expire_date;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
       $shipArr =  str_replace(",","",$request->shipping_cost);
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
           $cost['shipping_cost']=0;

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
                      $cost['shipping_cost'] =$shipArr[0];

                  $d=Items::where('id',$typeArr[$i])->first();
                     if($categoryArr[$i] == 'Batch'){
                      $bt=  PurchaseHistory::where('id',$nameArr[$i])->first();
                      $batch=$bt->batch_number;
                     $expire=$bt->expire_date;
                    $serial='';
                    
                       }
                        else{
                       $st=  PurchaseSerialList::where('id',$nameArr[$i])->first();
                      $batch='';
                     $expire='';
                       $serial= $st->serial_no;
                       }

                    $items = array(
                      'type' => $typeArr[$i],
                      'category' => $categoryArr[$i],
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                         'due_quantity' =>   $qtyArr[$i],
                        'batch_number' =>  $batch,                        
                        'expire_date' => $expire,
                         'serial_no' =>  $serial,
                        'tax_rate' =>  $rateArr [$i],
                         'unit' =>$d->unit,
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                          'purchase_history'=>$nameArr[$i],
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
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'] +$cost['shipping_cost'] ;
            Invoice::where('id',$id)->update($cost);
        }    

        

        return redirect(route('pharmacy_proforma_invoice.show',$id));

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
        InvoiceItems::where('invoice_id', $id)->delete();
        InvoicePayments::where('invoice_id', $id)->delete();
       
        $invoices = Invoice::find($id);
        $invoices->delete();
        return redirect(route('profoma_invoice.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Inventory::where('id',$request->id)->get();
                return response()->json($price);                      

    }
   

    public function approve($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 1;
        $invoice->update($data);
        return redirect(route('invoice.index'))->with(['success'=>'Approved Successfully']);
    }
    public function convert_to_invoice($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['invoice_status'] = 1;
        $invoice->update($data);
        return redirect(route('pharmacy_invoice.index'))->with(['success'=>'Converted  Successfully']);
    }

    public function cancel($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);
        return redirect(route('invoice.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $client=Client::all();
        $name = Inventory::all();
        $location = Location::all();
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
        $type="receive";
       return view('pos.invoices.index',compact('name','client','currency','location','data','id','items','type'));
    }

  public function inventory_list()
    {
        //
        $tyre= InventoryList ::all();
       return view('inventory.list',compact('tyre'));
    }
    public function make_payment($id)
    {
        //
        $invoice = Invoice::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('pos.invoices.invoice_payments',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function invoice_pdfview(Request $request)
    {
        //
        $invoices = Invoice::find($request->id);
        $invoice_items=InvoiceItems::where('invoice_id',$request->id)->get();

        view()->share(['invoices'=>$invoices,'invoice_items'=> $invoice_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('pharmacy.pos.sales.profoma_invoice_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('PROFORMA INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('inv_pdfview');
    }
}
