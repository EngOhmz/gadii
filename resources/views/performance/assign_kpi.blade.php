@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
            
                <div class="card">
                    <div class="card-header">
                        <h4>Assign Performance Indicator</h4>
                    </div>
                    <div class="card-body">
                    
                         
                         @if(!empty($id))
                         
                               
                    <div class="form-group offset-3">
                        <label for="field-1" class="col-sm-3 control-label">Employee <span class="required">
                                *</span></label>

                        <div class="col-sm-5">
                            <select name="user" class="form-control m-b user" style="width:100%" disabled required>
                                            <option value="">Select</option>
                                            @if (!empty($user))
                                            @foreach ($user as $u) 
                                            <option value="{{$u->id}}" @if(isset($dept)) {{ $dept == $u->id ? 'selected' : ''  }} @endif> {{$u->name}}</option>
                                                   
                                            @endforeach
                                            @endif
                                        </select>
                        </div>
                    </div>
                   
                  
                    
                    
                         @else
                         
                          {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
               
                    <div class="form-group offset-3">
                        <label for="field-1" class="col-sm-3 control-label">Employee <span class="required">
                                *</span></label>

                        <div class="col-sm-5">
                            <select name="user" class="form-control m-b user" style="width:100%" required>
                                            <option value="">Select</option>
                                            @if (!empty($user))
                                            @foreach ($user as $u) 
                                            <option value="{{$u->id}}" @if(isset($dept)) {{ $dept == $u->id ? 'selected' : ''  }} @endif> {{$u->name}}</option>
                                                   
                                            @endforeach
                                            @endif
                                        </select>
                        </div>
                    </div>
                    
                   
                    <div class="form-group offset-4" id="border-none">
                        <label for="field-1" class="col-sm-3 control-label"></label>
                        <div class="col-sm-5">
                             <button type="submit" class="btn btn-success" id="save">Go</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                    
                    <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p> </div>
                
            </form>
            @endif
            
            
            @if(!empty($dept)) 
            
            
            
            
        </div><!-- ******************** Employee Search Panel Ends ******************** -->
           </div>             
                        
            <br>
             
                       
                           
                                <div class="card">
                                
                                 
                                 
                                    <div class="card-header">
                                       @php $name=App\Models\User::find($dept)->name;@endphp
                                        <h5>Key Performance Indicator for {{$name}} </h5>
                                       <hr>
                                    </div>
                                    
                                    <div class="card-body">
                                       
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('update_kpi', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'save_kpi']) }}
                                                @method('POST')
                                                @endif

                                       
                                                <div class="form-group row">
                        <label class="col-sm-3 control-label">Date <span class="required"> *</span></label>
                        <div class="col-sm-5">
                                <input type="date" name="date"  value="{{ isset($data) ? $data->date : date('Y-m-d')}}" class="form-control date"  required>

                        </div>
                    </div>
                    
                    <br>
                                
                                         <div class="table-responsive">
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                     <th>#</th>
                                                                    <th>Key Result Area</th>
                                                                    <th>Key Performance Indicator</th>
                                                                    <th>Type</th>
                                                                    <th>%</th>
                                                                    
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                              @if(!empty($list))
                                                                @foreach ($list as $i)
                                                                <tr class="line_items">
                                                                
                                                                @if(!empty($id))
                                                                @php
                                                                $items= App\Models\Performance\KPIResultList::where('result_id',$id)->where('list_id',$i->id)->first();
                                                                @endphp
                                                                    @endif
                                                                    
                                                    <td>{{$loop->iteration }}</td>                
                                                <td>{{$i->area }}</td>
                                                <td>{!! $i->indicator !!}</td>
                                                
                                                <td>
                                                <select id="type{{$i->id}}" name="type[]" class="form-control m-b type" data-sub_category_id="{{$i->id}}" required>
                                               
                                        <option value="Automatic"  @if(isset($items)) {{$items->type == 'Automatic' ? 'selected' : '' }} @endif >Automatic</option>
                                                 <option value="Manual" @if(isset($items)) {{$items->type == 'Manual' ? 'selected' : '' }} @endif>Manual</option>                
                                                  </select>
                                                </td>
                                                
                                                 <td>
                                                 
                                                  <div class="input-group mb-3" id="goal{{$i->id}}" style="display: @if(!empty($items)){{  $items->type != 'Manual' ? 'block' : 'none'  }} @endif ;"> 
                                                 <select name="goal_id[]" class="form-control append-button-single-field goal" id="goal_id_{{$i->id}}"  data-sub_category_id="{{$i->id}}">
                                            <option value="">Select Goal</option>
                                                      @if (!empty($goal))
                                                      @foreach ($goal as $v_goal)
                                                    <option value="{{$v_goal->id}}" @if(isset($items)) {{$items->goal_id == $v_goal->id ? 'selected' : '' }} @endif>{{$v_goal->subject}}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>&nbsp;
                                       
                                            <button class="btn btn-outline-secondary" type="button" data-toggle="modal" onclick="model({{ $i->id}},'addgoal')" value="{{ $i->id}}" data-target="#appFormModal"><i class="icon-plus-circle2"></i></button>
                                                
                                          </div>
                                          
                                             @if(!empty($items))
                                             <input type="text" name="percent[]" class="form-control percent{{$i->id}}" value="{{ isset($items) ? $items->percent : ''}}" @if(!empty($items)){{  $items->type == 'Manual' ? 'readonly' : ''  }} @endif  required>
                                             
                                             @else
                                             
                                             <input type="text" name="percent[]" class="form-control percent{{$i->id}}" readonly  required>
                                             @endif
                                                 
                                                 
                                                 
                                                 
                                                 </td>
                                                 
                                                 
                                                 <input type="hidden" name="list_id[]" class="form-control list{{$i->id}}" value="{{$i->id}}">
                                                  <input type="hidden" name="saved_id[]" class="form-control item_saved{{$i->id}}" value="{{ isset($items) ? $items->id : ''}}" required />
                                                                </tr>
                                                
                                                                @endforeach
                                                                @endif
            
                                                            </tbody>
                                                               
                                                        </table>
                                                    </div>
       
                                
               
                                
                                  <input type="hidden" name="user_id" id="user_id" value="{{ isset($dept) ? $dept : '' }}">
                                    <input type="hidden" name="kpi_id" value="{{ isset($kp) ? $kp->id : '' }}"> 
                                     <input type="hidden" name="designation_id" value="{{ isset($kp) ? $kp->designation_id : '' }}"> 
                                     <input type="hidden" name="department_id" value="{{ isset($kp) ? $kp->department_id : '' }}"> 
                                      
                                      
                                 
                                      
                                               <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit" id="save2">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save2">Save</button>
                                                        @endif
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    
                           
                            @endif

                      
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
    
    
    <script>
