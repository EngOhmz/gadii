@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tire Disposal</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Tire Disposal
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Tire Disposal</a>
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
                                                    style="width: 106.484px;">Ref</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Date</th>
                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Staff</th>
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
                                            @if(!@empty($disposal))
                                            @foreach ($disposal as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                 <td>{{ $row->name }}</td>
                                               <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                               <td>{{$row->tyre_staff->name}}</td>                                            
                                                
                                               <td>
                                                @if($row->status == 0)
                                                <div class="badge badge-danger badge-shadow">Not Approved</div>
                                          
                                                @elseif($row->status == 1)
                                                <span class="badge badge-success badge-shadow"> Approved</span>

                                                @endif
                                            </td>
                                                      <td>
                                                    <div class="form-inline">
                                                        @if($row->status == 0)
                                                 
                                                    <a class="list-icons-item text-success"
                                                    href="{{ route("tyre_disposal.approve", $row->id)}}" title="Approve" onclick="return confirm('Are you sure?')">
                                                    <i class="icon-checkmark3"></i>
                                                </a>&nbsp&nbsp

                                               <a class="list-icons-item text-primary"
                                                        href="{{ route("tyre_disposal.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>&nbsp
                                              
                                                    {!! Form::open(['route' => ['tyre_disposal.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                 {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
                                                    &nbsp
                                                    
                                                      @endif
                                                    
                                             
                                               
                                                <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                            <div class="dropdown-menu">

                            <a class="nav-link" href=""  data-toggle="modal" href=""  value="{{ $row->id}}" data-type="disposal" data-target="#appFormModal" onclick="model({{ $row->id }},'disposal')">View  Items</a>
                           
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
                                        <h5>Edit Tire Disposal</h5>
                                        @else
                                        <h5>Add New Tire Disposal</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('tyre_disposal.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'tyre_disposal.store']) }}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->date :  date('Y-m-d')}}"
                                                            class="form-control" required>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Mechanical</label>
                                                    <div class="col-lg-4">
                                                     <select class="form-control m-b type" name="staff" required id="staff">
                                                 <option value="">Select 
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
                                            
                                              <div class=""> <p class="form-control-static save_errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                                              
                                            <div class="table-responsive">
                                            <table class="table table-bordered" id="cart">
                                                <thead>
                                                    <tr>
                                                        <th>Item Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                               
                                               
                                                    @if(!empty($id))
                                                    @if(!empty($items))
                                                    @foreach ($items as $i)
                                                    <tr class="line_items">
                                                        
                                                <td class="rtype_{{ $i->id }}_edit">
                                                <select name="item_id[]" class="form-control m-b item_name"  data-sub_category_id="{{ $i->id }}_edit" required >
                                                <option value="">Select Tire</option>
                                                @foreach($list as $n) 
                                                <option value="{{ $n->id}}" @if(isset($i))@if($n->id == $i->item_id) selected @endif @endif >{{ $n->serial_no }} </option>
                                                @endforeach
                                                        </select>
                                                <div class=""> <p class="form-control-static errors{{ $i->id }}_edit" id="errors" style="text-align:center;color:red;"></p></div>
                                                </td>
                                                  <input type="hidden" name="quantity[]"
                                                            class="form-control item_quantity" data-category_id="{{$i->order_no}}"
                                                            placeholder="quantity" id="quantity"
                                                            value="{{ isset($i) ? $i->quantity : ''}}"
                                                            required />       
                                                            
                                                    
                                                    <input type="hidden" id="item_id"  class="form-control item_id{{ $i->id }}_edit" value="{{$i->item_id}}" />

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

                                                 </tbody>   
                                            </table>
                                        </div>


                                            <br>


                            


                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit" id="save">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
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
            html +='<td  class="rtype_' +count + '"><select name="item_id[]" class="form-control m-b item_name" id="item_name' +count +'" required  data-sub_category_id="' +count +'"><option value="">Select Item</option>@foreach($list as $n) <option value="{{ $n->id}}">{{ $n->serial_no }}</option>@endforeach</select> </td>';
            html +='<input type="hidden" name="quantity[]" class="form-control item_quantity" data-category_id="' +count + '"placeholder ="quantity" id ="quantity" value= "1" required />';
            html +='<input type="hidden" id="item_id"  class="form-control item_id' +count+'" value="" />';                                                
            html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';
    
            $('#cart > tbody').append(html);
            
            

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


    
    
   





<script type="text/javascript">
    function model(id,type) {

$.ajax({
    type: 'GET',
     url: '{{url("tyre/invModal")}}',
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
    
    
 <script>
    $(document).ready(function() {
    
      
         $(document).on('click', '.save', function(event) {
   
         $('.save_errors').empty();
        
          if ( $('#cart > tbody tr').length == 0 ) {
               event.preventDefault(); 
    $('.save_errors').append('Please Add Items.');
}
         
         else{
            
         
          
         }
        
    });
    
    
    
    });
    </script>
       
  
    

@endsection