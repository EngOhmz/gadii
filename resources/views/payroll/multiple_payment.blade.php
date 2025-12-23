@extends('layouts.master')


@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <!-- *********     Employee Search Panel ***************** -->
            <div class="card-header">
                <h4>Make Multiple Payments</h4>
            </div>
<?php
   if (!empty($payment_month)) {
               
                                }
else{
  $payment_month='';
}

?>
            <form id="form" role="form" enctype="multipart/form-data" action="{{route('multiple_payment.store')}}"
                method="post" class="form-horizontal form-groups-bordered">
                @csrf
                <div class="card-body">
                    <div class="form-group offset-3">
                        <label for="field-1" class="col-sm-3 control-label">Select Department <span class="required">
                                *</span></label>

                        <div class="col-sm-5">
                            <select required name="departments_id" class="form-control m-b">
                                <option value="">Select Department </option>
                                <?php if (!empty($all_department_info)): foreach ($all_department_info as $v_department_info) :
                                    if (!empty($v_department_info->name)) {
                                        $deptname = $v_department_info->name;
                                    } else {
                                        $deptname = "Undifined Department";
                                    }
                                    ?>
                                <option value="<?php echo $v_department_info->id; ?>" <?php
                                        if (!empty($departments_id)) {
                                            echo $v_department_info->id == $departments_id ? 'selected' : '';
                                        }
                                        ?>><?php echo $deptname ?></option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group offset-3">
                        <label class="col-sm-3 control-label">Select Month <span class="required"> *</span></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input required type="month" value="<?php
                                if (!empty($payment_month)) {
                                    echo $payment_month;
                                }
                                ?>" class="form-control monthyear" name="payment_month" data-format="yyyy/mm/dd">

                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group offset-3" id="border-none">
                        <label for="field-1" class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                            <button id="submit" type="submit" name="flag" value="1" class="btn btn-primary btn-block">Go
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- ******************** Employee Search Panel Ends ******************** -->
        <?php if (!empty($flag)): ?>

        <div class="card">
            <div class="card-header">

                <span>
                    <strong>Payment Info for<?php
                                        if (!empty($payment_month)) {
                                            echo ' <span class="text-danger">' . date('F Y', strtotime($payment_month)) . '</span>';
                                        }
                                        ?></strong>
                </span>

            </div>
 <div class="card-body">
            <!-- Table -->
            <div class="table-responsive">
              
          {!! Form::open(array('route' => 'multiple_save.payment','method'=>'POST', 'id' => 'frm-example' , 'name' => 'frm-example')) !!}
                
                <table class="table datatable-basic table-striped"  id="table-1">
                    <thead>
                        <tr>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Employee Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Salary Grade</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Basic Salary</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Total Allowance</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Net Salary</th>
                                                  
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 228.1094px;"><input type="checkbox" name="select_all"  id="example-select-all"> Select All</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                      
                  
                    if (!empty($employee_info)):
                    
                        foreach ($employee_info as $v_employee): 

                   $allowance_info =   App\Models\Payroll\SalaryAllowance::where('salary_template_id',$v_employee->salary_template_id)->get();
                    $deduction_info =  App\Models\Payroll\SalaryDeduction::where('salary_template_id',$v_employee->salary_template_id)->get();
                     $salary_info = App\Models\Payroll\SalaryPayment::where('user_id', $v_employee->user_id)->where('payment_month', $payment_month)->first();
                   $overtime_info = App\Models\Payroll\Overtime::where('user_id',$v_employee->user_id)->where('overtime_date','>=', $start_date)->where('overtime_date','<=', $end_date)->where('status', '1')->get();  
                   $salary_overtime_info = App\Models\Payroll\Overtime::where('user_id',$v_employee->user_id)->where('overtime_date','>=', $start_date)->where('overtime_date','<=', $end_date)->where('status', '3')->get();                                    
                     $advance_salary=  App\Models\Payroll\AdvanceSalary::where('user_id',$v_employee->user_id)->where('deduct_month', $payment_month)->where('status', '1')->get();
                     $salary_advance_salary=  App\Models\Payroll\AdvanceSalary::where('user_id',$v_employee->user_id)->where('deduct_month', $payment_month)->where('status', '3')->get();
                      $loan_info=  App\Models\Payroll\EmployeeLoanReturn::where('user_id',$v_employee->user_id)->where('deduct_month', $payment_month)->where('status', '1')->get();
                    $salary_loan_info= App\Models\Payroll\ EmployeeLoanReturn::where('user_id',$v_employee->user_id)->where('deduct_month', $payment_month)->where('status', '3')->get();
                     $award_info=  App\Models\Payroll\EmployeeAward::where('user_id',$v_employee->user_id)->where('award_date', $payment_month)->where('status', '1')->get();;
                      $salary_award_info=  App\Models\Payroll\EmployeeAward::where('user_id',$v_employee->user_id)->where('award_date', $payment_month)->where('status', '3')->get();;
                      $total_hours = '0';



