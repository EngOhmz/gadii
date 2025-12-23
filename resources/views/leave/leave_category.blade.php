@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Leave Category</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                         
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Leave Category
                                    List</a>
                            </li>
                           
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Leave Category</a>
                            </li>
                           

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                               
                                   <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 28.484px;">#</th>
                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Leave Category</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Duration</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Paid Leave</th>


                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($category))
                                            @foreach ($category as $row)
                                            <tr class="gradeA even" role="row">

                                                <td> {{ $loop->iteration }}</td>
                                                
                                                <td>{{$row->leave_category}}</td>

                                                 <td>{{$row->days}}</td>
                                                    <td>{{$row->paid}}</td>
                                                

                                               

                                                <td>
                                                 <div class="form-inline">
                                                    <a class="list-icons-item text-primary"
                                                        href="{{ route("leave_category.edit", $row->id)}}">
                                                      <i class="icon-pencil7"></i>
                                                    </a>&nbsp
                                                           


                                                    
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
                                        <h5>Create Leave Category</h5>
                                        @else
                                        <h5>Edit Leave Category</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('leave_category.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'leave_category.store']) }}
                                                @method('POST')
                                                @endif




                                               
                    <div class="form-group row"><label class="col-lg-2 col-form-label">Leave Category</label>

                        <div class="col-lg-10">
                            <input type="text" name="leave_category" id="category" class="form-control category" value="{{ isset($data) ? $data->leave_category : ''}}" required>
                        </div>
                    </div>
                    
                     <div class="form-group row"><label class="col-lg-2 col-form-label">Number of Days</label>

                        <div class="col-lg-10">
                            <input type="number" name="days" id="days" class="form-control days" value="{{ isset($data) ? $data->days : ''}}" required>
                        </div>
                    </div>
                    
                     <div class="form-group row"><label class="col-lg-2 col-form-label">Limit Days</label>

                        <div class="col-lg-10">
                          <select class="form-control limitation m-b" name="limitation"  id="limitation" required>
                            <option value="">Select</option>
                           <option value="Yes" @if(isset($data)){{  $data->limitation == 'Yes'  ? 'selected' : ''}}  @endif >Yes</option>
                            <option value="No" @if(isset($data)){{  $data->limitation == 'No'  ? 'selected' : ''}}  @endif >No</option>
                        </select>
                        </div>
                    </div>
                    
                     <div class="form-group row"><label class="col-lg-2 col-form-label">Paid Leave</label>

                        <div class="col-lg-10">
                          <select class="form-control m-b paid" name="paid"  id="paid" required>
                            <option value="">Select</option>
                           <option value="Yes" @if(isset($data)){{  $data->paid == 'Yes'  ? 'selected' : ''}}  @endif >Yes</option>
                            <option value="No" @if(isset($data)){{  $data->paid == 'No'  ? 'selected' : ''}}  @endif >No</option>
                        </select>
                        </div>
                    </div>
                    
                  
                    
                    
                                                
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('leave_category.index')}}">
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
</section>






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
    $(document).ready(function(){
   

 $(document).on('change', '.paid', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'Yes') {
          $('.amount_field').show(); 
           $("#amount").empty();
        $("#amount").prop('required',true);
        }
   else  {
            $('.amount_field').hide(); 
             $("#amount").empty();
              $("#amount").val(0);
           $("#amount").prop('required',false);
        } 
});






    });
</script>






  




@endsection