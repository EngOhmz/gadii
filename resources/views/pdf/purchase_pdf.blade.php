<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Purchase</title>
    <link rel="stylesheet" href="{{ asset('invoice/invoice.css')}}" media="all" />
</head>

<body>
    <?php
$settings= App\Models\System::first();


?>
    <header class="clearfix">
        <div>

        </div>
        <div id="logo">
            <img src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
        </div>
        <div id="company">
            <h2 class="name">{{$settings->name}}</h2>
            <div>{{$settings->address}}</div>
            <div>{{$settings->phone}}</div>
            <div><a href="mailto:{{$settings->email}}">{{$settings->email}}</a></div>
        </div>
        </div>
    </header>
    <main>
        <div id="details" class="clearfix">
            <div id="client">

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
            <div id="invoice">
                <p>PURCHASE NO {{$purchases->reference_no}}</p>
                <div class="date">Date: {{$purchases->purchase_date}}</div>
            </div>
        </div>
        <div>

        </div>


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
                        SUBTOTAL
                        
                    </td>
                    <td>
                        {{number_format($sub_total,2)}} {{$purchases->currency_code}}
                        
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">
                        TAX 18%
                        
                    </td>
                    <td>
                        {{number_format($tax,2)}} {{$purchases->currency_code}}
                        
                    </td>
                </tr>
                @if(!@empty($pacel->discount > 0))
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">
                        DISCOUNT</td>
                    <td>{{$pacel->discount}} {{$purchases->currency_code}}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="2"></td>
                    <td colspan="2">
                        GRAND TOTAL
                    </td>
                    <td>
                        {{number_format($gland_total - $purchases->discount,2)}}
                        {{$purchases->currency_code}}
                    </td>
                </tr>
            </tfoot>
        </table>
        <div id="thanks">Thank you!</div>
        <div id="notices">
            <div>NOTICE:</div>
            <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
        </div>
    </main>
    <footer>
        Invoice was created on a computer and is valid without the signature and seal.
    </footer>
</body>

</html>