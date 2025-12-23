@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Multiple Mileage Payment</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                         
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Mileage
                                    List</a>
                            </li>
                           
                           
                           

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                               
                            {!! Form::open(array('route' => 'multiple_mileage_payment','method'=>'POST', 'id' => 'frm-example' , 'name' => 'frm-example')) !!} 
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
                                                    style="width: 128.484px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 116.484px;">Truck</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Route</th>
                                              
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Mileage Amount</th>

                                              <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($fuel))
                                            @foreach ($fuel as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                           <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}} </td>
                                                <td>{{$row->truck->reg_no}}</td>
                                             
                                                <td>From {{$row->route->from}} to {{$row->route->to}}</td>
                                           <td>{{number_format($row->due_mileage,2)}} TZS</td>
                                               
                                                   <td> 
                                        @if($row->payment_status == 0)
                                        <div class="badge badge-warning badge-shadow">Not Paid</div>
                                        @elseif($row->payment_status == 1)
                                        <div class="badge badge-info badge-shadow">Partially Paid</div>
                                        @elseif($row->payment_status== 2)
                                        <span class="badge badge-success badge-shadow">Fully Paid</span>
                                       
                                        @endif
                                       
                                    </td>

                                                <td><input name="item_id[]" type="checkbox"  class="checks" value="{{$row->id}}"> </td>

                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>



<br>
<h4>Payment Details</h4>
<hr>

              <div class="form-group row"><label class="col-lg-2 col-form-label">Payment Date</label>

                                    <div class="col-lg-4">
                                        <input type="date" name="date" value="{{ isset($data) ? $data->date : date('Y-m-d')}}"
                                            class="form-control" required>
                                    </div>
                               <label class="col-lg-2 col-form-label">Payment
                                        Method</label>

                                    <div class="col-lg-4">
                                        <select class="form-control m-b" name="payment_method" id="method">
                                            <option value="">Select
                                            </option>
                                            @if(!empty($payment_method))
                                            @foreach($payment_method as $row)
                                            <option value="{{$row->id}}" @if(isset($data))@if($data->
                                                manager_id == $row->id) selected @endif @endif >From
                                                {{$row->name}}
                                            </option>

                                            @endforeach
                                            @endif
                                        </select>

                                    </div>
                                </div>

                              
                                <div class="form-group row"><label  class="col-lg-2 col-form-label">Bank/Cash Account</label>

                                    <div class="col-lg-4">
                                       <select class="form-control m-b" name="account_id" id="account" required>
                                    <option value="">Select Payment Account</option> 
                                          @foreach ($bank_accounts as $bank)                                                             
                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->account_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                               @endforeach
                                              </select>
                                    </div>

                        <label class="col-lg-2 col-form-label">Notes</label>

                                    <div class="col-lg-4">
                                        <textarea name="notes" 
                                            class="form-control"></textarea>
                                    </div>


                                </div>
                                   
<button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save" >Save</button>
                    {!! Form::close() !!}
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


<script type="text/javascript">


    function model(id,type) {

$.ajax({
    type: 'GET',
    url: '{{url("mileageModal")}}',
    data: {
        'id': id,
        'type':type,
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

 function ShowDiv() {
                  var ddlPassport = document.getElementById("type");
                var dfPassport = document.getElementById("account");
              dfPassport.style.display = ddlPassport.value == "cash" ? "block" : "none";
    }

function calculateCost() {
    
    $('#price,#litres').on('input',function() {
    var price= parseInt($('#price').val());
    var qty = parseFloat($('#litres').val());
    console.log(qty);
    $('#total_c').val((10* 2 ? 10* 2 : 0).toFixed(2));
    });
    
    }



                    


             </script>




@endsection