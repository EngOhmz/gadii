@extends('layouts.master')


@section('content')
        
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Subscription List</h4>
                    </div>
                    <div class="card-body">
                      
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>
        <div class="panel-heading">
            <h6 class="panel-title">
              
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

             
                <div class="col-md-4">
                    <label class="">Users</label>
                   <select class="form control m-b account" id="account_id" name="account_id" required>
                   <option value="">Select Account</option>
                   @foreach($chart_of_accounts as $chart)
                   <option value="{{$chart->id}}" @if(isset($account_id)){{  $account_id == $chart->id  ? 'selected' : ''}} @endif>{{$chart->name}} - {{$chart->phone}} </option>
                   @endforeach
                   
                   </select>
                </div>

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
@if(!empty($account_id))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">
                
                                    
                                    
                     <table class="table datatable-button-html5-basic">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                             <th>Phone No</th>
                            <th> Role</th>
                            <th>Due Date</th>
                             <th>Daily</th>
                            <th>Monthly</th>
                            <th>Yearly</th>
                            <th class="always-visible">Action</th>
                        </tr>
                        </thead>
                        <tbody>
<?php
$dr=0;
$cr=0;
?>
                        @foreach($data as $key)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{Carbon\Carbon::parse($key->created_at)->format('d/m/Y')}}</td>
                                <td>{{ $key->users->phone }}</td>
                                  <td>{{ $key->roles->slug }}</td>
                                <td>{{Carbon\Carbon::parse($key->due_date)->format('d/m/Y')}}</td>
                                 <td>{{ number_format($key->day) }}</td>
                                 <td>{{ number_format($key->month) }}</td>
                                 <td>{{ number_format($key->year) }}</td>
                                 <td>
                   
                   
                    <div class="dropdown">
                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                     <div class="dropdown-menu">

                      <a class="nav-link" id="profile-tab2" onclick="model({{ $key->id }},'price')" href="" data-toggle="modal" data-target="#appFormModal" aria-selected="false">Adjust</a>
                     <a class="nav-link" id="profile-tab2" onclick="model({{ $key->id }},'deposit')" href="" data-toggle="modal" data-target="#appFormModal" aria-selected="false">Deposit</a>
                                                    
                                                                        </div>
                                                                    </div>

                                                                           
                                
                                </td>
                            </tr>

                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
            <!-- /.panel-body -->
             </div>
    @endif              

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

      $('.datatable-button-html5-basic').DataTable(
        {
        dom: 'lBfrtip',

        buttons: [
          {extend: 'copyHtml5',title: 'SUBSCRIPTION LIST',exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
           {extend: 'excelHtml5',title: 'SUBSCRIPTION LIST' ,exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
           {extend: 'csvHtml5',title: 'SUBSCRIPTION LIST' , exportOptions:{columns: ':visible :not(.always-visible)'},footer: true},
            {extend: 'pdfHtml5',title: 'SUBSCRIPTION LIST',exportOptions:{columns: ':visible :not(.always-visible)'}, footer: true},
            {extend: 'print',title: 'SUBSCRIPTION LIST' , exportOptions:{columns: ':visible :not(.always-visible)'},footer: true}

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