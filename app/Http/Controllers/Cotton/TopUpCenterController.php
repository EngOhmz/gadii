<?php

namespace App\Http\Controllers\Cotton;

use App\Http\Controllers\Controller;
use App\Models\ChartOfAccount;
use App\Models\GroupAccount;
use App\Models\ClassAccount;
use App\Models\AccountCodes;
use App\Models\Expenses;
use App\Models\Accounts;
use App\Models\Transaction;
use App\Models\Cotton\AssignDriver;
use App\Models\Cotton\AssignCenter;
use App\Models\Cotton\ReverseAssignDriver;
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

class TopUpCenterController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
      $transfer=TopUpCenter::where('status','0')->orwhere('status','1')->get();
  $operator=Operator::all() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
     $all_center =CollectionCenter::where('head','!=','1')->get(); ;
        return view('cotton.top_up_center', compact('payment_method','transfer','currency','operator'))->with('all_center',$all_center);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
       $group_account = GroupAccount::all();
        return view('account_codes.create', compact('group_account'));
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
         $data['reference'] = "TC_".$random;
         $data['due_amount'] =$request->amount;
        $data['added_by']=auth()->user()->id;
       $transfer=TopUpCenter::create($data);
     return redirect(route('top_up_center.index'))->with(['success'=>'Transaction Created Successfully']);


     
        }
   

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
         $data=TopUpCenter::find($id);
 $operator=Operator::all() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
    $center= CollectionCenter::where('operator_id',$data->from_account_id)->where('name','!=','Main Center')->get();
        return View::make('cotton.top_up_center', compact('data','currency','payment_method','id','operator','center'))->render();

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
       
          $transfer= TopUpCenter::find($id);

     $cr= AccountCodes::where('account_name','Petty Cash')->first();
         $data=$request->post();
       $data['due_amount'] =$request->amount;
        $data['added_by']=auth()->user()->id;
           $data['from_account_id']= $cr->id;
      $transfer->update($data);
     return redirect(route('top_up_center.index'))->with(['success'=>'Transaction Updated Successfully']);


     
 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
       TopUpCenter::destroy($id);
        //Flash::success(trans('general.successfully_deleted'));
   return redirect(route('top_up_center.index'))->with(['success'=>'Transaction Deleted Successfully']);
    }

public function findCenterName(Request $request)
    {

        $district= TopUpOperator::where('to_account_id',$request->id)->where('status','1')->where('reversed','0')->get();                                                                                    
               return response()->json($district);

}

public function findCenter(Request $request)
    {
 
$user_id=$request->user;
$account=$request->account;

$top= TopUpCenter::where('id',$user_id)->first();


      if($request->id > $top->due_amount){
      $price="You have exceeded your Balance. Choose amount less than ".  number_format($top->due_amount,2) ;

      }
      else{
      $price='' ;
      }
 


                return response()->json($price);	                  
 
    }


     public function approve($id)
    {
        //
        $transfer= TopUpCenter::find($id);
        $data['status'] = 1;
        $data['approve_by']=auth()->user()->id;
        $transfer->update($data);

$from_account= TopUpOperator::where('to_account_id',$transfer->from_account_id)->where('status', '1')->first();
if(!empty($from_account)){

$from_balance=$from_account->due_amount - $transfer->amount  ;
$item['due_amount']=$from_balance;
$from_account->update($item);
}

else{
$cash=AccountCodes::where('account_name','Cash Account')->first();
 $random = substr(str_shuffle(str_repeat($x='0123456789', ceil(4/strlen($x)) )),3,4);

           $new['reference_no'] = "auto_".$random;;
         $new['due_amount'] =0-$transfer->amount;
          $new['amount'] =0-$transfer->amount;
             $new['payment_method']=$transfer->payment_method;;
        $new['added_by']=auth()->user()->id;
               $new['approve_by']=auth()->user()->id;
            $new['status']='1';
             $new['date']=date('Y-m-d');
           $new['to_account_id']= $transfer->from_account_id;
           $new['from_account_id']= $cash->account_id;
       $top=TopUpOperator::create($new);


 $from= AccountCodes::where('id',$cash->account_id)->first();
  $to= Operator::where('id',$transfer->from_account_id)->first();

   $cr= AccountCodes::where('account_name','Operator Account')->first();

        $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',  $top->date);
        $journal->date = $top->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'operator';
        $journal->name = 'Top Up Operator';
        $journal->payment_id =    $top->id;
       $journal->currency_code =    $top->exchange_code;
        $journal->exchange_rate=   $top->exchange_rate;
        $journal->notes='Top Up From '.$from->account_name.' to Operator ' .$to->name;
        $journal->debit=     $transfer->amount;
            $journal->added_by=auth()->user()->id;
           $journal->operator_id= $transfer->from_account_id;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $cash->account_id;
       $date = explode('-',  $top->date);
        $journal->date = $top->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
         $journal->transaction_type = 'operator';
        $journal->name = 'Top Up Operator';
        $journal->payment_id =    $top->id;
         $journal->currency_code =    $top->exchange_code;
        $journal->exchange_rate=   $top->exchange_rate;
           $journal->notes='Top Up From '.$from->account_name.' to Operator ' .$to->name;
        $journal->credit=    $transfer->amount;
     $journal->operator_id= $transfer->from_account_id;
 $journal->added_by=auth()->user()->id;
        $journal->save();
    
       
$account= Accounts::where('account_id', $cash->account_id)->first();
if(!empty($account)){
$balance=$account->balance - $transfer->amount ;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id', $cash->account_id)->first();

     $new['account_id']= $transfer->from_account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$transfer->amount;
       $new[' exchange_code']=$transfer->exchange_code;
        $new['added_by']=auth()->user()->id;
$balance= 0-$transfer->amount;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Top Up Operator',
                                 'module_id' => $top->id,
                               'account_id' =>  $cash->account_id,
                                'code_id' => $cr->id,
                                'name' => 'Top Up Operator with reference  ' .$top->reference_no,
                                'type' => 'Expense',
                                'amount' =>$transfer->amount ,
                                'debit' => $transfer->amount,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d', strtotime($top->date)),
                                'payment_methods_id' =>$top->payment_method,
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from top up operator. The Reference is ' .$top->reference_no ,
                                'added_by' =>auth()->user()->id,
                            ]);
}


  $to=CollectionCenter::where('id',$transfer->to_account_id)->first();
   $dr= AccountCodes::where('account_name','Collection Center Account')->first();


  $from= Operator::where('id',$transfer->from_account_id)->first();
   $cr= AccountCodes::where('account_name','Operator Account')->first();

        $journal = new JournalEntry();
        $journal->account_id = $dr->id;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'collection';
        $journal->name = 'Top Up Collection';
        $journal->payment_id =    $transfer->id;
       $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
      $journal->center_id= $transfer->to_account_id;
         $journal->notes='Top Up From Operator '.$from->name.' to Collection Center ' .$to->name;
        $journal->debit=     $transfer->amount;
          $journal->added_by=auth()->user()->id;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $cr->id;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'collection';
        $journal->name = 'Top Up Collection';
        $journal->payment_id =    $transfer->id;
         $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
   $journal->center_id= $transfer->to_account_id;
           $journal->notes='Top Up From Operator '.$from->name.' to Collection Center ' .$to->name;
        $journal->credit=    $transfer->amount;
       $journal->added_by=auth()->user()->id;
        $journal->save();
    
       


      

        return redirect(route('top_up_center.index'))->with(['success'=>'Approved Successfully']);
    }

   public function discountModal(Request $request)
   {
                $id=$request->id;
                $type = $request->type;
                if($type == 'center'){
                $payment_method= Payment_methodes::all();
               return view('cotton.addReversedCenter',compact('id','payment_method'));
     }          
       elseif($type=='quantity'){
       $movement= CottonHistory::where('location',$id)->get();
               return view('cotton.center_quantity',compact('id','movement'));
}
         elseif($type=='driver'){
       $movement= AssignDriver::find($id);
               return view('cotton.addReversedDriver',compact('id','movement'));
}
 elseif($type=='assign'){
       $movement= AssignCenter::find($id);
               return view('cotton.addReversedAssign',compact('id','movement'));
}
   }


 public function newdiscount(Request $request)
    {
        //
        $transfer= TopUpCenter::find($request->id);
   $random = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(4/strlen($x)) )),1,4);

