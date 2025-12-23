<?php

namespace App\Http\Controllers\CF_Pacel;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Pacel\Pacel;
use App\Models\Pacel\PacelItem;
use App\Models\Pacel\PacelList;
use App\Models\Pacel\PacelPayment;
use App\Models\Pacel\PacelInvoice;
use App\Models\Pacel\PacelInvoiceItem;
use App\Models\Payment_methodes;
use App\Models\Route;
use App\Models\Client;
use Illuminate\Http\Request;
use PDF;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\orders\OrderMovement;
use App\Models\Region;
use App\Models\CargoCollection;
use App\Models\User;

class PacelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pacel = Pacel::where('added_by', auth()->user()->added_by)->where('good_receive','0')->where('status','!=','400')->orwhere('status','7')->orwhere('status','0')->orderBy('date', 'desc')->get();

        $route = Route::where('added_by',auth()->user()->added_by)->get(); 
        $users = Client::where('user_id', auth()->user()->added_by)->get();
          $name = PacelList::where('added_by', auth()->user()->added_by)->get();
          $currency = Currency::all();
        return view('pacel.quotation',compact('pacel','route','users','name','currency'));
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
      
        $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
  

  $pacel=Pacel::create([
     'pacel_name' => $request->pacel_name ,
   'pacel_number' => '12AB' ,
   'date' => $request->date ,
  'due_date' => $request->due_date ,
     'owner_id' => $request->owner_id ,
       'cf_id' => $request->cf_id ,
     'weight' => $request->weight  ,
     'receiver_name' => $request->receiver_name ,
     'docs' => $request->docs  ,
     'non_docs' => $request->non_docs  ,
     'bags' => $request->bags ,
     'mobile' => $request->mobile ,
     'discount' => '0'  ,
     'status' => '0'  ,
     'good_receive' => '0'  ,
     'currency_code' => $request->currency_code,
     'exchange_rate' => $request->exchange_rate,
     'instructions' => $request->instructions  ,
     'added_by'=>auth()->user()->added_by,
]);


    $number = "PCL-".$pacel->id;
       $confirmation_number = "PCL-".$random.$pacel->id;
  $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);

  $nameArr =$request->item_name ;
 $qtyArr = $request->quantity  ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
 $chargeArr =$request->charge;
 $distanceArr = $request->distance  ;
 $costArr = str_replace(",","",$request->total_cost)  ;
 $taxArr =  str_replace(",","",$request->total_tax );
  $savedArr =$request->items_id ;

  if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'amount' =>  $amountArr[$i],
                    'due_amount' =>  $amountArr[$i] ,
                     'pacel_number' => $number , 
                      'confirmation_number' =>  $confirmation_number , 
                    'tax' =>   $totalArr[$i]);

                      Pacel::where('id',$pacel->id)->update($t);  


            }
        }
    }    


          
    if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
              if($chargeArr[$i]=='1'){
                      $type[$i]='Flat';
                        }
                     else if($chargeArr[$i]== $distanceArr[$i]){
                    $type[$i]='Distance';
                        }
                     else{
                      $type[$i]='Rate';
                        }
                $items = array(
                    'item_name' => $nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr [$i],
                     'charge_type' =>  $type[$i],
                    'distance' => $distanceArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                     'items_id' => $savedArr[$i],
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$pacel->id);

                 PacelItem::create($items);  ;


            }
        }
    }    



      return redirect(route('cf.show',$request->cf_id))->with(['success'=>"Details Created Successfully",'type'=>'logistic']);
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
        $purchases = Pacel::find($id);
        $purchase_items=PacelItem::where('pacel_id',$id)->get();
        //$payments=PacelPayment::where('pacel_id',$id)->get();
        
        return view('pacel.quotation_details',compact('purchases','purchase_items'));
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
        $data =  Pacel::find($id);
        $route =Route::where('added_by',auth()->user()->added_by)->get(); 
        $users = Client::where('user_id', auth()->user()->added_by)->get();
        $name = PacelList::where('added_by', auth()->user()->added_by)->get();
        $items = PacelItem::where('pacel_id',$id)->get(); 
         $currency = Currency::all();
        return view('pacel.quotation',compact('data','id','users','name','route','items','currency'));
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
      return 'update pacel'; 

