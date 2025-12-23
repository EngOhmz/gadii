@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Location</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Location
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Location</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Name</th>
                                                   <!-- <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Store Manager</th> -->
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Store Type</th>
                                               
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($location))
                                            @foreach ($location as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->name }}</td>
                                               <!-- <td>{{$row->manager }}</td> -->
                                                @if($row->type == 1)
                                                <td>Work Centre</td>
                                                @elseif($row->type == 2)
                                                 <td>Finished Product</td>
                                                 @else
                                                 <td>Inventory Store</td>
                                                 @endif
                                                
                                                <td>
                                                 <div class="form-inline">
                                                      <a class="list-icons-item text-primary"
                                                        href="{{ route("manufacturing_location.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>
                                              
                                                    {!! Form::open(['route' => ['manufacturing_location.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                 {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
&nbsp

           <a href="#"  class="list-icons-item text-info" title="View"  data-toggle="modal" data-target="#appFormModal"  data-id="{{ $row->id }}" data-type="template"   onclick="model({{ $row->id }},'location')">
                        View Manager</a>                                                             
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
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(!empty($id))
                                        <h5>Edit Location</h5>
                                        @else
                                        <h5>Add New Location</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('manufacturing_location.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'manufacturing_location.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="name"
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                        <div class="form-group row"><label
                                                class="col-lg-2 col-form-label">Is it the Main Location</label>
                                            <div class="col-lg-10">
                                                <select class="form-control m-b" name="main" required
                                                id="main">
                                                <option value="">Select</option>
                                                <option @if(isset($data))
                                                {{  $data->main == '1' ? 'selected' : ''}}
                                                @endif value="1">Yes</option>
                                                <option @if(isset($data))
                                                {{  $data->main == '0' ? 'selected' : ''}}
                                                @endif value="0">No</option>
                                            </select>
                                            </div>
                                        </div>
                                        
                                        
                                                  <!--   <div class="form-group row"><label class="col-lg-2 col-form-label">Manager Name</label>
                                                   <div class="col-lg-10">
                                                           <input type="text" name="manager"
                                                            value="{{ isset($data) ? $data->manager : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div> -->
                                                
                                              <!--   <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Quantity</label>

                                                <div class="col-lg-10">
                                                    <input type="number" name="quantity"
                                                        value="{{ isset($data) ? $data->quantity : ''}}"
                                                        class="form-control">
                                                </div>
                                            </div> -->
                                            
                                                     <div class="form-group row"><label class="col-lg-2 col-form-label">Type</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control m-b" name="store_type" required>
                                                    <option value="">Select</option>
                                                   <option value="1" {{ isset($data) ? ($data->store_type == 1 ? "selected":'') : ''}}>Work Centre</option>
                                                   <option value="2" {{ isset($data) ? ($data->store_type == 2 ? "selected":'') : ''}}>Finished Products</option>
                                                   <option value="3" {{ isset($data) ? ($data->store_type == 3 ? "selected":'') : ''}}>Inventory Store</option>
                                                   </select>
            
                                                    </div>
                                                </div>
                                                
                                                  <br>
                                                <h4 align="center">Enter Location Manager</h4>
                                                <hr>
                                              
                                                <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                        class="fas fa-plus"> Add item</i></button><br>
                                                <br>
                                                
                                                <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                                                
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>                                                            
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(!empty($id))
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        <tr class="line_items">
                                                            <td>
                                                            <select name="manager[]" id="manager{{$i->order_no}}_edit"
                                                                    class="form-control m-b manager" required
                                                                    data-sub_category_id="{{$i->order_no}}_edit">
                                                                    <option value="">Select Manager</option>@foreach($user
                                                                    as $u) <option value="{{ $u->id}}"
                                                                        @if(isset($i))@if($u->id == $i->manager)
                                                                        selected @endif @endif >{{$u->name}}</option>
                                                                    @endforeach
                                                                </select></td>
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs rem"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
                                                          <input type="hidden" name="saved_items_id[]"
                                                                class="form-control item_saved{{$i->order_no}}_edit"
                                                                value="{{ isset($i) ? $i->id : ''}}"
                                                                required />
                                                            
                                                        </tr>

                                                        @endforeach
                                                        @endif
                                                        @endif

                                                    </tbody>
                                                    
                                                   <tfoot>
                                                   </tfoot>
                                                   
                                                </table>
                                            </div>

                                               <br>
                                               
                                              
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
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
            "columnDefs": [{
                "orderable": false,
                "targets": [1]
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
<script type="text/javascript">
$(document).ready(function() {

    var count = 0;
    
    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +='<td><select name="manager[]" class="form-control m-b manager" id="manager' +count +'" required  data-sub_category_id="' +count +'"><option value="">Select Manager</option>@foreach($user as $u) <option value="{{ $u->id}}">{{$u->name}}</option>@endforeach</select></td>';
        html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#cart > tbody').append(html);

            $('.m-b').select2({
                            });
    });



    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
    });


    $(document).on('click', '.rem', function() {
        var btn_value = $(this).attr("value");
        $(this).closest('tr').remove();
        $('tfoot').append(
            '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
            btn_value + '"/>');
    });

});
</script>

<script>
    $(document).ready(function() {
    
      
         $(document).on('click', '.save', function(event) {
   
         $('.errors').empty();
        
          if ( $('#cart tbody tr').length == 0 ) {
               event.preventDefault(); 
    $('.errors').append('Please Select Location Manager.');
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
     url: '{{url("inventory/invModal")}}',
    data: {
        'id': id,
        'type':type,
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
    </script>
@endsection