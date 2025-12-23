<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll\SalaryAllowance;
use App\Models\Departments;
use App\Models\Payroll\SalaryDeduction;
use App\Models\Payroll\SalaryTemplate;
use App\Models\Payroll\EmployeePayroll;
use App\Models\Payroll\SalaryPayment;
use App\Models\Payroll\SalaryPaymentDetails;
use App\Models\Payroll\SalaryPaymentAllowance;
use App\Models\Payroll\SalaryPaymentDeduction;
use App\Models\UserDetails\BasicDetails;
//use App\Models\Payroll\Accounts;
use App\Models\Payroll\Overtime;
use App\Models\Payroll\AdvanceSalary;
use App\Models\Payroll\EmployeeLoan;
use App\Models\Payroll\EmployeeLoanReturn;
use App\Models\Payroll\PayrollActivity;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;
use DateTime;

class EmployeeLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $user=auth()->user()->id;
            $employee_loan=EmployeeLoan::all();
             $user_employee_loan=EmployeeLoan::where('user_id',$user)->get();
             $all_employee=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();   
              $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->orwhere('account_name','VICOBA')->where('added_by',auth()->user()->added_by)->get();
 return view('payroll.employee_loan',compact('all_employee','employee_loan','user_employee_loan','bank_accounts'));
       
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

  

         $data['user_id']=$request->user_id;
        $data['loan_amount']=$request->loan_amount;
      $data['paid_amount']=$request->paid_amount;
        $data['deduct_month']=$request->deduct_month;
        $data['reason']=$request->reason;
        $data['bank_id']=$request->bank_id;
       if(!empty($request->approve)){
        $data['status']='1';
    $data['approve_by']=auth()->user()->added_by;
$st="Approved";
}
       else{
        $data['status']='0';
$st="Created";
}
        $data['added_by']=auth()->user()->added_by;


$loan_amount=$request->loan_amount;
$paid=$request->paid_amount;
        $num=$loan_amount/$paid;

        if(is_float($num)){
        $intpart=floor($num);
         $data['returns']= $intpart + 1;
       }
      else{
         $data['returns']=$num;
}


        $loan=EmployeeLoan::create($data);


     $date = new DateTime($request->deduct_month . '-01');
       $loan_due_date = $date->format('Y-m-d');
      $b=0;

  if(is_float($num)){
        $intpart=floor($num);
        for($i = 0; $i < $intpart; $i++){
            if(!empty($intpart)){
                   $b++;
                $items = array(
                    'loan_amount' =>$request->paid_amount,
                    'loan_id' =>   $loan->id,
                     'status' =>   $loan->status,
                    'user_id' =>$request->user_id,
                     'deduct_month' => date('Y-m', strtotime("+$i months", strtotime($loan_due_date))) 
                             );
                     EmployeeLoanReturn::create($items);  

                
            }
        }

$rem=$loan_amount - ($intpart * $paid);
$m= $intpart;
          if($rem > 0){     
                $gl['loan_amount'] =  $rem;
                 $gl['loan_id'] = $loan->id;
                $gl['status'] =  $loan->status;
                 $gl['user_id'] = $request->user_id;
                 $gl['deduct_month'] =date('Y-m', strtotime("+$m months", strtotime($loan_due_date)));
          EmployeeLoanReturn::create($gl);  
    }             
       }


      else{

   for($i = 0; $i < $num; $i++){
            if(!empty($num)){
                  $b++;
                $items = array(
                    'loan_amount' =>$request->paid_amount,
                    'loan_id' =>   $loan->id,
                     'status' =>   $loan->status,
                    'user_id' =>$request->user_id,
                     'deduct_month' => date('Y-m', strtotime("+$i months", strtotime($loan_due_date))) 
                             );
                     EmployeeLoanReturn::create($items);  
                
            }
        }
        
}
     

 $emp_info = User::find($request->user_id);
 $dl=EmployeeLoan::find($loan->id);

