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


                   @if($purchases->status == 0 ) 
                    <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')"   href="{{ route('purchase_tyre.edit', $purchases->id)}}"  title="" > Edit </a>     
              <a class="btn btn-xs btn-info"  title="Convert to Invoice" onclick="return confirm('Are you sure?')"    href="{{ route('purchase_tyre.receive',$purchases->id)}}"  title="" >Approve Purchase </a>
                @endif

               @if($purchases->status != 0 && $purchases->status != 4 && $purchases->status != 3)                      
                <a class="btn btn-xs btn-danger " data-placement="top"  href="{{ route('purchase_tyre.pay',$purchases->id)}}"  title="Add Payment"> Pay Purchase  </a>    
           @endif  

      @if($purchases->status != 0 &&  $purchases->good_receive == 0)                        
<a class="btn btn-xs btn-info" data-id="{{ $purchases->id }}" onclick="model({{ $purchases->id }},'receive')" href="" data-toggle="modal" data-target="#appFormModal"  title="Good Receive"> Good Receive </a>   
           @endif  
             
             <a class="btn btn-xs btn-success"  href="{{ route('tyre_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download PDF </a>         
                                         
    </div>

<br>

<?php if (strtotime($purchases->due_date) < time() && $purchases->status == '0') {
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
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();


?>
                        <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                                   <div class="col-lg-6 col-xs-6 ">
                <img class="pl-lg" style="width: 233px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
            </div>
                                  
 <div class="col-lg-3 col-xs-3">

                                    </div>

                                      <div class="col-lg-3 col-xs-3">
                                        
                                       <h5 class="mb0">REF NO : {{$purchases->reference_no}}</h5>
                                      Purchase Date : {{Carbon\Carbon::parse($purchases->date)->format('d/m/Y')}}                  
              <br>Due Date : {{Carbon\Carbon::parse($purchases->due_date)->format('d/m/Y')}}                                          
           <br>Purchase Agent: {{$purchases->user->name }} 
                                      
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


                               <br><br>
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
                    <th  style="color:white;">Received Qty</th>
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

                                         $due=App\Models\Tyre\TyreHistory::where('purchase_id',$purchases->id)->where('item_id',$row->item_name)->where('type', 'Purchases')->sum('quantity');
                                      $return=App\Models\Tyre\TyreHistory::where('purchase_id',$purchases->id)->where('item_id',$row->item_name)->where('type', 'Debit Note')->sum('quantity');
                                                          $qty=$due-$return;
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                            <?php
                                         $item_name = App\Models\Tyre\TyreBrand::find($row->item_name);
                                        ?>
                                            <td class=""><strong class="block">@if(!empty($item_name->brand)) {{$item_name->brand}} @else {{$row->item_name}}  @endif  </strong>
                                                  <br>{{$row->description}}
                                                       </td>
                                            <td class="">{{ $row->quantity }} </td>
                                          <td class="">{{ number_format($qty,2) }} </td>
                                        <td class="">{{number_format($row->price ,2)}}  </td>                                         
                                         <td class=""> {{number_format($row->total_tax ,2)}} </td>
                                            <td class="">{{number_format($row->total_cost ,2)}} </td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif

                                       
                                    </tbody>
 <tfoot>
<tr>
<td colspan="5"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total,2)}}  {{$purchases->exchange_code}}</td>
</tr>

<tr>
<td colspan="5"></td>
<td>Total Tax </td>
<td>{{number_format($tax,2)}}  {{$purchases->exchange_code}}</td>
</tr>
<tr>
<td colspan="5"></td>
<td>Shipping Cost</td>
<td>{{number_format( $purchases->shipping_cost ,2)}}  {{$purchases->exchange_code}}</td>
</tr>
<tr>
<td colspan="5"></td>
<td>Discount</td>
<td>{{number_format($purchases->discount ,2)}}  {{$purchases->exchange_code}}</td>
</tr>
<tr>
<td colspan="5"></td>
<td>Total Amount</td>
<td>{{number_format(($gland_total +  $purchases->shipping_cost)  - $purchases->discount ,2)}}  {{$purchases->exchange_code}}</td>
</tr>

 @if(!empty($purchases->due_amount < ($purchases->purchase_amount + $purchases->purchase_tax +  $purchases->shipping_cost)  - $purchases->discount))
     <tr>
