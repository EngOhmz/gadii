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
use App\Models\Payroll\Overtime;
use App\Models\Payroll\AdvanceSalary;
use App\Models\Payroll\EmployeeAward;
use App\Models\Payroll\EmployeeLoan;
use App\Models\Payroll\EmployeeLoanReturn;
use App\Models\Payroll\PayrollActivity;
use App\Models\Payment_methodes;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\Transaction;
use App\Models\Accounts;
use App\Models\UserDetails\BasicDetails;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use  DateTime;

class MultiplePaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
       $all_department_info = Departments::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
        return view('payroll.multiple_payment',compact('all_department_info'));

        
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

        $flag = $request->flag;
        $departments_id = $request->departments_id;
         $payment_month ='';
        $employee_info='';
         $allowance_info='';
        $deduction_info='';
        $overtime_info='';
        $award_info='';
       $advance_salary='';
       $total_hours='';
      $salary_info='';
  $loan_info='';
$salary_loan_info='';
$account_info='';

$all_department_info=Departments::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
if (!empty($flag) || !empty($departments_id)) {
    $payment_month = $request->payment_month;    
     $date = new DateTime($payment_month . '-01');
        $start_date = $date->modify('first day of this month')->format('Y-m-d');
        $end_date = $date->modify('last day of this month')->format('Y-m-d');
  

                          //$employee_info  = EmployeePayroll::where('department_id',$departments_id)->get();

                  $employee_info=EmployeePayroll::leftJoin('users', 'users.id','tbl_employee_payroll.user_id')
               ->where('tbl_employee_payroll.department_id',$departments_id)
              ->where('tbl_employee_payroll.disabled','0')
               ->where('users.joining_date', '<', $payment_month) 
               ->where('users.added_by',auth()->user()->added_by)  
                ->where('users.disabled','0')
          ->select('tbl_employee_payroll.*')
        ->get();

     $all_payment_method = Payment_methodes::all();
        //   $account_info=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
           
           $account_info=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();
           
        //   dd($account_info);

}

