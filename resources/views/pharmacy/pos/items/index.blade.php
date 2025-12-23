@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Inventory</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Inventory
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Inventory</a>
                            </li>
                        <li class="nav-item">
                                <a class="nav-link  " id="importExel-tab"
                                    data-toggle="tab" href="#importExel" role="tab" aria-controls="profile"
                                    aria-selected="false">Import Items</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                       <table class="table table-bordered" id="itemsDatatable">
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
                                                    style="width: 98.1094px;">Category</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Unit</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
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
                                        <h5>Edit Drugs</h5>
                                        @else
                                        <h5>Add New Drugs</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('pharmacy_items.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'pharmacy_items.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Item Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="name"
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Cost Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="cost_price"
                                                            value="{{ isset($data) ? $data->cost_price : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                    <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Sales Price</label>

                                                    <div class="col-lg-10">
                                                        <input type="number" name="sales_price"
                                                            value="{{ isset($data) ? $data->sales_price : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Unit</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="unit"
                                                            value="{{ isset($data) ? $data->unit : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>

<!--
                                                     <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Category</label>

                                                    <div class="col-lg-10">
                                                        <div class="input-group">
                                                            <select class="form-control m-b" name="category" required
                                                                id="category">
                                                                <option value="">Select Category</option>
                                                                @if(!empty($category))
                                                                @foreach($category as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->category == $row->id  ? 'selected' : ''}}
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

-->

                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Category</label>

                                                    <div class="col-lg-10">
                                                        
                                                            <select class="form-control m-b" name="category" required
                                                                id="category">
                                                                <option value="">Select Category</option>

                                                                <option @if(isset($data))
                                                                    {{  $data->category == 'Batch' ? 'selected' : ''}}
                                                                    @endif value="Batch">Batch</option>
                                                                 <option @if(isset($data))
                                                                    {{  $data->category == 'Serial' ? 'selected' : ''}}
                                                                    @endif value="Serial">Serial</option>
                                                              
                                                            </select>
                                                            
                                                      
                                                    </div>
                                                </div>


                                                  <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Manufacturer</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="manufacturer"
                                                            value="{{ isset($data) ? $data->manufacturer : ''}}"
                                                            class="form-control">
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
                                     <form action="{{ route('item.sample') }}" method="POST" enctype="multipart/form-data">
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
                                                <form action="{{ route('item.import') }}" method="POST" enctype="multipart/form-data">
                                            
                                                    @csrf
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="file" class="form-control" id="customFile" required>
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

<!-- supplier Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form id="addClientForm" method="post" action="javascript:void(0)">
            @csrf
        <div class="modal-body">

            <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

      <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Name</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"  id="name"                                                                
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                   
              </div>
</div>
                                                    </div>


        </div>
       <div class="modal-footer ">
            <button type="submit" class="btn btn-primary" id="save" onclick="saveCategory(this)" data-dismiss="modal"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
           <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


       </form>

         
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
$(function() {
    let urlcontract = "{{ route('pharmacy_items.index') }}";
    $('#itemsDatatable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
          autoWidth: false,
        
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
                data: 'category',
                name: 'category'
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
 var url = '{{ route("pharmacy_items.destroy", ":id") }}';
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

<script>
  $(document).ready(function(){


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
<script type="text/javascript">

function saveCategory(e) {
     
     var name = $('#name').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("pos/pharmacy_purchases/addCategory")}}',
             data: {
                 'name':name,

             },
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#category').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}
</script>
@endsection