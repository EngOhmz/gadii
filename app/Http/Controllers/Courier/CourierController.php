<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Courier\Courier;
use App\Models\Courier\CourierItem;
use App\Models\Courier\CourierList;
use App\Models\Courier\CourierPayment;
use App\Models\Payment_methodes;
use App\Models\Route;
use App\Models\Courier\CourierClient;
use Illuminate\Http\Request;
use PDF;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\orders\OrderMovement;
use App\Models\Region;
use App\Models\Courier\CourierCollection;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $courier = Courier::where('good_receive','0')->orwhere('status','7')->get();
        $route = Route::all();
        $users = CourierClient::all();
          $name = CourierList::all();
          $currency = Currency::all();
        return view('courier.quotation',compact('courier','route','users','name','currency'));
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
    

  $pacel=Courier::create([
     'pacel_name' => $request->pacel_name ,
   'pacel_number' => '12AB' ,
   'date' => $request->date ,
  'due_date' => $request->due_date ,
     'owner_id' => $request->owner_id ,
     'weight' => $request->weight  ,
     'receiver_name' => $request->receiver_name ,
    'route_id' => $request->route_id ,
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
     'added_by'=>auth()->user()->id,
]);


    $number = "CM-".$pacel->id;
       $confirmation_number = "CM-".$random.$pacel->id;
  $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);

  $nameArr =$request->item_name ;
 $qtyArr = $request->quantity  ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
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

                      Courier::where('id',$pacel->id)->update($t);  


            }
        }
    }    







    if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
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
                       'added_by'=>auth()->user()->id,
                    'pacel_id' =>$pacel->id);

                 CourierItem::create($items);  ;


            }
        }
    }    




       
       return redirect(route('courier_quotation.show',$pacel->id));
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
        $purchases = Courier::find($id);
        $purchase_items=CourierItem::where('pacel_id',$id)->get();
        $payments=CourierPayment::where('pacel_id',$id)->get();
        
        return view('courier.quotation_details',compact('purchases','purchase_items','payments'));
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
        $data =  Courier::find($id);
        $route = Route::all();
        $users = CourierClient::all();
        $name = CourierList::all();
        $items = CourierItem::where('pacel_id',$id)->get(); 
         $currency = Currency::all();
        return view('courier.quotation',compact('data','id','users','name','route','items','currency'));
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
        $pacel = Courier::find($id);

        Courier::where('id',$id)->update([
            'pacel_name' => $request->pacel_name ,
          'date' => $request->date ,
      'due_date' => $request->due_date ,
            'owner_id' => $request->owner_id ,
            'route_id' => $request->route_id ,
            'weight' => $request->weight  ,
            'receiver_name' => $request->receiver_name ,
            'docs' => $request->docs  ,
            'non_docs' => $request->non_docs  ,
            'bags' => $request->bags ,
            'mobile' => $request->mobile ,
            'currency_code' => $request->currency_code,
            'exchange_rate' => $request->exchange_rate,
            'instructions' => $request->instructions  ,
            'added_by'=>auth()->user()->id,
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
        
                              Courier::where('id',$id)->update($t);  
        
        
                    }
                }
            }    

       
         $nameArr =$request->item_name ;
        $qtyArr = $request->quantity  ;
        $priceArr = $request->price;
        $rateArr = $request->tax_rate ;
        $unitArr = $request->unit  ;
        $costArr = str_replace(",","",$request->total_cost)  ;
        $taxArr =  str_replace(",","",$request->total_tax );
         $savedArr =$request->items_id ;
         $remArr = $request->removed_id ;
         $expArr = $request->pacel_item_id ;
       
       
         if (!empty($remArr)) {
            for($i = 0; $i < count($remArr); $i++){
               if(!empty($remArr[$i])){        
                   CourierItem::where('id',$remArr[$i])->delete();        
                   }
               }
           }

           if(!empty($nameArr)){
               for($i = 0; $i < count($nameArr); $i++){
                   if(!empty($nameArr[$i])){
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
                              'added_by'=>auth()->user()->id,
                           'pacel_id' =>$pacel->id);
                        
                           if(!empty($expArr[$i])){
                            CourierItem::where('id',$expArr[$i])->update($items);  
      
      }
                          else{
                          CourierItem::create($items);  
      
      }

                          
       
       
                   }
               }
           }    
       
       
       
       
              
              return redirect(route('courier_quotation.show',$pacel->id));
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
        CourierItem::where('pacel_id', $id)->delete();
        CourierPayment::where('pacel_id', $id)->delete();
        $purchases = Courier::find($id);
        $purchases->delete();
        return redirect(route('courier_quotation.index'))->with(['success'=>'Deleted Successfully']);
    }

    public function findPrice(Request $request)
    {
               $price= CourierList::where('id',$request->id)->get();
                return response()->json($price);                      

    }


   public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
                if($type == 'supplier'){
               return view('courier.addClient');
               
                }elseif($type == 'route'){
                    $old = Courier::find($id);
               $region = Region::all();   
                return view('courier.addRoute',compact('id','old','region'));   
                }else{
               
                 $old = Courier::find($id);
                return view('courier.addLoading',compact('id','old'));
               
                }
                
 

       
   }

   public function addSupplier(Request $request){
       
    
        $client= CourierClient::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        'TIN' => $request['TIN'],
            'user_id'=> auth()->user()->id,
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
          'added_by'=> auth()->user()->id,
      ]);
      
    

      if (!empty($route)) {           
          return response()->json($route);
       }

     
 }


  public function newdiscount(Request $request)
   {
  Courier::where('id',$request->id)->update([
     'amount' => $request->amount ,
     'due_amount' => $request->amount ,
     'discount' => $request->discount ,
]);

         return redirect(route('courier_quotation.index'))->with(['success'=>'Discount for the Quotation created successfully']);
   }

   public function approve($id)
   {
       //
       $purchase = Courier::find($id);
       $data['good_receive'] = 1;
       $purchase->update($data);


            $quot=Courier::find($id);  
                $route = Route::find($quot->route_id); 
               $region_from= Region::where('name',$route->from)->first(); 
             $region_to= Region::where('name',$route->to)->first(); 
        
                $result['pacel_id']=$id;
                $result['pacel_name']=$quot->pacel_name;
                $result['pacel_number']=$quot->pacel_number;
                $result['weight']=$quot->weight;
               $result['due_weight']=$quot->weight;
                $result['start_location']= $region_from->id;
                $result['end_location']=$region_to->id;
                $result['owner_id']=$quot->owner_id;
              $result['receiver_name']=$quot->receiver_name;
                $result['amount']=$quot->amount;
                $result['route_id']=$quot->route_id;
                $result['status']='2';
                $result['added_by'] = auth()->user()->id;
                $movement=CourierCollection::create($result);
                

$client=CourierClient::find($purchase->owner_id);

$cr= AccountCodes::where('account_name','Courier')->first();
          $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',$purchase->date);
        $journal->date =   $purchase->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'courier';
        $journal->name = 'Invoice';
        $journal->credit = ($purchase->amount - $purchase->tax) *  $purchase->exchange_rate;
        $journal->income_id= $id;
         $journal->currency_code =  $purchase->currency_code;
        $journal->exchange_rate= $purchase->exchange_rate;
       $journal->added_by=auth()->user()->id;
           $journal->notes= "Courier Invoice with reference no " .$purchase->pacel_number. "  by Client ".  $client->name ;
        $journal->save();

if($purchase->tax > 0){
       $tax= AccountCodes::where('account_name','VAT OUT')->first();
          $journal = new JournalEntry();
        $journal->account_id = $tax->id;
        $date = explode('-',$purchase->date);
        $journal->date =   $purchase->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'courier';
        $journal->name = 'Invoice';
        $journal->credit = $purchase->tax *  $purchase->exchange_rate;
        $journal->income_id= $id;
         $journal->currency_code =  $purchase->currency_code;
        $journal->exchange_rate= $purchase->exchange_rate;
       $journal->added_by=auth()->user()->id;
           $journal->notes= "Courier Invoice Tax with reference no " .$purchase->pacel_number. "  by Client ".  $client->name ;
        $journal->save();
}

        $codes= AccountCodes::where('account_group','Receivables')->first();
        $journal = new JournalEntry();
        $journal->account_id = $codes->id;
         $date = explode('-',$purchase->date);
        $journal->date =   $purchase->date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'courier';
        $journal->name = 'Invoice';
               $journal->income_id= $id;
       $journal->notes= "Courier Debit Receivables for Invoice with reference no " .$purchase->pacel_number. "  by Client ".  $client->name ;
        $journal->debit =$purchase->amount *  $purchase->exchange_rate;
            $journal->currency_code =  $purchase->currency_code;
        $journal->exchange_rate= $purchase->exchange_rate;
 $journal->added_by=auth()->user()->id;
        $journal->save();
        
       return redirect(route('courier.invoice'))->with(['success'=>'Invoiced Successfully']);
   }
   public function invoice()
   {
       //
       $courier = Courier::where('good_receive','1')->get();
       $route = Route::all();
       $users = CourierClient::all();
         $name = CourierList::all();
         $currency = Currency::all();
       return view('courier.invoice',compact('courier','route','users','name','currency'));
   }

   public function cancel($id)
   {
       //
       $purchase = Courier::find($id);
       $data['status'] = 7;
       $purchase->update($data);
       return redirect(route('courier_quotation.index'))->with(['success'=>'Cancelled Successfully']);
   }

  

   public function make_payment($id)
   {
       //
       $invoice = Courier::find($id);
       $payment_method = Payment_methodes::all();
  $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->get() ;
       return view('courier.pacel_payment',compact('invoice','payment_method','bank_accounts'));
   }
   
   public function courier_pdfview(Request $request)
   {
       //
       $purchases = Courier::find($request->id);
       $purchase_items=CourierItem::where('pacel_id',$request->id)->get();

       view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

       if($request->has('download')){
       $pdf = PDF::loadView('courier.quotation_pdf')->setPaper('a4', 'landscape');
      return $pdf->download('COURIER NO # ' .  $purchases->pacel_number . ".pdf");
       }
       return view('courier_pdfview');
   }

}