if(!empty($request->approve)){

  $empl_loan=AccountCodes::where('account_name','Employee Loan')->where('added_by', auth()->user()->added_by)->first();   
          $journal = new JournalEntry();
        $journal->account_id = $empl_loan->id;
          $journal->user_id=$request->user_id ;
         $date = explode('-', $dl->request_date);
        $journal->date =   $dl->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'employee_loan';
        $journal->name = 'Employee Loan ';
        $journal->debit= $loan->loan_amount;
        $journal->payment_id= $loan->id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Loan to " .$emp_info->name ;
        $journal->save();
          
         $journal = new JournalEntry();
        $journal->account_id =   $request->bank_id;;
          $journal->user_id=$request->user_id ;
         $date = explode('-', $dl->request_date);
        $journal->date =   $dl->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'employee_loan';
        $journal->name = 'Employee Loan ';
        $journal->credit= $loan->loan_amount;
        $journal->payment_id= $loan->id;        
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Loan  to " .$emp_info->name ;
        $journal->save();
        

$bank_accounts=AccountCodes::where('id',$request->bank_id)->where('added_by',auth()->user()->added_by)->first() ;
if($bank_accounts->account_group == 'Cash and Cash Equivalent'){
$account= Accounts::where('account_id',$request->bank_id)->first();
 if(!empty($account)){
        $balance=$account->balance - $request->loan_amount ;
        $item_to['balance']=$balance;
        $account->update($item_to);
        }
        
        else{
          $cr= AccountCodes::where('id',$request->bank_id)->first();
        
             $new['account_id']= $request->bank_id;
               $new['account_name']= $cr->account_name;
              $new['balance']= 0-$request->loan_amount;
               $new[' exchange_code']='TZS';
                $new['added_by']=auth()->user()->added_by;
        $balance=0-$request->loan_amount;
             Accounts::create($new);
        }
                
           // save into tbl_transaction
        
                                     $transaction= Transaction::create([
                                        'module' => 'Employee Loan',
                                         'module_id' => $loan->id,
                                       'account_id' => $request->bank_id,
                                        'code_id' => $empl_loan->id,
                                        'name' => 'Employee Loan to ' .$emp_info->name,
                                        'type' => 'Expense',                               
                                        'amount' =>$request->loan_amount ,
                                        'credit' => $request->loan_amount,
                                         'total_balance' =>$balance,
                                          'date' => date('Y-m-d', strtotime($loan->request_date)),
                                           'status' => 'paid' ,
                                        'notes' => 'Employee Loan to ' .$emp_info->name,
                                        'user_id' => $request->user_id ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);
}

}



if(!empty($loan)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $loan->id,
                            'module'=>'Employee Loan',
                            'activity'=>"Employee Loan to " .$emp_info->name. " is ".$st,
                        ]
                        );                      
       }

 return redirect(route('employee_loan.index'))->with(['success'=>'Employee Loan Created Successfully']);

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
      $data=EmployeeLoan::find($id);
             $all_employee=User::where('added_by',auth()->user()->added_by)->where('disabled','0')->get();
             
         $bank_accounts=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->orwhere('account_name','VICOBA')->where('added_by',auth()->user()->added_by)->get();
 return view('payroll.employee_loan',compact('all_employee','data','id','bank_accounts'));
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
          $loan=EmployeeLoan::find($id);

     $data['user_id']=$request->user_id;
        $data['loan_amount']=$request->loan_amount;
      $data['paid_amount']=$request->paid_amount;
        $data['deduct_month']=$request->deduct_month;
        $data['reason']=$request->reason;

       if(!empty($request->approve)){
        $data['status']='1';
    $data['approve_by']=auth()->user()->added_by;
$st="Approved";

$bank_accounts=AccountCodes::where('id',$request->bank_id)->where('added_by',auth()->user()->added_by)->first() ;
if($bank_accounts->account_group == 'Cash and Cash Equivalent'){

                if($loan->bank_id == $request->bank_id){

               $old_account= Accounts::where('account_id',$request->bank_id)->first();
if(!empty($old_account)){

      if( $loan->loan_amount <= $request->loan_amount){
                    $diff=$request->adavance_amount-$loan->loan_amount;
                    $balance=  $old_account->balance - $diff;
                }

                if($loan->loan_amount > $request->loan_amount){
                    $diff=$loan->loan_amount - $request->loan_amount;
                $balance =   $old_account->balance + $diff;
                }

$item['balance']=$balance;
$old_account->update($item);
}
}

else{

$x_account= Accounts::where('account_id',$loan->bank_id)->first();

if(!empty($x_account)){
$x_balance=$x_account->balance + $loan->loan_amount;
$x_item['balance']=$x_balance;
$x_account->update($x_item);
}


$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance - $request->loan_amount;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']=$request->bank_id;;
       $new['account_name']= $cr->account_name;
      $new['balance']=0-$request->loan_amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$request->loan_amount;
     Accounts::create($new);
}

}

}

}
       else{
        $data['status']='0';
$st="Updated";
}
     


