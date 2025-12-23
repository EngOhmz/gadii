@extends('layouts.master')
<style>
.p-md {
    padding: 12px !important;
}

.bg-items {
    background: #303252;
    color: #ffffff;
}
.ml-13 {
    margin-left: -13px !important;
}
</style>

@section('content')
<section class="section">
    <div class="section-body">


        <div class="row">


            <div class="col-12 col-md-12 col-lg-12">

               <div class="col-lg-10">
                  @if($invoices->good_receive == 0 && $invoices->status != 4)
                 <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')"   href="{{ route('pharmacy_invoice.edit', $invoices->id)}}"  title="" > Edit </a>          
            
                @endif
                @if($invoices->invoice_status == 0)
                 <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')"   href="{{ route('pharmacy_invoice.convert_to_invoice', $invoices->id)}}"  title="" > Convert To Invoice </a>          
            
                @endif


               @if($invoices->status != 0 && $invoices->status != 4 && $invoices->status != 3 && $invoices->good_receive == 1)                      
                <a class="btn btn-xs btn-danger " data-placement="top"  href="{{ route('pharmacy_pos_invoice.pay',$invoices->id)}}"  title="Add Payment"> Pay invoice  </a>    
           @endif  

      @if($invoices->status == 0 && $invoices->status != 4 && $invoices->status != 3 && $invoices->good_receive == 0)                        
              <a class="btn btn-xs btn-info" data-placement="top"  href="{{ route('pharmacy_invoice.receive',$invoices->id)}}"  title="Good Receive"> Approve Invoice</a>   
           @endif  
             
             <a class="btn btn-xs btn-success"  href="{{ route('pharmacy_pos_invoice_pdfview',['download'=>'pdf','id'=>$invoices->id]) }}"  title="" > Download PDF </a>         

            @if($invoices->good_receive == 1)                        
                  <a class="btn btn-xs btn-success"  href="{{ route('pharmacy_pos_note_pdfview',['download'=>'pdf','id'=>$invoices->id]) }}"  title="" > Download Delivery Note</a>   
           @endif  
                                         
    </div>

<br>

<?php if (strtotime($invoices->due_date) < time() && $invoices->status != '4' && $invoices->status != '3' && $invoices->good_receive == 0) {
    $start = strtotime(date('Y-m-d H:i'));
    $end = strtotime($invoices->due_date);

    $days_between = ceil(abs($end - $start) / 86400);
    ?>

   <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
             <i class="fa fa-exclamation-triangle"></i>
        This invoice is overdue by {{ $days_between}} days
            </div>
          </div>

  
    <?php
}
?>

<br>
 
                <div class="card">
                    <div class="card-body">
                       
                        <?php
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();


?>
                        <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                                   <div class="col-lg-6 col-xs-6 ">
              <img class="pl-lg" style="width: 233px;height: 120px;" src="{{url('assets/img/logo')}}/{{$settings->picture}}">
            </div>
                                  
 <div class="col-lg-3 col-xs-3">

                                    </div>

                                      <div class="col-lg-3 col-xs-3">
                                        
                                       <h5 class=mb0">REF NO : {{$invoices->reference_no}}</h5>
                                      invoice Date : {{Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y')}}                  
              <br>Due Date : {{Carbon\Carbon::parse($invoices->due_date)->format('d/m/Y')}}                                          
           <br>invoices Agent: {{$invoices->client->name }} 
                                      
          <br>Status: 
                                   @if($invoices->status == 0)
                                            <span class="badge badge-danger badge-shadow">Not Approved</span>
                                            @elseif($invoices->status == 1)
                                            <span class="badge badge-warning badge-shadow">Not Paid</span>
                                            @elseif($invoices->status == 2)
                                            <span class="badge badge-info badge-shadow">Partially Paid</span>
                                            @elseif($invoices->status == 3)
                                            <span class="badge badge-success badge-shadow">Fully Paid</span>
                                            @elseif($invoices->status == 4)
                                            <span class="badge badge-danger badge-shadow">Cancelled</span>
                                            @endif
                                       
                                        <br>Currency: {{$invoices->exchange_code }}                                                
                    
                    
                
            </div>
                                </div>


                               
                               <div class="row mb-lg">
                                    <div class="col-lg-6 col-xs-6">
                                         <h5 class="p-md bg-items mr-15">Our Info:</h5>
                                 <h4 class="mb0">{{$settings->name}}</h4>
                    {{ $settings->address }}  
                   <br>Phone : {{ $settings->phone}}     
                  <br> Email : <a href="mailto:{{$settings->email}}">{{$settings->email}}</a>                                                               
                   <br>TIN : {{$settings->tin}}
                                    </div>
                                   

                                    <div class="col-lg-6 col-xs-6">
                                       
                                       <h5 class="p-md bg-items ml-13">  Client Info: </h5>
                                       <h4 class="mb0"> {{$invoices->client->name}}</h4>
                                      {{$invoices->client->address}}   
                                     <br>Phone : {{$invoices->client->phone}}                  
                                    <br> Email : <a href="mailto:{{$invoices->client->email}}">{{$invoices->client->email}}</a>                                                               
                                    <br>TIN : {{!empty($invoices->client->TIN)? $invoices->client->TIN : ''}}
                                        

                                        </div>
 </div>

                                    </div>
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
                 <th  style="color:white;">Serial/Batch No</th>
                        <th  style="color:white;">Qty</th>
                        <!--<th  style="color:white;">Batch_No#</th>
                        <th  style="color:white;">Expires_Date</th>-->
                        <th  style="color:white;">Price</th>
                        <th  style="color:white;">Tax</th>
                        <th  style="color:white;">Total</th>
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
                                         $item_name = App\Models\Pharmacy\Items::find($row->type);
                                        ?>
                                            <td class=""><strong class="block">{{$item_name->name}}</strong></td>
                                           <td class="">
                                           @if( $row->category == 'Batch')
                                          {{ $row->batch_number }}
                                          @else
                                           {{ $row->serial_no }} 
                                                 @endif
                                                    </td>
                                            <td class="">{{ $row->due_quantity }} </td>
                                        <td class="">{{number_format($row->price ,2)}}  </td>                                         
                                         <td class="">
                                  
                               {{number_format($row->total_tax ,2)}} 

</td>
                                            <td class="">{{number_format($row->total_cost ,2)}} </td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif

                                       
                                    </tbody>
 <tfoot>
<tr>
<td colspan="5"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total,2)}}  {{$invoices->exchange_code}}</td>
</tr>

