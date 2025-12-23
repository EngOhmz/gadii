@extends('layouts.master')



@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Expired Users </h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>
                                                   <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                   <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 160.484px;">Full Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Registered</th>
                                                   <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                   style="width: 150.484px;">Role</th> 
                                                   <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Phone</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Due Date</th>
                                                    <th class="always-visible" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 90.484px;">Action</th>

                                               

                                            </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($data as $key)
                                         
                                        
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>@if(!empty($key->users->name)){{ $key->users->name }}@endif</td>
                                 <td>{{Carbon\Carbon::parse($key->created_at)->format('d/m/Y g:i:s A')}}</td>
                                <td>{{ $key->roles->slug }}</td>
                                <td>@if(!empty($key->users->phone)){{ $key->users->phone }}@endif</td>
                                <td>{{Carbon\Carbon::parse($key->due_date)->format('d/m/Y')}}</td>
                                <td><a class="nav-link" onclick="model({{ $key->id }},'sms')" href="" data-toggle="modal" data-target="#appFormModal">SMS</a></td>
                            </tr>
                             
                        @endforeach

                                           

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

 <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-lg">

        </div>
    </div>


@endsection



@section('scripts')

<link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

<script src="{{asset('assets/datatables/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/datatables/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/datatables/js/buttons.print.min.js')}}"></script>
<script>

      $('.datatable-basic').DataTable(
        {
        dom: 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'EXPIRED USERS',exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
           {extend: 'excelHtml5',title: 'EXPIRED USERS' ,exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
           {extend: 'csvHtml5',title: 'EXPIRED USERS' , exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
            {extend: 'pdfHtml5',title: 'EXPIRED USERS',exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
            {extend: 'print',title: 'EXPIRED USERS' , exportOptions:{columns: ':visible :not(.always-visible)'},footer: true}

                ],
        }
      );
     
    </script>


 <script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-b').select2({ width: '100%', });



        });
    </script>
    
    <script type="text/javascript">
        function model(id, type) {
        var start_date = $('.start').val();
        var end_date = $('.end').val();
            $.ajax({
                type: 'GET',
                url: '{{ url('subscription/subModal') }}',
                data: {
                    'id': id,
                    'type': type,
                    'start_date':start_date,
                     'end_date':end_date,
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

@endsection