?>
                        <tr>
                           
                            <td> <?php echo $v_employee->user->name; ?></td>
                            
                            <td><?php
                                    $set_salary = false;
                                    if (!empty($v_employee->salaryTemplates->salary_grade)) {
                                        echo $v_employee->salaryTemplates->salary_grade;
                                    } else if (!empty($v_employee->hourly_grade)) {
                                        echo $v_employee->hourly_grade ;
                                    } else {
                                        echo '<span class="text-danger">did not set salary yet</span>';
                                        $set_salary = true;
                                    }
                                    ?></td>
                            <td><?php
                                    if (!empty($v_employee->salaryTemplates->basic_salary)) {
                                       echo number_format($v_employee->salaryTemplates->basic_salary,2) ;
                                    } else if (!empty($v_employee->salaryTemplates->hourly_grade)) {
                                        echo $v_employee->salaryTemplates->hourly_rate ;
                                    } else {
                                        echo '-';
                                    }
                                    ?></td>
                            <td><?php
                                    if (!empty($total_hours)) {
                                        foreach ($total_hours as  $v_total_hours) {
                                          
                                                if (!empty($v_total_hours)) {
                                                    $total_hour = $v_total_hours->total_hours;
                                                    $total_minutes = $v_total_hours->total_minutes;
                                                    if ($total_hour > 0) {
                                                        $hours_ammount = $total_hour * $v_employee->salaryTemplates->hourly_rate;
                                                    } else {
                                                        $hours_ammount = 0;
                                                    }
                                                    if ($total_minutes > 0) {
                                                        $amount = round($v_employee->salaryTemplates->hourly_rate / 60, 2);
                                                        $minutes_ammount = $total_minutes * $amount;
                                                    } else {
                                                        $minutes_ammount = 0;
                                                    }
                                                    if (!empty($advance_salary[$index])) {
                                                        $advance_amount = $advance_salary[$index]['advance_amount'];
                                                    } else {
                                                        $advance_amount = 0;
                                                    }
                                                    if (!empty($award_info[$index])) {
                                                        $total_award = $award_info[$index]['award_amount'];
                                                    } else {
                                                        $total_award = 0;
                                                    }
                                                    $total_amount = $hours_ammount + $minutes_ammount + $total_award - $advance_amount;
                                                    echo round($total_amount,2);
                                                }
                                            }
                                        }
                                  
                                    if (!empty($v_employee->salaryTemplates->basic_salary)) {
                                          $total_allowance = 0;
                                        if (!empty($allowance_info)) {
                                            foreach ($allowance_info as  $v_allowance) {
                                                    $total_allowance += $v_allowance->allowance_value; 
                                            }
                                        }
                                     $total_deduction = 0;
                                        if (!empty($deduction_info)) {
                                            foreach ($deduction_info as $v_deduction) {                                            
                                                  $total_deduction += $v_deduction->deduction_value; 
                                            }
                                        }
                                         $total_advance = 0;
                                        if (!empty($advance_salary)) {
                                            foreach ($advance_salary as  $v_advance) {                                            
                                                    $total_advance += $v_advance->advance_amount;                                               
                                            }
                                        }
                                     $total_a = 0;
                                        if (!empty($salary_advance_salary)) {
                                            foreach ($salary_advance_salary as  $s_advance) {                                            
                                                    $total_a += $s_advance->advance_amount;                                               
                                            }
                                        }
                                     $total_loan = 0;
                                        if (!empty($loan_info)) {
                                            foreach ($loan_info as  $v_loan) {                                            
                                                    $total_loan += $v_loan->loan_amount;                                               
                                            }
                                        }
                                       $total_l = 0;
                                        if (!empty($salary_loan_info)) {
                                            foreach ($salary_loan_info as $s_loan) {                                            
                                                    $total_l += $s_loan->loan_amount;                                               
                                            }
                                        }
                                       $total_award = 0;
                                        if (!empty($award_info)) {
                                            foreach ($award_info as  $v_award_info) {
                                                    $total_award += $v_award_info->award_amount;
                                            }
                                        }
                                    $total_aw = 0;
                                        if (!empty($salary_award_info)) {
                                            foreach ($salary_award_info as  $s_award_info) {
                                                    $total_aw += $s_award_info->award_amount;
                                            }
                                        }
                                     $total_amount=0;
                                        if (!empty($overtime_info)) {
                                            foreach ($overtime_info as  $v_overtime) {                                    
                                                    $total_amount += $v_overtime->overtime_amount;
                                                
                                            }
                                        }
                                      $total_ov=0;
                                        if (!empty($salary_overtime_info)) {
                                            foreach ($salary_overtime_info as  $s_overtime) {                                    
                                                    $total_ov += $s_overtime->overtime_amount;
                                                
                                            }
                                        }
                                    
                                     
                                        if (empty($v_employee->salaryTemplates->basic_salary)) {
                                            $basic_salary = 0;
                                        } else {
                                            $basic_salary = $v_employee->salaryTemplates->basic_salary;
                                        }
                                            $l=0;
                                       if(!empty($salary_info)){
                                    $l=$total_l;
                                       $ad=$total_a;
                              $overtime=$total_ov;
                          $award=$total_aw;
                         $fine =$salary_info->fine_deduction;
                                       }
                                         else{
                                   $l=$total_loan;
                                 $ad=$total_advance;
                              $overtime=$total_amount;
                          $award=$total_award;
                                  $fine =0;
}
                                        // check existing payment by employee id and payment month
                                        echo   number_format($total_allowance + $overtime + $award,2) ;; //sehemu ya kuonyesha net salary
                                    }
                                   
                                    ?></td>

                              <td>{{ number_format($basic_salary + $total_allowance + $overtime + $award - $total_deduction - $ad - $l-$fine,2) }}</td>
                            <td>
                                <?php if (!empty($salary_info) && $salary_info->user_id == $v_employee->user_id) { ?>
                                <span class="badge badge-success badge-shadow">Paid</span>
                                <?php
                                    } else {
                                        if (empty($set_salary)) {
                                            ?>
                                <span class="badge badge-danger badge-shadow">Not Paid</span>
                                <?php }
                                    } ?>
                            </td>
                            <td>

                                    <div class="form-inline">
                    @can('approve-payment')
                      
        <?php if (!empty($salary_info) && $salary_info->user_id == $v_employee->user_id) { ?>
                                <a class="list-icon text-success" target="_blank"
                                    href="{{route('payslip.generate',$salary_info->id)}}">Generate
                                    Payslip</a> &nbsp&nbsp
                                         <?php
                                                   $today = date('Y-m-d');
                                                   $next= date('Y-m-d', strtotime("+1 month", strtotime($salary_info->paid_date))) ;
                                                   ?>
                                     <?php  if ($today < $next) { ?>
                                     
                                    <?php } ?>
                                <?php } else {
                                        if (!empty($set_salary)) {
                                            ?>
                                <a class="list-icon text-danger" target="_blank"
                                    href="admin/payroll/manage_salary_details/<?php echo $v_employee->departments_id; ?>">Set
                                    Salary</a>&nbsp&nbsp
                                <?php } else {
                                            ?>
                                    <input name="item_id[]" type="checkbox"  class="checks" value="{{$v_employee->user_id}}">
                              
                                <?php }
                                    } ?>
                             
                        &nbsp&nbsp

                @else

               
        <?php if (!empty($salary_info) && $salary_info->user_id == $v_employee->user_id) { ?>
                                <a class="list-icon text-success" target="_blank"
                                    href="{{route('payslip.generate',$salary_info->id)}}">Generate
                                    Payslip</a>&nbsp&nbsp
                                <?php } else {
                                        if (!empty($set_salary)) {
                                            ?>
                                <a class="list-icon text-danger" target="_blank"
                                    href="admin/payroll/manage_salary_details/<?php echo $v_employee->departments_id; ?>">Set
                                    Salary</a>&nbsp&nbsp
                                <?php }
                                    } ?>
                             
                  @endcan                                                          
                    

                     
                @if (empty($salary_info)) 
                                <a href="#" class="list-icon text-info" title="View" data-toggle="modal" data-target="#appFormModal"  data-id="{{ $v_employee->id }}" data-type="template"   onclick="model({{ $v_employee->id }},'salary')">View</a>&nbsp&nbsp
                      @else          
