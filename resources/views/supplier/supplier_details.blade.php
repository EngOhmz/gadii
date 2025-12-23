@extends('layouts.master')

@push('plugin-styles')
 


<style>

    .border-bottom-0 a {
      font-size: 15px;
        color: #444;
    }

.nav-tabs-vertical .nav-item.show .nav-link, .nav-tabs-vertical .nav-link.active {
        color: #3F51B5;
      font-weight:bold;
}

 .ms-2 {
        color: white;
    }
    
   
    </style>

@endpush

@section('content')
<section class="section">
    <div class="section-body">

                       <div class="row">
						  <div class="col-12 col-sm-12 col-lg-12">
							<div class="card">
							<div class="card-header header-elements-sm-inline">
			                                       <h4>{{$data->name}} Details</h4>

                                        <div class="header-elements">    
                               <a href="{{ route("supplier.edit",$data->id)}}" class="list-icons-item text-primary">
                                        <i class="icon-pencil7"></i> Edit Supplier
                                                     </a>

   </div></div>
								<div class="card-body">
									<div class="d-lg-flex">
										<ul class="nav nav-tabs nav-tabs-vertical flex-column mr-lg-8 wmin-lg-200 mb-lg-0 border-bottom-0">
<li class="nav-item"><a href="#vertical-left-tab1" class="nav-link @if($type == 'details') active  @endif" data-toggle="tab"> Overview</a></li>
<li class="nav-item"><a href="#vertical-left-tab2" class="nav-link @if($type == 'purchase') active  @endif" data-toggle="tab">Purchase  <span class="badge bg-teal rounded-pill float-right ms-2">{{$purcount}}</span></a></li>
<li class="nav-item"><a href="#vertical-left-tab3" class="nav-link @if($type == 'debit') active  @endif" data-toggle="tab">Debit Note <span class="badge bg-teal rounded-pill float-right ms-2">{{$dncount}}</span></a></li>
<li class="nav-item"><a href="#vertical-left-tab4" class="nav-link @if($type == 'grn') active  @endif" data-toggle="tab">Good Receive <span class="badge bg-teal rounded-pill float-right ms-2">{{$grncount}}</span></a></li>
<li class="nav-item"><a href="#vertical-left-tab5" class="nav-link @if($type == 'payment') active  @endif" data-toggle="tab">Purchase Payment <span class="badge bg-teal rounded-pill float-right ms-2">{{$paycount + $depcount}}</span></a></li>
<li class="nav-item"><a href="#vertical-left-tab6" class="nav-link @if($type == 'expense') active  @endif" data-toggle="tab">Expenses <span class="badge bg-teal rounded-pill float-right ms-2">{{$expcount}}</span></a></li>
<li class="nav-item"><a href="#vertical-left-tab7" class="nav-link @if($type == 'journal') active  @endif" data-toggle="tab">Journal Entries <span class="badge bg-teal rounded-pill float-right ms-2">{{$jcount}}</span></a></li>
  
										
										</ul>

                                                                              
			<div class="tab-content flex-lg-fill">

     {{-- overview --}}
		<div class="tab-pane fade @if($type == 'details') show active  @endif " id="vertical-left-tab1">
		<div class="card-header"> <strong>Supplier Details</strong> </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                       <table class="table datatable-overview table-striped">

                                <tbody>
                                <tr><th>Name</th> <td>{{$data->name}}</td> <th>Phone</th>  <td>{{$data->phone}}</td></tr>
                                <tr><th>Email</th><td>{{$data->email}}</td><th>Address</th><td>{{$data->address}}</td></tr>
                                 <tr><th>TIN</th><td>{{$data->TIN}}</td><th>VAT</th><td>{{$data->VAT}}</td></tr>
                                </tbody>
                        </table>
                    </div>
                    </div>
                    </div>
 {{-- overview --}}

											
						  {{-- purchase --}}					
                        <div class="tab-pane fade @if($type == 'purchase') show active  @endif" id="vertical-left-tab2">
						<div class="card-header"> <strong>Purchases</strong> </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                       <table class="table datatable-basic table-striped">
                           <thead>
                                                <tr>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 106.484px;">Ref No</th>
                                                    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 136.484px;">Purchase Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 161.219px;">Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 101.219px;">Status</th>

                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($purchase))
                                                    @foreach ($purchase as $row)
                                                        <tr class="gradeA even" role="row">

                                                <td><a href="{{ route('purchase.show', $row->id) }}" target="_blank">{{ $row->reference_no }}</a></td>

                                                <td>{{Carbon\Carbon::parse($row->purchase_date)->format('d/m/Y')}} </td>

                                                <td>{{ number_format( ($row->purchase_amount + $row->purchase_tax + $row->shipping_cost)  - $row->discount , 2) }} {{ $row->exchange_code }}</td>
                                                <td>
                                            @php $loc = App\Models\Location::where('id', $row->location)->get(); @endphp
                                            @foreach ($loc as $l) {{ $l->name }} @endforeach
                                                </td>

                                            <td>
                                            @if ($row->status == 0)
                                                <div class="badge badge-danger badge-shadow">Not
                                                    Approved</div>
                                            @elseif($row->status == 1)
                                                <div class="badge badge-warning badge-shadow">Approved
                                                </div>
                                            @elseif($row->status == 2)
                                                <div class="badge badge-info badge-shadow">Partially
                                                    Paid</div>
                                            @elseif($row->status == 3)
                                                <span class="badge badge-success badge-shadow">Fully
                                                    Paid</span>
                                            @elseif($row->status == 4)
                                                <span
                                                    class="badge badge-danger badge-shadow">Cancelled</span>
                                            @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>

                        </table>
                    </div>
                </div>
											</div>
											
											 {{-- purchase --}}
											
											
											  {{-- debit note --}}					
                        <div class="tab-pane fade @if($type == 'debit') show active  @endif" id="vertical-left-tab3">
						<div class="card-header"> <strong>Debit Note</strong> </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                       <table class="table datatable-basic table-striped">
                           <thead>
                                                <tr>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 106.484px;">Ref No</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Purchase No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 136.484px;">Return Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 161.219px;">Amount</th>
                                                    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 101.219px;">Status</th>

                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($debit))
                                                    @foreach ($debit as $row)
                                                        <tr class="gradeA even" role="row">

                                                <td><a href="{{ route('debit_note.show', $row->id) }}" target="_blank">{{ $row->reference_no }}</a></td>
                                                 <td> {{$row->purchase->reference_no }}</td>

                                                <td>{{Carbon\Carbon::parse($row->return_date)->format('d/m/Y')}} </td>

                                                <td>{{ number_format(  $row->due_amount , 2) }} {{ $row->exchange_code }}</td>
                                               

                                            <td>
                                            @if ($row->status == 0)
                                                <div class="badge badge-danger badge-shadow">Not
                                                    Approved</div>
                                            @elseif($row->status == 1)
                                                <div class="badge badge-warning badge-shadow">Approved
                                                </div>
                                            @elseif($row->status == 2)
                                                <div class="badge badge-info badge-shadow">Partially
                                                    Paid</div>
                                            @elseif($row->status == 3)
                                                <span class="badge badge-success badge-shadow">Fully
                                                    Paid</span>
                                            @elseif($row->status == 4)
                                                <span
                                                    class="badge badge-danger badge-shadow">Cancelled</span>
                                            @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>

                        </table>
                    </div>
                </div>
											</div>
											 {{-- debit note --}}
											
											
																
											  {{-- grn--}}					
                        <div class="tab-pane fade @if($type == 'grn') show active  @endif" id="vertical-left-tab4">
						<div class="card-header"> <strong>Good Receive</strong> </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                                        @php $total_qty=0; @endphp
                       <table class="table datatable-basic2 table-striped">
                           <thead>
                                                <tr>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Purchase No</th>
                                                    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 156.484px;">Items</th>
                                                          <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 106.484px;">Qty</th>
                                                    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 121.219px;">Location</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 128.1094px;">Actions</th>
                                                  

                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!@empty($grn))
                                                    @foreach ($grn as $row)
                                                        <tr class="gradeA even" role="row">
                                                        
                                                          <?php
                                         $item_name = App\Models\POS\Items::find($row->item_id);
                                        ?>
                                
                                                <td>
                                                @if(!empty($row->purchase_id)) 
                                                <a href="{{ route('purchase.show', $row->purchase_id) }}" target="_blank">{{ $row->purchase->reference_no }}</a>
                                               
                                                @endif
                                                </td>
                                                
                                                  <td class="">@if(!empty($item_name->name)) {{$item_name->name}} @if(!empty($item_name->color)) - {{$item_name->c->name}} @endif   @if(!empty($item_name->size)) - {{$item_name->s->name}} @endif  @endif  </td>
                                                 <td >{{ number_format($row->quantity ,2) }}</td>
                                                <td>{{Carbon\Carbon::parse($row->purchase_date)->format('d/m/Y')}} </td>
                                                <td> @if(!empty($row->location)){{$row->store->name }}@endif</td>
                                                 <td><a href="{{ route('purchase_grn_pdfview', ['download' => 'pdf', 'id' => $row->id]) }}">Download PDF</a></td>

                                                        </tr>
                                                        
                                                         @php $total_qty+=$row->quantity; @endphp
                                                    @endforeach

                                                @endif

                                            </tbody>
                                            
                                             <tfoot>
                                                <tr>
                                                <td><b>Total</b></td>
                                                 <td class=""></td>
                                                 <td><b>{{ number_format($total_qty ,2) }}</b></td>
                                                <td></td>
                                                <td></td>
                                                  <td></td>
                                                        </tr>
                                                        

                                            </tfoot>

                        </table>
                    </div>
                </div>
											</div>
											 {{-- grn --}}
											 
											 
											 
											 	{{-- payments--}}					
                        <div class="tab-pane fade @if($type == 'payment') show active  @endif" id="vertical-left-tab5">
						<div class="card-header"> <strong>Purchase Payments</strong> </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                                        @php   $pay=0; $dep=0; @endphp
                       <table class="table datatable-basic table-striped">
                           <thead>
                                                <tr>
                                                     <th>Ref</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Mode</th>
                                    <th>Account</th>
                                   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!@empty($payment))
                                        @foreach($payment as $row)
                                       
                                        <tr>
                                            <?php
