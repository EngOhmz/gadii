@extends('layouts.master')
@section('title')  Menu Item List @endsection
@section('content')

            <section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>  Menu Item List</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true"> Menu Item List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New  Menu Item </a>
                            </li>

                        </ul>
                        <br>
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
                                                                    style="width: 28.484px;">#</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="Platform(s): activate to sort column ascending"
                                                                    style="width: 156.484px;">Menu Name</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="Platform(s): activate to sort column ascending"
                                                                    style="width: 156.484px;">Price</th>
                                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="Platform(s): activate to sort column ascending"
                                                                    style="width: 108.484px;">Status</th>
                                                                    
                                                                <th class=" sorting text-center" tabindex="0" aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="CSS grade: activate to sort column ascending"
                                                                    style="width: 120.1094px;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(!@empty($index))
                                                            @foreach ($index as $row)
                                                            <tr class="gradeA even" role="row">
                
                                                                <td>
                                                                    {{ $loop->iteration }}
                                                                </td>
                     <td><a  title="View" data-toggle="modal"   href="" onclick="model({{ $row->id }},'show')" value="{{ $row->id}}" data-target="#appFormModal" >{{$row->name}}</a></td>
                                                                <td>{{number_format($row->price,2)}}</td>

                                                               
                                                                <td>
                                                                    @if($row->status == 0)
                                                                    <div class="badge badge-danger badge-shadow">Unavailable</div>
                                                                    @elseif($row->status == 1)
                                                            <div class="badge badge-success badge-shadow">Available</span>
                                                                    @endif
                                                                </td>
                                                               
                
                                                                <td>
                                                                  <div class="form-inline">
                                                                    <a class="list-icons-item text-primary"
                                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                                        href="{{ route('menu-items.edit', $row->id)}}"><i
                                                                           class="icon-pencil7"></i></a>
                                                                           
                
                                                                    {!! Form::open(['route' => ['menu-items.destroy',$row->id],
                                                                    'method' => 'delete']) !!}
                                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
                
                                                                       <div class="dropdown">
							                		<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                                <div class="dropdown-menu">
                                                               <a class="nav-link"
                                                                    title="Edit" onclick="return confirm('Are you sure you want to change Status ?')"
                                                                    href="{{ route('menu-items.change', $row->id)}}">Change Status</a>

                                                                    </div></div>
                                                                   
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
                                                <h5>Create Menu Item</h5>
                                                @else
                                                <h5>Edit Menu Item</h5>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-sm-12 ">
                                                       
                                                        @if(isset($id))
                                                        {{ Form::model($id, array('route' => array('menu-items.update', $id), 'method' => 'PUT')) }}
                                                        @else
                                                        {{ Form::open(['route' => 'menu-items.store']) }}
                                                        @method('POST')
                                                        @endif
        
                                                         <input type="hidden" name="type" value="{{$type}}">
                                                          
                                                        <div class="form-group row">
                                                            <label class="col-lg-2 col-form-label"> Menu Name <span class="" style="color:red;">*</span></label>
                                                            <div class="col-lg-4">
                                                                <input type="text" name="name"  value="{{ isset($data) ? $data->name: ''}}"
                                                                class="form-control" required>
                                                            </div>
                                                            
                                                    
                                                            <label class="col-lg-2 col-form-label"> Price <span class="" style="color:red;">*</span></label>
                                                            <div class="col-lg-4">
                                                                <input type="text" name="price"  value="{{ isset($data) ? $data->price : ''}}"
                                                                class="form-control" required>
                                                            </div>
                                                            
                                                        </div>

                                                        <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label"> Tax Rate <span class="" style="color:red;">*</span></label>

                                                    <div class="col-lg-4">
                                                        <select name="tax_rate" class="form-control m-b item_tax" required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0" @if(isset($data))@if('0'==$data->tax_rate) selected @endif @endif>No tax</option>
                                                                    <option value="0.18" @if(isset($data))@if('0.18'==$data->tax_rate) selected @endif @endif>18%</option>
                                                                </select>
                                                    </div>
                                                </div>


                                                        <h4 align="center">Enter Menu Component</h4>
                                                        <hr>
                                                        
                                                        
                                                        <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                                class="fas fa-plus"> Add Menu Component</i></button><br>
                                                        <br>
                                                        <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Menu Component</th>
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
                                                                    
                                                                   
                                                    <td>
                                                        <input type="text" name="component[]" 
                                                    class="form-control item_price{{$i->order_no}}" required  value="{{ isset($i) ? $i->name : ''}}">
                                                     
                                                        </td>
                                                
                                                                            <input type="hidden" name="saved_id[]"
                                                                            class="form-control item_saved{{$i->order_no}}"
                                                                            value="{{ isset($i) ? $i->id : ''}}"
                                                                            required />
                                                                    <td><button type="button" name="remove"
                                                                            class="btn btn-danger btn-xs rem"
                                                                            value="{{ isset($i) ? $i->id : ''}}"><i
                                                                                class="icon-trash"></i></button></td>
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
                                                              @if(!@empty($id))
        
                                                                <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                    href="{{ route('menu-items.index')}}">
                                                                   Cancel
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
            </div>
        </div>
    </div>
</div>

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
            "columnDefs": [
                {"orderable": false, "targets": [1]}
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
    $(document).ready(function() {
    
    
        var count = 0;
    
    
        $('.add').on("click", function(e) {
    
            count++;
            var html = '';
            html += '<tr class="line_items">';   
                  
            html += '<td><input type="text" name="component[]" class="form-control item_price' + count +'" required  value="" style="margin-top:10px;"/></textarea></td>';
           
            html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';
    
            $("#cart > tbody ").append(html);
           
        });
    
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
           
        });
    
    
        $(document).on('click', '.rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
           $("#cart > tbody ").append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
           
        });
    
    });
    </script>

<script type="text/javascript">
    function model(id,type) {

let url = '{{ route("menu-items.show", ":id") }}';
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