$loan_amount=$request->loan_amount;
$paid=$request->paid_amount;
        $num=$loan_amount/$paid;

        if(is_float($num)){
        $intpart=floor($num);
         $data['returns']= $intpart + 1;
       }
      else{
         $data['returns']=$num;
}


        $loan->update($data);


     $date = new DateTime($request->deduct_month . '-01');
       $loan_due_date = $date->format('Y-m-d');
      $b=0;

     EmployeeLoanReturn::where('loan_id',$id)->delete();

  if(is_float($num)){
        $intpart=floor($num);
        for($i = 0; $i < $intpart; $i++){
            if(!empty($intpart)){
                   $b++;
                $items = array(
                    'loan_amount' =>$request->paid_amount,
                    'loan_id' =>   $loan->id,
                     'status' =>   $loan->status,
                    'user_id' =>$request->user_id,
                     'deduct_month' => date('Y-m', strtotime("+$i months", strtotime($loan_due_date))) 
                             );
                     EmployeeLoanReturn::create($items);  

                
            }
        }

$rem=$loan_amount - ($intpart * $paid);
$m= $intpart;
          if($rem > 0){     
                $gl['loan_amount'] =  $rem;
                 $gl['loan_id'] = $loan->id;
                $gl['status'] = $loan->status;;
                 $gl['user_id'] = $request->user_id;
                 $gl['deduct_month'] =date('Y-m', strtotime("+$m months", strtotime($loan_due_date)));
          EmployeeLoanReturn::create($gl);  
    }             
       }


      else{

   for($i = 0; $i < $num; $i++){
            if(!empty($num)){
                  $b++;
                $items = array(
                    'loan_amount' =>$request->paid_amount,
                    'loan_id' =>   $loan->id,
                     'status' =>   $loan->status,
                    'user_id' =>$request->user_id,
                     'deduct_month' => date('Y-m', strtotime("+$i months", strtotime($loan_due_date))) 
                             );
                     EmployeeLoanReturn::create($items);  
                
            }
        }
        
}
     
 $emp_info = User::find($request->user_id);




if(!empty($request->approve)){

  $empl_loan=AccountCodes::where('account_name','Employee Loan')->where('added_by', auth()->user()->added_by)->first();   
         $journal = JournalEntry::where('payment_id',$id )->where('transaction_type', 'employee_loan')->whereNotNull('debit')->first();;
        $journal->account_id = $empl_loan->id;
          $journal->user_id=$request->user_id ;
         $date = explode('-', $loan->request_date);
        $journal->date =   $loan->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'employee_loan';
        $journal->name = 'Employee Loan ';
        $journal->debit= $loan->loan_amount;
        $journal->payment_id= $loan->id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Loan to " .$emp_info->name ;
        $journal->update();
          
        $journal = JournalEntry::where('payment_id',$id )->where('transaction_type', 'employee_loan')->whereNotNull('credit')->first();;
        $journal->account_id =   $request->bank_id;;
          $journal->user_id=$request->user_id ;
         $date = explode('-', $loan->request_date);
        $journal->date =   $loan->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'employee_loan';
        $journal->name = 'Employee Loan ';
        $journal->credit= $loan->loan_amount;
        $journal->payment_id= $loan->id;        
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Loan  to " .$emp_info->name ;
        $journal->update();



                
           // save into tbl_transaction
        
if($bank_accounts->type == 'Bank'){                         
                                         $transaction= Transaction::where('module','Employee Loan')->where('module_id',$id)->update([
                                        'module' => 'Employee Loan',
                                         'module_id' => $id,
                                       'account_id' => $request->bank_id,
                                        'code_id' => $empl_loan->id,
                                        'name' => 'Employee Loan to ' .$emp_info->name,
                                        'type' => 'Expense',                               
                                        'amount' =>$request->loan_amount ,
                                        'credit' => $request->loan_amount,
                                         'total_balance' =>$balance,
                                          'date' => date('Y-m-d', strtotime($loan->request_date)),
                                           'status' => 'paid' ,
                                        'notes' => 'Employee Loan to ' .$emp_info->name,
                                        'user_id' => $request->user_id ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);

}

}


if(!empty($loan)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $loan->id,
                            'module'=>'Employee Loan',
                            'activity'=>"Employee Loan to " .$emp_info->name. " is " .$st,
                        ]
                        );                      
       }

 return redirect(route('employee_loan.index'))->with(['success'=>'Employee Loan Updated Successfully']);
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
    }



 public function findLoan(Request $request)
    {
 
$user_id=$request->user;



  $employee_info  = EmployeePayroll::where('user_id', $user_id)->first();
 if (!empty( $employee_info)) {

$loan= EmployeeLoan::where('user_id',$user_id)->where('status', '!=', '4')->first();

                    if (!empty($loan)) {
              
$price="You have already applied for loan . Please pay loan before you apply for another loan. " ;

}
else{
$price='' ;
 }


}
else{
$price="You can not apply for Loan . Please set your Salary Grade . " ;
}



                return response()->json($price);                      
 
    }

