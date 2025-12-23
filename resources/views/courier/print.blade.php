   


    <div class="modal-content">
        <div class="modal-header hidden-print">
            <h5 class="modal-title" id="formModal">{{$data->confirmation_number}} Barcode</h5>
            
            
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

      
          <?php
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();

?> 
       <div class="modal-body print" id="printableArea">
          <div class="container mt-4" id="barprint">
          
           <div class="table-responsive">
                                       <table class="table datatable-modal table-borderless" >
                                       
                                        


                                        <thead style="display:none;">
                                            <tr>
                                            <th></th>
                                            <th></th>
                                            </tr>
                                        </thead>
                                            
                                            <tbody>
                                            
                                       <tr>
        <td style="text-align:center;"><img class="pl-lg" style="width: 120px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}"></td>
   
        <td>
                <div class="box-text">
                    <p>{{$settings->name}}</p>
                    <p>{{ $settings->address }}</p>               
                    <p>Contact :{{  $settings->phone}}</p>
                 <p>Email: <a href="mailto:{{$settings->email}}">{{$settings->email}}</p>
                   
                </div>
            </td>
                  
         </tr>      
                                            
            <tr>
            <td class="always-visible" style="display:none;"></td>
                    
            <td colspan="2" style="text-align:center;" ><?php echo ' <img src="data:image/png;base64,' . DNS1D::getBarcodePNG($data->pacel_number, 'CODABAR',1,33,array(1,1,1), true) . '" alt="barcode"   />'; ?></td>
                    </tr>

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
         
          
            {extend: 'print',title: '{{$data->confirmation_number}} Barcode' , exportOptions: { stripHtml: false, } }

                ],
        }
      );
     
    </script>