$item['from_account_id']=$transfer->to_account_id;
$item['to_account_id']=$transfer->from_account_id;
$item['due_amount']=$request->amount;
$item['amount']=$request->amount;
$item['exchange_code']=$transfer->exchange_code;
$item['exchange_rate']=$transfer->exchange_rate;
$item['notes']=$request->notes;
$item['date']=$request->date;
$item['status']='1';
 $item['approve_by']=auth()->user()->id;
 $item['added_by']=auth()->user()->id;
$item['top_up_id']=$request->id;
$item['top_up_reference']=$transfer->reference;
$item['payment_method']=$request->payment_method;
$item['reference']=$request->reference;

ReverseTopUpCenter::create($item);

      

$from_account= TopUpOperator::where('to_account_id',$transfer->from_account_id)->where('status', '1')->where('reversed', '0')->first();


$from_balance=$from_account->due_amount + $request->amount  ;
$it['due_amount']=$from_balance;
$from_account->update($it);


  $to=CollectionCenter::where('id',$transfer->to_account_id)->first();
 $dr= AccountCodes::where('account_name','Collection Center Account')->first();


  $from= Operator::where('id',$transfer->from_account_id)->first();
   $cr= AccountCodes::where('account_name','Operator Account')->first();


        $journal = new JournalEntry();
        $journal->account_id = $cr->id;
        $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'collection';
        $journal->name = 'Reverse Top Up Collection';
        $journal->payment_id =    $transfer->id;
       $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
         $journal->notes='Reverse Top Up From Center '.$to->name.' to Operator ' .$from->name;
        $journal->debit=     $request->amount ;
        $journal->added_by=auth()->user()->id;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =    $dr->id;
       $date = explode('-',  $transfer->date);
        $journal->date = $transfer->date;
        $journal->year = $date[0];
        $journal->month = $date[1];
          $journal->transaction_type = 'collection';
        $journal->name = 'Reverse Top Up Collection';
        $journal->payment_id =    $transfer->id;
         $journal->currency_code =    $transfer->exchange_code;
        $journal->exchange_rate=   $transfer->exchange_rate;
             $journal->notes='Reverse Top Up From Center '.$to->name.' to Operator ' .$from->name;
        $journal->credit=    $request->amount ;
 $journal->added_by=auth()->user()->id;
        $journal->save();
    
       


        $data['due_amount'] =$transfer->due_amount -$request->amount;;
     $data['reversed']='1';
        $transfer->update($data);

        return redirect(route('top_up_center.index'))->with(['success'=>'Reversed Successfully']);
    }
   

 public function complete($id)
    {
        //
        $transfer= TopUpCenter::find($id);
        $data['status'] = 2;
        $transfer->update($data);

        return redirect(route('top_up_center.index'))->with(['success'=>'Transaction Completed Successfully']);
    }


 public function reverse_top_center()
    {
      
      $transfer=ReverseTopUpCenter::all();
  $operator=Operator::all() ;
     $currency = Currency::all();
     $payment_method = Payment_methodes::all();
        return view('cotton.reverse_top_up_center', compact('payment_method','transfer','currency','operator'));
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
