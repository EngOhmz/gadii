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
use App\Models\Payroll\PayrollActivity;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;
use DateTime;

class AdvanceController extends Controller
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
// active check with current month
        $current_month = date('m');
     
            $year= date('Y'); // get current year

            for ($i = 1; $i <= 12; $i++) { // query for months
                if ($i >= 1 && $i <= 9) { // if i<=9 concate with Mysql.becuase on Mysql query fast in two digit like 01.
                    $month = $year . "-" . '0' . $i;
                } else {
                    $month = $year . "-" . $i;
                }
                $advance_salary_info[$i] = AdvanceSalary::where('deduct_month',$month)->where('added_by',auth()->user()->added_by)->get();
                 $user_advance_salary_info[$i] = AdvanceSalary::where('deduct_month',$month)->where('user_id',$user)->get();
            }
       
      

 return view('payroll.advance_salary',compact('current_month','year','advance_salary_info','user_advance_salary_info'));
       
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

   if(!empty($request->type)){

         $data['user_id']=$request->user_id;
        $data['advance_amount']=$request->advance_amount;
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
    
        
        $dnew=AdvanceSalary::create($data);
        
         $advance=AdvanceSalary::find($dnew->id);

 $emp_info = User::find($request->user_id);
$month= date('F Y', strtotime($request->deduct_month)) ;


 if(!empty($request->approve)){
 $adv=AccountCodes::where('account_name','Advance Salary')->where('added_by', auth()->user()->added_by)->first();   
          $journal = new JournalEntry();
        $journal->account_id = $adv->id;
          $journal->user_id=$request->user_id ;
         $date = explode('-',  $advance->request_date);
        $journal->date = $advance->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'advance_salary';
        $journal->name = 'Advance Salary';
        $journal->debit= $request->advance_amount;
        $journal->payment_id= $advance->id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Advance Salary  to " .$emp_info->name . "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
          
         $journal = new JournalEntry();
        $journal->account_id =   $request->bank_id;;
          $journal->user_id=$request->user_id ;
         $date = explode('-',  $advance->request_date);
        $journal->date =    $advance->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'advance_salary';
        $journal->name = 'Advance Salary';
        $journal->credit=$request->advance_amount;
        $journal->payment_id= $advance->id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Advance Salary  to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();


$account= Accounts::where('account_id',$request->bank_id)->first();
 if(!empty($account)){
        $balance=$account->balance - $request->advance_amount ;
        $item_to['balance']=$balance;
        $account->update($item_to);
        }
        
        else{
          $cr= AccountCodes::where('id',$request->bank_id)->first();
        
             $new['account_id']= $request->bank_id;
               $new['account_name']= $cr->account_name;
              $new['balance']= 0-$request->advance_amount;
               $new[' exchange_code']='TZS';
                $new['added_by']=auth()->user()->added_by;
        $balance=0-$request->advance_amount;
             Accounts::create($new);
        }
                
           // save into tbl_transaction
        
                                     $transaction= Transaction::create([
                                        'module' => 'Advance Salary',
                                         'module_id' => $advance->id,
                                       'account_id' => $request->bank_id,
                                        'code_id' => $adv->id,
                                        'name' => 'Advance Salary to ' .$emp_info->name. '  for the month of '.  $month,
                                        'type' => 'Expense',                               
                                        'amount' =>$request->advance_amount ,
                                        'credit' => $request->advance_amount,
                                         'total_balance' =>$balance,
                                          'date' => date('Y-m-d', strtotime($advance->request_date)),
                                           'status' => 'paid' ,
                                        'notes' => 'Advance Salary to ' .$emp_info->name. '  for the month of '.  $month,
                                        'user_id' => $request->user_id ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);


}


if(!empty($advance)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $advance->id,
                            'module'=>'Advance Salary',
                            'activity'=>"Advance Salary to " .$emp_info->name. "  for the month ".  $month. " is ".$st,
                        ]
                        );                      
       }
    

 return redirect(route('advance_salary.index'))->with(['success'=>'Advance Salary Created Successfully']);
}

