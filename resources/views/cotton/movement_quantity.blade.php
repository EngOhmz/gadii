<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Quantity</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

 <div class="modal-body">

             <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 98.531px;">#</th>
                                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 108.1094px;">Stock Reference</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;"> Quantity</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Price</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 108.1094px;">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
                        $total_q=0; 
                   $total_m=0;    
                     $total_b=0;  
                                                                   
?>
                                            @if(!@empty($movement))
                                            @foreach ($movement as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>                                              
                                                 <td>{{ $row->cotton->reference }}</td>
                                                <td>{{ number_format($row->quantity,2) }}</td>
                                      <td>{{ number_format($row->price,2) }}</td>
                                          <td>{{number_format($row->total_cost,2) }}</td>
                                         
                                              @php    
                   $total_q+= $row->quantity; 
                   $total_m+=$row->total_cost;   
                 @endphp
                                                
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>

<tfoot>

<tr>
 <td></td> 
                    <td><b>Total</b></td>
                  
                    
        <td >{{number_format($total_q,2)}} </td>                 
       <td> </td>
        <td >{{number_format( $total_m,2)}} </td>
   </tr> 



<tfoot>
                                    </table>
                                </div>
                                                    </div>




        
        <div class="modal-footer bg-whitesmoke br">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


     


    </div>
</div>


