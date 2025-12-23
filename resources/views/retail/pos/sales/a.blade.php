<!DOCTYPE html>
<html>
<head>
    <title>Enquiry By Council</title>

    <style>

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid black;
        }

    </style>

</head>
<body>

<div class="row" style="margin-top: 1%">
    <img style="margin-left: 42%; width: 100px" src="{{url('public/images/logo.png')}}"/>
    <h2 align="center" style="margin-top: 0%">Ministry Of Health</h2>
    <br>
    <h3 align="center" style="font-weight: normal">CONTACT CENTER REPORT
    <br>
    <p align="center"><b>Enquiry By Council From c to y</b></p>
</h3>

    <div class="row">
        <div class="col-md-12">
            <table align="center">
                <!-- loop the product names here -->
                <thead>
                <tr>
                    <th>Council</th>
                    <th>Open</th>
                    <th>Closed</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
              
                @if(isset($data))
                @foreach($data as $key => $row)
                    <tr>
                        <td>{{$key}}</td>
                        <td align="right">{{number_format($row['open'])}}</td>
                        <td align="right">{{number_format($row['close'])}}</td>
                        <td align="right">{{number_format($row['open']+$row['close'])}}</td>
                    </tr>
                    
                @endforeach
                @endif
                <tr>
                    <td style="border:1px solid white" align="right"><b>Total</b></td>
                    <td style="border:1px solid white" align="right"><b>q</b></td>
                    <td style="border:1px solid white" align="right"><b>d</b></td>
                    <td style="border:1px solid white" align="right"><b>f</b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script type="text/php">
    if ( isset($pdf) ) {
        $x = 35;
        $y = 820;
        $text = "Generated from Fléx CRM                                             - - - -    {PAGE_NUM} of {PAGE_COUNT} pages    - - - - ";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);


     }



</script>

</body>
</html>

