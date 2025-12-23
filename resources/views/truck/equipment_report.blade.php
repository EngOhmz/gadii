@extends('layouts.master')



@section('content')
    <section class="section" id="nonPrintable">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Equipment Report</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                               
                              
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-button-html5-basic" id="itemsDatatable">
                                            <thead>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Browser: activate to sort column ascending"
                                                        style="width: 28.531px;">No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Assigned</th>
                                                   
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Disposed</th>
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Available</th>
                                                    

                                            </thead>
                                            <tbody>


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

<!-- Modal -->
 @foreach($list as $key)
  <div class="modal fade " data-backdrop=""  id="viewa{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Assigned Balance<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                                        <?php
                                        $q =0; $r =0;
                                            ?>
                           <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Item</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Date</th>                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Qty</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Truck</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 120.484px;">Staff</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Cost</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                   
                                          $account =App\Models\EquipmentList::leftJoin('truck_equipment_items', 'equipment_list.issue_id','truck_equipment_items.issue_id')
                                                      ->where('truck_equipment_items.brand_id', $key->id)
                                                       ->where('equipment_list.status',1)     
                                                       ->select('truck_equipment_items.*','equipment_list.*')
                                                          ->get()  ;
                                            ?>  
                                         @foreach($account  as $a)
                                                         <tr>
                                               <td>{{$loop->iteration }}</td>
                                               <td>{{$a->serial_no }}</td>
                                               <td>{{Carbon\Carbon::parse($a->date)->format('d/m/Y') }}</td>
                                               <td>{{ number_format($a->quantity ,2) }}</td>
                                               <td>@if(!empty($a->truck_id)) {{ $a->truck->truck_name }} -  {{ $a->truck->reg_no }} @endif</td>
                                               <td>@if(!empty($a->staff)) {{$a->approve->name}} @endif</td>
                                               <td >{{ number_format($a->cost ,2) }}</td>
                                              
                                            </tr> 
                                            
                                            
                                            <?php
                                        $q +=$a->quantity; $r += $a->cost;
                                            ?>  
                        
                          @endforeach
                            </tbody>
                         
                         
                        <tfoot>
                                            <tr>     
                                                <td></td> <td ></td>
                                                <td><b> Total</b></td>
                                                <td><b>{{ number_format($q ,2) }}</b></td>
                                                <td></td> <td></td>
                                                <td><b>{{ number_format($r ,2) }}</b></td>
                                                
                                            </tr> 
                        
                                              
                         
                                                      </tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>

@endforeach



 @foreach($list as $key)
  <div class="modal fade " data-backdrop=""  id="viewd{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Disposed Balance<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                                        <?php
                                        $q =0; $r =0;
                                            ?>
                           <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Item</th>
                                                                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Qty</th>
                                                   
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                   
                                          $account =App\Models\EquipmentList::where('brand_id', $key->id)->where('status',1)->get()  ;
                                            ?>  
                                         @foreach($account  as $a)
                                                         <tr>
                                               <td>{{$loop->iteration }}</td>
                                               <td>{{$a->serial_no }}</td>
                                               <td>{{ number_format(1 ,2) }}</td>
                                              
                                            </tr> 
                                            
                                            
                                            <?php
                                        $q +=1;
                                            ?>  
                        
                          @endforeach
                            </tbody>
                         
                         
                        <tfoot>
                                            <tr>     
                                                <td></td>
                                                <td><b> Total</b></td>
                                                <td><b>{{ number_format($q ,2) }}</b></td>
                                               
                                                
                                            </tr> 
                        
                                              
                         
                                                      </tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>

@endforeach



 @foreach($list as $key)
  <div class="modal fade " data-backdrop=""  id="viewq{{$key->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg"><div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$key->name}} Available Balance<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
                                        <?php
                                        $q =0; $r =0;
                                            ?>
                           <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 30.531px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Item</th>
                                                                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 100.484px;">Qty</th>
                                                   
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                   
                                          $account =App\Models\EquipmentList::where('brand_id', $key->id)->where('status',0)->get()  ;
                                            ?>  
                                         @foreach($account  as $a)
                                                         <tr>
                                               <td>{{$loop->iteration }}</td>
                                               <td>{{$a->serial_no }}</td>
                                               <td>{{ number_format(1 ,2) }}</td>
                                              
                                            </tr> 
                                            
                                            
                                            <?php
                                        $q +=1;
                                            ?>  
                        
                          @endforeach
                            </tbody>
                         
                         
                        <tfoot>
                                            <tr>     
                                                <td></td>
                                                <td><b> Total</b></td>
                                                <td><b>{{ number_format($q ,2) }}</b></td>
                                               
                                                
                                            </tr> 
                        
                                              
                         
                                                      </tfoot>
                            </table>
                           </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div></div>
  </div>

@endforeach
    
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/jquery.dataTables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/css/buttons.dataTables.min.css') }}">

    <script src="{{ asset('assets/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/datatables/js/buttons.print.min.js') }}"></script>
    
    
    
</script>
    
    
    

    <script>
        $(function() {
            let urlcontract = "{{ route('equipment.report') }}";
            
           
            
            $('#itemsDatatable').DataTable({
                processing: true,
                serverSide: false,
                searching: true,
                "dom": 'lBfrtip',
                "columnDefs": [{
                "orderable": false,
                "targets": [0]
            }],

                buttons: [{
                        extend: 'copyHtml5',
                        title: 'Equipment Report ',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                      
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        title: 'Equipment Report',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                       
                        footer: true
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Equipment Report',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Equipment Report',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)',
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        title: 'Equipment Report',
                        exportOptions: {
                            columns: ':visible :not(.always-visible)'
                        },
                        footer: true
                    }

                ],

                type: 'GET',
                ajax: {
                    url: urlcontract,
                    data: function(d) {
                        d.start_date = $('#date1').val();

                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'assign',
                        name: 'assign'
                    },
                   
                    {
                        data: 'dispose',
                        name: 'dispose'
                    },
                   
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },

                ],
            })
        });


    </script>




    
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "orderable": false,
                "targets": [0]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
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

        });
    </script>

    

    
    
    
@endsection
