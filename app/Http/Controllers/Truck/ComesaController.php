<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Comesa;
use App\Models\Truck;
use Illuminate\Http\Request;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Supplier;

class ComesaController extends Controller
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
        $truck= Comesa::create($data);
$supp=Truck::find($truck->truck_id);

$dr= AccountCodes::where('account_name','COMESA')->where('added_by',auth()->user()->added_by)->first();
$journal = new JournalEntry();
  $journal->account_id = $dr->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
$journal->transaction_type = 'truck_comesa';
  $journal->name = 'Truck COMESA';
  $journal->debit = $truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->officer ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck COMESA for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();



  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'truck_comesa';
  $journal->name = 'Truck COMESA';
  $journal->credit =$truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->officer ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck COMESA for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();
  
  
        return redirect(route('truck.comesa', $request->truck_id))->with(['success'=>"Truck COMESA Created Successfully",'type'=>"comesa"]);
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
        $data =  Comesa::find($id);      
        $truck=  Truck::where('id',$data->truck_id)->first();
        $type = "edit-comesa";
          $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        return view('truck.comesa',compact('data','id','type','truck','client'));
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
        $truck= Comesa::find($id);   

        $data = $request->all();   
        $data['added_by']=auth()->user()->added_by;

       
        $truck->update($data);

$supp=Truck::find($truck->truck_id);
       $dr= AccountCodes::where('account_name','COMESA')->where('added_by',auth()->user()->added_by)->first();
$journal = JournalEntry::where('transaction_type','truck_comesa')->where('income_id', $truck->id)->whereNotNull('debit')->first();
  $journal->account_id = $dr->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
$journal->transaction_type = 'truck_comesa';
  $journal->name = 'Truck COMESA';
  $journal->debit = $truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->officer ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck COMESA for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
 $journal->update();



  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
 $journal = JournalEntry::where('transaction_type','truck_comesa')->where('income_id', $truck->id)->whereNotNull('credit')->first();
  $journal->account_id = $codes->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
 $journal->transaction_type = 'truck_comesa';
  $journal->name = 'Truck COMESA';
  $journal->credit =$truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->officer ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck COMESA for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
 $journal->update();
  
 
        return redirect(route('truck.comesa', $request->truck_id))->with(['success'=>"Truck COMESA Updated Successfully",'type'=>"comesa'"]);
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
        $truck= Comesa::find($id);
         $a=$truck->truck_id;
       JournalEntry::where('transaction_type','truck_comesa')->where('income_id', $id)->delete();
        $truck->delete();
        return redirect(route('truck.comesa',$a))->with(['success'=>"Truck COMESA Deleted Successfully",'type'=>"comesa"]);
    }
}
