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
                                    data-toggle="tab">Salary
                                    Template List</a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if(!empty($id)) active show @endif"
                                    href="#profile2" data-toggle="tab">New
                                    Template</a></li>
                        <li class="nav-item">
                                <a class="nav-link  " id="importExel-tab"
                                    data-toggle="tab" href="#importExel" role="tab" aria-controls="profile"
                                    aria-selected="false">Import</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">

                                <div class="table-responsive">
                                <table class="table datatable-basic table-striped">
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
                <a href="#"  class="list-icons-item text-info" title="View"  data-toggle="modal" data-target="#appFormModal"  data-id="{{ $row->salary_template_id }}" data-type="template"   onclick="model({{ $row->salary_template_id }},'template')">
                        <i class="icon-eye"></i></a>                                                             
                    &nbsp&nbsp

                      <a href="{{ route("salary_template.edit", $row->salary_template_id)}}" class="list-icons-item text-primary"  title="Edit"><i class="icon-pencil7"></i></a> 
                   &nbsp

                  
         {!! Form::open(['route' => ['salary_template.destroy',$row->salary_template_id], 'method' => 'delete']) !!}                                                   
          {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                 {{ Form::close() }}
&nbsp
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
                                                               <br>
                                                               @if(!empty($salary_template_info))
                                                               <input name="checked" id="inc"  type="checkbox"  class="inc" 
                                                               value="1" {{(!empty($salary_template_info))?($salary_template_info->checked == '1')?'checked':'':''}}> Include NSSF
                                                               
                                                                &nbsp&nbsp<input name="heslb_check" id="heslb_inc"  type="checkbox"  class="heslb_inc" 
                                                               value="1" {{(!empty($salary_template_info))?($salary_template_info->heslb_check == '1')?'checked':'':''}}> Include HESLB

                                                                @else
                                                                <input name="checked" id="inc"  type="checkbox"  value="1" class="inc" checked="checked" > Include NSSF
                                                                &nbsp&nbsp <input name="heslb_check" id="heslb_inc"  type="checkbox"  value="1" class="heslb_inc" checked="checked" > Include HESLB
                                                                 @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="card">
                                                             <div class="card-header header-elements-sm-inline">
                                                                <h5>Allowance</h5>
                                                                 <div class="header-elements">  
                                                                <strong><a href="javascript:void(0);" id="add_more" class="addCF"><i class="fa fa-plus"></i>&nbsp;Add More</a></strong>
                                                            </div></div>
                                                            
                                                            <div class="card-body">
                                                             <div id="edit">
                                                            
                                                                <?php
                                                                           $total_salary = 0;
                                                                  ?>
                                                                           @if (!empty($salary_allowance_info[0]))
                                                                           
                                                                            
                                                                           
                                                                     @foreach ($salary_allowance_info as $v_allowance_info)

                                                                 <div class="row">
                                                                 
                                                                 <div class="col-sm-9">
                                                                    <input type="text"
                                                                        style="margin:5px 0px;height: 28px;width: 56%;"
                                                                        class="form-control" name="allowance_label[]"
                                                                        value="<?php echo $v_allowance_info->allowance_label; ?>">
                                                                        </div>
                                                                       
                                                                        <div class="col-sm-9"> 
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="allowance_value[]"
                                                                        value="<?php echo $v_allowance_info->allowance_value; ?>"
                                                                        class="salary form-control">
                                                                   
                                                                        </div>
                                                                         <input type="hidden" name="salary_allowance_id[]"
                                                                        value="<?php echo $v_allowance_info->salary_allowance_id; ?>"
                                                                        class="form-control">
                                                                        
                                                                        <div class="col-sm-3">
                                <strong><a href="javascript:void(0);" class="editremCF" value="{{ isset($v_allowance_info) ? $v_allowance_info->salary_allowance_id : ''}}"><i class="icon-cross2"></i>&nbsp;Remove</a></strong>
                                                                </div>
                                                                
                                                                  </div>
                                                                <?php $total_salary += $v_allowance_info->allowance_value; ?>
                                                                 @endforeach
                                                                  @endif
                                                                  </div>
                                                                  
                                                                <div id="add_new">
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                        <div class="card">
                                                            <div class="card-header header-elements-sm-inline">
                                                                <h5>Deductions</h5>
                                                                 <div class="header-elements">  
                                                                
                                                                 <strong><a href="javascript:void(0);"
                                                                            id="add_more_deduc" class="addCF "><i
                                                                                class="fa fa-plus"></i>&nbsp;Add
                                                                            More</a></strong>
                                                            </div></div>
                                                            <div class="card-body">
                                                                
                                                                
                                                                         <?php $total_deduction = 0;
                                                                          if (!empty($salary_deduction_info[0])):
                                                                              
                                                                              ?>
                                                                              
                                                                              <div class="">
                                                                    <label class="control-label">NSSF </label>
                                                                <input type="text" data-parsley-type="number" name="deduction_value[]" id="NSSF" value="{{ isset($nssf) ? $nssf->deduction_value : ''}}"  class="deduction form-control NSSF" readonly>
                                                                        
                                                                <input type="hidden" class="form-control" name="deduction_label[]" value="{{ isset($nssf) ? $nssf->deduction_label: ''}}">
                                                               <input type="hidden" name="salary_deduction_id[]" value="{{ isset($nssf) ? $nssf->salary_deduction_id : 'NSSF'}}" class="form-control ">
                                                                </div>
                                                                <div class="">
                                                                    <label class="control-label">PAYE </label>
                                                                    <input type="text" data-parsley-type="number" name="deduction_value[]" value="{{ isset($paye) ? $paye->deduction_value : ''}}" class="deduction form-control PAYE" readonly>
                                                                     <input type="hidden" class="form-control" name="deduction_label[]" value="{{ isset($paye) ? $paye->deduction_label : 'PAYE'}}">
                                                               <input type="hidden" name="salary_deduction_id[]" value="{{ isset($paye) ? $paye->salary_deduction_id : ''}}" class="form-control ">
                                                                </div>
                                                                    <div class="">
                                                             <label class="control-label">HESLB </label>
                                            <input type="text" data-parsley-type="number" name="deduction_value[]" id="heslb" value="{{ isset($heslb) ? $heslb->deduction_value : ''}}" class="deduction form-control HESLB" readonly>
                                             <input type="hidden" class="form-control" name="deduction_label[]" value="{{ isset($heslb) ? $heslb->deduction_label : 'HESLB'}}">
                                                               <input type="hidden" name="salary_deduction_id[]" value="{{ isset($heslb) ? $heslb->salary_deduction_id : ''}}" class="form-control ">
                                        </div>
                                        
                                                         
                                                          <div id="ded_edit">
                                                                              @php
                                                                $og_deduc = App\Models\Payroll\SalaryDeduction::where('salary_template_id', $id)->whereNotIn('deduction_label', ['NSSF','PAYE','HESLB'])->get();
                                                                             @endphp
                                                                             
                                                                              @if(!empty($og_deduc))
                                                                               @foreach ($og_deduc as $v_deduction_info)
                                                                             

                                                                 <div class="row">
        
                                                               <div class="col-sm-9">
                                                                    <input type="text"
                                                                        style="margin:5px 0px;height: 28px;width: 56%;"
                                                                        class="form-control" name="deduction_label[]"
                                                                        value="<?php echo $v_deduction_info->deduction_label; ?>"
                                                                        class="">
                                                                        </div>
                                                                        <div class="col-sm-9">
                                                                    <input type="text" data-parsley-type="number"
                                                                        name="deduction_value[]" id="<?php echo $v_deduction_info->deduction_label; ?>"
                                                                        value="<?php echo $v_deduction_info->deduction_value; ?>"
                                                                        class="deduction form-control <?php echo $v_deduction_info->deduction_label; ?>">
                                                                        </div>
                                                                        
                                                                    <input type="hidden" name="salary_deduction_id[]"
                                                                        value="<?php echo $v_deduction_info->salary_deduction_id; ?>"
                                                                        class="form-control ">
                                                                        
                                                                         <div class="col-sm-3">
                                                                <strong><a href="javascript:void(0);" class="editremCF_deduc" value="{{ isset($v_deduction_info) ? $v_deduction_info->salary_deduction_id : ''}}"><i class="icon-cross2"></i>&nbsp;Remove</a></strong>
                                                               
                                                                </div>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                                 
                                                                 </div>
                                                                 
                                                                 <?php 
                                                                foreach ($salary_deduction_info as $sv_deduction_info):
                                                                
                                                                 $total_deduction += $sv_deduction_info->deduction_value ?>
                                                                <?php endforeach; ?>
                                                                <?php else: ?>
                                                                <div class="">
                                                                    <label class="control-label">NSSF
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        disabled class="form-control NSSF">
                                                                    <input type="hidden" data-parsley-type="number"
                                                                        name="provident_fund" id="NSSF"
                                                                        class="deduction form-control NSSF">
                                                                </div>
                                                                <div class="">
                                                                    <label class="control-label">PAYE 
                                                                    </label>
                                                                    <input type="text" data-parsley-type="number"
                                                                        disabled class="form-control PAYE">
                                                                    <input type="hidden" data-parsley-type="number"
                                                                        name="tax_deduction"
                                                                        class="deduction form-control PAYE">
                                                                </div>
                                                                    <div class="">
                                            <label class="control-label">HESLB </label>
                                            <input type="text" data-parsley-type="number" disabled
                                                   class="form-control HESLB">
                                            <input type="hidden" data-parsley-type="number" name="heslb" id="heslb"
                                                   class="deduction form-control HESLB">
                                        </div>
                                                                <?php endif; ?>
<br>
                                                                <div id="add_new_deduc">
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
                                                                     <br>
                                                                <div class="btn-bottom-toolbar text-right">
                                                                    <?php
                                                                 if (!empty($salary_template_info)) { ?>
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-primary">Updates</button>
                                                                    <button type="button"  href="{{ route('salary_template.index')}}"
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

                           <div class="tab-pane fade" id="importExel" role="tabpanel"
                            aria-labelledby="importExel-tab">

                            <div class="card">
                                <div class="card-header">
                                     <form action="{{ route('salary_template.sample') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button class="btn btn-success">Download Sample</button>
                                        </form>
                                 
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <div class="container mt-5 text-center">
                                                <h4 class="mb-4">
                                                 Import Excel & CSV File   
                                                </h4>
                                                <form action="{{ route('salary_template.import') }}" method="POST" enctype="multipart/form-data">
                                            
                                                    @csrf
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="file" class="form-control" id="customFile" required>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Import Salary Template</button>
                                          
                                        </form>
                                       
                                    </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
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
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF"><i class="icon-cross2"></i>&nbsp;Remove</a></strong></div></div>'
        );
        maxAppend++;
        $("#add_new").append(add_new);
    });

    $("#add_new").on('click', '.remCF', function() {
        $(this).parent().parent().parent().remove();
    });
    
     $("#edit").on('click', '.editremCF', function() {
          var btn_value = $(this).attr("value");
        $(this).parent().parent().parent().remove();
        $("#edit").append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +btn_value + '"/>');

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
<div class="col-sm-3"><strong><a href="javascript:void(0);" class="remCF_deduc"><i class="icon-cross2"></i>&nbsp;Remove</a></strong></div></div>');
            maxAppend++;
            $("#add_new_deduc").append(add_new);

        });

        $("#add_new_deduc").on('click', '.remCF_deduc', function () {
            $(this).parent().parent().parent().remove();
        });
        
         $("#ded_edit").on('click', '.editremCF_deduc', function() {
          var btn_value = $(this).attr("value");
        $(this).parent().parent().parent().remove();
        $("#ded_edit").append('<input type="hidden" name="deduc_removed_id[]"  class="form-control name_list" value="' +btn_value + '"/>');
    });
    
    });
</script>
<script type="text/javascript">

     
 $(document).on("change", function () {
        var sum = 0;
        var basic_salary= 0;
         var heslb= 0;
      var provident_fund= 0;
        var nssf= 0;
        var deduc = 0;

        $(".salary").each(function () {
            sum += +$(this).val();
         console.log(sum);
        });
         $(".basic_salary").each(function () {
            basic_salary += +$(this).val();
        });
        
         $(".heslb_inc").each(function () {
            if($(this).is(':checked')){ 
         var heslb = ((basic_salary * 15 / 100 )).toFixed(2);
         $(".HESLB").val(heslb)
            }
            else{
                var heslb = (0).toFixed(2);    
                $(".HESLB").val(heslb);
            }
        });
        
        $(".inc").each(function () {
            if($(this).is(':checked')){ 
         var nssf = ((sum * 10 / 100 )).toFixed(2);
         $(".NSSF").val(nssf);
            }
            else{
                var nssf = (0).toFixed(2);   
                $(".NSSF").val(nssf)
            }
        });
        
        $("#NSSF").each(function () {
            provident_fund += +$(this).val();
            
        });
              
        

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