$method= App\Models\Payment_methodes::find($row->payment_method);
$pay+=$row->amount;


?>
                                            <td class=""> {{$row->trans_id}}</td>
                                            <td class=""> Withdraw</td>
                                            <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($row->amount ,2)}} {{$row->exchange_code }} </td>
                                            <td class="">@if(!empty($method)){{ $method->name }}@endif</td>
                                            <td class="">{{ $row->payment->account_name }}</td>
                                            
                                        </tr>
                                        @endforeach
                                        @endif
                                        
                                         @foreach($deposits as $row)
                                       
                                        <tr>
                                        
                                        <?php
                                        $bank= App\Models\AccountCodes::find($row->bank_id);
                                        $dep+=$row->credit/$row->exchange_rate;
                                        ?>
                                            
                                            <td class=""> {{$row->reference_no}}</td>
                                            <td class=""> Deposit</td>
                                            <td class="">{{Carbon\Carbon::parse($row->return_date)->format('d/m/Y')}}  </td>
                                            <td class="">{{ number_format($row->credit/$row->exchange_rate ,2)}} {{$row->exchange_code }}</td>
                                            <td class=""></td>
                                            <td class="">@if(!empty($bank)){{ $bank->account_name }}@endif</td>
                                           
                                        </tr>
                                        @endforeach
                                       


                                    </tbody>
                                    
                                  
                                   

                        </table>
                    </div>
                </div>
											</div>
											 {{-- payments --}}
											 
											 
											 	{{-- expense--}}					
                        <div class="tab-pane fade @if($type == 'expense') show active  @endif" id="vertical-left-tab6">
						<div class="card-header"> <strong>Expenses</strong> </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                                        @php   $total_exp=0; @endphp
                       <table class="table datatable-basic table-striped">
                           <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 98.531px;">Ref</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Expense Account</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Payment Account</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 58.1094px;">Status</th>
                                               
                                            </tr>
                                        </thead>
                                         <tbody id="tenhag">
                                            @if(!@empty($expense))
                                            @foreach ($expense as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{$row->name}}</th>
                                                <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                                   
                                                @php
                                                 $account=App\Models\AccountCodes::where('id',$row->account_id)->first();
                                                @endphp
                                               @if(!empty($account))
                                                <td>{{$account->account_name}}</td>
                                              @else
                                                <td></td>
                                              @endif

                                                @php
                                                 $bank=App\Models\AccountCodes::where('id',$row->bank_id)->first();
                                                @endphp
                                                <td>{{$bank->account_name}}</td>                                           
                                                  <td>{{number_format($row->amount,2)}} {{$row->exchange_code}}</td>
                                                  <td>
                                            @if ($row->status == 0)
                                                <div class="badge badge-danger badge-shadow">Pending</div>
                                            @elseif($row->status == 1)
                                                <div class="badge badge-warning badge-shadow">Approved</div>
                                            @endif
                                                            </td>
                                                  

                                            </tr>
                                <?php
                                                 $total_exp+=$row->amount;
                                ?>
                                            @endforeach

                                            @endif

                                        </tbody>
