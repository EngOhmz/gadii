@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
           <div class="col-sm-12" >


         <div class="card">
            <!-- *********     Employee Search Panel ***************** -->
            <div class="card-header">
                <h4>School Fees Payment Views</h4>
            </div>
           
            
                <div class="card-body">
         
                     {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
                      <div class="form-group offset-3">
                        <label  for="field-1" class="col-sm-3 control-label">Search By Class <span
                                class="required"> *</span></label>

                        <div class="col-sm-5">
                           <select required name="class"  id="class" class="form-control m-b search" required  >
                                <option value="">Select Class</option>
                                     @if(!empty($schools))
                                            @foreach($schools as $row)
                                            <option value="{{$row->class}}" @if(!empty($class))  {{  $class == $row->class  ? 'selected' : ''}} @endif>{{$row->class}}</option>
                                             @endforeach
                                            @endif
                            </select>
                        </div>
                    </div>

  <div class="form-group offset-3">
<label  for="field-1" class="col-sm-3 control-label">Payment Year <span
                                class="required"> *</span></label>

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

@if(!empty($class))
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>School Fees Payment Views for {{$class}} in the year {{$year}}</h4>
                    </div>
                    <div class="card-body">
                        <!-- Tabs within a box -->
                       
                        <div class="tab-content tab-bordered">
                            <!-- ************** general *************-->
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2">

                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped " id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 28.1094px;">#</th>
                                               <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 168.1094px;">Name</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Fee Price</th>
                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Discount</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Due Amount</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Status</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                                    
                             <?php
                               $students=  DB::table('student_payments')
                           ->leftJoin('students', 'students.id', 'student_payments.student_id')
                            ->where('student_payments.year', $year)
                       ->where('students.added_by', auth()->user()->added_by)
                          ->where('students.class', $class)
                            ->select('student_payments.*','students.student_name')
                            ->get();
                                      
                                  ?>

                                                @if (!empty($students))
                                                @foreach ($students as $row)
                                                <tr class="gradeA even" role="row">
                                                 <td>{{ $loop->iteration }}</td>
                                                  <td>{{$row->student_name}} </td>
                                                  <td>{{number_format($row->fee,2)}} </td>
                                                  <td>{{number_format($row->discount,2)}} </td>
                                                  <td>{{number_format($row->due_fee,2)}} </td>
                                                   <td>
                                              @if($row->status == '0')
                                           <span class="badge badge-danger badge-shadow">Invoiced</span> 
                                             @elseif($row->status == '1')
                                             <span class="badge badge-info badge-shadow">Partially Paid</span>
                                            @elseif($row->status == '2')
                                             <span class="badge badge-success badge-shadow">Fully Paid</span>
                                              @endif
                                        </td>      
                                             <td><div class="form-inline">
                                                            @if($row->status != '0')
<a href="#" data-toggle="modal" data-target="#appFormModal"   data-id="{{ $row->id }}" data-type="template"   onclick="model({{ $row->id }},'payment')"    data-toggle="modal" data-target="#appFormModal"   class="list-icons-item text-success" title="Fee Collection">View  Details</a>
                    @else
 <a href="{{ route('student.action', $row->id)}}" class="list-icons-item text-primary" title="Fee Collection">Collect Fees</a>
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

 
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                $('#appFormModal > .modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
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