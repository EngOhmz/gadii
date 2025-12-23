@extends('layouts.master')


@section('content')

<div class="row">
    <div class="col-sm-12" >
        <div class="card">
            <!-- *********     Employee Search Panel ***************** -->
            <div class="card-header">
                <h4>Promote Students</h4>
            </div>

            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal form-groups-bordered', 'name' => 'form')) !!}  
                {{csrf_field()}}
                <div class="card-body">
                      <div class="form-group offset-3">
                        <label  for="field-1" class="col-sm-3 control-label">Promotion Type <span class="required"> *</span></label>

                        <div class="col-sm-5">
                            <select required name="type" id="search_type" class="form-control m-b type" required>
                                <option value="">Select Promotion Type</option>
                                <option value="class" @if(!empty($type)) {{  $type == 'class'  ? 'selected' : ''}} @endif>Next Class</option>
                                <option value="level" @if(!empty($type)) {{  $type == 'level'  ? 'selected' : ''}} @endif>Next Level</option>
                               <option value="graduate" @if(!empty($type)) {{  $type == 'graduate'  ? 'selected' : ''}} @endif>Graduate</option>

                            </select>
                        </div>
                    </div>


                   
                         <div class="form-group offset-3">
                            <label for="field-1" class="col-sm-3 control-label">Class
                                <span class="required"> *</span></label>

                            <div class="col-sm-5">
                                <select class="class form-control m-b select_box" style="width: 100%" name="class" id="class" required>
                                    <option value="">Select Class</option>
                                     @foreach ($classes as $row)                                                             
                                <option value="{{$row->id}}" @if(isset($class_id))@if($class_id == $row->id) selected @endif @endif >{{$row->class}}</option>
                                @endforeach
                                </select>
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


@if(!empty($students))
{!! Form::open(array('route' => 'student.save_promote','method'=>'POST', 'id' => 'frm-example' , 'name' => 'frm-example')) !!}
  <input name="type" type="hidden"  value="{{ isset($type) ? $type : ''}}"> 

             <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Students List </h4>
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
                                                <th>School Level</th>
                                                <th>Class</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                     <tbody>
                                           
                                            
                                  
                                            @if(!@empty($students))
                                              @foreach ($students as $row)
                                                  <tr class="gradeA even" role="row">
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td>{{$row->student_name}}</td>
                                                   <td>{{$row->gender}}</td>
                                                   <td>{{$row->level}}</td>
                                                   <td>{{$row->class}}</td>
                                                   <td><input name="trans_id[]" type="checkbox"  class="checks" value="{{$row->id}}" checked="checked"></td>      
                                                            
                                      </tr>
                                  
                                       @endforeach
                                    @endif
                                     
 
                                   </tbody>
                                       
                                    </table>
                                </div>

                              <br> <br>  
               
  
                  
 <div class="btn-bottom-toolbar text-right">
                                      <button type="submit"
                                         class="btn btn-sm btn-primary" id="save">Save Details</button>
                                                              
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
 $(document).on("change", function () {
$('input:checkbox').click(function() {
 if ($(this).is(':checked')) {
 $('#save').prop("disabled", false);
 } else {
 if ($('.checks').filter(':checked').length < 0){
 $('#save').prop("disabled", true);

}
 }
});

  });       
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.type', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("school/findPLevel")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#class").empty();
                $("#class").append('<option value="">Select Class</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#class").append('<option value=' + value.id+ '>' + value.class + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>


@endsection