$(document).ready(function() {

    $(document).on('change', '.user', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("performance/findUser2")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
            $("#save").attr("disabled", false);
             $("#save2").attr("disabled", false);
             if (data != '') {
           $("#errors").append(data);
           $("#save").attr("disabled", true);
            $("#save2").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });
    
});
</script>

<script type="text/javascript">
        $(document).ready(function() {
            $(document).on('change', '.type', function() {
                var id = $(this).val();
         var sub_category_id =  $(this).data('sub_category_id');
         console.log(id);

                if (id == 'Automatic') {
                     $('#goal' + sub_category_id).show();
                      $('.percent' + sub_category_id).attr("readonly", true);
                      

                } else {
                   $('#goal' + sub_category_id).hide();
                    $('.percent' + sub_category_id).attr("readonly", false);
                }
            });
        });
    </script>

<script type="text/javascript">
$(document).ready(function() {
    
    $(document).on('change', '.goal', function() {
        var id = $(this).val();
        var user =  $('#user_id').val();;
         var sub_category_id =  $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("performance/findPercent")}}',
            type: "GET",
            data: {
                id: id,
                user:user,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
           
           $('.percent' + sub_category_id).val(data);
           
            
       
            }

        });

    });




});
</script>
    

 
 <script type="text/javascript">
    function model(id, type) {

 var user =  $('#user_id').val();;
        $.ajax({
            type: 'GET',
            url: '{{url("performance/performanceModal")}}',
            data: {
                'id': id,
                'type': type,
                'user':user,
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
    
 <script>   
    function saveGoal(e){
   var form = $('#addClientForm').serialize();
       var sub_category_id =  $('#category').val();;
       
          $.ajax({
            type: 'GET',
            url: '{{url("performance/addGoal")}}',
            
         data:  $('#addClientForm').serialize(),
              
          
                dataType: "json",
             success: function(response) {
                console.log(response);
              console.log(sub_category_id);
                               var id = response.id;
                             var name = response.subject;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#goal_id_'+sub_category_id).append(option).trigger('change').trigger('create');;
                              $('#appFormModal').hide();
                            $('.modal-backdrop').remove();
                                
               
            }
        });
}

    </script>
@endsection