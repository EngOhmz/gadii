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


                    @php
                        $rn=App\Models\POS\ReturnInvoice::where('invoice_id',$invoices->id)->where('added_by',auth()->user()->added_by)->first();
                        $today = date('Y-m-d');
                        $next= date('Y-m-d', strtotime("+1 month", strtotime($invoices->invoice_date))) ;

                    @endphp

                    <div class="col-lg-10">

                        @if($invoices->invoice_status == 0 && $invoices->status == 0)
                            <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')"   href="{{ route('profoma_invoice.edit', $invoices->id)}}"  title="" > Edit </a>

                        @endif
                        @if($invoices->invoice_status == 0)
                            <a class="btn btn-xs btn-primary"  onclick="return confirm('Are you sure?')"   href="{{ route('invoice.convert_to_invoice', $invoices->id)}}"  title="" > Convert To Invoice </a>

                        @endif



{{--                        @if($invoices->status != 0 && $invoices->status != 4 && $invoices->status != 3 && $invoices->invoice_status == 1)--}}
{{--                            <a class="btn btn-xs btn-danger " data-placement="top"  href="{{ route('invoice.pay',$invoices->id)}}"  title="Add Payment"> Pay invoice  </a>--}}
{{--                        @endif--}}

                        @if($invoices->status != 0 && $invoices->status != 4 && $invoices->status != 3 && $invoices->invoice_status == 0)
                            <a class="btn btn-xs btn-info" data-placement="top"  href="{{ route('invoice.receive',$invoices->id)}}"  title="Good Receive"> Good Receive </a>
                        @endif

                        <a class="btn btn-xs btn-success"  href="{{ route('pos_profoma_pdfview',['download'=>'pdf','id'=>$invoices->id]) }}"  title="" > Download PDF </a>

                        <a class="btn btn-xs btn-info"  target="_blank" href="{{ route('pos_invoice_print',['download'=>'pdf','id'=>$invoices->id]) }}"  title="" > Print PDF</a>


                        @if(!empty($invoices->profoma_attachment))
                            <a class="btn btn-xs btn-outline-primary" target="_blank" href="{{ asset($invoices->profoma_attachment) }}">View Attachment</a>
                        @endif


                    </div>

                    <br>

                    <?php if (strtotime($invoices->due_date) < time() && $invoices->invoice_status == 0) {
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
                                            <img class="pl-lg" style="width: 160px;height: 80px;" src="{{url('assets/img/logo')}}/{{$settings->picture}}">
                                        </div>

                                        <div class="col-lg-3 col-xs-3">

                                        </div>

                                        <div class="col-lg-3 col-xs-3">

                                            <h5 class="mb-0">HEADING : {{$invoices->heading}}</h5>
                                            <h6 class="mb-0">CLIENT REFERENCE: {{$invoices->supplier_reference}}</h6>
                                            <h6 class="mb-0">REF NO : {{$invoices->reference_no}}</h6>
                                            @if(!empty($invoices->project_id)) Project No : {{$invoices->project->project_name}} - {{$invoices->project->project_no}} @endif
                                            Invoice Date : {{Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y')}}
                                            <br>Due Date : {{Carbon\Carbon::parse($invoices->due_date)->format('d/m/Y')}}
                                            <br>Sales Agent:  @if(!empty($invoices->assign->name)){{$invoices->assign->name }} @endif

                                            <br>Status:
                                            @if($invoices->status === null)
                                                <span class="badge badge-danger badge-shadow"> Not Approved Proforma</span>
                                            @elseif($invoices->status === 0)
                                                <span class="badge badge-danger badge-shadow">Proforma Invoice</span>
                                            @elseif($invoices->status === 1)
                                                <span class="badge badge-warning badge-shadow">Invoice</span>
                                            @elseif($invoices->status === 2)
                                                <span class="badge badge-info badge-shadow">Partially Paid</span>
                                            @elseif($invoices->status === 3)
                                                <span class="badge badge-success badge-shadow">Fully Paid</span>
                                            @elseif($invoices->status === 4)
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
                                            <br>TIN : {{$settings->tin}}
                                            <br>VRN : {{$settings->vat}}
                                            <br>Phone : {{ $settings->phone}}
                                            <br> Email : <a href="mailto:{{$settings->email}}">{{$settings->email}}</a>
                                        </div>


                                        <div class="col-lg-6 col-xs-6">

                                            <h5 class="p-md bg-items ml-13">  Client Info: </h5>
                                            <h4 class="mb0"> {{$invoices->client->name}}</h4>
                                            {{$invoices->client->address}}
                                            <br>TIN : {{!empty($invoices->client->TIN)? $invoices->client->TIN : ''}}
                                            <br>VRN : {{!empty($invoices->client->VRN)? $invoices->client->VRN : ''}}
                                            <br>Phone : {{$invoices->client->phone}}
                                            <br> Email : <a href="mailto:{{$invoices->client->email}}">{{$invoices->client->email}}</a>


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
                                                    $item_name = App\Models\POS\Items::find($row->item_name);
                                                    ?>
                                                <td class=""><strong class="block">@if(!empty($item_name->name)) {{$item_name->name}} @if(!empty($item_name->color)) - {{$item_name->c->name}} @endif   @if(!empty($item_name->size)) - {{$item_name->s->name}} @endif @else {{$row->item_name}}  @endif   </strong>
                                                    <br>{{$row->description}}
                                                </td>
                                                <td class="">{{ $row->quantity }} </td>
                                                <td class="">{{number_format($row->price ,2)}}  </td>
                                                <td class="">{{number_format($row->total_tax ,2)}} </td>
                                                <td class="">{{number_format($row->total_cost + $row->total_tax ,2)}} </td>

                                            </tr>
                                        @endforeach
                                    @endif


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>Sub Total</td>
                                        <td>{{number_format($invoices->invoice_amount,2)}}  {{$invoices->exchange_code}}</td>
                                    </tr>

                                    <tr>
                                        <td colspan="4"></td>
                                        <td>Total Tax </td>
                                        <td>{{number_format($invoices->invoice_tax,2)}}  {{$invoices->exchange_code}}</td>
                                    </tr>

                                    @if($invoices->adjustment !=0)
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Total Before Adjustment</td>
                                            <td>{{number_format(($invoices->invoice_amount + $invoices->invoice_tax + $invoices->shipping_cost)  - $invoices->discount  ,2)}}  {{$invoices->exchange_code}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Adjustment</td>
                                            <td>{{number_format($invoices->adjustment ,2)}}  {{$invoices->exchange_code}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>Total Amount</td>
                                        <td>{{number_format(( ($invoices->invoice_amount + $invoices->invoice_tax +  $invoices->shipping_cost)  - $invoices->discount + $invoices->adjustment)  - $invoices->discount + $invoices->adjustment ,2)}}  {{$invoices->exchange_code}}</td>
                                    </tr>

                                    @if($invoices->status != 1 && $invoices->status != 4 &&  $invoices->invoice_status == 1)
                                        <td colspan="4"></td>
                                        <td>Paid Amount</p>
                                        <td>{{number_format(( ($invoices->invoice_amount + $invoices->invoice_tax +  $invoices->shipping_cost)  - $invoices->discount + $invoices->adjustment) - $invoices->due_amount,2)}}  {{$invoices->exchange_code}}</p>
                                            </tr>

                                            <tr>
                                        <td colspan="4"></td>
                                        <td class="text-danger">Total Due</td>
                                        <td>{{number_format($invoices->due_amount,2)}}  {{$invoices->exchange_code}}</td>
                                        </tr>
                                    @endif

                                    <br>
                                    @if($invoices->commission > 0)
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Sales Commission</td>
                                            <td>{{number_format($invoices->commission,2)}}  {{$invoices->exchange_code}}</td>
                                        </tr>
                                    @endif

                                    <br>
                                    @php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp
                                    @if($invoices->exchange_code != $def->currency)
                                        <tr>
                                            <td colspan="4"></td>
                                            <td><b>Exchange Rate 1 {{$invoices->exchange_code}} </b></td>
                                            <td><b> {{$invoices->exchange_rate}} {{$def->currency}}</b></td>
                                        </tr>
                                        <p></p>
                                        <br>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Sub Total</td>
                                            <td>{{number_format($sub_total * $invoices->exchange_rate,2)}}  {{$def->currency}}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Total Tax </td>
                                            <td>{{number_format($tax * $invoices->exchange_rate,2)}}   {{$def->currency}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Shipping Cost</td>
                                            <td>{{number_format( $invoices->shipping_cost * $invoices->exchange_rate ,2)}}  {{$invoices->exchange_code}}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Discount</td>
                                            <td>{{number_format($invoices->discount * $invoices->exchange_rate ,2)}}  {{$invoices->exchange_code}}</td>
                                        </tr>
                                        @if($invoices->adjustment !=0)
                                            <tr>
                                                <td colspan="4"></td>
                                                <td>Total Before Adjustment</td>
                                                <td>{{number_format($invoices->exchange_rate * ( ($gland_total +  $invoices->shipping_cost)  - $invoices->discount)  ,2)}}  {{$invoices->exchange_code}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td>Adjustment</td>
                                                <td>{{number_format($invoices->exchange_rate * $invoices->adjustment ,2)}}  {{$invoices->exchange_code}}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td colspan="4"></td>
                                            <td>Total Amount</td>
                                            <td>{{number_format($invoices->exchange_rate * ( ($gland_total +  $invoices->shipping_cost)  - $invoices->discount + $invoices->adjustment) ,2)}}   {{$def->currency}}</td>
                                        </tr>

                                        @if($invoices->status != 1 && $invoices->status != 4 &&  $invoices->invoice_status == 1)
                                            <tr>
                                                <td colspan="4"></td>
                                                <td>Paid Amount</td>
                                                <td>{{number_format( $invoices->exchange_rate * ((($invoices->invoice_amount + $invoices->invoice_tax +  $invoices->shipping_cost)  - $invoices->discount + $invoices->adjustment) - $invoices->due_amount),2)}} {{$def->currency}}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="text-danger">Total Due</td>
                                                <td>{{number_format($invoices->due_amount * $invoices->exchange_rate,2)}}  {{$def->currency}}</td>
                                            </tr>
                                        @endif
                                    @endif


                                    @if(!@empty($invoices->notes))
                                        <tr>
                                            <td colspan="6">NOTES : <br>{{$invoices->notes}}</td>
                                        </tr>
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
                                                    <td><a  href="{{ route('invoice_payment_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download Receipt </a> </td>
                                                </tr>
                                            @endforeach
                                            @isset($deposits)


                                                @if($deposits && count($deposits))
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
                                        @endif
                                            @endisset





                                            </tbody>

                                            <tfoot>
                                            <tr>


                                                <td class=""><b> Total</b></td>
                                                <td class=""> </td>
                                                <td class="">  </td>
                                                <td class=""><b>{{number_format($pay-$dep ,2)}} {{$invoices->exchange_code}}</b></td>
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



@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
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


    <script>
        let print = (doc) => {
            let objFra = document.createElement('iframe');   // Create an IFrame.
            objFra.style.visibility = 'hidden';    // Hide the frame.
            objFra.src = doc;                      // Set source.
            document.body.appendChild(objFra);  // Add the frame to the web page.
            objFra.contentWindow.focus();       // Set focus.
            objFra.contentWindow.print();      // Print it.
        }



    </script>
@endsection