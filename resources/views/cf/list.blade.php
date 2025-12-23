    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Payment List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

 {!! Form::open(array('route' => 'cf_expenses.approve','method'=>'POST', 'id' => 'exp-example' , 'class' => 'exp-example' , 'name' => 'exp-example')) !!}
 <div class="modal-body">
<?php
$total=0;
?>

 <input type="hidden" name="project_id" value="{{ $main->cf_id}}">

            <div class="table-responsive">
                                            <table class="table datatable-modal table-striped">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 206.484px;">Expense Account</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 151.219px;">Payment Account</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                     
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 58.1094px;">Confirm</th>
                                            </tr>
                                        </thead>
                                         <tbody id="exp-list">
                                            @if(!@empty($expense))
                                            @foreach ($expense as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                   
                                                    @php
                                                 $account=App\Models\AccountCodes::where('id',$row->account_id)->first();
                                                @endphp
                                               @if(!empty($account))
                                                <td>{{$account->account_name}}</td>
                                              @else
                                                <td></td>
                                              @endif

                                                      @php
                                                 $bank=App\Models\AccountCodes::where('id',$row->bank_id)->first();
                                                @endphp
                                                <td>{{$bank->account_name}}</td>                                           
                                                  <td>{{number_format($row->amount,2)}} {{$row->exchange_code}}</td>
                                                  
                               
                                                <td>
                                                    @if($row->status == 0)
                                                   <div class="form-inline">
                                                       
                                                        
<a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')"   href="{{route('edit.cf_details',['id' => $main->cf_id,'type'=>'edit-expenses','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp&nbsp
     <a title="Delete" onclick="return confirm('Are you sure? you want to delete')"  href="{{route('delete.cf_details',['type'=>'delete-expenses','type_id'=>$row->id])}}" class="list-icons-item text-danger delete" > <i class="icon-trash"></i> </a>&nbsp                                                  
                                  
                                                    @endif                                           

                                                </td>

 <td> @if($row->status == 0)<input name="trans_id[]" type="checkbox"  class="checks" value="{{$row->id}}">  @endif </td>

                              
                                            </tr>
<?php
                 $total+=$row->amount;
?>
                                            @endforeach

                                            @endif

                                        </tbody>
<tfoot>
<td></td><td></td>
<td><b>Total</b></td><td><b>{{number_format($total,2)}}</b> </td>
<td></td><td></td>
</tfoot>
                                    </table>
                                </div>
                                                    </div>


        
        <div class="modal-footer">
          @if($con != $st) <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button> @endif
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
  {!! Form::close() !!}
    </div>

@yield('scripts')


    <script>
$(document).ready(function (){
   var table = $('.datatable-modal').DataTable();
   
   // Handle form submission event 
   $('.exp-example').on('submit', function(e){
    //e.preventDefault();
       
      var form = this;

    //   var rowCount = $('#exp-list >tr').length;
      var rowCount = $(' #exp-list > tr').find('input[type=checkbox]').length;
console.log(rowCount);


if(rowCount == '1'){
var c= $(' #exp-list > tr').find('input[type=checkbox]');

  if(c.is(':checked')){ 
var tick=c.val();
console.log(tick);

$(form).append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', 'checked_trans_id[]')
                  .val(tick)  );

}

}


else if(rowCount > '1'){
      // Encode a set of form elements from all pages as an array of names and values
      var params = table.$('input').serializeArray();

      // Iterate over all form elements
      $.each(params, function(){     
         // If element doesn't exist in DOM
         if(!$.contains(document, form[this.name])){
            // Create a hidden element 
            $(form).append(
               $('<input>')
                  .attr('type', 'hidden')
                  .attr('name', 'checked_trans_id[]')
                  .val(this.value)
            );
         } 
      });      

}
   
   });  
    
});


</script>