return view('payroll.multiple_payment',compact('employee_info','flag','payment_month','departments_id','all_department_info','start_date','end_date','all_payment_method','account_info'));
    }

  public function getPayment($user_id,$departments_id,$payment_month)
    {
        //

        $employee_info='';
         $allowance_info='';
        $deduction_info='';
        $overtime_info='';
        $award_info='';
       $advance_salary='';
       $total_hours='';
      $salary_info='';
 $total_paid_amount='';
       $ttl_deduction='';
      $ttl_allowance='';
      $loan_info='';


$all_department_info=Departments::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
if (!empty($user_id) || !empty($departments_id)) {
        
     $date = new DateTime($payment_month . '-01');
        $start_date = $date->modify('first day of this month')->format('Y-m-d');
        $end_date = $date->modify('last day of this month')->format('Y-m-d');



                 // check payment history by employee id
                    $check_existing_payment = SalaryPayment::all()->where('user_id', $user_id);
               
  
                        // get all salary Template info
                          $employee_info  = EmployeePayroll::where('user_id', $user_id)->where('disabled','0')->first();

                          // get all allowance info by salary template id
                                          $allowance_info =  SalaryAllowance::where('salary_template_id',$employee_info->salary_template_id)->get();
        // get all deduction info by salary template id
                                         $deduction_info = SalaryDeduction::where('salary_template_id',$employee_info->salary_template_id)->get();
                                           // get all overtime info by month and employee id
                                      $overtime_info =Overtime::where('user_id',$user_id)->where('overtime_date','>=', $start_date)->where('overtime_date','<=', $end_date)->get();                                    
        // get all advance salary info by month and employee id
                                    $advance_salary= AdvanceSalary::where('user_id',$user_id)->where('deduct_month', $payment_month)->where('status', '1')->get();
                              $loan_info= EmployeeLoanReturn::where('user_id',$user_id)->where('deduct_month', $payment_month)->where('status', '1')->get();
        // get award info by employee id and payment month
                                  $award_info= EmployeeAward::where('user_id',$user_id)->where('award_date', $payment_month)->get();;
  
                                  $total_hours = '0';

             $all_payment_method = Payment_methodes::all();
        //   $account_info=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
        
        $account_info=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();


}

return view('payroll.employee_payment',compact('employee_info','allowance_info','deduction_info','overtime_info','advance_salary','award_info','total_hours','payment_month','departments_id','all_department_info','salary_info','user_id','all_payment_method','account_info','check_existing_payment','loan_info'));
    }

   public function save_payment(Request $request){


$item_id=$request->checked_item_id;
//dd($item_id);

 if(!empty($item_id)){
 for($i = 0; $i < count($item_id); $i++){
   if(!empty($item_id[$i])){

      $date = new DateTime($request->payment_month . '-01');
        $start_date = $date->modify('first day of this month')->format('Y-m-d');
        $end_date = $date->modify('last day of this month')->format('Y-m-d');
   // input data
                                         $employee_info  = EmployeePayroll::where('user_id', $item_id[$i])->where('disabled','0')->first();
                                          $template=SalaryTemplate::where('salary_template_id',  $employee_info->salary_template_id)->first();
                                          $allowance =  SalaryAllowance::where('salary_template_id',$employee_info->salary_template_id)->get();
                                         $deduction = SalaryDeduction::where('salary_template_id',$employee_info->salary_template_id)->get();
                                      $overtime =Overtime::where('user_id',$item_id[$i])->where('overtime_date','>=', $start_date)->where('overtime_date','<=', $end_date)->get();                                    
                                    $advance_info= AdvanceSalary::where('user_id',$item_id[$i])->where('deduct_month', $request->payment_month)->where('status', '1')->get();
                              $loan= EmployeeLoanReturn::where('user_id',$item_id[$i])->where('deduct_month', $request->payment_month)->where('status', '1')->get();
                                  $award= EmployeeAward::where('user_id',$item_id[$i])->where('award_date', $request->payment_month)->get();

              $total_amount=0;
      $total_adv = 0;
            if (!empty($advance_info)) {
                                            foreach ($advance_info as  $i_advance) {                                            
                                                    $total_adv += $i_advance->advance_amount;                                               
                                            }
                                        }
    $total_l = 0;
                                        if (!empty($loan)) {
                                            foreach ($loan as  $i_loan) {                                            
                                                    $total_l += $i_loan->loan_amount;                                               
                                            }
                                        }

 $total_aw = 0;
                                        if (!empty($award)) {
                                            foreach ($award as  $i_award_info) {
                                                    $total_a += $i_award_info->award_amount;
                                            }
                                        }

           $total_allow = 0;
                                        if (!empty($allowance)) {
                                            foreach ($allowance as  $i_allowance) {
                                                    $total_allow += $i_allowance->allowance_value; 
                                            }
                                        }
                                     $total_deduct = 0;
                                        if (!empty($deduction)) {
                                            foreach ($deduction as $i_deduction) {                                            
                                                  $total_deduct += $i_deduction->deduction_value; 
                                            }
                                        }
             $total_over=0;
            if (!empty($overtime)) {
               foreach ($overtime as  $i_overtime) {                                    
                $total_over += $i_overtime->overtime_amount;                                               
                                            }
               }

              

   
 $emp_info = User::find($item_id[$i]);
 $payroll_info  = EmployeePayroll::where('user_id', $item_id[$i])->where('disabled','0')->first();
 $paye_info = SalaryDeduction::where('salary_template_id',$payroll_info->salary_template_id)->where('deduction_label','PAYE')->where('deduction_value', '>','0')->first();
 $nssf_info = SalaryDeduction::where('salary_template_id',$payroll_info->salary_template_id)->where('deduction_label','NSSF')->where('deduction_value', '>','0')->first();
$basic=SalaryTemplate::where('salary_template_id', $payroll_info->salary_template_id)->first();
$month= date('F Y', strtotime($request->payment_month)) ;


 $total_amount =   $total_over +  $total_allow + $total_aw ;                   
$gross = $template->basic_salary + $total_amount;
$deduction =  $total_deduct +  $total_adv +$total_l;
$net_salary = $gross - $deduction;


if(empty($paye_info)){
 $paye_deduction_value=0;
}

else{
$paye_deduction_value= $paye_info->deduction_value;
}

if(empty($nssf_info)){
 $nssf_deduction_value=0;
}

else{

$nssf_deduction_value= $nssf_info->deduction_value;
}


  if (!empty($overtime[0])) {

//$over_nssf= ($template->basic_salary +  $total_over)  * 0.10 ;
$over_nssf= $gross  * 0.10 ;
$sub_total= $gross -$over_nssf;


if ($sub_total < 270000) {
          $tax=0;
        }
        else if ($sub_total >= 270000 && $sub_total < 520000) {
            $tax= 0.08 * ($sub_total - 270000);
        }
        else if ($sub_total >= 520000 && $sub_total < 760000) {
            $tax= 20000 + (($sub_total - 520000) * 0.2 );
        }
        else if ($sub_total >= 760000 && $sub_total < 1000000) {
            $tax= 68000 + (($sub_total - 760000) * 0.25 );
        } else if ($sub_total >= 1000000) {
              $tax= 128000  + (($sub_total - 1000000) * 0.3 );
        }

$over_tax=$tax ;
}

else{
$over_nssf=$nssf_deduction_value;
$over_tax= $paye_deduction_value;

}

$diff=($over_nssf - $nssf_deduction_value)  + ($over_tax - $paye_deduction_value) ;
$payment_amount=($net_salary-$request->fine_deduction) - $diff;

                    $data = array(
                     'user_id' => $item_id[$i],
                    'payment_month' =>    $request->payment_month,
                    'fine_deduction' =>   $request->fine_deduction,
                     'payment_type' => $request->payment_type,
                      'paid_date' =>  $request->paid_date,
                  'bank_charges' =>  $request->bank_charges,
                     'payment_amount' =>  $payment_amount,
                    'comments' =>   $request->comments,
                  'account_id' =>   $request->account_id,
                       'added_by'=>auth()->user()->added_by);
            $salary_payment=SalaryPayment::create($data);  ;

if(!empty( $salary_payment)){ 
$s=AccountCodes::where('account_name','Salaries')->where('added_by', auth()->user()->added_by)->first();   

          $journal = new JournalEntry();
        $journal->account_id = $s->account_id;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Salary Payment';
        $journal->debit= $payment_amount;
        $journal->payment_id= $salary_payment->id;
         $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Net Salary Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =   $request->account_id;;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Salary Payment';
        $journal->credit= $payment_amount;
        $journal->payment_id= $salary_payment->id;
        $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Net Salary Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();

 $account= Accounts::where('account_id',$request->account_id)->first();
 if(!empty($account)){
        $balance=$account->balance - $payment_amount ;
        $item_to['balance']=$balance;
        $account->update($item_to);
        }
        
        else{
          $cr= AccountCodes::where('id',$request->account_id)->first();
        
             $new['account_id']= $request->account_id;
               $new['account_name']= $cr->account_name;
              $new['balance']= 0-$payment_amount;
               $new[' exchange_code']='TZS';
                $new['added_by']=auth()->user()->added_by;
        $balance=0-$payment_amount;
             Accounts::create($new);
        }
                
           // save into tbl_transaction
        
                                     $transaction= Transaction::create([
                                        'module' => 'Salary Payment',
                                         'module_id' => $salary_payment->id,
                                       'account_id' => $request->account_id,
                                        'code_id' => $s->account_id,
                                        'name' => 'Net Salary Payment to ' .$emp_info->name. '  for the month of '.  $month,
                                        'type' => 'Expense',                               
                                        'amount' =>$payment_amount ,
                                        'credit' => $payment_amount,
                                         'total_balance' =>$balance,
                                          'date' => date('Y-m-d', strtotime($request->paid_date)),
                                         'payment_methods_id'=>$request->payment_type,
                                           'status' => 'paid' ,
                                        'notes' => 'Net Salary Payment to ' .$emp_info->name. '  for the month of '.  $month,
                                        'user_id' => $item_id[$i] ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);
   }       

 
if ($over_tax > 0) {         
$salary=AccountCodes::where('account_name','Salaries')->where('added_by', auth()->user()->added_by)->first();                 
          $journal = new JournalEntry();
        $journal->account_id = $salary->id;
          $journal->user_id=$item_id[$i] ;
        $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'PAYE Payment';
        $journal->debit=  $over_tax ;
        $journal->payment_id= $salary_payment->id;
        $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "PAYE Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();

 $paye=AccountCodes::where('account_name','PAYE')->where('added_by', auth()->user()->added_by)->first();;
   
         $journal = new JournalEntry();
        $journal->account_id = $paye->id;
          $journal->user_id=$item_id[$i] ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'PAYE Payment';
        $journal->credit=  $over_tax ;
        $journal->payment_id= $salary_payment->id;
       $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "PAYE Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
          
}


 if ($over_nssf > 0) {
$salary=AccountCodes::where('account_name','Salaries')->where('added_by', auth()->user()->added_by)->first();                 
          $journal = new JournalEntry();
        $journal->account_id = $salary->id;
          $journal->user_id=$item_id[$i] ;
          $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NSSF Payment';
        $journal->debit= $over_nssf ;
        $journal->payment_id= $salary_payment->id;
         $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "NSSF Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
          
     $nssf=AccountCodes::where('account_name','NSSF')->where('added_by', auth()->user()->added_by)->first();;
   
         $journal = new JournalEntry();
        $journal->account_id = $nssf->id;
          $journal->user_id=$item_id[$i] ;
      $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NSSF Payment';
        $journal->credit= $over_nssf;
        $journal->payment_id= $salary_payment->id;
        $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "NSSF Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();  


$nssf_e=AccountCodes::where('account_name','NSSF - Employer Contribution')->where('added_by', auth()->user()->added_by)->first();   
                   
          $journal = new JournalEntry();
        $journal->account_id =$nssf_e->id;
          $journal->user_id=$item_id[$i] ;
        $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NSSF - Employer Contribution Payment';
        $journal->debit= $over_nssf;
        $journal->payment_id= $salary_payment->id;
           $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "NSSF - Employer Contribution Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();

$nssf=AccountCodes::where('account_name','NSSF')->where('added_by', auth()->user()->added_by)->first();;
   
         $journal = new JournalEntry();
        $journal->account_id = $nssf->id;
          $journal->user_id=$item_id[$i] ;
        $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NSSF Payment';
        $journal->credit= $over_nssf;
        $journal->payment_id= $salary_payment->id;
          $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "NSSF Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();  

  }        
       

$wcf_e=AccountCodes::where('account_name','WCF contribution')->where('added_by', auth()->user()->added_by)->first();;
 
           $journal = new JournalEntry();
        $journal->account_id =$wcf_e->id;
          $journal->user_id=$item_id[$i] ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'WCF Contribution Payment';
        $journal->debit=  0.006 * $gross ;
        $journal->payment_id= $salary_payment->id;
           $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "WCF Contribution Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();


 $wcf=AccountCodes::where('account_name','WCF')->where('added_by', auth()->user()->added_by)->first();;
   
                 $journal = new JournalEntry();
        $journal->account_id =$wcf->id;
          $journal->user_id=$item_id[$i] ;
        $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'WCF Payment';
        $journal->credit=  0.006 * $gross ;
        $journal->payment_id= $salary_payment->id;
             $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "WCF  Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
          
$nhif_e=AccountCodes::where('account_name','NHIF - Heath Insurance Expense')->where('added_by', auth()->user()->added_by)->first();;

        $journal = new JournalEntry();
        $journal->account_id =$nhif_e->id;
          $journal->user_id=$item_id[$i] ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NHIF - Heath Insurance Expense Payment';
        $journal->debit=  0.06 * $gross ;
        $journal->payment_id= $salary_payment->id;
             $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "NHIF - Heath Insurance Expense Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
         

 $nhif=AccountCodes::where('account_name','NHIF')->where('added_by', auth()->user()->added_by)->first();;

        $journal = new JournalEntry();
        $journal->account_id =$nhif->id;
          $journal->user_id=$item_id[$i] ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NHIF Payment';
        $journal->credit=  0.06 *$gross ;
        $journal->payment_id= $salary_payment->id;
          $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "NHIF  Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
   

$staff=EmployeePayroll::where('added_by',auth()->user()->added_by)->where('disabled','0')->count();

if($staff >=10){
$sdl_e=AccountCodes::where('account_name','SDL contribution')->where('added_by', auth()->user()->added_by)->first();;
 
           $journal = new JournalEntry();
        $journal->account_id =$sdl_e->id;
          $journal->user_id=$item_id[$i] ; ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'SDL Payment';
        $journal->debit=  0.04 * $gross ;
        $journal->payment_id= $salary_payment->id;
           $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "SDL Contribution Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();


 $sdl=AccountCodes::where('account_name','SDL')->where('added_by', auth()->user()->added_by)->first();;
   
                 $journal = new JournalEntry();
        $journal->account_id =$sdl->id;
          $journal->user_id=$item_id[$i] ; ;
        $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'SDL Payment';
        $journal->credit=  0.04 * $gross ;
        $journal->payment_id= $salary_payment->id;
             $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "SDL Payment from " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
          
}


if($request->bank_charges > 0){ 
$bc=AccountCodes::where('account_name','Bank Charges')->where('added_by', auth()->user()->added_by)->first();    

          $journal = new JournalEntry();
        $journal->account_id = $bc->account_id;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
       $journal->name = 'Bank Charges';
        $journal->debit= $request->bank_charges;
        $journal->payment_id= $salary_payment->id;
         $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Bank Charges for the salary payment of " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();

        $journal = new JournalEntry();
        $journal->account_id =   $request->account_id;;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Bank Charges';
        $journal->credit= $request->bank_charges;
        $journal->payment_id= $salary_payment->id;
        $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Bank Charges for the salary payment of " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
$account= Accounts::where('account_id',$request->account_id)->first();
 if(!empty($account)){
        $charge=$account->balance - $request->bank_charges ;
        $c_to['balance']=$charge;
        $account->update($c_to);
        }
        
        else{
          $cr= AccountCodes::where('id',$request->account_id)->first();
        
             $cnew['account_id']= $request->account_id;
               $cnew['account_name']= $cr->account_name;
              $cnew['balance']= 0-$request->bank_charges;
               $cnew[' exchange_code']='TZS';
                $cnew['added_by']=auth()->user()->added_by;
        $charge=0-$request->bank_charges;
             Accounts::create($cnew);
        }
                
           // save into tbl_transaction
        
                                     $transaction= Transaction::create([
                                        'module' => 'Bank Charges',
                                         'module_id' => $salary_payment->id,
                                       'account_id' => $request->account_id,
                                        'code_id' => $bc->account_id,
                                        'name' => 'Bank Charges for the salary payment of ' .$emp_info->name. '  for the month of '.  $month,
                                        'type' => 'Expense',                               
                                        'amount' =>$request->bank_charges ,
                                        'credit' => $request->bank_charges,
                                         'total_balance' =>$charge,
                                          'date' => date('Y-m-d', strtotime($request->paid_date)),
                                         'payment_methods_id'=>$request->payment_type,
                                           'status' => 'paid' ,
                                        'notes' => 'Bank Charges for the salary payment of ' .$emp_info->name. '  for the month of '.  $month,
                                        'user_id' => $item_id[$i] ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);

   } 





// get all allowance info by salary template id
        if (!empty($basic->salary_template_id)) {
            $salary_payment_details_label[] = 'Salary Grade ';
            $salary_payment_details_value[] = $basic->salary_grade;

            //$salary_payment_details_label[] = 'Basic Salary - ' .$basic->salary_grade;
            $salary_payment_details_label[] = 'Basic Salary ';
            $salary_payment_details_value[] = $basic->basic_salary;

                    $sd['salary_payment_id'] = $salary_payment->id;
                    $sd['salary_payment_details_label'] = 'Salary Grade';
                    $sd['salary_payment_details_value'] = $basic->salary_grade;

                       SalaryPaymentDetails::create($sd);

                    $d['salary_payment_id'] = $salary_payment->id;
                    $d['salary_payment_details_label'] = 'Basic Salary';
                    $d['salary_payment_details_value'] = $basic->basic_salary;

             SalaryPaymentDetails::create($d);

          
// ************ Save all allwance info **********
         $allowance_info = SalaryAllowance::where('salary_template_id', $payroll_info->salary_template_id)->get();
            if (!empty($allowance_info)) {
                foreach ($allowance_info as $v_allowance_info) {
                    $aldata['salary_payment_id'] = $salary_payment->id;
                    $aldata['salary_payment_allowance_label'] = $v_allowance_info->allowance_label;
                    $aldata['salary_payment_allowance_value'] = $v_allowance_info->allowance_value;

                     $salary_allowance = SalaryPaymentAllowance::create($aldata);
                }
            }
// get all deduction info by salary template id
// ************ Save all deduction info **********

             if ($over_nssf > 0) {

                    $salary_payment_deduction_label[] = 'NSSF';
                    $salary_payment_deduction_value[] = $over_nssf;         

               $nsdata['salary_payment_id'] = $salary_payment->id;
                $nsdata['salary_payment_deduction_label'] = 'NSSF';;
                $nsdata['salary_payment_deduction_value'] = $over_nssf;
 
              SalaryPaymentDeduction::create($nsdata);
       
            }


           if ($over_tax > 0) {

                    $salary_payment_deduction_label[] = 'PAYE';
                    $salary_payment_deduction_value[] = $over_tax;         

               $pdata['salary_payment_id'] = $salary_payment->id;
                $pdata['salary_payment_deduction_label'] = 'PAYE';;
                $pdata['salary_payment_deduction_value'] = $over_tax;
 
              SalaryPaymentDeduction::create($pdata);
       
            }


            $deduction_info = SalaryDeduction::where('salary_template_id', $payroll_info->salary_template_id)->whereNotIn('deduction_label', ['NSSF','PAYE'])->get();
            if (!empty($deduction_info)) {
                foreach ($deduction_info as $v_deduction_info) {
                    $salary_payment_deduction_label[] = $v_deduction_info->deduction_label;
                    $salary_payment_deduction_value[] = $v_deduction_info->deduction_value;

                $ddata['salary_payment_id'] = $salary_payment->id;
                $ddata['salary_payment_deduction_label'] = $v_deduction_info->deduction_label;
                $ddata['salary_payment_deduction_value'] = $v_deduction_info->deduction_value;
 
              SalaryPaymentDeduction::create($ddata);
                }
            }


// ************ Save all Overtime info **********
// get all overtime info by month and employee id
            $overtime_info =Overtime::where('user_id',$item_id[$i])->where('overtime_date','>=', $start_date)->where('overtime_date','<=', $end_date)->where('status', '1')->get();
                $overtime_ttl=0;
               if (!empty($overtime_info[0])) {
                foreach ($overtime_info as $v_overtime_info) {
                    $overtime_ttl +=  $v_overtime_info->overtime_amount;
                       Overtime::where('id', $v_overtime_info->id)->update(['status' => '3']); 


                    $od['salary_payment_id'] = $salary_payment->id;
                    $od['salary_payment_details_label'] = 'Overtime Amount';
                    $od['salary_payment_details_value'] = $overtime_ttl;

             SalaryPaymentDetails::create($od);
                }
              $salary_payment_details_label[] = 'Overtime Amount';
            $salary_payment_details_value[] = $overtime_ttl;



            $over=AccountCodes::where('account_name','Overtime')->where('added_by', auth()->user()->added_by)->first();   
         if (!empty($over)) {
          $journal = new JournalEntry();
        $journal->account_id = $over->id;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Overtime Salary Payment';
        $journal->debit= $overtime_ttl;
        $journal->payment_id= $salary_payment->id;
             $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Overtime Salary Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
     }     
                 
if (!empty($request->account_id)) {
       $journal = new JournalEntry();
        $journal->account_id =   $request->account_id;;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Overtime  Salary Payment';
        $journal->credit=$overtime_ttl;
        $journal->payment_id= $salary_payment->id;
            $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Overtime  Salary Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
 }         
            }
}       
// ************ Save all Advance Salary info **********
// get all advance salary info by month and employee id
        $advance_salary= AdvanceSalary::where('user_id',$item_id[$i])->where('deduct_month', $request->payment_month)->where('status', '1')->first();
         $total_advance=0;
             if (!empty($advance_salary)) {
                    $total_advance = $advance_salary->advance_amount;
                AdvanceSalary::where('id', $advance_salary->id)->update(['status' => '3']); 
               
              $salary_payment_deduction_label[] = 'Advance Amount';
            $salary_payment_deduction_value[] =   $total_advance;
         


$salary=AccountCodes::where('account_name','Salaries')->where('added_by', auth()->user()->added_by)->first();     
          $journal = new JournalEntry();
        $journal->account_id = $salary->id;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Advance Salary Payment';
        $journal->debit= $total_advance;
        $journal->payment_id= $salary_payment->id;
            $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Advance Salary Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();

  $adv=AccountCodes::where('account_name','Advance Salary')->where('added_by', auth()->user()->added_by)->first();   
          $journal = new JournalEntry();
        $journal->account_id = $adv->id;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Advance Salary Payment';
        $journal->credit= $total_advance;
        $journal->payment_id= $salary_payment->id;
            $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Advance Salary Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
          

            $addata['salary_payment_id'] = $salary_payment->id;
                $addata['salary_payment_deduction_label'] = 'Advance Amount';;
                $addata['salary_payment_deduction_value'] = $total_advance;
 
              SalaryPaymentDeduction::create($addata);

        
            }
     

// ************ Save all Advance Salary info **********
// get all advance salary info by month and employee id
        $loan_info= EmployeeLoanReturn::where('user_id',$item_id[$i])->where('deduct_month', $request->payment_month)->where('status', '1')->first();
         $total_loan=0;
             if (!empty($loan_info)) {
                    $total_loan =$loan_info->loan_amount;
               EmployeeLoanReturn::where('id', $loan_info->id)->update(['status' => '3']); 
               
              $salary_payment_deduction_label[] = 'Employee Loan';
            $salary_payment_deduction_value[] =   $total_loan;


$trans_info=EmployeeLoanReturn::where('id','!=',$loan_info->loan_id)->get();
                 if (!empty($trans_info)) {
                foreach ($trans_info as $it) {
              if ($it->status == '3') {
           EmployeeLoan::where('id', $loan_info->loan_id)->update(['status' => '4']);   
           
}
        else {
            EmployeeLoan::where('id', $loan_info->loan_id)->update(['status' => '3']);   
           
}
}
}
          

$salary=AccountCodes::where('account_name','Salaries')->where('added_by', auth()->user()->added_by)->first();     
          $journal = new JournalEntry();
        $journal->account_id = $salary->id;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Employee Loan Payment';
        $journal->debit= $total_loan;
        $journal->payment_id= $salary_payment->id;
        $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Loan Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();

$loan=AccountCodes::where('account_name','Employee Loan')->where('added_by', auth()->user()->added_by)->first();   
          $journal = new JournalEntry();
        $journal->account_id = $loan->id;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Employee Loan Payment';
        $journal->credit= $total_loan;
        $journal->payment_id= $salary_payment->id;
        $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Loan Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->added_by=auth()->user()->added_by;
        $journal->save();
          


               $eddata['salary_payment_id'] = $salary_payment->id;
                $eddata['salary_payment_deduction_label'] = 'Employee Loan';
                $eddata['salary_payment_deduction_value'] = $total_loan;
 
              SalaryPaymentDeduction::create($eddata);
        
            }
     

// get award info by employee id and payment date
        $award_info = EmployeeAward::where('user_id',$item_id[$i])->where('award_date', $request->payment_month)->where('status', '1')->get();;
 $total_award=0;
        if (!empty($award_info[0])) {
            foreach ($award_info as $v_award_info) {             
                  $total_award += $v_award_info->award_amount;
                   EmployeeAward::where('id', $v_award_info->id)->update(['status' => '3']); 
                      
                      $ad['salary_payment_id'] = $salary_payment->id;
                    $ad['salary_payment_details_label'] = 'Award Name'  ;
                    $ad['salary_payment_details_value'] = $total_award;

             SalaryPaymentDetails::create($ad);

                }
                $salary_payment_details_label[] ='Award Name'  ;
                $salary_payment_details_value[] = $total_award;

          
          $award=AccountCodes::where('account_name','Employee Award')->where('added_by', auth()->user()->added_by)->first();   
          $journal = new JournalEntry();
        $journal->account_id = $award->id;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Employee Award Payment';
        $journal->debit=$total_award;
        $journal->payment_id= $salary_payment->id;
        $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Award Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->save();
          
         $journal = new JournalEntry();
        $journal->account_id =   $request->account_id;;
          $journal->user_id=$item_id[$i] ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Employee Award  Payment';
        $journal->credit=$total_award;
        $journal->payment_id= $salary_payment->id;
        $journal->payment_month=$request->payment_month;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Award Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->save();
        }

       

if(!empty($salary_payment)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $salary_payment->id,
                            'module'=>'Salary Payment',
                            'activity'=>"Salary Payment to " .$emp_info->name. "  for the month ".  $month ,
                        ]
                        );                      
       }



}
}    
return redirect(route('multiple_view.payment',['departments_id'=>$request->department_id,'payment_month'=>$request->payment_month]))->with(['success'=>'Payment Updated Successfully']);

}


else{

  return redirect(route('multiple_view.payment',['departments_id'=>$request->department_id,'payment_month'=>$request->payment_month]))->with(['error'=>'You have not chosen an entry']);
}

}




 
    public function viewPayment($departments_id,$payment_month)
    {  

        $flag = '1';
        $employee_info='';
         $allowance_info='';
        $deduction_info='';
        $overtime_info='';
        $award_info='';
       $advance_salary='';
       $total_hours='';
      $salary_info='';
         $loan_info='';
     $salary_loan_info='';
      if(!empty($salary)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=>$salary->id,
                             'module'=>'Salary Details',
                            'activity'=>"Salary Details for  " . $dep_name->name. "  Department Updated",
                        ]
                        );                      
       }
