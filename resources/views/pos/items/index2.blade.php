@extends('layouts.master')

@push('plugin-styles')


 <style type="text/css" media="print">
    .noPrint{
      display: none;
    }
  </style>

@endpush


@section('content')
    <section class="section" id="nonPrintable">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Items</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                               
                              
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-button-html5-basic" id="itemsDatatable">
                                            <thead>
                                                <tr role="row">

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 28.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Item Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Item Type</th>
                                                   
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Sales Price</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Quantity</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Unit</th>

                                                   
                                                </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (!empty($id))
                                                <h5>Edit Items</h5>
                                            @else
                                                <h5>Add New Items</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['items.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'items.store']) }}
                                                        @method('POST')
                                                    @endif

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Item Type <span class="required"> * </span></label>
                                                        <div class="col-lg-10">
                                                            <select class="form-control m-b type" name="type" required>
                                                                <option value="">Select</option>
                                                                <option value="1"
                                                                    {{ isset($data) ? ($data->type == 1 ? 'selected' : '') : '' }}>
                                                                    Inventory</option>
                                                                <option value="4"
                                                                    {{ isset($data) ? ($data->type == 4 ? 'selected' : '') : '' }}>
                                                                    Service</option>

                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Item Name <span class="required"> * </span></label>
                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"
                                                                value="{{ isset($data) ? $data->name : '' }}"
                                                                class="form-control item" required>

                                                            <div class="">
                                                                <p class="form-control-static" id="errors"
                                                                    style="text-align:center;color:red;"></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                     @if(!empty($data)  && !empty($data->type == '1' ))  
                                                <div class="form-group row" id="product">
                                                     <label class="col-lg-2 col-form-label">Does Product have barcode?</label>
                                                        <div class="col-lg-10" >
                                                          <select class="form-control m-b product" id="product" name="product" id="product_id">
                                                                <option value="">Select</option>
                                                                <option value="Yes" {{ isset($data) ? ($data->barcode != '' ? 'selected' : '') : '' }}>Yes</option>
                                                                 <option value="No" {{ isset($data) ? ($data->barcode == '' ? 'selected' : '') : '' }}>No</option>
                                                               
                                                            </select>

                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    @else
                                                    
                                                    <div class="form-group row" id="product" style=" display: none ">
                                                     <label class="col-lg-2 col-form-label">Does Product have barcode?</label>
                                                        <div class="col-lg-10" >
                                                          <select class="form-control m-b product" id="product" name="product" id="product_id">
                                                                <option value="">Select</option>
                                                                <option value="Yes" {{ isset($data) ? ($data->barcode != '' ? 'selected' : '') : '' }}>Yes</option>
                                                                 <option value="No" {{ isset($data) ? ($data->barcode == '' ? 'selected' : '') : '' }}>No</option>
                                                               
                                                            </select>

                                                        </div>
                                                    </div>
                                                    
                                                    @endif
                                                    
                                                    
                                                    @if(!empty($data)  && !empty($data->barcode_type != '' ))
                                                    
                                                <div class="form-group row" id="symbol"><label
                                                            class="col-lg-2 col-form-label">Barcode Symbology </label>
                                                        <div class="col-lg-10">
                                                            <select class="form-control m-b barcode_type" name="barcode_type" id="barcode_type">
                                                        <option value="">Select</option>
                                                        <option value="UPCA" {{ isset($data) ? ($data->barcode_type == 'UPCA' ? 'selected' : '') : '' }}>Bar Code</option>
                                                        <option value="QRCODE" {{ isset($data) ? ($data->barcode_type == 'QRCODE' ? 'selected' : '') : '' }}>QRCODE </option>
                                                         
                                                            </select>

                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    @else
                                                    
                                                     <div class="form-group row" id="symbol" style=" display: none"><label
                                                            class="col-lg-2 col-form-label">Barcode Symbology </label>
                                                        <div class="col-lg-10">
                                                            <select class="form-control m-b barcode_type" name="barcode_type" id="barcode_type">
                                                        <option value="">Select</option>
                                                        <option value="UPCA" {{ isset($data) ? ($data->barcode_type == 'UPCA' ? 'selected' : '') : '' }}>Bar Code</option>
                                                        <option value="QRCODE" {{ isset($data) ? ($data->barcode_type == 'QRCODE' ? 'selected' : '') : '' }}>QRCODE </option>
                                                         
                                                            </select>

                                                        </div>
                                                    </div>
                                                    
                                                    @endif
                                                    
                                                    
                                                    
                                                     @if(!empty($data)  && !empty($data->barcode != '' ))  
                                               <div class="form-group row" id="bar">
                                                     <label class="col-lg-2 col-form-label">Bar Code</label>
                                                        <div class="col-lg-10">
                                                         <div class="input-group mb-3">
                                                            <input type="text" name="barcode" id="barcode"
                                                                value="{{ isset($data) ? $data->barcode : '' }}"
                                                                class="form-control barcode">
                                                                
                                                                
                                                                &nbsp

                                                                <button class="btn btn-outline-secondary scan" type="button"><i class="icon-barcode2"> </i> Scan</button>

                                                            </div>
                                                            <div class="">
                                                                <p class="form-control-static" id="bar_errors"
                                                                    style="text-align:center;color:red;"></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    
                                                    
                                                    @else
                                                    
                                                   <div class="form-group row" id="bar" style=" display:none ">
                                                     <label class="col-lg-2 col-form-label">Bar Code</label>
                                                        <div class="col-lg-10">
                                                         <div class="input-group mb-3">
                                                            <input type="text" name="barcode" id="barcode"
                                                                value="{{ isset($data) ? $data->barcode : '' }}"
                                                                class="form-control barcode">
                                                                
                                                                
                                                                &nbsp

                                                                <button class="btn btn-outline-secondary scan" type="button"><i class="icon-barcode2"> </i> Scan</button>

                                                            </div>
                                                            <div class="">
                                                                <p class="form-control-static" id="bar_errors"
                                                                    style="text-align:center;color:red;"></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                    
                                                    @endif
                                                    
                                                     
                                                    
                                                    

                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                            Cost Price <span class="required"> * </span></label>

                                                        <div class="col-lg-10">
                                                            <input type="number" name="cost_price" id="cost_price"
                                                                value="{{ isset($data) ? $data->cost_price : '' }}"
                                                                class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                            Sales Price <span class="required"> * </span></label>

                                                        <div class="col-lg-10">
                                                            <input type="number" name="sales_price" id="sales_price"
                                                                value="{{ isset($data) ? $data->sales_price : '' }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Category</label>
                                                        <div class="col-lg-10">
                                                            <select class="form-control m-b" name="category_id"
                                                                id="location" >
                                                                <option value="">Select Category</option>
                                                                @if (!empty($category))
                                                                    @foreach ($category as $loc)
                                                                        <option
                                                                            @if (isset($data)) {{ $data->category_id == $loc->id ? 'selected' : '' }} @endif
                                                                            value="{{ $loc->id }}">
                                                                            {{ $loc->name }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>

                                                        </div>
                                                    </div>
                                                        <div class="form-group row"><label
                                                                class="col-lg-2 col-form-label"> Tax Rate <span class="required"> * </span></label>

                                                            <div class="col-lg-10">
                                                                <select name="tax_rate" class="form-control m-b item_tax"
                                                                    required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0"
                                                                        @if (isset($data)) @if ('0' == $data->tax_rate) selected @endif
                                                                        @endif>No tax</option>
                                                                    <option value="0.18"
                                                                        @if (isset($data)) @if ('0.18' == $data->tax_rate) selected @endif
                                                                        @endif>18%</option>
                                                                </select>
                                                            </div>
                                                        </div>



                                                        <div class="form-group row"><label
                                                                class="col-lg-2 col-form-label">Unit</label>

                                                            <div class="col-lg-10">
                                                                <input type="text" name="unit"
                                                                    value="{{ isset($data) ? $data->unit : '' }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-form-label col-lg-2">Desription</label>
                                                            <div class="col-lg-10">
                                                                <textarea name="description" class="form-control">{{ isset($data) ? $data->description : '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        

                                                        <div class="form-group row">
                                                            <div class="col-lg-offset-2 col-lg-12">
                                                                @if (!@empty($id))
                                                                    <button
                                                                        class="btn btn-sm btn-primary float-right save"
                                                                        
                                                                        type="submit" id="save">Update</button>
                                                                @else
                                                                    <button
                                                                        class="btn btn-sm btn-primary float-right save"
                                                                        type="submit" id="save" disabled>Save</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="importExel" role="tabpanel"
                                        aria-labelledby="importExel-tab">

                                        <div class="card">
                                            <div class="card-header">
                                                <form action="{{ route('item.sample') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <button class="btn btn-success">Download Sample</button>
                                                </form>

                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 ">
                                                        <div class="container mt-5 text-center">
                                                            <h4 class="mb-4">
                                                                Import Excel & CSV File
                                                            </h4>
                                                            <form action="{{ route('item.import') }}" method="POST"
                                                                enctype="multipart/form-data">

                                                                @csrf
                                                                <div class="form-group mb-4">
                                                                    <div class="custom-file text-left">
                                                                        <input type="file" name="file"
                                                                            class="form-control" id="customFile" required>
                                                                    </div>
                                                                </div>
                                                                <button class="btn btn-primary">Import Items</button>

                                                            </form>

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
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

    <script src="{{ asset('assets/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.print.min.js') }}"></script>
    
    
    
</script>
    
    
    

    <script>
        $(function() {
            let urlcontract = "{{ route('items.index') }}";
            
           
            
            $('#itemsDatatable').DataTable({
                processing: true,
                serverSide: false,
                searching: true,
                "dom": 'lBfrtip',

                buttons: [{
                        extend: 'copyHtml5',
                        title: 'ITEM LIST ',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                      
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'ITEM LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                       
                        footer: true
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'ITEM LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'ITEM LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)',
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        title: 'ITEM LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    }

                ],

                type: 'GET',
                ajax: {
                    url: urlcontract,
                    data: function(d) {
                        d.start_date = $('#date1').val();
                        d.end_date = $('#date2').val();
                        d.from = $('#from').val();
                        d.to = $('#to').val();
                        d.status = $('#status').val();

                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                   
                    {
                        data: 'sales_price',
                        name: 'sales_price'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },

                    {
                        data: 'unit',
                        name: 'unit',
                        orderable: false,
                        searchable: true
                    },

                  


                ]
            })
        });

        function deleteItem(id) {
            var url = '{{ route('items.destroy', ':id') }}';
            url = url.replace(':id', id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Swal.fire({
                title: "Delete",
                text: "Do you really want to delete!",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                confirmButtonColor: "#3085d6",
                cancelButtonText: "No, cancel!",
                cancelButtonColor: "#aaa",

                reverseButtons: !0,

            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "delete",
                        success: function(data) {
                            $('#itemsDatatable').DataTable().ajax.reload();
                            Swal.fire({
                                title: "Deleted",
                                text: "Your data has been deleted",
                                confirmButtonColor: "#3085d6",
                            })
                        }
                    })
                }
            })
        }
    </script>



 <script type="text/javascript">
       $(document).ready(function(e) {

/* For Export Buttons available inside jquery-datatable "server side processing" - Start
- due to "server side processing" jquery datatble doesn't support all data to be exported
- below function makes the datatable to export all records when "server side processing" is on */

function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    
                    
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
    // Requery the server with the new one-time export settings
    dt.ajax.reload();
};
//For Export Buttons available inside jquery-datatable "server side processing" - End            
 
        });
    </script>
    
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
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

            var msg = 'The Item already exists. Please Create another one.';

            $(document).on('change', '.item', function() {
                var id = $(this).val();
                $.ajax({
                    url: '{{ url('pos/purchases/findItem') }}',
                    type: "GET",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $("#errors").empty();
                        //$("#save").attr("disabled", false);
                        if (data != '') {
                            $("#errors").append(msg);
                            $("#save").attr("disabled", true);
                        } else {

                        }


                    }

                });

            });

        });
    </script>
    
    
     <script>
        $(document).ready(function() {

            var msg = 'The Bar Code already exists.';

            $(document).on('change', '.barcode', function(event) {
                var id = $(this).val();
                $.ajax({
                    url: '{{ url('pos/purchases/findCode') }}',
                    type: "GET",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $("#bar_errors").empty();
                        //$("#save").attr("disabled", false);
                        if (data != '') {
                            $("#bar_errors").append(msg);
                            $("#save").attr("disabled", true);
                            event.preventDefault(); 
                        } else {
                            event.preventDefault(); 
                        }


                    }

                });

            });

        });
    </script>
    
    
     <script>
