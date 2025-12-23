<!DOCTYPE html>
<html>
<head>
    <title>Download PDF</title>
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
        position: fixed;
        bottom: 42px;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 12px;
        color: #DAA520;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 6px 6px 0 0;
        padding: 4px 0;
        z-index: 1000;
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
        /* width: 200px !important;
        height: 100px !important; */
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
    .page-number {
        font-size: 10px;
        color: #000;
        margin-top: 5px;
    }
    @page {
        margin-bottom: 50px;
    }
</style>
<body>
<?php
// $settings = App\Models\System::where('added_by', auth()->user()->added_by)->first();
    if ($invoices->branch_id == 62) {
        $settings = App\Models\System::where('id', 551)->first();
    } else {
        $settings = App\Models\System::where('added_by', auth()->user()->added_by)->first();
    }
$items = App\Models\SystemDetails::where('system_id', $settings->id)->get();
?>
<div class="watermark p-0">Invoice</div>
<hr class="bold-line-2">
<div class="head-title" style="margin: 0px; !important; padding: 0px; !important;">
    <h1 class="text-center m-0 p-0">Invoice</h1>
</div>
<div class="add-detail">
    <table class="table w-100" style="margin: 0px; !important; padding: 0px; !important;">
        <tfoot>
            <tr>
                <td class="w-50">
                    <div class="box-text">
                        <img class="pl-lg" style="width: 320px !important; height: 160px !important;"
                             src="{{ url('assets/img/logo') }}/{{ $settings->picture }}">
                    </div>
                </td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td><div class="box-text"></div></td>
                <td class="w-50">
                    <div class="box-text">
                        <p style="font-size: 12px;"><strong>Client Name:</strong> {{ $invoices->client->name }}</p>
                        <p style="font-size: 12px;"><strong>Customer Reference:</strong> {{ $invoices->supplier_reference }}</p>
                        <p style="font-size: 12px;"><strong>Invoice Ref:</strong> {{ $invoices->reference_no }}</p>
                        <p style="font-size: 12px;"><strong>Invoice Date:</strong> {{ Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y') }}</p>
                        {{-- <p style="font-size: 12px;"><strong>Valid Until:</strong> {{ Carbon\Carbon::parse($invoices->delivery_date)->format('d/m/Y') }}</p> --}}
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="table-section bill-tbl w-100 mt-0">
    <table class="table w-100" style="font-size: 10px;">
        <tbody>
            <tr>
                <th class="w-50" style="background-color: #00008B; color: white;">Our Info</th>
                <th class="w-50" style="background-color: #00008B; color: white;">Client Details</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p style="color:#2980b9; font-size:12px; margin:0; padding:0;">
                            <strong>{{ $settings->name }}</strong>
                        </p>
                        <p>{{ $settings->address }}</p>

                       @if ($invoices->branch_id == 62)
                        <p>PIN: {{ $settings->tin }}</p>
                       @else
                        <p>TIN: {{ $settings->tin }}</p>
                        <p>VRN: {{ $settings->vat }}</p>
                       @endif
                        
                        <p>Phone: {{ $settings->phone }}</p>
                        <p>
                            Email: 
                            <a href="mailto:{{ $settings->email }}" style="color: #00008B;">
                                {{ $settings->email }}
                            </a>
                        </p>
                    </div>
                </td>
                <td>
                    <div class="box-text">
                        <p style="color:#2980b9; font-size:12px; margin:0; padding:0;"><strong>{{ $invoices->client->name }}</strong></p>
                        <p>{{ $invoices->client->address }}</p>
                        <p>TIN: {{ !empty($invoices->client->TIN) ? $invoices->client->TIN : '' }}</p>
                        <p>VRN: {{ !empty($invoices->client->VRN) ? $invoices->client->VRN : '' }}</p>
                        <p>Phone: {{ $invoices->client->phone }}</p>
                        <p>Email: <a href="mailto:{{ $invoices->client->email }}" style="color: #00008B;">{{ $invoices->client->email }}</a></p>
                    </div>
                </td>
            </tr>
 fester       </tbody>
    </table>
</div>

<?php
$sub_total = 0;
$gland_total = 0;
$tax = 0;
$i = 1; // Initialize $i here
?>

<div class="table-section bill-tbl w-100 mt-10">
    <h3 class="text-left m-0 p-0">{{ $invoices->heading }}</h3>
    <table class="table w-100 mt-10">
        <thead>
            <tr>
                <th style="background-color: #00008B; color: white;">S/N</th>
                <th class="col-2" style="background-color: #00008B; color: white;">Items</th>
                <th style="background-color: #00008B; color: white;">Price</th>
                <th style="background-color: #00008B; color: white;">Qty</th>
                <th style="background-color: #00008B; color: white;">UOM</th>
                <th style="background-color: #00008B; color: white;">Total [{{ $invoices->exchange_code }}]</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($invoice_items))
                @foreach ($invoice_items as $row)
                    <?php
                    $sub_total += $row->total_cost;
                    $gland_total += $row->total_cost + $row->total_tax;
                    $tax += $row->total_tax;
                    ?>
                    <tr align="center">
                        <td>{{ $i++ }}</td>
                        <?php
                        $item_name = App\Models\POS\Items::find($row->item_name);
                        ?>
                        <td style="text-align: left;">
                            @if (!empty($item_name->name))
                                {{ $item_name->name }} @if (!empty($item_name->color))
                                    - {{ $item_name->c->name }}
                                    @endif @if (!empty($item_name->size))
                                        - {{ $item_name->s->name }}
                                    @endif
                                @else
                                    {{ $row->item_name }}
                                @endif <br>{{ $row->description }}
                        </td>
                        <td style="text-align: right;">{{ number_format($row->price, 2) }}</td>
                        <td style="text-align: right;">{{ number_format($row->due_quantity) }}</td>
                        <td>{{ $item_name->unit }}</td>
                        <td style="text-align: right;">{{ number_format($row->total_cost + $row->total_tax, 2) }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div style="margin-top:15px; width: 50%; margin-left:auto; text-align:right; font-size:14px;">
        <p style="margin:1px 0;"><b>Sub Total:</b> {{ number_format($sub_total, 2) }} {{ $invoices->exchange_code }}</p>
        <p style="margin:1px 0;"><b>VAT {{ $invoices->exchange_code == 'TZS' ? '18%' : '16%' }}:</b> {{ number_format($tax, 2) }} {{ $invoices->exchange_code }}</p>
        @if ($invoices->adjustment != 0)
            <p style="margin:1px 0;"><b>Total Before Adjustment:</b> {{ number_format($gland_total + $invoices->shipping_cost - $invoices->discount, 2) }} {{ $invoices->exchange_code }}</p>
            <p style="margin:1px 0;"><b>Adjustment:</b> {{ number_format($invoices->adjustment, 2) }} {{ $invoices->exchange_code }}</p>
        @endif
        <p style="margin:1px 0;"><b>Grand Total:</b> <b>{{ number_format($gland_total + $invoices->shipping_cost - $invoices->discount + $invoices->adjustment, 2) }} {{ $invoices->exchange_code }}</b></p>
        @if ($invoices->commission > 0)
            <p style="margin:1px 0;"><b>Sales Commission:</b> {{ number_format($invoices->commission, 2) }} {{ $invoices->exchange_code }}</p>
        @endif
    </div>
    <table style="width: 100%; border: none; border-collapse: collapse;">
        <tbody style="font-size: 10px;">
            <tr style="border: none;">
                <td style="width: 100%; padding-right: 10px; border: none;">
                    <p style="margin: 0;"><strong>Amount In Words:</strong> {{ convertNumberToWord($gland_total + $invoices->shipping_cost - $invoices->discount + $invoices->adjustment) }} Only.</p>
                </td>
            </tr>
            {{-- @if (!empty($invoices->notes))
                <tr style="border: none;">
                    <td style="width: 100%; padding-right: 10px; border: none;">
                        <p style="margin: 0;"><strong>Terms and Conditions:</strong><br>{{ $invoices->notes }}</p>
                    </td>
                </tr>
            @endif --}}
            <tr style="border: none;">
                <td style="width: 50%; padding-right: 10px; border: none;">
                    <p style="margin: 0;"><strong>Payment Terms:</strong> {{ $invoices->payment_condition }}</p>
                </td>
                {{-- <td style="width: 50%; border: none;">
                    <p style="margin: 0;"><strong>Delivery Terms:</strong><br>{{ $invoices->delivery_terms }}</p>
                </td> --}}
            </tr>
        </tbody>
    </table>
    
    <?php
    $word_curr = App\Models\Currency::where('code', $invoices->exchange_code)->first();
    $bank_curr = App\Models\SystemDetails::find($invoices->bank_details_id);
    ?>
    @if ($bank_curr)
        <table class="table w-100 mt-20">
            <tfoot>
                <tr>
                    <td style="width: 50%;">
                        <div><u><h3><b>Account Details For {{ $word_curr->name }}</b></h3></u></div>
                        <div><b>Account Name:</b> {{ $bank_curr->account_name }}</div>
                        <div><b>Account Number:</b> {{ $bank_curr->account_number }}</div>
                        <div><b>Bank Name:</b> {{ $bank_curr->bank_name }}</div>
                        <div><b>Branch:</b> {{ $bank_curr->branch_name }}</div>
                        <div><b>Swift Code:</b> {{ $bank_curr->swift_code }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    @endif
    <p style="font-size: 12px;"><strong>Signature:</strong></p>
    <div class="">
        <img src="{{ url('public/assets/img/signature') }}/{{ $settings->signature }}" alt="{{ $settings->name }}" width="80">
    </div>
    <div class="">
           <img class="pl-lg" style="width: 90px !important; height: 40px !important;"
                src="{{ url('assets/img/logo') }}/{{ $settings->picture }}">
    </div>
    {{-- <div style="display: flex; justify-content: left; align-items: left; width: 100%;">
        <img style="width: 640px; height: 640px;" 
            src="{{ url('assets/img/stamp') }}/{{ $settings->stamp }}">
    </div> --}}

</div>

    <p class="footer-dealers">
        <i><strong>Dealers In:</strong> Sales of Industrial mechanical, Electrical, electronic & pneumatic spares,
            Consumables, Industrial Chemicals, lubricants, Motors & motor Rewinding, Industrial PPEs, General
            Hardware, Industrial Tools and Building Materials.</i>
    </p>

<footer>
    

    {{ $settings->name }}, {{ $settings->address }}<br>
    Phone: {{ $settings->phone }}
    @if (!empty($settings->email))
        <br>Email: <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
    @endif
    <div class="page-number">Page <span class="pageNumber"></span> of <span class="totalPages"></span></div>
</footer>

<script>
    // JavaScript to insert page numbers and total pages (compatible with wkhtmltopdf)
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