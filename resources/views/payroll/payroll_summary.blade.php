@extends('layouts.master')


@section('content')
<div class="row">
    <div class="col-sm-12" >
        <div class="card">
            <!-- *********     Employee Search Panel ***************** -->
            <div class="card-header">
                <h4>Payroll Summary</h4>
            </div>

            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal form-groups-bordered', 'name' => 'form')) !!}  
                {{csrf_field()}}
                <div class="card-body">
                      <div class="form-group offset-3">
                        <label  for="field-1" class="col-sm-3 control-label">Search Type <span
                                class="required"> *</span></label>

                        <div class="col-sm-5">
                            <select required name="search_type" id="search_type" class="form-control search" required  onchange = "ShowHideDiv()">
                                <option value="">Select Search Type</option>
                                <option value="employee" <?php if (!empty($search_type)) {
                                    echo $search_type == 'employee' ? 'selected' : '';
                                } ?>>By Employee</option>

                                <option value="month" <?php if (!empty($search_type)) {
                                    echo $search_type == 'month' ? 'selected' : '';
                                } ?>>By Month</option>

                                <option value="period" <?php if (!empty($search_type)) {
                                    echo $search_type == 'period' ? 'selected' : '';
                                } ?>>By Period</option>

                                <option value="activities" <?php if (!empty($search_type)) {
                                    echo $search_type == 'activities' ? 'selected' : '';
                                } ?>>All Activities</option>

                            </select>
                        </div>
                    </div>

                <script type="text/javascript">
                     function ShowHideDiv() {
                  var ddlPassport = document.getElementById("search_type");
                var dfPassport = document.getElementById("employee");
               var daPassport = document.getElementById("month");
             var dzPassport = document.getElementById("period");
              dfPassport.style.display = ddlPassport.value == "employee" ? "block" : "none";
  daPassport.style.display = ddlPassport.value == "month" ? "block" : "none";
             dzPassport.style.display = ddlPassport.value == "period" ? "block" : "none";
    }
             </script>

                    <div class="by_employee" id="employee"
                         style="display: <?= !empty($search_type) && $search_type == 'employee' ? 'block' : 'none' ?>">
                         <div class="form-group offset-3">
                            <label for="field-1"
                                   class="col-sm-3 control-label">Employee Name
                                <span
                                    class="required"> *</span></label>

                            <div class="col-sm-5">
                                <select class="by_employee form-control select_box" style="width: 100%" name="user_id">
                                    <option value="">Select Employee</option>
                                    <?php
                                    if (!empty($all_employee)): ?>
                                        <?php foreach ($all_employee as $v_employee) : ?>
                                                    <option value="<?php echo $v_employee->id; ?>"
                                                        <?php
                                                        if (!empty($user_id)) {
                                                            echo $v_employee->id == $user_id ? 'selected' : '';
                                                        }
                                                        ?>><?php echo $v_employee->name  ?></option>
                                               
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="by_month" id="month"
                         style="display: <?= !empty($search_type) && $search_type == 'month' ? 'block' : 'none' ?>">
                       <div class="form-group offset-3">
                            <label class="col-sm-3 control-label">Select Month <span
                                    class="required"> *</span></label>
                            <div class="col-sm-5">
                              
                                    <input  type="month" value="<?php
                                    if (!empty($by_month)) {
                                        echo $by_month;
                                    }
                                    ?>" class="form-control monthyear by_month" name="by_month"
                                           data-format="yyyy/mm/dd">

                                 
                            </div>
                        </div>
                    </div>

                    <div class="by_period" id="period"
                         style="display: <?= !empty($search_type) && $search_type == 'period' ? 'block' : 'none' ?>">
                        <div class="form-group offset-3">
                            <label class="col-sm-3 control-label">Start Month <span
                                    class="required"> *</span></label>
                            <div class="col-sm-5">
                               
                                    <input type="month" value="<?php
                                    if (!empty($start_month)) {
                                        echo $start_month;
                                    }
                                    ?>" class="by_period form-control monthyear" name="start_month"
                                           data-format="yyyy/mm/dd">

                                  
                                </div>
                            </div>
                      
                       <div class="form-group offset-3">
                            <label class="col-sm-3 control-label">End Month <span
                                    class="required"> *</span></label>
                            <div class="col-sm-5">
                             
                                    <input type="month" value="<?php
                                    if (!empty($end_month)) {
                                        echo $end_month;
                                    }
                                    ?>" class="by_period form-control monthyear" name="end_month"
                                           data-format="yyyy/mm/dd">

                                 
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="form-group offset-3" id="border-none">
                        <label for="field-1" class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                            <button id="submit" type="submit" name="flag" value="1"
                                    class="btn btn-primary btn-block">Go
                            </button>
                        </div>
                    </div>
                </div>
  </div>
            </form>
        </div><!-- ******************** Employee Search Panel Ends ******************** -->
        

<!-- ******************** Employee Search Result ******************** -->



