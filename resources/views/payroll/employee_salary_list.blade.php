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
        <table class="table datatable-basic table-striped" id="table-1">
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
                <a href="#"  class="list-icons-item text-info" title="View"  data-toggle="modal" data-target="#appFormModal"  data-id="{{ $row->id }}" data-type="template"   onclick="model({{ $row->id }},'employee')">
                        <i class="icon-eye"></i></a>                                                             
                    &nbsp

                      <a href="{{ route("employee.edit", $row->user->department_id)}}" class="list-icons-item text-primary"  title="Edit"><i class="icon-pencil7"></i></a> 
                   &nbsp

                  
           {!! Form::open(['route' => ['employee.destroy',$row->id], 'method' => 'delete']) !!}                                                     
          {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                
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