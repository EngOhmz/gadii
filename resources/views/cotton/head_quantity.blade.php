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

                                                <th >#</th>
                                                                 <th>Stock Reference</th>
                                                    <th >Moved From</th>
                                                    <th > Quantity</th>
                                             
                                            </tr>
                                        </thead>
                                        <tbody>
<?php
                        $total_q=0; 
                   $total_m=0;    
                     $total_b=0;  
                                                                   
?>
                                            @if(!@empty($main))
                                            @foreach ($main as $row)
                                  @if($row->due_quantity < $row->quantity)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>                                              
                                                 <td>{{ $row->reference }}</td>
                                                <td>{{ $row->center->name }}</td>
                                          <td>{{number_format($row->quantity - $row->due_quantity,2) }}</td>
                                              @php    
                   $total_q+= $row->quantity - $row->due_quantity; 

                 @endphp
                                                
                                            </tr>
 @endif
                                            @endforeach

                                            @endif

                                        </tbody>

<tfoot>

<tr>
 <td></td> 
                    <td><b>Total</b></td>
                                  
       <td> </td>
        <td >{{number_format( $total_q,2)}} </td>
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


