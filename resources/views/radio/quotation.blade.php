@extends('layouts.master')
@push('plugin-styles')


<style>

    .without::-webkit-datetime-edit-ampm-field {
   display: none;
 }
 
 input[type=time]::-webkit-clear-button {
   -webkit-appearance: none;
   -moz-appearance: none;
   appearance: none;
   margin: 0; 
 }

  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  -moz-appearance: none;
   appearance: none;
   margin: 0; 
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
                        <h4>Quotation</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Quotation
                                    List</a>
                            </li>
                              @if(!empty($id))
                            <li class="nav-item">
                                <a class="nav-link  active show" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false"> Quotation Form</a>
                            </li>
                       @endif

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
                                                    style="width: 130.484px;">Type</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 180.484px;">Client/Guest</th>
                                               
                                            
                                                      
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Date</th> 

                                                 {{--
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                 --}}
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 50.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 100.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($courier))
                                            @foreach ($courier as $row)
                                                    
                                            <tr class="gradeA even" role="row">
                                               
                                                <td><a href="{{ route('radio_quotation.show', $row->id)}}">{{$row->confirmation_number}}</a></td>
                                                 <td>{{$row->program_type}}</td>   
                                                <td> @if($row->program_type == 'Commercial'){{$row->supplier->name}} @else {{$row->guest}} @endif</td>                                             
                                                <td>{{Carbon\Carbon::parse($row->request_date)->format('M d, Y')}}</td>
                                                
                                                {{--<td>{{number_format($row->due_amount,2)}} {{$row->currency_code}}</td>--}}
                                                

                                                 
                                                <td>                              
                                                        @if($row->status == 0 )
                                                <div class="badge badge-warning badge-shadow">Waiting For Approval</div>
                                            @elseif($row->status == 1)
                                            <span class="badge badge-success badge-shadow">Approved</span>
                                            @elseif($row->status == 2)
                                            <span class="badge badge-danger badge-shadow">Cancelled</span>
                                           
                                           
                                                    @endif                                                
                                               </td>
                                         
                                               
                                                 <td>
                                               
                                                                              <div class="form-inline">
  
                                                                                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                    <div class="dropdown-menu">
                              
                
                 @if($row->status == 0 )  
                 
                 @can('approve-order')
              <a class="nav-link"  title="Approve"   href=""  data-toggle="modal"  onclick="model({{ $row->id }},'approve')" value="{{ $row->id}}" data-target="#appFormModal"> Approve </a>
               @endcan
               
                @can('reject-order')
              <a class="nav-link"  title="Cancel" href=""  data-toggle="modal"  onclick="model({{ $row->id }},'reject')" value="{{ $row->id}}" data-target="#appFormModal"> Reject </a>
               @endcan
               
               @elseif($row->status == 1)
              @if($row->finish == 0 ) 
              
               @can('finish-order')
              <a class="nav-link"  title="Finish"  href=""  data-toggle="modal"  onclick="model({{ $row->id }},'finish')" value="{{ $row->id}}" data-target="#appFormModal"> Finish Job </a>
                 @endcan
                 
                @endif
                
                @endif

{{--
               @if($row->status != 2 )                      
                <a class="nav-link"  onclick="return confirm('Are you sure?')" href="{{ route('radio.pay',$row->id)}}"  title="Add Payment"> Pay Order  </a>    
           @endif  
 --}}                                                                                                                             
                       <a class="nav-link" id="profile-tab2" href="{{ route('radio_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  role="tab"  aria-selected="false">Download Quotation</a>
                        <a class="nav-link" id="profile-tab2" href="{{ route('schedule_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  role="tab"  aria-selected="false">Download Preview Job Schedule</a>
             

                                           
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
                                      
                                       
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                              
                                                {{ Form::open(['route' => 'radio.save_receive']) }}
                                                @method('POST')
                                               
                                           
                                             <input type="hidden" name="pacel_id"
                                                class="form-control pacel"
                                                value="{{ isset($data) ? $data->id : ''}}" />
                                                 
                                             
                                          <input type="hidden" name="update"
                                                class="form-control"
                                                value="{{ isset($value) ? $value : ''}}" />
                                                   

                                         <input type="hidden" name="id"
                                                class="form-control list"
                                                value="{{ isset($data) ? $id : ''}}" />


                                            
                                                               <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Order Date</label>

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
                                                    
                                               
                                               
                                                     <label class="col-lg-2 col-form-label">Transmission Date</label>

                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php
                                                      if (!empty($it)) {
                                                      echo $it->date;
                                                               } else {
                                                            echo date('Y-m-d');
                                                      }
                                                 ?>"
                                                            class="form-control" readonly required>
                                                    </div></div>
                                                    
                                                      @if(!empty($data))
                                                     @if($data->program_type == 'Commercial')
                                                    
                                                     <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Client Name</label>

                                                    <div class="col-lg-4">
                                                  
                                         <select class=" form-control m-b supplier " name="owner_id"  id="supplier" disabled>
                                                <option value="">Select</option>
                                                          @if(!empty($users))
                                                          @foreach($users as $row)
                                                          <option @if(isset($data))
                                                          {{  $data->owner_id == $row->id  ? 'selected' : ''}}
                                                          @endif value="{{ $row->id}}">{{$row->name}}</option>
                                                          @endforeach
                                                          @endif

                                                        </select>
 
                                                    </div>
                                                    
                                                  
                                                   
                                                     <label class="col-lg-2 col-form-label">Amount(inclusive TAX)</label>

                                                    <div class="col-lg-4">
                                                        <input type="number" name="amount" value="{{ isset($data) ? $data->amount : ''}}" class="form-control"  required>
                                                    </div>
                                                   
                                                  
                                                    
                                                    
                                                    </div>
                                                    
                                                    
                                                    @endif
                                                     @endif

                                      



                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Instructions</label>

                                                    <div class="col-lg-10">
                                                        <textarea name="instructions" class="form-control" required>{{ isset($data) ? $data->instructions : ''}}</textarea>

                                                    </div>
                                                </div>





                                     <br>
                                              <h4 align="center">Enter Item Details</h4>
                                            <hr>
                                                 
