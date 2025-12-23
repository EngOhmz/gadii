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
                    @if($purchases->approve == 1 )
                   @if($purchases->status == 0 || $purchases->status == 1)
                 <a class="btn btn-xs btn-danger"  href="{{ route('courier.pay', $purchases->id)}}"  title="" > Pay Invoice </a>          
                @endif
         
                     @else
                 <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')" href="{{ route('courier_edit.invoice', $purchases->id)}}"  title="" > Edit </a>
              <a class="btn btn-xs btn-primary"   data-toggle="modal"  onclick="model({{ $purchases->id }},'reverse')" value="{{ $purchases->id}}" data-target="#appFormModal"> Reverse </a>
               @can('approve-invoice')
            <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')" href="{{ route('courier.approve', $purchases->id)}}"  title="" > Approve </a>
                       @endcan
                   @endif

             
             <a class="btn btn-xs btn-success" href="{{ route('courier_invoice_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download PDF </a>         
                                         
    </div>



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
                                        
                                       <h5 class=mb0">REF NO : {{$purchases->confirmation_number}}</h5>
                                      Invoice Date : {{Carbon\Carbon::parse($purchases->date)->format('d/m/Y')}}                                                         
                                        <br>Sales Agent: {{$purchases->user->name }} 
                                      
          <br>Status: 
                                                      @if($purchases->status == 0 && $purchases->approve == 0)
                                                     <div class="badge badge-warning badge-shadow">Waiting For Approval</div>
                                                    @elseif($purchases->status == 0 && $purchases->approve == 1)
                                                     <div class="badge badge-primary badge-shadow">Invoiced</div>
                                                    @elseif($purchases->status == 1)
                                                     <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($purchases->status == 2)
                                                    <div class="badge badge-success badge-shadow">Paid Invoice</div>
                                                    @endif

                                        <br>Currency: {{$purchases->currency_code }}                                                
                    
                    
                
            </div>
                                </div>


                           
                               <div class="row mb-lg">
                                    <div class="col-lg-6 col-xs-6">
                                         <h5 class="p-md bg-items mr-15">Our Info:</h5>
  <div class="col-lg-1 col-xs-1"></div>
                                 <h4 class="mb0">{{$settings->name}}</h4>
                    {{ $settings->address }}  
                   <br>Phone : {{ $settings->phone}}     
                  <br> Email : <a href="mailto:{{$settings->email}}">{{$settings->email}}</a>                                                               
                   <br>TIN : {{$settings->tin}}
                                    </div>
                                   

                                    <div class="col-lg-6 col-xs-6">
                                       
                                       <h5 class="p-md bg-items ml-13">  Customer Info: </h5>
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
                                  $storage_total = 0;
                                 $i =1;
       
                                 ?>

<br><br>

                               <div class="table-responsive mb-lg">
            <table class="table items invoice-items-preview" >
                <thead class="bg-items">
                    <tr>
                        <th style="color:white;">#</th>
                     <th style="color:white;">WB No</th>
                        <th style="color:white;">Tariff</th>
                        <th style="color:white;">Route</th>
                        <th  style="color:white;">Price</th>
                        <th style="color:white;">Tax</th>
                        <th  style="color:white;">Total</th>
                    </tr>
                </thead>
                                    <tbody>
                                        @if(!empty($purchase_items))
                                        @foreach($purchase_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax ;
                                         $tax += $row->total_tax; ;
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                           <td class=""> {{$row->collect->wbn_no}}</td>
                                            <?php
                                          $item_name = App\Models\Tariff::find($row->item_name);
                                        ?>
                                            <td class=""><strong class="block"> @if(!empty($item_name)) {{$item_name->zone_name}} - {{$item_name->weight}}  @else {{$row->item_name }} @endif</strong></td>
                                            <td class="">From {{$row->start->name}} to {{$row->end->name}}</td>
                                        <td class="">{{number_format($row->price ,2)}}  </td>                                         
                                         <td class="">
                                  @if(!@empty($row->total_tax > 0))
                             {{number_format($row->total_tax ,2)}} 
                                @else
                           {{number_format(0 ,2)}} 
@endif
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
<td>{{number_format($sub_total,2)}}  {{$purchases->currency_code}}</td>
</tr>
<tr>
<td colspan="5"></td>
<td>Add :Total Tax   <small class="pr-sm"> ( VAT - 18%)</small></td>
<td>{{number_format($tax,2)}}  {{$purchases->currency_code}}</td>
</tr>
<tr>
<td colspan="5"></td>
<td>Total Amount</td>
<td>{{number_format($gland_total - $purchases->discount ,2)}}  {{$purchases->currency_code}}</td>
</tr>

 @if(!@empty($purchases->due_amount < $purchases->amount))
     <tr>
<td colspan="4"></td>
                    <td>Paid Amount</p></td>
                    <td>{{number_format($purchases->amount - $purchases->due_amount,2)}}  {{$purchases->currency_code}}</p></td>
                </tr>

      <tr>
<td colspan="4"></td>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($purchases->due_amount,2)}}  {{$purchases->currency_code}}</td>
                </tr>
@endif

<br>
 @if($purchases->currency_code != 'TZS')
 <b>Exchange Rate 1 {{$purchases->currency_code}} = {{$purchases->exchange_rate}} TZS</b>
<p></p>
<br>
              <tr>
<td colspan="4"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total * $purchases->exchange_rate,2)}}  TZS</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Add :Total Tax   <small class="pr-sm"> ( VAT - 18%)</small></td>
<td>{{number_format($tax * $purchases->exchange_rate,2)}}   TZS<</td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Amount</td>
<td>{{number_format($purchases->exchange_rate * ($gland_total-$purchases->discount) ,2)}}   TZS</td>
</tr>

 @if(!@empty($purchases->due_amount < $purchases->amount))
     <tr>
                   <td colspan="4"></td>
                    <td>Paid Amount</p></td>
                    <td>{{number_format($purchases->exchange_rate * ($purchases->amount - $purchases->due_amount),2)}}  TZS</p>
                </tr>

      <tr>
                    <td colspan="4"></td>
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
                       <!-- <th>Action</th>-->
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
                                                <td class="">{{ $row->bank->account_name }}</td>
                                      <!--
                                            <td class=""><a class="list-icons-item text-primary"
                                            title="Edit" onclick="return confirm('Are you sure?')"
                                            href="{{ route('courier_payment.edit', $row->id)}}"> <i class="icon-pencil7"></i></a></td>
                                  -->
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

<!-- discount Modal -->
  <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
    </div>
</div>

   
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
<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("courier/courierModal")}}',
            data: {
                'id': id,
                'type':type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
</script>
@endsection