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
use App\Models\Payroll\Accounts;
use App\Models\Payroll\Overtime;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use DateTime;
use Session;

class GetPayment2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
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
    public function index(Request $request,$user_id = 0, $departments_id = NULL, $payment_month = NULL)
    {
        //
        // input data
        $data['user_id'] = 0;
        $departments_id = Session::get('departments_id');
        $payment_month = Session::get('payment_month');
        $data['payment_month'] =$payment_month;
        //$data = $request->all();
        
        //$this->payroll_model->array_from_post(array('user_id', 'payment_month', 'fine_deduction', 'payment_type', 'comments'));
//        // save into tbl employee paymenet
        // $this->payroll_model->_table_name = "tbl_salary_payment"; // table name
        // $this->payroll_model->_primary_key = "salary_payment_id"; // $id
        if (!empty($id)) {
            $details_data['salary_payment_id'] = $id;
            SalaryPayment::where('salary_payment_id',$id)->update($data);
            //$this->payroll_model->save($data, $id);
        } else {
            $data['deduct_from'] = 0;
            $result = SalaryPayment::create($data);
            $details_data['salary_payment_id'] = $result->id;
        }
// get employee info by employee id
        $employee_info = $this->get_emp_salary_list($data['user_id']);

// get all allowance info by salary template id
        if (!empty($employee_info->salary_template_id)) {
            $salary_payment_details_label[] = "Salary Grade";
            $salary_payment_details_value[] = $employee_info->salary_grade;

            $salary_payment_details_label[] = "Basic Salary";
            $salary_payment_details_value[] = $employee_info->basic_salary;
            if (!empty($employee_info->overtime_salary)) {
                $salary_payment_details_label[] = 'overtime_salary';
                $salary_payment_details_value[] = $employee_info->overtime_salary;
            }
// ************ Save all allwance info **********
            // $this->payroll_model->_table_name = 'tbl_salary_allowance';
            // $this->payroll_model->_order_by = 'salary_template_id';
            $allowance_info  = SalaryAllowance::all()->where('salary_template_id',$employee_info->salary_template_id);
            //$allowance_info = $this->payroll_model->get_by(array('salary_template_id' => $employee_info->salary_template_id), FALSE);
            if (!empty($allowance_info)) {
                foreach ($allowance_info as $v_allowance_info) {
                    $aldata['salary_payment_id'] = $details_data['salary_payment_id'];
                    $aldata['salary_payment_allowance_label'] = $v_allowance_info->allowance_label;
                    $aldata['salary_payment_allowance_value'] = $v_allowance_info->allowance_value;

//  save into tbl employee paymenet
                    // $this->payroll_model->_table_name = "tbl_salary_payment_allowance"; // table name
                    // $this->payroll_model->_primary_key = "salary_payment_allowance_id"; // $id
                    // $this->payroll_model->save($aldata);
                    SalaryAllowance::create($aldata);
                }
            }
// get all deduction info by salary template id
// ************ Save all deduction info **********
            // $this->payroll_model->_table_name = 'tbl_salary_deduction';
            // $this->payroll_model->_order_by = 'salary_template_id';
            $deduction_info = SalaryDeduction::all()->where('salary_template_id',$employee_info->salary_template_id);
            if (!empty($deduction_info)) {
                foreach ($deduction_info as $v_deduction_info) {
                    $salary_payment_deduction_label[] = $v_deduction_info->deduction_label;
                    $salary_payment_deduction_value[] = $v_deduction_info->deduction_value;
                }
            }
// ************ Save all Overtime info **********
// get all overtime info by month and employee id
            $overtime_info = $this->get_overtime_info_by_id($data['user_id'], $data['payment_month']);
            $salary_payment_details_label[] ="Overtime Our";
            $salary_payment_details_value[] = $overtime_info['overtime_hours'] . ':' . $overtime_info['overtime_minutes'];

            $overtime_hour = $overtime_info['overtime_hours'];
            $overtime_minutes = $overtime_info['overtime_minutes'];
            if ($overtime_hour > 0) {
                $ov_hours_ammount = $overtime_minutes * $employee_info->overtime_salary;
            } else {
                $ov_hours_ammount = 0;
            }
            if ($overtime_minutes > 0) {
                $ov_amount = round($employee_info->overtime_salary / 60, 2);
                $ov_minutes_ammount = $overtime_minutes * $ov_amount;
            } else {
                $ov_minutes_ammount = 0;
            }
            $overtime_amount = $ov_hours_ammount + $ov_minutes_ammount;
            $salary_payment_details_label[] = "Overtime Amount";
            $salary_payment_details_value[] = $overtime_amount;
        }
// ************ Save all Advance Salary info **********
// get all advance salary info by month and employee id
        $advance_salary = $this->get_advance_salary_info_by_id($data['user_id'], $data['payment_month']);
        if ($advance_salary['advance_amount']) {
            $salary_payment_deduction_label[] = "Advanced Amount";
            $salary_payment_deduction_value[] = $advance_salary['advance_amount'];
           // $advance_salary_info = $this->payroll_model->check_by(array('user_id' => $data['user_id'], 'deduct_month' => $data['payment_month']), 'tbl_advance_salary');
            $advance_salary_info = AdvanceSalary::all()->where('user_id',$data['user_id'])->where('deduct_month',$data['payment_month'])->last();
            if (!empty($advance_salary_info)) {
          
                $advnce_slry_date['status'] = 3;
                AdvanceSalary::where('advance_salary_id',$advance_salary_info->advance_salary_id)->update($advnce_slry_date);
                
            }
        }
// ************ Save all Hourly info **********
// check hourly payment info
// if exist count total hours in a month
// get hourly payment info by id
        if (!empty($employee_info->hourly_rate_id)) {
            $total_hours = $this->get_total_hours_in_month($data['user_id'], $data['payment_month']);
            $salary_payment_details_label[] = "Houry Grade";
            $salary_payment_details_value[] = $employee_info->hourly_grade;

            $salary_payment_details_label[] = 'hourly_rates';
            $salary_payment_details_value[] = $employee_info->hourly_rate;

            $salary_payment_details_label[] = "Total Houry";
            $salary_payment_details_value[] = $total_hours['total_hours'] . ':' . $total_hours['total_minutes'];

            $total_hour = $total_hours['total_hours'];
            $total_minutes = $total_hours['total_minutes'];
            if ($total_hour > 0) {
                $hours_ammount = $total_hour * $employee_info->hourly_rate;
            } else {
                $hours_ammount = 0;
            }
            if ($total_minutes > 0) {
                $amount = round($employee_info->hourly_rate / 60, 2);
                $minutes_ammount = $total_minutes * $amount;
            } else {
                $minutes_ammount = 0;
            }
            $total_hours_amount = $hours_ammount + $minutes_ammount;
            $salary_payment_details_label[] = "Amount";
            $salary_payment_details_value[] = $total_hours_amount;
        }
// get award info by employee id and payment date
//         $this->payroll_model->_table_name = 'tbl_employee_award';
//         $this->payroll_model->_order_by = 'user_id';
//         $award_info = $this->payroll_model->get_by(array('user_id' => $data['user_id'], 'award_date' => $data['payment_month']), FALSE);
//         if (!empty($award_info)) {
//             foreach ($award_info as $v_award_info) {
//                 $salary_payment_details_label[] = lang('award_name') . '
// <small> ( ' . $v_award_info->award_name . ' )</small>';
//                 $salary_payment_details_value[] = $v_award_info->award_amount;
//             }
//         }
        if (!empty($salary_payment_details_label)) {
            foreach ($salary_payment_details_label as $key => $payment_label) {
                $details_data['salary_payment_details_label'] = $payment_label;
                $details_data['salary_payment_details_value'] = $salary_payment_details_value[$key];

//  save into tbl employee paymenet
             
                SalaryPaymentDetails::create($details_data);
               
        }
        if (!empty($salary_payment_deduction_label)) {
            foreach ($salary_payment_deduction_label as $dkey => $deduction_label) {
                $ddetails_data['salary_payment_id'] = $details_data['salary_payment_id'];
                $ddetails_data['salary_payment_deduction_label'] = $deduction_label;
                $ddetails_data['salary_payment_deduction_value'] = $salary_payment_deduction_value[$dkey];

//  save into tbl employee paymenet
             
                SalaryDeduction::create($ddetails_data);
                
            }
        }
        if (!empty($employee_info->hourly_rate_id) || !empty($employee_info->salary_template_id)) {

            $deduct_from_account = $request->deduct_from_account;
            if (!empty($deduct_from_account)) {
                $account_id = $request->account_id;
                if (empty($account_id)) {
                    $account_id = 1;
                }
                if (!empty($account_id)) {
                    $reference = "Monthly Salary" . ' : ' . date('F Y', strtotime($data['payment_month'])) . ' ' . "Salary Payment" . ' ' . "For" . ' ' . $employee_info->full_name . ' ' . "And" . ' ' . "Comments" . ': ' . $data['comments'];
// save into tbl_transaction
                    $tr_data = array(
                        'name' => "Salary Payment" . ' ' . "For". ' ' . $employee_info->full_name,
                        'type' => 'Expense',
                        'amount' => $request->payment_amount,
                        'debit' => $request->payment_amount,
                        'date' => date('Y-m-d'),
                        'paid_by' => '0',
                        'payment_methods_id' => $request->payment_type,
                        'reference' =>"Monthly Salary" . ' ' . $request->payment_month,
                        'notes' => "hhh",
                        'permission' => 'all',
                    );
                    $account_info = Accounts::find($account_id);
                    //$this->payroll_model->check_by(array('account_id' => $account_id), 'tbl_accounts');
                    if (!empty($account_info)) {
                        $ac_data['balance'] = $account_info->balance - $tr_data['amount'];
                        // $this->payroll_model->_table_name = "tbl_accounts"; //table name
                        // $this->payroll_model->_primary_key = "account_id";
                        // $this->payroll_model->save($ac_data, $account_info->account_id);
                        Accounts::where('account_id',$account_info->account_id)->update($ac_data);

                        //$aaccount_info = $this->payroll_model->check_by(array('account_id' => $account_id), 'tbl_accounts');
                        $aaccount_info = Accounts::find($account_id);
                        $tr_data['total_balance'] = $aaccount_info->balance;
                        $tr_data['account_id'] = $account_id;
// save into tbl_transaction
                        // $this->payroll_model->_table_name = "tbl_transactions"; //table name
                        // $this->payroll_model->_primary_key = "transactions_id";
                        // $return_id = $this->payroll_model->save($tr_data);

// save into activities
                 

                        // $this->payroll_model->_table_name = "tbl_salary_payment"; // table name
                        // $this->payroll_model->_primary_key = "salary_payment_id"; // $id
                        $deduct_account['deduct_from'] = $account_id;
                        SalaryPayment::where('salary_payment_id',$details_data['salary_payment_id'])->update($deduct_account);
                       // $this->payroll_model->save($deduct_account, $details_data['salary_payment_id']);
                    }
                }
            }

        }

        // $type = 'success';
        // $message = lang('payment_information_update');
        // set_message($type, $message);
        //redirect('admin/payroll/make_payment/0/' . $employee_info->departments_id . '/' . $data['payment_month']);
    }
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
