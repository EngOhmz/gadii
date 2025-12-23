@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                       
                        <h5> Fuel Refill Payments</h5>
                       
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                
                                {{ Form::open(['route' => 'save_multiple_refill']) }}
                                @method('POST')
                             

                       <div class="form-group row"><label  class="col-lg-2 col-form-label">Supplier</label>

                <div class="col-lg-10">
                   <select class="form-control m-b" name="supplier"  id="supplier" required >
                <option value="">Select Supplier</option>                                                            
                      @foreach ($supplier as $supp)                                                             
                        <option value="{{$supp->id}}" @if(isset($data))@if($data->supplier == $supp->id) selected @endif @endif >{{$supp->name}}</option>
                           @endforeach
                          </select>
                </div>
            </div>



                                <div class="form-group row">

                                    <label class="col-lg-2 col-form-label">Amount
                                    </label>
                                    <div class="col-lg-10">
                                        <input type="text" name="amount"
                                            value="" class="form-control amount" required>

                                            
                                    </div>
                                </div>

                        <div class="form-group row"><label  class="col-lg-2 col-form-label">Bank/Cash Account</label>

                                    <div class="col-lg-10">
                                       <select class="form-control m-b " name="account_id"  id="account" required>
                                    <option value="">Select Payment Account</option> 
                                          @foreach ($bank_accounts as $bank)                                                             
                                            <option value="{{$bank->id}}" @if(isset($data))@if($data->account_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                               @endforeach
                                              </select>
                                    </div>
                                </div>


                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment Date</label>

                                    <div class="col-lg-10">
                                        <input type="date" name="date" value="{{ isset($data) ? $data->date : date('Y-m-d')}}"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Payment
                                        Method</label>

                                    <div class="col-lg-10">
                                        <select class="form-control m-b" name="payment_method" id="method" required>
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

                                <div class="form-group row"><label class="col-lg-2 col-form-label">Notes</label>

                                    <div class="col-lg-10">
                                        <textarea name="notes" 
                                            class="form-control"></textarea>
                                    </div>
                                </div>



                              
                               




                                <div class="form-group row">
                                    <div class="col-lg-offset-2 col-lg-12">
                                       
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">Add
                                            Payments</button>
                                      
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
</section>



@endsection

@section('scripts')


<script type="text/javascript">
$(document).ready(function() {
$('.amount').keyup(function(event) {   
if(event.which >= 37 && event.which <= 40) return;

$(this).val(function(index,value){
return value
.replace(/\D/g,"")
.replace(/\B(?=(\d{3})+(?!\d))/g,",");
   
});

});


});
</script>

<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection