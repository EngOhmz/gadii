@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
        <div class="col-sm-12" >


         <div class="card">
            <!-- *********     Employee Search Panel ***************** -->
            <div class="card-header">
                <h4>Invoice Generation</h4>
            </div>
           
            
                <div class="card-body">
         
                     {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
                      <div class="form-group offset-3">
                        <label  for="field-1" class="col-sm-3 control-label">Fee Type <span
                                class="required"> *</span></label>

                        <div class="col-sm-5">
                            <select required name="fee"  id="fee" class="form-control m-b search" required  >
                                <option value="">Select Fee Type</option>
                                     @if(!empty($schools))
                                            @foreach($schools as $row)
                                            <option value="{{$row->id}}" @if(!empty($fee))  {{  $fee == $row->id  ? 'selected' : ''}} @endif>{{$row->feeType}}</option>
                                             @endforeach
                                            @endif
                            </select>
                        </div>
                    </div>

                   <div class="form-group offset-4" id="border-none">
                                                        <label for="field-1" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-5">
                                                            <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>
                                                        </div>
                                                    </div>
                                  
                </div>
           
            {!! Form::close() !!}             
                  
                </div>
  </div>
           
        </div><!-- ******************** Employee Search Panel Ends ******************** -->

@if(!empty($fee))
{!! Form::open(array('route' => 'student.generate','method'=>'POST', 'id' => 'frm-example' , 'name' => 'frm-example')) !!}

             <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Students List for {{$feeType}}</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">
                              
                        
                                <div class="table-responsive">
                                    
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student Name</th>
                                                <th>Gender</th>
                                                <th>Type</th>
                                                <th>School Level</th>
                                                <th>Class</th>
                                                <th>Fee Price</th>                                           
                                                <th class="col-sm-1">Action</th>
                                            </tr>
                                        </thead>
                                     <tbody>
                                           
                                            
                                              @foreach ($details as $dtls)
                                              
                                            
                                              
                                @if(empty($dtls->branch_id))   
                                 <?php
                                 $year=date('Y');
                               $user=auth()->user()->added_by;
                               $students=  DB::select('SELECT * 
FROM students WHERE class = "'.$dtls->class.'" AND branch_id IS NULL AND added_by = "'.$user.'" AND disabled = "0" AND graduate = "0" AND id NOT IN(SELECT students.id FROM students
LEFT JOIN student_payments ON students.id = student_payments.student_id WHERE student_payments.year ="'.$year.'" AND student_payments.added_by = "'.$user.'") ');
   
                                  ?>
                                
                                
                                @else
                                                    
                             <?php
                                 $year=date('Y');
                               $user=auth()->user()->added_by;
                               $students=  DB::select('SELECT * 
FROM students WHERE class = "'.$dtls->class.'" AND branch_id = "'.$dtls->branch_id.'" AND added_by = "'.$user.'" AND disabled = "0" AND graduate = "0" AND id NOT IN(SELECT students.id FROM students
LEFT JOIN student_payments ON students.id = student_payments.student_id WHERE students.branch_id = "'.$dtls->branch_id.'" AND student_payments.year ="'.$year.'" AND student_payments.added_by = "'.$user.'") ');
   
                                  ?>
                                  
                                  @endif
                                  
                                            @if(!@empty($students))
                                              @foreach ($students as $row)
                                                  <tr class="gradeA even" role="row">
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td>{{$row->student_name}}</td>
                                                   <td>{{$row->gender}}</td>
                                                    <td>{{$row->type}}</td>
                                                   <td>{{$row->level}}</td>
                                                   <td>{{$row->class}}</td>
                                                   <td>{{number_format($price,2)}} <input type="hidden" name="student_fee" class="form-control" value="{{$fee}}"  required ></td>
                                                   <td><input name="trans_id[]" type="checkbox"  class="checks" value="{{$row->id}}" checked="checked"></td>      
                                                               
                                      </tr>
                                  
                                       @endforeach
                                    @endif
                                     
                                   
                                    @endforeach
                                   </tbody>
                                       
                                    </table>
                                </div>

                              <br> <br>  
               
          
   <div class="form-group row">
                        <label  for="field-1" class="col-sm-2 control-label">Payment Year <span
                                class="required"> *</span></label>

                        <div class="col-sm-4">
                            <input type="text" name="year" class="form-control" id="datepicker"  required >
                          
                        </div>

                        <label  for="field-1" class="col-sm-2 control-label">Notes  </label>

                        <div class="col-sm-4">
                            <textarea name="notes" class="form-control" ></textarea>
                        </div>
                    </div>
                  
 <div class="btn-bottom-toolbar text-right">
                                      <button type="submit"
                                         class="btn btn-sm btn-primary" id="save" disabled>Save Details</button>
                                                              
                                    </div>

                            </div>
                           
                        </div>

                    </div>

                </div>
            </div>
  {!! Form::close() !!}
          
                </div>
            </div>
@endif





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
           "ordering": false,
             "columnDefs": [{
                "targets": [0]
            }],
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
                  .attr('name', 'student_id[]')
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
                  .attr('name', 'student_id[]')
                  .val(this.value)
            );
         } 
      });      

}
   
   });  
    
});


</script>


<script>
 $(document).on("change", function () {
$('input:checkbox').click(function() {
 if ($(this).is(':checked')) {
 $('#save').prop("disabled", false);
 } else {
 if ($('.checks').filter(':checked').length < 1){
 $('#save').prop("disabled", true);

}
 }
});

  });       
</script>



 <script src="{{url('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>

<script>
$(document).ready(function(){
$('#table-1').find('tr').each(function () {
    var row = $(this);
    if (row.find('input[type="checkbox"]').filter(':checked').length > 0) {
        $('#save').attr("disabled", false);
    }
});

});      
</script>

<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("student.invoice", ":id") }}';
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