else{
// active check with current month
$user=auth()->user()->id;
        $current_month = date('m');
         if(!empty($request->year)){
         $year=$request->year;
}
else{
            $year= date('Y'); // get current year
}
            for ($i = 1; $i <= 12; $i++) { // query for months
                if ($i >= 1 && $i <= 9) { // if i<=9 concate with Mysql.becuase on Mysql query fast in two digit like 01.
                    $month = $year . "-" . '0' . $i;
                } else {
                    $month = $year . "-" . $i;
                }
                $advance_salary_info[$i] = AdvanceSalary::where('deduct_month',$month)->where('added_by',auth()->user()->added_by)->get();
             $user_advance_salary_info[$i] = AdvanceSalary::where('deduct_month',$month)->where('user_id',$user)->get();
            }
       
  }    


 return view('payroll.advance_salary',compact('current_month','year','advance_salary_info','user_advance_salary_info'));
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
 $advance=AdvanceSalary::find($id);

   $data['user_id']=$request->user_id;
        $data['advance_amount']=$request->advance_amount;
        $data['deduct_month']=$request->deduct_month;
         $data['bank_id']=$request->bank_id;
        $data['reason']=$request->reason;
        
       if(!empty($request->approve)){
        $data['status']='1';
    $data['approve_by']=auth()->user()->added_by;
$st="Approved";



                  if($advance->bank_id == $request->bank_id){

               $old_account= Accounts::where('account_id',$request->bank_id)->first();
if(!empty($old_account)){

      if( $advance->advance_amount <= $request->advance_amount){
                    $diff=$request->adavance_amount-$advance->advance_amount;
                    $balance=  $old_account->balance - $diff;
                }

                if($advance->advance_amount > $request->advance_amount){
                    $diff=$advance->advance_amount - $request->advance_amount;
                $balance =   $old_account->balance + $diff;
                }

$item['balance']=$balance;
$old_account->update($item);
}
}

else{

$x_account= Accounts::where('account_id',$advance->bank_id)->first();

if(!empty($x_account)){
$x_balance=$x_account->balance + $advance->advance_amount;
$x_item['balance']=$x_balance;
$x_account->update($x_item);
}


$account= Accounts::where('account_id',$request->bank_id)->first();

if(!empty($account)){
$balance=$account->balance - $request->advance_amount;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->bank_id)->first();

     $new['account_id']=$request->bank_id;;
       $new['account_name']= $cr->account_name;
      $new['balance']=0-$request->advance_amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$request->advance_amount;
     Accounts::create($new);
}

}



}
       else{
        $data['status']='0';
$st="Updated";
}
        $advance->update($data);

 $emp_info = User::find($request->user_id);
$month= date('F Y', strtotime($request->deduct_month)) ;


 if(!empty($request->approve)){
 $adv=AccountCodes::where('account_name','Advance Salary')->where('added_by', auth()->user()->added_by)->first();   
 $journal = JournalEntry::where('payment_id',$id )->where('transaction_type', 'advance_salary')->whereNotNull('debit')->first();;
        $journal->account_id = $adv->id;
          $journal->user_id=$request->user_id ;
         $date = explode('-',  $advance->request_date);
        $journal->date = $advance->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'advance_salary';
        $journal->name = 'Advance Salary';
        $journal->debit= $request->advance_amount;
        $journal->payment_id= $advance->id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Advance Salary  to " .$emp_info->name . "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->update();
          
         $journal = JournalEntry::where('payment_id',$id )->where('transaction_type', 'advance_salary')->whereNotNull('credit')->first();;
        $journal->account_id =   $request->bank_id;;
          $journal->user_id=$request->user_id ;
         $date = explode('-',  $advance->request_date);
        $journal->date =    $advance->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'advance_salary';
        $journal->name = 'Advance Salary';
        $journal->credit=$request->advance_amount;
        $journal->payment_id= $advance->id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Advance Salary  to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
         $journal->update();


                
           // save into tbl_transaction
                                   $transaction= Transaction::where('module','Advance Salary')->where('module_id',$id)->update([
                                        'module' => 'Advance Salary',
                                         'module_id' => $id,
                                       'account_id' => $request->bank_id,
                                        'code_id' => $adv->id,
                                        'name' => 'Advance Salary to ' .$emp_info->name. '  for the month of '.  $month,
                                        'type' => 'Expense',                               
                                        'amount' =>$request->advance_amount ,
                                        'credit' => $request->advance_amount,
                                         'total_balance' =>$balance,
                                          'date' => date('Y-m-d', strtotime($advance->request_date)),
                                           'status' => 'paid' ,
                                        'notes' => 'Advance Salary to ' .$emp_info->name. '  for the month of '.  $month,
                                        'user_id' => $request->user_id ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);


}

if(!empty($advance)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $advance->id,
                            'module'=>'Advance Salary',
                            'activity'=>"Advance Salary to " .$emp_info->name. "  for the month ".  $month. " is " .$st,
                        ]
                        );                      
       }

 return redirect(route('advance_salary.index'))->with(['success'=>'Advance Salary Updated Successfully']);
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


 public function findAmount(Request $request)
    {
 
$user_id=$request->user;



  $employee_info  = EmployeePayroll::where('user_id', $user_id)->first();
 if (!empty( $employee_info)) {
$total_deduction=0;

$deduction_info = SalaryDeduction::where('salary_template_id', $employee_info->salary_template_id)->get();

                    if (!empty($deduction_info[0])) {
                    foreach ($deduction_info as $value) {
                     $total_deduction+=$value->deduction_value;
}
}

$template=SalaryTemplate::where('salary_template_id', $employee_info->salary_template_id)->first();
$salary=$template->basic_salary-$total_deduction;

if($request->id > $salary){
$price="You have exceeded your Net Salary. Choose amount less than ".  number_format($salary,2) ;

}
else if($request->id <= 0){
$price="Choose amount less than ".  number_format($salary,2) ;

}
else{
$price='' ;
 }


}
else{
$price="You can not apply for Advance Amount . Please set your Salary Grade  " ;
}



                return response()->json($price);                      
 
    }

 public function findMonth(Request $request)
    {
 
$user_id=$request->user;

  $employee_info  = EmployeePayroll::where('user_id', $user_id)->first();
 if (!empty( $employee_info)) {

$advance_salary= AdvanceSalary::where('user_id',$user_id)->where('deduct_month', $request->id)->first();
$payment= SalaryPayment::where('user_id',$user_id)->where('payment_month', $request->id)->first();
  $user_info=EmployeePayroll::leftJoin('users', 'users.id','tbl_employee_payroll.user_id')
               ->where('tbl_employee_payroll.user_id', $user_id)
               ->where('users.joining_date', '>=', $request->id)   
            ->select('users.*','tbl_employee_payroll.*')
        ->get();

                    if (!empty($payment)) {
              
$price="You can not apply for this month. Salary Already paid. Please choose a different month " ;

}
  else if (!empty($advance_salary)) {
              
$price="You have already applied for this month . Please choose a different month " ;

}
  else if (!empty($user_info[0])) {
              
$price="You can not apply for the month before you joined.  Please choose a different month " ;
}
else{
$price='' ;
 }

}

else{
$price="You can not apply for Advance Amount . Please set your Salary Grade . " ;
}

                return response()->json($price);                      
 
    }


