@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Performance Indicator Result</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                
                              
                                        
                                     <table class="table datatable-basic table-striped">
                                           <thead>
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 38.531px;">#</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Employee</th>
                                                    
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Date</th>
                                                    
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Status</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($list))
                                            @foreach ($list as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->user->name}}</td>
                                                  <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>  
                                                  
                                                   <td> 
                                                       @if($row->active == '0')
                                                    <div class="badge badge-primary badge-shadow">Active</div>
                                                    @elseif($row->active == '1')
                                                    <span class="badge badge-success badge-shadow">Close</span>
                                                   
                                                @endif
                                                  </td>

                                                 <td><div class="form-inline">
                                                 @if($row->active == '0')
                                                <a class="list-icons-item text-primary" href="{{ route("edit_kpi", $row->id)}}"  onclick="return confirm('Are you sure?')"> Edit </a>&nbsp&nbsp&nbsp&nbsp
                                                 <a class="list-icons-item text-danger" href="{{ route("close_kpi", $row->id)}}"  onclick="return confirm('Are you sure?')"> Close </a>&nbsp&nbsp&nbsp&nbsp
                                                @endif
                                        <a class="list-icons-item text-success" href="#" data-toggle="modal" data-target="#appFormModal" onclick="model({{ $row->id }},'view-result')"> Show </a>&nbsp

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
             "ordering": false,
            "columnDefs": [
                {"targets": [1]}
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


        $.ajax({
            type: 'GET',
            url: '{{url("performance/performanceModal")}}',
            data: {
                'id': id,
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