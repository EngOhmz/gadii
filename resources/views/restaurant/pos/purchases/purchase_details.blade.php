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

                                @can('manage-second-approval')
                           @if($purchases->approval_1 != '' && $purchases->approval_2 == '' )
                            <a  class="btn btn-xs btn-info"  title="Collect" onclick="return confirm('Are you sure? you want to approve')" href="{{ route('restaurant_purchase.second_approval', $purchases->id)}}">First Approval</a>
                                         @endif
                                               @endcan

                                            @can('manage-third-approval')
                            @if($purchases->approval_1 != '' && $purchases->approval_2 != '' && $purchases->approval_3 == '')
                            <a  class="btn btn-xs btn-info"  title="Collect" onclick="return confirm('Are you sure? you want to approve')" href="{{ route('restaurant_purchase.final_approval', $purchases->id)}}">Final Approval</a>
                         <a  class="btn btn-xs btn-danger"  title="Collect" onclick="return confirm('Are you sure? you want to disapprove')" href="{{ route('restaurant_purchase.final_disapproval', $purchases->id)}}">Disapprove</a>
                          @endif
                                @endcan

               

            

           @canany(['manage-first-approval', 'manage-second-approval','manage-third-approval'])
               @if($purchases->approval_1 != '' && $purchases->approval_2 != '' && $purchases->approval_3 != '')

          @if( $purchases->good_receive == 0)
                                                          
                                                         
                                                             <a class="btn btn-xs btn-info" id="profile-tab2" data-id="{{ $purchases->id  }}" data-type="receive"   onclick="model({{ $purchases->id  }},'receive')"
                                                                    href=""  data-toggle="modal" data-target="#appFormModal"
                                                                    role="tab"
                                                                    aria-selected="false">Good Receive</a>

                                                          <a class="btn btn-xs btn-info"  href="{{ route('restaurant_purchase.issue',$purchases->id) }}"  title=""  onclick="return confirm('Are you sure?')" > Issue Supplier </a>
                                                            @endif

   @if($purchases->status == 1  || $purchases->status == 2 )                      
                <a class="btn btn-xs btn-danger " data-placement="top"  href="{{ route('restaurant_purchase.pay',$purchases->id)}}"  title="Add Payment"> Pay Purchase  </a>    
           @endif  

    @endif  
    @endcanany

             @if( $purchases->good_receive == 1)
                                                          
<a class="btn btn-xs btn-success"  href="{{ route('restaurant_issue_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download Supplier Issue </a>                                                               
                                                            @endif
             <a class="btn btn-xs btn-success"  href="{{ route('restaurant_purchase_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download PDF </a>         
                                         
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
                <img class="pl-lg" style="width: 233px;height: 120px;" src="{{url('assets/img/logo')}}/{{$settings->picture}}">
            </div>
                                  
 <div class="col-lg-3 col-xs-3">

                                    </div>

                                      <div class="col-lg-3 col-xs-3">
                                        
                                       <h5 class="mb0">REF NO : {{$purchases->reference_no}}</h5>
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

                                    $due=App\Models\Restaurant\POS\PurchaseHistory::where('purchase_id',$purchases->id)->where('item_id',$row->item_name)->where('type', 'Purchases')->sum('quantity');
                                      $return=App\Models\Restaurant\POS\PurchaseHistory::where('purchase_id',$purchases->id)->where('item_id',$row->item_name)->where('type', 'Debit Note')->sum('quantity');
                                                          $qty=$due-$return;
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                            <?php
                                         $item_name = App\Models\Restaurant\POS\Items::find($row->item_name);
                                        ?>
                                            <td class=""><strong class="block">{{$item_name->name}}</strong></td>
                                            <td class="">{{ $row->quantity }} </td>
                                               <td class="">{{ number_format($qty,2) }} </td>
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
<td>{{number_format($sub_total,2)}}  {{$purchases->exchange_code}}</td>
</tr>

@if($tax > 0)
<tr>
<td colspan="5"></td>
<td>Total Tax <small class="pr-sm">(VAT 18 %)</small></td>
<td>{{number_format($tax,2)}}  {{$purchases->exchange_code}}</td>
</tr>
@endif

<tr>
<td colspan="5"></td>
<td>Total Amount</td>
<td>{{number_format($gland_total - $purchases->discount ,2)}}  {{$purchases->exchange_code}}</td>
</tr>

 @if(!@empty($purchases->due_amount < $purchases->purchase_amount + $purchases->purchase_tax))
     <tr>
