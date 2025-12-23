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
use App\Models\SystemConfig;
use App\Models\System;

class CourierPickupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

          $courier = Courier::where('added_by',auth()->user()->added_by)->where('pickup','0')->orwhere('pickup','1')->orderBy('created_at','desc')->get();      
        $route = Route::all();
        $users = CourierClient::where('user_id',auth()->user()->added_by)->get();
          $name = CourierList::all();
          $currency = Currency::all();
       $region = Region::all();   
        return view('courier.pickup',compact('courier','route','users','name','currency','region'));
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
        $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(11/strlen($x)) )),1,10);
 
         //dd($random);
      $sys = System::where('added_by',auth()->user()->added_by)->first();
       $config=SystemConfig::where('system_id',$sys->id)->where('type','courier')->first();
            $client = CourierClient::find($request->owner_id);

        if(!empty($client->code)){

        if(!empty($config)){
          $count = Courier::where('added_by',auth()->user()->added_by)->count();  
        if($count > 0){
        $pro=$count+1;
       }

        else{
           $pro=$config->start_no;
           }

         $reference=$config->prefix.'/'.$client->code.'/00'.$pro;
         }

     else{
 $count=Courier::where('added_by',auth()->user()->added_by)->count();
        $pro=$count+1;
       $reference=$client->code.'/00'.$pro;
}


         }

else{

        if(!empty($config)){
          $count = Courier::where('added_by',auth()->user()->added_by)->count();  
        if($count > 0){
        $pro=$count+1;
       }

        else{
           $pro=$config->start_no;
           }

         $reference=$config->prefix.'/00'.$pro;
         }

     else{
 $count=Courier::where('added_by',auth()->user()->added_by)->count();
        $pro=$count+1;
       $reference='CM00'.$pro;
}


         }





       


  $pacel=Courier::create([
   'confirmation_number' =>$reference ,
   'date' => $request->date ,
      'location' => $request->location ,
      'currency_code' => 'TZS' ,
       'exchange_rate' => '1' ,
     'owner_id' => $request->owner_id ,
     'from_region_id' =>$request->from_region_id,
     'from_district_id' =>$request->from_district_id,
     'status' => '0'  ,
     'good_receive' => '0'  ,
     'instructions' => $request->instructions  ,
     'added_by'=>auth()->user()->added_by,
]);


       $confirmation_number = $random.$pro;
 

      Courier::where('id',$pacel->id)->update([ 'pacel_number' =>  $confirmation_number]);  


       return redirect(route('courier_pickup.index'))->with(['success'=>'Created Successfully.']);

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
       
        
        return view('courier.pickup_details',compact('purchases'));
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
        return view('courier.pickup',compact('data','id','users','name','route','items','currency','tariff','from_district','to_district','region'));
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
   'date' => $request->date ,
     'owner_id' => $request->owner_id ,
    'location' => $request->location ,
     'from_region_id' =>$request->from_region_id,
     'from_district_id' =>$request->from_district_id,
     'instructions' => $request->instructions  ,
     'added_by'=>auth()->user()->added_by,
       ]);
       
       
   return redirect(route('courier_pickup.index'))->with(['success'=>'Updated Successfully.']);
       
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
        //CourierItem::where('pacel_id', $id)->delete();
        //CourierPayment::where('pacel_id', $id)->delete();
        $purchases = Courier::find($id);
        $purchases->delete();
        return redirect(route('courier_pickup.index'))->with(['success'=>'Deleted Successfully']);
    }



   public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
               
       
   }





   public function approve($id)
   {
       //
       $purchase = Courier::find($id);
       $data['pickup'] = 1;
       $purchase->update($data);


           
        
       return redirect(route('courier_pickup.index'))->with(['success'=>'Pickup Confirmed.']);
   }
  
   public function pickup_pdfview(Request $request)
   {
       //
       $purchases = Courier::find($request->id);
       //$purchase_items=CourierItem::where('pacel_id',$request->id)->get();

       view()->share(['purchases'=>$purchases]);

       if($request->has('download')){
       $pdf = PDF::loadView('courier.pickup_pdf')->setPaper('a4', 'potrait');
      return $pdf->download('COURIER NO # ' .  $purchases->confirmation_number . ".pdf");
       }
       return view('pickup_pdfview');
   }


}