<tfoot>
<td></td><td></td><td></td>
<td><b>Total</b></td><td><b>{{number_format($total_exp,2)}}</b> </td>
<td></td>
</tfoot>
                                  
                                   

                        </table>
                    </div>
                </div>
											</div>
											 {{-- expense --}}
											 
											 
											 											 
											 	{{-- journal--}}					
                        <div class="tab-pane fade @if($type == 'journal') show active  @endif" id="vertical-left-tab7">
						<div class="card-header"> <strong>Journal Entries</strong> </div>
                                        <div class="card-body">
                                        <div class="table-responsive">
                                        @php   $total_d=0; $total_c=0; @endphp
                       <table class="table datatable-basic table-striped">
                           <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 98.531px;">Date</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Account Code</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Account Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Debit</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Credit</th>
                                                    
                                               
                                            </tr>
                                        </thead>
                                         <tbody id="tenhag">
                                            @if(!@empty($journal))
                                            @foreach ($journal as $row)
                                             @php $account=App\Models\AccountCodes::where('id',$row->account_id)->first(); @endphp
                                                
                                            <tr class="gradeA even" role="row">
                                              
                                        <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                         <td>{{$account->account_codes}}</td> 
                                         <td>{{$account->account_name}}</td>
                                          
                                        <td>{{number_format($row->debit,2)}}</td>
                                        <td>{{number_format($row->credit,2)}}</td>
                                        
                                                 
                                                  

                                            </tr>
                                <?php
                                    $total_d+=$row->debit;  $total_c+=$row->credit;
                                ?>
                                            @endforeach

                                            @endif

                                        </tbody>
<tfoot>
<td></td><td></td>
<td><b>Total</b></td><td><b>{{number_format($total_d,2)}}</b> </td><td><b>{{number_format($total_c,2)}}</b> </td>

</tfoot>
                                  
                                   

                        </table>
                    </div>
                </div>
											</div>
											 {{-- expense --}}



										</div>
									</div>
								</div>
							</div>
						</div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


@endsection

@section('scripts')



<script>
       $('.datatable-basic2').DataTable({
            autoWidth: false,
            ordering:false,
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });

 $('.datatable-task').DataTable({
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


  $('.datatable-notes').DataTable({
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

 $('.datatable-activity').DataTable({
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

 


$('.datatable-est').DataTable({
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

$('.datatable-inv').DataTable({
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

$('.datatable-credit').DataTable({
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

$('.datatable-exp').DataTable({
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















@endsection