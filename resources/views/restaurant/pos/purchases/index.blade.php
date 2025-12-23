@extends('layouts.master')
@section('title') Bar Purchases @endsection

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Purchase Order</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Purchase Order
                                     List</a>
                            </li>
<!--
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Purchase</a>
                            </li>
-->
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                  <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Ref No</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Supplier Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Purchase Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Due Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 101.219px;">Status</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 168.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($purchases))
                                            @foreach ($purchases as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('restaurant_purchase.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                </td>
                                                <td>
                                                      {{$row->supplier->name }}
                                                </td>
                                                
                                                <td>{{$row->purchase_date}}</td>

                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>

                                                <td>
                                                    @php    
                                                    $loc=App\Models\Location::where('id', $row->location)->get();   
                                                  @endphp
                                                     @foreach($loc as $l)
                                                    {{$l->name}}
                                                    @endforeach
                                                </td>
                                               


                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-warning badge-shadow">Not Paid</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($row->status == 3)
                                                    <span class="badge badge-success badge-shadow">Fully Paid</span>
                                                    @elseif($row->status == 4)
                                                    <span class="badge badge-danger badge-shadow">Cancelled</span>

                                                    @endif
                                                </td>
                                               
                                                
                                               <td>
                                                        <div class="form-inline">
                                                   
                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                                <div class="dropdown-menu">

                                                      @can('manage-second-approval')
                           @if($row->approval_1 != '' && $row->approval_2 == '')
                            <a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to approve')" href="{{ route('restaurant_purchase.second_approval', $row->id)}}">First Approval</a>
                         {{--<a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to disapprove')" href="{{ route('restaurant_purchase.second_disapproval', $row->id)}}">Disapprove</a>--}}
                                         @endif
                                               @endcan

                                            @can('manage-third-approval')
                            @if($row->approval_1 != '' && $row->approval_2 != '' && $row->approval_3 == '')
                            <a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to approve')" href="{{ route('restaurant_purchase.final_approval', $row->id)}}">Final Approval</a>
                         <a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to disapprove')" href="{{ route('restaurant_purchase.final_disapproval', $row->id)}}">Disapprove</a>
                          @endif
                                @endcan
                                                          
                                                     @canany(['manage-first-approval', 'manage-second-approval','manage-third-approval'])
                                                               @if($row->approval_1 != '' && $row->approval_2 != '' && $row->approval_3 != '')

                                                            @if( $row->good_receive == 0)
                                                                                                                   
                                                             <a class="nav-link" id="profile-tab2" data-id="{{ $row->id  }}" data-type="receive"   onclick="model({{ $row->id  }},'receive')"
                                                                    href=""  data-toggle="modal" data-target="#appFormModal"
                                                                    role="tab"
                                                                    aria-selected="false">Good Receive</a>

                                                 <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('restaurant_purchase.issue',$row->id)}}"
                                                                    role="tab"
                                                                    aria-selected="false" onclick="return confirm('Are you sure?')">Issue Supplier</a>
                                                          
                                                            @endif


                                                             @if($row->status == 1 || $row->status == 2  )
                                                           <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('restaurant_purchase.pay',$row->id)}}"
                                                                    role="tab"
                                                                    aria-selected="false">Make Payments</a>
                                                            
                                                            @endif

                                                                @endif

                                                        @endcanany

                                                             
                                                          
                                                            
                                            @if( $row->good_receive == 1)
                                                <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('restaurant_issue_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
                                                                    role="tab"
                                                                    aria-selected="false" >Download Supplier Issue</a>
                                                             @endif

                                               <a class="nav-link" id="profile-tab2" href="{{ route('restaurant_purchase_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
                                                            role="tab"  aria-selected="false">Download PDF</a>
                                                       </div>
                                                </div>
                                                   
                                                </div>

                                                </td>
                                               
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Purchase</h5>
                                        @else
                                        <h5>Edit Purchase</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('restaurant_purchase.update', $id), 'method' => 'PUT')) }}
                                              
                                                @else
                                                {{ Form::open(['route' => 'restaurant_purchase.store']) }}
                                                @method('POST')
                                                @endif


                                                <input type="hidden" name="type"
                                                class="form-control name_list"
                                                value="{{$type}}" />

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Location</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control m-b" name="location" required
                                                        id="location">
                                                        <option value="">Select Location</option>
                                                        @if(!empty($location))
                                                        @foreach($location as $loc)

                                                        <option @if(isset($data))
                                                            {{  $data->location == $loc->id  ? 'selected' : ''}}
                                                            @endif value="{{ $loc->id}}">{{$loc->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                        
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Supplier Name</label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group">
                                                            <select class="form-control m-b" name="supplier_id" required
                                                                id="supplier_id">
                                                                <option value="">Select Supplier Name</option>
                                                                @if(!empty($supplier))
                                                                @foreach($supplier as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->supplier_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="button"
                                                                    data-toggle="modal" value=""
                                                                    data-target="#appFormModal"  href="appFormModal"><i class="icon-plus-circle2"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Purchase Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="purchase_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->purchase_date : date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="due_date"
                                                            placeholder="0 if does not exist"
                                                           value="{{ isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime("+10 days"))) }}"
                                                            class="form-control">
                                                    </div>
                                                </div>


                                                <br>
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-4">
                                                       @if(!empty($data->exchange_code))

                              <select class="form-control m-b" name="exchange_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled selected>Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)
                            <option  @if(isset($data)) {{$data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif  value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                         @else
                       <select class="form-control m-b" name="exchange_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled >Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)

                           @if($row->code == 'TZS')
                            <option value="{{ $row->code }}" selected>{{ $row->name }}</option>
                           @else
                          <option value="{{ $row->code }}" >{{ $row->name }}</option>
                           @endif

                            @endforeach
                            @endif
                        </select>


                     @endif
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Exchange Rate</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="exchange_rate"
                                                            placeholder="1 if TZSH"
                                                            value="{{ isset($data) ? $data->exchange_rate : '1.00'}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> Add item</i></button><br>
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>Unit</th>
                                                            <th>Tax</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                    <tfoot>
                                                        @if(!empty($id))
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        <tr class="line_items">
                                                            <td><select name="item_name[]"
                                                                    class="form-control m-b item_name" required
                                                                    data-sub_category_id={{$i->order_no}}>
                                                                    <option value="">Select Item Name</option>@foreach($name
                                                                    as $n) <option value="{{ $n->id}}"
                                                                        @if(isset($i))@if($n->id == $i->item_name)
                                                                        selected @endif @endif >{{$n->name}}</option>
                                                                    @endforeach
                                                                </select></td>
                                                            <td><input type="number" name="quantity[]"
                                                                    class="form-control item_quantity{{$i->order_no}}"
                                                                    placeholder="quantity" id="quantity"
                                                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                                                    required /></td>
                                                            <td><input type="text" name="price[]"
                                                                    class="form-control item_price{{$i->order_no}}"
                                                                    placeholder="price" required
                                                                    value="{{ isset($i) ? $i->price : ''}}" /></td>
                                                            <td><input type="text" name="unit[]"
                                                                    class="form-control item_unit{{$i->order_no}}"
                                                                    placeholder="unit" required
                                                                    value="{{ isset($i) ? $i->unit : ''}}" />
                                                            <td><select name="tax_rate[]"
                                                                    class="form-control m-b item_tax'+count{{$i->order_no}}"
                                                                    required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0" @if(isset($i))@if('0'==$i->
                                                                        tax_rate) selected @endif @endif>No tax</option>
                                                                    <option value="0.18" @if(isset($i))@if('0.18'==$i->
                                                                        tax_rate) selected @endif @endif>18%</option>
                                                                </select></td>
                                                            <input type="hidden" name="total_tax[]"
                                                                class="form-control item_total_tax{{$i->order_no}}'"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_tax : ''}}" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                            <input type="hidden" name="saved_items_id[]"
                                                                class="form-control item_saved{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->id : ''}}"
                                                                required />
                                                            <td><input type="text" name="total_cost[]"
                                                                    class="form-control item_total{{$i->order_no}}"
                                                                    placeholder="total" required
                                                                    value="{{ isset($i) ? $i->total_cost : ''}}"
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="{{ isset($i) ? $i->id : ''}}" />
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs rem"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
                                                        </tr>

                                                        @endforeach
                                                        @endif
                                                        @endif

                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold">Sub Total </span>: </td>
                                                            <td><input type="text" name="subtotal[]"
                                                                    class="form-control item_total"
                                                                    placeholder="subtotal" required
                                                                    jAutoCalc="SUM({total_cost})" readonly></td>
                                                        </tr>
                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold">Tax </span>: </td>
                                                            <td><input type="text" name="tax[]"
                                                                    class="form-control item_total" placeholder="tax"
                                                                    required jAutoCalc="SUM({total_tax})" readonly>
                                                            </td>
                                                        </tr>
                                                        @if(!@empty($data->discount > 0))
                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            <td><span class="bold">Discount</span>: </td>
                                                            <td><input type="text" name="discount[]"
                                                                    class="form-control item_discount"
                                                                    placeholder="total" required
                                                                    value="{{ isset($data) ? $data->discount : ''}}"
                                                                    readonly></td>
                                                        </tr>
                                                        @endif

                                                        <tr class="line_items">
                                                            <td colspan="4"></td>
                                                            @if(!@empty($data->discount > 0))
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax} - {discount}"
                                                                    readonly></td>
                                                            @else
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax}" readonly>
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>


                                                <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('restaurant_purchase.index')}}">
                                                            cancel
                                                        </a>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
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

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>



