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

                     
    
                 @if($purchases->good_receive == 0 )
                                  @if(!empty($child[0]))
                  @can('approve-trip')
                  <a  class="btn btn-xs btn-info" title="Collect" onclick="return confirm('Are you sure?')"   href="{{ route('courier.start', $purchases->id)}}">Start Trip</a>
                           @endcan                     
                     @endif 

                  @if(!empty($close))
                 @can('close-trip')
                  <a  class="btn btn-xs btn-danger" title="Close" onclick="return confirm('Are you sure?')"   href="{{ route('courier.close_trip', $purchases->id)}}">Close Trip</a>
                           @endcan
                        @endif

                   <a  class="btn btn-xs btn-primary" title="Add" onclick="return confirm('Are you sure?')"   href="{{ route('courier.add_trip', $purchases->id)}}">Add Trip</a>
                @endif
          


                @if(!empty($chk))
             <a class="btn btn-xs btn-success" href="{{ route('courier_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download PDF </a>         
             @endif
                            
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

                                                  
                                                @if($purchases->status == 0 && $purchases->good_receive == 0)
                                                    <div class="badge badge-warning badge-shadow">Waiting For Approval</div>
                                                    @elseif($purchases->good_receive == 1)
                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                  
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

@if(!empty($purchases->instructions))<br><strong>Instruction : </strong> {{$purchases->instructions}}   @endif                                
                                <?php
                               
                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>

<br><br>
  @if(!empty($purchase_items[0]))
                               <div class="table-responsive mb-lg">
            <table class="table items invoice-items-preview" >
                <thead class="bg-items">
                    <tr>
                        <th style="color:white;">#</th>
                    <th style="color:white;">Route</th>
                        <th style="color:white;">WBN</th>
                        <th  style="color:white;">Price</th>                      
                        <th style="color:white;">Tax</th>                              
                        <th  style="color:white;">Total</th>
                   <th  style="color:white;">Action</th>
                    </tr>
                </thead>
                                    <tbody>
                                      
                                        @foreach($purchase_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                                 <td class="">{{$purchases->from->name}} -  @if(!empty($row->to->name)) {{$row->to->name}} @endif</td>
                                            <?php
                                          $item_name = App\Models\Tariff::find($row->item_name);
                                        ?>
                                            <td class=""><strong class="block">{{$row->wbn_no}}</strong>
                                               <br>{{ $row->description }}
                                                     </td>

                                        <td class="">{{number_format($row->price ,2)}}  </td>     
                                                                                   
                                         <td class="">
                             {{number_format($row->total_tax ,2)}} 

</td>
                                            <td class="">{{number_format($row->total_cost ,2)}} </td>


                                            <td>
                                                <div class="form-inline">
                                                
                                             @if($purchases->good_receive == 0)
                   <a  class="list-icons-item text-primary" title="Add" onclick="return confirm('Are you sure?')"   href="{{ route('courier.receive', $row->id)}}"><i class="icon-plus2"></i></a> &nbsp;

@php   
$del=App\Models\Courier\CourierItem::where('pacel_id',$row->pacel_id)->where('parent_id',$row->id)->get(); 
$close_trip=App\Models\Courier\CourierItem::where('pacel_id',$row->pacel_id)->where('parent_id',$row->id)->where('child','1')->where('start','1')->first(); 
@endphp
  @if(empty($del[0]))
{!! Form::open(['route' => ['courier_quotation.delete_parent',$row->id], 'method' => 'delete']) !!}
<button type="submit" style="border:none;background: none; padding-top:20px;" class="list-icons-item text-danger" title="Delete" onclick="return confirm('Are you sure?')"><i class="icon-trash"></i></button>
{{ Form::close() }}
&nbsp;
@endif
                            @endif
  
                                                  <div class="dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                    <div class="dropdown-menu">   
                   @if(empty($close_trip))
                        <a  href="#" class="nav-link" title="View" data-toggle="modal"  onclick="model({{ $row->id }},'assign-wbn')" value="{{ $row->id}}" data-target="#appFormModal">Assign</a>    
                           @endif                           
                       <a  href="#" class="nav-link" title="View" data-toggle="modal"  onclick="model({{ $row->id }},'view-child')" value="{{ $row->id}}" data-target="#appFormModal">View Details</a>                                                    
                                                                             
             </div></div>
                                                
 </div>
                                   </td>
                                        </tr>
                                        @endforeach
                                    

                                       
                                    </tbody>


                          <tfoot>
<tr>
<td colspan="4"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total,2)}}  {{$purchases->currency_code}}</td>
<td></td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Tax   </td>
<td>{{number_format($tax,2)}}  {{$purchases->currency_code}}</td>
<td></td>
</tr>

<tr>
<td colspan="4"></td>
<td>Total Amount</td>
<td>{{number_format($gland_total - $purchases->discount ,2)}}  {{$purchases->currency_code}}</td>
<td></td>
</tr>

 @if(!@empty($purchases->due_amount < $purchases->amount))
     <tr>
<td colspan="5"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format($purchases->amount - $purchases->due_amount,2)}}  {{$purchases->currency_code}}</p>
                </tr>

      <tr>
<td colspan="5"></td>
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
<td colspan="6"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total * $purchases->exchange_rate,2)}}  TZS</td>
</tr>

<tr>
<td colspan="6"></td>
<td>Total Tax</td>
<td>{{number_format($tax * $purchases->exchange_rate,2)}}   TZS</td>
</tr>

<tr>
<td colspan="6"></td>
<td>Total Amount</td>
<td>{{number_format($purchases->exchange_rate * ($gland_total-$purchases->discount) ,2)}}   TZS</td>
</tr>

 @if(!@empty($purchases->due_amount < $purchases->amount))
     <tr>
                    <td>Paid Amount</p>
                    <td>{{number_format($purchases->exchange_rate * ($purchases->amount - $purchases->due_amount),2)}}  TZS</p>
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

    @endif


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
                                            <td class="">{{ number_format($row->amount ,2)}} {{$purchases->currency_code}}</td>
                                            <td class="">{{ $method->name }}</td>
                                            <td class=""><a class="list-icons-item text-primary"
                                            title="Edit" onclick="return confirm('Are you sure?')"
                                            href="{{ route('courier_payment.edit', $row->id)}}"> <i class="icon-pencil7"></i></a></td>
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