<!DOCTYPE html>
<html>
<head>
    <title>Purchase PDF</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<style type="text/css">
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f0 100%);
        margin: 15px;
        position: relative;
    }
    .m-0 { margin: 0px; }
    .p-0 { padding: 0px; }
    .pt-5 { padding-top: 2px; }
    .mt-10 { margin-top: 1px; }
    .text-center { text-align: center !important; }
    .w-100 { width: 100%; }
    .w-50 { width: 50%; }
    .w-85 { width: 85%; }
    .w-15 { width: 15%; }
    .logo img {
        width: 100px;
        height: 50px;
        padding-top: 1px;
        border-radius: 6px;
    }
    .logo span {
        margin-left: 8px;
        top: 12px;
        position: absolute;
        font-weight: 500;
        font-size: 22px;
        color: #000;
    }
    .gray-color { color: #000; }
    .text-bold { font-weight: 500; }
    .border { border: 1px solid #000; }
    table {
        border-collapse: collapse;
        background: #ffffff;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        border-radius: 6px;
        overflow: hidden;
    }
    table tbody tr, table thead th, table tbody td {
        border: 1px solid #000;
        padding: 2px 3px;
    }
    table tr th {
        background: linear-gradient(90deg, #3498db, #2980b9);
        color: #ffffff;
        font-size: 13px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    table tr td {
        font-size: 12px;
        color: #000;
    }
    .box-text p {
        margin: 0px 0;
        line-height: 1.0;
        font-size: 10px;
    }
    .float-left { float: left; }
    .total-part {
        font-size: 14px;
        line-height: 1.4;
        color: #000;
    }
    .total-right p { padding-right: 1px; }
    .footer-dealers {
        position: relative;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        text-align: center;
        font-size: 12px;
        color: #DAA520;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 6px 6px 0 0;
        padding: 4px 0;
        margin-top: 20px;
        page-break-inside: avoid;
        display: block;
    }
    .footer-dealers strong {
        color: #00008B;
    }
    footer {
        color: #000;
        width: 100%;
        height: 40px;
        position: fixed;
        bottom: 0;
        border-top: 1px solid #3498db;
        padding: 2px 0;
        text-align: center;
        font-size: 10px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 6px;
        z-index: 1000;
    }
    table tfoot tr:first-child td { border-top: none; }
    table tfoot tr td { padding: 2px 3px; }
    table tfoot tr td:first-child { border: none; }
    .watermark {
        position: fixed;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 60px;
        color: rgba(0, 0, 0, 0.1);
        white-space: nowrap;
        z-index: -1;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }
    .head-title h1 {
        font-size: 26px;
        color: #000;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        border-bottom: 1px solid #3498db;
        padding-bottom: 1px;
    }
    .table-section h3 {
        font-size: 16px;
        color: #000;
        font-weight: 500;
        margin-bottom: 6px;
    }
    .box-text h4 {
        font-size: 14px;
        color: #2980b9;
        margin-bottom: 5px;
    }
    a { color: #3498db; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .table-section table tbody tr:hover {
        background: #f8f9fa;
        transition: background 0.2s ease;
    }
    .add-detail img {
        width: 320px !important;
        height: 160px !important;
    }
    .bold-line {
        border: none;
        height: 16px;
        background-color: #ADD8E6;
    }
    .bold-line-2 {
        border: none;
        height: 16px;
        background-color: #00008B;
    }
    .bank-details {
        border: 1px solid #000;
        padding: 1px;
        margin-top: 10px;
        background: #ffffff;
        border-radius: 6px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
    }
    .bank-details h4 {
        font-size: 14px;
        color: #2980b9;
        margin-bottom: 5px;
        text-transform: uppercase;
    }
    .bank-details p {
        line-height: 1.4;
        margin: 3px 0;
        color: #000;
        font-size: 12px;
    }
    @page {
        margin-bottom: 50px;
        margin-top: 20px;
    }
</style>
<body>
<?php
$settings = App\Models\System::where('added_by', auth()->user()->added_by)->first();
$items = App\Models\SystemDetails::where('system_id', $settings->id)->get();
?>
<div class="watermark p-0">Purchase </div>
<hr class="bold-line-2">
<div class="head-title" style="margin: 0px !important; padding: 0px !important;">
    <h1 class="text-center m-0 p-0">Purchase Order</h1>
</div>

<div class="add-detail">
    <table class="table w-100" style="margin: 0px !important; padding: 0px !important;">
        <tfoot>
            <tr>
                <td class="w-50">
                    <div class="box-text">
                        <img class="pl-lg" style="width: 320px !important; height: 160px !important;" src="{{url('assets/img/logo')}}/{{$settings->picture}}">
                    </div>
                </td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td class="w-50">
                    <div class="box-text">
                        <p style="font-size: 12px;"><strong>PO No:</strong> ............................</p>
                        <p style="font-size: 12px;"><strong>Qoute Ref No:</strong> {{$purchases->reference_no}}</p>
                        <p style="font-size: 12px;"><strong>Purchase Date:</strong> {{Carbon\Carbon::parse($purchases->purchase_date)->format('d/m/Y')}}</p>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div style="clear: both;"></div>
</div>

<div class="table-section bill-tbl w-100 mt-0">
    <table class="table w-100" style="font-size: 10px;">
        <tbody>
            <tr>
                <th class="w-50" style="background-color: #00008B; color: white;">Our Info</th>
                <th class="w-50" style="background-color: #00008B; color: white;">Supplier Details</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p style="color:#2980b9; font-size:12px; margin:0; padding:0;"><strong>{{$settings->name}}</strong></p>
                        <p>{{$settings->address}}</p>
                        <p>TIN: {{$settings->tin}}</p>
                        <p>Phone: {{$settings->phone}}</p>
                        <p>Email: <a href="mailto:{{$settings->email}}" style="color: #00008B;">{{$settings->email}}</a></p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        <p style="color:#2980b9; font-size:12px; margin:0; padding:0;"><strong>{{$purchases->supplier->name}}</strong></p>
                        <p>{{$purchases->supplier->address}}</p>
                        <p>TIN: {{!empty($purchases->supplier->TIN) ? $purchases->supplier->TIN : ''}}</p>
                        <p>Phone: {{$purchases->supplier->phone}}</p>
                        <p>Email: <a href="mailto:{{$purchases->supplier->email}}" style="color: #00008B;">{{$purchases->supplier->email}}</a></p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php
$sub_total = 0;
$gland_total = 0;
$tax = 0;
$i = 1;
$has_tax = false;

// First, check if any items have tax
if(!empty($purchase_items)) {
    foreach($purchase_items as $row) {
        if($row->total_tax > 0) {
            $has_tax = true;
            break;
        }
    }
}
?>

<div class="table-section bill-tbl w-100 mt-10">
    <h3 class="text-left m-0 p-0">{{ $purchases->purchase_heading }}</h3>

    <table class="table w-100 mt-10">
        <thead>
            <tr>
                <th style="background-color: #00008B; color: white;">S/N</th>
                <th class="col-2" style="background-color: #00008B; color: white;">Items</th>
                <th style="background-color: #00008B; color: white;">Price</th>
                <th style="background-color: #00008B; color: white;">Qty</th>
                <th style="background-color: #00008B; color: white;">Unit</th>
                @if($has_tax)
                    <th style="background-color: #00008B; color: white;">Tax</th>
                @endif
                <th style="background-color: #00008B; color: white;">Total [{{$purchases->exchange_code}}]</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($purchase_items))
                @foreach($purchase_items as $row)
                    <?php
                    $sub_total += $row->total_cost;
                    $gland_total += $row->total_cost + $row->total_tax;
                    $tax += $row->total_tax;
                    $item_name = App\Models\POS\Items::find($row->item_name);
                    ?>
                    <tr align="center">
                        <td>{{$i++}}</td>
                        <td style="text-align: left;">
                            @if(!empty($item_name->name))
                                {{$item_name->name}} @if(!empty($item_name->color)) - {{$item_name->c->name}} @endif @if(!empty($item_name->size)) - {{$item_name->s->name}} @endif
                            @else
                                {{$row->item_name}}
                            @endif
                            <br>{{$row->description}}
                        </td>
                        <td>{{number_format($row->price, 2)}}</td>
                        <td>{{$row->due_quantity}}</td>
                        <td>{{ $item_name->unit }}</td>
                        @if($has_tax)
                            <td>{{number_format($row->total_tax, 2)}}</td>
                        @endif
                        <td>{{number_format($row->total_cost, 2)}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{ $has_tax ? '5' : '4' }}"></td>
                <td><b>Sub Total</b></td>
                <td>{{number_format($sub_total, 2)}} {{$purchases->exchange_code}}</td>
            </tr>
            @if($has_tax && $tax > 0)
                <tr>
                    <td colspan="{{ $has_tax ? '5' : '4' }}"></td>
                    <td><b>VAT (18%)</b></td>
                    <td>{{number_format($tax, 2)}} {{$purchases->exchange_code}}</td>
                </tr>
            @endif
            <tr>
                <td colspan="{{ $has_tax ? '5' : '4' }}"></td>
                <td><b>Total Amount</b></td>
                <td>{{number_format(($gland_total + $purchases->shipping_cost) - $purchases->discount, 2)}} {{$purchases->exchange_code}}</td>
            </tr>
        </tfoot>
    </table>
</div>

 <table style="width: 100%; border: none; border-collapse: collapse;">
        <tbody style="font-size: 10px;">
            <tr style="border: none;">
                <td style="width: 100%; padding-right: 10px; border: none;">
                    <p style="margin: 0;"><strong>Amount In Words:</strong> {{ convertNumberToWord($gland_total + $purchases->shipping_cost - $purchases->discount + $purchases->adjustment) }} Only.</p>
                </td>
            </tr>
            @if (!empty($purchases->notes))
                <tr style="border: none;">
                    <td style="width: 100%; padding-right: 10px; border: none;">
                        <p style="margin: 0;"><strong>Terms and Conditions:</strong><br>{{ $purchases->notes }}</p>
                    </td>
                </tr>
            @endif
            <tr style="border: none;">
                <td style="width: 50%; padding-right: 10px; border: none;">
                    <p style="margin: 0;"><strong>Payment Terms:</strong> {{ $purchases->payment_condition }}</p>
                </td>
                <td style="width: 50%; border: none;">
                    <p style="margin: 0;"><strong>Delivery Terms:</strong><br>{{ $purchases->delivery_terms }}</p>
                </td>
            </tr>
        </tbody>
    </table>
    <div>
         <p style="font-size: 12px;"><strong>Signature:</strong></p>
        <div class="">
            <img src="{{ url('public/assets/img/signature') }}/{{ $settings->signature }}" alt="{{ $settings->name }}" width="80">
        </div>
        <div class="">
            <img class="pl-lg" style="width: 90px !important; height: 40px !important;"
                    src="{{ url('assets/img/logo') }}/{{ $settings->picture }}">
        </div>
    </div>

{{-- <div class="bank-details">
    @if(!empty($items))
        @foreach($items->chunk(2) as $chunk)
            <table class="table w-100 mt-10">
                <tfoot>
                    <tr>
                        @foreach($chunk as $i)
                            <?php
                            $word_curr = App\Models\Currency::where('code', $i->exchange_code)->first();
                            ?>
                            <td style="width: 50%;">
                                <div><u><h4>Account Details For {{$word_curr->name}}</h4></u></div>
                                <div><p><b>Account Name:</b> {{$i->account_name}}</p></div>
                                <div><p><b>Account Number:</b> {{$i->account_number}}</p></div>
                                <div><p><b>Bank Name:</b> {{$i->bank_name}}</p></div>
                                <div><p><b>Branch:</b> {{$i->branch_name}}</p></div>
                                <div><p><b>Swift Code:</b> {{$i->swift_code}}</p></div>
                            </td>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
        @endforeach
    @endif
</div> --}}

<p class="footer-dealers">
        <i><strong>Dealers In:</strong> Sales of Industrial mechanical, Electrical, electronic & pneumatic spares,
            Consumables, Industrial Chemicals, lubricants, Motors & motor Rewinding, Industrial PPEs, General
            Hardware, Industrial Tools and Building Materials.</i>
</p>

<footer>
    {{$settings->name}}, {{$settings->address}}<br>
    Phone: {{$settings->phone}}
    @if(!empty($settings->email))
        <br>Email: <a href="mailto:{{$settings->email}}">{{$settings->email}}</a>
    @endif
    <div class="page-number">Page <span class="pageNumber"></span> of <span class="totalPages"></span></div>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var pageNumberElements = document.getElementsByClassName("pageNumber");
        var totalPagesElements = document.getElementsByClassName("totalPages");
        for (var i = 0; i < pageNumberElements.length; i++) {
            pageNumberElements[i].innerHTML = "<%page%>";
        }
        for (var i = 0; i < totalPagesElements.length; i++) {
            totalPagesElements[i].innerHTML = "<%totalPages%>";
        }
    });
</script>
</body>
</html>

<?php
function convertNumberToWord($num = false) {
    $num = str_replace([',', ' '], '', trim($num));
    if (!$num) {
        return false;
    }
    $num = (int) $num;
    $words = [];
    $list1 = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    $list2 = ['', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred'];
    $list3 = ['', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion', 'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'];
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = $hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '';
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ($tens < 20) {
            $tens = $tens ? ' ' . $list1[$tens] . ' ' : '';
        } else {
            $tens = (int) ($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ($levels && (int) $num_levels[$i] ? ' ' . $list3[$levels] . ' ' : '');
    }
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return ucwords(strtolower(implode(' ', $words)));
}
?>