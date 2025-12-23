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
                   @can('approve-order')
                   <a class="btn btn-xs btn-info"  title="Approve"    href="" data-toggle="modal"  onclick="model({{ $purchases->id }},'approve')" value="{{ $purchases->id}}" data-target="#appFormModal"> Approve </a>
                   @endcan
                   
                    @can('reject-order')
                   <a class="btn btn-xs btn-danger"  title="Cancel" href="" data-toggle="modal"  onclick="model({{ $purchases->id }},'reject')" value="{{ $purchases->id}}" data-target="#appFormModal"> Reject </a>
                   @endcan
                   
                    @elseif($purchases->status == 1)
                  @if($purchases->finish == 0 )
                   @can('finish-order')
              <a class="btn btn-xs btn-info"  title="Finish" href=""  title=""  data-toggle="modal" onclick="model({{ $purchases->id }},'finish')"  value="{{ $purchases->id}}" data-target="#appFormModal"> Finish Job </a>
                @endcan
                @endif
                
                 @endif

{{--
               @if($purchases->status != 2 )                      
                <a class="btn btn-xs btn-danger "  onclick="return confirm('Are you sure?')" href="{{ route('radio.pay',$purchases->id)}}"  title="Add Payment"> Pay Order  </a>    
           @endif  
--}}
          
             <a class="btn btn-xs btn-success" href="{{ route('radio_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download Quotation </a>
              <a class="btn btn-xs btn-success" href="{{ route('schedule_pdfview',['download'=>'pdf','id'=>$purchases->id]) }}"  title="" > Download  Preview Job Schedule </a> 
             
                            
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
                                        
                                       <h5 class="mb0">REF NO : {{$purchases->confirmation_number}}</h5>
                                      Quotation Date : {{Carbon\Carbon::parse($purchases->request_date)->format('d/m/Y')}}                                                         
                                        <br>Sales Agent: {{$purchases->user->name }} 
                                      
          <br>Status: 

                                                  
                                                @if($purchases->status == 0 )
                                                <div class="badge badge-warning badge-shadow">Waiting For Approval</div>
                                            @elseif($purchases->status == 1)
                                            <span class="badge badge-success badge-shadow">Approved</span>
                                            @elseif($purchases->status == 2)
                                            <span class="badge badge-danger badge-shadow">Cancelled</span>
                                           
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
                                       @if($purchases->program_type == 'Commercial')
                                       <h4 class="mb0"> {{$purchases->supplier->name}}</h4>
                                      {{$purchases->supplier->address}}   
                                     <br>Phone : {{$purchases->supplier->phone}}                  
                                    <br> Email : <a href="mailto:{{$purchases->supplier->email}}">{{$purchases->supplier->email}}</a>                                                               
                                    <br>TIN : {{!empty($purchases->supplier->TIN)? $purchases->supplier->TIN : ''}}
                                    
                                      @else
                                       <h4 class="mb0"> {{$purchases->guest}}</h4>
                                        {{$purchases->institution}}  
                                      @endif

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
                        <th style="color:white;">Date</th>
                        <th  style="color:white;">Reference</th>                      
                   <th  style="color:white;">Action</th>
                    </tr>
                </thead>
                                    <tbody>
                                      
                                        @foreach($purchase_items as $row)
                                        
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                              

                                        <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}  </td>  
                                        <td class="">{{$row->wbn_no}}  </td>
                                                                                   
                                        

                                            <td>
                                                <div class="form-inline">
                                                
                                             @if($purchases->finish == 0 )
                   <a  class="list-icons-item text-primary" title="Add" onclick="return confirm('Are you sure?')"   href="{{ route('radio.receive', $row->id)}}">Edit</a> &nbsp;
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
<td colspan="2"></td>
<td>Sub Total</td>
<td>{{number_format($purchases->amount - $purchases->tax ,2)}}  {{$purchases->currency_code}}</td>

</tr>

<tr>
<td colspan="2"></td>
<td>Total Tax   </td>
<td>{{number_format($purchases->tax,2)}}  {{$purchases->currency_code}}</td>
</tr>

<tr>
<td colspan="2"></td>
<td>Total Amount</td>
<td>{{number_format($purchases->amount ,2)}}  {{$purchases->currency_code}}</td>
</tr>


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
            url: '{{url("radio/radioModal")}}',
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