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
use App\Models\Payroll\Payslip;
use App\Models\Payment_methodes;
use App\Models\AccountCodes;
use App\Models\JournalEntry;
use App\Models\UserDetails\BasicDetails;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use  DateTime;
use PDF;

class GetPaymentController extends Controller
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


       public function nssf(Request $request)
    {
        //

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

                $nssf_salary_info[$i] =  JournalEntry::where('payment_month', $month)->where('transaction_type','salary')->where('name','NSSF Payment')->whereNotNull('debit')->get();
             $user_nssf_salary_info[$i] =JournalEntry::where('payment_month', $month)->where('user_id',$user)->where('transaction_type','salary')->where('name','NSSF Payment')->whereNotNull('debit')->get();
            }

 return view('payroll.provident_fund_info',compact('current_month','year','nssf_salary_info','user_nssf_salary_info'));
    }

  public function tax(Request $request)
    {
        //

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

                $nssf_salary_info[$i] =  JournalEntry::where('payment_month', $month)->where('transaction_type','salary')->where('name','PAYE Payment')->whereNotNull('debit')->get();
             $user_nssf_salary_info[$i] =JournalEntry::where('payment_month', $month)->where('user_id',$user)->where('transaction_type','salary')->where('name','PAYE Payment')->whereNotNull('debit')->get();
            }

 return view('payroll.tax_deduction_info',compact('current_month','year','nssf_salary_info','user_nssf_salary_info'));
    }

  public function nhif(Request $request)
    {
        //

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

                $nssf_salary_info[$i] =  JournalEntry::where('payment_month', $month)->where('transaction_type','salary')->where('name','NHIF Payment')->whereNotNull('credit')->get();
             $user_nssf_salary_info[$i] =JournalEntry::where('payment_month', $month)->where('user_id',$user)->where('transaction_type','salary')->where('name','NHIF Payment')->whereNotNull('debit')->get();
            }

 return view('payroll.nhif_contr',compact('current_month','year','nssf_salary_info','user_nssf_salary_info'));
    }

  public function wcf(Request $request)
    {
        //

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

                $nssf_salary_info[$i] =  JournalEntry::where('payment_month', $month)->where('transaction_type','salary')->where('name','WCF Contribution Payment')->whereNotNull('debit')->get();
             $user_nssf_salary_info[$i] =JournalEntry::where('payment_month', $month)->where('user_id',$user)->where('transaction_type','salary')->where('name','WCF Contribution Payment')->whereNotNull('debit')->get();
            }

 return view('payroll.wcf_info',compact('current_month','year','nssf_salary_info','user_nssf_salary_info'));
    }


 public function payroll_summary(Request $request)
    {
        //

    $all_employee=User::where('id','!=',1)->get();

 $search_type = $request->search_type;
 $check_existing_payment='';
$start_month='';
$end_month='';
$by_month='';
$user_id='';
$flag = $request->flag;

 

if (!empty($flag)) {
            if ($search_type == 'employee') {
             $user_id = $request->user_id;
             $check_existing_payment = SalaryPayment::where('user_id', $user_id)->get();
            }
            else if ($search_type == 'month') {
            $by_month = $request->by_month;
             $check_existing_payment = SalaryPayment::all()->where('payment_month', $by_month);
            }
            else if ($search_type == 'period') {
              $start_month = $request->start_month;
              $end_month = $request->end_month;
             $check_existing_payment = SalaryPayment::all()->where('payment_month','>=', $start_month)->where('payment_month','<=', $end_month);
            }
           elseif ($search_type == 'activities') {
             $check_existing_payment =PayrollActivity::all();
            }
}
else{
 $check_existing_payment='';
$start_month='';
$end_month='';
$search_type='';
$by_month='';
$user_id='';
        }

 

 return view('payroll.payroll_summary',compact('all_employee','check_existing_payment','start_month','end_month','search_type','by_month','user_id','flag'));
    }

 public function generate_payslip (Request $request)
    {
        //
     
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
 $start_date ='';
  $loan_info='';
 $end_date='';

$all_department_info=Departments::all();
if (!empty($flag) || !empty($departments_id)) {
    $payment_month = $request->payment_month;    
     $date = new DateTime($payment_month . '-01');
        $start_date = $date->modify('first day of this month')->format('Y-m-d');
        $end_date = $date->modify('last day of this month')->format('Y-m-d');
  
                          $employee_info  = EmployeePayroll::where('department_id',$departments_id)->get();



}

return view('payroll.generate_payslip',compact('employee_info','flag','payment_month','departments_id','all_department_info','start_date','end_date'));
 
    }

 public function received_payslip ($id)
    {
        //
    $check_existing_payment = SalaryPayment::find($id);
   $employee_info = User::find($check_existing_payment->user_id);
$month= date('F Y', strtotime($check_existing_payment->payment_month)) ;
$salary_payment_details_info=SalaryPaymentDetails::where('salary_payment_id', $id)->get();
$allowance_info=SalaryPaymentAllowance::where('salary_payment_id', $id)->get();
$deduction_info=SalaryPaymentDeduction::where('salary_payment_id', $id)->get();

       $payslip=Payslip::where('salary_payment_id',$id)->first();
        if(!empty($payslip)){
          $payslip_number = $payslip->payslip_number;
          }
        else{
         $data['salary_payment_id']=$id;
         $data['added_by']=auth()->user()->id;
         $slip= Payslip::create($data);

          $pdata['payslip_number'] = date('Ym') . $slip->id;
          $p=date('Ym') . $slip->id;
           Payslip::where('id', $slip->id)->update($pdata);
       


         if(!empty($slip)){
                    $activity =PayrollActivity::create(
                        [ 
                            'added_by'=>auth()->user()->id,
                            'module_id'=> $slip->id,
                            'module'=>'Payslip',
                            'activity'=>"Payslip ". $p. " has been generated for  " .$employee_info->name. "  for the month ".  $month ,
                        ]
                        );                      
       }

   }                
     $pay=Payslip::where('salary_payment_id',$id)->first();
return view('payroll.payslip_info',compact('pay','check_existing_payment','id','employee_info','month','salary_payment_details_info','allowance_info','deduction_info'));
 
    }

