@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Work Order</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Work Order
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Work Order</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Reference No</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Product </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Expected Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Quantity</th>
                                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Produced Quantity</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Responsible User</th>
                                                  
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th> 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($work_orders))
                                            @foreach ($work_orders as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->reference_no }}</td>
                                                 
                                                <td>{{$row->item->name}}</td>
                                                   <td>{{$row->expected_date}}</td>
                                                    <td>{{number_format($row->quantity)}}</td>
                                                    <td>{{number_format($row->quantity - $row->due_quantity)}}</td>
                                                <td>{{$row->assign->name}}</td>
                                                 @php
                                                      $inv_store = App\Models\Location::find($row->location_id);
                                                 @endphp
                                                 
                                                 
                                                
                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-warning badge-shadow">Approved</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-info badge-shadow">Released</div>
                                                    @elseif($row->status == 3)
                                                    <span class="badge badge-success badge-shadow">Produced</span>

                                                    @endif
                                                </td>
                                                <td>
                                                <div class="form-inline">
                                                @if($row->status == 0)
                                                
                                                    <a class="list-icons-item text-primary"
                                                        href="{{ route("work_order.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>
                                                   

                                                    {!! Form::open(['route' => ['work_order.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
                                                    @endif

                                                    
                                                    <div class="dropdown">
							                		<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

													<div class="dropdown-menu">

                                                                    @if($row->status == 0)
                                                            <li> <a class="nav-link" id="profile-tab2"
                                                                    href="{{ route('work_order.approve',$row->id)}}"
                                                                    role="tab"
                                                                    aria-selected="false">Approve Work Order</a>
                                                            </li>
                                                               @elseif($row->status == 1)
                                                                  <li> <a class="nav-link" id="profile-tab2"
                                                                        href="{{ route('work_order.release',$row->id)}}"
                                                                        role="tab"
                                                                        aria-selected="false">Release Work Order</a>
                                                                </li>

                                                                    @elseif($row->status == 2)
                                                                     <li><a class="nav-link" href=""  data-toggle="modal" href=""  value="{{ $row->id}}" data-type="produce" data-target="#appFormModal"  onclick="model({{ $row->id 
                                                                     }},'produce')">Produce</a>
                                                                </li>

                                                                  <li> <a class="nav-link" id="profile-tab2"
                                                                        href="{{ route('work_order.finish',$row->id)}}"
                                                                        role="tab"
                                                                        aria-selected="false">Finish Production</a>
                                                                </li>
                                                                   @elseif($row->status == 3)
                                                                 <li><a class="nav-link" href=""  data-toggle="modal" href=""  value="{{ $row->id}}" data-type="overhead" data-target="#appFormModal"  onclick="model({{ $row->id 
                                                                     }},'overhead')">Overhead Cost</a>
                                                                </li>

                                                                       @endif
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
                                        @if(!empty($id))
                                        <h5>Edit Work Order</h5>
                                        @else
                                        <h5>Add New Work Order</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('work_order.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'work_order.store']) }}
                                                @method('POST')
                                                @endif
                                                
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Bill Of Material</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control m-b" name="product" required
                                                                id="product">
                                                                <option value="">Select Bill Of Material</option>
                                                                @if(!empty($billofmaterials))
                                                                @foreach($billofmaterials as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->product == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->reference_no}} - {{$row->description}}</option>

                                                                @endforeach
                                                                @endif

                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                
                                              <!--  <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Item Name</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control m-b" name="name" required
                                                                id="name">
                                                                <option value="">Select Item Name</option>
                                                                @if(!empty($items))
                                                                @foreach($items as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->name == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                        </select>
                                                    </div>
                                                </div> -->
                                                
                                                <input type="hidden" name="type"
                                                                class="form-control"
                                                                value="Manufacturing"
                                                                required />
                                                                
                                                <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Quantity</label>

                                                <div class="col-lg-10">
                                                    <input type="number" name="quantity"
                                                        value="{{ isset($data) ? $data->quantity : ''}}"
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
                                                
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Responsible By</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control m-b" name="user_id" required
                                                                id="user_id">
                                                                <option value="">Select Responsible User</option>
                                                                @if(!empty($users))
                                                                @foreach($users as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->responsible_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Description</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="description"
                                                            value="{{ isset($data) ? $data->description : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                
                                              <!--  <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Created Date</label>
                                                  <div class="col-lg-10">
                                                        <input type="date" name="created_date"
                                                            value="{{ isset($data) ? $data->created_date : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>-->
                                                
                                                
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Expected Date</label>
                                                  <div class="col-lg-10">
                                                        <input type="date" name="expected_date"
                                                            value="{{ isset($data) ? $data->expected_date : date('Y-m-d')}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                 <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Inventory Store Location</label>
                                                      <div class="col-lg-10">
                                                   <select class="form-control m-b" name="location_id" required
                                                                id="location_id">
                                                                <option value="">Select Inventory Store Location</option>
                                                                @if(!empty($locations))
                                                                @foreach($locations as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->location_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                        </select>
                                                    </div>
                                                                
                                                </div>
                                                
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Work Center Store</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control m-b" name="work_center" required
                                                                id="work_center">
                                                                <option value="">Select Work Center Store</option>
                                                                @if(!empty($locationWs))
                                                                @foreach($locationWs as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->work_center == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Finished Store</label>
                                                   <div class="col-lg-10">
                                                   <select class="form-control m-b" name="finished_store" required
                                                                id="finished_store">
                                                                <option value="">Select Finished Product Store </option>
                                                                @if(!empty($locationFs))
                                                                @foreach($locationFs as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->finished_store == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                        </select>
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

    $(document).on('change', '.billProduct', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("manufacturing/findbillProduct")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#class").empty();
                $("#class").append('<option value="">Select Product</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#class").append('<option value=' + value.id+ '>' + value.class + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script type="text/javascript">
    function model(id,type) {

$.ajax({
    type: 'GET',
     url: '{{url("manufacturing/workModal")}}',
    data: {
        'id': id,
        'type':type,
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