<!DOCTYPE html>
<html lang="en">
<?php
$settings= App\Models\System::first();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EMA ERP - by Ujuzinet</title>


    <!-- Core JS files -->
    <script src="asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{asset('assets2/js/app.js') }}"></script>
    <!-- /theme JS files -->

<!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets2/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('assets2/css/datepicker.min.css')}}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/css/dataTables.dateTime.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/dataTables.dateTime.min.css')}}">
    <!-- /global stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <!-- Core JS files -->
  


</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-static">

        <div class="navbar-brand ml-2 ml-lg-0">
            <a href="index.html" class="d-inline-block">
                <img src="{{url('assets/img/logo')}}/{{!empty($settings->picture) ? $settings->picture: ''}}" alt="">            {{ !empty($settings->name) ? $settings->name: ''}}
            </a>
        </div>

        <div class="d-flex justify-content-end align-items-center ml-auto">
            <ul class="navbar-nav flex-row">

   <li class="nav-item">
                    <a href="{{route('login')}}" class="navbar-nav-link">
                        <i class="icon-user-lock"></i>
                        <span class="d-none d-lg-inline-block ml-2">Login</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a  href="{{route('register')}}" class="navbar-nav-link">
                        <i class="icon-user-plus"></i>
                        <span class="d-none d-lg-inline-block ml-2">Register</span>
                    </a>
                </li>
             
            </ul>
        </div>
    </div>
    <!-- /main navbar -->
    
     <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            
<!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content">
<section class="section">
    <div class="section-body">
        <div class="row">
        <div class="col-1 col-sm-3 col-lg-1"></div>
            <div class="col-10 col-sm-6 col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <h4> Courier Tracking</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>

        <div class="panel-heading">

            
        </div>

        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">
             <div class="col-sm-12 ">

               <div class="form-group row"><label  class="col-lg-2 col-form-label">Courier Reference</label>
                                                           
                 <div class="col-lg-5">
                   <input  name="reference" type="text" class="form-control"  required value="{{ isset($reference) ? $reference : ''}}" placeholder="Courier Reference">

                </div> 

              <div class="col-lg-4">
                      <button type="submit" class="btn btn-success">Search</button>
                        <a href="{{Request::url()}}"class="btn btn-danger">Reset</a>

                </div> 
              </div>


  
                 
                </div>
           </div>
            {!! Form::close() !!}

        </div>

        <!-- /.panel-body -->

   <br>
@if(!empty($reference))
        <div class="panel panel-white">
            <div class="panel-body ">
                <div class="table-responsive">

                   <table class="table  table-striped" id="example" style="width:100%;">
                        <thead>
                        <tr>
                         <th> Date</th>
                         <th> WB No</th>
                           <th> Tariff</th>
                             <th> Location</th>
                          <th>Status</th>
                                <th>Notes</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                           

                        @foreach($data as $key)

                             @php
                                            $pacel=App\Models\Courier\CourierCollection::find($key->collection_id); 
                                            $route = App\Models\Tariff::find($pacel->tariff_id); 
                                            $start = App\Models\Region::find($pacel->start_location); 
                                           $end = App\Models\Region::find($pacel->end_location); 
                                        @endphp

                            <tr>
                                  <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}} </td>
                             <td>{{$key->wbn_no}} </td> 
                                 
                                       <td>{{$start->name}} - {{$end->name}} </td>                                              
                                           <td> @if(!empty($route->zone_name)) {{$route->zone_name}} - {{$route->weight}} @else {{$pacel->tariff_id }} @endif</td>
                                        <td>
                                        @if($key->activity =='Confirm Pickup')
                                          Package Picked
                                     @elseif($key->activity =='Confirm Packaging')
                                          Package Packed
                                         @elseif($key->activity =='Confirm Freight')
                                            Package Freighted
                                          @elseif($key->activity =='Confirm Commission')
                                            Package Commissioned
                                           @elseif($key->activity =='Confirm Delivery')
                                              Package Delivered      
                                                    @endif
                                         </td> 
                                <td>{{$key->notes}} </td>  
                          
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
</div>

 <!-- Footer -->
                <div class="navbar navbar-expand-lg navbar-light">
                    <div class="text-center d-lg-none w-100">
                        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                            data-target="#navbar-footer">
                            <i class="icon-unfold mr-2"></i>
                            Footer
                        </button>
                    </div>

                    <div class="navbar-collapse collapse" id="navbar-footer">
                        <span class="navbar-text">
                            &copy; <?php echo date('Y'); ?> <a href="#">EMA ERP</a> by <a
                                href="https://ema.co.tz/" target="_blank">Ujuzinet  Company Limited</a>
                        </span>

                        <ul class="navbar-nav ml-lg-auto">
                            <li class="nav-item"><a href="https://ema.co.tz/" class="navbar-nav-link"
                                    target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
                            <li class="nav-item"><a href="https://ema.co.tz/"
                                    class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i>
                                    Docs</a></li>
                            <li class="nav-item"><a
                                    href="https://ema.co.tz/"
                                    class="navbar-nav-link font-weight-semibold"><span class="text-pink"><i
                                            class="icon-cart2 mr-2"></i> Purchase</span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /footer -->
                
                </div>
            <!-- /inner content -->
                
                  </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->
                
                

<script src="{{ asset('assets2/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets2/js/bootbox.min.js') }}"></script>
	<!-- /core JS files -->
		<!-- Theme JS files -->
 <script src="{{url('assets/js/dateTime.min.js')}}"></script>

	<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

	<script src="{{asset('global_assets/js/demo_pages/datatables_basic.js')}}"></script

<script type="text/javascript" src="{{asset('assets2/js/downloadFile.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>

   <script src="https://logistic.ema.co.tz/assets/bundles/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{asset('assets/jQuery/jQuery.print.js')}}"></script>

    {!! Html::script('plugins/table/datatable/datatables.js') !!}
    <!--  The following JS library files are loaded to use Copy CSV Excel Print Options-->
    {!! Html::script('plugins/table/datatable/button-ext/dataTables.buttons.min.js') !!}
    {!! Html::script('plugins/table/datatable/button-ext/jszip.min.js') !!}
    {!! Html::script('plugins/table/datatable/button-ext/buttons.html5.min.js') !!}
    {!! Html::script('plugins/table/datatable/button-ext/buttons.print.min.js') !!}
    <!-- The following JS library files are loaded to use PDF Options-->
    {!! Html::script('plugins/table/datatable/button-ext/pdfmake.min.js') !!}
    {!! Html::script('plugins/table/datatable/button-ext/vfs_fonts.js') !!}
	{!! Html::script('global_assets/js/main/bootstrap.bundle.min.js') !!}
   
    <script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
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
    jQuery(document).ready(function($) {
      $('#example').DataTable(
        {
        searching: false,
         "ordering": false,
        dom: 'lBfrtip',
        buttons: [
          {extend: 'copyHtml5',title: 'COURIER TRACKING FOR {{ isset($reference) ? $reference : ''}} ', footer: true},
           {extend: 'excelHtml5',title: 'COURIER TRACKING FOR {{ isset($reference) ? $reference : ''}}' , footer: true},
           {extend: 'csvHtml5',title: 'COURIER TRACKING FOR {{ isset($reference) ? $reference : ''}}' , footer: true},
            {extend: 'pdfHtml5',title: 'COURIER TRACKING FOR {{ isset($reference) ? $reference : ''}}', footer: true},
            {extend: 'print',title: 'COURIER TRACKING FOR {{ isset($reference) ? $reference : ''}}' , footer: true}
                ],
        }
      );
     
    } );
    </script>
	

</body>


</html>