@extends('layouts.master')


@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>


 <script>
    jQuery(document).ready(function($) {
      $('#example').DataTable(
        {
        searching: false,
        dom: 'Bfrtip',
        buttons: [
                    { extend: 'copy', footer: true },
                    
                    { extend: 'excel', footer: true},
                    
                    { extend: 'csv', footer: true },
                    
                    { extend: 'pdf', footer: true },
                   
                    { extend: 'print', footer: true }
                ],
        }
      );
     
    } );
    </script>

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Courier Tracking</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">  Courier Tracking
                                    List</a>
                            </li>
                       

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">

<br>

        <div class="panel-heading">

            
        </div>

<br>
        <div class="panel-body hidden-print">
            {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form')) !!}
            <div class="row">
             <div class="col-sm-12 ">

                <div class="form-group row"><label  class="col-lg-2 col-form-label">Courier Reference</label>
                                                           
                 <div class="col-lg-5">
                   <input  name="reference" type="text" class="form-control"  required value="{{ isset($reference) ? $reference : ''}}" placeholder="Courier Reference No">

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
                         <th> Ref No</th>
                           <th> Tariff</th>
                          <th>Status</th>
                                <th>Notes</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                           

                        @foreach($data as $key)

                            <tr>
                                  <td>{{Carbon\Carbon::parse($key->date)->format('d/m/Y')}} </td>
                             <td>{{$key->courier->confirmation_number}} </td> 
                                    <td>{{$courier->route->from}} - {{$courier->route->to}}</td>
                                       <td>
                                        @if($key->activity =='Confirm Pickup')
                                          Package Picked Up
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
             order: [[0, 'desc']],
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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection