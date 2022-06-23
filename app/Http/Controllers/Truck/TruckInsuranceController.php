<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\TruckInsurance;
use Illuminate\Http\Request;
use App\Models\AccountCodes;
use App\Models\JournalEntry;

class TruckInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = $request->all();
        $data['added_by']=auth()->user()->id;
        $truck= TruckInsurance::create($data);

$supp=Truck::find($truck->truck_id);
 
$dr= AccountCodes::where('account_name','Insurance')->first();
$journal = new JournalEntry();
  $journal->account_id = $dr->id;
  $date = explode('-',$truck->created_at);
  $journal->date =   $truck->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_insurance';
  $journal->name = 'Truck Insurance';
  $journal->debit = $truck->value;
  $journal->payment_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
  $journal->added_by=auth()->user()->id;
  $journal->notes= "Truck Insurance for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();



  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$truck->created_at);
  $journal->date =   $truck->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_insurance';
  $journal->name = 'Truck Insurance';
  $journal->credit =$truck->value;
  $journal->payment_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
  $journal->added_by=auth()->user()->id;
  $journal->notes= "Truck Insurance for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();
  
        return redirect(route('truck.insurance', $request->truck_id))->with(['success'=>"Truck Insurance Created Successfully",'type'=>"insurance"]);
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
        $data =  TruckInsurance::find($id);      
        $truck=  Truck::where('id',$data->truck_id)->first();
        $type = "edit-insurance";
        return view('truck.insurance',compact('data','id','type','truck'));
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
        $truck= TruckInsurance::find($id);   

        $data = $request->all();   
        $data['added_by']=auth()->user()->id;

       
        $truck->update($data);

     $dr= AccountCodes::where('account_name','Insurance')->first();
$journal = JournalEntry::where('transaction_type','truck_insurance')->where('payment_id', $truck->truck_id)->whereNotNull('debit')->first();
  $journal->account_id = $dr->id;
  $date = explode('-',$truck->created_at);
  $journal->date =   $truck->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_insurance';
  $journal->name = 'Truck Insurance';
  $journal->debit = $truck->value;
  $journal->payment_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
  $journal->added_by=auth()->user()->id;
  $journal->notes= "Truck Insurance for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->update();



  $codes= AccountCodes::where('account_name','Payables')->first();
  $journal = JournalEntry::where('transaction_type','truck_insurance')->where('payment_id', $truck->truck_id)->whereNotNull('credit')->first();
  $journal->account_id = $codes->id;
  $date = explode('-',$truck->created_at);
  $journal->date =   $truck->created_at ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_insurance';
  $journal->name = 'Truck Insurance';
  $journal->credit = $truck->value;
  $journal->payment_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
  $journal->added_by=auth()->user()->id;
  $journal->notes= "Truck Insurance for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->update();
 
        return redirect(route('truck.insurance', $request->truck_id))->with(['success'=>"Truck Insurance Updated Successfully",'type'=>"insurance"]);
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
        $truck= TruckInsurance::find($id);
         JournalEntry::where('transaction_type','truck_insurance')->where('payment_id', $id)->delete();
        $truck->delete();
        return redirect(route('truck.insurance'))->with(['success'=>"Licence Deleted Successfully",'type'=>"insurance"]);
    }
}
