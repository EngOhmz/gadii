    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign User for Task {{$data->task_name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

 {!! Form::open(array('route' => 'task.assign_user','method'=>'POST', 'id' => 'frm-example' , 'class' => 'frm-example' , 'name' => 'frm-example')) !!}
 <div class="modal-body">
<?php
$total=0;
$list=explode(",", $data->assigned_to);
?>

 <input type="hidden" name="task_id" value="{{ $id}}">

            <div class="table-responsive">
                                                            <table class="table datatable-modal table-striped" id="table-list">
                                       <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 98.531px;">#</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Name</th>                                             
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;"><input type="checkbox" name="select_all"  id="example-select-all"> Select All</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!empty($user))
                                            @foreach ($user as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                     <td>{{$row->name}}</td>
                                               <td> <input name="trans_id[]" type="checkbox"  class="checks" value="{{$row->id}}" <?php if(in_array("$row->id",$list)){echo "checked";}?>>   </td>

                                            </tr>
                                          
                                       
                                            @endforeach
                                                   @endif
                                            </tbody>
                                    </table>
                                </div>
                                                    </div>


        
        <div class="modal-footer">
           <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
  {!! Form::close() !!}
    </div>

@yield('scripts')


<script>

$("#example-select-all").click(function() {
  $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});

$("input[type=checkbox]").click(function() {
  if (!$(this).prop("checked")) {
    $("#example-select-all").prop("checked", false);
  }
});


</script>


