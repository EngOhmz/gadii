@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tire Reallocation</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Tire Reallocation
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Tire Reallocation</a>
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
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 128.219px;">Source Truck</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Destination Truck</th>

                                               
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
                                                    style="width: 258.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($reallocation))
                                            @foreach ($reallocation as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                 <td>{{ $row->name }}</td>
                                               <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                              <td>{{$row->s_truck->reg_no}} - {{$row->s_truck->truck_name}}</td> 
                                                <td>{{$row->d_truck->reg_no}} - {{$row->d_truck->truck_name}}</td>  
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
                                                    href="{{ route("tyre_reallocation.approve", $row->id)}}" title="Approve" onclick="return confirm('Are you sure?')">
                                                    <i class="icon-checkmark3"></i>
                                                </a>&nbsp&nbsp

                                               <a class="list-icons-item text-primary"
                                                        href="{{ route("tyre_reallocation.edit", $row->id)}}">
                                                        <i class="icon-pencil7"></i>
                                                    </a>&nbsp
                                              
                                                    {!! Form::open(['route' => ['tyre_reallocation.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                 {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
                                                    &nbsp
                                                    
                                                      @endif
                                                    
                                             
                                               
                                                <div class="dropdown">
                                                <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                            <div class="dropdown-menu">

                            <a class="nav-link" href=""  data-toggle="modal" href=""  value="{{ $row->id}}" data-type="reallocation" data-target="#appFormModal" onclick="model({{ $row->id }},'reallocation')">View  Items</a>
                           
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
                                        <h5>Edit Tire Reallocation</h5>
                                        @else
                                        <h5>Add New Tire Reallocation</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('tyre_reallocation.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'tyre_reallocation.store']) }}
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

                                                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Source Truck</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control m-b truck_id" name="source_truck" required
                                                                id="supplier_id">
                                                        <option value="">Select Source</option>
                                                        @if(!empty($truck_s))
                                                        @foreach($truck_s as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->source_truck == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->truck->reg_no}} - {{$row->truck->truck_name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                
                                                    <label
                                                    class="col-lg-2 col-form-label">Destination Truck</label>

                                                <div class="col-lg-4">
                                                    <select class="form-control m-b type_id" name="destination_truck" required
                                                    id="">
                                                    <option value="">Select Destination</option>
                                                    @if(!empty($truck))
                                                    @foreach($truck as $row)

                                                    <option @if(isset($data))
                                                        {{ $data->destination_truck == $row->id  ? 'selected' : ''}}
                                                        @endif value="{{$row->id}}">{{$row->truck->reg_no}} - {{$row->truck->truck_name}}</option>

                                                    @endforeach
                                                    @endif
                                            </select>
                                                    </div>
                                                </div>
                                          
                                               
                                        <div class="form-group row">
                <label class="col-lg-2 col-form-label">Source Reading</label>

                <div class="col-lg-4">
                 <input type="text" name="source_reading" value="{{isset($data) ? $data->source_reading : ''}} "   class="form-control"  required>
                    
                </div>

               <label class="col-lg-2 col-form-label">Destination Reading</label>

                <div class="col-lg-4">
                 <input type="text" name="destination_reading" value="{{isset($data) ? $data->destination_reading : ''}}"   class="form-control"  required>
                    
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
                                                        <th>Source Tire</th>
                                                        <th>Destination Tire</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                               
                                               
                                                    @if(!empty($id))
                                                    @if(!empty($items))
                                                    @foreach ($items as $i)
                                                    <tr class="line_items">
                                                        
                                                <td class="rtype_{{ $i->id }}_edit">
                                                <select name="source_tyre[]" class="form-control m-b tyre"  id="tyre{{ $i->id }}_edit" data-sub_category_id="{{ $i->id }}_edit" required >
                                                <option value="">Select Source Tire</option>
                                                @foreach($list as $n) 
                                                <option value="{{ $n->id}}" @if(isset($i))@if($n->id == $i->source_tyre) selected @endif @endif >
                                                {{ $n->serial_no }} - {{ $n->position }} </option>
                                                @endforeach
                                                </select>
                                                </td>
                                                
                                                <td class="rtype1_{{ $i->id }}_edit">
                                                <select name="destination_tyre[]" class="form-control m-b dest_tyre"  id="destination_tyre{{ $i->id }}_edit" data-sub_category_id="{{ $i->id }}_edit">
                                                <option value="">Select Destination Tire</option>
                                                @foreach($dest_list as $n) 
                                                <option value="{{ $n->id}}" @if(isset($i))@if($n->id == $i->destination_tyre) selected @endif @endif>
                                                {{ $n->serial_no }} - {{ $n->position }} </option>
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
                             
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
                                                            type="submit" id="save">Save</button>
                                                       
                                                      
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
            html +='<td class="rtype_' +count + '"><select name="source_tyre[]" class="form-control m-b tyre"  required  data-sub_category_id="' +count +'"><option value="">Select Source Tire</option></select> </td>';
             html +='<td class="rtype1_' +count + '"><select name="destination_tyre[]" class="form-control m-b dest_tyre"   data-sub_category_id="' +count +'"><option value="">Select Destination Tire</option></select> </td>';
            html +='<input type="hidden" name="quantity[]" class="form-control item_quantity" data-category_id="' +count + '"placeholder ="quantity" id ="quantity" value= "1" required />';
            html +='<input type="hidden" id="item_id"  class="form-control item_id' +count+'" value="" />';                                                
            html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';
    
            $('#cart > tbody').append(html);
            
 
            var id1 = $('.truck_id').val();
            $.ajax({
                url: '{{url("tyre/findTyreDetails")}}',
                type: "GET",
                data: {
                    id: id1
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                $('.rtype_'+count).find('.tyre').empty();
                $('.rtype_'+count).find('.tyre').append('<option value="">Select Source Tire</option>');
                $.each(data,function(key, value)
                {
                 
                    $('.rtype_'+count).find('.tyre').append('<option value=' + value.id+ '>' + value.serial_no + ' - ' + value.position + '</option>');
                   
                });
                }
    
            });
    
       
    
            var id2 = $('.type_id').val();

            $.ajax({
                url: '{{url("tyre/findTyreDetails")}}',
                type: "GET",
                data: {
                    id: id2
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                $('.rtype1_'+count).find('.dest_tyre').empty();
               $('.rtype1_'+count).find('.dest_tyre').append('<option value="">Select Destination Tire</option>');
               
               
                     if(data != ''){
                   $('.rtype1_'+count).find('.dest_tyre').prop('required',true);  
                }
                else{
                  $('.rtype1_'+count).find('.dest_tyre').prop('required',false); 
                }
                
                $.each(data,function(key, value)
                {
                 
              $('.rtype1_'+count).find('.dest_tyre').append('<option value=' + value.id+ '>' + value.serial_no + ' - ' + value.position + '</option>');
                   
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
    
    
        $(document).on('change', '.truck_id', function() {
            var id = $(this).val();
             var sub_category_id = $(this).data('sub_category_id');
            $.ajax({
                url: '{{url("tyre/findTyreDetails")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.tyre').empty();
                $('.tyre').append('<option value="">Select Source Tire</option>');
                $.each(data,function(key, value)
                {
                 
                    $('.tyre').append('<option value=' + value.id+ '>' + value.serial_no + ' - ' + value.position + '</option>');
                   
                });
                }
    
            });
    
        });
    
    
    
    
        $(document).on('change', '.type_id', function() {
            var id = $(this).val();
             var sub_category_id = $(this).data('sub_category_id');
            $.ajax({
                url: '{{url("tyre/findTyreDetails")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.dest_tyre').empty();
                $('.dest_tyre').append('<option value="">Select Destination Tire</option>');
                
                  if(data != ''){
                   $('.dest_tyre').prop('required',true);  
                }
                else{
                   $('.dest_tyre').prop('required',false); 
                }
                $.each(data,function(key, value)
                {
                    
                    $('.dest_tyre').append('<option value=' + value.id+ '>' + value.serial_no + ' - ' + value.position + '</option>');
                   
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
            
          $.ajax({
                    data: $('#cart > tbody tr').find('select').serialize(),
                    type: 'GET',
                    url: '{{ url('tyre/findTyrePosition') }}',
                    dataType: "json",
                    success: function(response) {
                    console.log(response);
                     $('.save_errors').empty();
                         if(response != ''){
                           event.preventDefault(); 
                        $('.save_errors').append('Please Choose Tires of the same position.');   
                         }
                         
                         else{
                           
                         }
                       

                    }
                })
                
                
        
         
          
         }
        
    });
    
    
    
    });
    </script>
       
  
    

@endsection