if($request->type == ''){
        $pacel = Pacel::find($id);
       
        Pacel::where('id',$id)->update([
            'pacel_name' => $request->pacel_name ,
          'date' => $request->date ,
      'due_date' => $request->due_date ,
            'owner_id' => $request->owner_id ,
            'weight' => $request->weight  ,
            'receiver_name' => $request->receiver_name ,
            'docs' => $request->docs  ,
            'non_docs' => $request->non_docs  ,
            'bags' => $request->bags ,
            'mobile' => $request->mobile ,
            'currency_code' => $request->currency_code,
            'exchange_rate' => $request->exchange_rate,
            'instructions' => $request->instructions  ,
            'added_by'=>auth()->user()->added_by,
       ]);
       
       

         $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

        if(!empty($request->discount > 0)){
            $discountArr = str_replace(",","",$request->discount);
            }
            else{
            $discountArr ='0';
            }

            if(!empty($amountArr)){
                for($i = 0; $i < count($amountArr); $i++){
                    if(!empty($amountArr[$i])){
                        $t = array(
                            'amount' =>  $amountArr[$i],
                            'due_amount' =>  $amountArr[$i],
                            'discount' =>  $discountArr[$i],
                            'tax' =>   $totalArr[$i]);
        
                              Pacel::where('id',$id)->update($t);  
        
        
                    }
                }
            }    

       
         $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
      $chargeArr =$request->charge;
 $distanceArr = $request->distance  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
         $savedArr =$request->items_id ;
         $remArr = $request->removed_id ;
         $expArr = $request->pacel_item_id ;
       
       
         if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                   PacelItem::where('id',$remArr[$i])->delete();        
                   }
               }
           }

           if(!empty($nameArr)){
               for($i = 0; $i < count($nameArr); $i++){
                   if(!empty($nameArr[$i])){
                    if($chargeArr[$i]=='1'){
                      $type[$i]='Flat';
                        }
                     else if($chargeArr[$i]== $distanceArr[$i]){
                    $type[$i]='Distance';
                        }
                     else{
                      $type[$i]='Rate';
                        }
                $items = array(
                    'item_name' => $nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr [$i],
                     'charge_type' =>  $type[$i],
                    'distance' => $distanceArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                     'items_id' => $savedArr[$i],
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$pacel->id);
                        
                           if(!empty($expArr[$i])){
                            PacelItem::where('id',$expArr[$i])->update($items);  
      
      }
                          else{
                          PacelItem::create($items);  
      
      }

                          
       
       
                   }
               }
           }    
       
       
       
              
             return redirect(route('cf.show',$request->cf_id))->with(['success'=>"Details Created Successfully",'type'=>'logistic']);
}