<tr>
<td colspan="5"></td>
<td>Total Tax <small class="pr-sm">(VAT 18 %)</small></td>
<td>{{number_format($tax,2)}}  {{$invoices->exchange_code}}</td>
</tr>
<tr>
<td colspan="5"></td>
<td>Shipping Cost </td>
<td>{{number_format($invoices->shipping_cost,2)}}  {{$invoices->exchange_code}}</td>
</tr>
<tr>
<td colspan="5"></td>
<td>Total Amount</td>
<td>{{number_format(($gland_total + $invoices->shipping_cost) - $invoices->discount ,2)}}  {{$invoices->exchange_code}}</td>
</tr>

 @if(!@empty($invoices->due_amount < $invoices->invoice_amount + $invoices->invoice_tax + $invoices->shipping_cost))
     <tr>
<td colspan="5"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format(($invoices->invoice_amount + $invoices->invoice_tax + $invoices->shipping_cost) - $invoices->due_amount,2)}}  {{$invoices->exchange_code}}</p>
                </tr>

      <tr>
<td colspan="5"></td>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($invoices->due_amount,2)}}  {{$invoices->exchange_code}}</td>
                </tr>
@endif

<br>
 @if($invoices->exchange_code != 'TZS')
 <tr>
<td colspan="5"></td>
 <td><b>Exchange Rate 1 {{$invoices->exchange_code}} </b></td>
 <td><b> {{$invoices->exchange_rate}} TZS</b></td>
</tr>
<p></p>
<br>
              <tr>
<td colspan="5"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total * $invoices->exchange_rate,2)}}  TZS</td>
</tr>

<tr>
<td colspan="5"></td>
<td>Total Tax</td>
<td>{{number_format($tax * $invoices->exchange_rate,2)}}   TZS<</td>
</tr>

<tr>
<td colspan="5"></td>
<td>Total Amount</td>
<td>{{number_format($invoices->exchange_rate * (($gland_total + $invoices->shipping_cost) -$invoices->discount) ,2)}}   TZS</td>
</tr>

 @if(!@empty($invoices->due_amount < $invoices->invoice_amount + $invoices->invoice_tax + $invoices->shipping_cost))
     <tr>
<td colspan="5"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format($invoices->exchange_rate * (($invoices->invoice_amount + $invoices->invoice_tax + $invoices->shipping_cost) - $invoices->due_amount),2)}}  TZS</p>
                </tr>

      <tr>
<td colspan="5"></td>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($invoices->due_amount * $invoices->exchange_rate,2)}}  TZS</td>
                </tr>
@endif
@endif
</tfoot>
</table>
                            </div>

                                    

                                
                             
                            </div>

                        </div>

                    </div>
                </div>
            </div>

         

  @if(!empty($payments[0]))
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="padding-20">
                        <br><h5 class="mb0" style="text-align:center">PAYMENT DETAILS</h5>
                      <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">     
                            
                                
                                <?php
                               
                                
                                 $i =1;
       
                                 ?>
                                <div class="table-responsive">
        <table class="table datatable-basic table-striped">
                                    <thead>
                                        <tr>
                                            <th>Transaction ID</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Payment Account</th>
                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @foreach($payments as $row)
                                       
                                        <tr>
                                            <?php
$method= App\Models\Payment_methodes::find($row->payment_method);


?>
                                            <td class=""> {{$row->trans_id}}</td>
                                               <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($row->amount ,2)}} {{$invoices->currency_code}}</td>
                                            <td class="">{{ $method->name }}</td>
                                            <td class="">{{ $row->payment->account_name }}</td>
                                             
                                        </tr>
                                        @endforeach
                                       


                                    </tbody>
                                   
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
</section>


   
@endsection

@section('scripts')
 <script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"orderable": false, "targets": [3]}
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
@endsection