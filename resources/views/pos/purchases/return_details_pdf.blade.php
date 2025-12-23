<!DOCTYPE html>
<html>
<head>
    <title>Debit Note PDF</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<style type="text/css">
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f0 100%);
        margin: 15px;
        position: relative;
    }
    .m-0 { margin: 0; }
    .p-0 { padding: 0; }
    .pt-5 { padding-top: 2px; }
    .mt-10 { margin-top: 1px; }
    .text-center { text-align: center !important; }
    .w-100 { width: 100%; }
    .w-50 { width: 50%; }
    .logo img {
        width: 320px !important;
        height: 160px !important;
        padding-top: 1px;
        border-radius: 6px;
    }
    .gray-color { color: #000; }
    .text-bold { font-weight: 500; }
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
        background: linear-gradient(90deg, #8e44ad, #5e3370);
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
        margin: 0;
        line-height: 1.0;
        font-size: 10px;
    }
    .table-section h3 {
        font-size: 16px;
        color: #000;
        font-weight: 500;
        margin-bottom: 6px;
    }
    a { color: #5e3370; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .table-section table tbody tr:hover {
        background: #f8f9fa;
        transition: background 0.2s ease;
    }
    .watermark {
        position: fixed;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 60px;
        color: rgba(0, 0, 0, 0.08);
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
        border-bottom: 1px solid #8e44ad;
        padding-bottom: 1px;
    }
    .bold-line {
        border: none;
        height: 16px;
        background-color: #dcd6f7;
    }
    .bold-line-2 {
        border: none;
        height: 16px;
        background-color: #7f3fbf;
    }
    footer {
        color: #000;
        width: 100%;
        height: 40px;
        position: fixed;
        bottom: 0;
        border-top: 1px solid #8e44ad;
        padding: 2px 0;
        text-align: center;
        font-size: 10px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 6px;
        z-index: 1000;
    }
    .footer-note {
        position: fixed;
        bottom: 42px;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 12px;
        color: #7f3fbf;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 6px 6px 0 0;
        padding: 4px 0;
        z-index: 1000;
    }
    .footer-note strong { color: #4a148c; }
    table tfoot tr:first-child td { border-top: none; }
    table tfoot tr td { padding: 2px 3px; }
    table tfoot tr td:first-child { border: none; }
    @page {
        margin-bottom: 50px;
    }
</style>
<body>
<?php
$settings = App\Models\System::where('added_by', auth()->user()->added_by)->first();
?>
<div class="watermark p-0">Debit Note</div>
<hr class="bold-line-2">
<div class="head-title" style="margin: 0 !important; padding: 0 !important;">
    <h1 class="text-center m-0 p-0">Debit Note</h1>
</div>

<div class="add-detail">
    <table class="table w-100" style="margin: 0 !important; padding: 0 !important;">
        <tfoot>
            <tr>
                <td class="w-50">
                    <div class="box-text logo">
                        <img class="pl-lg" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">
                    </div>
                </td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td class="w-50">
                    <div class="box-text">
                        <p style="font-size: 12px;"><strong>Supplier Name:</strong> {{ $invoices->supplier->name }}</p>
                        <p style="font-size: 12px;"><strong>Debit Note Ref:</strong> {{ $invoices->reference_no }}</p>
                        <p style="font-size: 12px;"><strong>Purchase Ref:</strong> {{ optional($invoices->purchase)->reference_no }}</p>
                        <p style="font-size: 12px;"><strong>Return Date:</strong> {{ Carbon\Carbon::parse($invoices->return_date)->format('d/m/Y') }}</p>
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
                <th class="w-50" style="background-color: #4a148c; color: white;">Our Info</th>
                <th class="w-50" style="background-color: #4a148c; color: white;">Supplier Details</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p style="color:#7f3fbf; font-size:12px;"><strong>{{$settings->name}}</strong></p>
                        <p>{{$settings->address}}</p>
                        <p>TIN: {{$settings->tin}}</p>
                        <p>Phone: {{$settings->phone}}</p>
                        <p>Email: <a href="mailto:{{$settings->email}}" style="color: #4a148c;">{{$settings->email}}</a></p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        <p style="color:#7f3fbf; font-size:12px;"><strong>{{$invoices->supplier->name}}</strong></p>
                        <p>{{$invoices->supplier->address}}</p>
                        <p>TIN: {{ $invoices->supplier->TIN ?? '' }}</p>
                        <p>Phone: {{$invoices->supplier->phone}}</p>
                        <p>Email: <a href="mailto:{{$invoices->supplier->email}}" style="color: #4a148c;">{{$invoices->supplier->email}}</a></p>
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
?>

<div class="table-section bill-tbl w-100 mt-10">
    <br>
    <h3 class="text-left m-0 p-0">{{ $invoices->heading ?? 'Debit Note Details' }}</h3>
    <table class="table w-100 mt-10">
        <thead>
            <tr>
                <th style="background-color: #4a148c; color: white;">#</th>
                <th class="col-2" style="background-color: #4a148c; color: white;">Items</th>
                <th style="background-color: #4a148c; color: white;">Price</th>
                <th style="background-color: #4a148c; color: white;">Qty</th>
                <th style="background-color: #4a148c; color: white;">Tax</th>
                <th style="background-color: #4a148c; color: white;">Total [{{$invoices->exchange_code}}]</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($invoice_items))
                @foreach($invoice_items as $row)
                    <?php
                        $sub_total += $row->total_cost;
                        $gland_total += $row->total_cost + $row->total_tax;
                        $tax += $row->total_tax;
                        $item_name = App\Models\POS\Items::find($row->item_name);
                    ?>
                    <tr align="center">
                        <td>{{$i++}}</td>
                        <td style="text-align: left;">
                            {{$item_name->name}}
                            @if(!empty($item_name->color)) - {{$item_name->c->name}} @endif
                            @if(!empty($item_name->size)) - {{$item_name->s->name}} @endif
                        </td>
                        <td>{{number_format($row->price, 2)}}</td>
                        <td>{{$row->quantity}}</td>
                        <td>{{number_format($row->total_tax, 2)}}</td>
                        <td>{{number_format($row->total_cost, 2)}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td><b>Sub Total</b></td>
                <td>{{number_format($sub_total, 2)}} {{$invoices->exchange_code}}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td><b>VAT</b></td>
                <td>{{number_format($tax, 2)}} {{$invoices->exchange_code}}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td><b>Total Amount</b></td>
                <td>{{number_format($gland_total, 2)}} {{$invoices->exchange_code}}</td>
            </tr>
            @if(!empty($invoices->notes))
                <tr>
                    <td colspan="6" style="border: none;">
                        <p style="margin: 0;"><strong>Notes:</strong><br>{{$invoices->notes}}</p>
                    </td>
                </tr>
            @endif
        </tfoot>
    </table>
</div>

<p class="footer-note">
    <i><strong>Dealers In:</strong> Sales & Supply of Industrial mechanical, electrical, electronic, pneumatic spares,
        consumables, industrial chemicals, lubricants, PPEs, tools and building materials.</i>
</p>

<footer>
    {{$settings->name}}, {{$settings->address}}<br>
    Phone: {{$settings->phone}}
    @if(!empty($settings->email))
        <br>Email: <a href="mailto:{{$settings->email}}">{{$settings->email}}</a>
    @endif
</footer>
</body>
</html>
