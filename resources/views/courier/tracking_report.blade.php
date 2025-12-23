@extends('layouts.master')


@section('content')


<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
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

                <div class="form-group row"><label  class="col-lg-2 col-form-label">Courier WB No</label>
                                                           
                 <div class="col-lg-6">
                  <div class="input-group mb-3">
                   <input name="reference" id="reference" type="text" class="form-control"  required value="{{ isset($reference) ? $reference : ''}}" placeholder="Courier WB No or Scan Package">
               &nbsp

                <button class="btn btn-outline-secondary scan" type="button"><i class="icon-barcode2"> </i> Scan Package</button>

                                                            </div>
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

   <br> <br>
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



@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
           "ordering": false,
             "columnDefs": [
                {"orderable": false, "targets": [0,1,2,3,4]}
            ],
           dom: '<"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
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
    
     <script type="text/javascript">
       $(document).ready(function(e) {

            $(document).on('click', '.scan', function(e) {
               
    $('#reference').val('');  // Input field should be empty on page load
    $('#reference').focus();  // Input field should be focused on page load 
e.preventDefault(); 
            });
            
        
 
        });
    </script>
@endsection