@if(empty($value))
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"></i> Add Item</button><br>
@endif
                    
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
              
                <th>Category</th>
                <th>Duration</th>
                <th>Air Time</th>
                 <th>Program</th>
                <th >Action</th>
              
              </tr>
            </thead>
            <tbody>
   

@if(!empty($items)) 
@foreach($items as $x)
 <tr class="line_items">
<input type="hidden" name="tracking_id[]" class="form-control tracking" data-sub_category_id="{{$x->id}}" value="{{ isset($x) ? $x->tracking_id : ''}}" required />
<td><select name="category[]" class="form-control m-b category" required  data-sub_category_id="{{$x->id}}">
<option value="">Select Category</option><option value="Spot" @if(isset($x)){{ $x->category =='Spot'  ? 'selected' : ''}}@endif>Spot</option>
<option value="Program" @if(isset($x)){{  $x->category =='Program'  ? 'selected' : ''}}@endif>Program</option>
<option value="Sponspor" @if(isset($x)){{  $x->category =='Sponspor'  ? 'selected' : ''}}@endif>Sponspor</option>
<option value="Mentions" @if(isset($x)){{  $x->category =='Mentions'  ? 'selected' : ''}}@endif>Mentions</option>
</select></td>
<td><input name="duration[]" type="text" class="form-control timepicker3" id="duration_{{$x->id}}" value="{{ isset($x) ? $x->duration : ''}}" required /></td>
<td><input name="air_time[]" type="time" class="form-control time" value="{{ isset($x) ? $x->air_time : ''}}" required></td>
<td><input type="text" name="program[]" class="form-control program" value="{{ isset($x) ? $x->tracking_id : ''}}" required /></td>  
<td><button type="button" name="remove" class="btn btn-danger btn-xs rem" value="{{ isset($x) ? $x->id : ''}}"><i class="icon-trash"></i></button></td>
 <input type="hidden" name="saved_id[]" class="form-control item_saved" value="{{ isset($x) ? $x->id : ''}}" required />
</tr>

  

@endforeach
@endif


</tbody>
          </table>


    
                                                <br><div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                       
                                                              <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                
                                                                href="{{ route('radio_quotation.index')}}">
                                                                 cancel
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











    
    <script type="text/javascript">
    $(document).ready(function() {
    var i = 0;


   
    
    $('.add').on("click", function(e) {

           i++;
        var html = '';
        html += '<tr class="line_items">';
         html +='<input type="hidden" name="tracking_id[]" class="form-control tracking" data-sub_category_id="' +i + '" required value="{{isset($data) ? $data->confirmation_number : ''}}"/>';
         html +='<td><select name="category[]" class="form-control m-b category" required  data-sub_category_id="' +i +'"><option value="">Select Category</option><option value="Spot">Spot</option><option value="Program">Program</option><option value="Sponspor">Sponspor</option><option value="Mentions">Mentions</option></select></td>';
        html +='<td><input name="duration[]" type="text" class="form-control timepicker3" id="duration'+i +'" required /></td>';
        html +='<td><input name="air_time[]" type="time" class="form-control time" required></td>';
        html +='<td><input type="text" name="program[]" class="form-control program" required /></td>';
        html +=  '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#cart > tbody').append(html);
        
         $('.timepicker3').timepicker({
                minuteStep: 1,
                secondStep: 1,
                showSeconds: true,
                showMeridian:false,
                maxHours: 1,
                defaultTime: '0:00:00'
                
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
 $(document).ready(function(){
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });

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
</script>

@endsection