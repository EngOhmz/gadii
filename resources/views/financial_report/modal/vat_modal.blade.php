<div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"  style="text-align:center;"> {{$account_code->account_codes }} - {{$account_code->account_name }}<h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>


        <div class="modal-body">
  <div class="table-responsive">
  
  <?php
                        $cr_in = 0;
                        $dr_in = 0;                   
                        $cr_out  = 0;
                        $dr_out  = 0;
                        $total_vat=0;
                           $total_out=0;
                             $total_in=0;
                             ?>
                             
                             
                                                        <table class="table datatable-vi table-striped"><h4>VAT IN </h4>
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                    </tr>
                    </thead>
 <tbody>   
 <?php
                         $vat_in = \App\Models\AccountCodes::where('account_name', 'VAT IN')->where('added_by',auth()->user()->added_by)->first();
                         
                         if(!empty($branch_id) && $branch_id != $a){
                       $account = \App\Models\JournalEntry::where('account_id', $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                            
                          }
                          else{
                              
                         $account = \App\Models\JournalEntry::where('account_id', $vat_in->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                          }
                        
                            
                       
                        ?>  
                 @foreach($account  as $ac)
                                 <tr>
                        <td >{{Carbon\Carbon::parse($ac->date)->format('d/m/Y') }}</td>
                          <td>{{ number_format($ac->debit ,2) }}</td>
                   <td >{{ number_format($ac->credit ,2) }}</td>
                       <td >{{ $ac->notes }}</td>
                    </tr> 

                @endforeach
     </tbody>           
            
    
 <?php
 
if(!empty($branch_id) && $branch_id != $a){
                          $cr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                          }
                          else{
                              
                              $cr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_in = \App\Models\JournalEntry::where('account_id',  $vat_in->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                          }
                   
                      
                            
                       $vat_in= $dr_in- $cr_in;


                        ?> 
                        
                        <tfoot>
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr_in,2) }}</b></td>
                            <td><b>{{ number_format($cr_in,2) }}</b></td>
                             <td></td>
                             
                    </tr> 
                    
                     <tr>     
                        <td >
                            <b>VAT IN Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format(abs($vat_in),2) }}</b></td>
                            
                             
                    </tr> 
 
                        </tfoot>
                            </table>


                            <table class="table datatable-vo table-striped"><h4>VAT OUT </h4>
<thead>
                    <tr>
                       <th>Date</th>
                            <th>Debit</th>
                        <th>Credit</th>
                      <th>Note</th>
                    </tr>
                    </thead>
 <tbody>   
 <?php
                         $vat_out = \App\Models\AccountCodes::where('account_name', 'VAT OUT')->where('added_by',auth()->user()->added_by)->first();
                         
                         
                                if(!empty($branch_id) && $branch_id != $a){
                        $account_out = \App\Models\JournalEntry::where('account_id', $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                            
                          }
                          else{
                              
                          $account_out = \App\Models\JournalEntry::where('account_id', $vat_out->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->orderBy('date','desc')->get();
                          }
                          
                        
                            
                       
                        ?>  
                 @foreach($account_out  as $a_out)
                                 <tr>
                        <td >{{Carbon\Carbon::parse($a_out->date)->format('d/m/Y') }}</td>
                          <td>{{ number_format($a_out->debit ,2) }}</td>
                   <td >{{ number_format($a_out->credit ,2) }}</td>
                       <td >{{ $a_out->notes }}</td>
                    </tr> 

                @endforeach
                
          </tbody>  
    
 <?php
                   
                        


                               if(!empty($branch_id) && $branch_id != $a){
                        $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->whereIn('branch_id', $br_id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                            
                          }
                          else{
                              
                           $cr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('credit');
                        $dr_out = \App\Models\JournalEntry::where('account_id',  $vat_out->id)->where('date', '<=',$second_date)->where('added_by',auth()->user()->added_by)->sum('debit');
                          }
                          
                            $vat_out=$cr_out-$dr_out;


                        ?> 
                        <tfoot>
                    <tr>     
                        <td >
                            <b>Total</b></td>
                           <td><b>{{ number_format($dr_out,2) }}</b></td>
                            <td><b>{{ number_format($cr_out,2) }}</b></td>
                             <td></td>
                             
                    </tr> 
                    
                     <tr>     
                        <td >
                            <b>VAT OUT Total Balance</b></td>
                           <td colspan="3"><b>{{ number_format(abs($vat_out),2) }}</b></td>
                            
                             
                    </tr> 

                        </tfoot>
                            </table>


<br>
                            <table class="table table-bordered table-striped">

 <tbody>   

  <tr>
                        <td >
                              <b>{{$account_code->account_name }} Total Balance</b></td>    
                                                          @if ($total_in - $total_out < 0)
                                   
                                        <td><b>{{ number_format(abs($vat_in - $vat_out) ,2) }} </b>  </td>
                                
                           @else
                                  <td><b>{{ number_format(abs($vat_in - $vat_out) ,2) }} </b> </td>
                               
                           @endif 
                       

                       

                    </tr> 
                        </tbody>
                            </table>
                           </div>

        </div>
      
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
        

    
    </div>
    
    
    @yield('scripts')
    
      <script>
       $('.datatable-vi').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [1]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
        
    </script>
    
    
     <script>
       $('.datatable-vo').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [1]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
        
    </script>
    
    