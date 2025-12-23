<!DOCTYPE html>
<html>
<head>
    <title>Download PDF</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<style type="text/css">
    body {
        font-family: 'Poppins', Arial, sans-serif;
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
    table tfoot tr:first-child td { border-top: none; }
    table tfoot tr td { padding: 2px 3px; }
    table tfoot tr td:first-child { border: none; }
    .footer-dealers {
        position: fixed;
        bottom: 42px; /* sits just above the footer (footer is 40px high) */
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
    h3, h4 {
        color: #000;
        font-weight: 500;
    }
    span i {
        font-size: 12px;
        color: #DAA520;
    }
    span i strong {
        color: #00008B;
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
    <div class="watermark p-0">Delivery Note</div>
    <hr class="bold-line-2">
    <div class="head-title">
        <h1 class="text-center m-0 p-0">Delivery Note</h1>
    </div>
    <div class="add-detail">
        <table class="table w-100">
            <tfoot>
                <tr>
                    <td class="w-50">
                        <div class="box-text">
                            <img class="pl-lg" style="width: 320px; height: 160px;"
                                src="{{ url('public/assets/img/logo') }}/{{ $settings->picture }}">
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
                        <p style="font-size: 12px;"><strong>Delivery Note NO:</strong> {{ $invoices->reference_no }}</p>
                        <p style="font-size: 12px;"><strong>Delivery Date:</strong> {{ Carbon\Carbon::parse($invoices->invoice_date)->format('d/m/Y') }}</p>
                        {{-- <p style="font-size: 12px;"><strong>P/Valid Until:</strong> {{ Carbon\Carbon::parse($invoices->delivery_date)->format('d/m/Y') }}</p> --}}
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
                <tr style="background-color: #00008B;">
                    <th class="w-50">Our Info</th>
                    <th class="w-50">Client Details</th>
                </tr>
                <tr>
                    <td>
                        <div class="box-text">
                            <p style="color:#2980b9; font-size:12px; margin:0; padding:0;"><strong>{{ $settings->name }}</strong></p>
                            <p>{{ $settings->address }}</p>
                            @if ($invoices->branch_id == 62)
                                <p>PIN: {{ $settings->tin }}</p>
                            @else
                                <p>TIN: {{ $settings->tin }}</p>
                                <p>VRN: {{ $settings->vat }}</p>
                            @endif
                            <p>Phone: {{ $settings->phone }}</p>
                            <p>Email: <a href="mailto:{{ $settings->email }}" style="color: #00008B;">{{ $settings->email }}</a></p>
                        </div>
                    </td>
                    <td>
                        <div class="box-text">
                            <p style="color:#2980b9; font-size:12px; margin:0; padding:0;"><strong>{{ $invoices->client->name }}</strong></p>
                            <p>{{ $invoices->client->address }}</p>
                            <p>TIN: {{ !empty($invoices->client->TIN) ? $invoices->client->TIN : '' }}</p>
                            <p>VRN: {{ !empty($invoices->client->VRN) ? $invoices->client->VRN : '' }}</p>
                            <p>Phone: {{ $invoices->client->phone }}</p>
                            <p>Email: <a href="mailto:{{ $invoices->client->email }}" style="color: #00008B;">{{ $invoices->client->email }}</p>
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
        <h3 class="text-left m-0 p-0">{{ $invoices->heading }}</h3>
        <table class="table w-100 mt-10">
            <thead>
                <tr  style="background-color: #00008B;">
                    <th class="col-sm-1 w-50">S/N</th>
                    <th class="col-sm-2 w-50">Items</th>
                    <th class="w-50">UOM</th>
                    <th class="w-50">Qty</th>
                    
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
                            <td style="text-align: left;">{{ $i++ }}</td>
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
                            <td>{{ $item_name->unit }}</td>
                            <td>{{ $row->due_quantity }}</td>
                            
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        
    </div>

    <div>
        <h4><b><u>Received By:</u></b></h4>
        <p style="font-size: 12px;"><strong>Full Name:</strong> .............................................</p>
        <p style="font-size: 12px;"><strong>Signature:</strong> .............................................</p>
        <p style="font-size: 12px;"><strong>Date:</strong> ................................................</p>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $x = 500;
            $y = 780;
            $font = $pdf->getFontMetrics()->getFont('Poppins', 'normal') ?: $pdf->getFontMetrics()->getFont('Times', 'normal');
            $size = 10;
            $color = [0, 0, 0];
            $text = "{{ $settings->name }}, {{ $settings->address }} | Phone: {{ $settings->phone }}";
            @if (!empty($settings->email))
                $text .= " | Email: {{ $settings->email }}";
            @endif
            $text .= " | Page {PAGE_NUM} of {PAGE_COUNT}";
            $pdf->text($x, $y, $text, $font, $size, $color);
            $pdf->line($x - 450, $y - 5, $x + 50, $y - 5, [52, 152, 219], 1);
        }
    </script>

    <p class="footer-dealers">
        <i><strong>Dealers In:</strong> Sales of Industrial mechanical, Electrical, electronic & pneumatic spares,
            Consumables, Industrial Chemicals, lubricants, Motors & motor Rewinding, Industrial PPEs, General
            Hardware, Industrial Tools and Building Materials.</i>
    </p>

<footer>
    {{-- {{ $settings->name }}, {{ $settings->address }}<br>
    Phone: {{ $settings->phone }}
    @if (!empty($settings->email))
        <br>Email: <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
    @endif --}}
    @php
            if ($invoices->branch_id == 62) {
                $settings = App\Models\System::where('id', 551)->first();
            } else {
                $settings = App\Models\System::where('added_by', auth()->user()->added_by)->first();
            }
        @endphp

        @if (!empty($settings))
            {{ $settings->name ?? '' }}, {{ $settings->address ?? '' }}<br>
            Phone: {{ $settings->phone ?? '' }}
            
            @if (!empty($settings->email))
                <br>Email: <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
            @endif
        @else
            <p>No Adrress Found</p>
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
