<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Inventory\Location;
use App\Models\InventoryHistory;
use App\Models\POS\InvoiceHistory;
use App\Models\POS\InvoicePayments;
use App\Models\POS\Items;
use App\Models\JournalEntry;
use App\Models\Payment_methodes;
//use App\Models\invoice_items;
use App\Models\InventoryList;
use App\Models\POS\Client;
use App\Models\ServiceType;
use App\Models\POS\Invoice;
use App\Models\POS\InvoiceItems;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
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
        $invoices=Invoice::all()->where('invoice_status',0)->where('added_by',auth()->user()->added_by);
       $client=Client::where('user_id',auth()->user()->added_by)->get(); 
        $name =Items::where('added_by',auth()->user()->added_by)->get(); 
        $location = Location::all();
        $type="";
       return view('pos.sales.profoma_invoice',compact('name','client','currency','invoices','location','type'));
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
        $data['reference_no']= "S0".$pro;
        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        $data['due_date']=$request->due_date;
     
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
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
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );

        
        $savedArr =$request->item_name ;
        
        $cost['invoice_amount'] = 0;
        $cost['invoice_tax'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['invoice_amount'] +=$costArr[$i];
                    $cost['invoice_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
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
                        'invoice_id' =>$invoice->id);
                       
                        InvoiceItems::create($items);  ;
    
    
                }
            }
           // $cost['reference_no']= "SALES-".$invoice->id."-".$data['invoice_date'];
            $cost['due_amount'] =  $cost['invoice_amount'] + $cost['invoice_tax'];
            InvoiceItems::where('id',$invoice->id)->update($cost);
        }    

        Invoice::find($invoice->id)->update($cost);

        
        return redirect(route('profoma_invoice.show',$invoice->id));
        
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
        
        return view('pos.sales.profoma_invoice_details',compact('invoices','invoice_items','payments'));
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
        $name =Items::where('added_by',auth()->user()->added_by)->get(); ;
        $location = Location::all();
        $data=Invoice::find($id);
        $items=InvoiceItems::where('invoice_id',$id)->get();
        $type="";
       return view('pos.sales.profoma_invoice',compact('name','client','currency','location','data','id','items','type'));
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

        if($request->type == 'receive'){
            $invoice = Invoice::find($id);
            $data['client_id']=$request->client_id;
            $data['invoice_date']=$request->invoice_date;
            $data['due_date']=$request->due_date;
            $data['location']=$request->location;
            $data['exchange_code']=$request->exchange_code;
            $data['exchange_rate']=$request->exchange_rate;
            //$data['reference_no']="SALES-".$id."-".$data['invoice_date'];
            $data['invoice_amount']='1';
            $data['due_amount']='1';
            $data['invoice_tax']='1';
            $data['good_receive']='1';
            $data['added_by']= auth()->user()->added_by;
    
            $invoice->update($data);
            
            $amountArr = str_replace(",","",$request->amount);
            $totalArr =  str_replace(",","",$request->tax);
    
            $nameArr =$request->item_name ;
            $qtyArr = $request->quantity  ;
            $priceArr = $request->price;
            $rateArr = $request->tax_rate ;
            $unitArr = $request->unit  ;
            $costArr = str_replace(",","",$request->total_cost)  ;
            $taxArr =  str_replace(",","",$request->total_tax );
            $remArr = $request->removed_id ;
            $expArr = $request->saved_items_id ;
            $savedArr =$request->item_name ;
            
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
                Invoice::where('id',$id)->update($cost);
            }    
    
            
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        $lists= array(
                            'quantity' =>   $qtyArr[$i],
                             'item_id' => $savedArr[$i],
                               'added_by' => auth()->user()->added_by,
                               'client_id' =>   $data['client_id'],
                             'invoice_date' =>  $data['invoice_date'],
                            'type' =>   'Sales',
                            'invoice_id' =>$id);
                           
         
                       InvoiceHistory::create($lists);   
          
                        $inv=Items::where('id',$nameArr[$i])->first();
                        $q=$inv->quantity - $qtyArr[$i];
                        Items::where('id',$nameArr[$i])->update(['quantity' => $q]);
                    }
                }
            
            }    
    
    
            $inv = Invoice::find($id);
            $supp=Client::find($inv->client_id);
           $cr= AccountCodes::where('account_name','Sales')->first();
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
         $tax= AccountCodes::where('account_name','VAT OUT')->first();
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
        
          $codes=AccountCodes::where('account_group','Receivables')->first();
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
          $journal->debit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
            $journal->notes= "Receivables for Sales Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();
    
         $stock= AccountCodes::where('account_name','Inventory')->first();
            $journal = new JournalEntry();
          $journal->account_id =  $stock->id;
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
             $journal->notes= "Reduce Stock  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

            $cos= AccountCodes::where('account_name','Cost of Goods Sold')->first();
            $journal = new JournalEntry();
          $journal->account_id =  $cos->id;
          $date = explode('-',$inv->invoice_date);
          $journal->date =   $inv->invoice_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'pos_invoice';
          $journal->name = 'Invoice';
          $journal->debit = $inv->invoice_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
         $journal->client_id= $inv->client_id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->added_by;
             $journal->notes= "Cost of Goods Sold  for Sales  Invoice No " .$inv->reference_no ." to Client ". $supp->name ;
          $journal->save();

    
    
            return redirect(route('invoice.show',$id));
    

        }

        else{
        $invoice = Invoice::find($id);
        $data['client_id']=$request->client_id;
        $data['invoice_date']=$request->invoice_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['invoice_amount']='1';
        $data['due_amount']='1';
        $data['invoice_tax']='1';
        $data['added_by']= auth()->user()->added_by;

        $invoice->update($data);
        
        $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
        $remArr = $request->removed_id ;
        $expArr = $request->saved_items_id ;
        $savedArr =$request->item_name ;
        
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
            Invoice::where('id',$id)->update($cost);
        }    

        

        return redirect(route('profoma_invoice.show',$id));

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

        Toastr::success('Deleted Successfully','Success');
        return redirect(route('profoma_invoice.index'));
    }

    public function findPrice(Request $request)
    {
               $price= Items::where('id',$request->id)->get();
                return response()->json($price);                      

    }
   public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;
                  if($type == 'reference'){
                    return view('inventory.addreference',compact('id'));
      }
                elseif($type == 'maintainance'){
                     $name = ServiceType::all();     
                    return view('inventory.addmaintainance',compact('id','name','type'));
      }
            elseif($type == 'service'){
                    $name = ServiceType::all();   
                    return view('inventory.addmaintainance',compact('id','name','type'));
      }
        elseif($type == 'mechanical_maintainance'){
                    $item =  MechanicalItem::where('module_id',$id)->where('module','maintainance')->get(); 
                   $notes =   MechanicalRecommedation::where('module_id',$id)->where('module','maintainance')->get();   
                    return view('inventory.viewreport',compact('id','item','type','notes'));
      }
   elseif($type == 'mechanical_service'){
                    $item =  MechanicalItem::where('module_id',$id)->where('module','service')->get(); 
                   $notes =   MechanicalRecommedation::where('module_id',$id)->where('module','service')->get();   
                    return view('inventory.viewreport',compact('id','item','type','notes'));
      }
     elseif($type == 'requisition_maintainance'){
                    $item =  Inventory::all(); 
                   $module =   'Maintainance';   
                    return view('inventory.addrequistion',compact('id','item','module','id'));
      }
  elseif($type == 'requisition_service'){
                    $item =  Inventory::all(); 
                   $module =   'Service';   
                    return view('inventory.addrequistion',compact('id','item','module','id'));
      }
                 }

           public function save_reference (Request $request){
                     //
                     $inv=   InventoryList::find($request->id);
                     $data['reference']=$request->reference;
                     $data['assign_reference']='1';
                     $inv->update($data);

                     return redirect(route('inventory.list'))->with(['success'=>'Inventory Reference Assigned Successfully']);
                 }


    public function approve($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 1;
        $invoice->update($data);
        Toastr::success('Approved Successfully','Success');
        return redirect(route('invoice.index'));
    }
    public function convert_to_invoice($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['invoice_status'] = 1;
        $invoice->update($data);
        Toastr::success('Converted Successfully','Success');
        return redirect(route('invoice.index'));
    }

    public function cancel($id)
    {
        //
        $invoice = Invoice::find($id);
        $data['status'] = 4;
        $invoice->update($data);
        Toastr::success('Cancelled Successfully','Success');
        return redirect(route('invoice.index'));
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
          $client=Client::where('user_id',auth()->user()->added_by)->get(); 
        $name =Items::where('added_by',auth()->user()->added_by)->get();   
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
        $pdf = PDF::loadView('pos.sales.profoma_invoice_pdf')->setPaper('a4', 'potrait');
         return $pdf->download('PROFORMA INV NO # ' .  $invoices->reference_no . ".pdf");
        }
       return view('inv_pdfview');
    }
}