elseif($request->type="invoice"){
        $pacel = PacelInvoice::find($id);

$random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
if(!empty($pacel->confirmation_number)){
$number=$pacel->confirmation_number;
}
else{
$number="PCL-INV-".$random.$id;
}

$cargo=PacelInvoice::where('added_by', auth()->user()->added_by)->where('pacel_number', 'like', "PCL-INV")->first();
if(!empty($cargo)){
$pnumber=$pacel->pacel_number;
}
else{
$pnumber="PCL-INV-".$id;
}

        PacelInvoice::where('id',$id)->update([
            'pacel_number' => $pnumber,
             'confirmation_number' => $number,
            'exchange_rate' => $request->exchange_rate,
           'added_by'=>auth()->user()->added_by
       ]);
       
       

         $amountArr = str_replace(",","",$request->amount);
        $totalArr =  str_replace(",","",$request->tax);

     

            if(!empty($amountArr)){
                for($i = 0; $i < count($amountArr); $i++){
                    if(!empty($amountArr[$i])){
                        $t = array(
                            'amount' =>  $amountArr[$i],
                            'due_amount' =>  $amountArr[$i],
                            'tax' =>   $totalArr[$i]);
        
                              PacelInvoice::where('id',$id)->update($t);  
        
        
                    }
                }
            }    

       

        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
         $savedArr =$request->items_id ;
         $expArr = $request->pacel_item_id ;
       
       
    

           if(!empty($priceArr)){
               for($i = 0; $i < count( $priceArr); $i++){
                   if(!empty( $priceArr[$i])){
                 
                $items = array(
                    'tax_rate' =>  $rateArr [$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                     'items_id' => $savedArr[$i],
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$pacel->id);
                        
                        
                            PacelInvoiceItem::where('id',$expArr[$i])->update($items);  
                            $lists=  PacelInvoiceItem::where('id',$expArr[$i])->first();  
    
                          
        
            $inv= PacelInvoice::find($id);
           $cr= AccountCodes::where('account_name','Sales')->first();
          $journal = JournalEntry::where('transaction_type','cargo')->where('income_id', $id)->where('reference', $expArr[$i])->whereNotNull('credit')->first();
        $journal->account_id = $cr->id;
       $journal->transaction_type = 'cargo';
        $journal->name = 'Cargo Invoice';
        $journal->credit =  $costArr[$i] *  $inv->exchange_rate;
        $journal->income_id= $pacel->id;
        $journal->exchange_rate= $inv->exchange_rate;
     $journal->added_by=auth()->user()->added_by;
        $journal->save();

if($taxArr[$i] > 0){
       $tax= AccountCodes::where('account_name','VAT OUT')->first();
          $tax_journal = JournalEntry::where('transaction_type','cargo')->where('income_id', $id)->where('account_id',  $tax->id)->where('reference', $expArr[$i])->whereNotNull('credit')->first();
if(!empty($tax_journal)){
       $tax_journal->account_id = $tax->id;
        $tax_journal->transaction_type = 'cargo';
       $tax_journal->name = 'Cargo Invoice';
       $tax_journal->credit =  $taxArr[$i] *  $inv->exchange_rate;
       $tax_journal->income_id= $pacel->id;
          $tax_journal->exchange_rate= $inv->exchange_rate;
        $tax_journal->added_by=auth()->user()->added_by;
        $tax_journal->save();
}

else{
 $client=Client::find($inv->owner_id);

 $journal = new JournalEntry();
        $journal->account_id = $tax->id;
        $date = explode('-',$inv->date);
        $journal->date =   $inv->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'cargo';
        $journal->name = 'Cargo Invoice';
        $journal->credit = $taxArr[$i] *  $inv->exchange_rate;
       $journal->income_id= $pacel->id;
      $journal->reference= $lists->id;
         $journal->truck_id= $lists->truck_id;
         $journal->currency_code =  $inv->currency_code;
        $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
           $journal->notes= "Invoice Tax with reference no " .$inv->pacel_number. "  by Client ".  $client->name ;
        $journal->save();

}

}

else if($taxArr[$i] == 0){
  $tax= AccountCodes::where('account_name','VAT OUT')->first();
          $tax_journal = JournalEntry::where('transaction_type','cargo')->where('income_id', $id)->where('account_id',  $tax->id)->where('reference', $expArr[$i])->whereNotNull('credit')->first();
if(!empty($tax_journal)){
 $tax_journal->delete();
}

}

        $codes= AccountCodes::where('account_group','Receivables')->first();
        $journal = JournalEntry::where('transaction_type','cargo')->where('income_id', $id)->where('reference', $expArr[$i])->whereNotNull('debit')->first();
        $journal->account_id = $codes->id;
         $date = explode('-',$pacel->date);
          $journal->transaction_type = 'cargo';
       $journal->name = 'Cargo Invoice';
       $journal->debit =( $taxArr[$i] + $costArr[$i]) *  $inv->exchange_rate;
           $journal->income_id= $pacel->id;
          $journal->exchange_rate= $inv->exchange_rate;
         $journal->added_by=auth()->user()->added_by;
        $journal->save();
       
                   }
               }
           }    
       
     
              
            return redirect(route('pacel.invoice'))->with(['success'=>'Updated Successfully']);

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
        PacelItem::where('pacel_id', $id)->delete();
        PacelPayment::where('pacel_id', $id)->delete();
        $purchases = Pacel::find($id);
        $purchases->delete();
        return redirect(route('pacel_quotation.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= Route::where('id',$request->id)->get();
                return response()->json($price);	                  

    }


   public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
                if($type == 'supplier'){
               return view('pacel.addClient');
               
                }elseif($type == 'route'){
                    $old = Pacel::find($id);
               $region = Region::all();   
                return view('pacel.addRoute',compact('id','old','region'));   
                }elseif($type == 'issue'){
                    $data= PacelInvoice::find($id);
               $user = User::all();   
                return view('pacel.addIssue',compact('id','data','user'));   
                }else{
               
                 $old = Pacel::find($id);
                return view('pacel.addLoading',compact('id','old'));
               
                }
                
 

       
   }

   public function addSupplier(Request $request){
       
    
        $client= Client::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        'TIN' => $request['TIN'],
            'user_id'=> auth()->user()->added_by,
            'added_by'=> auth()->user()->added_by,
            
        ]);
        
      

        if (!empty($client)) {           
            return response()->json($client);
         }

       
   }

   public function addRoute(Request $request){
       
       
      //
      $route = Route::create([
          'from' => $request['from'],
          'to' => $request['to'],
          'distance' => $request['distance'],
          'added_by'=> auth()->user()->added_by,
      ]);
      
    

      if (!empty($route)) {           
          return response()->json($route);
       }

     
 }


  public function newdiscount(Request $request)
   {
  Pacel::where('id',$request->id)->update([
     'amount' => $request->amount ,
     'due_amount' => $request->amount ,
     'discount' => $request->discount ,
]);

         return redirect(route('pacel_quotation.index'))->with(['success'=>'Discount for the Quotation created successfully']);
   }


