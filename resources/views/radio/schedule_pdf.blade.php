<!DOCTYPE html>
<html>
<head>
    <title>Tax Invoice PDF</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
.head{
            font-size: 15px;
        }
.margin{
            margin-top: -1%;
            font-size: 10px;
    }
    .w-100{
        width: 100%;
    }
   
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tbody tr, table thead th, table tbody td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
      .float-right{
        float:right;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:30px;
    }
footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: -20px;
            border-top: 1px solid #aaaaaa;
            padding: 8px 0;
            text-align: center;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }
 table tfoot tr td {
  padding:7px 8px;
        }


        table tfoot tr td:first-child {
            border: none;
        }
.end{
            
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 40px;
            border-top: 1px solid #aaaaaa;
            padding: 8px 0;
            text-align: center;
        }

</style>
<body>
 <?php
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();
$items=App\Models\SystemDetails::where('system_id',$settings->id)->get();
?>

<div class="head-title">
   <h1 class="text-center m-0 p-0 head"><img class="pl-lg" style="width: 233px;height: 120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}"> </h1><br>

 <h3 class="text-center m-0 p-0">Transmission Report</h3><br>
</div>



<div class="table-section bill-tbl w-100 mt-10" >

<h3><b> Transmission Report</b></h3>

    <table class="table w-100 mt-10">
<thead>
        <tr>
            
            <th class="col-sm-1 w-50">Tracking ID</th>
           <th class="col-sm-1 w-50">Category</th>
            <th class=" col-sm-1 w-50" >Duration</th>
            <th class=" col-sm-1 w-50" >Aired Date</th>
             <th class="col-sm-1 w-50">Program</th>

        </tr>
</thead>
        <tbody>
             @if(!empty($purchase_items))
            @foreach($purchase_items as $row)
                                        

            <tr align="center">
                
                   
                   <td>{{$row->tracking_id}}</td>
                                          <td class="">{{$row->category}}</td>
                                             <td> {{$row->duration}}</td>                                             
                                            <td class="">{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}} {{Carbon\Carbon::parse($row->air_time)->format('g:i A')}} </td>
                                             <td> {{$row->program}}</td>  
                
            </tr>
           @endforeach
                                        @endif
       </tbody>

  
    </table>



</div>



</body>
</html>


