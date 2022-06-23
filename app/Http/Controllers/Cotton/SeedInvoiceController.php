<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Currency;
use App\Models\Inventory;
use App\Models\Cotton\CottonPayment;
use App\Models\Cotton\InvoiceCottonHistory;
use App\Models\Cotton\InvoiceItemCotton;
use App\Models\Cotton\InvoiceCotton;
use App\Models\Cotton\Production;
use App\Models\Cotton\ProductionActivity;
use App\Models\Cotton\CottonClient;
use App\Models\Cotton\SeedList;
use App\Models\Cotton\SeedPayment;
use App\Models\Cotton\InvoiceSeedHistory;
use App\Models\Cotton\InvoiceItemSeed;
use App\Models\Cotton\InvoiceSeed;
use App\Models\JournalEntry;
use App\Models\Location;
use App\Models\Payment_methodes;
use App\Models\Purchase_items;
use App\Models\PurchaseInventory;
use App\Models\InventoryList;
use App\Models\User;
use PDF;

use Illuminate\Http\Request;

class SeedInvoiceController extends Controller
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
        $purchases=InvoiceSeed::all();
        $supplier=AccountCodes::where('account_group','LIKE','%Sundry Debtors%')->get();                     
        $name = SeedList::all();
        $location = Location::all();
        $type="";
       return view('cotton.manage_invoice_seed',compact('name','supplier','currency','purchases','location','type'));
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

       $data['reference_no']='1';
        $data['reference']=$request->reference;
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
         $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['status']='1';
        $data['good_receive']='1';
        $data['added_by']= auth()->user()->id;


        $purchase = InvoiceSeed::create($data);


       
        $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );


        
         $savedArr =$request->item_name ;        
        $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;
        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                     $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'invoice_id' =>$purchase->id);
                       
                    InvoiceItemSeed::create($items);  ;
    
    
                }
            }
            $cost['reference_no']= "INV_SEED-".$purchase->id."-".$data['purchase_date'];
             $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            InvoiceSeed::where('id',$purchase->id)->update($cost);
        }    


          if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
             
                        $lists = array(
                           'quantity' =>   $qtyArr[$i],
                             'items_id' => $savedArr[$i],
                               'added_by' => auth()->user()->id,
                               'supplier_id' =>   $data['supplier_id'],
                             'purchase_date' =>  $data['purchase_date'],
                            'invoice_id' =>$purchase->id);
                           
         
                        InvoiceSeedHistory::create($lists);   
          
                    
                    }
                }
            
            }    

                   if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
             
                        $activity = array(
                           'sales_quantity' =>   $qtyArr[$i],
                             'type' => $savedArr[$i],
                               'added_by' => auth()->user()->id,
                            'lot_no' =>$purchase->id);
                           
         
                       ProductionActivity::create($activity);   
          
                    
                    }
                }
            
            }    


                  $supp=AccountCodes::find($purchase->supplier_id);
                   $invoice=  InvoiceSeed::where('id',$purchase->id)->first();

