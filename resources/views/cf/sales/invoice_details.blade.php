
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Invoice Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
             
        <div class="modal-body">
                                <?php
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();


?>
     

            <div class="card-body">
                                        <div class="row">
                                          
                                            
                                            <div class="col-lg-6 col-xs-6 ">
                <img class="pl-lg" style="width: 233px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
            </div>
                                  
 <div class="col-lg-3 col-xs-3"></div>

                                      <div class="col-lg-3 col-xs-3">
                                        
                                       <h5 class="mb0">REF NO : {{$invoices->reference_no}}</h5>
                                      Invoice Date : {{Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y')}}                  
                                     <br>Due Date : {{Carbon\Carbon::parse($invoices->due_date)->format('d/m/Y')}}                                          
                                    <br>Sales Agent:  @if(!empty($invoices->assign->name)){{$invoices->assign->name }} @endif 
                                      
          <br>Status: 
                                           
                                           
                                            
                                             @if($invoices->quotation == 0)
                                              @if($invoices->status == 0)
                                            <span class="badge badge-danger badge-shadow">Not Approved</span>
                                            @elseif($invoices->status == 1)
                                            <span class="badge badge-warning badge-shadow">Completed</span>
                                             @elseif($invoices->status == 2)
                                            <span class="badge badge-success badge-shadow">Approved</span>
                                             @elseif($invoices->status == 3)
                                            <span class="badge badge-info badge-shadow">Partially Paid</span>
                                            @elseif($invoices->status == 4)
                                            <span class="badge badge-success badge-shadow">Fully Paid</span>
                                            @endif
                                            
                                            
                                            @else
                                             @if($invoices->status == 0)
                                            <span class="badge badge-danger badge-shadow">Not Approved</span>
                                            @elseif($invoices->status == 1)
                                             <span class="badge badge-success badge-shadow">Approved</span>
                                            @endif
                                            
                                              @endif
                                           
                                       
                                </div>

                            <br><br>
                             <div class="col-lg-6 col-xs-6">
                            <h5 class="p-md bg-items mr-15">Our Info:</h5>
                                 <h4 class="mb0">{{$settings->name}}</h4>
                    {{ $settings->address }}  
                   <br>Phone : {{ $settings->phone}}     
                  <br> Email : <a href="mailto:{{$settings->email}}">{{$settings->email}}</a>                                                               
                   <br>TIN : {{$settings->tin}}
                                    </div>
                                   

                                    <div class="col-lg-6 col-xs-6">
                                    @if($invoices->related == 'Clients')
                                     @php $name= $invoices->client->name; @endphp
                                    @else 
                                     @php $name = App\Models\Departments::find($invoices->client_id)->name; @endphp
                                    @endif 
                                       
                                       <h5 class="p-md bg-items ml-13">  Client Info: </h5>
                                       <h4 class="mb0"> {{$name}}</h4>
                                      
                                        

                                        
 </div>

 <?php
                               
                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>

                               <div class="table-responsive mb-lg">
           <table class="table items invoice-items-preview" page-break-inside:="" auto;="">
                <thead class="bg-items">
                    <tr>
                       <th style="color:white;">#</th>
                        <th style="color:white;">Items</th>
                        <th style="color:white;">Qty</th>
                        <th style="color:white;">Price</th>
                        <th style="color:white;">Tax</th>
                        <th style="color:white;">Total</th>
                    </tr>
                </thead>
                                    <tbody>
                                        @if(!empty($invoice_items))
                                        @foreach($invoice_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                            <?php
                                         $item_name = App\Models\CF\CFservice::find($row->item_name);
                                        ?>
                                <td class=""><strong class="block">@if(!empty($item_name->name)) {{$item_name->name}}  @else {{$row->item_name}}  @endif   </strong>
                                                  <br>{{$row->description}}
                                                       </td>
                                <td class="">{{ $row->quantity }} </td>
                                <td class="">{{number_format($row->price ,2)}}  </td>                                         
                                <td class="">{{number_format($row->total_tax ,2)}} </td>
                                <td class="">{{number_format($row->total_cost ,2)}} </td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif

                                       
                                    </tbody>
 <tfoot>
<tr>
<td colspan="4"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total,2)}}  </td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Tax </td>
<td>{{number_format($tax,2)}}  </td>
</tr>

