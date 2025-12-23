<!DOCTYPE html>
<html>
<head>
    <title>Larave Generate Invoice PDF - Nicesnippest.com</title>
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
    .w-100{
        width: 100%;
    }
   
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
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
        font-size:14px;
    }
    table tr td{
        font-size:12px;
    }
    table{
        border-collapse:collapse;
    }
table tbody tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,.07);
}
table tbody tr {
    background-color: #ffffff;
}
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
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
            position: fixed;
            bottom: 0;
              margin-top:30px;
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

</style>
<body>
  <!-- Define header and footer blocks before your content -->


  <!-- Wrap the content of your PDF inside a main tag -->
 <?php
$settings= App\Models\System::where('added_by',auth()->user()->added_by)->first();

?>

<div class="add-detail ">
   <table class="table w-100 ">
<tfoot>
       
        <tr>
            <td class="w-50">
                <div class="box-text">
                    <center><img class="pl-lg" style="width: 133px;height:120px;" src="{{url('public/assets/img/logo')}}/{{$settings->picture}}">  </center>
                </div>
            </td>
  
                  
        </tr>
</tfoot>
    </table>


    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tfoot>
 <td class="w-50">
                <div class="box-text">
                    <center><b> DRIVER CHECK LIST </b> </center>
                </div>
        <td>
         
        </tr>

</tfoot>
    </table>
</div>

<?php
$total_a=0;
$total_d=0;
?>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table  w-100 mt-10">
    
                                            <tbody>
                                            
                                               <tr>

                                                <th>Driver Name:</th>
                                                <td>{{$cargo->driver->driver_name}}</td>
                                                <th>License No:</th>
                                                <td>{{$cargo->driver->licence}}</td>

                                                </tr>

                                                <tr>

                                                <th>Horse No:</th>
                                                <td>{{$cargo->truck->reg_no}}</td>

                                                <th>Trailer No:</th>
                                                <td>{{$cargo->truck->connect_trailer}}</td>

                                                </tr>


                                                <tr>

                                                <th>Route Fuel Loaded:</th>
                                                @php $route_fuel  = App\Models\Route::where('id', $cargo->route_id)->first(); @endphp
                                                @if(!empty($route_fuel))
                                                <td>{{$route_fuel->loaded_fuel}}</td>
                                                @else
                                                <td>No used Route Fuel Loaded</td>
                                                @endif

                                                <th >Route Fuel Empty:</th>
                                                @php $fuel2  = App\Models\Route::where('id', $cargo->route_id)->first(); @endphp
                                                @if(!empty($fuel2))
                                                <td>{{$fuel2->empty_fuel}}</td>
                                                @else
                                                <td>No used Fuel</td>
                                                @endif

                                                </tr>


                                                <tr>

                                                <th>Total Fuel:</th>
                                                <td>{{$cargo->return_fuel}}</td>
  
                                                <th></th>
                                                <td></td>
                                                </tr>


                                                <tr>

                                                <th>Loaded Date:</th>
                                                <td>{{Carbon\Carbon::parse($cargo->collection_date)->format('d/m/Y')}}</td>

                                                <th >Cargo Type:</th>
                                                <td>{{$cargo->pacel_name}}</td>

                                                </tr>


                                                <tr>

                                                <th>Fuel Volume:</th>
                                                @php $fuel  = App\Models\Fuel\Fuel::where('movement_id', $cargo->id)->first(); @endphp
                                                @if(!empty($fuel))
                                                <td>{{$fuel->fuel_used}}</td>
                                                @else
                                                <td>No used Fuel</td>
                                                @endif

                                                <th >Mileage Amount:</th>
                                                @php $mileage  = App\Models\Mileage::where('movement_id', $cargo->id)->first(); @endphp
                                                @if(!empty($mileage))
                                                <td>{{$mileage->total_mileage}}</td>
                                                @else
                                                <td>No Mileage found</td>
                                                @endif

                                                </tr>


                                                </tbody>
                                                
                                                


    </table>



</div>
                    <div class="table-section bill-tbl w-100 mt-10">
                        <table class="table w-100 mt-10">
                                                <tfoot>
       
                                                    <tr>
                                                        <td class="w-50">
                                                            ________________________
                                                        </td>
                                                        <td class="w-50">
                                                            _________________________
                                                        </td>
                                                        <td class="w-50">
                                                            _________________________
                                                        </td>
                                                        <td class="w-50"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="w-50"><b>Driver Signature</b></td>
                                                        <td class="w-50"><b>Supervisor Signature</b></td>
                                                        <td class="w-50"><b>Accountant Signature</b></td>
                                                        <td class="w-50"></td>
                                                    </tr>
                                            </tfoot>
                                            </table>
                    </div>

</body>
</html>


