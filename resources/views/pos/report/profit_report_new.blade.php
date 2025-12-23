@extends('layouts.master')
@section('content')
<section class="section">
    <div class="card">
        <div class="card-body text-primary">
            <h2 class="h3 mb-0 text-gray-800"><img width="50" height="50"
                    src="https://img.icons8.com/ios-filled/50/40C057/total-sales-1.png"/> Profit Report</2>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <br>
                                <div class="panel-heading">
                                
                                    <h6 class="panel-title"  style="font-family: 'Dancing Script', cursive;font-weight: bold; 
                                    background: linear-gradient(to right, #4CAF50, #2196F3); -webkit-background-clip: text; -webkit-text-fill-color:transparent;">

                                        @if(!empty($start_date))
                                        For the period: <b>{{Carbon\Carbon::parse($start_date)->format('d/m/Y')}} to
                                            {{Carbon\Carbon::parse($end_date)->format('d/m/Y')}}</b>
                                        @endif
                                    </h6>
                                </div>

                                <br>
                                <div class="panel-body hidden-print">
                                    {!! Form::open(array('url' => '#', 'method' => 'post','class'=>'form-horizontal',
                                    'name' => 'form')) !!}
                                    <div class="row">

                                        <div class="col-md-4">
                                            <label class="">Start Date</label>
                                            <input name="start_date" id="start_date" type="date"
                                                class="form-control date-picker" required value="<?php
                                                if (!empty($start_date)) {
                                                    echo $start_date;
                                                } else {
                                                    echo date('Y-m-d', strtotime('first day of january this year'));
                                                }
                                                ?>">

                                        </div>
                                        <div class="col-md-4">
                                            <label class="">End Date</label>
                                            <input name="end_date" id="end_date" type="date"
                                                class="form-control date-picker" required value="<?php
                                                if (!empty($end_date)) {
                                                    echo $end_date;
                                                } else {
                                                    echo date('Y-m-d');
                                                }
                                                ?>">
                                        </div>

                                        {{--<?php $a=  trim(json_encode($x), '[]');  ?>--}}



                                        <div class="col-md-4">
                                            <label class="">Location</label>

                                            <select name="location_id" class="form-control m-b location"
                                                id="location_id" required>
                                                <option value="">Select Location</option>
                                                @if(!empty($location[0]))

                                                @foreach($location as $br)
                                                <option value="{{$br->id}}" @if(isset($location_id)){{
                                                    $location_id==$br->id ? 'selected' : ''}} @endif>{{$br->name}}
                                                </option>
                                                @endforeach
                                                <option value="all">All Location</option>
                                                @endif
                                            </select>

                                        </div>


                                        <div class="col-md-4">
                                            <br><button type="submit" class="btn btn-success"
                                                id="btnFiterSubmitSearch">Search</button>
                                                
                                            <a href="{{Request::url()}}" class="btn btn-danger" >Reset</a>
                                            <br>
                                           

                                        </div>
                                    </div>

                                    {!! Form::close() !!}

                                </div>

                                <!-- /.panel-body -->



                                <br>
                                
                                @if(!empty($start_date))

                                <div class="panel panel-white">
                                    <div class="panel-body ">
                                        <div class="table-responsive">


                                            <table  id="datatable-basic2"  class="display">
                                                <thead>
                                                    <tr>
                                                         <th>#</th>
                                                         <th>Name</th>
                                                         <th>Sales Balance</th>
                                                         <th>Cost Balance</th>
                                                         <th>Total Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($data))
                                                    @foreach ($data as $flist)
                                                        <tr class="gradeA even" role="row">
                                                            <td>{{ $loop->iteration }}</td>
                                                            
                                                            @if(!empty($flist->color) && empty($flist->size))
                                                                <td> {{$flist->name .' - '.$flist->color }}</td>
                                                                  
                                                              @elseif(empty($flist->color) && !empty($flist->size))
                                                                  <td>{{ $flist->name .' - '.$flist->size}} </td>
                                                               
                                                               
                                                               @elseif(!empty($flist->color) && !empty($flist->size))
                                                                    <td> {{$flist->name .' - '.$flist->color . ' - '.$flist->size}} </td>
                                                                    
                                                               
                                                               
                                                               @else
                                                                   
                                                                <td> {{ $flist->name }} </td>
                                                                @endif
                                                            
                                                            <td>{{ number_format($flist->sales_qty,2) }}</td>    
                                                            <td>{{ number_format($flist->cost_qty,2) }}</td>
                                                            <td>{{ number_format($flist->sales_qty - $flist->cost_qty  ,2) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    @endif
                                                      
                                                </tbody>
                                                <tfoot>
                                                   <tr>
                                                   <td></td>
                                                    <td>Total</td>
                                                    <td><?php echo number_format($totalData[0]->total_sales_qty,2); ?></td>
                                                    <td><?php echo number_format($totalData[0]->total_cost_qty,2); ?></td>
                                                    <td><?php echo number_format($totalData[0]->total_profit,2); ?></td>
                                                                                    
                                                    </tr>
                                                </tfoot>
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
</section>

<!-- Modal -->

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
        $(document).ready(function() {
            // Destroy existing DataTable instance if it exists
            if ($.fn.DataTable.isDataTable('#datatable-basic2')) {
                $('#datatable-basic2').DataTable().destroy();
            }

            // Initialize DataTable
            $('#datatable-basic2').DataTable({
                autoWidth: false,
                columnDefs: [
                    { orderable: false, targets: [1] }
                ],
                dom: '<"datatable-header"flB><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 
                        'first': 'First', 
                        'last': 'Last', 
                        'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 
                        'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' 
                    }
                },
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: 'Copy',
                        footer: true,
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        footer: true,
                        className: 'btn btn-info'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        footer: true,
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        footer: true,
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        footer: true,
                        className: 'btn btn-primary'
                    }
                ]
            });
        });
    </script>


@endsection