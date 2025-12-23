<?php

namespace App\Http\Controllers\Radio;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Radio\Radio;
use App\Models\Radio\RadioItem;
use App\Models\Radio\RadioProgram;
use App\Models\Client;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\Branch;
use Illuminate\Http\Request;
use PDF;
use App\Models\AccountCodes;
use App\Models\JournalEntry;


class RadioPickupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

          $courier = Radio::where('added_by',auth()->user()->added_by)->where('pickup','0')->orwhere('pickup','1')->get();      
          $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
        $users = Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
          
        return view('radio.pickup',compact('courier','users','branch'));
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
        
        $count=Radio::where('added_by',auth()->user()->added_by)->count();
        $pro=$count+1;

 
        $data=$request->all();
        $data['confirmation_number']="MG".$random;
        $data['added_by']=auth()->user()->added_by;
         $data['user_id']=auth()->user()->id;
        $pacel=Radio::create($data);


       $confirmation_number = "MG".$random.$pro;
 

      Radio::where('id',$pacel->id)->update([ 'pacel_number' =>  $confirmation_number]);  


       return redirect(route('radio_pickup.index'))->with(['success'=>'Created Successfully.']);

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
        $purchases = Radio::find($id);
       
        
        return view('radio.pickup_details',compact('purchases'));
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
        $data =  Radio::find($id);
        $branch = Branch::all()->where('disabled','0')->where('added_by', auth()->user()->added_by);
        $users = Client::where('owner_id',auth()->user()->added_by)->where('disabled','0')->get();
        return view('radio.pickup',compact('data','id','users','branch'));
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
 
        $pacel = Radio::find($id);
        $data=$request->all();
        $data['added_by']=auth()->user()->added_by;
         $data['user_id']=auth()->user()->id;
        $pacel->update($data);
       
       
   return redirect(route('radio_pickup.index'))->with(['success'=>'Updated Successfully.']);
       
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
        $purchases = Radio::find($id);
        $purchases->delete();
        return redirect(route('radio_pickup.index'))->with(['success'=>'Deleted Successfully']);
    }



   public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
               
       
   }





   public function approve($id)
   {
       //
       $purchase = Radio::find($id);
       $data['pickup'] = 1;
       $purchase->update($data);


           
        
       return redirect(route('radio_pickup.index'))->with(['success'=>'Approved.']);
   }
  
   public function pickup_pdfview(Request $request)
   {
       //
       $purchases = Radio::find($request->id);
       //$purchase_items=CourierItem::where('pacel_id',$request->id)->get();

       view()->share(['purchases'=>$purchases]);

       if($request->has('download')){
       $pdf = PDF::loadView('radio.pickup_pdf')->setPaper('a4', 'potrait');
      return $pdf->download('RADIO ORDER NO # ' .  $purchases->confirmation_number . ".pdf");
       }
       return view('pickup_pdfview');
   }


}