<td colspan="5"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format(( ($purchases->purchase_amount + $purchases->purchase_tax +  $purchases->shipping_cost)  - $purchases->discount) - $purchases->due_amount,2)}}  {{$purchases->exchange_code}}</p>
                </tr>

      <tr>
<td colspan="5"></td>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($purchases->due_amount,2)}}  {{$purchases->exchange_code}}</td>
                </tr>
@endif

<br>
  @php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp
 @if($purchases->exchange_code !=  $def->currency)
 <tr>
<td colspan="5"></td>
 <td><b>Exchange Rate 1 {{$purchases->exchange_code}} </b></td>
 <td><b> {{$purchases->exchange_rate}} {{$def->currency}}</b></td>
</tr>
<p></p>
<br>
              <tr>
<td colspan="5"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total * $purchases->exchange_rate,2)}}  {{$def->currency}}</td>
</tr>

<tr>
<td colspan="5"></td>
<td>Total Tax</td>
<td>{{number_format($tax * $purchases->exchange_rate,2)}}   {{$def->currency}}<</td>
</tr>

<tr>
<td colspan="5"></td>
<td>Total Amount</td>
<td>{{number_format($purchases->exchange_rate * ($gland_total-$purchases->discount) ,2)}}   {{$def->currency}}</td>
</tr>

 @if(!@empty($purchases->due_amount <  $purchases->purchase_amount + $purchases->purchase_tax))
     <tr>
<td colspan="5"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format($purchases->exchange_rate * (( $purchases->purchase_amount + $purchases->purchase_tax) - $purchases->due_amount),2)}}  {{$def->currency}}</p>
                </tr>

      <tr>
<td colspan="5"></td>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($purchases->due_amount * $purchases->exchange_rate,2)}}  {{$def->currency}}</td>
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
         <table class="table datatable-basic table-striped">
                                    <thead>
                                    <tr>
                                    <th>Ref</th>
                                    <th>Type</th>
                                    <th>Payment Date</th>
                                    <th>Amount</th>
                                    <th>Mode</th>
                                    <th>Account</th>
                                    <th>Action</th
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
                                            <td class=""> Withdraw</td>
                                            <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($row->amount ,2)}} </td>
                                            <td class="">@if(!empty($method)){{ $method->name }}@endif</td>
                                            <td class="">{{ $row->payment->account_name }}</td>
                                            <td> <a href="{{ route('tyre_payment_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download Receipt </a> </td> 
                                        </tr>
                                        @endforeach
                                        
                                        
                                         @foreach($deposits as $row)
                                       
                                        <tr>
                                        
                                        <?php
                                        $bank= App\Models\AccountCodes::find($row->bank_id);
                                        $dep+=$row->credit/$purchases->exchange_rate;
                                        ?>
                                            
                                            <td class=""> {{$row->reference_no}}</td>
                                            <td class=""> Deposit</td>
                                            <td class="">{{Carbon\Carbon::parse($row->return_date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($row->credit/$purchases->exchange_rate ,2)}} </td>
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
                                            <td class=""><b>{{number_format($pay-$dep ,2)}} {{$purchases->exchange_code}}</b></td>
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
</section>



   <!-- supplier Modal -->
    <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">

        </div>
    </div>

   
@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            ordering:false,
            "columnDefs": [
                {"targets": [3]}
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
    
<script type="text/javascript">
function model(id, type) {

    $.ajax({
        type: 'GET',
        url: '{{url("tyre/invModal")}}',
        data: {
            'id': id,
            'type': type,
        },
        cache: false,
        async: true,
        success: function(data) {
            //alert(data);
            $('#appFormModal > .modal-dialog').html(data);
        },
        error: function(error) {
            $('#appFormModal').modal('toggle');

        }
    });

}


</script>
@endsection