public function payslip_pdfview(Request $request)
   {
       //
    $pay=Payslip::find($request->id);
    $check_existing_payment = SalaryPayment::where('id',$pay->salary_payment_id)->first();
   $employee_info = User::find($check_existing_payment->user_id);
$month= date('F Y', strtotime($check_existing_payment->payment_month)) ;
$salary_payment_details_info=SalaryPaymentDetails::where('salary_payment_id',$pay->salary_payment_id)->get();
$allowance_info=SalaryPaymentAllowance::where('salary_payment_id', $pay->salary_payment_id)->get();
$deduction_info=SalaryPaymentDeduction::where('salary_payment_id', $pay->salary_payment_id)->get();



       view()->share(['pay'=>$pay,'check_existing_payment'=> $check_existing_payment,'employee_info'=> $employee_info,'month'=> $month,'salary_payment_details_info'=>$salary_payment_details_info,
         'allowance_info'=> $allowance_info,'deduction_info'=> $deduction_info]);

       if($request->has('download')){
       $pdf = PDF::loadView('payroll.payslip_info_pdf')->setPaper('a4', 'landscape');
      return $pdf->download('PAYSLIP NO # ' .  $pay->payslip_number . ".pdf");
       }
       return view('payslip_pdfview');
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

    public function get_emp_salary_list($id = NULL, $designation_id = NULL)
    {
        // $this->db->select('tbl_employee_payroll.*', FALSE);
        // $this->db->select('tbl_account_details.*', FALSE);
        // $this->db->select('tbl_salary_template.*', FALSE);
        // $this->db->select('tbl_hourly_rate.*', FALSE);
        // $this->db->select('tbl_designations.*', FALSE);
        // $this->db->select('tbl_departments.deptname', FALSE);
        // $this->db->from('tbl_employee_payroll');
        // $this->db->join('tbl_account_details', 'tbl_employee_payroll.user_id = tbl_account_details.user_id', 'left');
        // $this->db->join('tbl_salary_template', 'tbl_employee_payroll.salary_template_id = tbl_salary_template.salary_template_id', 'left');
        // $this->db->join('tbl_hourly_rate', 'tbl_employee_payroll.hourly_rate_id = tbl_hourly_rate.hourly_rate_id', 'left');
        // $this->db->join('tbl_designations', 'tbl_designations.designations_id  = tbl_account_details.designations_id', 'left');
        // $this->db->join('tbl_departments', 'tbl_departments.departments_id  = tbl_designations.departments_id', 'left');
        
        $query_result = DB::table('tbl_employee_payroll')
            ->join('tbl_salary_template', 'tbl_employee_payroll.salary_template_id', '=', 'tbl_salary_template.salary_template_id','left')
            ->join('basic_details', 'tbl_employee_payroll.user_id', '=', 'basic_details.user_id')
            ->select('tbl_employee_payroll.*', 'tbl_salary_template.*', 'basic_details.*')
            ->get();
          
        
        if (!empty($id)) {
            //$this->db->where('tbl_employee_payroll.user_id', $id);
            //$query_result = EmployeePayroll::with('salaryTemplates')->where('user_id', $id)->get();
            //$result = $query_result->last();
            // $this->db->where('tbl_employee_payroll.user_id', $id);
            // $query_result = $this->db->get();
            // $result = $query_result->row();
            $query_result = DB::table('tbl_employee_payroll')
            ->join('tbl_salary_template', 'tbl_employee_payroll.salary_template_id', '=', 'tbl_salary_template.salary_template_id','left')
            ->join('basic_details', 'tbl_employee_payroll.user_id', '=', 'basic_details.user_id')
            ->where('tbl_employee_payroll.user_id', $id)
            ->select('tbl_employee_payroll.*', 'tbl_salary_template.*', 'basic_details.*')
            ->get();
            $result = $query_result->last();
        }elseif(!empty($designation_id)){
            //$query_result = EmployeePayroll::with('salaryTemplates')->get();
            //->where('designations_id', $designation_id);
            //$result = $query_result->last();
            $query_result = DB::table('tbl_employee_payroll')
            ->join('tbl_salary_template', 'tbl_employee_payroll.salary_template_id', '=', 'tbl_salary_template.salary_template_id','left')
            ->join('basic_details', 'tbl_employee_payroll.user_id', '=', 'basic_details.user_id')
            ->select('tbl_employee_payroll.*', 'tbl_salary_template.*', 'basic_details.*')
            ->row();
            $result = $query_result;
        } else {
            
            //$result = EmployeePayroll::with('salaryTemplates')->get();
            $result = $query_result;
        }
        return $result;
    }

    public function get_advance_salary_info_by_id($user_id, $payment_month)
    {

        $advance_salary_info = $this->get_advance_salary_info_by_date($payment_month, '', $user_id); // get all report by start date and in date
        $advance_amount = 0;
        foreach ($advance_salary_info as $v_advance_salary) {
            $advance_amount += $v_advance_salary->advance_amount;
        }
        $result['advance_amount'] = $advance_amount;
        return $result;

    }

    public function get_advance_salary_info_by_date($payment_month = NULL, $id = NULL, $user_id = NULL)
    {    
        $query_result = DB::table('tbl_advance_salary')
        ->join('basic_details', 'tbl_advance_salary.user_id', '=', 'basic_details.user_id')
        ->select('tbl_advance_salary.*', 'basic_details.*')
        ->get();

        
       
        // if ($this->session->userdata('user_type') != 1) {
        //     $this->db->where('tbl_advance_salary.user_id', $this->session->userdata('user_id'));
        //     $this->db->where('tbl_advance_salary.deduct_month', $payment_month);
        //     $query_result = $this->db->get();
        //     $result = $query_result->result();
        // } else
        
        if (!empty($id)) {
            $query_result = DB::table('tbl_advance_salary')
            ->join('basic_details', 'tbl_advance_salary.user_id', '=', 'basic_details.user_id')
            ->where('tbl_advance_salary.advance_salary_id', $id)
            ->select('tbl_advance_salary.*', 'basic_details.*')
            ->last();
            
            //$result = $query_result->last();
            $result = $query_result;
            echo "<pre>";
            print_r($result);
            exit();
        } elseif (!empty($user_id)) {
            $query_result = DB::table('tbl_advance_salary')
            ->join('basic_details', 'tbl_advance_salary.user_id', '=', 'basic_details.user_id')
            ->where('tbl_advance_salary.status', '1')
            ->where('basic_details.user_id', $user_id)
            ->select('tbl_advance_salary.*', 'basic_details.*')
            ->get();
            
            
            $result = $query_result;
        } else {
            $query_result = DB::table('tbl_advance_salary')
            ->join('basic_details', 'tbl_advance_salary.user_id', '=', 'basic_details.user_id')
            ->where('tbl_advance_salary.deduct_month', $payment_month)
            
            ->select('tbl_advance_salary.*', 'basic_details.*')
            ->get();
            $this->db->where('tbl_advance_salary.deduct_month', $payment_month);
            
            $result = $query_result;
        }
        return $result;
    }

}