<tr>
    <td colspan="4"></td>
    <td>Total Amount</td>
    <td>{{number_format(($gland_total +  $invoices->shipping_cost)  - $invoices->discount + $invoices->adjustment ,2)}}  </td>
    </tr>
    
     @if($invoices->status == 3 || $invoices->status == 4)
        <td colspan="4"></td>
                        <td>Paid Amount</p>
                        <td>{{number_format(( ($invoices->invoice_amount + $invoices->invoice_tax +  $invoices->shipping_cost)  - $invoices->discount + $invoices->adjustment) - $invoices->due_amount,2)}}  </p>
                    </tr>
    
          <tr>
    <td colspan="4"></td>
                        <td class="text-danger">Total Due</td>
                        <td>{{number_format($invoices->due_amount,2)}}  </td>
                    </tr>
@endif

 <br>
 @if($invoices->commission > 0)
  <tr>
    <td colspan="4"></td>
                        <td>Sales Commission</td>
                        <td>{{number_format($invoices->commission,2)}}  </td>
                    </tr>
@endif 



@if(!@empty($invoices->notes))
<tr>
<td colspan="7">NOTES : <br>{{$invoices->notes}}</td>
</tr>
@endif
</tfoot>
</table>
                            </div>
                           
                           
                           <br><br> 
                            
                            @if(!empty($payments[0]))
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br><h5 class="mb0" style="text-align:center">PAYMENT DETAILS</h5>
                      <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">     
                            
                                
                                <?php
                               
                                
                                 $pay=0;
                                $dep=0;
                                 $i =1;
       
                                 ?>
                                <div class="table-responsive">
        <table class="table datatable-pay table-striped">
                                    <thead>
                                        <tr>
                                            <th>Ref</th>
                                            <th>Type</th>
                                            <th>Payment Date</th>
                                            <th>Amount</th>
                                            <th>Mode</th>
                                            <th>Account</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($payments as $row)
                                       
                                        <tr>
                                            <?php
$method= App\Models\Payment_methodes::find($row->payment_method);
$pay+=$row->amount;

?>
                                            <td class=""> {{$row->trans_id}}</td>
                                             <td class=""> Deposit</td>
                                               <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($row->amount ,2)}} </td>
                                            <td class="">@if(!empty($method)){{ $method->name }} @else {{$row->payment_method}} @endif</td>
                                            <td class="">{{ $row->payment->account_name }}</td>
                                            <td><a  href="{{ route('cf_invoice_payment_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download Receipt </a> </td>
                                        </tr>
                                        @endforeach
                                       
                                     @foreach($deposits as $row)
                                       
                                        <tr>
                                        
                                        <?php
                                        $bank= App\Models\AccountCodes::find($row->bank_id);
                                        $dep+=$row->credit/$invoices->exchange_rate;
                                        ?>
                                            
                                            <td class=""> {{$row->reference_no}}</td>
                                            <td class=""> Withdraw</td>
                                            <td class="">{{Carbon\Carbon::parse($row->return_date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($row->credit/$invoices->exchange_rate ,2)}} </td>
                                            <td class=""></td>
                                            <td class="">@if(!empty($bank)){{ $bank->account_name }}@endif</td>
                                            <td>  </td> 
                                        </tr>
                                        @endforeach
                                       


                                    </tbody>
                                    
                                    <tfoot>
                                    <tr>

                                            
                                            <td class=""><b> Total</b></td>
                                            <td class=""> </td>
                                            <td class="">  </td>
                                            <td class=""><b>{{number_format($pay-$dep ,2)}} </b></td>
                                            <td class=""></td>
                                            <td class=""></td>
                                            <td></td> 
                                        </tr>
                                    </tfoot>

                             
                                </table>
                              </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            @endif
    
    


                 
               
              
        </div>
  </div>

</div>
        <div class="modal-footer bg-whitesmoke br">
            <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>


      

            </div>
            
@yield('scripts')
 <script>
       $('.datatable-pay').DataTable({
            autoWidth: false,
            ordering:false,
            "columnDefs": [
                {"orderable": false, "targets": [1]}
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
            
       