public function findMonth(Request $request)
    {
 
$user_id=$request->user;

  $employee_info  = EmployeePayroll::where('user_id', $user_id)->first();
 if (!empty( $employee_info)) {

$payment= SalaryPayment::where('user_id',$user_id)->where('payment_month', $request->id)->first();
  $user_info=EmployeePayroll::leftJoin('users', 'users.id','tbl_employee_payroll.user_id')
               ->where('tbl_employee_payroll.user_id', $user_id)
               ->where('users.joining_date', '>=', $request->id)   
            ->select('users.*','tbl_employee_payroll.*')
        ->get();

                    if (!empty($payment)) {
              
$price="You can not apply for this month. Salary Already paid. Please choose a different month " ;

}

  else if (!empty($user_info[0])) {
              
$price="You can not apply for the month before you joined.  Please choose a different month " ;
}
else{
$price='' ;
 }

}

else{
$price="You can not apply for Loan . Please set your Salary Grade . " ;
}

                return response()->json($price);                      
 
    }

public function reject($id)
   {
       //
      $loan= EmployeeLoan::find($id);
       $data['status'] = 2;
       $loan->update($data);

     $emp_info = User::find($loan->user_id);


if(!empty($loan)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $loan->id,
                            'module'=>'Employee Loan',
                            'activity'=>"Employee Loan to " .$emp_info->name. " is rejected",
                        ]
                        );                      
       }

       return redirect(route('employee_loan.index'))->with(['success'=>'Rejected Successfully']);
   }

public function approve($id)
   {
       //
       $loan= EmployeeLoan::find($id);
       $data['status'] = 1;
        $data['approve_by']=auth()->user()->added_by;
       $loan->update($data);

 $emp_info = User::find($loan->user_id);


$empl_loan=AccountCodes::where('account_name','Employee Loan')->where('added_by', auth()->user()->added_by)->first();   
          $journal = new JournalEntry();
        $journal->account_id = $empl_loan->id;
          $journal->user_id=$loan->user_id ;
         $date = explode('-', $loan->request_date);
        $journal->date =   $loan->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'employee_loan';
        $journal->name = 'Employee Loan ';
        $journal->debit= $loan->loan_amount;
        $journal->payment_id= $loan->id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Loan to " .$emp_info->name ;
        $journal->save();
          
         $journal = new JournalEntry();
        $journal->account_id =   $loan->bank_id;;
          $journal->user_id=$loan->user_id ;
         $date = explode('-', $loan->request_date);
        $journal->date =   $loan->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'employee_loan';
        $journal->name = 'Employee Loan ';
        $journal->credit= $loan->loan_amount;
        $journal->payment_id= $loan->id;        
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Loan  to " .$emp_info->name ;
        $journal->save();

$bank_accounts=AccountCodes::where('id',$loan->bank_id)->where('added_by',auth()->user()->added_by)->first() ;
if($bank_accounts->account_group == 'Cash and Cash Equivalent'){
$account= Accounts::where('account_id',$loan->bank_id)->first();
 if(!empty($account)){
        $balance=$account->balance - $loan->loan_amount ;
        $item_to['balance']=$balance;
        $account->update($item_to);
        }
        
        else{
          $cr= AccountCodes::where('id',$loan->bank_id)->first();
        
             $new['account_id']= $loan->bank_id;
               $new['account_name']= $cr->account_name;
              $new['balance']= 0-$request->loan_amount;
               $new[' exchange_code']='TZS';
                $new['added_by']=auth()->user()->added_by;
        $balance=0-$request->loan_amount;
             Accounts::create($new);
        }
                
           // save into tbl_transaction
        
                                     $transaction= Transaction::create([
                                        'module' => 'Employee Loan',
                                         'module_id' => $loan->id,
                                       'account_id' => $loan->bank_id,
                                        'code_id' => $empl_loan->id,
                                        'name' => 'Employee Loan to ' .$emp_info->name,
                                        'type' => 'Expense',                               
                                        'amount' =>$loan->loan_amount ,
                                        'credit' => $loan->loan_amount,
                                         'total_balance' =>$balance,
                                          'date' => date('Y-m-d', strtotime($loan->request_date)),
                                           'status' => 'paid' ,
                                        'notes' => 'Employee Loan to ' .$emp_info->name,
                                        'user_id' => $loan->user_id ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);

}


if(!empty($loan)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $loan->id,
                            'module'=>'Employee Loan',
                            'activity'=>"Employee Loan to " .$emp_info->name. " is approved",
                        ]
                        );                      
       }
       return redirect(route('employee_loan.index'))->with(['success'=>'Approved Successfully']);
   }
   

}
