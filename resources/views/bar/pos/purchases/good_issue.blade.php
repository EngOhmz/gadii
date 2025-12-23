@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Good Issue</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Good Issue
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Good Issue</a>
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
                                                    style="width: 106.484px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 101.219px;">Location</th>
                                                    
                                              
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Staff</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($issue))
                                            @foreach ($issue as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                                                <td> {{$row->store->name}}</td>
                                                <td> @if(!empty($row->staff)){{$row->approve->name}}@endif</td>

                                                      <td>
                                            <div class="form-inline">
                                                    @if($row->status == 0)
                                               <a class="list-icons-item text-success"
                                                    href="{{ route("store_pos_issue.approve", $row->id)}}" onclick="return confirm('Are you sure, You want to Approve')" title="Change Status">
                                                    <i class="icon-checkmark3"></i>
                                                </a>&nbsp&nbsp                                             

                                                    <a class="list-icons-item text-primary"
                                                        href="{{ route("store_pos_issue.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>&nbsp
                                                   
                                                    {!! Form::open(['route' => ['store_pos_issue.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                  {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}

                                                    @else
                                                    <a class="nav-link"
                                                        href="{{ route("store_pos_issue.edit", $row->id)}}"  data-toggle="modal" href=""  value="{{ $row->id}}" data-type="issue" data-target="#appFormModal"
                                                        onclick="model({{ $row->id }},'issue')">
                                                        View  Items
                                                    </a>
                                               @endif
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
                                        <h5>Edit Good Issue</h5>
                                        @else
                                        <h5>Add New Good Issue</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('store_pos_issue.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'store_pos_issue.store']) }}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->date : date('Y-m-d')}}"
                                                            class="form-control" required>
                                                    </div>
                                                
                                                    <label class="col-lg-2 col-form-label">Location</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control m-b" name="location" required
                                                                id="supplier_id">
                                                        <option value="">Select Location</option>
                                                        @if(!empty($location))
                                                        @foreach($location as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->location == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                </div>

                                                

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Staff</label>
                                                   <div class="col-lg-4">
                                                    <select class="form-control m-b staff" name="staff"
                                                        id="staff">
                                                <option value="">Select </option>
                                                    @if(!empty($staff))
                                                    @foreach($staff as $row)

                                                    <option @if(isset($data))
                                                        {{ $data->staff == $row->id  ? 'selected' : ''}}
                                                        @endif value="{{$row->id}}">{{$row->name}}</option>

                                                    @endforeach
                                                    @endif
                                                  

                                            </select>
                                                    </div>
                                                
                                                    
                                                </div>
                                          
                                               

                                            <br>
                                            <h4 align="center">Enter  Details</h4>
                                            <hr>
                                            
                                            
                                            <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                    class="fas fa-plus"> Add item</i></button><br>
                                            <br>
                                            <div class="table-responsive">
                                            <table class="table table-bordered" id="cart">
                                                <thead>
                                                    <tr>
                                                        <th>Item Name</th>
                                                        <th>Quantity</th>
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
                                                        
                                                        <td><select name="item_id[]"
                                                            class="form-control m-b item_name"  data-sub_category_id="{{$i->order_no}}" required
                                                            >
                                                            <option value="">Select Item</option>@foreach($inventory
                                                            as $n) <option value="{{ $n->id}}"
                                                                @if(isset($i))@if($n->id == $i->item_id)
                                                                selected @endif @endif >{{$n->name}}</option>
                                                            @endforeach
                                                        </select></td>
                                                  <td><input type="number" name="quantity[]"
                                                            class="form-control item_quantity" data-category_id="{{$i->order_no}}"
                                                            placeholder="quantity" id="quantity"
                                                            value="{{ isset($i) ? $i->quantity : ''}}"
                                                            required />       
                                                            <div class=""> <p class="form-control-static errors{{$i->order_no}}" id="errors" style="text-align:center;color:red;"></p>   </div>
                                                    </td>
                                                    <input type="hidden" id="item_id"  class="form-control item_id{{$i->order_no}}" value="{{$i->item_id}}" />

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
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
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


    
    <script type="text/javascript">
    $(document).ready(function() {
    
    
        var count = 0;
    
    
        $('.add').on("click", function(e) {
    
            count++;
            var html = '';
            html += '<tr class="line_items">';   
               
                html +=
            '<td><select name="item_id[]" class="form-control m-b item_name" required  data-sub_category_id="' +
            count +
            '"><option value="">Select Item</option>@foreach($inventory as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></td>';
        html +=
            '<td><input type="number" name="quantity[]" class="form-control item_quantity" data-category_id="' +
            count + '"placeholder ="quantity" id ="quantity" value= "" required /> <div class=""> <p class="form-control-static errors'+count+'" id="errors" style="text-align:center;color:red;"></p>   </div></td>';
            html +='<input type="hidden" id="item_id"  class="form-control item_id' +count+'" value="" />';                                                
            html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';
    
            $('tbody').append(html);

           /*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
        });
    
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
           
        });
    
    
        $(document).on('click', '.rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('tbody').append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
           
        });
    
    });
    </script>

<script>
    $(document).ready(function() {
    
    
        $(document).on('change', '.item_name', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');

            console.log(id);
            $('.item_id' + sub_category_id).val(id);
               
    
    
        });
    
    
    });
    </script>

<script>
    $(document).ready(function() {
    
       $(document).on('change', '.item_quantity', function() {
            var id = $(this).val();
              var sub_category_id = $(this).data('category_id');
             var item= $('.item_id' + sub_category_id).val();
    console.log(item);
            $.ajax({
                url: '{{url("store/purchases/findQuantity")}}',
                type: "GET",
                data: {
                    id: id,
                  item: item,
                },
                dataType: "json",
                success: function(data) {
                  console.log(data);
                 $('.errors' + sub_category_id).empty();
                $("#save").attr("disabled", false);
                 if (data != '') {
                $('.errors' + sub_category_id).append(data);
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
    
    
    
        $(document).on('change', '.type', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("store/purchases/findIssueService")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    $("#type_id").empty();
                    $("#type_id").append('<option value="">Select</option>');
                    $.each(response,function(key, value)
                    {
                        if(id == "Service"){
                            $("#type_id").append('<option value=' + value.id+ '>' + value.truck_name + ' - ' + value.reg_no + '</option>');
    }
                       else if(id == "Maintenance"){
                        $("#type_id").append('<option value=' + value.id+ '>' + value.truck_name + '  - ' + value.reg_no + '</option>');
                }
                       
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
     url: '{{url("store/purchases/purchaseModal")}}',
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