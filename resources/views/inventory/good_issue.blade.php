@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                           @if(empty($returned))
                            <h4>Good Issue</h4>
                             @else
                     @if(!empty($returned) && $returned == '1')
                    <h4>Return Issued Goods</h4>
                    @else
                    <h4>Dispose Issued Goods</h4>
                    @endif

                        @endif
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                              @if(empty($returned))
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Good Issue
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Good Issue</a>
                                </li>
                                
                                 @else
                              
                              @endif

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                             @if(empty($returned))
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
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
                                                        style="width: 106.484px;">Reference</th>
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
                                                        style="width: 98.1094px;">Truck/Equipment</th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 98.1094px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($issue))
                                                    @foreach ($issue as $row)
                                                        <tr class="gradeA even" role="row">
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $row->name }}</td>
                                                            <td>{{ Carbon\Carbon::parse($row->date)->format('M d, Y') }}
                                                            </td>
                                                            <td> {{ $row->store->name }}</td>

                                                            <td> @if (!empty($row->staff)){{ $row->approve->name }}@endif</td>
                                                             <td> @if (!empty($row->truck->truck_name)){{ $row->truck->truck_name}} - {{$row->truck->reg_no }}@endif</td>

                                                           
                                                      <td>
                                            <div class="form-inline">
                                                    @if($row->status == 0)
                                               <a class="list-icons-item text-success"
                                                    href="{{ route("good_issue.approve", $row->id)}}" onclick="return confirm('Are you sure, You want to Approve')" title="Approve">
                                                    <i class="icon-checkmark3"></i>
                                                </a>&nbsp&nbsp                                             

                                                    <a class="list-icons-item text-primary"
                                                        href="{{ route("good_issue.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>&nbsp
                                                   
                                                    {!! Form::open(['route' => ['good_issue.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                  {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}

                                                    @else
                                                    
                                                     <div class="dropdown">
							                		<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                                <div class="dropdown-menu">
                                                    <a class="nav-link" data-toggle="modal" href=""  value="{{ $row->id}}" data-type="issue" data-target="#appFormModal" onclick="model({{ $row->id }},'issue')">
                                                        View  Items
                                                    </a>
                                                    
                                                   
                                                 
                                                      <a class="nav-link" href="{{ route("good_issue.returned", $row->id)}}"  value="">Return Issued Item </a>
                                                       <a class="nav-link" href="{{ route("good_issue.disposed", $row->id)}}"  value="">Dispose Issued Item </a>
                                                      @endif
                                                      
                                                       <a class="nav-link" data-toggle="modal" href=""  value="{{ $row->id}}" data-type="issue" data-target="#appFormModal" onclick="model({{ $row->id }},'returned')">
                                                        View  Returned/Disposed Items
                                                    </a>
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
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (!empty($id))
                                                <h5>Edit Good Issue</h5>
                                            @else
                                                <h5>Add New Good Issue</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['good_issue.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'good_issue.store']) }}
                                                        @method('POST')
                                                    @endif
                                                    <div class="form-group row">

                                                        <label class="col-lg-2 col-form-label">Date</label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($data) ? $data->date : date('Y-m-d') }}"
                                                                class="form-control" required>
                                                        </div>
                                                   

                                                        <label class="col-lg-2 col-form-label">Location</label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b location" name="location"
                                                                id="location_id" required>
                                                                <option value="">Select Location</option>
                                                                @if (!empty($location))
                                                                    @foreach ($location as $row)
                                                                        <option
                                                                            @if (isset($data)) {{ $data->location == $row->id ? 'selected' : '' }} @endif
                                                                            value="{{ $row->id }}">
                                                                            {{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div></div>
                                                        
                                                         <div class="form-group row">
                                                         
                                                         <label class="col-lg-2 col-form-label">Truck/Equipment</label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b truck_id" name="truck_id"
                                                                id="truck_id" required>
                                                                <option value="">Select Truck</option>
                                                                @if (!empty($truck))
                                                                    @foreach ($truck as $row)
                                                            <option @if (isset($data)) {{ $data->truck_id == $row->id ? 'selected' : '' }} @endif value="{{ $row->id }}">
                                                                            {{ $row->truck_name }} -  {{ $row->reg_no }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Staff</label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b staff" name="staff"
                                                                id="staff" required>
                                                                <option value="">Select </option>
                                                                @if (!empty($staff))
                                                                    @foreach ($staff as $row)
                                                                        <option
                                                                            @if (isset($data)) {{ $data->staff == $row->id ? 'selected' : '' }} @endif
                                                                            value="{{ $row->id }}">
                                                                            {{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif


                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Description</label>
                                                        <div class="col-lg-4">
                                                            <textarea name="description" class="form-control">{{ isset($data) ? $data->description : '' }}</textarea>
                                                        </div>
                                                         <label class="col-lg-2 col-form-label">Branch</label>
                                                         <div class="form-group col-md-4">
                                                            <select  class="form-control m-b" name="branch_id">
                                                                <option>Select Branch</option>
                                                                @if (!empty($branch))
                                                                    @foreach ($branch as $row)
                                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label" for="gender">Transport
                                                            Cost </label>
                                                        <div class="col-lg-4">
                                                            <input type="number" name="costs"
                                                                value="{{ isset($data) ? $data->costs : '' }}"
                                                                class="form-control costs">

                                                        </div>

                                                        @if (!empty($data->account_id))
                                                            <label for="stall_no" class="col-lg-2 col-form-label bank1"
                                                                style="display:block;">Payment Account</label>
                                                            <div class="col-lg-4 bank2" style="display:block;">
                                                                <select class="form-control m-b" name="account_id">
                                                                    <option value="">Select Payment Account</option>
                                                                    @foreach ($bank_accounts as $bank)
                                                                        <option value="{{ $bank->id }}"
                                                                            @if (isset($data)) @if ($data->account_id == $bank->id) selected @endif
                                                                            @endif
                                                                            >{{ $bank->account_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        @else
                                                            <label for="stall_no" class="col-lg-2 col-form-label bank1"
                                                                style="display:none;">Payment Account</label>
                                                            <div class="col-lg-4 bank2" style="display:none;">
                                                                <select class="form-control m-b" name="account_id">
                                                                    <option value="">Select Payment Account</option>
                                                                    @foreach ($bank_accounts as $bank)
                                                                        <option value="{{ $bank->id }}"
                                                                            @if (isset($data)) @if ($data->account_id == $bank->id) selected @endif
                                                                            @endif
                                                                            >{{ $bank->account_name }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        @endif
                                                    </div>



                                                    <br>
                                                    <h4 align="center">Enter Details</h4>
                                                    <hr>


                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add
                                                            item</i></button><br>
                                                    <br>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="cart">
                                                            <thead>
                                                                <tr>
                                                                    <th>Item Name</th>
                                                                   
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                @if (!empty($id))
                                                                    @if (!empty($items))
                                                                        @foreach ($items as $i)
                                                                            <tr class="line_items">

                                                                                <td>
                                                                        <select name="item_id[]" class="form-control m-b item_name" data-sub_category_id="{{ $i->order_no }}_qty" required>
                                                                        <option value="">Select Item</option>
                                                                        @foreach ($inventory as $n)
                                                                        <option value="{{ $n->id }}"@if (isset($i)) @if ($n->id == $i->item_id) selected @endif @endif>{{$n->brand->name}} - {{ $n->serial_no }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                           <div class=""><p class="form-control-static errors{{ $i->order_no }}_qty" id="errors" style="text-align:center;color:red;"></p></div>           
                                                                                    </td>
                                                                              <input type="hidden"
                                                                                        name="quantity[]"
                                                                                        class="form-control item_quantity"
                                                                                        data-category_id="{{ $i->order_no }}_qty"
                                                                                        placeholder="quantity"
                                                                                        id="quantity"
                                                                                        value="{{ isset($i) ? $i->quantity : '' }}"
                                                                                        required />
                                                                                  
                                                                                </td>
                                                                                <input type="hidden" id="item_id"
                                                                                    class="form-control item_id{{ $i->order_no }}_qty"
                                                                                    value="{{ $i->item_id }}" />

                                                                                <input type="hidden" name="saved_id[]"
                                                                                    class="form-control item_saved{{ $i->order_no }}_qty"
                                                                                    value="{{ isset($i) ? $i->id : '' }}"
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

                                                            </tbody>
                                                        </table>
                                                    </div>


                                                    <br>


                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))
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
                                
                                 {{--returned goods --}}
                            @else
                             <div class="tab-pane fade @if(!empty($returned)) active show @endif" id="profile3" role="tabpanel"
                                aria-labelledby="profile-tab3">

                                <div class="card">
                                    
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                    @if(!empty($returned) && $returned == '1')
                                                <form id="form" role="form" enctype="multipart/form-data" action="{{route('good_issue.return')}}"  method="post" >
                                                @else
                                                 <form id="form" role="form" enctype="multipart/form-data" action="{{route('good_issue.disposal')}}"  method="post" >
                                                @endif
                                                
                                                @csrf
                                                
                                                 <input type="hidden" id="purchase_id" name="issue_id"  class="form-control user"   value="{{ isset($returned) ? $id : ''}}">
                                 
                                           
                                            <div class="table-responsive">
                                            <table class="table table-bordered" id="cart">
                                                <thead>
                                                    <tr>
                                                        <th>Item Name</th>
                                                        
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                     
                                                        @if(!empty($data))
                                                        @foreach ($data as $i)

                                                          
                                                        <tr class="line_items">
                                                        <td><select name="item_name[]" class="form-control  m-b item_name" required disabled>
                                                            <option value="">Select Item</option>
                                                            @foreach($name as $n) 
                                                            <option value="{{ $n->id}}"@if(isset($i))@if($n->id == $i->item_id) selected @endif @endif >{{$n->serial_no}}</option>
                                                                    @endforeach
                                                                </select></td>

                                                           
                                                <input type="hidden"  class="form-control item_quantity" data-category_id="{{$i->order_no}}_qty" value="{{ isset($i) ? $i->due_quantity : ''}}" disabled />       
                                                   
                                        <input type="hidden" name="quantity[]" class="form-control item_quantity" id="quantity" value="1"  max="{{$i->due_quantity }}" required />
                                                               
                                                        
                                                        
                                                <input type="hidden" name="items_id[]" class="form-control name_list" value="{{ isset($i) ? $i->id : ''}}" />

                                                      
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs del"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
                                                        </tr>
                                                          
                                                        @endforeach
                                                        @endif
                                                       

                                                </tbody>
                                                
                                            </table>
                                        </div>


                                            <br>


                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                       
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>
                                                        
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                              @endif

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



    <script type="text/javascript">
        $(document).ready(function() {


            var count = 0;


            $('.add').on("click", function(e) {

                count++;
                var html = '';
                html += '<tr class="line_items">';
                html +=
                    '<td><select name="item_id[]" class="form-control m-b item_name" required  data-sub_category_id="' +count +'"><option value="">Select Item</option></select><div class=""> <p class="form-control-static errors' +
                    count + '" id="errors" style="text-align:center;color:red;"></p>   </div></td>';
                html +='<input type="hidden" name="quantity[]" class="form-control item_quantity" data-category_id="' +count +'"placeholder ="quantity" id ="quantity" value= "1" required /> ';
                html += '<input type="hidden" id="item_id"  class="form-control item_id' + count +
                    '" value="" />';
                html +=
                    '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

                $('tbody').append(html);
                
                           var id = $('.location').val();
            $.ajax({
                url: '{{url("inventory/findInvItem")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                console.log(data);
              $('select[data-sub_category_id="' + count + '"]').empty();
               $('select[data-sub_category_id="' + count + '"]').append('<option value="">Select Item</option>');
                $.each(data,function(key, value)
                {
                 
                   $('select[data-sub_category_id="' + count + '"]').append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });
                }
    
            });
                

               
                $('.m-b').select2({});
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

            $(document).on('change', '.item_name', function() {
                var id = $(this).val();
                var sub_category_id = $(this).data('sub_category_id');
                var item = $('.item_id' + sub_category_id).val();
                var location = $('.location').val();
                console.log(location);
                $.ajax({
                    url: '{{ url('inventory/findIssueItem') }}',
                    type: "GET",
                    data: {
                        id: id,
                        item: item,
                        location: location,
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
            

$(document).on('change', '.location', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("inventory/findInvItem")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                console.log(data);
                $('.item_name').empty();
               $('.item_name').append('<option value="">Select Item Name</option>');
                $.each(data,function(key, value)
                {
                 
                    $('.item_name').append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });
                }
    
            });
    
        });
    

        });
    </script>

   

    <script type="text/javascript">
        function model(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('inventory/issueModal') }}',
                data: {
                    'id': id,
                    'type': type,
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


    <script>
        $(document).ready(function() {

            $(document).on('change', '.costs', function() {
                var id = $(this).val();
                console.log(id);
                if (id > 0) {
                    $('.bank1').show();
                    $('.bank2').show();

                } else {
                    $('.bank1').hide();
                    $('.bank2').hide();

                }

            });
        });
    </script>
    
    <script type="text/javascript">
$(document).ready(function() {

    $(document).on('click', '.del', function() {
        $(this).closest('tr').remove();
    });



});
</script>
@endsection