<a href="#" class="list-icon text-info" title="View" data-toggle="modal" data-target="#appFormModal"  data-id="{{ $salary_info->id }}" data-type="template"   onclick="model({{ $salary_info->id }},'payment')">View</a> &nbsp&nbsp 
@endif                
                   
                    </div>
                                    
                            </td>
                        </tr>
                       
                        <?php endforeach; ?>
                        <?php endif; ?>

                                 
                    </tbody>
                </table>


<br>


<h4>Payment Details</h4>
<hr>
                   
                      
                            <div class="card-body">
                               <div class="row">
                  <div class="col-sm-12">

                          <div class="form-group row">
                                    <label class="col-lg-2 col-form-label">Payment Date <span class="required"> *</span></label>
                                   <div class="col-lg-4">
                                    <input type="date" name="paid_date"  value="<?php echo date('Y-m-d') ?>"    class="salary form-control">                            
                                </div>

                                    <label class="col-lg-2 col-form-label">Fine Deduction </label>
                                        <div class="col-lg-4">
                                    <input type="number" data-parsley-type="number" name="fine_deduction"
                                        id="fine_deduction" value="" class="form-control">
                                </div>
                                  </div>


 <div class="form-group row">
                                    <!-- Payment Type -->
                                    <label class="col-lg-2 control-label">Payment Method <span class="required"> *</span></label>
                                     <div class="col-lg-4">
                                    <select name="payment_type" class="form-control m-b"
                                        required>
                                        <option value="">Select Payment Method</option>
                                        <?php
                                 
                                    if (!empty($all_payment_method)) {
                                        foreach ($all_payment_method as $v_payment_method) {
                                            ?>
                                        <option  value="<?= $v_payment_method->id; ?>">
                                            <?= $v_payment_method->name; ?></option>
                                            <?php }
                                    } ?>
                                    </select>
                                </div><!-- Payment Type -->

                               
                                    <label class="col-lg-2 control-label">Payment Account <span class="required"> *</span></label>
                                 
                                           <div class="col-lg-4">
                                   <select name="account_id" style="width:100%;" class="form-control m-b select_box" required>
                                        <option value="">Select Payment Account</option>
                                            <?php
                                      
                                        if (!empty($account_info)) {
                                            foreach ($account_info as $v_account) : ?>
                                            <option value="<?= $v_account->id ?>"
                                               >
                                                <?= $v_account->account_name ?></option>
                                            <?php endforeach;
                                        }
                                        ?>
                                        </select>
                                </div>
                                 </div>

                                <div class="form-group row">
                                     <label class="col-lg-2 control-label">Comments </label>
                                     <div class="col-lg-4">
                                      <input type="text" name="comments" value="" class=" form-control">                                       
                                    </div>
                                  <label class="col-lg-2 control-label">Bank Charges</label>
                             <div class="col-lg-4">
                                       <input type="number"  name="bank_charges" class="form-control charge">                                       
                                    </div>
                                  </div>
                            

 <input type="hidden" name="payment_month" value="<?php
                            if (!empty($payment_month)) {
                                echo $payment_month;
                            }
                            ?>" class="salary form-control">

 <input type="hidden" name="department_id" value="<?php
                            if (!empty($departments_id)) {
                                echo $departments_id;
                            }
                            ?>" class="salary form-control">




