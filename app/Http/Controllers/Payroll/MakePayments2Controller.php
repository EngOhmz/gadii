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
use App\Models\UserDetails\BasicDetails; 
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use DateTime;

class MakePayments2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1(Request $request)
    {
        //
       $all_department_info = Departments::all();
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
    public function index(Request $request,$user_id = NULL, $departments_id = NULL, $payment_month = NULL)
    {   $data['payment_flag'] = null;
        $data['flag'] = null;
        $departments_id = $request->departments_id;
        $user_id = $request->user_id;
        $payment_month = $request->payment_month;
        // retrive all data from department table
                $data['all_department_info'] = Departments::all();
                if ($user_id != 0 && !empty($payment_month)) {
        // check payment history by employee id
                    $check_existing_payment = SalaryPayment::all()->where('user_id', $user_id);
        
                    $data['user_id'] = $user_id;
                    $data['staff_details'] = BasicDetails::all()->where('user_id',$user_id)->last();
                    $total_slary_amount = 0;
                    if (!empty($check_existing_payment)) {
                        foreach ($check_existing_payment as $key => $v_paymented_id) {
                            $salary_payment_id = $v_paymented_id->salary_payment_id;
                            $data['emp_salary_info'] = $this->get_salary_payment_info($salary_payment_id);
                            $data['salary_payment_info'][] = $this->get_salary_payment_info($salary_payment_id, true);
        
                            $this->payroll_model->_table_name = "tbl_salary_payment_details"; // table name
                            $this->payroll_model->_order_by = "salary_payment_id"; // $id

                            $salary_payment_history = SalaryPaymentDetails::all()->where('salary_payment_id', $salary_payment_id);

                            if (!empty($salary_payment_history)) {
                                foreach ($salary_payment_history as $v_payment_history) {
                                    if (is_numeric($v_payment_history->salary_payment_details_value)) {
                                        if ($v_payment_history->salary_payment_details_label == 'overtime_salary') {
                                            $rate = $v_payment_history->salary_payment_details_value;
                                        } elseif ($v_payment_history->salary_payment_details_label == 'hourly_rates') {
                                            $rate = $v_payment_history->salary_payment_details_value;
                                        }
                                        $total_slary_amount += $v_payment_history->salary_payment_details_value;
                                    }
                                }
                            }
                           
                            $salary_allowance_info = SalaryPaymentAllowance::all()->where('salary_payment_id', $salary_payment_id);
                            $total_allowance = 0;
                            if (!empty($salary_allowance_info)) {
                                foreach ($salary_allowance_info as $v_salary_allowance_info) {
                                    $total_allowance += $v_salary_allowance_info->salary_payment_allowance_value;
                                }
                            }
                            if (!empty($rate)) {
                                $rate = $rate;
                            } else {
                                $rate = 0;
                            }
        
                            $data['total_paid_amount'][] = $total_slary_amount + $total_allowance - $rate;
                            SalaryPaymentDeduction::all()->where('salary_payment_id', $salary_payment_id);
                            $total_deduction = 0;
                            if (!empty($salary_deduction_info)) {
                                foreach ($salary_deduction_info as $v_salary_deduction_info) {
                                    $total_deduction += $v_salary_deduction_info->salary_payment_deduction_value;
                                }
                            }
                            $data['total_deduction'][] = $total_deduction;
                        }
                    }
                    $data['payment_month'] = $payment_month;
                    $data['payment_flag'] = 1;
                    $data['departments_id'] = $departments_id;
        // get employee info by employee id
                    $data['employee_info'] = $this->get_emp_salary_list($user_id);
        // get all allowance info by salary template id
                    if (!empty($data['employee_info']->salary_template_id)) {
                        $data['allowance_info'] = $this->get_allowance_info_by_id($data['employee_info']->salary_template_id);
        // get all deduction info by salary template id
                        $data['deduction_info'] = $this->get_deduction_info_by_id($data['employee_info']->salary_template_id);
        // get all overtime info by month and employee id
                        $data['overtime_info'] = $this->get_overtime_info_by_id($user_id, $data['payment_month']);
                    }
        // get all advance salary info by month and employee id
                    $data['advance_salary'] = $this->get_advance_salary_info_by_id($user_id, $data['payment_month']);
        // get award info by employee id and payment month
        // get award info by employee id and payment date
                    // $this->payroll_model->_table_name = 'tbl_employee_award';
                    // $this->payroll_model->_order_by = 'user_id';
                    // $data['award_info'] = $this->payroll_model->get_by(array('user_id' => $user_id, 'award_date' => $data['payment_month']), FALSE);
        // check hourly payment info
        // if exist count total hours in a month
        // get hourly payment info by id
                    if (!empty($data['employee_info']->hourly_rate_id)) {
                        $data['total_hours'] = $this->get_total_hours_in_month($user_id, $data['payment_month']);
                    }
                    if (!empty($data['total_hours'])) {
                        if ($data['total_hours'] == 0 && $data['total_minutes'] == 0) {
                            $type = 'error';
                            $message = '<strong>' . $data['employee_info']->fullname . ' ' . '</strong>' . lang('working_hour_empty');
                            set_message($type, $message);
                            redirect('admin/payroll/make_payment/' . '0' . '/' . $data['employee_info']->departments_id . '/' . $data['payment_month']);
                        }
                    }
                } else {
                    $flag = $request->flag;
                    if (!empty($flag) || !empty($departments_id)) { // check employee id is empty or not
                        $data['flag'] = 1;
                        if (!empty($departments_id)) {
                            $data['departments_id'] = $departments_id;
                        } else {
                            $data['departments_id'] = $request->departments_id;
                        }
                        if (!empty($payment_month)) {
                            $data['payment_month'] = $payment_month;
                        } else {
                            $data['payment_month'] = $request->payment_month;
                        }
        // get all designation info by Department id
                        $designation = $data['departments_id'];
                        if (!empty($designation)) {
                            
                                $data['employee_info'][] = $this->get_emp_salary_list('', $designation);
                                $employee_info = $this->get_emp_salary_list('', $designation);
                                foreach ($employee_info as $value) {
        
        // get all allowance info by salary template id
                                    if (!empty($value->salary_template_id)) {
                                        $data['allowance_info'][$value->user_id] = $this->get_allowance_info_by_id($value->salary_template_id);
        // get all deduction info by salary template id
                                        $data['deduction_info'][$value->user_id] = $this->get_deduction_info_by_id($value->salary_template_id);
        // get all overtime info by month and employee id
                                      //  $data['overtime_info'][$value->user_id] = $this->get_overtime_info_by_id($value->user_id, $data['payment_month']);
                                    }
        // get all advance salary info by month and employee id
                                   // $data['advance_salary'][$value->user_id] = $this->get_advance_salary_info_by_id($value->user_id, $data['payment_month']);
        // get award info by employee id and payment month
                                   // $data['award_info'][$value->user_id] = $this->get_award_info_by_id($value->user_id, $data['payment_month']);
        // check hourly payment info
        // if exist count total hours in a month
        // get hourly payment info by id
                                    if (!empty($value->hourly_rate_id)) {
                                        $data['total_hours'][$value->user_id] = $this->get_total_hours_in_month($value->user_id, $data['payment_month']);
                                    }
                                }
                            
                        }
                    }
                }
               // $data['subview'] = $this->load->view('admin/payroll/make_payment', $data, TRUE);
               //$this->load->view('admin/_layout_main', $data);

                return view('payroll.make_payment',compact('data'));
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

    public function get_salary_payment_info($salary_payment_id, $result = NULL, $search_type = null)
    {

        // $this->db->select('tbl_salary_payment.*', FALSE);
        // $this->db->select('tbl_account_details.*', FALSE);
        // $this->db->select('tbl_designations.*', FALSE);
        // $this->db->select('tbl_departments.deptname', FALSE);
        // $this->db->from('tbl_salary_payment');
        // $this->db->join('tbl_account_details', 'tbl_salary_payment.user_id = tbl_account_details.user_id', 'left');
        // $this->db->join('tbl_designations', 'tbl_designations.designations_id  = tbl_account_details.designations_id', 'left');
        // $this->db->join('tbl_departments', 'tbl_departments.departments_id  = tbl_designations.departments_id', 'left');
        if (!empty($search_type)) {
            if ($search_type == 'employee') {
                $this->db->where("tbl_salary_payment.user_id", $salary_payment_id);
            } elseif ($search_type == 'month') {
                $this->db->where("tbl_salary_payment.payment_month", $salary_payment_id);
            } elseif ($search_type == 'period') {
                $this->db->where("tbl_salary_payment.payment_month >=", $salary_payment_id['start_month']);
                $this->db->where("tbl_salary_payment.payment_month <=", $salary_payment_id['end_month']);
            }
        } else {
            $results = SalaryPayment::all()->where("salary_payment_id", $salary_payment_id);
        }
        //$query_result = $this->db->get();
        if (!empty($result)) {
            $result = $results;
        } else {
            $result = $results->last();
        }
        return $result;
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

}
