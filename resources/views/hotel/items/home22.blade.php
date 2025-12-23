@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Property Management </h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Property
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Property</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
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
                                                        style="width: 186.484px;">Property Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 136.484px;">Property Type</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Property Address</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Property Phone Number</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 168.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($hotels))
                                                    @foreach ($hotels as $row)
                                                        @php
                                                         
                                                                
                                                            $hotelType = App\Models\Hotel\HouseType::find($row->type);    
                                                        @endphp

                                                        <tr class="gradeA even" role="row">

                                                            <td>
                                                                <a class="nav-link" id="profile-tab2"
                                                                    href="#"
                                                                    role="tab"
                                                                    aria-selected="false">{{ $row->reference_no }}</a>
                                                            </td>
                                                            <td>
                                                                {{ $row->name }}
                                                            </td>

                                                            <td>@if(!empty($hotelType)) {{ $hotelType->name }} @endif</td>

                                                            <td>{{ $row->address }}</td>
                                                            <td> {{ $row->phone1 }}</td>
                                                            <td>
                                                                <div class="form-inline">
                                                                
                                                                            <a class="list-icons-item text-primary"
                                                                                title="Edit"
                                                                                onclick="return confirm('Are you sure?')"
                                                                                href="{{ route('hotel.edit', $row->id) }}"><i
                                                                                    class="icon-pencil7"></i></a>&nbsp
                                                                       
                                                                    &nbsp

                                                                </div>
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (empty($id))
                                                <h5>Create Property</h5>
                                            @else
                                                <h5>Edit Property</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                {{ Form::model($id, array('route' => array('hotel.update', $id), 'method' => 'PUT',"enctype"=>"multipart/form-data", 'id' => 'invform')) }}
                                                        
                                                    @else
                                                        {!! Form::open(array('route' => 'hotel.store',"enctype"=>"multipart/form-data", 'id' => 'invform')) !!}
                                                        @method('POST')
                                                    @endif

                                                    <div class="form-group row">
                                                    
                                                    <label class="col-lg-2 col-form-label">Property Name <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="name"
                                                                placeholder="i.e EMASUITE HOTEL"
                                                                value="{{ isset($data) ? $data->name : '' }}"
                                                                class="form-control" required>
                                                        </div>

                                                        <label class="col-lg-2 col-form-label">Property Type <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                           
                                                                <select class="form-control m-b" name="type"  required>
                                                                    <option value="">Select Property Type</option>
                                                                    @if (!empty($items))
                                                                        @foreach ($items as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->type == $row->id ? 'selected' : '' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </div>
                                                       
                                                   

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Property Address/Location <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="address"
                                                                placeholder="i.e Tanzania, Dar es Salaam, Kinondoni, Kijitonyama"
                                                                value="{{ isset($data) ? $data->address : '' }}"
                                                                class="form-control">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Property Google Location </label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="google_location"
                                                                placeholder="google location if any"
                                                                value="{{ isset($data) ? $data->google_location : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Property Phone Number 1 <span class="required"> * </span></label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="phone1"
                                                                placeholder="Property Phone Number for any enquires "
                                                                value="{{ isset($data) ? $data->phone1 : '' }}"
                                                                class="form-control">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Property Phone Number 2 </label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="phone2"
                                                                placeholder="Phone Number 2 if any"
                                                                value="{{ isset($data) ? $data->phone2 : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="form-group row">
                                                        <label class="col-form-label col-lg-2">Property Email if any</label>
                                                            <div class="col-lg-4">
                                                               <input type="text" name="email"
                                                                placeholder="i.e ujuzinet@gmail.com"
                                                                value="{{ isset($data) ? $data->email : '' }}"
                                                                class="form-control">
                                                            </div>
                                                        <label class="col-lg-2 col-form-label">Property official website Link </label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="website_link"
                                                                placeholder="i.e https://ema.co.tz"
                                                                value="{{ isset($data) ? $data->website_link : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>  
                                                    
                                                  
                                                    
                                                    <div class="form-group row">
                                                            <label class="col-form-label col-lg-2">Property Desription if any</label>
                                                            <div class="col-lg-10">
                                                                <textarea name="description" class="form-control" placeholder="Property Description if any">{{ isset($data) ? $data->description : '' }}</textarea>
                                                            </div>
                                                            </div>
                                                            
                                                             <div class="form-group row">
                                                             <label class="col-lg-2 col-form-label">Property Service/Offers </label>
                                                        <div class="col-lg-10">
                                                         <textarea name="offers" class="form-control"   placeholder="Property Services if any">{{ isset($data) ? $data->offers : '' }}</textarea>
                                                           
                                                        </div>
                                                            
                                                        </div>

                                                    

                                                    
                                                    <hr>
                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add
                                                            Property Rooms</i></button><br>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Name <span class="required"> * </span></th>
                                                                    <th>Type <span class="required"> * </span></th>
                                                                    <th>Price per night<span class="required"> * </span></th>
                                                                    <th>Toilet Service </th>
                                                                    <th>Other Services </th>
                                                                    <th>Description </th>
                                                                    <th>Action </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                            </tbody>
                                                            <tfoot>
                                                                @if (!empty($id))
                                                                    @if (!empty($hotel_items))
                                                                        @foreach ($hotel_items as $i)
                                                                            <tr class="line_items">
                                                                            
                                                                                <td><input type="text" name="room_name[]"
                                                                                        class="form-control item_price1{{ $i->id }}_edit"
                                                                                        placeholder="room_name" required
                                                                                        value="{{ isset($i) ? $i->name : '' }}" />
                                                                                </td>
                                                                                
                                                                                <td>
                                                                    <select class="form-control m-b item_price2{{ $i->id }}_edit" name="room_type[]"  required>
                                                                    <option value="">Select Type</option>
                                                                    @if (!empty($room))
                                                                        @foreach ($room as $row)
                                                                    <option @if (isset($i)) {{ $i->room_type == $row->id ? 'selected' : '' }} @endif value="{{ $row->id }}">{{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>
                                                                                
                                                                                
                                                                                </td>
                                                                                
                                                                                <td><input type="number" name="price[]" step="any"
                                                                                        class="form-control item_price3{{ $i->id }}_edit"
                                                                                        placeholder="price" required
                                                                                        value="{{ isset($i) ? $i->price : '' }}" />
                                                                                </td>
                                                                                
                                                                                <td><input type="text" name="toilet[]"
                                                                                        class="form-control item_price4{{ $i->id }}_edit"
                                                                                        placeholder="i.e self conatined toilet or not" 
                                                                                        value="{{ isset($i) ? $i->toilet : '' }}" />
                                                                                </td>
                                                                                
                                                                                <td><textarea name="service[]" class="form-control item_price5{{ $i->id }}_edit"
                                                                                        placeholder="i.e free wifi , tv if any"  required  cols="30" >{{ isset($i) ? $i->service : '' }}</textarea>
                                                                                
                                                                                </td>
                                                                                <td>
                                                                                
                                                                                <textarea name="description[]" class="form-control item_price6{{ $i->id }}_edit" placeholder="Description" cols="30">{{ isset($i) ? $i->description : '' }}</textarea>
                                                                                </td>
                                                                                <input type="hidden" name="saved_items_id[]"
                                                                                class="form-control item_saved{{$i->order_no}}_edit"
                                                                                value="{{ isset($i) ? $i->id : ''}}"
                                                                                required />
                                                                                <td><button type="button" name="remove"
                                                                                        class="btn btn-danger btn-xs rem"
                                                                                        value="{{ isset($i) ? $i->id : '' }}"><i
                                                                                            class="icon-trash"></i></button>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                @endif

                                                            
                                                            </tfoot>
                                                        </table>
                                                    </div>


                                                    <br>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))

                                                                <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                    href="{{ route('hotel.index') }}">
                                                                    Cancel
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
    <script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>



    
    

    <script>
        $(document).ready(function() {

            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
            });

  


        });
    </script>

   


    <script type="text/javascript">
        $(document).ready(function() {


            var count = 0;


            $('.add').on("click", function(e) {

                count++;
                var html = '';
                html += '<tr class="line_items">';
                
                html += '<td><input type="text" name="room_name[]" class="form-control item_price1' + count +
                    '" placeholder ="room_name" required  value=""/></td>';
                    
            html += '<td><select class="form-control m-b item_price2' + count +'" name="room_type[]"  required><option value="">Select Type</option>@if (!empty($room))@foreach ($room as $row)<option value="{{ $row->id }}">{{ $row->name }}</option>@endforeach @endif</select></td>';
                    
                html += '<td><input type="number" name="price[]" step="any" class="form-control item_price3' + count +
                    '" placeholder ="price" required  value=""/></td>';
                    
                
                html += '<td><input type="text" name="toilet[]" class="form-control item_price4' + count +
                    '" placeholder ="i.e self conatined toilet or no" required  value=""/></td>';
                    
                html += '<td><textarea name="service[]" class="form-control item_price5' + count +
                    '" placeholder ="i.e free wifi , tv if any" required  cols="30" ></textarea></td>';
                    
                html += '<td><textarea name="description[]"  class="form-control item_price6' + count + '" placeholder="Description"  cols="30" ></textarea></td>';    
                
                html +=
                    '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

                $('#cart > tbody').append(html);

                 $('.m-b').select2({});




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


 <script>
        $(document).ready(function() {

            $(document).on('click', '.scan', function() {
                var type = 'scan';
                var id = $(this).data('sub_category_id');
                console.log(id);
                $.ajax({
                    type: 'GET',
                      url: '{{ url('pos/sales/invModal') }}',
                    data: {
                        'id': id,
                        'type': type,
                    },
                    cache: false,
                    async: true,
                    success: function(data) {
                        //alert(data);
                        $('#appFormModal').find('.modal-dialog').html(data);
                    },
                    error: function(error) {
                        $('#appFormModal').modal('toggle');

                    }


                });


            });

            $(document).on('click', '.check_item', function(e) {
                e.preventDefault();
                var sub = $("#select_id").val();
                console.log(sub);
                
                $.ajax({
                    data: $('.addScanForm').serialize(), 
                    type: 'GET',
                    url: '{{ url('pos/sales/check_item') }}',
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        var id = response.id;
                        var name = response.name;
                        var price = response.sales_price;
                        var unit = response.unit;
                        var tax = response.tax_rate;

                        var option = "<option value='" + id + "'  selected>" + name +
                            " </option>";
                        $('select[data-sub_category_id="' + sub + '"]').append(option);
                        $('.item_price' + sub).val(price);
                        $(".item_unit" + sub).val(unit);
                        $(".item_tax" + sub).val(tax);
                        $('#appFormModal').hide();

                    }
                })
            });


        });
    </script>



    <script type="text/javascript">
        function model(id, type) {


            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/invModal') }}',
                data: {
                    'id': id,
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
    
        function attach_model(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/sales/attachModal') }}',
                data: {
                    'id': id,
                    'type': type,
                },
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);
                    $('.table-img').html(data);
                     $('#invoice_id').val(id);
              
                    
                },
                error: function(error) {
                    $('#attachFormModal').modal('toggle');

                }
            });

        }

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
