<?php

namespace App\Http\Controllers\Fuel;

use App\Http\Controllers\Controller;
use App\Models\AccountCodes;
use App\Models\Fuel\Fuel;
use App\Models\Fuel\Refill;
use App\Models\Fuel\RefillPayment;
use App\Models\Supplier;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\Route;
use App\Models\User;
use App\Models\Region;
use App\Models\District;
use App\Models\Truck;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\Payment_methodes;
use  DateTime;

class FuelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $truck = Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get();
        $route=Route::where('added_by',auth()->user()->added_by)->get();      
       $fuel = Fuel::where('added_by',auth()->user()->added_by)->where('fuel_used','>','0')->orderBy('date', 'desc')->get(); 
        $refill=Refill::where('added_by',auth()->user()->added_by)->get(); 
$region = Region::all();   
         $staff=User::where('added_by',auth()->user()->added_by)->get(); 
        return view('fuel.fuel',compact('truck','route','fuel','refill','region','staff'));
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
        $route=Route::where('added_by',auth()->user()->added_by)->where('id',$request->route_id)->first();
        $data['fuel_used']=$request->fuel_used;;
        $data['due_fuel']=$request->fuel_used;;
        $data['added_by']=auth()->user()->added_by;
        $fuel= Fuel::create($data);


      
 
        return redirect(route('fuel.index'))->with(['success'=>'Fuel Created Successfully']);
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

    public function discountModal(Request $request)
    {
                 $id=$request->id;
                 $type = $request->type;

                 $supplier=Supplier::where('user_id',auth()->user()->added_by)->get() ;
                $bank_accounts=AccountCodes::where('added_by',auth()->user()->added_by)->where('account_status','Bank')->get() ;
                 if($type == 'refill'){
                    return view('fuel.addrefill',compact('id','bank_accounts','supplier'));
                
                 }elseif($type == 'adjustment'){
                    $data =  Fuel::find($id);
                 return view('fuel.addadjustment',compact('id','data'));  
                 }
                 else if($type == 'edit_refill'){
                      $data=Refill::find($id);
                    return view('fuel.editrefill',compact('id','supplier','data'));
                
                 }

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
        $data =  Fuel::find($id);
         $truck = Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get();
        $route=Route::where('added_by',auth()->user()->added_by)->get();    
   $region = Region::all();  
  $refill=Refill::where('added_by',auth()->user()->added_by)->get(); 
      $staff=User::where('added_by',auth()->user()->added_by)->get();  
        return view('fuel.fuel',compact('truck','route','data','id','region','refill','staff'));
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
        $fuel=  Fuel::find($id);

        if($request->type == 'adjustment'){
            $adjust =  Fuel::find($id);
            $item['fuel_adjustment']=$request->fuel_adjustment;
            $item['reason']=$request->reason;
            $item['status_approve']='0';
            $adjust->update($item);

            return redirect(route('fuel.index'))->with(['success'=>'Fuel Adjustment Updated Successfully']);

        }

        if($request->type == 'refill'){
        $receipt = $request->all();
        $sales =Fuel::find($id);
      
      
        if(($receipt['litres'] <= $sales->due_fuel)){
            if($receipt['litres'] >= 0){
                $receipt['truck'] = $sales->truck_id;
                $receipt['route'] = $sales->route_id;
                $receipt['total_cost'] = $request->price ;
               $receipt['due_cost'] = $request->price ;
               $receipt['status'] = '0' ;
               $receipt['price'] = $request->price / $request->litres;
                $receipt['fuel_id'] = $id;
                $receipt['added_by'] = auth()->user()->added_by;
                
                //update due amount from invoice table
                $data['due_fuel'] =  $sales->due_fuel-$receipt['litres'];              
                $sales->update($data);
                $refill = Refill::create($receipt);

           $t=Truck::find($sales->truck_id);
             $account= AccountCodes::where('account_name','Fuel')->where('added_by',auth()->user()->added_by)->first();
$bank= AccountCodes::where('added_by',auth()->user()->added_by)->where('account_name','Payables')->first();
 $supp = Supplier::find($refill->supplier);

             if($refill->payment_type == 'cash'){  

             $sales =Refill::find($refill->id);
            $method= Payment_methodes::where('name','Cash')->first();

               $receipt['trans_id'] = "TRFL".$refill->id.substr(str_shuffle(1234567890), 0, 4);
                $receipt['added_by'] = auth()->user()->added_by;
                 $receipt['fuel_id'] =$sales->fuel_id;
                $receipt['refill_id'] =$refill->id;
                 $receipt['supplier_id'] =$refill->supplier;
               $receipt['amount'] = $sales->total_cost;
                $receipt['date'] = $sales->date;
                 $receipt['payment_method'] = $method->id;
                  $receipt['account_id'] =$request->account_id;

                //update due amount from invoice table
                 $b['due_cost'] =  0;
               $b['status'] = 2;              
                $sales->update($b);
                 
                $payment = RefillPayment::create($receipt);



                $journal = new JournalEntry();
        $journal->account_id =     $account->id ;;
    $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
         $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill';
             $journal->income_id=    $refill->id;;
           $journal->truck_id= $refill->truck;
              $journal->supplier_id= $refill->supplier;
              $journal->notes= 'Fuel Refill On Cash Payment to Supplier ' . $supp->name.' for Truck '.$t->truck_name. ' - '. $t->reg_no;
        $journal->added_by= auth()->user()->added_by;;
        $journal->debit =   $refill->total_cost ;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $bank->id;;
        $date = explode('-',  $refill->date);
         $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
        $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill';
             $journal->income_id=    $refill->id;;
           $journal->truck_id= $refill->truck;
              $journal->supplier_id= $refill->supplier;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Fuel Refill On Cash Payment to Supplier ' . $supp->name.' for Truck '.$t->truck_name. ' - '. $t->reg_no;
        $journal->save();
          

                $journal = new JournalEntry();
              $journal->account_id = $bank->id;;;
              $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
             $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Payment';
              $journal->debit = $refill->total_cost ;
       $journal->truck_id= $sales->truck_id;
           $journal->supplier_id= $refill->supplier;
              $journal->payment_id= $payment->id;
        $journal->added_by=auth()->user()->added_by;
               $journal->notes= 'Payment for Fuel Refill to Supplier ' . $supp->name.' for Truck '.$t->truck_name. ' - '. $t->reg_no;
              $journal->save();
      
      

              $journal = new JournalEntry();
              $journal->account_id = $request->account_id;
              $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
             $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Payment';
              $journal->credit =$refill->total_cost ;
              $journal->truck_id= $sales->truck_id;
             $journal->supplier_id= $refill->supplier;
              $journal->payment_id= $payment->id;
               $journal->added_by=auth()->user()->added_by;
                 $journal->notes= 'Payment for Fuel Refill to Supplier ' . $supp->name.' for Truck '.$t->truck_name. ' - '. $t->reg_no;
              $journal->save();

$bank_account= Accounts::where('added_by',auth()->user()->added_by)->where('account_id',$request->account_id)->first();
        if(!empty($bank_account)){
$balance=$bank_account->balance - $refill->total_cost ;
$item_to['balance']=$balance;
$bank_account->update($item_to);
}

else{
  $cr= AccountCodes::where('added_by',auth()->user()->added_by)->where('id',$request->account_id)->first();

     $new['account_id']= $request->account_id;
       $new['account_name']= $cr->account_name;
      $new['balance']= 0-$refill->total_cost;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$refill->total_cost;
     Accounts::create($new);
}
        
   // save into tbl_transaction
                            $transaction= Transaction::create([
                                'module' => 'Fuel Refill Paymnet',
                                 'module_id' => $refill->id,
                               'account_id' => $request->account_id,
                                'code_id' => $bank->id,
                                'name' => 'Fuel Refill Payment for truck ' .$t->reg_no,
                                'type' => 'Expense',
                                'amount' =>$refill->total_cost,
                                'debit' => $refill->total_cost,
                                 'total_balance' =>$balance,
                                'date' => date('Y-m-d'),
                                   'status' => 'paid' ,
                                'notes' => 'This expense is from fuel refill payment. Payment to Truck '.$t->reg_no ,
                                'added_by' =>auth()->user()->added_by,
                            ]);
                              

}

    else if($refill->payment_type == 'credit'){



  $journal = new JournalEntry();
        $journal->account_id =     $account->id ;;
    $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
         $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Credit';
             $journal->income_id=    $refill->id;;
           $journal->truck_id= $refill->truck;
              $journal->supplier_id= $refill->supplier;
              $journal->notes= 'Fuel Refill On Credit Payment to Supplier ' . $supp->name.' for Truck '.$t->truck_name. ' - '. $t->reg_no;
        $journal->added_by= auth()->user()->added_by;;
        $journal->debit =   $refill->total_cost ;
        $journal->save();

         $journal = new JournalEntry();
        $journal->account_id = $bank->id;;
        $date = explode('-',  $refill->date);
         $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
        $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Credit';
             $journal->income_id=    $refill->id;;
           $journal->truck_id= $refill->truck;
              $journal->supplier_id= $refill->supplier;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes='Fuel Refill On Credit Payment to Supplier ' . $supp->name.' for Truck '.$t->truck_name. ' - '. $t->reg_no;
        $journal->save();
}


                return redirect(route('fuel.index'))->with(['success'=>'Fuel Refill Updated Successfully']);

                
            }else{
                return redirect(route('fuel.index'))->with(['error'=>'Amount should not be equal or less to zero']);          
            }
       

        }else{
            return redirect(route('fuel.index'))->with(['error'=>'Amount should  be less than Fuel Used']);
            
        }

    }


 if($request->type == 'edit_refill'){

              $refill = Refill::find($id);
             
                 if($refill->total_cost < $request->price){
                  $due=$request->price - $refill->total_cost ;
                  $receipt['due_cost'] = $refill->due_cost +  $due ;
               if($refill->status == '2'){
                     $receipt['status'] = '1' ; 
                        }
                      else{
                          $receipt['status'] = $refill->status;
                     }


                   }

                   else if($refill->total_cost  > $request->price){
                  $due=$refill->total_cost - $request->price ;

                    if($due <= 0){
                    $receipt['due_cost'] =0;
                      $receipt['status'] = '2' ; 
                   }

                 else{
                    $receipt['due_cost'] =$refill->due_cost -  $due;
                      $receipt['status'] = $refill->status; ; 
                   } 

                   }

           else if($refill->total_cost  == $request->price){
                  $due=$refill->total_cost - $request->price ;

                    $receipt['due_cost'] =$refill->total_cost -  $due;
                      $receipt['status'] = $refill->status; ; 

                   }

                $receipt['total_cost'] = $request->price ;
                $receipt['supplier'] = $request->supplier ;
             $receipt['date'] = $request->date ;
               $receipt['price'] = $request->price / $request->litres;

                  $refill->update($receipt);

$account= AccountCodes::where('added_by',auth()->user()->added_by)->where('account_name','Fuel')->first();
$bank= AccountCodes::where('added_by',auth()->user()->added_by)->where('account_name','Payables')->first();
 $t=Truck::find($refill->truck);
  $supp = Supplier::find($refill->supplier);

$journal = JournalEntry::where('added_by',auth()->user()->added_by)->where('transaction_type','fuel')->where('income_id', $refill->id)->whereNotNull('debit')->first();
        $journal->account_id =     $account->id ;;
    $date = explode('-',$refill->date);
              $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
         $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Credit';
             $journal->income_id=    $refill->id;;
           $journal->truck_id= $refill->truck;
              $journal->supplier_id= $refill->supplier;
              $journal->notes= 'Fuel Refill On Credit Payment to Supplier ' . $supp->name.' for Truck '.$t->truck_name. ' - '. $t->reg_no;
        $journal->added_by= auth()->user()->added_by;;
        $journal->debit =   $refill->total_cost ;
        $journal->save();

        $journal = JournalEntry::where('added_by',auth()->user()->added_by)->where('transaction_type','fuel')->where('income_id', $refill->id)->whereNotNull('credit')->first();
        $journal->account_id = $bank->id;;
        $date = explode('-',  $refill->date);
         $journal->date =   $refill->date ;
              $journal->year = $date[0];
              $journal->month = $date[1];
        $journal->transaction_type = 'fuel';
              $journal->name = 'Fuel Refill Credit';
             $journal->income_id=    $refill->id;;
           $journal->truck_id= $refill->truck;
              $journal->supplier_id= $refill->supplier;
        $journal->credit =    $refill->total_cost ;;
       $journal->added_by= auth()->user()->added_by;;
      $journal->notes= 'Fuel Refill On Credit Payment to Supplier ' . $supp->name.' for Truck '.$t->truck_name. ' - '. $t->reg_no;
        $journal->save();

            return redirect(route('refill_list'))->with(['success'=>'Refill Updated Successfully']);

        }

        else{
        $data = $request->all();
        $route=Route::where('id',$request->route_id)->first();
        $data['fuel_used']=$request->fuel_used;
        $data['due_fuel']=$request->fuel_used;
        $data['added_by']=auth()->user()->added_by;
        $fuel->update($data);
        return redirect(route('fuel.index'))->with(['success'=>'Fuel Updated Successfully']);

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
    $fuel=  Fuel::find($id);

$refill=Refill::where('added_by',auth()->user()->added_by)->where('fuel_id',$id)->delete();
$fuel->delete();
 return redirect(route('fuel.index'))->with(['success'=>'Fuel Deleted Successfully']);
    }

    public function route(Request $request)
    {
        //
        $data = $request->all();
        $data['added_by']=auth()->user()->added_by;

       $from_region=Region::find($request->from_region_id);
      $to_region=Region::find($request->to_region_id);


        $specific_place = $request->depature_specific_place;      
       $arrive_place = $request->arrive_specific_place;

    
     $data['from']=$specific_place ;
     $data['to']=$arrive_place;
      $route = Route::create($data);

       
       if ($request->ajax()) {
          
           $data = Route::get(['id', 'from','to']);
           return response()->json($route);
       }
    
}
    public function approve($id)
    {
        //
        $fuel = Fuel::find($id);
        $data['status_approve'] = 1;
    $data['approved_by'] = auth()->user()->id;;
        $data['fuel_used']=$fuel->fuel_used + $fuel->fuel_adjustment;
        $data['due_fuel']=$fuel->due_fuel + $fuel->fuel_adjustment;
        $fuel->update($data);
        return redirect(route('fuel.index'))->with(['success'=>'Approved Successfully']);
    }


 public function return_fuel()
    {
        //
        $truck = Truck::where('disabled','0')->where('truck_type','Horse')->where('added_by',auth()->user()->added_by)->get();
        $route=Route::where('added_by',auth()->user()->added_by)->get();    
        //$fuel = Fuel::where('added_by',auth()->user()->added_by)->get();    
       $fuel = Fuel::where('added_by',auth()->user()->added_by)->where('fuel_used','0')->orderBy('date', 'desc')->get(); 
        $refill=Refill::where('added_by',auth()->user()->added_by)->get(); 
$region = Region::all();   
        return view('fuel.return_fuel',compact('truck','route','fuel','refill','region'));
    }

public function fuel_report(Request $request)
    {
       
        $start_date = $request->start_date;

        $date = new DateTime($start_date . '-01');
        $start= $date->modify('first day of this month')->format('Y-m-d');
        $end = $date->modify('last day of this month')->format('Y-m-d');
     
        if($request->isMethod('post')){
            $data= Fuel::where('added_by',auth()->user()->added_by)->whereBetween('date',[$start,$end])->orderBy('date', 'desc')->get();
        }else{
            $data=[];
        }

       

        return view('fuel.fuel_report',
            compact('start_date',
                'data'));
    }

public function refill_list()
    {
        //
        $fuel =Refill::where('added_by',auth()->user()->added_by)->orderBy('date', 'desc')->get();    
        return view('fuel.refill',compact('fuel'));
    }

}
