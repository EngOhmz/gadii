
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">   Loan Details</h5>
               
             

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
       
        <div class="modal-body">

      <div class="table-responsive">
                                     <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Loan Amount</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>                                         

                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php
                                           $total=0;
                                               ?>
                                            @if(!@empty($loan_details))
                                            @foreach ($loan_details as $loan)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                               <td>  <?php echo date('Y M', strtotime($loan->deduct_month)) ?></a></td>
                                                <td>{{number_format($loan->loan_amount,2)}}</td>
                                              
  
                                             
                                        <td>
                                               @if ($loan->status == '0') 
                                                    <span class="badge badge-warning badge-shadow">Pending </span>
                                                @elseif ($loan->status == '1') 
                                                    <span class="badge badge-success badge-shadow">Accepted </span>
                                                @elseif ($loan->status == '2') 
                                                   <span class="badge badge-danger badge-shadow">Rejected </span>
                                                @else
                                                  <span class="badge badge-info badge-shadow">Paid </span>
                                                 @endif
                                               </td>
                                                     
                                            </tr>
                                            <?php
                                       $total+=$loan->loan_amount;
                                          ?>
                                            @endforeach

                                            @endif

                                        </tbody>              
                                    <tfoot>
                                     <tr> 
    <td></td>     
      <td><b>Total Amount</b></td>                     
         <td><b>{{number_format($total , 2) }}</b></td>
            <td></td>    
                    </tr> 
                                <tfoot>
                                    </table>
                                </div>



        </div>
        <div class="modal-footer">
        
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        </form>
    </div>
