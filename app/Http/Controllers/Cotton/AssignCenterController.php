<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\Expenses;
use App\Models\Accounts;
use App\Models\Cotton\AssignCenter;
use App\Models\Cotton\ReverseAssignCenter;
use App\Models\Driver;
use App\Models\Cotton\TopUpOperator;
use App\Models\Cotton\TopUpCenter;
use App\Models\Cotton\ReverseTopUpCenter;
use App\Models\Cotton\CollectionCenter;
use App\Models\Cotton\CottonMovement;
use App\Models\Cotton\CottonItemMovement;
use App\Models\Cotton\CottonLevyMovement; ;;
use App\Models\Cotton\CottonHistory;
use App\Models\Cotton\Operator;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Models\JournalEntry;
use App\Http\Requests;
use App\Models\Currency;
use App\Models\Payment_methodes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;

class AssignCenterController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
      $transfer=AssignCenter::all();
$driver=CollectionCenter::where('head','!=','1')->get(); ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
        return view('cotton.assign_center', compact('payment_method','transfer','currency','driver'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         $data=$request->post();
          $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);
         $data['reference'] = "AD_".$random;
         $data['due_amount'] =$request->amount;
        $data['added_by']=auth()->user()->id;
       $transfer=AssignCenter::create($data);
     return redirect(route('assign_center.index'))->with(['success'=>' Created Successfully']);


     
        }
   

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
         $data=AssignCenter::find($id);
 $driver=CollectionCenter::where('head','!=','1')->get(); ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
        return View::make('cotton.assign_center', compact('data','currency','payment_method','id','driver'))->render();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
          $transfer= AssignCenter::find($id);

         $data=$request->post();
       $data['due_amount'] =$request->amount;
      $transfer->update($data);
     return redirect(route('assign_center.index'))->with(['success'=>' Updated Successfully']);


     
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
     AssignCenter::destroy($id);
     
   return redirect(route('assign_driver.index'))->with(['success'=>'Deleted Successfully']);
    }



     public function approve($id)
    {
        //
        $transfer= AssignCenter::find($id);
        $data['status'] = 1;
        $data['approve_by']=auth()->user()->id;
        $transfer->update($data);


   $dr= AccountCodes::where('account_name','Collection Center Account')->first();
   $cr= AccountCodes::where('account_name','Equipment')->first();
  $driver=CollectionCenter::where('id',$transfer->driver_id)->first();

        $journal = new JournalEntry();
        $journal->account_id = $dr->id;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'assign_center';
        $journal->name = 'Assign Equipment to Center';
        $journal->income_id =    $transfer->id;
       $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
         $journal->notes='Assign Equipment to Center '.$driver->name;
        $journal->debit=     $transfer->amount;
          $journal->added_by=auth()->user()->id;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $cr->id;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
     $journal->transaction_type = 'assign_center';
        $journal->name = 'Assign Equipment to Center';
        $journal->income_id =    $transfer->id;
       $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
         $journal->notes='Assign Equipment to Center '.$driver->name;
        $journal->credit=    $transfer->amount;
       $journal->added_by=auth()->user()->id;
        $journal->save();
    
       


      

        return redirect(route('assign_center.index'))->with(['success'=>'Approved Successfully']);
    }

   public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
                if($type == 'center'){
                $payment_method= Payment_methodes::all();
               return view('cotton.addReversedCenter',compact('id','payment_method'));
     }          
       elseif($type='quantity'){
       $movement= CottonHistory::where('location',$id)->get();
               return view('cotton.center_quantity',compact('id','movement'));
}
  elseif($type='driver'){
       $movement= AssignDriver::find($id);
               return view('cotton.addReversedDriver',compact('id','movement'));
}
   }


 public function newdiscount(Request $request)
    {
        //
        $transfer= AssignCenter::find($request->id);
   $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);

$item['driver_id']=$transfer->driver_id;
$item['due_amount']=$request->amount;
$item['amount']=$request->amount;
$item['exchange_code']=$transfer->exchange_code;
$item['exchange_rate']=$transfer->exchange_rate;
$item['notes']=$request->notes;
$item['date']=$request->date;
$item['status']='1';
 $item['approve_by']=auth()->user()->id;
 $item['added_by']=auth()->user()->id;
$item['assign_id']=$request->id;
$item['assign_reference']=$transfer->reference_no;
$item['reference']=$request->reference_no;
$rev=ReverseAssignCenter::create($item);

      



 $cr= AccountCodes::where('account_name','Collection Center Account')->first();
   $dr= AccountCodes::where('account_name','Equipment')->first();
  $driver=CollectionCenter::where('id',$transfer->driver_id)->first();

        $journal = new JournalEntry();
        $journal->account_id = $dr->id;
        $date = explode('-',  $request->date);
        $journal->date = $request->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'reverse_assign_center';
        $journal->name = 'Reverse Assign Equipment to Center';
        $journal->income_id =    $rev->id;
       $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
         $journal->notes='Reverse Assignment From Center '.$driver->name;
        $journal->debit=     $request->amount;
        $journal->added_by=auth()->user()->id;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $cr->id;
         $date = explode('-',  $request->date);
        $journal->date = $request->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'reverse_assign_center';
        $journal->name = 'Reverse Assign Equipment to Center';
        $journal->income_id =    $rev->id;
       $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
         $journal->notes='Reverse Assignment From Center '.$driver->name;
        $journal->credit=    $request->amount;
 $journal->added_by=auth()->user()->id;
        $journal->save();
    
       


        $data['due_amount'] = $transfer->amount - $request->amount;
     $data['reversed']='1';
        $transfer->update($data);

        return redirect(route('assign_center.index'))->with(['success'=>'Reversed Successfully']);
    }
   

 public function complete($id)
    {
        //
        $transfer= TopUpCenter::find($id);
        $data['status'] = 2;
        $transfer->update($data);

        return redirect(route('top_up_center.index'))->with(['success'=>'Transaction Completed Successfully']);
    }


 public function reverse_assign_center()
    {
      
     $transfer=ReverseAssignCenter::all();
  $driver=Driver::all() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
        return view('cotton.reverse_assign_center', compact('payment_method','transfer','currency','driver'));
    }
    public function complete_center()
    {
      
      $transfer=TopUpCenter::where('status','2')->get();
  $operator=Operator::all() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
        return view('cotton.complete_center', compact('payment_method','transfer','currency','operator'));
    }

}