<?php if (!empty($search_type) && $search_type != 'activities') {
if ($search_type == 'period') {
    $by = 'From ' . date('F Y', strtotime($start_month)) . ' to ' . date('F Y', strtotime($end_month));
}
elseif ($search_type == 'month') {
    $by = ' For the month of  ' . date('F Y', strtotime($by_month));
}
elseif ($search_type == 'employee') {
  $user_info = App\Models\User::where('id', $user_id)->first();
    $by = 'For ' . $user_info->name;
}
?>
  <div class="card">
                            <!-- Default panel contents -->
                            <div class="card-header"><strong>Payroll Summary <?php echo $by ?></strong> </div>
                            <div class="card-body">  
   <!-- Table -->
                   <div class="table-responsive">
                <table class="table table-striped "id="table-1">
                        <thead>
                        <tr> 
                       <th>#</th>
                            <?php if ($search_type == 'month' || $search_type == 'period' ) { ?>
                                 <th>Name</th>
                                 <?php } ?>
                            <th>Month</th>
                            <th>Date</th>
                            <th>Gross Salary</th>
                            <th>Total Deduction</th>
                            <th>Net Salary</th>
                            <th>Fine Deduction</th>
                            <th>Amount</th>
                            <th>Details</th>
                        </tr>
                        </thead>
                        <tbody>
                      
                          @if (!empty($check_existing_payment))
                    <?php $total_paid_amount=0; ?>
                        @foreach ($check_existing_payment as $row)
                        <tr>
                           <td> <?php echo $loop->iteration; ?></td>
                             <?php if ($search_type == 'month' || $search_type == 'period' ) { 
                                       $a = App\Models\User::where('id', $row->user_id)->first();
                                       ?>
                                 <td><?php echo $a->name; ?></td>
                                 <?php } ?>
                            <td> <?php echo date('F Y', strtotime($row->payment_month)); ?></td>
                            
                            <td><?php echo date('d/m/ Y', strtotime($row->paid_date)); ?>  </td>

                              <?php
                   $ttl_deduction =App\Models\Payroll\SalaryPaymentDeduction::all()->where('salary_payment_id', $row->id)->sum('salary_payment_deduction_value');;;         
                    $ttl_allowance  = App\Models\Payroll\SalaryPaymentAllowance::all()->where('salary_payment_id', $row->id)->sum('salary_payment_allowance_value');;
                     $total_salary = App\Models\Payroll\ SalaryPaymentDetails::where('salary_payment_id', $row->id)->where('salary_payment_details_label', '!=', 'Salary Grade')->sum('salary_payment_details_value');
                       $total_paid_amount= $total_salary +  $ttl_allowance;     

?>
                            <td><?php echo  number_format($total_paid_amount,2) ;;?></td>
                                 <td><?php echo  number_format($ttl_deduction,2) ;;?></td>
                               <td><?php echo  number_format($total_paid_amount - $ttl_deduction,2) ;;?></td>
                            
                       <td><?php echo  number_format( $row->fine_deduction,2) ;;?></td>
  <td><?php echo  number_format(($total_paid_amount - $ttl_deduction)- $row->fine_deduction,2) ;;?></td>   
                            
                          
                            <td>

                                    <div class="form-inline">
                   

                      <div class = "input-group"> 
                      
                                <a href="#" class="btn btn-info btn-xs" title="View" data-toggle="modal" data-target="#appFormModal"  data-id="{{ $row->id }}" data-type="template"   onclick="model({{ $row->id }},'payment')">View Payment Details</a>
                                               
                    </div>&nbsp
                    </div>
                                    
                            </td>
                        </tr>
                       
                         @endforeach
                           @endif
                        </tbody>
                    </table>
                </div>
</div>
</div>
 <?php } ?>
<!--************ Employee Result End***********-->


<!--************ Activity Result End***********-->
<?php if (!empty($search_type) && $search_type == 'activities') {

?>
  <div class="card">
                            <!-- Default panel contents -->
                            <div class="card-header"><strong>Payroll Summary </strong> </div>
                            <div class="card-body">  
   <!-- Table -->
                   <div class="table-responsive">
                <table class="table table-striped "id="table-1">
                        <thead>
                        <tr>
                          <th>#</th>
                            <th>Activity Date</th>
                          
                            <th>Activity</th>
                           <th>Performed by</th>
                        </tr>
                        </thead>
                        <tbody>
                      
                          @if (!empty($check_existing_payment))
                        @foreach ($check_existing_payment as $row)
                        <tr>
                             <td> <?php echo $loop->iteration; ?></td>
                            <td><?php echo date('d/m/ Y', strtotime($row->date)); ?>  </td>
                            <td><?php echo  $row->activity ;;?></td>
                                 <td><?php echo  $row->user->name ;;?></td> 
                       
                        </tr>
                       
                         @endforeach
                           @endif
                        </tbody>
                    </table>
                </div>
</div>
</div>
 <?php } ?>


<!-- discount Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>
</div>
</div>
@endsection



@section('scripts')
<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("salary_template.show", ":id") }}';
        url = url.replace(':id', id)

        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
               
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