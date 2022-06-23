@extends('layouts.master')


@section('content')
<section class="section">
@can('view-purchase')
    <div class="section-body">
        <div class="row">

            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="padding-20">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                                    aria-selected="true">Purchase Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab2" href="{{ route('payments.show',$purchases->id)}}"
                                    role="tab" aria-selected="false">Make
                                    Payments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab2"
                                    href="{{ route('pdfview',['download'=>'pdf','id'=>$purchases->id,'type'=>'purchase']) }}"
                                    role="tab" aria-selected="false">
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
                                            {{!empty($purchases->supplier->name) ? $purchases->supplier->name : 'no name' }}
                                        </h5>
                                        <div class="address">
                                            {{!empty($purchases->supplier->address) ? $purchases->supplier->address : 'no address' }}
                                        </div>
                                        <div class="email"><a
                                                href="mailto:{{!empty($purchases->supplier->email) ? $purchases->supplier->email : 'no email' }}">{{!empty($purchases->supplier->email) ? $purchases->supplier->email : 'no email' }}</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6 b-r">

                                    </div>

                                    <div class="col-md-3 col-6">
                                        <p>PURCHASE NO {{$purchases->reference_no}}</p>
                                        <div class="date">Date: {{$purchases->purchase_date}}</div>
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
                                        @if(!empty($purchases->purchase_items))
                                        @foreach($purchases->purchase_items as $row)
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
                                            <td class="">{{ $row->price }} {{$purchases->currency_code}}</td>
                                            <td class="">{{ $row->quantity }} {{$purchases->currency_code}}</td>
                                            <td class="">{{ $row->total_cost }} {{$purchases->currency_code}}</td>
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
                                                <hr>{{number_format($sub_total,2)}} {{$purchases->currency_code}}
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
                                                <hr>{{number_format($tax,2)}} {{$purchases->currency_code}}
                                                <hr>
                                            </td>
                                        </tr>
                                        @if(!@empty($pacel->discount > 0))
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                <hr>DISCOUNT</hr>/td>
                                            <td>{{$pacel->discount}} {{$purchases->currency_code}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">
                                                <hr>GRAND TOTAL</hr>
                                            </td>
                                            <td>
                                                <hr>{{number_format($gland_total - $purchases->discount,2)}}
                                                {{$purchases->currency_code}}</hr>
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
    @endcan
</section>


@endsection

@section('scripts')

@endsection