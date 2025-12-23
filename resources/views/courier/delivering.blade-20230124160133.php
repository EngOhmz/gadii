@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Courier Destination</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            @if(empty($id))
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Courier Destination</a>
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
<?php $id=1; ?>

                       {{ Form::model($id, array('route' => array('courier_movement.update', $id), 'method' => 'PUT', 'id' => 'frm-example' , 'name' => 'frm-example')) }}
                         
                            <div class="tab-pane fade active show " id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                  <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 30.484px;">#</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Ref No</th>
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
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Amount</th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 90.219px;">{{__('ordering.status')}}</th>


    

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($quotation))
                                            @foreach ($quotation as $row)
                                            <tr class="gradeA even" role="row">

                                                <td> {{$loop->iteration}}</td>
                                                <td>{{$row->confirmation_number}}</td>              
                                               <td>From {{$row->start->name}} to {{$row->end->name}}</td>
                                                <td>{{$row->route->zone_name}} - {{$row->route->weight}} </td>
                                                <td>{{$row->client->name}}</td>           
                                                <td>{{number_format($row->amount,2)}} {{$row->courier->currency_code}}</td>  
                                                    <!--<td>{{$row->receiver_name}}</td>-->


                                                <td>
                                                       @if($row->status == 5)
                                                   <div class="badge badge-info badge-shadow">Commissioned</div>
                                                    @elseif($row->status == 6)
                                                    <div class="badge badge-success badge-shadow">Delivered</div>
                                                    @endif
                                                </td>
                                          

                                                <td>
                                                    @if($row->status == 5  )                                              
                                                      <input name="item_id[]" type="checkbox"  class="checks" value="{{$row->id}}">
                                                     @elseif($row->status == 6)
                                                    <input name="item_id[]" type="hidden"  class="checks" value="{{$row->id}}">
                                                    @endif
                                                </td>

                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>


                                    </table>
                                </div>
                            </div>
                          


                   <div class="card" >
                                    <div class="card-header">
                                        <h5>Create Courier Destination Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">   

            
                                                      

           <div class="form-group">
          


            <div class="form-group row">
                <label class="col-lg-2 col-form-label">Description</label>

                <div class="col-lg-4">
                    <textarea name="notes" value="" required class="form-control"></textarea>                    
                </div>
            
                <label class="col-lg-2 col-form-label">Delivery Date</label>

                <div class="col-lg-4">
                   <input type="date" name="collection_date" value="<?php echo date('Y-m-d');  ?>"  required class="form-control">
                                                                                   
                    <input type="hidden" name="type" value="delivering" required class="form-control">
                    <input type="hidden" name="id" value="{{ $id}}" required class="form-control" id="collection">
                </div>
            </div>

        <div class="form-group row">
            <label class="col-lg-2 col-form-label">Collectors</label>
                <div class="col-lg-4">
                 <select class="form-control m-b" name="receiver_id" required   id="receiver_id">           
                                                                <option value="">Select Collectors</option>
                                                                @if(!empty($supplier))
                                                                @foreach($supplier as $row)

                                                                <option value="{{ $row->id}}">{{$row->driver_name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                        </div>

                                          <label class="col-lg-2 col-form-label">Received by</label>
                <div class="col-lg-4">
                    <input type="text" name="receiver_name" value=""  class="form-control">
                    
                </div></div>



<div class="form-group row">

                <label class="col-lg-2 col-form-label">Delivery Cost</label>

                <div class="col-lg-4">
                 <input type="number" name="costs"   value="0" class="form-control costs" required>
                     
</div>

 
                <label class="col-lg-2 col-form-label payment1"  style="display:none;">Payment Type</label>

                <div class="col-lg-4 payment2"  style="display:none;">
                   <select class="form-control type m-b payment_type" name="payment_type"  id="payment_type" >
                <option value="">Select Payment Type</option>                                                            
                        <option value="cash">On Cash</option>
                           <option value="credit">On Credit</option>
                          </select>

            </div>
</div>

<div class="form-group row account" id="account" style="display:none;">
<label  class="col-lg-2 col-form-label">Bank/Cash Account</label>

                <div class="col-lg-4">
                   <select class="form-control m-b" name="bank_id" >
                <option value="">Select Payment Account</option> 
                      @foreach ($bank_accounts as $bank)                                                             
                        <option value="{{$bank->id}}">{{$bank->account_name}}</option>
                           @endforeach
                          </select>
                </div>
            </div>


       <br><div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="freight" >Save</button>
                                               
                                                    </div>
                                                </div>

       


                        </div>
                    </div>
                </div>
            </div>

 </div>

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
</section>

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
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

<script>
    $(document).ready(function(){
   

 $(document).on('change', '.payment_type', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'cash') {
          $('.account').show(); 
        } else {
            $('.account').hide(); 
        } 


});


    });
</script>


<script>
    $(document).ready(function(){
   

 $(document).on('change', '.costs', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() > 0) {      
          $('.payment1').show(); 
       $('.payment2').show(); 
        } else {
           $('.payment1').hide(); 
       $('.payment2').hide(); 
      $('.account').hide(); 
        } 


});


    });
</script>

<script>
    $(document).ready(function(){
   /*
                * Multiple drop down select
                */
$('.m-b').select2({ width: '100%', });
 

   
    });
   </script>

<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("courier_movement.show", ":id") }}';
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



@endsection