@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Courier Freight </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            @if(empty($id))
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Courier Freight </a>
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
 {!! Form::open(array('route' => 'save.freight' ,'method'=>'POST', 'id' => 'frm-example' , 'name' => 'frm-example')) !!}
    @csrf
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                             
                                       
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
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Weight</th>
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
                                                    style="width: 161.219px;">Amount</th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">{{__('ordering.status')}}</th>


    

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
                                                <td>{{$row->confirmation_number}}</td>              
                                               <td>{{$row->weight}} kgs</td>
                                                <td>From {{$row->route->from}} to {{$row->route->to}}</td>
                                                <td>{{$row->client->name}}</td>           
                                              <td>{{number_format($row->amount,2)}} {{$row->courier->currency_code}}</td>  
                                                    <!--<td>{{$row->receiver_name}}</td>-->


                                                <td>
                                                    @if($row->status == 3)
                                                    <div class="badge badge-success badge-shadow">Picked</div>

                                                    @endif
                                                </td>
                                          

                                                <td>
                                                 <input name="item_id[]" type="checkbox"  class="checks" value="{{$row->id}}"></td>

                                                 <!--
                                                      <button type="button" class="btn btn-xs btn-primary"
                                            data-toggle="modal" data-target="#appFormModal"
                                            data-id="{{ $row->id }}" data-type="loading"
                                            onclick="model({{ $row->id }},'loading')">
                                            Freight
                                        </button>
-->
                                                
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                           


<div class="card" >
                                    <div class="card-header">
                                        <h5>Create Courier Freight Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">   

            
                                                      

           <div class="form-group">
                <label class="col-lg-6 col-form-label">Freight Method</label>

                <div class="col-lg-12">
                   <select class="form-control m-b method" name="method" required >
                                                    <option value="">Select Freight Method</option>                                                          
                                                            <option value="Truck Freight" >Truck Freight</option>
                                                              <option value="Air Freight" >Air Freight</option>
                                                              </select>
</div>
            </div>


            <div class="form-group">
                <label class="col-lg-6 col-form-label">Description</label>

                <div class="col-lg-12">
                    <input type="text" name="notes" value="" required class="form-control">
                    
                </div>
            </div>

             <div class="form-group truck" style="display:none;">
                <label class="col-lg-6 col-form-label">Vehicle Reg No</label>

                <div class="col-lg-12">
                 <input type="text" class="form-control truck_id" name="truck_id" id="truck" >
                </div>
            </div>

        
      <div class="form-group awb" style="display:none;">
                <label class="col-lg-6 col-form-label">AWB Number</label>

                <div class="col-lg-12">
                      <input type="text" class="form-control awb" name="awb" id="awb" >
                </div>
            </div>
          
                 <div class="form-group">
                <label class="col-lg-6 col-form-label">Loading Date</label>

                <div class="col-lg-12">
                    <input type="date" name="collection_date" value="<?php echo date('Y-m-d');  ?>" required class="form-control">
                    <input type="hidden" name="type" value="loading" required class="form-control">
                </div>
            </div>

        <div class="form-group">
                <label class="col-lg-6 col-form-label">Loading Cost</label>

                <div class="col-lg-12">
                 <input type="number" name="costs"   value="0" class="form-control" >
                     <input type="hidden" name="id" value="" required class="form-control fid">                       

</div>
            </div>


   <div class="form-group">
                <label class="col-lg-6 col-form-label">Payment</label>

                <div class="col-lg-12">
                   <select class="form-control m-b" name="bank_id" >
                                                    <option value="">Select Payment Account</option> 
                                                             @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" >{{$bank->account_name}}</option>
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
    $(document).ready(function(){
   

 $(document).on('change', '.method', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'Truck Freight') {
          $('.truck').show(); 
           $('.awb').hide(); 
        }else if($(this).val() == 'Air Freight') {
          $('.truck').hide(); 
           $('.awb').show(); 
        }else {
            $('.awb').hide(); 
              $('.truck').hide(); 
        } 

});


    });
</script>

@endsection