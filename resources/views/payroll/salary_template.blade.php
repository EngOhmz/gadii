@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Salary Template</h4>
                    </div>
                    <?php
            $created =1;
            $edited = 2;
            $deleted = 3;
            ?>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a
                                    class="nav-link @if(empty($id)) active show @endif" href="#home2"
                                    data-toggle="tab">Sallary
                                    Template List</a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if(!empty($id)) active show @endif"
                                    href="#profile2" data-toggle="tab">New
                                    Template</a></li>
                        </ul>
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">

                                <div class="table-responsive">
                                    <table class="table table-striped " id="table-1">
                                        <thead>
                                            <tr>
                                                <th >#</th>
                                                <th>Salary Grade</th>
                                                <th>Basic Salary</th>
                                           
                                                <th class="col-sm-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                                                @if(!@empty($salary))
                                                                @foreach ($salary as $row)
                                                                <tr class="gradeA even" role="row">
                                                                    <th>{{ $loop->iteration }}</th>
                                                                    <td>{{$row->salary_grade}}</td>
                                                                      <td>{{number_format($row->basic_salary,2)}}</td>
                              
                          <td><div class="form-inline">
                      <div class = "input-group"> 
                <a href="#"  class="btn btn-outline-success btn-xs" title="View"  data-toggle="modal" data-target="#appFormModal"  data-id="{{ $row->salary_template_id }}" data-type="template"   onclick="model({{ $row->salary_template_id }},'template')">
                        <i class="fa fa-eye"></i></a>                                                             
                    </div>&nbsp
                      <div class = "input-group"> 
                      <a href="{{ route("salary_template.edit", $row->salary_template_id)}}" class="btn btn-outline-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a> 
                   </div>&nbsp
                      <div class = "input-group"> 
         {!! Form::open(['route' => ['salary_template.destroy',$row->salary_template_id], 'method' => 'delete']) !!}                                                   
                                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger  btn-xs ', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                                    {{ Form::close() }}
                </div>
                    </div></td>      
                                                               
                                                                </tr>
                                                                @endforeach
                                
                                                                @endif
                                
                                                            </tbody>
                                       
                                    </table>
                                </div>
                            </div>
                            <?php if (!empty($created) || !empty($edited)) { ?>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2">
                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Template</h5>
                                        @else
                                        <h5>Edit Template</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('salary_template.update', $id),'role'=>'form','enctype'=>'multipart/form-data' ,'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'salary_template.store','role'=>'form','enctype'=>'multipart/form-data']) }}
                                                @method('POST')
                                                @endif

                                                <div class="row">
                                                    <div
                                                        class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 offset-lg-3">
                                                        <div class="card">

                                                            <div class="card-body">
                                                                <div class="">
                                                                    <label class="control-label">Salary
                                                                        Grade<span class="required">
                                                                            *</span></label> </label>
                                                                    <input type="text" required name="salary_grade" value="<?php
                                                                                      if (!empty($salary_template_info->salary_grade)) {
                                                                                          echo $salary_template_info->salary_grade;
                                                                                      }
                                                                                      ?>" class="form-control" required
                                                                        placeholder="Enter Salary Grade">
                                                                </div>
                                                                <div class="">
                                                                    <label class="control-label">Basic
                                                                        Salary <span class="required">
                                                                            *</span>
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="basic_salary" required value="<?php
                                                                                 if (!empty($salary_template_info->basic_salary)) {
                                                                              echo $salary_template_info->basic_salary;
                                                                                }
                                                                       ?>" class="salary form-control basic_salary"
                                                                        required placeholder="Basic Salary">
                                                                </div>
                                                               

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Allowance</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <?php
                                                                           $total_salary = 0;
                                                                  ?>
                                                                           @if (!empty($salary_allowance_info[0]))
                                                                     @foreach ($salary_allowance_info as $v_allowance_info)
                                                                <div class="">
                                                                    <input type="text"
                                                                        style="margin:5px 0px;height: 28px;width: 56%;"
                                                                        class="form-control" name="allowance_label[]"
                                                                        value="<?php echo $v_allowance_info->allowance_label; ?>">
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="allowance_value[]"
                                                                        value="<?php echo $v_allowance_info->allowance_value; ?>"
                                                                        class="salary form-control">
                                                                    <input type="hidden" name="salary_allowance_id[]"
                                                                        value="<?php echo $v_allowance_info->salary_allowance_id; ?>"
                                                                        class="form-control">
                                                                </div>
                                                                <?php $total_salary += $v_allowance_info->allowance_value; ?>
                                                                 @endforeach
                                                                @else
                                                                <div class="">
                                                                    <label class="control-label">House Rent
                                                                        Allowance
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="house_rent_allowance" value=""
                                                                        class="salary form-control">
                                                                </div>
                                                                <div class="">
                                                                    <label class="control-label">Medical Allowance
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="medical_allowance" value=""
                                                                        class="salary form-control">
                                                                </div>
                                                               @endif
                                                                <br><div id="add_new">
                                                                </div>
                                                                <div class="margin">
                                                                    <strong><a href="javascript:void(0);" id="add_more"
                                                                            class="addCF "><i
                                                                                class="fa fa-plus"></i>&nbsp;Add
                                                                            More</a></strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5>Deductions</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <?php
                                                                          $total_deduction = 0;
                                                                          if (!empty($salary_deduction_info[0])):foreach ($salary_deduction_info as $v_deduction_info):
                                                                              ?>
                                                                <div class="">
                                                                    <input type="text"
                                                                        style="margin:5px 0px;height: 28px;width: 56%;"
                                                                        class="form-control" name="deduction_label[]"
                                                                        value="<?php echo $v_deduction_info->deduction_label; ?>"
                                                                        class="">
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="deduction_value[]"
                                                                        value="<?php echo $v_deduction_info->deduction_value; ?>"
                                                                        class="deduction form-control <?php echo $v_deduction_info->deduction_label; ?>">
                                                                    <input type="hidden" name="salary_deduction_id[]"
                                                                        value="<?php echo $v_deduction_info->salary_deduction_id; ?>"
                                                                        class="form-control ">
                                                                </div>
                                                                <?php $total_deduction += $v_deduction_info->deduction_value ?>
                                                                <?php endforeach; ?>
                                                                <?php else: ?>
                                                                <div class="">
                                                                    <label class="control-label">Social Security
                                                                        (NSSF) <span class="required">
                                                                            *</span>
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        disabled class="form-control NSSF">
                                                                    <input type="hidden" data-parsley-type="number"
                                                                        name="provident_fund"
                                                                        class="deduction form-control NSSF">
                                                                </div>
                                                                <div class="">
                                                                    <label class="control-label">PAYE <span class="required">
                                                                            *</span>
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        disabled class="form-control PAYE">
                                                                    <input type="hidden" data-parsley-type="number"
                                                                        name="tax_deduction"
                                                                        class="deduction form-control PAYE">
                                                                </div>
                                                                    <div class="">
                                            <label class="control-label">HESLB </label>
                                            <input type="text" data-parsley-type="number" 
                                                   class="deduction form-control HESLB">
                                            <input type="hidden" data-parsley-type="number" name="heslb"
                                                   class="deduction form-control HESLB ">
                                        </div>
                                                                <?php endif; ?>
<br>
                                                                <div id="add_new_deduc">
                                                                </div>
                                                                <div class="margin">
                                                                    <strong><a href="javascript:void(0);"
                                                                            id="add_more_deduc" class="addCF "><i
                                                                                class="fa fa-plus"></i>&nbsp;Add
                                                                            More</a></strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div
                                                        class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12 offset-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <strong>Total Salary Details</strong>
                                                            </div>
                                                            <div class="card-body">
                                                                <table class="table table-bordered custom-table">
                                                                    <tr>
                                                                        <!-- Sub total -->
                                                                        <th class="col-sm-8 vertical-td">
                                                                            <strong>Gross
                                                                                Salary
                                                                                :</strong>
                                                                        </th>
                                                                        <td class="">
                                                                            <input type="text" name="" disabled value="<?php
                                                                                      if (!empty($total_salary) || !empty($salary_template_info->basic_salary)) {
                                                                                          echo $total = $total_salary + $salary_template_info->basic_salary;
                                                                                      }
                                                                                      ?>" id="total"
                                                                                class="form-control">
                                                                        </td>
                                                                    </tr> <!-- / Sub total -->
                                                                    <tr>
                                                                        <!-- Total tax -->
                                                                        <th class="col-sm-8 vertical-td">
                                                                            <strong>Total
                                                                                Deduction
                                                                                :</strong>
                                                                        </th>
                                                                        <td class="">
                                                                            <input type="text" name="" disabled value="<?php
                                                                                     if (!empty($total_deduction)) {
                                                                                         echo $total_deduction;
                                                                                     }
                                                                                     ?>" id="deduc"
                                                                                class="form-control">
                                                                        </td>
                                                                    </tr><!-- / Total tax -->
                                                                    <tr>
                                                                        <!-- Grand Total -->
                                                                        <th class="col-sm-8 vertical-td"><strong>Net
                                                                                Salary
                                                                                :</strong>
                                                                        </th>
                                                                        <td class="">
                                                                            <input type="text" name="" disabled required
                                                                                value="<?php
                                                                                    if (!empty($total) || !empty($total_deduction)) {
                                                                                        echo $total - $total_deduction;
                                                                                    }
                                                                                    ?>" id="net_salary"
                                                                                class="form-control">
                                                                        </td>
                                                                    </tr><!-- Grand Total -->
                                                                </table>

                                                                <div class="btn-bottom-toolbar text-right">
                                                                    <?php
                                                                 if (!empty($salary_template_info)) { ?>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-primary">Updates</button>
                                                                    <button type="button" onclick="goBack()"
                                                                        class="btn btn-sm btn-danger">Cancel</button>
                                                                    <?php } else {
                                                            ?>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-primary">Save</button>
                                                                    <?php }
                                                            ?>
                                                                </div>



                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- ****************** Total Salary Details End  *******************-->

                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } else { ?>
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
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

<script type="text/javascript">
$(document).ready(function() {
    var maxAppend = 0;
    $("#add_more").click(function() {
        var add_new = $(
            '<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="allowance_label[]" style="margin:5px 0px;height: 28px;width: 56%;" class="form-control"  placeholder="Enter Allowance label" required ></div>\n\
<div class="col-sm-9"><input  type="text" data-parsley-type="number" name="allowance_value[]" placeholder="Enter Allowance Value" required  value="<?php
                if (!empty($emp_salary->allowance_value)) {
                    echo $emp_salary->allowance_value;
                }
                ?>"  class="salary form-control"></div>\n\
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF"><i class="fa fa-times"></i>&nbsp;Remove</a></strong></div></div>'
        );
        maxAppend++;
        $("#add_new").append(add_new);
    });

    $("#add_new").on('click', '.remCF', function() {
        $(this).parent().parent().parent().remove();
    });
});
</script>
<script type="text/javascript">
 $(document).ready(function () {
        var maxAppend = 0;
        $("#add_more_deduc").click(function () {
            var add_new = $('<div class="row">\n\
    <div class="col-sm-12"><input type="text" name="deduction_label[]" style="margin:5px 0px;height: 28px;width: 56%;" class="form-control" placeholder="Enter Deductions Label" required></div>\n\
<div class="col-sm-9"><input  type="text" data-parsley-type="number" name="deduction_value[]" placeholder="Enter Deductions Value" required  value=""  class="deduction form-control"></div>\n\
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF_deduc"><i class="fa fa-times"></i>&nbsp;Remove</a></strong></div></div>');
            maxAppend++;
            $("#add_new_deduc").append(add_new);

        });

        $("#add_new_deduc").on('click', '.remCF_deduc', function () {
            $(this).parent().parent().parent().remove();
        });
    });
</script>
<script type="text/javascript">
 $(document).on("change", function () {
        var sum = 0;
        var basic_salary= 0;
        var deduc = 0;

        $(".salary").each(function () {
            sum += +$(this).val();
         console.log(sum);
        });
         $(".basic_salary").each(function () {
            basic_salary += +$(this).val();
        });
        
        var provident_fund = ((basic_salary * 10 / 100 )).toFixed(2);
        $(".NSSF").val(provident_fund);
        
              
        

      var sub_total=sum- provident_fund ;


        var total_tax = tax_deduction_rule(sub_total);

        $(".PAYE").val(total_tax);

    

        $(".deduction").each(function () {
            deduc += +$(this).val();
        });
        
        var ctc = $("#ctc").val();
        $("#total").val(sum.toFixed(2));

        $("#deduc").val(deduc.toFixed(2));
        var net_salary = 0;
        net_salary = (sum - deduc).toFixed(2);
        $("#net_salary").val(net_salary);
    });

    function tax_deduction_rule(tax) {
        if (tax < 270000) {
            return "0";
        }
        else if (tax >= 270000 && tax < 520000) {
            return (0.08 * (tax - 270000)).toFixed(2);
        }
        else if (tax >= 520000 && tax < 760000) {
            var tr = (tax - 520000);
            var ttotal = ( tr * 20 / 100 );
            return ((20000 + ttotal)).toFixed(2);
        }
        else if (tax >= 760000 && tax < 1000000) {
            var tr = (tax - 760000);
            var ttotal = ( tr * 25 / 100 );
            return ((68000 + ttotal)).toFixed(2);
        } else if (tax >= 1000000) {
            var tr = (tax - 1000000);
            var ttotal = ( tr * 30 / 100 );
            return ((128000 + ttotal)).toFixed(2);
        }
    }


</script>
@endsection