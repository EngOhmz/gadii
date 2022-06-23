<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 2</title>
    <link rel="stylesheet" href="{{ asset('invoice/invoice.css')}}" media="all" />
  </head>
  <body>
  <?php
$settings= App\Models\System::first();

$client_Details = App\User::find($pacel->owner_id);
?>
    <header class="clearfix">
    <div>
    <center> <a href="{{ route('pdfview',['download'=>'pdf','id'=>$pacel->id,'type'=>'requisition']) }}">Download PDF</a> </center>
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
          <h2 class="name">{{$client_Details->fname}}</h2>
          <div class="address">{{$client_Details->address}}</div>
          <div class="email"><a href="mailto:{{$client_Details->email}}">{{$client_Details->email}}</a></div>
        </div>
        <div id="invoice">
          <h3>REQUISITION NO {{$pacel->pacel_number}}</h3>
          <div class="date">Date of Requisition: {{$pacel->created_at}}</div>
          
        </div>
      </div>
      <div>
       <p><center><h3>Requisition For  {{$client_Details->fname}}</h3></center></p>
       </div>
       
       <?php
       $items =  App\Models\Pacel_items::all()->where('pacel_id',$pacel->id);
       $sub_total = 0;
       $gland_total = 0;
       $tax=0;
       $i =1;
       
       ?>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="">#</th>
            <th class="">DESCRIPTION</th>
            <th class="">UNIT PRICE</th>
            <th class="">QUANTITY</th>
            <th class="">TOTAL</th>
          </tr>
        </thead>
        <tbody>
        @if(!empty($items))
        @foreach($items as $row)
        <?php
        $sub_total +=$row->total_cost;
        $gland_total +=$row->total_cost +$row->total_tax;
        $tax += $row->total_tax;
        
        
        ?>
          <tr>
            <td class="">{{$i++}}</td>
             <?php
            $item_name = App\Models\Price::find($row->item_name);
            ?>
            <td class=""><h4 style="padding-right:80px;">{{$item_name->name}}</h4></td>
            <td class="">{{ $row->price }} {{$pacel->currency_code}}</td>
            <td class="">{{ $row->quantity }} {{$pacel->currency_code}}</td>
            <td class="">{{ $row->total_cost }} {{$pacel->currency_code}}</td>
          </tr>
        @endforeach
        @endif
        
        </tbody>
       <tfoot>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">SUBTOTAL</td>
            <td>{{number_format($sub_total,2)}} {{$pacel->currency_code}}</td>
          </tr>
          <tr>
            <td colspan="2"></td>
            <td colspan="2">TAX 18%</td>
            <td>{{number_format($tax,2)}} {{$pacel->currency_code}}</td>
          </tr>
            @if(!@empty($pacel->discount > 0))
           <tr>
            <td colspan="2"></td>
            <td colspan="2">DISCOUNT</td>
            <td>{{$pacel->discount}} {{$pacel->currency_code}}</td>
          </tr> 
           @endif            
          <tr>
            <td colspan="2"></td>
            <td colspan="2">GRAND TOTAL</td>
            <td>{{number_format($gland_total - $pacel->discount,2)}} {{$pacel->currency_code}}</td>
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