$(document).ready(function() {

    $(document).on('change', '.type', function() {
        var id = $(this).val();
  console.log(id);


 if (id == '1'){
      $("#product").show();
      $("#product_id").prop('required',true);

}



else{
    $("#product").hide();    
    $("#symbol").hide(); 
    $("#bar").hide();
    $("#product_id").prop('required',false);
       
}


     

    });



});

</script>


     <script>
$(document).ready(function() {

    $(document).on('change', '.product', function() {
        var id = $(this).val();
  console.log(id);


 if (id == 'Yes'){
      $("#symbol").show();
      $("#bar").show();
        $("#symbol > label").text('Barcode Symbology');
       $("#barcode_type").prop('required',true);
      $("#barcode").prop('required',true);


}



else{
     $("#symbol").show();
      $("#bar").hide();
      $("#symbol > label").text('Generate Barcode');
       $("#barcode_type").prop('required',false);
      $("#barcode").prop('required',false);
       
}


     

    });



});

</script>
    
    
     <script type="text/javascript">
       $(document).ready(function(e) {

            $(document).on('click', '.scan', function(e) {
               
    $('#barcode').val('');  // Input field should be empty on page load
    $('#barcode').focus();  // Input field should be focused on page load 
e.preventDefault(); 
            });
            
        
 
        });
    </script>
    
    
    
    <script type="text/javascript">
      $(document).on("change", function (event) {
         
         var a=$('.type').val();
         var b=$('.item_name').val();
         var c=$('.item_tax').val();
         var d=$('#cost_price').val();
         var e=$('#sales_price').val();
         console.log(c);
        
         if(a == '' || b == '' || c == '' || d == '' || e == '' ){
               $("#save").attr("disabled", true);
              event.preventDefault(); 
         }
         
         else{
            
           $("#save").attr("disabled", false);
          
         }
        
    });      
            

    </script>
    
    
   
    
    

    <script type="text/javascript">
        function model(id) {

            let url = '{{ route('items.show', ':id') }}';
            url = url.replace(':id', id);
            
             
             var type=$('a[data-id="'+id+'"]').attr('data-type');;

            console.log(type);

            $.ajax({
                type: 'GET',
                url: url,
                 data: {'type': type,},

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
        
        
      function model2(id) {

            let url = '{{ route('items.show', ':id') }}';
            url = url.replace(':id', id);
            
             
             var type=$('a[data-id2="'+id+'"]').attr('data-type');;

            console.log(type);

            $.ajax({
                type: 'GET',
                url: url,
                 data: {'type': type,},

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
