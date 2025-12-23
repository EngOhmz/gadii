@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Bookings </h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                             
                                <li class="nav-item">
                                    <a class="nav-link active show"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Booking</a>
                                </li>
                               
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                
                                <div class="tab-pane fade active show "
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (empty($id))
                                                <h5>Create Invoice</h5>
                                            @else
                                                <h5>Edit Invoice</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                {{ Form::model($id, array('route' => array('booking.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data", 'id' => 'invform')) }}
                                                        
                                                    @else
                                                        {!! Form::open(array('route' => 'booking.store',"enctype"=>"multipart/form-data", 'id' => 'invform')) !!}
                                                        @method('POST')
                                                    @endif


                                                    <input type="hidden" name="type" class="form-control name_list"
                                                        value="{{ $type }}" />
                                                         <input type="hidden" name="inv_id" class="form-control inv_id"
                                                        value="{{ isset($data) ? $id : '' }}" />
                                                        
                                                        
                                                        <div class="form-group row">
                                                    
                                                     <label class="col-lg-2 col-form-label">Check In Date <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                            <input name="start_date" id="date1" type="date" class="form-control date1" onkeydown="return false" required value="{{ $start_date}}" readonly required>
                                                        </div>

                                                        <label class="col-lg-2 col-form-label">Client Name <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                                <select class="form-control m-b client_id"
                                                                    name="client_id" id="client_id" required>
                                                                    <option value="">Select Client Name</option>
                                                                    @if (!empty($client))
                                                                        @foreach ($client as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->client_id == $row->id ? 'selected' : '' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>
                                                        </div>
                                                        
                                                        
                                                
                                                        </div>

                                                 
                                                    

                                                    <div class="form-group row">
                                                    
                                                    <label class="col-lg-2 col-form-label">Property <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                   
                    <select name="hotel_id" class="form-control m-b location" id="location_id" disabled required>
                        <option value="">Select Property</option>
                        @if(!empty($location))
                       
                        @foreach($location as $br)
                        <option value="{{$br->id}}" @if(isset($hotel_id)){{  $hotel_id == $br->id  ? 'selected' : ''}} @endif>{{$br->name}}</option>
                        @endforeach
                      
                        @endif
                    </select>
                    
                     <input type="hidden" name="hotel_id" class="form control location" id="location_id" value="{{ $hotel_id}}" required readonly>
                    
                </div>

                                                        
                                                        
                                                        <label class="col-lg-2 col-form-label">Branch</label>
                                                            <div class="form-group col-md-4">
                                                                <select class="form-control m-b" name="branch_id">
                                                                    <option>Select Branch</option>
                                                                    @if (!empty($branch))
                                                                        @foreach ($branch as $row)
                                                                            <option value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                    </div>
                                                    
                                                    <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Sales Agent <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            @if (!empty($data->user_agent))

                                                                <select class="form-control m-b" name="user_agent"
                                                                    id="user_agent" required>
                                                                    <option value="{{ old('user_agent') }}" disabled
                                                                        selected>Select User</option>
                                                                    @if (isset($user))
                                                                        @foreach ($user as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->user_agent == $row->id ? 'selected' : 'TZS' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            @else
                                                                <select class="form-control m-b" name="user_agent"
                                                                    id="user_agent" required>
                                                                    <option value="{{ old('user_agent') }}" disabled
                                                                        selected>Select User</option>
                                                                    @if (isset($user))
                                                                        @foreach ($user as $row)
                                                                            @if ($row->id == auth()->user()->id)
                                                                                <option value="{{ $row->id }}"
                                                                                    selected>{{ $row->name }}</option>
                                                                            @else
                                                                                <option value="{{ $row->id }}">
                                                                                    {{ $row->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>


                                                            @endif
                                                        </div>
                                                        <label class="col-lg-2 col-form-label" for="gender">Sales Type <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b sales" name="sales_type"
                                                                id="sales" required>
                                                                <option value="">Select Sales Type</option>
                                                                <option value="Cash Sales"
                                                                    @if (isset($data)) {{ $data->sales_type == 'Cash Sales' ? 'selected' : '' }} @endif>
                                                                    Cash Sales</option>
                                                                <option value="Credit Sales"
                                                                    @if (isset($data)) {{ $data->sales_type == 'Credit Sales' ? 'selected' : '' }} @endif>
                                                                    Credit Sales</option>
                                                            </select>
                                                           
                                                           
                                                        </div>
                                                        </div>
                                                        
                                                        
                                                            <div class="form-group row">
                                                        @if (!empty($data->bank_id))
                                                            <label for="stall_no" class="col-lg-2 col-form-label bank1"
                                                                style="display:block;">Bank/Cash Account <span class="required"> * </span></label>
                                                            <div class="col-lg-4 bank2" style="display:block;">
                                                                <select class="form-control m-b" name="bank_id" id="bank_id">
                                                                    <option value="">Select Payment Account</option>
                                                                    @foreach ($bank_accounts as $bank)
                                                                        <option value="{{ $bank->id }}"
                                                                            @if (isset($data)) @if ($data->bank_id == $bank->id) selected @endif
                                                                            @endif
                                                                            >{{ $bank->account_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @else
                                                            <label for="stall_no" class="col-lg-2 col-form-label bank1"
                                                                style="display:none;">Bank/Cash Account <span class="required"> * </span></label>
                                                            <div class="col-lg-4 bank2" style="display:none;">
                                                                <select class="form-control m-b" name="bank_id" id="bank_id">
                                                                    <option value="">Select Payment Account</option>
                                                                    @foreach ($bank_accounts as $bank)
                                                                        <option value="{{ $bank->id }}"
                                                                            @if (isset($data)) @if ($data->bank_id == $bank->id) selected @endif
                                                                            @endif
                                                                            >{{ $bank->account_name }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        @endif
                                                        
                                                         
                                                    </div>

                                                   
                                                       
                                               
                                                    <br>
                                                    <h4 align="center">Enter Item Details</h4>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Currency <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            @if (!empty($data->exchange_code))

                                                                <select class="form-control m-b" name="exchange_code"
                                                                    id="currency_code" required>
                                                                    <option value="{{ old('currency_code') }}" disabled
                                                                        selected>Choose option</option>
                                                                    @if (isset($currency))
                                                                        @foreach ($currency as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif
                                                                                value="{{ $row->code }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            @else
                                                                <select class="form-control m-b" name="exchange_code"
                                                                    id="currency_code" required>
                                                                    <option value="{{ old('currency_code') }}" disabled>
                                                                        Choose option</option>
                                                                    @if (isset($currency))
                                                                        @foreach ($currency as $row)
                                                                            @if ($row->code == 'TZS')
                                                                                <option value="{{ $row->code }}"
                                                                                    selected>{{ $row->name }}</option>
                                                                            @else
                                                                                <option value="{{ $row->code }}">
                                                                                    {{ $row->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>


                                                            @endif
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Exchange Rate <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <input type="number" name="exchange_rate"
                                                                placeholder="1 if TZSH"
                                                                value="{{ isset($data) ? $data->exchange_rate : '1.00' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add Rooms</i></button><br>
                                                    <br>
                                                    
                                                     <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                                                      
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Check Out Date <span class="required"> * </span></th>
                                                                    <th>Room Type<span class="required"> * </span></th>
                                                                    <th>Room Name <span class="required"> * </span></th>
                                                                    <th>Checkout time </th>
                                                                    <th>Price <span class="required"> * </span></th>
                                                                    <th>Total <span class="required"> * </span></th>
                                                                    <th>Action </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            
                                                            @if (!empty($items))
                                                            @foreach($items as $n)
                                                            @php $i=App\Models\Hotel\HotelItems::find($n); @endphp
                                                            <tr>
                <td><input type="date" name="end_date[]" class="form-control date2" id="date2" value="{{$end_date }}" onkeydown="return false" readonly/></td>
                <td>
                <select  class="form-control m-b item_type" disabled required><option value="">Select Type</option>
                 @foreach ($room_type as $r)
                 <option value="{{ $r->id }}" @if (isset($i)) @if ($r->id == $i->room_type) selected @endif @endif>{{ $r->name }}</option>
                 @endforeach
                </select>
                <input type="hidden" name="room_type[]" class="form-control item_type" value="{{$i->room_type }}"  required />
                </td>
                
                <td>
                <select  class="form-control m-b item_name" disabled required><option value="">Select Room</option>
                 @foreach ($room as $ro)
                 <option value="{{ $ro->id }}" @if (isset($i)) @if ($ro->id == $i->id) selected @endif @endif>{{ $ro->name }}</option>
                 @endforeach
                </select>
                <input type="hidden" name="room_name[]" class="form-control item_name" value="{{$i->id }}"  required />
                </td>
                
               <td><input name="checkout_time[]" type="time" class="form-control time"  value=""/></td>
               <td><input type="text" name="price[]" class="form-control item_total" value="{{$i->price }}" required  /></td>
               <input type="hidden" name="nights[]" class="form-control item_nights" placeholder ="total"  value="{{$nights }}"  required /></td>
               <td><input type="text" name="total_cost[]" class="form-control item_price" placeholder ="total"  jAutoCalc="{price} * {nights}"  readonly required /></td>
                <td></td>
                <tr>
                                                            @endforeach
                                                            @endif
                                                            </tr>
                                                            </tbody>
                                                            <tfoot>
                                                              <tr class="line_items">
                                                                    <td colspan="4"></td>
                                                                    <td><span class="bold">Total </span>: </td>
                                                                    <td><input type="text" name="subtotal[]"
                                                                            class="form-control total"
                                                                            value="{{ isset($data) ? '' : '0.00' }}"
                                                                            required jAutoCalc="SUM({total_cost})"
                                                                            readonly></td>
                                                                </tr>
                                                               
                                                              
                                                            </tfoot>
                                                        </table>
                                                    </div>


                                                    <br>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))

                                                                <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                    href="{{ route('booking.index') }}">
                                                                    Cancel
                                                                </a>
                                                                
                                                            @else
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
                                                                    type="submit" id="save">Save</button>
                                                            @endif
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

        </div>
    </section>

    <!-- supplier Modal -->
    <div class="modal fade" data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">

        </div>
    </div>
    
    
@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            order: [
                [2, 'desc']
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [3]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>
    
   <script>
    
    $(document).ready(function() { //DISABLED PAST DATES IN APPOINTMENT DATE
  var dateToday = new Date();
  var month = dateToday.getMonth() + 1;
  var day = dateToday.getDate();
  var year = dateToday.getFullYear();

  if (month < 10)
    month = '0' + month.toString();
  if (day < 10)
    day = '0' + day.toString();

  var maxDate = year + '-' + month + '-' + day;

  $('#date1').attr('min', maxDate);
});
    </script>   

    

    <script type="text/javascript">
        $(document).ready(function() {


            var count = 0;


            function autoCalcSetup() {
                $('table#cart').jAutoCalc('destroy');
                $('table#cart tr.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('table#cart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();
            
           
            
            $('.add').on("click", function(e) {

                count++;
                var html = '';
                html += '<tr class="line_items">';
                
                html +='<td class="rdate_' +count + '"><input type="date" name="end_date[]" class="form-control date2" id="date2_' +count + '" data-category_id="' +count +'" onkeydown="return false"/></td>';
                html +='<td class="rtype_' +count + '"><select name="room_type[]" class="form-control m-b item_type" data-sub_category_id="' +count +'" required><option value="">Select Type</option></select></td>';
                html += '<td class="rname_' +count + '"><select name="room_name[]" class="form-control m-b item_name"   data-sub_category_id="' +count + '"  required><option value="">Select Room</option></select></div></td>';
                html += '<td><input name="checkout_time[]" type="time" class="form-control time' + count +'"  value=""/></td>';
                html += '<td class="rtotal_' +count + '"><input type="text" name="price[]" class="form-control item_total" data-category_id="' +count +'" required  /></td>';
                 html += '<input type="hidden" name="nights[]" class="form-control item_nights' +count +'" placeholder ="total"   required /></td>';
                html += '<td><input type="text" name="total_cost[]" class="form-control item_price' +count +'" placeholder ="total"  jAutoCalc="{price} * {nights}"  reaonly required /></td>';
                
                html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

                $('#cart > tbody').append(html);
                autoCalcSetup();
                
                
                /*
                 * Multiple drop down select
                 */
                $('.m-b').select2({});
                
                
 var dateToday = new Date();
  var month = dateToday.getMonth() + 1;
  var day = dateToday.getDate();
  var year = dateToday.getFullYear();

  if (month < 10)
    month = '0' + month.toString();
  if (day < 10)
    day = '0' + day.toString();

  var maxDate = year + '-' + month + '-' + day;

  $('#date2_'+count).attr('min', maxDate);

 



            });

          

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                autoCalcSetup();
            });


            $(document).on('click', '.rem', function() {
                var btn_value = $(this).attr("value");
                $(this).closest('tr').remove();
                $('#cart > tfoot').append(
                    '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                    btn_value + '"/>');
                autoCalcSetup();
            });

        });
    </script>
    
    
    
   
       <script>
$(document).ready(function() {
    
    $(document).on('change', '.date1', function() {
     $(".date2").change();

    });
    
    $(document).on('change', '.location', function() {
     $(".date2").change();

    });
    
    $(document).on('change', '.date2', function() {
        var id = $(this).val();
        var location= $('.location').val();
         var date= $('.date1').val();
          var sub_category_id = $(this).data('category_id');
          console.log(id);
        $.ajax({
            url: '{{url("hotel/showType")}}',
            type: "GET",
            data: {
                id: id,
                 location: location,
                 date:date,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                
            var s = new Date(date);
            var e = new Date(id);
            var timeDiff = Math.abs(e.getTime() - s.getTime());
            var nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
                
                $('.item_nights' + sub_category_id).empty();
                $('.item_nights' + sub_category_id).val(nights);
                
                 $(".item_total").change();
               $('.rtype_'+sub_category_id).find('.item_type').empty();
               $('.rname_'+sub_category_id).find('.item_name').empty();
                $('.rname_'+sub_category_id).find('.item_name').append('<option value="">Select Room Name</option>');
               $('.rtotal_'+sub_category_id).find('.item_total').val(0);
                $('.item_price' + sub_category_id).val(0);
                $('.rtype_'+sub_category_id).find('.item_type').append('<option value="">Select Room Type</option>');
                $.each(data,function(key, value)
                {

           $('.rtype_'+sub_category_id).find('.item_type').append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                   
                });              
               
            }

        });

    });
    
    
    
    $(document).on('change', '.item_type', function() {
        var id = $(this).val();
         var sub_category_id = $(this).data('sub_category_id');
        var location= $('.location').val();
         var sdate= $('.date1').val();
         var edate= $('.rdate_'+sub_category_id).find('.date2').val();
         
          console.log(sub_category_id);
        $.ajax({
            url: '{{url("hotel/showName")}}',
            type: "GET",
            data: {
                id: id,
                 location: location,
                 sdate:sdate,
                 edate:edate,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);

                  $(".item_total").change();
                  
               $('.rname_'+sub_category_id).find('.item_name').empty();
               $('.rtotal_'+sub_category_id).find('.item_total').val(0);
                $('.item_price' + sub_category_id).val(0);
                $('.rname_'+sub_category_id).find('.item_name').append('<option value="">Select Room Name</option>');
                $.each(data,function(key, value)
                {

           $('.rname_'+sub_category_id).find('.item_name').append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                   
                });              
               
            }

        });

    });
     
    
    $(document).on('change', '.item_name', function() {
            var id = $(this).val();
           
            var sub_category_id = $(this).data('sub_category_id');
             console.log(sub_category_id);
            $.ajax({
            url: '{{url("hotel/findPrice")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);

                $('.rtotal_'+sub_category_id).find('.item_total').val(data[0]["price"]);
                $('.item_price' + sub_category_id).val(data[0]["price"]);
            }

        });

    });


    
   
   
   
}); 
    </script>
    

<script>
    $(document).ready(function() {
    
      
         $(document).on('click', '.save', function(event) {
   
         $('.errors').empty();
        
          if ( $('#cart tbody tr').length == 0 ) {
               event.preventDefault(); 
    $('.errors').append('Please Select Rooms.');
}
         
         else{
            
         
          
         }
        
    });
    
    
    
    });
    </script>
 


    <script type="text/javascript">
        function model(id, type) {


            $.ajax({
                type: 'GET',
                url: '{{ url('hotel/discountModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('#appFormModal > .modal-dialog').html(data);
                    
                },
                error: function(error) {
                    $('#appFormModal').modal('toggle');

                }
            });

        }

        function saveClient(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/save_client') }}',
                data: $('#addClientForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#client_id').append(option);
                    $('#appFormModal').hide();



                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {

            $(document).on('change', '.sales', function() {
                var id = $(this).val();
                console.log(id);


                if (id == 'Cash Sales') {
                    $('.bank1').show();
                    $('.bank2').show();
                    $("#bank_id").prop('required',true);

                } else {
                    $('.bank1').hide();
                    $('.bank2').hide();
                     $("#bank_id").prop('required',false);

                }

            });



        });
    </script>
    
    
    
    <script type="text/javascript">
       


        function saveClient(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/save_client') }}',
                data: $('.addClientForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#client_id').append(option);
                    $('#appFormModal').hide();



                }
            });
        }
        
        
    </script>
    
         

@endsection