</div>
</div>
</div>
</div>

                                                  <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                 <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>

 </div>
                                                </div>

 {!! Form::close() !!}
            </div>
</div>
        </div>
        <?php endif; ?>
      

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>

@endsection



@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>

<script>
$(document).ready(function (){
   var table = $('.datatable-basic').DataTable();
   


   // Handle form submission event 
   $('#frm-example').on('submit', function(e){
      var form = this;

         var rowCount = $('#table-1 >tbody >tr').length;
console.log(rowCount);


if(rowCount == '1'){
var c= $('#table-1 >tbody >tr').find('input[type=checkbox]');

  if(c.is(':checked')){ 
var tick=c.val();
console.log(tick);

$(form).append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', 'checked_item_id[]')
                  .val(tick)  );

}

}


else if(rowCount > '1'){
      // Encode a set of form elements from all pages as an array of names and values
      var params = table.$('input[type=checkbox]').serializeArray();

 
      // Iterate over all form elements
      $.each(params, function(){     
         // If element doesn't exist in DOM
         if(!$.contains(document, form[this.name])){
            // Create a hidden element 
            $(form).append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', 'checked_item_id[]')
                  .val(this.value)
            );
         } 
      });     

} 


   });  



    
});


</script>

    <script>
 var t = $('#table-1').DataTable();
 
$('#example-select-all').on('click', function(){
      var rows = t.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

$("input[type=checkbox]").click(function() {
  if (!$(this).prop("checked")) {
    $("#example-select-all").prop("checked", false);
  }
});



</script>


<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("salary_template.show", ":id") }}';
        url = url.replace(':id', id)
        var month = "<?php echo $payment_month; ?>";
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
                 'month': month,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
    </script>


@endsection