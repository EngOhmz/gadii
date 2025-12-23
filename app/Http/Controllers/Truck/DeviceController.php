<?php

namespace App\Http\Controllers\Truck;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Supplier;

class DeviceController extends Controller
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
        $truck= Device::create($data);

$supp=Truck::find($truck->truck_id);

   $before=$truck->value/1.18;
    $tax=$truck->value -  $before;
 
$dr= AccountCodes::where('account_name','Tracking Device')->where('added_by',auth()->user()->added_by)->first();
$journal = new JournalEntry();
  $journal->account_id = $dr->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_device';
  $journal->name = 'Truck Device';
  $journal->debit = $before;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->broker_name ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck Device for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();

$tax_code= AccountCodes::where('account_name','VAT IN')->where('added_by',auth()->user()->added_by)->first();
$journal = new JournalEntry();
  $journal->account_id = $tax_code->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
   $journal->month = $date[1];
   $journal->transaction_type = 'truck_device';
  $journal->name = 'Truck Device';
  $journal->debit= $tax ;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->broker_name ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck Device for the truck " .$supp->truck_name ." - ". $supp->reg_no ;;
          $journal->save();

  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = new JournalEntry();
  $journal->account_id = $codes->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_device';
  $journal->name = 'Truck Device';
  $journal->credit =$truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->broker_name ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck Device for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->save();
  
        return redirect(route('truck.device', $request->truck_id))->with(['success'=>"Truck Device Created Successfully",'type'=>"device"]);
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
        $data =  Device::find($id);      
        $truck=  Truck::where('id',$data->truck_id)->first();
        $type = "edit-device";
          $client=Supplier::where('user_id', auth()->user()->added_by)->get();
        return view('truck.device',compact('data','id','type','truck','client'));
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
        $truck= Device::find($id);   

        $data = $request->all();   
        $data['added_by']=auth()->user()->added_by;
      
        $truck->update($data);
       
$before=$truck->value/1.18;
    $tax=$truck->value -  $before; 
 $supp=Truck::find($truck->truck_id);       

     $dr= AccountCodes::where('account_name','Tracking Device')->where('added_by',auth()->user()->added_by)->first();
$journal = JournalEntry::where('transaction_type','truck_device')->where('income_id', $truck->id)->whereNotNull('debit')->first();
  $journal->account_id = $dr->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_device';
  $journal->name = 'Truck Device';
  $journal->debit = $before;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->broker_name ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck Device for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->update();

$tax_code= AccountCodes::where('account_name','VAT IN')->where('added_by',auth()->user()->added_by)->first();
$journal = where('transaction_type','truck_device')->where('income_id', $truck->id)->where('account_id', $tax_code->id)->whereNotNull('debit')->first();
  $journal->account_id = $tax_code->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
   $journal->month = $date[1];
   $journal->transaction_type = 'truck_device';
  $journal->name = 'Truck Device';
  $journal->debit= $tax ;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->broker_name ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck Device for the truck " .$supp->truck_name ." - ". $supp->reg_no ;;
          $journal->save();

  $codes= AccountCodes::where('account_name','Payables')->where('added_by',auth()->user()->added_by)->first();
  $journal = JournalEntry::where('transaction_type','truck_device')->where('income_id', $truck->id)->whereNotNull('credit')->first();
  $journal->account_id = $codes->id;
  $date = explode('-',$truck->issue_date);
  $journal->date =   $truck->issue_date ;
  $journal->year = $date[0];
  $journal->month = $date[1];
  $journal->transaction_type = 'truck_device';
  $journal->name = 'Truck Device';
  $journal->credit = $truck->value;
  $journal->income_id= $truck->id;
  $journal->truck_id= $truck->truck_id;
 $journal->supplier_id  = $request->broker_name ;
  $journal->added_by=auth()->user()->added_by;
  $journal->notes= "Truck Device for the truck " .$supp->truck_name ." - ". $supp->reg_no ;
  $journal->update();
 
        return redirect(route('truck.device', $request->truck_id))->with(['success'=>"Truck Device Updated Successfully",'type'=>"device"]);
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
        $truck= Device::find($id);
         $a=$truck->truck_id;
         JournalEntry::where('transaction_type','truck_device')->where('income_id', $id)->delete();
        $truck->delete();
        return redirect(route('truck.device',  $a))->with(['success'=>"Licence Deleted Successfully",'type'=>"device"]);
    }
}
