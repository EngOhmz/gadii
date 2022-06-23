@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">

            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="padding-20">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                                    aria-selected="true">Invoice Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab2"
                                    href="{{ route('invoice_payment.show',$sales->id)}}" role="tab"
                                    aria-selected="false">Make
                                    Payments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab2"
                                    href="{{ route('pdfview',['download'=>'pdf','id'=>$sales->id,'type'=>'invoice','invoice_id'=>$sales->id]) }}" role="tab"
                                    aria-selected="false">
                                    Download PDF</a>
                            </li>
                            
                        </ul>
                        <?php
$settings= App\Models\System::first();


?>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                                    <div class="col-md-3 col-6 b-r">
                                        <img src="{{url('public/assets/img/logo')}}/{{$settings->picture}}" width="300px;">
                                        <br>

                                    </div>
                                    <div class="col-md-6 col-6 b-r">

                                    </div>

                                    <div class="col-md-3 col-6">
                                        <h4 class="name">{{$settings->name}}</h4>
                                        <div>{{ !empty($settings->address) ? $settings->address : 'address' }}</div>
                                        <div>{{!empty($settings->phone) ? $settings->phone : 'Phone'}}</div>
                                        <div><a
                                                href="mailto:{{$settings->email}}">{{!empty($settings->email) ? $settings->email : 'Email'}}</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3 col-6 b-r">
                                        <div class="to">INVOICE TO:</div>
                                        <h5 class="name">
                                            {{!empty($sales->farmer->firstname) ? $sales->farmer->firstname : 'no name' }}
                                        </h5>
                                        <div class="address">
                                            {{!empty($sales->farmer->address) ? $sales->farmer->firstname : 'no address' }}
                                        </div>
                                        <div class="email"><a
                                                href="mailto:{{!empty($sales->farmer->email) ? $sales->farmer->email : 'no email' }}">{{!empty($purchases->supplier->email) ? $purchases->supplier->email : 'no email' }}</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 b-r">

                                    </div>

                                    <div class="col-md-3 col-6">
                                        <p>{{$sales->reference_no}}</p>
                                        <div class="date">Date: {{$sales->invoice_date}}</div>
                                    </div>
                                </div>

                                <hr>
                                <?php
                               
                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">DESCRIPTION</th>
                                            <th scope="col">UNIT PRICE</th>
                                            <th scope="col">QUANTITY</th>
                                            <th scope="col">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($sales->sales_items))
                                        @foreach($sales->sales_items as $row)
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>
                                        <tr>
                                            <td class="">{{$i++}}</td>
                                            <?php
                                          $item_name = App\Models\Items::find($row->item_name);
                                        ?>
                                            <td class="">
                                                <p style="padding-right:80px;">{{$item_name->name}}</p>
                                            </td>
                                            <td class="">{{ $row->price }} {{$sales->currency_code}}</td>
                                            <td class="">{{ $row->quantity }} {{$sales->currency_code}}</td>
                                            <td class="">{{ $row->total_cost }} {{$sales->currency_code}}</td>
                                        </tr>
                                        @endforeach
                                        @endif


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                <hr>SUBTOTAL
                                                </hr>
                                            </td>
                                            <td>
                                                <hr>{{number_format($sub_total,2)}} {{$sales->currency_code}}
                                                <hr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                <hr>TAX 18%
                                                <hr>
                                            </td>
                                            <td>
                                                <hr>{{number_format($tax,2)}} {{$sales->currency_code}}
                                                <hr>
                                            </td>
                                        </tr>
                                        @if(!@empty($pacel->discount > 0))
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                <hr>DISCOUNT</hr>/td>
                                            <td>{{$pacel->discount}} {{$sales->currency_code}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                <hr>GRAND TOTAL</hr>
                                            </td>
                                            <td>
                                                <hr>{{number_format($gland_total - $sales->discount,2)}}
                                                {{$sales->currency_code}}</hr>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <hr>
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

@endsection