@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
           order: [[2, 'desc']],
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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
$(document).ready(function() {

    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });

    $(document).on('change', '.item_name', function() {
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("bar/purchases/findInvPrice")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                $('.item_price' + sub_category_id).val(data[0]["cost_price"]);
                $(".item_unit" + sub_category_id).val(data[0]["unit"]);
               
            }

        });

    });


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
        html +=
            '<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item</option>@foreach($name as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></td>';
        html +=
            '<td><input type="number" name="quantity[]" class="form-control item_quantity" data-category_id="' +
            count + '"placeholder ="quantity" id ="quantity" required /></td>';
        html += '<td><input type="text" name="price[]" class="form-control item_price' + count +
            '" placeholder ="price" required  value=""/></td>';
        html += '<td><input type="text" name="unit[]" class="form-control item_unit' + count +
            '" placeholder ="unit" required /></td>';
        html += '<td><select name="tax_rate[]" class="form-control m-b item_tax' + count +
            '" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
        html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />';
       
        html += '<td><input type="text" name="total_cost[]" class="form-control item_total' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('tbody').append(html);
        autoCalcSetup();
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
    });



    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });


    $(document).on('click', '.rem', function() {
        var btn_value = $(this).attr("value");
        $(this).closest('tr').remove();
        $('tfoot').append(
            '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
            btn_value + '"/>');
        autoCalcSetup();
    });

});
</script>



<script type="text/javascript">
function model(id, type) {

        let url = '{{ route("restaurant_purchase.show", ":id") }}';
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

@endsection