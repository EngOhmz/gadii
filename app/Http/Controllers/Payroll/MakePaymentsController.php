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

class MakePaymentsController extends Controller
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
        return view('payroll.make_payment',compact('all_department_info'));

        
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
        
        // $account_info=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();
        
        $account_info=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();


}

return view('payroll.make_payment',compact('employee_info','flag','payment_month','departments_id', 'account_info','all_department_info','start_date','end_date'));
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
            // $account_info=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get();
            $account_info=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();


}

return view('payroll.employee_payment',compact('employee_info','allowance_info','deduction_info','overtime_info','advance_salary','award_info','total_hours','payment_month','departments_id','all_department_info','salary_info','user_id','all_payment_method','account_info','check_existing_payment','loan_info'));
    }

   public function save_payment(Request $request){

   // input data
    $date = new DateTime($request->payment_month . '-01');
        $start_date = $date->modify('first day of this month')->format('Y-m-d');
        $end_date = $date->modify('last day of this month')->format('Y-m-d');

 $emp_info = User::find($request->user_id);
 $payroll_info  = EmployeePayroll::where('user_id', $request->user_id)->where('disabled','0')->first();
 $paye_info = SalaryDeduction::where('salary_template_id',$payroll_info->salary_template_id)->where('deduction_label','PAYE')->where('deduction_value', '>','0')->first();

if(empty($paye_info)){
 $paye_deduction_value=0;
}

else{

$paye_deduction_value= $paye_info->deduction_value;
}

 $nssf_info = SalaryDeduction::where('salary_template_id',$payroll_info->salary_template_id)->where('deduction_label','NSSF')->where('deduction_value', '>','0')->first();

if(empty($nssf_info)){
 $nssf_deduction_value=0;
}

else{

$nssf_deduction_value= $nssf_info->deduction_value;
}


$basic=SalaryTemplate::where('salary_template_id', $payroll_info->salary_template_id)->first();
$month= date('F Y', strtotime($request->payment_month)) ;

$ovrtme =Overtime::where('user_id',$request->user_id)->where('overtime_date','>=', $start_date)->where('overtime_date','<=', $end_date)->where('status', '1')->get();
                $ovrtme_ttl=0;
                
               if (!empty($ovrtme[0])) {
                foreach ($ovrtme as $v_ovrtme) {
                    $ovrtme_ttl +=  $v_ovrtme->overtime_amount;
                     
                }

//$over_nssf= ($basic->basic_salary +  $ovrtme_ttl)  * 0.10 ;
$over_nssf= $request->gross  * 0.10 ;
$sub_total= $request->gross -$over_nssf;


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
$payment_amount= $request->payment_amount - $diff;

   $data['user_id']=$request->user_id ;
     $data['payment_month']=$request->payment_month ;
       $data['fine_deduction']=$request->fine_deduction ;
       $data['payment_type']=$request->payment_type ;
     $data['paid_date']=$request->paid_date ;
         $data['bank_charges']=$request->bank_charges ;
         $data['payment_amount']= $payment_amount;
       $data['comments']=$request->comments ;
      $data['account_id']=$request->account_id ;
      $data['added_by']=auth()->user()->added_by ;
            $salary_payment=SalaryPayment::create($data);  ;

if(!empty( $salary_payment)){ 
$s=AccountCodes::where('account_name','Salaries')->where('added_by', auth()->user()->added_by)->first();   

          $journal = new JournalEntry();
        $journal->account_id = $s->account_id;
          $journal->user_id=$request->user_id ;
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
          $journal->user_id=$request->user_id ;
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
                                        'user_id' => $request->user_id ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);
   }       

 
          //dd($over_tax );

  if ($over_tax > 0) {
$salary=AccountCodes::where('account_name','Salaries')->where('added_by', auth()->user()->added_by)->first();                 
          $journal = new JournalEntry();
        $journal->account_id = $salary->id;
          $journal->user_id=$request->user_id ;
        $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'PAYE Payment';
        $journal->debit= $over_tax ;
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
          $journal->user_id=$request->user_id ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'PAYE Payment';
        $journal->credit= $over_tax ;
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
          $journal->user_id=$request->user_id ;
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
          $journal->user_id=$request->user_id ;
      $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NSSF Payment';
        $journal->credit=$over_nssf ;
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
          $journal->user_id=$request->user_id ;
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
          $journal->user_id=$request->user_id ;
        $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NSSF Payment';
        $journal->credit=$over_nssf;
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
          $journal->user_id=$request->user_id ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'WCF Contribution Payment';
        $journal->debit=  0.006 * $request->gross ;
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
          $journal->user_id=$request->user_id ;
        $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'WCF Payment';
        $journal->credit=  0.006 *  $request->gross ;
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
          $journal->user_id=$request->user_id ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NHIF - Heath Insurance Expense Payment';
        $journal->debit=  0.06 *  $request->gross ;
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
          $journal->user_id=$request->user_id ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'NHIF Payment';
        $journal->credit=  0.06 *  $request->gross ;
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
          $journal->user_id=$request->user_id ;
       $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'SDL Payment';
        $journal->debit=  0.04 *  $request->gross ;
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
          $journal->user_id=$request->user_id ;
        $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'SDL Payment';
        $journal->credit=  0.04 *  $request->gross ;
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
          $journal->user_id=$request->user_id ;
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
          $journal->user_id=$request->user_id ;
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
                                        'user_id' => $request->user_id ,
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
                }
 
 if ($over_tax > 0) {
                    $salary_payment_deduction_label[] = 'PAYE';
                    $salary_payment_deduction_value[] = $over_tax;
                }

            $deduction_info = SalaryDeduction::where('salary_template_id', $payroll_info->salary_template_id)->whereNotIn('deduction_label', ['NSSF','PAYE'])->get();
            if (!empty($deduction_info)) {
                foreach ($deduction_info as $v_deduction_info) {
                    $salary_payment_deduction_label[] = $v_deduction_info->deduction_label;
                    $salary_payment_deduction_value[] = $v_deduction_info->deduction_value;
                }
            }


 
         

// ************ Save all Overtime info **********
// get all overtime info by month and employee id
            $overtime_info =Overtime::where('user_id',$request->user_id)->where('overtime_date','>=', $start_date)->where('overtime_date','<=', $end_date)->where('status', '1')->get();
                $overtime_ttl=0;
               if (!empty($overtime_info[0])) {
                foreach ($overtime_info as $v_overtime_info) {
                    $overtime_ttl +=  $v_overtime_info->overtime_amount;
                       Overtime::where('id', $v_overtime_info->id)->update(['status' => '3']); 
                }
              $salary_payment_details_label[] = 'Overtime Amount';
            $salary_payment_details_value[] = $overtime_ttl;



            $over=AccountCodes::where('account_name','Overtime')->where('added_by', auth()->user()->added_by)->first();   
         if (!empty($over)) {
          $journal = new JournalEntry();
        $journal->account_id = $over->id;
          $journal->user_id=$request->user_id ;
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
          $journal->user_id=$request->user_id ;
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
        $advance_salary= AdvanceSalary::where('user_id',$request->user_id)->where('deduct_month', $request->payment_month)->where('status', '1')->first();
         $total_advance=0;
             if (!empty($advance_salary)) {
                    $total_advance = $advance_salary->advance_amount;
                AdvanceSalary::where('id', $advance_salary->id)->update(['status' => '3']); 
               
              $salary_payment_deduction_label[] = 'Advance Amount';
            $salary_payment_deduction_value[] =   $total_advance;
          
           
          
$salary=AccountCodes::where('account_name','Salaries')->where('added_by', auth()->user()->added_by)->first();     
          $journal = new JournalEntry();
        $journal->account_id = $salary->id;
          $journal->user_id=$request->user_id ;
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
          $journal->user_id=$request->user_id ;
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
        
            }
     

// ************ Save all Advance Salary info **********
// get all advance salary info by month and employee id
        $loan_info= EmployeeLoanReturn::where('user_id',$request->user_id)->where('deduct_month', $request->payment_month)->where('status', '1')->first();
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
          $journal->user_id=$request->user_id ;
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
          $journal->user_id=$request->user_id ;
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
          
        
            }
     

// get award info by employee id and payment date
        $award_info = EmployeeAward::where('user_id',$request->user_id)->where('award_date', $request->payment_month)->where('status', '1')->get();;
 $total_award=0;
        if (!empty($award_info[0])) {
            foreach ($award_info as $v_award_info) {             
                  $total_award += $v_award_info->award_amount;
                   EmployeeAward::where('id', $v_award_info->id)->update(['status' => '3']); 
                }
                $salary_payment_details_label[] ='Award Name '  ;
                $salary_payment_details_value[] = $total_award;

          
          $award=AccountCodes::where('account_name','Employee Award')->where('added_by', auth()->user()->added_by)->first();   
          $journal = new JournalEntry();
        $journal->account_id = $award->id;
          $journal->user_id=$request->user_id ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Employee Award Payment';
        $journal->debit=$total_award;
        $journal->payment_id= $salary_payment->id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Award Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->save();
          
         $journal = new JournalEntry();
        $journal->account_id =   $request->account_id;;
          $journal->user_id=$request->user_id ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Employee Award  Payment';
        $journal->credit=$total_award;
        $journal->payment_id= $salary_payment->id;
         $journal->currency_code =  'TZS';
        $journal->exchange_rate= '1';
        $journal->notes= "Employee Award Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->save();
        }

        if (!empty($salary_payment_details_label)) {
            foreach ($salary_payment_details_label as $key => $payment_label) {
                $details_data['salary_payment_details_label'] = $payment_label;
                $details_data['salary_payment_details_value'] = $salary_payment_details_value[$key];
                 $details_data['salary_payment_id'] = $salary_payment->id;
                SalaryPaymentDetails::create($details_data);

            }
        }
        if (!empty($salary_payment_deduction_label)) {
            foreach ($salary_payment_deduction_label as $dkey => $deduction_label) {
                $ddetails_data['salary_payment_id'] = $salary_payment->id;
                $ddetails_data['salary_payment_deduction_label'] = $deduction_label;
                $ddetails_data['salary_payment_deduction_value'] = $salary_payment_deduction_value[$dkey];
 
              SalaryPaymentDeduction::create($ddetails_data);
            }
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
    
return redirect(route('view.payment',['departments_id'=>$emp_info->department_id,'payment_month'=>$request->payment_month]))->with(['success'=>'Payment Updated Successfully']);
}


 public function editPayment($user_id,$departments_id,$payment_month)
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
                    $check_salary_payment=SalaryPayment::where('user_id', $user_id)->where('payment_month', $payment_month)->first();
  
                        // get all salary Template info
                          $employee_info  = EmployeePayroll::where('user_id', $user_id)->where('disabled','0')->first();

                          // get all allowance info by salary template id
                                          $allowance_info =  SalaryAllowance::where('salary_template_id',$employee_info->salary_template_id)->get();
        // get all deduction info by salary template id
                                         $deduction_info = SalaryDeduction::where('salary_template_id',$employee_info->salary_template_id)->get();
                                           // get all overtime info by month and employee id
                                      $overtime_info =Overtime::where('user_id',$user_id)->where('overtime_date','>=', $start_date)->where('overtime_date','<=', $end_date)->where('status', '3')->get();                                    
        // get all advance salary info by month and employee id
                                    $advance_salary= AdvanceSalary::where('user_id',$user_id)->where('deduct_month', $payment_month)->where('status', '3')->get();
                              $loan_info= EmployeeLoanReturn::where('user_id',$user_id)->where('deduct_month', $payment_month)->where('status', '3')->get();
        // get award info by employee id and payment month
                                  $award_info= EmployeeAward::where('user_id',$user_id)->where('award_date', $payment_month)->where('status', '3')->get();;
  
                                  $total_hours = '0';

             $all_payment_method = Payment_methodes::all();
        //   $account_info=AccountCodes::where('account_group','Cash and Cash Equivalent')->where('added_by',auth()->user()->added_by)->get() ;
        $account_info=AccountCodes::where('account_status','Bank')->where('disabled','0')->where('added_by',auth()->user()->added_by)->get();


}

return view('payroll.employee_edit_payment',compact('employee_info','allowance_info','deduction_info','overtime_info','advance_salary','award_info','total_hours','payment_month','departments_id','all_department_info','salary_info','user_id','all_payment_method','account_info','check_existing_payment','loan_info','check_salary_payment'));
    }

  public function edit_payment(Request $request){

   // input data


      $salary_payment=SalaryPayment::find($request->salary_id);  ;

                if( $salary_payment->account_id  == $request->account_id ){

               $old_account= Accounts::where('account_id',$request->account_id )->first();
if(!empty($old_account)){

      if( $salary_payment->fine_deduction <= $request->fine_deduction){
                    $diff=$request->fine_deduction-$salary_payment->fine_deduction;
                    $balance=  $old_account->balance - $diff;
                }

                if($salary_payment->fine_deduction > $request->fine_deduction){
                    $diff=$salary_payment->fine_deduction - $request->fine_deduction;
                $balance =   $old_account->balance + $diff;
                }

$item['balance']=$balance;
$old_account->update($item);
}
}

else{

$x_account= Accounts::where('account_id',$salary_payment->account_id)->first();

if(!empty($x_account)){
$dr_amount =JournalEntry::where('payment_id',  $request->salary_id )->where('name', 'Salary Payment')->whereNotNull('debit')->first();
$x_balance=$x_account->balance + $dr_amount->debit;
$x_item['balance']=$x_balance;
$x_account->update($x_item);
}


$account= Accounts::where('account_id',$request->account_id)->first();

if(!empty($account)){
$balance=$account->balance - $request->payment_amount;
$item_to['balance']=$balance;
$account->update($item_to);
}

else{
  $cr= AccountCodes::where('id',$request->account_id)->first();

     $new['account_id']=$request->bank_id;;
       $new['account_name']= $cr->account_name;
      $new['balance']=0-$request->payment_amount;
       $new[' exchange_code']='TZS';
        $new['added_by']=auth()->user()->added_by;
$balance=0-$request->payment_amount;
     Accounts::create($new);
}

}



                if( $salary_payment->account_id  == $request->account_id ){

               $old_account= Accounts::where('account_id',$request->account_id )->first();
if(!empty($old_account)){

      if( $salary_payment->bank_charges <= $request->bank_charges){
                    $diff=$request->bank_charges-$salary_payment->bank_charges;
                    $charge=  $old_account->balance - $diff;
                }

                if($salary_payment->bank_charges > $request->bank_charges){
                    $diff=$salary_payment->bank_charges - $request->bank_charges;
                $charge =   $old_account->balance + $diff;
                }

$citem['balance']=$charge;
$old_account->update($citem);
}
}

else{

$cx_account= Accounts::where('account_id',$salary_payment->account_id)->first();

if(!empty($cx_account)){
$dr_amount =JournalEntry::where('payment_id',  $request->salary_id )->where('name', 'Bank Charges')->whereNotNull('debit')->first();
$cx_balance=$cx_account->balance + $dr_amount->debit;
$cx_item['balance']=$cx_balance;
$cx_account->update($cx_item);
}


$account= Accounts::where('account_id',$request->account_id)->first();

if(!empty($account)){
$charge=$account->balance - $request->bank_charges;
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

} 




     $data['user_id']=$request->user_id ;
     $data['payment_month']=$request->payment_month ;
       $data['fine_deduction']=$request->fine_deduction ;
       $data['payment_type']=$request->payment_type ;
        $data['paid_date']=$request->paid_date ;
      $data['bank_charges']=$request->bank_charges ;
           $data['payment_amount']=  $request->payment_amount;
       $data['comments']=$request->comments ;
      $data['account_id']=$request->account_id ;
      $data['added_by']=auth()->user()->added_by ;
            $salary_payment->update($data);  ;

    $date = new DateTime($request->payment_month . '-01');
        $start_date = $date->modify('first day of this month')->format('Y-m-d');
        $end_date = $date->modify('last day of this month')->format('Y-m-d');

 $emp_info = User::find($request->user_id);
 $payroll_info  = EmployeePayroll::where('user_id', $request->user_id)->where('disabled','0')->first();
 $paye_info = SalaryDeduction::where('salary_template_id',$payroll_info->salary_template_id)->where('deduction_label','PAYE')->where('deduction_value', '>','0')->first();
 $nssf_info = SalaryDeduction::where('salary_template_id',$payroll_info->salary_template_id)->where('deduction_label','NSSF')->where('deduction_value', '>','0')->first();
$basic=SalaryTemplate::where('salary_template_id', $payroll_info->salary_template_id)->first();
$month= date('F Y', strtotime($request->payment_month)) ;

if(!empty( $salary_payment)){ 
$s=AccountCodes::where('account_name','Salaries')->where('added_by', auth()->user()->added_by)->first();   

          $journal = JournalEntry::where('payment_id',  $request->salary_id )->where('name', 'Salary Payment')->whereNotNull('debit')->first();;
        $journal->account_id = $s->account_id;
          $journal->user_id=$request->user_id ;
           $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
       $journal->transaction_type = 'salary';
        $journal->name = 'Salary Payment';
        $journal->debit= $request->payment_amount;
         $journal->payment_month=$request->payment_month;
        $journal->notes= "Net Salary Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->update();

        $journal = JournalEntry::where('payment_id',  $request->salary_id )->where('name', 'Salary Payment')->whereNotNull('credit')->first();;
        $journal->account_id =   $request->account_id;;
          $journal->user_id=$request->user_id ;
       $journal->transaction_type = 'salary';
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->name = 'Salary Payment';
        $journal->credit= $request->payment_amount;
        $journal->payment_month=$request->payment_month;
        $journal->notes= "Net Salary Payment to " .$emp_info->name. "  for the month ".  $month ;
        $journal->update();

$dt = explode('-', $request->paid_date);
  $journal = JournalEntry::where('payment_id',  $request->salary_id )->where('transaction_type', 'salary')->update([
   'date'=>$request->paid_date,
   'year'=> $dt[0],
   'month'=> $dt[1],

   ]);


// save into tbl_transaction
        
                                     $transaction= Transaction::where('module','Salary Payment')->where('module_id',$request->salary_id)->update([
                                        'module' => 'Salary Payment',
                                         'module_id' => $request->salary_id,
                                       'account_id' => $request->account_id,
                                        'code_id' => $s->account_id,
                                        'name' => 'Net Salary Payment to ' .$emp_info->name. '  for the month of '.  $month,
                                        'type' => 'Expense',                               
                                        'amount' =>$request->payment_amount ,
                                        'credit' => $request->payment_amount,
                                         'total_balance' =>$balance,
                                         'payment_methods_id'=>$request->payment_type,
                                           'status' => 'paid' ,
                                             'date' => date('Y-m-d', strtotime($request->paid_date)),
                                        'notes' => 'Net Salary Payment to ' .$emp_info->name. '  for the month of '.  $month,
                                        'user_id' => $request->user_id ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);
       
  
   }      


if(!empty($request->bank_charges)){ 
  $old_journal = JournalEntry::where('payment_id',  $request->salary_id )->where('name', 'Bank Charges')->whereNotNull('debit')->first();;
  if(!empty($old_journal)){

$bc=AccountCodes::where('account_name','Bank Charges')->where('added_by', auth()->user()->added_by)->first(); 
$journal = JournalEntry::where('payment_id',  $request->salary_id )->where('name', 'Bank Charges')->whereNotNull('debit')->first();;
        $journal->account_id = $bc->account_id;
          $journal->user_id=$request->user_id ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->debit= $request->bank_charges;       
        $journal->update();

       $journal = JournalEntry::where('payment_id',  $request->salary_id )->where('name', 'Bank Charges')->whereNotNull('credit')->first();;
        $journal->account_id =   $request->account_id;;
          $journal->user_id=$request->user_id ;
         $date = explode('-', $request->paid_date);
        $journal->date =   $request->paid_date ;
        $journal->year = $date[0];
        $journal->month = $date[1];
        $journal->credit= $request->bank_charges;       
        $journal->update();


 $transaction= Transaction::where('module','Bank Charges')->where('module_id',$request->salary_id)->update([                             
                                        'amount' =>$request->bank_charges ,
                                        'credit' => $request->bank_charges,
                                         'total_balance' =>$charge,
                                          'date' => date('Y-m-d', strtotime($request->paid_date)),
                                    ]);




}



else{
$bc=AccountCodes::where('account_name','Bank Charges')->where('added_by', auth()->user()->added_by)->first(); 
$journal = new JournalEntry();
        $journal->account_id = $bc->account_id;
          $journal->user_id=$request->user_id ;
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
          $journal->user_id=$request->user_id ;
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
                                        'user_id' => $request->user_id ,
                                        'added_by' =>auth()->user()->added_by,
                                    ]);


}
 
 }




          
if(!empty($salary_payment)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->added_by,
       'user_id'=>auth()->user()->id,
                            'module_id'=> $salary_payment->id,
                            'module'=>'Salary Payment',
                            'activity'=>"Salary Payment to " .$emp_info->name. "  for the month ".  $month. " has been Updated" ,
                        ]
                        );                      
       }
    
return redirect(route('view.payment',['departments_id'=>$emp_info->department_id,'payment_month'=>$request->payment_month]))->with(['success'=>'Payment Updated Successfully']);
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


}

return view('payroll.make_payment',compact('employee_info','flag','payment_month','departments_id','all_department_info','start_date','end_date'));
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
