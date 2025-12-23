<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Courier\Courier;
use App\Models\Courier\CourierInvoiceItem;
use App\Models\Courier\CourierInvoice;
use App\Models\Courier\CourierItem;
use App\Models\Courier\CourierList;
use App\Models\Courier\CourierPayment;
use App\Models\Payment_methodes;
use App\Models\Route;
use App\Models\Tariff;
use App\Models\Driver;
use App\Models\Courier\CourierClient;
use Illuminate\Http\Request;
use PDF;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\orders\OrderMovement;
use App\Models\Region;
use App\Models\District;
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
         if(auth()->user()->client_id != null){
            $courier = Courier::where('owner_id',auth()->user()->client_id)->get();     
         }else{
          $courier = Courier::where('added_by',auth()->user()->added_by)->get();
         }

        $route = Route::all();
        $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
          $name = CourierList::all();
          $currency = Currency::all();
       $region = Region::all();   
        return view('courier.quotation',compact('courier','route','users','name','currency','region'));
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
 
 if($request->from_district_id != $request->to_district_id){   
 $count=Courier::count();
        $pro=$count+1;

  $pacel=Courier::create([
   'pacel_number' =>'CM0'.$pro ,
   'date' => $request->date ,
     'owner_id' => $request->owner_id ,
       'by_client' => $request->by_client ,
     'from_region_id' =>$request->from_region_id,
    'to_region_id' => $request->to_region_id ,
     'from_district_id' =>$request->from_district_id,
    'to_district_id' => $request->to_district_id ,
     'docs' => $request->docs  ,
     'non_docs' => $request->non_docs  ,
     'bags' => $request->bags ,
     'discount' => '0'  ,
     'status' => '0'  ,
     'good_receive' => '0'  ,
     'currency_code' => $request->currency_code,
     'exchange_rate' => $request->exchange_rate,
     'instructions' => $request->instructions  ,
     'added_by'=>auth()->user()->added_by,
]);


       $confirmation_number = "CM".$random.$pacel->id;
  $amountArr = str_replace(",","",$request->amount);
 $totalArr =  str_replace(",","",$request->tax);

  $nameArr =$request->item_name ;
 $qtyArr = $request->quantity  ;
 $priceArr = $request->price;
 $rateArr = $request->tax_rate ;
 $unitArr = $request->unit  ;
 $costArr = str_replace(",","",$request->total_cost)  ;
 $taxArr =  str_replace(",","",$request->total_tax );

  if(!empty($nameArr)){
        for($i = 0; $i < count($amountArr); $i++){
            if(!empty($amountArr[$i])){
                $t = array(
                    'amount' =>  $amountArr[$i],
                    'due_amount' =>  $amountArr[$i] ,
                      'confirmation_number' =>  $confirmation_number , 
                    'tax' =>   $totalArr[$i]);

                      Courier::where('id',$pacel->id)->update($t);  


            }
        }
    }    



    $cost['weight'] = 0;
    if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
                  $cost['weight'] += $qtyArr[$i];
                $items = array(
                    'item_name' => $nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr [$i],
                     'unit' => $unitArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                     'items_id' =>  $nameArr[$i],
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$pacel->id);

                $it= CourierItem::create($items);  ;

            }
        }
         $cost['tariff_id'] =$it->item_name  ;
          Courier::where('id',$pacel->id)->update($cost);
    }    
       
       return redirect(route('courier_quotation.show',$pacel->id));
}