public function save_issue(Request $request)
   {
  PacelInvoice::where('id',$request->id)->update([
     'issue_date' => $request->date ,
     'issued_by' => $request->staff,
]);

         return redirect(route('invoice.details',$request->id))->with(['success'=>'Issued Successfully']);
   }
   public function approve($id)
   {
       //
       $purchase = Pacel::find($id);
       $data['collected'] = 1;
       $purchase->update($data);


            $quot=Pacel::find($id);  
              
             $items=PacelItem::where('pacel_id',$id)->get();
           foreach($items as $i){
               $route = Route::find($i->item_name); 
               $region_from= Region::where('name',$route->from)->first(); 
             $region_to= Region::where('name',$route->to)->first(); 

                $result['pacel_id']=$id;
                $result['pacel_name']=$quot->pacel_name;
                $result['pacel_number']=$quot->pacel_number;
                $result['weight']=$quot->weight;
               $result['due_weight']=$quot->weight;
                $result['start_location']= $route->from;
                $result['end_location']=$route->to;
                $result['from_region_id']= $route->from_region_id;
                $result['to_region_id']=$route->to_region_id;
                $result['owner_id']=$quot->owner_id;
              $result['receiver_name']=$quot->receiver_name;
                $result['amount']=$i->total_cost;
                $result['route_id']=$i->item_name;
                $result['item_id']=$i->id;
                  $result['quantity']=$i->quantity;
                $result['status']='2';
                $result['added_by'] = auth()->user()->added_by;
                $movement=CargoCollection::create($result);
      }          


        
       return redirect(route('order.collection'))->with(['success'=>'Package Collected Successfully']);
   }
   public function invoice()
   {
       //
       $pacel = PacelInvoice::where('added_by', auth()->user()->added_by)->get();
       $route = Route::where('added_by',auth()->user()->added_by)->get(); 
       $users = Client::where('user_id', auth()->user()->added_by)->get();
         $name = PacelList::where('added_by', auth()->user()->added_by)->get();
         $currency = Currency::all();
      $id="";
       return view('pacel.invoice',compact('pacel','route','users','name','currency','id'));
   }
   public function edit_invoice($id)
   {
       //
       $data = PacelInvoice::find($id);
       $route = Route::where('added_by',auth()->user()->added_by)->get(); 
       $users = Client::where('user_id', auth()->user()->added_by)->get();
        $name = PacelList::where('added_by', auth()->user()->added_by)->get();
        $items = PacelInvoiceItem::where('pacel_id',$id)->get(); 
         $currency = Currency::all();
       return view('pacel.invoice',compact('data','route','users','name','currency','id','items'));
   }

      public function details($id)
    {
        //
        $purchases =PacelInvoice::find($id);
        $purchase_items=PacelInvoiceItem::where('pacel_id',$id)->get();
        $payments=PacelPayment::where('pacel_id',$id)->get();
        
        return view('pacel.invoice_details',compact('purchases','purchase_items','payments'));
    }

   public function cancel($id)
   {
       //
       $purchase = Pacel::find($id);
       $data['status'] = 7;
       $purchase->update($data);
       return redirect(route('pacel_quotation.index'))->with(['success'=>'Cancelled Successfully']);
   }
   
     public function disable($id)
   {
       //
       $purchase = Pacel::find($id);
       $data['status'] = 400;
       $purchase->update($data);
       return redirect(route('pacel_quotation.index'))->with(['success'=>'Disabled Successfully']);
   }

  

   public function make_payment($id)
   {
       //
       $invoice =PacelInvoice::find($id);
       $payment_method = Payment_methodes::all();
  $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
       return view('pacel.pacel_payment',compact('invoice','payment_method','bank_accounts'));
   }
   
   public function pacel_pdfview(Request $request)
   {
       //
       $purchases = Pacel::find($request->id);
       $purchase_items=PacelItem::where('pacel_id',$request->id)->get();

       view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

       if($request->has('download')){
       $pdf = PDF::loadView('pacel.quotation_pdf')->setPaper('a4', 'potrait');
      return $pdf->download('CARGO SALES NO # ' .  $purchases->pacel_number . ".pdf");
       }
       return view('pacel_pdfview');
   }

   public function invoice_pdfview(Request $request)
   {
       //
       $purchases =PacelInvoice::find($request->id);
       $purchase_items=PacelInvoiceItem::where('pacel_id',$request->id)->get();

       view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

       if($request->has('download')){
       $pdf = PDF::loadView('pacel.invoice_pdf')->setPaper('a4', 'potrait');
      return $pdf->download('CARGO INVOICE SALES NO # ' .  $purchases->pacel_number . ".pdf");
       }
       return view('invoice_pdfview');
   }

}