public function reject($id)
   {
       //
       $advance=AdvanceSalary::find($id);
       $data['status'] = 2;
       $advance->update($data);

 $emp_info = User::find($advance->user_id);
$month= date('F Y', strtotime($advance->deduct_month)) ;

if(!empty($advance)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $advance->id,
                            'module'=>'Advance Salary',
                            'activity'=>"Advance Salary to " .$emp_info->name. "  for the month ".  $month. " is rejected",
                        ]
                        );                      
       }
       return redirect(route('advance_salary.index'))->with(['success'=>'Rejected Successfully']);
   }

public function approve($id)
   {
       //
       $advance=AdvanceSalary::find($id);
       $data['status'] = 1;
        $data['approve_by']=auth()->user()->added_by;
       $advance->update($data);

 $emp_info = User::find($advance->user_id);
$month= date('F Y', strtotime($advance->deduct_month)) ;


 $adv=AccountCodes::where('account_name','Advance Salary')->where('added_by', auth()->user()->added_by)->first();   
          $journal = new JournalEntry();
        $journal->account_id = $adv->id;
          $journal->user_id=$advance->user_id ;
         $date = explode('-',  $advance->request_date);
        $journal->date = $advance->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'advance_salary';
        $journal->name = 'Advance Salary';
        $journal->debit= $advance->advance_amount;
        $journal->payment_id= $id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Advance Salary  to " .$emp_info->name . "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
          
         $journal = new JournalEntry();
        $journal->account_id =   $advance->bank_id;;
          $journal->user_id=$advance->user_id ;
         $date = explode('-',  $advance->request_date);
        $journal->date =    $advance->request_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->transaction_type = 'advance_salary';
        $journal->name = 'Advance Salary';
        $journal->credit=$advance->advance_amount;
        $journal->payment_id= $id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Advance Salary  to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();


$account= Accounts::where('account_id',$advance->bank_id)->first();
 if(!empty($account)){
        $balance=$account->balance - $advance->advance_amount ;
        $item_to['balance']=$balance;
        $account->update($item_to);
        }
        
        else{
          $cr= AccountCodes::where('id',$advance->bank_id)->first();
        
             $new['account_id']= $advance->bank_id;
               $new['account_name']= $cr->account_name;
              $new['balance']= 0-$advance->advance_amount;
               $new[' exchange_code']='TZS';
                $new['added_by']=auth()->user()->added_by;
        $balance=0-$advance->advance_amount;
             Accounts::create($new);
        }
                
           // save into tbl_transaction
        
                                     $transaction= Transaction::create([
                                        'module' => 'Advance Salary',
                                         'module_id' => $advance->id,
                                       'account_id' => $advance->bank_id,
                                        'code_id' => $adv->id,
                                        'name' => 'Advance Salary to ' .$emp_info->name. '  for the month of '.  $month,
                                        'type' => 'Expense',                               
                                        'amount' =>$advance->advance_amount ,
                                        'credit' => $advance->advance_amount,
                                         'total_balance' =>$balance,
                                          'date' => date('Y-m-d', strtotime($advance->request_date)),
                                           'status' => 'paid' ,
                                        'notes' => 'Advance Salary to ' .$emp_info->name. '  for the month of '.  $month,
                                        'user_id' => $advance->user_id ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);


if(!empty($advance)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $advance->id,
                            'module'=>'Advance Salary',
                            'activity'=>"Advance Salary to " .$emp_info->name. "  for the month ".  $month. " is approved",
                        ]
                        );                      
       }
       return redirect(route('advance_salary.index'))->with(['success'=>'Approved Successfully']);
   }
   

}
