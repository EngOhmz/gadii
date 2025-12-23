@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Fuel Report</h4>
                    </div>
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>


        <div class="panel-heading">
            <h6 class="panel-title">
            
                @if(!empty($start_date))
                    For the period: <b><?php echo date('F Y', strtotime($start_date)) ?></b>
                @endif
            </h6>
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">

                <div class="col-md-4">
                    <label class="">Month</label>
                  
 <input required type="month"  class="form-control monthyear" name="start_date" data-format="yyyy/mm/dd" value="<?php
                                if (!empty($start_date)) {
                    echo $start_date;
                } else {
                    echo date('Y-m');
                }  
                        ?>">
          </div>        

   <div class="col-md-4">
                      <br><button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div>                  
                </div>
           
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br> <br>
@if(!empty($start_date))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">
                
                

                    <table class="table datatable-basic table-striped" id="tableExport" style="width:100%;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th> Date</th>
                        <th> Truck</th>
                            <th>Route </th>
                            <th>Fuel Used</th>
                        </tr>
                        </thead>
                        <tbody>

                       <?php
                        $cr = 0;
                        ?>
                        @foreach($data as $key)
                        
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                  <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}} </td>
                                    <td>{{ $key->truck->reg_no }}</td>
                                    <td>From {{$key->route->from}} to {{$key->route->to}}</td>
                                <td>{{ $key->fuel_used}} Litres</td>  

                                
                            </tr>
                        
                            <?php
                        $cr += $key->fuel_used;
                        ?>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="custom-color-with-td">
                                   <td></td>  <td></td><td></td>  
                                <td ><b>Total</b></td>
                                <td><b>{{ number_format($cr,2) }} Litres</b></td>

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
            </div>
        </div>

    </div>
</section>



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
          {extend: 'copyHtml5',title: 'FUEL REPORT ', footer: true},
           {extend: 'excelHtml5',title: 'FUEL REPORT' , footer: true},
           {extend: 'csvHtml5',title: 'FUEL REPORT' , footer: true},
            {extend: 'pdfHtml5',title: 'FUEL REPORT', footer: true},
            {extend: 'print',title: 'FUEL REPORT' , footer: true}

                ],
        }
      );
     
    </script>

@endsection