$all_department_info=Departments::all()->where('disabled','0')->where('added_by',auth()->user()->added_by);
if (!empty($flag) || !empty($departments_id)) { 
     $date = new DateTime($payment_month . '-01');
        $start_date = $date->modify('first day of this month')->format('Y-m-d');
        $end_date = $date->modify('last day of this month')->format('Y-m-d');
  

                          //$employee_info  = EmployeePayroll::where('department_id',$departments_id)->get();

                                    $employee_info=EmployeePayroll::leftJoin('users', 'users.id','tbl_employee_payroll.user_id')
               ->where('tbl_employee_payroll.department_id',$departments_id)
              ->where('tbl_employee_payroll.disabled','0')
               ->where('users.joining_date', '<', $payment_month) 
               ->where('users.added_by',auth()->user()->added_by)  
                ->where('users.disabled','0')
          ->select('tbl_employee_payroll.*')
        ->get();

  $all_payment_method = Payment_methodes::all();
        //   $account_info=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
        $account_info=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();

}

return view('payroll.multiple_payment',compact('employee_info','flag','payment_month','departments_id','all_department_info','start_date','end_date','all_payment_method','account_info'));
    }

    public function get_allowance_info_by_id($salary_template_id)
    {
        $salary_allowance_info = SalaryAllowance::all()->where('salary_template_id', $salary_template_id);
        $total_allowance = 0;
        foreach ($salary_allowance_info as $v_allowance_info) {
            $total_allowance += $v_allowance_info->allowance_value;
        }
        return $total_allowance;
    }

    public function get_deduction_info_by_id($salary_template_id)
    {
        $salary_deduction_info = SalaryDeduction::all()->where('salary_template_id', $salary_template_id);
        $total_deduction = 0;
        foreach ($salary_deduction_info as $v_deduction_info) {
            $total_deduction += $v_deduction_info->deduction_value;
        }
        return $total_deduction;
    }

    public function get_overtime_info_by_id($user_id, $payment_month)
    {
        $date = new DateTime($payment_month . '-01');
        $start_date = $date->modify('first day of this month')->format('Y-m-d');
        $end_date = $date->modify('last day of this month')->format('Y-m-d');
        //$this->payroll_model->_table_name = "tbl_overtime"; //table name
        // $this->payroll_model->_order_by = "overtime_id";
        $all_overtime_info = Overtime::all()->where('overtime_date >=', $start_date)->where('overtime_date <=',$end_date)->where('user_id',$user_id); // get all report by start date and in date
        //$all_overtime_info = $this->payroll_model->get_by(array('overtime_date >=' => $start_date, 'overtime_date <=' => $end_date, 'user_id' => $user_id), FALSE); // get all report by start date and in date
        $hh = 0;
        $mm = 0;
        foreach ($all_overtime_info as $overtime_info) {
            $hh += $overtime_info->overtime_hours;
            $mm += date('i', strtotime($overtime_info->overtime_hours));
        }
        if ($hh > 1 && $hh < 10 || $mm > 1 && $mm < 10) {
            $total_mm = '0' . $mm;
            $total_hh = '0' . $hh;
        } else {
            $total_mm = $mm;
            $total_hh = $hh;
        }
        if ($total_mm > 59) {
            $total_hh += intval($total_mm / 60);
            $total_mm = intval($total_mm % 60);
        }
        $result['overtime_hours'] = $total_hh;
        $result['overtime_minutes'] = $total_mm;
        return $result;
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


}