<td colspan="5"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format(( $purchases->purchase_amount + $purchases->purchase_tax) - $purchases->due_amount,2)}}  {{$purchases->exchange_code}}</p>
                </tr>

      <tr>
<td colspan="5"></td>
                    <td class="text-danger">Total Due</td>
                    <td>{{number_format($purchases->due_amount,2)}}  {{$purchases->exchange_code}}</td>
                </tr>
@endif

<br>
 @if($purchases->exchange_code != 'TZS')
 <tr>
<td colspan="5"></td>
 <td><b>Exchange Rate 1 {{$purchases->exchange_code}} </b></td>
 <td><b> {{$purchases->exchange_rate}} TZS</b></td>
</tr>
<p></p>
<br>
              <tr>
<td colspan="5"></td>
<td>Sub Total</td>
<td>{{number_format($sub_total * $purchases->exchange_rate,2)}}  TZS</td>
</tr>

@if($tax > 0)
<tr>
<td colspan="5"></td>
<td>Total Tax</td>
<td>{{number_format($tax * $purchases->exchange_rate,2)}}   TZS</td>
</tr>
@endif

<tr>
<td colspan="5"></td>
<td>Total Amount</td>
<td>{{number_format($purchases->exchange_rate * ($gland_total-$purchases->discount) ,2)}}   TZS</td>
</tr>

 @if(!@empty($purchases->due_amount <  $purchases->purchase_amount + $purchases->purchase_tax))
     <tr>
<td colspan="5"></td>
                    <td>Paid Amount</p>
                    <td>{{number_format($purchases->exchange_rate * (( $purchases->purchase_amount + $purchases->purchase_tax) - $purchases->due_amount),2)}}  TZS</p>
                </tr>

      <tr>
<td colspan="5"></td>
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
                           <th >Status</th>
                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"   rowspan="1" colspan="1"   aria-label="CSS grade: activate to sort column ascending" style="width: 178.1094px;">Actions</th>
     
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
                                          <td class="">{{ $row->payment->account_name }}</td>
                                              <td>
                                                    @if($row->approval_1 == '' && $row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Waiting For First Approval</div>
                                                         @elseif($row->approval_1 != '' && $row->approval_2 == '' && $row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Waiting For Final Approval</div>
                                                   @elseif($row->approval_1 != '' && $row->approval_2 != '' && $row->status == 0)
                                                    <div class="badge badge-info badge-shadow">Approved</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-success badge-shadow">Paid</div>                                                   
                                                    @endif
                                                </td>
                                             <td class="">
                                            <div class="form-inline">
                                               @if($row->approval_1 == '')
                                                          
                                                    <a class="list-icons-item text-primary"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('restaurant_purchase_payment.edit', $row->id)}}"><i
                                                            class="icon-pencil7"></i></a>&nbsp

                                                {!! Form::open(['route' => ['restaurant_purchase_payment.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
&nbsp
                                                         
   @endif
                
                               
                                           <div class="dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                                <div class="dropdown-menu">

                                                               @can('manage-first-approval')
                                                            @if($row->approval_1 == '' && $row->status == 0)
                         <a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to approve')" href="{{ route('restaurant_purchase_payment.first_approval', $row->id)}}">First Approval</a>
                                                           @endif
                                                                @endcan

                                                     @can('manage-second-approval')
                           @if($row->approval_1 != '' && $row->approval_2 == '' && $row->status == 0)
                            <a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to approve')" href="{{ route('restaurant_purchase_payment.final_approval', $row->id)}}">Final Approval</a>
                         <a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to disapprove')" href="{{ route('restaurant_purchase_payment.first_disapproval', $row->id)}}">Disapprove</a>
                                         @endif
                                               @endcan

                                            @can('manage-third-approval')
                            @if($row->approval_1 != '' && $row->approval_2 != '' && $row->status == 0)
                            <a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to confirm')" href="{{ route('restaurant_purchase_payment.confirm', $row->id)}}">Confirm Payment</a>
                          @endif
                                @endcan

                                     <a class="nav-link" id="profile-tab2" href="{{ route('restaurant_purchase_payment_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
                                                            role="tab"  aria-selected="false">Download PDF</a>

                    
                                                       </div>
                                                </div>
                                                   
                                                </div>
                                                 </td>
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
 function model(id, type) {

        let url = '{{ route("restaurant_purchase.show", ":id") }}';
        url = url.replace(':id', id)
        $.ajax({
            type: 'GET',
            url: url,
            data: {
                'type': type,
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