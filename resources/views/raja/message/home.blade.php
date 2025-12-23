@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">

            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Message Board</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a
                                    class="nav-link @if(empty($id)) active show @endif" href="#home2"
                                    data-toggle="tab">Message List</a>
                            </li>
                            <li class="nav-item"><a class="nav-link @if(!empty($id)) active show @endif"
                                    href="#profile2" data-toggle="tab">Create New Message</a></li>
                        </ul>
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">

                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th >#</th>
                                                <th>Date</th> 
                                                <th>Class</th>
                                                <th>Message</th> 
                                                <th>Status</th>                                          
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                       
                                            @if(!@empty($schools))
                                              @foreach ($schools as $row)
                                                <tr class="gradeA even" role="row">
                                                  <th>{{ $loop->iteration }}</th>
                                                   <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                                   <td>{{$row->class}}</td>
                                                    <td>{{$row->message}}</td>
                                                     <td>
                                              @if($row->status == '0')
                                           <span class="badge badge-info badge-shadow">Pending</span> 
                                             @elseif($row->status == '1')
                                             <span class="badge badge-success badge-shadow">Sent</span>
                                           
                                              @endif
                                        </td> 
                                                    
                                                               
                                      </tr>
                                    @endforeach
                                
                                    @endif
                                
                                   </tbody>
                                       
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2">
                                <div class="card">
                                    <div class="card-header">
                                         @if(empty($id))
                                        <h5>Create Message</h5>
                                        @else
                                        <h5>Edit Message</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                  @if(isset($id))
                                                {{ Form::model($id, array('route' => array('messages.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'messages.store','role'=>'form','enctype'=>'multipart/form-data']) }}
                                                @method('POST')
                                                @endif


                                               

                                                               
                                             <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Class </label>  
                                                       <div class="col-lg-10"> 
                                                     @if(!empty($class))
                                            &nbsp;&nbsp;&nbsp;<input type="checkbox" name="select_all"  id="example-select-all"> Select All <br>
                                            @foreach ($class as $row)
                                            <div class="col-lg-12">
                                            @php $c=App\Models\School\SchoolLevel::where('level',$row->level)->get(); @endphp
                                            
                                             @foreach ($c as $r)
                                             <input name="trans_id[]" type="checkbox"  class="checks" value="{{$r->class}}"> {{$r->class}} &nbsp;
                                             @endforeach
                                            </div>
                                   
                                            @endforeach
                                                   @endif
                                                </div>
                                                </div>

                                          <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Message </label>  
                                                       <div class="col-lg-8"> 
                                                    <textarea name="message" class="form-control" rows="3"></textarea>
                                                </div>
                                                </div>



                                                               <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))      
                                                                                                                                                          
                                                <a href="{{ route('messages.index')}}" class="btn btn-sm btn-danger float-right m-t-n-xs" >Cancel</a> 
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit">Update</button>                                                 
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
    function model(id, type) {

        let url = '{{ route("school.show", ":id") }}';
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

    $(document).on('change', '.level', function() {
        var id = $(this).val();
         var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("school/findLevel")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $('.class'+sub_category_id).empty();
                $('.class'+sub_category_id).append('<option value="">Select Class</option>');
                $.each(response,function(key, value)
                {
                 
                   $('.class'+sub_category_id).append('<option value=' + value.id+ '>' + value.class + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script>

$("#example-select-all").click(function() {
  $(".checks").prop("checked", $(this).prop("checked"));
});

$(".checks").click(function() {
  if (!$(this).prop("checked")) {
    $("#example-select-all").prop("checked", false);
  }
});


</script>


@endsection