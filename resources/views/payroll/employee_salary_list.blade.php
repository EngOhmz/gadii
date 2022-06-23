@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Employee Salary Details</h4>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
        <table class="table table-striped" id="table-1">
            <thead>
                <tr>
                <th>#</th>
               
                    <th>Name</th>
                    <th>Salary Type</th>
                    <th>Basic Salary</th>                    
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
  @if(!@empty($data))
                                            @foreach ($data as $row)
                                            <tr class="gradeA even" role="row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{$row->user->name }}</td>
                                                <td>{{$row->salaryTemplates->salary_grade}}</td>
                                                <td>{{number_format($row->salaryTemplates->basic_salary,2)}}</td>
                                     
                                                <td>
                                                  <div class="form-inline">
                      <div class = "input-group"> 
                <a href="#"  class="btn btn-outline-success btn-xs" title="View"  data-toggle="modal" data-target="#appFormModal"  data-id="{{ $row->payroll_id }}" data-type="template"   onclick="model({{ $row->payroll_id }},'employee')">
                        <i class="fa fa-eye"></i></a>                                                             
                    </div>&nbsp
                      <div class = "input-group"> 
                      <a href="{{ route("employee.edit", $row->user->department_id)}}" class="btn btn-outline-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a> 
                   </div>&nbsp
                      <div class = "input-group"> 
         {!! Form::open(['route' => ['employee.destroy',$row->payroll_id], 'method' => 'delete']) !!}                                                   
                                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger  btn-xs ', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                                    {{ Form::close() }}
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


                </div>
            </div>
        </div>
    </div>
</section>

<!-- discount Modal -->
<div class="modal inmodal show" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    </div>
</div>
</div>
</div>
@endsection



@section('scripts')
<script type="text/javascript">
    function model(id, type) {

        let url = '{{ route("salary_template.show", ":id") }}';
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
@endsection