else{
  return redirect(route('courier_quotation.index'))->with(['error'=>'Districts cannot be the same']);
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
          $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
        $name = CourierList::all();
        $items = CourierItem::where('pacel_id',$id)->first(); 
         $currency = Currency::all();
            $tariff= Tariff::where('client_id',$data->owner_id)->get();
    $from_district= District::where('region_id', $data->from_region_id)->get(); 
  $to_district= District::where('region_id', $data->to_region_id)->get();   
    $region = Region::all();
        return view('courier.quotation',compact('data','id','users','name','route','items','currency','tariff','from_district','to_district','region'));
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
 if($request->from_district_id != $request->to_district_id){   
        $pacel = Courier::find($id);

        Courier::where('id',$id)->update([
   'date' => $request->date ,
     'owner_id' => $request->owner_id ,
       'by_client' => $request->by_client ,
     'from_region_id' =>$request->from_region_id,
    'to_region_id' => $request->to_region_id ,
     'from_district_id' =>$request->from_district_id,
    'to_district_id' => $request->to_district_id ,
     'docs' => $request->docs  ,
     'non_docs' => $request->non_docs  ,
     'bags' => $request->bags ,
     'currency_code' => $request->currency_code,
     'exchange_rate' => $request->exchange_rate,
     'instructions' => $request->instructions  ,
     'added_by'=>auth()->user()->added_by,
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
       


        $cost['weight'] = 0;
    if(!empty($nameArr)){
        for($i = 0; $i < count($nameArr); $i++){
            if(!empty($nameArr[$i])){
                  $cost['weight'] += $qtyArr[$i];
                $items = array(
                    'item_name' => $nameArr[$i],
                    'quantity' =>   $qtyArr[$i],
                    'tax_rate' =>  $rateArr [$i],
                     'unit' => $unitArr[$i],
                       'price' =>  $priceArr[$i],
                    'total_cost' =>  $costArr[$i],
                    'total_tax' =>   $taxArr[$i],
                     'items_id' =>  $nameArr[$i],
                       'order_no' => $i,
                       'added_by'=>auth()->user()->added_by,
                    'pacel_id' =>$id);

                        
                            CourierItem::where('pacel_id',$id)->update($items);  
                      $it=  CourierItem::where('pacel_id',$id)->first(); 

                   }
               }
             $cost['tariff_id'] =$it->item_name  ;
          Courier::where('id',$id)->update($cost);
           }    
       
              return redirect(route('courier_quotation.show',$id));
}
else{
  return redirect(route('courier_quotation.index'))->with(['error'=>'Districts cannot be the same']);
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
        CourierItem::where('pacel_id', $id)->delete();
        //CourierPayment::where('pacel_id', $id)->delete();
        $purchases = Courier::find($id);
        $purchases->delete();
        return redirect(route('courier_quotation.index'))->with(['success'=>'Deleted Successfully']);
    }

  
 public function findTariff(Request $request)
    {
               //$price= CourierList::where('id',$request->id)->get();
              $price= Tariff::where('client_id',$request->id)->where('type','Automatic')->get();
                return response()->json($price);                      

    }

 public function findTariff2(Request $request)
    {
               //$price= CourierList::where('id',$request->id)->get();
              $price= Tariff::where('client_id',$request->id)->where('type','Formula')->get();
                return response()->json($price);                      

    }

    public function findPrice(Request $request)
    {
               //$price= CourierList::where('id',$request->id)->get();
              $price= Tariff::where('id',$request->id)->get();
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
                }
              elseif($type == 'assign'){
                    $old = Courier::find($id);
               $driver =Driver::where('added_by', auth()->user()->added_by)->get();   
                return view('courier.assign',compact('id','old','driver'));   
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
            'user_id'=> auth()->user()->added_by,
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
  Courier::where('id',$request->id)->update([
     'amount' => $request->amount ,
     'due_amount' => $request->amount ,
     'discount' => $request->discount ,
]);

         return redirect(route('courier_quotation.index'))->with(['success'=>'Discount for the Quotation created successfully']);
   }

 public function first_approval(Request $request)
   {
       //
      $id=$request->id;
       $purchase = Courier::find($id);
        $data['approval_1'] =  auth()->user()->id;
       $purchase->update($data);


          
       return redirect(route('courier_quotation.index'))->with(['success'=>'First Approval Executed Successfully']);
   }

 public function second_approval(Request $request)
   {
       //
      $id=$request->id;
       $purchase = Courier::find($id);
        $data['approval_2'] =  auth()->user()->id;
       $purchase->update($data);


          
       return redirect(route('courier_quotation.index'))->with(['success'=>'Second Approval Executed Successfully']);
   }

 public function assign(Request $request)
   {
       //
      $id=$request->id;
       $purchase = Courier::find($id);
       $data['good_receive'] = 1;
        $data['collector_id'] = $request->collector_id;
        $data['approval_3'] =  auth()->user()->id;
       $purchase->update($data);


            $quot=Courier::find($id);  
                $route = Tariff::find($quot->tariff_id); 
               $region_from= Region::where('name',$route->from_region_id)->first(); 
             $region_to= Region::where('name',$route->to_region_id)->first(); 
        
                $result['pacel_id']=$id;
                $result['pacel_number']=$quot->pacel_number;
                 $result['confirmation_number']=$quot->confirmation_number;
                $result['weight']=$quot->weight;
               $result['due_weight']=$quot->weight;
                $result['start_location']= $route->from_region_id;
                $result['end_location']=$route->to_region_id;
                $result['owner_id']=$quot->owner_id;
                $result['amount']=$quot->amount;
                $result['tariff_id']=$quot->tariff_id;
                $result['status']='2';
                 $result['collector_id'] = $request->collector_id;
                $result['added_by'] = auth()->user()->added_by;
                $movement=CourierCollection::create($result);
                


        
       return redirect(route('courier.collection'))->with(['success'=>'Package Collected Successfully']);
   }

   public function approve($id)
   {
       //
       $purchase = Courier::find($id);
       $data['good_receive'] = 1;
       $purchase->update($data);


            $quot=Courier::find($id);  
                $route = Tariff::find($quot->tariff_id); 
               $region_from= Region::where('name',$route->from_region_id)->first(); 
             $region_to= Region::where('name',$route->to_region_id)->first(); 
        
                $result['pacel_id']=$id;
                $result['pacel_number']=$quot->pacel_number;
                $result['weight']=$quot->weight;
               $result['due_weight']=$quot->weight;
                $result['start_location']= $route->from_region_id;
                $result['end_location']=$route->to_region_id;
                $result['owner_id']=$quot->owner_id;
                $result['amount']=$quot->amount;
                $result['tariff_id']=$quot->tariff_id;
                $result['status']='2';
                $result['added_by'] = auth()->user()->added_by;
                $movement=CourierCollection::create($result);
                


        
       return redirect(route('courier.collection'))->with(['success'=>'Package Collected Successfully']);
   }
   public function invoice()
   {
       //
       $courier =  CourierInvoice::all()->where('added_by',auth()->user()->added_by);
       $route = Route::all();
       $users = CourierClient::all();
         $name = CourierList::all();
         $currency = Currency::all();
       return view('courier.invoice',compact('courier','route','users','name','currency'));
   }
    public function details($id)
    {
        //
        $purchases =CourierInvoice::find($id);
        $purchase_items=CourierInvoiceItem::where('pacel_id',$id)->get();
        $payments=CourierPayment::where('pacel_id',$id)->get();
        
        return view('courier.invoice_details',compact('purchases','purchase_items','payments'));
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
       $invoice = CourierInvoice::find($id);
       $payment_method = Payment_methodes::all();
  $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
       return view('courier.pacel_payment',compact('invoice','payment_method','bank_accounts'));
   }
   
   public function courier_pdfview(Request $request)
   {
       //
       $purchases = Courier::find($request->id);
       $purchase_items=CourierItem::where('pacel_id',$request->id)->get();

       view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

       if($request->has('download')){
       $pdf = PDF::loadView('courier.quotation_pdf')->setPaper('a4', 'potrait');
      return $pdf->download('COURIER NO # ' .  $purchases->confirmation_number . ".pdf");
       }
       return view('courier_pdfview');
   }

public function courier_invoice_pdfview(Request $request)
 {
       //
       $purchases =CourierInvoice::find($request->id);
       $purchase_items=CourierInvoiceItem::where('pacel_id',$request->id)->get();

       view()->share(['purchases'=>$purchases,'purchase_items'=> $purchase_items]);

       if($request->has('download')){
       $pdf = PDF::loadView('courier.invoice_pdf')->setPaper('a4', 'potrait');
      return $pdf->download('COURIER INVOICE NO # ' .  $purchases->confirmation_number . ".pdf");
       }
       return view('courier_invoice_pdfview');
   }
}
