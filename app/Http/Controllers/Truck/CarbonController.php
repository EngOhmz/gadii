<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\TruckCarbon;
use App\Models\Truck;
use Illuminate\Http\Request;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Supplier;

class CarbonController extends Controller
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
        $data['added_by']=auth()->user()->added_by;
        $truck= TruckCarbon::create($data);
$supp=Truck::find($truck->truck_id);

$dr= AccountCodes::where('account_name','CARBON')->where('added_by',auth()->user()->added_by)->first();
$journal = new JournalEntry();
  $journal->account_id = $dr->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
$journal->transaction_type = 'truck_carbon';
  $journal->name = 'Truck CARBON';
  $journal->debit = $truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->officer ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck CARBON for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();



  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'truck_carbon';
  $journal->name = 'Truck CARBON';
  $journal->credit =$truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->officer ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck CARBON for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();
  
  
        return redirect(route('truck.carbon', $request->truck_id))->with(['success'=>"Truck CARBON Created Successfully",'type'=>"carbon"]);
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
        $data =  TruckCarbon::find($id);      
        $truck=  Truck::where('id',$data->truck_id)->first();
        $type = "edit-carbon";
          $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        return view('truck.carbon',compact('data','id','type','truck','client'));
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
        $truck= TruckCarbon::find($id);   

        $data = $request->all();   
        $data['added_by']=auth()->user()->added_by;

       
        $truck->update($data);

$supp=Truck::find($truck->truck_id);
       $dr= AccountCodes::where('account_name','CARBON')->where('added_by',auth()->user()->added_by)->first();
$journal = JournalEntry::where('transaction_type','truck_carbon')->where('income_id', $truck->id)->whereNotNull('debit')->first();
  $journal->account_id = $dr->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
$journal->transaction_type = 'truck_carbon';
  $journal->name = 'Truck CARBON';
  $journal->debit = $truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->officer ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck CARBON for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
 $journal->update();



  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
 $journal = JournalEntry::where('transaction_type','truck_carbon')->where('income_id', $truck->id)->whereNotNull('credit')->first();
  $journal->account_id = $codes->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'truck_carbon';
  $journal->name = 'Truck CARBON';
  $journal->credit =$truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->officer ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck CARBON for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
 $journal->update();
  
 
        return redirect(route('truck.carbon', $request->truck_id))->with(['success'=>"Truck CARBON Updated Successfully",'type'=>"carbon'"]);
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
        $truck= TruckCarbon::find($id);
         $a=$truck->truck_id;
       JournalEntry::where('transaction_type','truck_carbon')->where('income_id', $id)->delete();
        $truck->delete();
        return redirect(route('truck.carbon',$a))->with(['success'=>"Truck CARBON Deleted Successfully",'type'=>"carbon"]);
    }
}