$invoice_items=  InvoiceItemSeed::where('invoice_id',$purchase->id)->get(); 
              foreach($invoice_items as $item){
             if($item->item_name == '1'){
             $cr= AccountCodes::where('account_name','Cotton Seed Sales')->first();

               $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'seed';
          $journal->name = 'Cotton Seed Sales';
        $journal->credit = $item->total_cost *  $invoice->exchange_rate;
          $journal->income_id= $purchase->id;
            $journal->client_id= $purchase->supplier_id;
      $journal->added_by=auth()->user()->id;
     $journal->currency_code =  $purchase->exchange_code;
        $journal->exchange_rate= $purchase->exchange_rate;
             $journal->notes="Cotton Seed Sales for Invoice No " .$purchase->reference ." to Debtor ". $supp->account_name ;
          $journal->save();
  
     
        if($item->total_tax > 0){
         $tax= AccountCodes::where('account_name','VAT OUT')->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
           $journal->transaction_type = 'seed';
        $journal->name = 'Cotton Seed Sales';
         $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->credit = $item->total_tax * $invoice->exchange_rate ;
          $journal->income_id= $purchase->id;
      $journal->client_id= $purchase->supplier_id;
      $journal->added_by=auth()->user()->id;
     $journal->currency_code =  $purchase->exchange_code;
        $journal->exchange_rate= $purchase->exchange_rate;
            $journal->notes="Cotton Seed Sales Tax for Invoice No " .$purchase->reference ." to Debtor ". $supp->account_name ;
          $journal->save();
        }
        

          $journal = new JournalEntry();
          $journal->account_id = $purchase->supplier_id;
          $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'seed';
              $journal->name = 'Cotton Seed Sales';
             $journal->debit = ( $item->total_cost  +  $item->total_tax) *   $invoice->exchange_rate;
          $journal->income_id= $purchase->id;
        $journal->client_id= $purchase->supplier_id;
      $journal->added_by=auth()->user()->id;
     $journal->currency_code =  $purchase->exchange_code;
        $journal->exchange_rate= $purchase->exchange_rate;
              $journal->notes="Cotton Seed Sales Receivables  for Invoice No " .$purchase->reference ." to Debtor ". $supp->account_name ;
          $journal->save();
           }



             else{
              $cr= AccountCodes::where('account_name','Cotton Trash Sales')->first();

               $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'trash';
          $journal->name = 'Cotton Trash Sales';
        $journal->credit = $item->total_cost *  $invoice->exchange_rate;
          $journal->income_id= $purchase->id;
            $journal->client_id= $purchase->supplier_id;
      $journal->added_by=auth()->user()->id;
     $journal->currency_code =  $purchase->exchange_code;
        $journal->exchange_rate= $purchase->exchange_rate;
             $journal->notes="Cotton Trash Sales for Invoice No " .$purchase->reference ." to Debtor ". $supp->account_name ;
          $journal->save();
  
     
        if($item->total_tax > 0){
         $tax= AccountCodes::where('account_name','VAT OUT')->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
           $journal->transaction_type = 'trash';
        $journal->name = 'Cotton Trash Sales';
         $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->credit = $item->total_tax * $invoice->exchange_rate ;
          $journal->income_id= $purchase->id;
      $journal->client_id= $purchase->supplier_id;
      $journal->added_by=auth()->user()->id;
     $journal->currency_code =  $purchase->exchange_code;
        $journal->exchange_rate= $purchase->exchange_rate;
            $journal->notes="Cotton Trash Sales Tax for Invoice No " .$purchase->reference ." to Debtor ". $supp->account_name ;
          $journal->save();
        }
        

          $journal = new JournalEntry();
          $journal->account_id = $purchase->supplier_id;
          $date = explode('-',$purchase->purchase_date);
          $journal->date =   $purchase->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'trash';
              $journal->name = 'Cotton Trash Sales';
             $journal->debit = ( $item->total_cost  +  $item->total_tax) *   $invoice->exchange_rate;
          $journal->income_id= $purchase->id;
        $journal->client_id= $purchase->supplier_id;
      $journal->added_by=auth()->user()->id;
     $journal->currency_code =  $purchase->exchange_code;
        $journal->exchange_rate= $purchase->exchange_rate;
              $journal->notes="Cotton Trash Sales Receivables  for Invoice No " .$purchase->reference ." to Debtor ". $supp->account_name ;
          $journal->save();
            }   
 
   }        
        
       return redirect(route('seed_sales.index'))->with(['success'=>'Invoice Created Successfully']);;
        
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
        $purchases = InvoiceSeed::find($id);
        $purchase_items=InvoiceItemSeed::where('invoice_id',$id)->get();
        $payments=SeedPayment::where('invoice_id',$id)->get();
        
        return view('cotton.invoice_seed_details',compact('purchases','purchase_items','payments'));
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
        $supplier=Supplier::all();
        $name = Inventory::all();
        $location = Location::all();
        $data=PurchaseInventory::find($id);
        $items=PurchaseItemInventory::where('purchase_id',$id)->get();
        $type="";
       return view('inventory.manage_purchase_inv',compact('name','supplier','currency','location','data','id','items','type'));
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
            $purchase = PurchaseInventory::find($id);
            $data['supplier_id']=$request->supplier_id;
            $data['purchase_date']=$request->purchase_date;
            $data['due_date']=$request->due_date;
            $data['location']=$request->location;
            $data['exchange_code']=$request->exchange_code;
            $data['exchange_rate']=$request->exchange_rate;
            $data['purchase_amount']='1';
            $data['due_amount']='1';
            $data['purchase_tax']='1';
            $data['good_receive']='1';
            $data['added_by']= auth()->user()->id;
    
            $purchase->update($data);
            
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
            
            $cost['purchase_amount'] = 0;
            $cost['purchase_tax'] = 0;
    
            if (!empty($remArr)) {
                for($i = 0; $i < count($remArr); $i++){
                   if(!empty($remArr[$i])){        
                    PurchaseItemInventory::where('id',$remArr[$i])->delete();        
                       }
                   }
               }
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
                        $cost['purchase_amount'] +=$costArr[$i];
                        $cost['purchase_tax'] +=$taxArr[$i];
    
                        $items = array(
                            'item_name' => $nameArr[$i],
                            'quantity' =>   $qtyArr[$i],
                            'tax_rate' =>  $rateArr [$i],
                             'unit' => $unitArr[$i],
                               'price' =>  $priceArr[$i],
                            'total_cost' =>  $costArr[$i],
                            'total_tax' =>   $taxArr[$i],
                             'items_id' => $savedArr[$i],
                               'order_no' => $i,
                               'added_by' => auth()->user()->id,
                            'purchase_id' =>$id);
                           
                            if(!empty($expArr[$i])){
                                PurchaseItemInventory::where('id',$expArr[$i])->update($items);  
          
          }
          else{
            PurchaseItemInventory::create($items);   
          }
                      
                  if(!empty($qtyArr[$i])){
            for($x = 1; $x <= $qtyArr[$i]; $x++){    
                $name=Inventory::where('id', $savedArr[$i])->first();
                $dt=date('Y',strtotime($data['purchase_date']));
                    $lists = array(
                        'serial_no' => $name->name."_" .$id."_".$x."_" .$dt,                      
                         'brand_id' => $savedArr[$i],
                           'added_by' => auth()->user()->id,
                           'purchase_id' =>   $id,
                         'purchase_date' =>  $data['purchase_date'],
                           'location' => $data['location'],
                           'status' => '0');
                       
     
                    InventoryList::create($lists);   
      
                }
            }
         
  
                    }
                }
                $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
                PurchaseInventory::where('id',$id)->update($cost);
            }    
    
            
    
            if(!empty($nameArr)){
                for($i = 0; $i < count($nameArr); $i++){
                    if(!empty($nameArr[$i])){
    
                        $items = array(
                            'quantity' =>   $qtyArr[$i],
                             'items_id' => $savedArr[$i],
                               'added_by' => auth()->user()->id,
                               'supplier_id' =>   $data['supplier_id'],
                             'purchase_date' =>  $data['purchase_date'],
                               'location' => $data['location'],
                            'purchase_id' =>$id);
                           
         
                         InventoryHistory::create($items);   
          
                        $inv=Inventory::where('id',$nameArr[$i])->first();
                        $q=$inv->quantity + $qtyArr[$i];
                        Inventory::where('id',$nameArr[$i])->update(['quantity' => $q]);
                    }
                }
            
            }    
    
    
            $inv = PurchaseInventory::find($id);
            $supp=Supplier::find($inv->supplier_id);
            $cr= AccountCodes::where('account_name','Inventory')->first();
            $journal = new JournalEntry();
          $journal->account_id = $cr->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
         $journal->transaction_type = 'inventory';
          $journal->name = 'Inventory Purchase';
          $journal->debit = $inv->purchase_amount *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->id;
             $journal->notes= "Inventory Purchase with reference no " .$inv->reference_no ." by Supplier ". $supp->name ;
          $journal->save();
        
        if($inv->purchase_tax > 0){
         $tax= AccountCodes::where('account_name','VAT IN')->first();
            $journal = new JournalEntry();
          $journal->account_id = $tax->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'inventory';
          $journal->name = 'Inventory Purchase';
          $journal->debit = $inv->purchase_tax *  $inv->exchange_rate;
          $journal->income_id= $inv->id;
           $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
          $journal->added_by=auth()->user()->id;
             $journal->notes= "Inventory Purchase Tax with reference no " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
        }
        
          $codes= AccountCodes::where('account_name','Payables')->first();
          $journal = new JournalEntry();
          $journal->account_id = $codes->id;
          $date = explode('-',$inv->purchase_date);
          $journal->date =   $inv->purchase_date ;
          $journal->year = $date[0];
          $journal->month = $date[1];
          $journal->transaction_type = 'inventory';
          $journal->name = 'Inventory Purchase';
          $journal->income_id= $inv->id;
          $journal->credit =$inv->due_amount *  $inv->exchange_rate;
          $journal->currency_code =  $inv->exchange_code;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->id;
             $journal->notes= "Credit for Inventory Purchase with reference no " .$inv->reference_no ." by Supplier ".  $supp->name ;
          $journal->save();
    
    
            return redirect(route('purchase_inventory.show',$id));
    

        }

        else{
        $purchase = PurchaseInventory::find($id);
        $data['supplier_id']=$request->supplier_id;
        $data['purchase_date']=$request->purchase_date;
        $data['due_date']=$request->due_date;
        $data['location']=$request->location;
        $data['exchange_code']=$request->exchange_code;
        $data['exchange_rate']=$request->exchange_rate;
        $data['purchase_amount']='1';
        $data['due_amount']='1';
        $data['purchase_tax']='1';
        $data['added_by']= auth()->user()->id;

        $purchase->update($data);
        
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
        
        $cost['purchase_amount'] = 0;
        $cost['purchase_tax'] = 0;

        if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                PurchaseItemInventory::where('id',$remArr[$i])->delete();        
                   }
               }
           }

        if(!empty($nameArr)){
            for($i = 0; $i < count($nameArr); $i++){
                if(!empty($nameArr[$i])){
                    $cost['purchase_amount'] +=$costArr[$i];
                    $cost['purchase_tax'] +=$taxArr[$i];

                    $items = array(
                        'item_name' => $nameArr[$i],
                        'quantity' =>   $qtyArr[$i],
                        'tax_rate' =>  $rateArr [$i],
                         'unit' => $unitArr[$i],
                           'price' =>  $priceArr[$i],
                        'total_cost' =>  $costArr[$i],
                        'total_tax' =>   $taxArr[$i],
                         'items_id' => $savedArr[$i],
                           'order_no' => $i,
                           'added_by' => auth()->user()->id,
                        'purchase_id' =>$id);
                       
                        if(!empty($expArr[$i])){
                            PurchaseItemInventory::where('id',$expArr[$i])->update($items);  
      
      }
      else{
        PurchaseItemInventory::create($items);   
      }
                    
                }
            }
            $cost['due_amount'] =  $cost['purchase_amount'] + $cost['purchase_tax'];
            PurchaseInventory::where('id',$id)->update($cost);
        }    

        

        return redirect(route('purchase_inventory.show',$id));

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
        PurchaseItemInventory::where('purchase_id', $id)->delete();
        InventoryPayment::where('purchase_id', $id)->delete();
        InventoryHistory::where('purchase_id', $id)->delete();
        $purchases = PurchaseInventory::find($id);
        $purchases->delete();
        return redirect(route('purchase_inventory.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= SeedList::where('id',$request->id)->get();
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
               $name = Inventory::all();
     
                    return view('inventory.addmaintainance',compact('id','name'));
      }
            elseif($type == 'service'){
                    return view('inventory.addreference',compact('id'));
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
        $purchase = PurchaseInventory::find($id);
        $data['status'] = 1;
        $purchase->update($data);
        return redirect(route('purchase_inventory.index'))->with(['success'=>'Approved Successfully']);
    }

    public function cancel($id)
    {
        //
        $purchase = PurchaseInventory::find($id);
        $data['status'] = 4;
        $purchase->update($data);
        return redirect(route('purchase_inventory.index'))->with(['success'=>'Cancelled Successfully']);
    }

   

    public function receive($id)
    {
        //
        $currency= Currency::all();
        $supplier=Supplier::all();
        $name = Inventory::all();
        $location = Location::all();
        $data=PurchaseInventory::find($id);
        $items=PurchaseItemInventory::where('purchase_id',$id)->get();
        $type="receive";
       return view('inventory.manage_purchase_inv',compact('name','supplier','currency','location','data','id','items','type'));
    }

  public function inventory_list()
    {
        //
        $tyre= InventoryList ::all();
       return view('inventory.list',compact('tyre'));
    }

    public function make_payment($id)
    {
     
        $invoice = InvoiceSeed::find($id);
        $payment_method = Payment_methodes::all();
        $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
        return view('cotton.seed_payment',compact('invoice','payment_method','bank_accounts'));
    }
    
    public function seed_pdfview(Request $request)
    {
        //
 
        $purchases = InvoiceSeed::find($request->id);
        $purchase_items=InvoiceItemSeed::where('invoice_id',$request->id)->get();

        view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

        if($request->has('download')){
        $pdf = PDF::loadView('cotton.invoice_seed_pdf')->setPaper('a4', 'landscape');
         return $pdf->download('SEED SALES INVOICE REF NO # ' .  $purchases->reference . ".pdf");
        }
        return view('sales_pdfview');
    }
}
