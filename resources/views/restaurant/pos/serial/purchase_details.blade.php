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
                  @if($purchases->good_receive == 0 && $purchases->status != 4)
                 <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')"   href="{{ route('purchase_serial.edit', $purchases->id)}}"  title="" > Edit </a>          
            
                @endif

                   @if($purchases->status == 0 )        
              <a class="btn btn-xs btn-info"  title="Convert to Invoice" onclick="return confirm('Are you sure?')"    href="{{ route('purchase_serial.approve',$purchases->id)}}"  title="" >Approve Purchase </a>
                @endif

               @if($purchases->status != 0 && $purchases->status != 4 && $purchases->status != 3 && $purchases->good_receive == 1)                      
                <a class="btn btn-xs btn-danger " data-placement="top"  href="{{ route('purchase_serial.pay',$purchases->id)}}"  title="Add Payment"> Pay Purchase  </a>    
           @endif  

      @if($purchases->status != 0 && $purchases->status != 4 && $purchases->status != 3 && $purchases->good_receive == 0)                        
              <a class="btn btn-xs btn-info" data-placement="top"  href="{{ route('purchase_serial.receive',$purchases->id)}}"  title="Good Receive"> Good Receive </a>   
           @endif  
             
             <a class="btn btn-xs btn-success"  href="{{ route('purchase_serial_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download PDF </a>         
                                         
    </div>

<br>

<?php if (strtotime($purchases->due_date) < time() && $purchases->status != '4' && $purchases->status != '3') {
    $start = strtotime(date('Y-m-d H:i'));
    $end = strtotime($purchases->due_date);

    $days_between = ceil(abs($end - $start) / 86400);
    ?>

   <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
             <i class="fa fa-exclamation-triangle"></i>
        This purchase is overdue by {{ $days_between}} days
            </div>
          </div>

  
    <?php
}
?>

<br>
 
                <div class="card">
                      <div class="card-body">
                       
                        <?php
$settings= App\Models\System::first();


?>
                        <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                                   <div class="col-lg-6 col-xs-6 ">
                <img class="pl-lg" style="width: 233px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
            </div>
              <br>                    
 <div class="col-lg-3 col-xs-3">

                                    </div>

                                      <div class="col-lg-3 col-xs-3">
                                        
                                       <h5 class=mb0">REF NO : {{$purchases->reference_no}}</h5>
                                      Purchase Date : {{Carbon\Carbon::parse($purchases->date)->format('d/m/Y')}}                  
              <br>Due Date : {{Carbon\Carbon::parse($purchases->due_date)->format('d/m/Y')}}                                          
           <br>Sales Agent: {{$purchases->supplier->name }} 
                                      
          <br>Status: 
                                   @if($purchases->status == 0)
                                            <span class="badge badge-danger badge-shadow">Not Approved</span>
                                            @elseif($purchases->status == 1)
                                            <span class="badge badge-warning badge-shadow">Not Paid</span>
                                            @elseif($purchases->status == 2)
                                            <span class="badge badge-info badge-shadow">Partially Paid</span>
                                            @elseif($purchases->status == 3)
                                            <span class="badge badge-success badge-shadow">Fully Paid</span>
                                            @elseif($purchases->status == 4)
                                            <span class="badge badge-danger badge-shadow">Cancelled</span>
                                            @endif
                                       
                                        <br>Currency: {{$purchases->exchange_code }}                                                
                    
                    
                
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
                                       
                                       <h5 class="p-md bg-items ml-13">  Supplier Info: </h5>
                                       <h4 class="mb0"> {{$purchases->supplier->name}}</h4>
                                      {{$purchases->supplier->address}}   
                                     <br>Phone : {{$purchases->supplier->phone}}                  
                                    <br> Email : <a href="mailto:{{$purchases->supplier->email}}">{{$purchases->supplier->email}}</a>                                                               
                                    <br>TIN : {{!empty($purchases->supplier->TIN)? $purchases->supplier->TIN : ''}}
                                        

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
                        <th  style="color:white;">Qty</th>
                        <th   style="color:white;">Price</th>
                        <th  style="color:white;">Tax</th>
                        <th style="color:white;">Total</th>
                    </tr>
                </thead>
                                    <tbody>
                                        @if(!empty($purchase_items))
                                        @foreach($purchase_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                            <?php
                                         $item_name = App\Models\POS\Items::find($row->item_name);
                                        ?>
                                            <td class=""><strong class="block">{{$item_name->name}}</strong></td>
                                            <td class="">{{ $row->quantity }} </td>
                                        <td class="">{{number_format($row->price ,2)}}  </td>                                         
                                         <td class="">
                                  @if(!@empty($row->total_tax > 0))
                               {{number_format($row->total_tax ,2)}} 
@endif
</td>
                                            <td class="">{{number_format($row->total_cost ,2)}} </td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif

                                       
                                    </tbody>
 <tfoot>
<tr>
<td colspan="4"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total,2)}}  {{$purchases->exchange_code}}</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Tax <small class="pr-sm">(VAT 18 %)</small></td>
<td>{{number_format($tax,2)}}  {{$purchases->exchange_code}}</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Amount</td>
<td>{{number_format($gland_total - $purchases->discount ,2)}}  {{$purchases->exchange_code}}</td>
</tr>

 @if(!@empty($purchases->due_amount < $purchases->purchase_amount + $purchases->purchase_tax))
     <tr>
<td colspan="4"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format(( $purchases->purchase_amount + $purchases->purchase_tax) - $purchases->due_amount,2)}}  {{$purchases->exchange_code}}</p>
                </tr>

      <tr>
<td colspan="4"></td>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($purchases->due_amount,2)}}  {{$purchases->exchange_code}}</td>
                </tr>
@endif

<br>
 @if($purchases->exchange_code != 'TZS')
 <tr>
<td colspan="4"></td>
 <td><b>Exchange Rate 1 {{$purchases->exchange_code}} </b></td>
 <td><b> {{$purchases->exchange_rate}} TZS</b></td>
</tr>
<p></p>
<br>
              <tr>
<td colspan="4"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total * $purchases->exchange_rate,2)}}  TZS</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Tax</td>
<td>{{number_format($tax * $purchases->exchange_rate,2)}}   TZS<</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Amount</td>
<td>{{number_format($purchases->exchange_rate * ($gland_total-$purchases->discount) ,2)}}   TZS</td>
</tr>

 @if(!@empty($purchases->due_amount <  $purchases->purchase_amount + $purchases->purchase_tax))
     <tr>
                    <td>Paid Amount</p>
                    <td>{{number_format($purchases->exchange_rate * (( $purchases->purchase_amount + $purchases->purchase_tax) - $purchases->due_amount),2)}}  TZS</p>
                </tr>

      <tr>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($purchases->due_amount * $purchases->exchange_rate,2)}}  TZS</td>
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
                        <!--<th>Action</th>-->
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
                                            <td class="">{{ number_format($row->amount ,2)}} {{$purchases->currency_code}}</td>
                                            <td class="">{{ $method->name }}</td>
                                             <!--<td class=""><a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                            title="Edit" onclick="return confirm('Are you sure?')"
                                            href="{{ route('tyre_payment.edit', $row->id)}}"><i
                                                class="fa fa-edit"></i></a></td>-->
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