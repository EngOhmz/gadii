   


    <div class="modal-content">
        <div class="modal-header hidden-print">
            <h5 class="modal-title" id="formModal">{{$data->name}} Barcode</h5>
            
            
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

      
          
       <div class="modal-body print" id="printableArea">
          <div class="container mt-4" id="barprint">
          
           <div class="table-responsive">
                                       <table class="table datatable-modal table-borderless" >
                                       
                                        

                                        <thead style="display:none;">
                                            <tr>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 38.531px;"></th>

                                              
                                            </tr>
                                        </thead>
                                            
                                            <tbody>
                    <td colspan="3" style="text-align: center">
                    @if($data->barcode_type == 'QRCODE')
                     <?php echo ' <img src="data:image/png;base64,' . DNS2D::getBarcodePNG($data->barcode, 'QRCODE') . '" alt="barcode"   />'; ?>
                    
                     @else
                     <?php echo ' <img src="data:image/png;base64,' . DNS1D::getBarcodePNG($data->barcode, 'CODABAR',1,33,array(1,1,1), true) . '" alt="barcode"   />'; ?>
                     @endif
                    </td>

                                            </tbody>
                                        </table>
                                    </div>

             
    </div>
          


        </div>
  
     
    </div>


@yield('scripts')

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

      $('.datatable-modal').DataTable(
        {
        dom: 'Brt',

        buttons: [
         
          
            {extend: 'print',title: '{{$data->name}} Barcode' , exportOptions: { stripHtml: false } }

                ],
        }
      );
     
    </script>
