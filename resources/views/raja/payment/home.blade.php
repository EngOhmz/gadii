@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
           <div class="col-sm-12" >


         <div class="card">
            <!-- *********     Employee Search Panel ***************** -->
            <div class="card-header">
                <h4>School Fees Collection</h4>
            </div>
           
            
                <div class="card-body">
         
                     {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
                      <div class="form-group offset-3">
                        <label  for="field-1" class="col-sm-3 control-label">Search By Student Name <span
                                class="required"> *</span></label>

                        <div class="col-sm-5">
                            <input type="text" id="name" name="name" class="form-control name" value="{{ isset($name) ? $name : ''}}">
                        </div>
                    </div>

  <div class="form-group offset-3">
<label  for="field-1" class="col-sm-3 control-label">Payment Year <span class="required"> *</span></label>

                        <div class="col-sm-5">
                            <input type="text" name="year" class="form-control" id="datepicker"  required  value="{{ isset($year) ? $year : ''}}">
                          
                        </div>
                        </div>


                   <div class="form-group offset-4" id="border-none">
                                                        <label for="field-1" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-5">
                                                            <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>
                                                        </div>
                                                    </div>
                                  
                </div>
           
            {!! Form::close() !!}             
                  
                </div>
  </div>
           
        </div><!-- ******************** Employee Search Panel Ends ******************** -->

@if(!empty($students))
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>School Fees Collection</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a
                                    class="nav-link @if(empty($id)) active show @endif" href="#home2"
                                    data-toggle="tab">Students List</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">

                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th >#</th>
                                                <th>Name</th>
                                                <th>School Level</th>
                                                <th>Class</th>
                                                <th>Type</th>
                                                <th class="col-sm-3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>



                                            @if (!empty($students))
                                            @foreach ($students as $row)
                                            @php $level=App\Models\School\SchoolLevel::where('class',$row->class)->first();@endphp
                                            <tr class="gradeA even" role="row">
                                              <th>{{ $loop->iteration }}</th>
                                               <td>{{$row->student->student_name}} </td>
                                               <td>{{$level->level}} </td>
                                               <td>{{$row->class}} </td>
                                               <td>{{$row->student->type}} </td>
                                               <td><div class="form-inline">
                                          
                                          @if($row->status != '2')
                                           <div class="header-elements">
                                        <a href="{{ route('student.action', $row->id)}}" class="btn btn-outline-primary btn-xs" title="Fee Collection">Pay</a> &nbsp
                                        <a href="#" data-toggle="modal" data-target="#appFormModal"   data-id="{{ $row->id }}" data-type="discount"   onclick="model({{ $row->id }},'discount')"    data-toggle="modal" data- 
                                             target="#appFormModal"   class="btn btn-outline-success btn-xs" title="Discount">Discount</a>
                                             </div>
                                        @else
                                         <span class="badge badge-success badge-shadow">Payment of Fee Completed</span>
                                          @endif
                                   
                                            
                         </div></td>      
                                                           
                                  </tr>

                                       @endforeach
                                
                                    @endif
                                   
                                
                                   </tbody>
                                       
                                    </table>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
@endif

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
                {"orderable": false, "targets": [0]}
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

        let url = '{{ route("student.show", ":id") }}';
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
  <script src="{{asset('assets/js/bootstrap3-typeahead.min.js')}}"></script>
<script>
  var path = "{{url('school/autocomplete')}}";
  $('input.name').typeahead({
      source:  function (query, process) {
      return $.get(path, { term: query }, function (data) {
              return process(data);
          });
      }
  });
</script>



 <script src="{{url('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker").datepicker({
     format: "yyyy",
     viewMode: "years", 
     minViewMode: "years",
     autoclose:true
  });   
})

 </script>
@endsection