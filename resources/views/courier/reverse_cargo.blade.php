    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Reverse Courier Invoice</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
 
  {!! Form::open(array('route' => 'courier.reverse','method'=>'POST', 'class' => 'frm-example' , 'name' => 'frm-example')) !!}

<input name="id" type="hidden"  value="{{$old->id}}">

        <div class="modal-body">

                                        <?php
                                          $total_cost=0;
                                                ?>

                                        <div class="table-responsive">
                                    <table class="table datatable-modal table-striped" id="table-list">
                                        <thead>
                                            <tr>                                              
                                              
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 90.484px;">#</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 150.484px;">Tariff</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 180.484px;">Route</th> 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Total</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 120.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tenhag">
                                            @if(!@empty($items))
                                            @foreach ($items as $row)
                                            <tr class="gradeA even" role="row">
                                                <td>{{$loop->iteration}}</td>
                                                <?php
                                          $item_name = App\Models\Tariff::find($row->item_name);
                                        ?>
                                            <td class="">@if(!empty($item_name)) {{$item_name->zone_name}} - {{$item_name->weight}}  @else {{$row->item_name }} @endif</td>
                                             <td class="">From {{$row->start->name}} to {{$row->end->name}}</td>                                                   
                                            <td class="">{{number_format($row->total_cost + $row->total_tax ,2)}} </td>
                                                 <td><input name="trans_id[]" type="checkbox"  class="checks" value="{{$row->id}}">                                       
                                                    </td>                                                
                                            </tr>

                                           <?php
                                          $total_cost+=$row->total_cost + $row->total_tax;
                                                ?>
                                            @endforeach
                                            @endif

                                        </tbody>


                                            <tfoot>
                                            <tr class="gradeA even" role="row">
                                                <td></td>                                               
                                            <td class=""></td>
                                        <td class="">Total </td>                                                    
                                            <td class="">{{number_format($total_cost ,2)}} </td>
                                                 <td></td>
                                                          
                                            </tr>

                                        </tfoot>
                                    </table>
</div>
          
        </div>

       <div class="modal-footer ">
        <button class="btn btn-primary"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        
    </div>


@yield('scripts')
<script>
       $('.datatable-modal').DataTable({
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
   var table = $('.datatable-modal').DataTable();
   
   // Handle form submission event 
   $('.frm-example').on('submit', function(e){
    //e.preventDefault();
       
      var form = this;

    //   var rowCount = $('#tenhag >tr').length;
      var rowCount = $('#tenhag').find('tr').length;
console.log(rowCount);


if(rowCount == '1'){
var c= $(' #tenhag > tr').find('input[type=checkbox]');

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

<script>
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
</script>


