@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Items</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Items
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Items</a>
                            </li>
                            
                             <li class="nav-item">
                                    <a class="nav-link  " id="importExel-tab" data-toggle="tab" href="#importExel"
                                        role="tab" aria-controls="profile" aria-selected="false">Import Items</a>
                                </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
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
                                                    style="width: 141.219px;">Cost Price</th>
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
                                               
                                                <th class="always-visible" class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(!empty($id))
                                        <h5>Edit Items</h5>
                                        @else
                                        <h5>Add New Items</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('items2.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'items2.store']) }}
                                                @method('POST')
                                                @endif
                                                
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Item Type</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control m-b related_class" name="type" required>
                                                <option value="">Select</option>
                                                    
                                                    <option value="2" {{ isset($data) ? ($data->type == 2 ? "selected":'') : ''}}>Manufacture(Finished Goods)</option>
                                                        <option value="3" {{ isset($data) ? ($data->type == 3 ? "selected":'') : ''}}>Raw Material</option>
                                                        <option value="5" {{ isset($data) ? ($data->type == 5 ? "selected":'') : ''}}>Semi Finished Goods</option>
                                        
                                                   </select>
                                                          
                                                    </div>
                                                </div>
                                                
                                                
                                              <!--  <option value="1" {{ isset($data) ? ($data->type == 1 ? "selected":'') : ''}}>Inventory</option> -->
                                                
                                                
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Item Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="name"
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                
                                                <div id="projectDiv" style="display:none">
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Cost Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="cost_price" step="any"
                                                            value="{{ isset($data) ? $data->cost_price : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                </div>
                                                
                                                <div id="leadsDiv" style="display:none">
                                                
                                                
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Package</label>

                                                    <div class="col-lg-10">
                                                        <select name="package" class="form-control m-b" required>
                                                                    <option >Select Package</option>
                                                                    @foreach($package as $n) 
                                                                     <option @if(isset($data)) {{  $data->package == $n->name  ? 'selected' : ''}} @endif value="{{ $n->name}}" >{{$n->name}}</option>
                                                                    @endforeach
                                                                    
                                                                    
                                                                  
                                                                </select>
                                                    </div>
                                                </div>
                                                
                                                <!--  <option value="200ml bottles" @if(isset($data))@if('200ml bottles'==$data->package) selected @endif @endif> 200ml bottles</option>
                                                                    <option value="400ml bottles" @if(isset($data))@if('400ml bottles'==$data->package) selected @endif @endif> 400ml bottles</option>
                                                                    <option value="600ml bottles" @if(isset($data))@if('600ml bottles'==$data->package) selected @endif @endif> 600ml bottles</option>
                                                                    <option value="1200ml bottles" @if(isset($data))@if('1200ml bottles'==$data->package) selected @endif @endif> 1200ml bottles</option>
                                                                    <option value="1250ml bottles" @if(isset($data))@if('1250ml bottles'==$data->package) selected @endif @endif> 1250ml bottles</option>
                                                                    <option value="1700ml bottles" @if(isset($data))@if('1700ml bottles'==$data->package) selected @endif @endif> 1700ml bottles</option>
                                                                    <option value="6000ml bottles" @if(isset($data))@if('6000ml bottles'==$data->package) selected @endif @endif> 6000ml bottles</option>
                                                                    <option value="12,000ml bottles" @if(isset($data))@if('12,000ml bottles'==$data->package) selected @endif @endif> 12,000ml bottles</option>
                                                                    <option value="18,900ml bottles Returnable" @if(isset($data))@if('18,900ml bottles Returnable'==$data->package) selected @endif @endif> 18,900ml bottles Returnable </option>
                                                                    <option value="18,900ml bottles Non-Returnable" @if(isset($data))@if('18,900ml bottles Non-Returnable'==$data->package) selected @endif @endif> 18,900ml bottles Non-Returnable</option>
                                                                    
                                                                    -->
                                                
                                                
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Produced Volume (in Litre)</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="vol_produced" step="any" 
                                                            value="{{ isset($data) ? $data->vol_produced : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                
                                    <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Sales Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="sales_price" step="any"
                                                            value="{{ isset($data) ? $data->sales_price : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                </div>

                                           <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Tax Rate</label>

                                                    <div class="col-lg-10">
                                                        <select name="tax_rate" class="form-control m-b item_tax" required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0" @if(isset($data))@if('0'==$data->tax_rate) selected @endif @endif>No tax</option>
                                                                    <option value="0.18" @if(isset($data))@if('0.18'==$data->tax_rate) selected @endif @endif>18%</option>
                                                                </select>
                                                    </div>
                                                </div>

                                             
                                                
                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Unit</label>

                                                    <div class="col-lg-5">
                                                        <input type="text" name="unit"
                                                            value="{{ isset($data) ? $data->unit : ''}}"
                                                            class="form-control">
                                                    </div>
                                                    
                                                    <div class="col-lg-2">
                                                     <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model2('unit_modal')" value="" data-target="#app3FormModal"><i class="icon-plus-circle2"></i></button>
                                                  </div>
                                                  </div>
                                                </div>

                                                   <div class="form-group row">
                                        <label class="col-form-label col-lg-2">Desription</label>
                                        <div class="col-lg-10">
                                            <textarea name="description"
                                                class="form-control">{{isset($data)? $data->description : ''}}</textarea>
                                        </div>
                                    </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
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
                            
                            
                            <div class="tab-pane fade" id="importExel" role="tabpanel"
                                        aria-labelledby="importExel-tab">

                                        <div class="card">
                                            <div class="card-header">
                                                <form action="{{ route('item2.sample') }}" method="POST"
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
                                                            <form action="{{ route('item2.import') }}" method="POST"
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

<!-- discount Modal -->
<div class="modal fade" id="app3FormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>




@endsection

@section('scripts')

<link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">
<script src="{{asset('assets/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.print.min.js')}}"></script>

<script>
$(function() {
    let urlcontract = "{{ route('items2.index') }}";
    $('#itemsDatatable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
       "dom": 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'ITEM LIST ', exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
           {extend: 'excelHtml5',title: 'ITEM LIST' , exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
           {extend: 'csvHtml5',title: 'ITEM LIST' , exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
            {extend: 'pdfHtml5',title: 'ITEM LIST', exportOptions:{ columns: ':visible :not(.always-visible)', },footer: true},
            {extend: 'print',title: 'ITEM LIST' , exportOptions:{columns: ':visible :not(.always-visible)'},footer: true}

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
        columns: [
            {
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
                data: 'cost_price',
                name: 'cost_price'
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
 var url = '{{ route("items2.destroy", ":id") }}';
        url = url.replace(':id', id);
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
      Swal.fire({
          title             : "Delete",
          text              : "Do you really want to delete!",
          showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
           confirmButtonColor: "#3085d6",
            cancelButtonText: "No, cancel!",
            cancelButtonColor : "#aaa",
       
            reverseButtons: !0,
       
      }).then((result) => {
          if (result.value) {
              $.ajax({
                  url    : url,
                  type   : "delete",
                  success: function(data) {
                    $('#itemsDatatable').DataTable().ajax.reload();
             Swal.fire({
          title             : "Deleted",
          text              : "Your data has been deleted",
          confirmButtonColor: "#3085d6",
      })
                  }
              })
          }
      })
          } 
</script>


<script type="text/javascript">
$(document).ready(function() {

    $(document).on('change', '.related_class', function() {


        var id = $(this).val();

        if (id == '3') {
            $('#projectDiv').show();
            $('#leadsDiv').hide();
        } else if (id == '2') {
            $('#projectDiv').hide();
            $('#leadsDiv').show();
        }


    });
});
</script>




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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>



<script type="text/javascript">
    function model(id) {

        let url = '{{ route("items2.show", ":id") }}';
        url = url.replace(':id', id)

        $.ajax({
            type: 'GET',
            url: url,

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
    
    <script type="text/javascript">
        function model2(type) {
        $.ajax({
        type: 'GET',
         url: '{{url("manufacturing/unitModal")}}',
        data: {
            'type':type,
        },
        cache: false,
        async: true,
        success: function(data) {
            //alert(data);
            $('#app3FormModal > .modal-dialog').html(data);
        },
        error: function(error) {
            $('#app3FormModal').modal('toggle');
        }
    });
    
    }
    </script>
    
@endsection