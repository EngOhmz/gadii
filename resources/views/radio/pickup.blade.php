@extends('layouts.master')


@push('plugin-styles')

<style>

    .durationpicker-container {
     display: inline-block;
      
    }

 .durationpicker-innercontainer {
     display: inline-block;
      
    }

 
    </style>

@endpush


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Request Order</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id) && empty($id2)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Order
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Order </a>
                            </li>


                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id) && empty($id2)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>                                              
                                              
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 90.484px;">Reference</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 110.484px;">Type</th>
                                               
                                                      
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 101.219px;">Date</th> 

                                                
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 90.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 170.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($courier))
                                            @foreach ($courier as $row)
                                            <tr class="gradeA even" role="row">
                                               
                                                <td>{{$row->confirmation_number}}</td>                                                
                                                <td>{{$row->program_type}}</td>                                             
                                                <td>{{Carbon\Carbon::parse($row->request_date)->format('M d, Y')}}</td>
                                                

                                                
                                                <td>                              
                                                        @if($row->pickup== 0 )
                                                    <div class="badge badge-danger badge-shadow">Waiting For Approval</div>
                                                    @elseif($row->pickup == 1)
                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                                        
                                               </td>
                                           @endif



                                       <td>
                                                                                           
                                                
                                        <div class="form-inline">
  @if($row->pickup== 0)
 <a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('radio_pickup.edit', $row->id)}}"> <i class="icon-pencil7"></i></a>&nbsp

 {!! Form::open(['route' => ['radio_pickup.destroy',$row->id], 'method' => 'delete']) !!}
{{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
{{ Form::close() }}&nbsp

<a  href="#" class="list-icons-item text-primary" title="wbn" data-toggle="modal"  onclick="model({{ $row->id }},'wbn')" value="{{ $row->id}}" data-target="#appFormModal">                                                    
       <i class="icon-plus2"></i> Create Program</a>

 
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
                                        @if(empty($id))
                                        <h5>Create Order</h5>
                                        @else
                                        <h5>Edit Order</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('radio_pickup.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'radio_pickup.store']) }}
                                                @method('POST')
                                                @endif




                                             
                                                               <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Date</label>

                                                    <div class="col-lg-4">
                                                        <input type="date" name="request_date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php
                                                      if (!empty($data)) {
                                                      echo $data->request_date;
                                                               } else {
                                                         echo date('Y-m-d');
                                                      }
                                                 ?>"
                                                            class="form-control" required>
                                                    </div>
                                                    
                                                    <label class="col-lg-2 col-form-label">Type</label>
                                                    <div class="col-lg-4">
                                                       
                                                            <select class="form-control m-b program" name="program_type"  id="program_type" required>
                                                                <option value="">Select Type</option>

                                                    <option @if(isset($data)) {{  $data->program_type == 'Commercial' ? 'selected' : ''}} @endif value="Commercial">Commercial</option>
                                                     <option @if(isset($data)) {{  $data->program_type == 'Non-Commercial' ? 'selected' : ''}} @endif value="Non-Commercial">Non-Commercial</option>
                                                                

                                                            </select>
                                                    </div>
                                                    
                                                </div>
                                              
                                              <div class="check"  @if(!empty($data)) style="display:{{ $data->program_type == 'Commercial' ? 'block' : 'none'}};" @else style="display:none;" @endif >
                                              
                                                <div class="form-group row">
                                                    
                                                    <label class="col-lg-2 col-form-label">Client Name</label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group mb-3">
                                                            <select class="form-control append-button-single-field client_id" name="owner_id"  id="client_id">
                                                                <option value="">Select Client Name</option>
                                                                @if(!empty($users))
                                                                @foreach($users as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->owner_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>&nbsp

                                                            <button class="btn btn-outline-secondary" type="button"
                                                                    data-toggle="modal" value="" onclick="model('1','client')"
                                                                    data-target="#appFormModal"  href="app2FormModal"><i class="icon-plus-circle2"></i></button>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                     <label class="col-lg-2 col-form-label"  for="gender">Sales Type  </label>
                         <div class="col-lg-4">
                   <select class="form-control m-b sales" name="sales_type" id="sales">                                     
                      <option value="">Select Sales Type</option>
                        <option value="Cash Sales" @if(isset($data)){{$data->sales_type == 'Cash Sales'  ? 'selected' : ''}} @endif>Cash Sales</option>
                             <option value="Credit Sales" @if(isset($data)){{$data->sales_type == 'Credit Sales'  ? 'selected' : ''}} @endif>Credit Sales</option>                                                              
                    </select>

                                                    </div>
                                                    
                                                </div>
                                              
                                                  </div>
                                         
                                                <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Start Date</label>

                                                    <div class="col-lg-4">
                                                        <input type="date" name="from_date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php
                                                      if (!empty($data)) {
                                                      echo $data->from_date;
                                                               } ?>"
                                                            class="form-control" required>
                                                    </div>
                       
                                                    <label class="col-lg-2 col-form-label">End Date</label>

                                                            <div class="col-lg-4">
                                                                <input type="date" name="to_date"
                                                                    placeholder="0 if does not exist"
                                                                    value="<?php
                                                            if (!empty($data)) {
                                                            echo $data->to_date;
                                                                    } ?>"
                                                                    class="form-control" required>
                                                            </div>


                                                </div>

                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Branch</label>
                                                    <div class="col-lg-4">
                                                      

                              <select class="form-control m-b" name="branch_id" id="branch_id"  >
                            <option value="" selected>Select Branch</option>
                            @if(isset($branch))
                            @foreach($branch as $row)
                            <option  @if(isset($data)) {{$data->branch_id == $row->id ? 'selected' : '' }} @endif  value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                                                    </div> 
                                                  
                                               
                                                    <label
                                                        class="col-lg-2 col-form-label">Instructions</label>

                                                    <div class="col-lg-4">
                                                        <textarea name="instructions" class="form-control" required>{{ isset($data) ? $data->instructions : ''}}</textarea>

                                                    </div>
                                                </div>
                                                



                                  <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                       
                                                              <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                
                                                                href="{{ route('radio_pickup.index')}}">
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

    </div>
</section>

 <!-- discount Modal -->
  <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
    </div>
</div>




@endsection

@section('scripts')
<script src="{{asset('assets/js/time/timepicker.min.js')}}"></script>
<script>
 $(document).ready(function(){
            $('.timepicker3').timepicker({
                minuteStep: 1,
                secondStep: 1,
                showSeconds: true,
                showMeridian:false,
                maxHours: 1,
                defaultTime: false
                
            });
  });
</script>

<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            order: [[4, 'desc']],
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
 $(document).ready(function(){
            $('.m-b').select2({
                            });

  });
</script>
















    
    <script type="text/javascript">
        
          $(document).ready(function(){

     

            function autoCalcSetup() {
                $('table#cart').jAutoCalc('destroy');
                $('table#cart tr.line_items').jAutoCalc({keyEventsFire: true, decimalPlaces: 2, emptyAsZero: true});
                $('table#cart').jAutoCalc({decimalPlaces: 2});
            }
            autoCalcSetup();

   

        });
        


    </script>






<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("radio/radioModal")}}',
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
    
    
    
    function saveClient(e) {
     
     $.ajax({
            type: 'GET',
            url: '{{url("pos/sales/save_client")}}',
         data:  $('#addClientForm').serialize(),
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#client_id').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.program', function() {
        var id = $(this).val();
  console.log(id);


 if (id == 'Commercial'){
     $('.check').show(); 

}


else{
  $('.check').hide(); 
   

}

  });



});

</script>
@endsection