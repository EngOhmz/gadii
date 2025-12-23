@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profoma Invoice </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Invoice
                                     List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Invoice</a>
                            </li>

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
                                                    style="width: 126.484px;">Ref No</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Client Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Invoice Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Due Amount</th>
                                                
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 168.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($invoices))
                                            @foreach ($invoices as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('courier_profoma_invoice.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                </td>
                                                <td>
                                                      {{$row->client->name }}
                                                </td>
                                                
                                                <td>{{$row->invoice_date}}</td>

                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>
                                              
{{--
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
--}}                                               
                                               
                                                <td>
                                                   <div class="form-inline">
                                                  
                                                    <a class="list-icons-item text-primary"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('courier_profoma_invoice.edit', $row->id)}}"><i
                                                            class="icon-pencil7"></i></a>&nbsp
                                                          

                                                    {!! Form::open(['route' => ['courier_profoma_invoice.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}

                                                     &nbsp

                                                <div class="dropdown">
						<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                      <div class="dropdown-menu">
                                                           <a class="nav-link"  href="{{ route('courier_profoma_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download PDF </a> 
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
                                        <h5>Create Invoice</h5>
                                        @else
                                        <h5>Edit Invoice</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('courier_profoma_invoice.update', $id), 'method' => 'PUT')) }}
                                              
                                                @else
                                                {{ Form::open(['route' => 'courier_profoma_invoice.store']) }}
                                                @method('POST')
                                                @endif


                                                <input type="hidden" name="type"
                                                class="form-control name_list"
                                                value="{{$type}}" />

                                                <div class="form-group row">
                                                 
                                                    <label class="col-lg-2 col-form-label">Client Name</label>
                                                    <div class="col-lg-6">
                                                            <select class="form-control m-b client" name="client_id" required
                                                                id="client_id">
                                                                <option value="">Select Client Name</option>
                                                                @if(!empty($client))
                                                                @foreach($client as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->client_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                          
                                                        </div>
                                                    </div>
                                               

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Invoice Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="invoice_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->invoice_date : date('Y-m-d')}}"
                                                            class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime("+10 days")))}}"
                                                            class="form-control">
                                                    </div>
                                                </div>


                                                <br>
                                                <h4 align="center">Enter Item Details</h4>

                                                
{{--

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
--}}
                                                <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> Add item</i></button><br>
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Type</th>
                                                     <th >Tariff</th>
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
   <td><select id="type{{$i->id}}" name="tariff_type[]" class="form-control m-b type"  data-sub_category_id="{{$i->id}}" required><option ="">Select Type</option> 
<option value="Automatic" @if(isset($i))@if('Automatic' == $i->tariff_type) selected @endif @endif>Automatic</option>
<option value="Formula"  @if(isset($i))@if('Formula' == $i->tariff_type) selected @endif @endif>Formula</option> 
</select>
</td>  
<?php 
   $tariff= App\Models\Tariff::where('client_id',$data->client_id)->where('type',$i->tariff_type)->get();
?>                                     
<td><select name="item_name[]" class="form-control m-b item_name{{$i->id}}" id="name"  data-sub_category_id="{{$i->id}}"required ><option value="">Select Tariff</option>
 @if(!empty($tariff))
 @foreach($tariff as $trow)
<option value="{{$trow->id}}"  @if(isset($i))@if($trow->id == $i->item_name) selected @endif @endif>{{$trow->zonal->name}} - {{$trow->weight}} </option>                                                                        
@endforeach
  @endif
</select></td>
<input type="hidden" name="quantity[]" class="form-control item_quantity{{$i->id}}"  placeholder ="weight" id ="quantity"  value="{{ isset($i) ? $i->quantity : ''}}" required />
<td><input type="text" name="price[]" class="form-control item_price{{$i->id}}" placeholder ="price" required  value="{{ isset($i) ? $i->price : ''}}"/></td>
<td><input type="text" name="unit[]" class="form-control item_unit" placeholder ="unit" required value="{{ isset($i) ? $i->unit : ''}}"/></td>
<td><select name="tax_rate[]" class="form-control m-b item_tax" required ><option value="0">Select Tax Rate</option>
<option value="0" @if(isset($i))@if('0' == $i->tax_rate) selected @endif @endif>No tax</option>
<option value="0.18" @if(isset($i))@if('0.18' == $i->tax_rate) selected @endif @endif>18%</option></select></td>
<input type="hidden" name="total_tax[]" class="form-control item_total_tax" placeholder ="total" required value="{{ isset($i) ? $i->total_tax : ''}}" readonly jAutoCalc="1 * {price} * {tax_rate}"   />
<td><input type="text" name="total_cost[]" class="form-control item_total" placeholder ="total" required value="{{ isset($i) ? $i->total_cost : ''}}" readonly jAutoCalc="1 * {price}" /></td>
<input type="hidden" name="saved_items_id[]"    class="form-control item_saved{{$i->id}}"  value="{{ isset($i) ? $i->id : ''}}" required />
 <td><button type="button" name="remove"  class="btn btn-danger btn-xs rem"  value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
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
                                                            href="{{ route('profoma_invoice.index')}}">
                                                            cancel
                                                        </a>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit" id="save">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
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




@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
       order: [[2, 'desc']],
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
$(document).ready(function() {

    $(document).on('change', '.type', function() {
        var type = $(this).val();
         var id= $('.client').val();
       var sub_category_id = $(this).data('sub_category_id');

        $.ajax({
            url: '{{url("courier/findTariff")}}',
            type: "GET",
            data: {
                id: id,
              type:type,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
               $('.item_name'+ sub_category_id).empty();
               $('.item_name'+ sub_category_id).append('<option value="">Select Tariff</option>');
                $.each(response,function(key, value)
                {


                    $('.item_name'+ sub_category_id).append('<option value=' + value.id+ '>' + value.zone_name + ' -  ' + value.weight + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script>
    $(document).ready(function(){
      

 $(document).on('change', '#name', function(){
        var id = $(this).val();
      var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("courier/findCourierPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
                     $('.item_price'+ sub_category_id).val(data[0]["price"]);
                  $('.item_quantity'+ sub_category_id).val(data[0]["weight"]);
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
      html +='<td><select name="tariff_type[]" class="form-control  m-b type" required  data-sub_category_id="' + count +'"><option value="">Select Type</option><option value="Automatic">Automatic</option><option value="Formula">Formula</option></select></td>';
        html +=  '<td><select name="item_name[]" class="form-control m-b item_name' + count +'"  id="name"  data-sub_category_id="' + count +'" required><option value="">Select Tariff</option></select></td>';
      html +='<input type="hidden" name="quantity[]" class="form-control item_quantity' + count +'" placeholder ="quantity" id ="quantity" required /></td>';
        html += '<td><input type="text" name="price[]" class="form-control item_price' + count +'" placeholder ="price" required  value=""/></td>';
        html += '<td><input type="text" name="unit[]" class="form-control item_unit' + count + '" placeholder ="unit" required /></td>';
        html += '<td><select name="tax_rate[]" class="form-control  m-b item_tax' + count +
            '" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
        html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax' + count +
            '" placeholder ="total" required readonly jAutoCalc="1 * {price} * {tax_rate}"   />';
       html +='<input type="hidden" id="item_id"  class="form-control item_id' +count+'" value="" />';
        html += '<td><input type="text" name="total_cost[]" class="form-control item_total' + count +
            '" placeholder ="total" required readonly jAutoCalc="1 * {price}" /></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

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




@endsection