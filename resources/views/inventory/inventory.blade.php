@extends('layouts.master')



@section('content')
    <section class="section" id="nonPrintable">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Inventory</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Inventory
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Inventory</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link  " id="importExel-tab" data-toggle="tab" href="#importExel"
                                        role="tab" aria-controls="profile" aria-selected="false">Import Inventory</a>
                                </li>
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
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Price</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Quantity</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Unit</th>

                                                    <th class="always-visible" class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Action</th>
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
                                                <h5>Edit Inventory</h5>
                                            @else
                                                <h5>Add New Inventory</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['inventory.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'inventory.store']) }}
                                                        @method('POST')
                                                    @endif

                                                   

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
                                                    
                                                    
                                                    


                                                    <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                            Price <span class="required"> * </span></label>

                                                        <div class="col-lg-10">
                                                            <input type="number" name="price" id="cost_price"
                                                                value="{{ isset($data) ? $data->price : '' }}"
                                                                class="form-control" required >
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


                                    <div class="tab-pane fade" id="importExel" role="tabpanel"
                                        aria-labelledby="importExel-tab">

                                        <div class="card">
                                            <div class="card-header">
                                                <form action="{{ route('inventory.sample') }}" method="POST"
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
                                                            <form action="{{ route('inventory.import') }}" method="POST"
                                                                enctype="multipart/form-data">

                                                                @csrf
                                                                <div class="form-group mb-4">
                                                                    <div class="custom-file text-left">
                                                                        <input type="file" name="file"
                                                                            class="form-control" id="customFile" required>
                                                                    </div>
                                                                </div>
                                                                <button class="btn btn-primary">Import Inventory</button>

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
            let urlcontract = "{{ route('inventory.index') }}";
            
        
            
            $('#itemsDatatable').DataTable({
                processing: true,
                serverSide: false,
                searching: true,
                "dom": 'lBfrtip',

                buttons: [{
                        extend: 'copyHtml5',
                        title: 'Inventory LIST ',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                      
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Inventory LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                       
                        footer: true
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Inventory LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Inventory LIST',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)',
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        title: 'Inventory LIST',
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
                        data: 'price',
                        name: 'price'
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

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },


                ]
            })
        });

        function deleteItem(id) {
            var url = '{{ route('inventory.destroy', ':id') }}';
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

            var msg = 'The Inventory already exists. Please Create another one.';

            $(document).on('change', '.item', function() {
                var id = $(this).val();
                $.ajax({
                    url: '{{ url('inventory/findItem') }}',
                    type: "GET",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $("#errors").empty();
                        $("#save").attr("disabled", false);
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
    
    
    


    
    
    
  
    
   
    
    

    <script type="text/javascript">
        function model(id) {

            let url = '{{ route('inventory.show', ':id') }}';
            url = url.replace(':id', id);

            $.ajax({
                type: 'GET',
                url: url,

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
        
        
      
        
    </script>
@endsection
