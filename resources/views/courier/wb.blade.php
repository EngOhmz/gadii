@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Delivered Package List </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            @if(empty($id))
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Delivered Package List</a>
                            </li>
                            @else
                           <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">{{__('ordering.create_quotation')}}</a>
                            </li> 
                            @endif

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                                
                                          {!! Form::open(array('route' => 'courier.wb','method'=>'POST', 'id' => 'frm-example' , 'name' => 'frm-example')) !!}

                                                          <table class="table datatable-basic table-striped" id="table-1">
                          <thead>
                                        <tr>
             <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 36.484px;">#</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">REF NO</th>
                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 161.219px;">WBN No</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 141.484px;">Location</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Tariff</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Client</th>
                                                  

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($quotation))
                                            @foreach ($quotation as $row)
                                            <tr class="gradeA even" role="row">

                                                <td> {{$loop->iteration}}</td>
                                                <td>{{$row->pacel_number}}</td>  
                                           <td>{{$row->wbn_no}}</td>              
                                             <td> {{$row->start->name}} - {{$row->end->name}}</td>
                                                <td>@if(!empty($row->route->zone_name)) {{$row->route->zone_name}} - {{$row->route->weight}}  @else {{$row->tariff_id }} @endif</td>
                                                <td>{{$row->client->name}}</td>
                                                    <!--<td>{{$row->receiver_name}}</td>-->

                                                <td>
                  <input name="item_id[]" type="checkbox"  class="checks" value="{{$row->id}}">
                                                </td>

                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>

                                    </table>
                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>
 {!! Form::close() !!}
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

    </div>
</section>

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>



<!-- continue Modal -->
<div class="modal fade" id="newFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog-new">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Order Collection</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
      
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary"  data-dismiss="modal">Yes</button>
            <a href="{{ route("order.collection")}}" class="btn btn-danger">No</a>
        </div>
       
    </div>
</div>
    </div>
</div>



@endsection

@section('scripts')
 <script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [3]}
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
      var params = table.$('input').serializeArray();

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

<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("order_movement.show", ":id") }}';
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





<script>
$(document).ready(function() {

  

    $(document).on('change', '.truck_id', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findExp")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
              console.log(data);


var a=data[0]["expire_date"];

const date1 = new Date();
const date2 = new Date(a);
const diffTime = (date2 - date1);
const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (window.confirm('You are license is about to expire in '+diffDays+' days . Do you want to continue ? ')) {
  // Save it!
  console.log('Thing was saved to the database.');
} else {
  // Do nothing!
 var targetUrl = '{{url("collection")}}';
 window.location.href = targetUrl;
  console.log('Thing was not saved to the database.');
}
    
      
    
               
            }

        });

    });



$(document).on('change', '.type', function() {
        var id = $(this).val();
     var collection=$('#collection').val();
        $.ajax({
            url: '{{url("findTruck")}}',
            type: "GET",
            data: {
                id: id,
              collection: collection,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#test").empty();
               
                $.each(response,function(key, value)
                {
                 
                     $('#test').append(response.html);
                   
                });                      
               
            }

        });
  });


});
</script>

<script>
$('input:checkbox').click(function() {
 if ($(this).is(':checked')) {
 $('#save').prop("disabled", false);
 } else {
 if ($('.checks').filter(':checked').length < 1){
 $('#save').prop("disabled", true);

}
 }
});

         </script>

@endsection