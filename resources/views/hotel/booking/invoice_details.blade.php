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
                    

                @if($invoices->status == 0)
             <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')"   href="{{ route('booking.approve', $invoices->id)}}"  title="" > Approve Booking</a> 
          
            
                @endif
                
               
               @if($invoices->status == 2 || $invoices->status == 1)                      
                <a class="btn btn-xs btn-info " data-placement="top"  href="{{ route('booking.pay',$invoices->id)}}"  title="Add Payment"> Pay invoice  </a>    
           @endif  
           
             @if($invoices->status == 0 || $invoices->status == 1)
             <a class="btn btn-xs btn-danger"  onclick="return confirm('Are you sure?')"   href="{{ route('booking.cancel', $invoices->id)}}"  title="" > Cancel Booking </a> 
            
                @endif

                @if($invoices->status == 2 || $invoices->status == 3)
                @if(!empty($check))
 
                  <a class="btn btn-xs btn-danger" data-toggle="modal"  onclick="model({{$invoices->id}},'cancel')" data-target="#appFormModal" data-id="{{$invoices->id}}"  href=""  title="" > Cancel Booking </a>
                @endif
                 @endif
             
             <a class="btn btn-xs btn-success"  href="{{ route('booking_pdfview',['download'=>'pdf','id'=>$invoices->id]) }}"  title="" > Download PDF </a>
             
             {{--
               <a class="btn btn-xs btn-success"  href="{{ route('booking_receipt',['download'=>'pdf','id'=>$invoices->id]) }}"  title="" > Download Receipt </a>
               --}}
                                         
    </div>

<br>



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
                                        
                                       <h5 class="mb0">REF NO : {{$invoices->reference_no}}</h5>
                                   
                                       Property : @if (!empty($invoices->store->name)){{ $invoices->store->name }}@endif 
                                      <br>Booking Date : {{Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y')}}                  
                                    <br>Booking Agent:  @if(!empty($invoices->assign->name)){{$invoices->assign->name }} @endif 
                                      
          <br>Status: 
                                   @if($invoices->status == 0)
                                            <span class="badge badge-danger badge-shadow">Not Approved</span>
                                            @elseif($invoices->status == 1)
                                            <span class="badge badge-warning badge-shadow">Approved</span>
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
                       <th style="color:white;">Date</th>
                        <th style="color:white;">Room Type</th>
                        <th style="color:white;">Room</th>
                        <th style="color:white;">Price</th>
                        <th style="color:white;">Total</th>
                         <th style="color:white;">Action</th>
                    </tr>
                </thead>
                                    <tbody>
                                        @if(!empty($invoice_items))
                                        @foreach($invoice_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost;
                                         
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                            <?php
                                         $item_type = App\Models\Hotel\RoomType::find($row->room_type);
                                          $item_name = App\Models\Hotel\HotelItems::find($row->room_id);
                                        ?>
                                      
                            <td class="">{{Carbon\Carbon::parse($row->check_in)->format('d/m/Y')}}  to {{Carbon\Carbon::parse($row->check_out)->format('d/m/Y')}} <br> Checkout Time: {{$row->checkout_time}}</td>  
                            <td class="">@if(!empty($item_type->name)) {{$item_type->name}} @else {{$row->room_type}}  @endif </td>
                            <td class=""><strong class="block">@if(!empty($item_name->name)) {{$item_name->name}} @else {{$row->room_id}}  @endif  </strong></td>
                            <td class="">{{number_format($row->price)}} x {{$row->nights}} nights</td>  
                             <td class="">{{number_format($row->total_cost)}}</td>
                                        
                                        <td>
                                         @php $room=App\Models\Hotel\Booked::where('invoice_item_id',$row->id)->where('invoice_id',$invoices->id)->whereIn('status', [0,1])->first(); 
                                         $out=App\Models\Hotel\Booked::where('invoice_item_id',$row->id)->where('invoice_id',$invoices->id)->where('status', 1)->first(); 
                                         @endphp
                                         @if(!empty($room))
                                         
                                            <div class="form-inline">
                                            <div class="dropdown">
                                            <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                              <div class="dropdown-menu">
                                              @can('approve-adjust')
                                              
                    <a class="nav-link"  data-toggle="modal"  onclick="model({{$row->id}},'adjust')" data-target="#appFormModal" data-id="{{$row->id}}"  href=""  title="" > Adjust Room </a>
                                             @endcan
                        <a class="nav-link"  data-toggle="modal"  onclick="model({{$row->id}},'cancel_room')" data-target="#appFormModal" data-id="{{$row->id}}"  href=""  title="" > Cancel Room </a>
                                  
                                   @if(!empty($out))
                                  <a class="nav-link"  onclick="return confirm('Are you sure?')"   href="{{ route('booking.checkout', $row->id)}}"  title="" > Checkout</a>
                                   @endif

                            
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                 @endif
                                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif

                                       
                                    </tbody>
 <tfoot>
<tr>
    <td colspan="4"></td>
    <td>Total Amount</td>
    <td>{{number_format($gland_total)}}  {{$invoices->exchange_code}}</td>
    <td></td>
    </tr>
    
     @if(!empty($invoices->due_amount < ($invoices->invoice_amount + $invoices->invoice_tax) ))
         <tr>
    <td colspan="4"></td>
                        <td>Paid Amount</p>
                        <td>{{number_format( ($invoices->invoice_amount + $invoices->invoice_tax)  - $invoices->due_amount)}}  {{$invoices->exchange_code}}</p></td>
                        <td></td>
                    </tr>
    
          <tr>
    <td colspan="4"></td>
                        <td class="text-danger">Total Due</td>
                        <td>{{number_format($invoices->due_amount,2)}}  {{$invoices->exchange_code}}</td>
                        <td></td>
                    </tr>
@endif

<br>
 @php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp
 @if($invoices->exchange_code != $def->currency)

<tr>
<td colspan="4"></td>
<td>Total Amount</td>
<td>{{number_format($invoices->exchange_rate * ($gland_total) ,2)}}   {{$def->currency}}</td>
<td></td>
</tr>

 @if(!@empty($invoices->due_amount < $invoices->invoice_amount + $invoices->invoice_tax))
     <tr>
     <td colspan="4">
                    <td>Paid Amount</p>
                    <td>{{number_format($invoices->exchange_rate * (($invoices->invoice_amount + $invoices->invoice_tax) - $invoices->due_amount),2)}}  {{$def->currency}}</p>
                    <td></td>
                </tr>

      <tr>
      <td colspan="4">
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($invoices->due_amount * $invoices->exchange_rate,2)}}  {{$def->currency}}</td>
                    <td></td>
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
                        <th>Action</th>
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
                                            <td><a class="nav-link"  href="{{ route('booking_payment_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download Receipt </a> </td>
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


    <!-- supplier Modal -->
    <div class="modal fade" data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">

        </div>
    </div>
   
@endsection

@section('scripts')
 <script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
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
    
    <script type="text/javascript">
        function model(id, type) {


            $.ajax({
                type: 'GET',
                url: '{{ url('hotel/discountModal') }}',
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