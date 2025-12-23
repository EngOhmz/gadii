@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Manage Salary</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content " id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

       

        <div class="panel-body hidden-print">
                                      @if(!empty($edit))
                                               <form name="form"  action="{{url('payroll/manage_salary')}}" method="post" class="form-horizontal">
                                                    @else
                                                {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}                                             
                                                @endif
          
    @csrf
            <div class="row">
 <div class="col-sm-12 ">
                                       
               <div class="form-group row">
                    <label class="col-lg-2 col-form-label"> Select Department   <span class="required" style="color:red;"> *</span></label>  
               <div class="col-lg-5">                               
                   <select name="departments_id" class="form-control m-b" id="departments_id" required>
                                        <option value="">Select Departments</option>
                                        <?php if (!empty($all_department_info)): foreach ($all_department_info as $v_department_info) :
                                                        if (!empty($v_department_info->name)) {
                                                            $deptname = $v_department_info->name;
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
  
                                               

   <div class="col-lg-4">
                      <button type="submit" class="btn btn-success" value="1" name="flag">Go</button>
                           @if(!empty($edit))
                                                  <a href="{{url('payroll/manage_salary')}}"class="btn btn-danger">Reset</a>
                                                    @else
                                                  <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>                                      
                                                @endif
                     

                </div>  </div>
                
                </div>
           </div>
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
@if(!empty($employee_info))
<?php $id=1; 
$a=0;

?>
        <div class="panel panel-white">
            <div class="panel-body ">
                      <form name="frm-example" id="frm-example" role="form" enctype="multipart/form-data" action="{{url('payroll/save_salary_details')}}" method="post" class="form-horizontal form-groups-bordered">
                            @csrf
                            
                             <table class="table datatable-basic table-striped" id="table-1">
                                <thead>
                                    <tr>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 36.484px;">#</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width:186.484px;">Employee Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 96.484px;"><input type="checkbox" name="select_all"  id="example-select-all"> Select All</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($employee_info as $v_employee)  
                               <?php
                                $a++;
                                $salary_info=App\Models\Payroll\EmployeePayroll::where('user_id',$v_employee->id)->where('disabled','0')->get();
                                    ?>
                            <tr>
                               <td>{{$loop->iteration }}</td>
                                <td><?php echo $v_employee->name; ?></td>
                                                
                                             <td>

                                             <div class="form-inline">
                                         
                                               <input name="monthly_status[]"    id="<?php echo $v_employee->id ?>"  type="checkbox"  value="<?php echo $v_employee->id ?>"   class="child_absent"
                                                        
                                                    @foreach ($salary_info as $v_gsalary_info) 
                                                            @if ($v_employee->id == $v_gsalary_info->user_id) 
                                                              {{ $v_gsalary_info->salary_template_id ? 'checked ' : '' }}
                                                            @endif
                                                        @endforeach
                                                          >&nbsp;&nbsp;&nbsp;                            
                                           
                                                <div class="input-group mb-3"> 
                                                 <select name="salary_template_id[]" class="form-control append-button-single-field template" id="template_id_{{$a}}"  data-sub_category_id="{{$a}}">
                                                           <option value="">Select Monthly Template</option>
                                                      <?php if (!empty($salary_grade)) : foreach ($salary_grade as $v_salary_info) : ?>
                                                        <option value="<?php echo $v_salary_info->salary_template_id ?>" <?php

                                                         foreach ($salary_info as $v_gsalary_info) {
                                                            if (!empty($v_gsalary_info)) {
                                                                if ($v_employee->id == $v_gsalary_info->user_id) {
                                                                    echo $v_salary_info->salary_template_id == $v_gsalary_info->salary_template_id ? 'selected ' : '';
                                                                }
                                                            }
                                                        }
                                                   
                                                    ?>>
                                                            <?php echo $v_salary_info->salary_grade ?></option>;
                                                        <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>&nbsp;
                                       
                                                  <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model({{ $a }},'addtemplate')" value="{{ $a}}" data-target="#appFormModal"><i class="icon-plus-circle2"></i></button>
                                                
                                          </div>
                      
                    </div>
                                           
                          </td>            

                                 <!-- Hidden value when update  Start-->
                            <input type="hidden" name="departments_id" value="<?php echo $departments_id ?>" />
                            <?php
                                 if (!empty($salary_info)) {
                    foreach ($salary_info as $v_gsalary_info) {
                     
                            ?>
                            <input type="hidden" name="payroll_id[]"
                                value="<?php echo $v_gsalary_info->id ?>" />
                            <?php
                                                                  }
                                         }
                   
                                
                                 ?>
                         
                              </tr>
                                
                            
                             
                         @endforeach
                           </tbody>
                             
                         </table>
                          <button class="btn btn-sm btn-primary float-right m-t-n-lg" type="submit" id="salery_btn">Update</button>

                        </form>
            </div>
            <!-- /.panel-body -->
             </div>
    @endif              

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
                {"targets": [1]}
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
 var table = $('#table-1').DataTable();
 
$('#example-select-all').on('click', function(){
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

$("input[type=checkbox]").click(function() {
  if (!$(this).prop("checked")) {
    $("#example-select-all").prop("checked", false);
  }
});



</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(':checkbox').on('change', function () {
            var th = $(this), id = th.prop('id');
            if (th.is(':checked')) {
                $(':checkbox[id="' + id + '"]').not($(this)).prop('checked', false);
            }
        });
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
                  .attr('name', 'monthly[]')
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
                  .attr('name', 'monthly[]')
                  .val(this.value)
            );
         } 
      });     

} 


   });  



    
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
                $('#appFormModal > .modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }


  function saveTemplate(e){
   var form = $('#addClientForm').serialize();
       var sub_category_id =  $('#category').val();;
          $.ajax({
            type: 'GET',
            url: '{{url("payroll/addTemplate")}}',
         data:  $('#addClientForm').serialize(),
              
          
                dataType: "json",
             success: function(response) {
                console.log(response);
  console.log(sub_category_id);
                               var id = response.salary_template_id;
                             var name = response.salary_grade;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#template_id_'+sub_category_id).append(option);
                              $('#appFormModal').hide();
                            $('.modal-backdrop').remove();
                                
               
            }
        });
}

    </script>


<script>
$(document).ready(function() {

  

    $(document).on('change', '.amount', function() {
        var id = $(this).val();
        var user=$('#user_id').val();
        $.ajax({
            url: '{{url("payroll/findLoan")}}',
            type: "GET",
            data: {
                id: id,
                  user: user,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });



$(document).on('change', '.monthyear', function() {
        var id = $(this).val();
    var user=$('#user_id').val();
        $.ajax({
            url: '{{url("payroll/findMonth")}}',
            type: "GET",
            data: {
                id: id,
                  user: user,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#month_errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
           $("#month_errors").append(data);
           $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });
  });


});
</script>
@endsection