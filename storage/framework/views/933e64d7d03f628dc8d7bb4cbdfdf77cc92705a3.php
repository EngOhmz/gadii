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
            bottom: 0;
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
 <?php
$settings= App\Models\System::first();

?>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Invoice</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Invoice : <span class="gray-color"><?php echo e($purchases->pacel_number); ?></span></p>
        <p class="m-0 pt-5 text-bold w-100">Invoice Date : <span class="gray-color"><?php echo e(Carbon\Carbon::parse($purchases->date)->format('d/m/Y')); ?></span></p>

    </div>
<!--
    <div class="w-50 float-left logo mt-10">
        <img src="<?php echo e(url('public/assets/img/logo')); ?>/<?php echo e($settings->picture); ?>" >   
    </div>
-->
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<tbody>
        <tr>
            <th class="w-50">From</th>
            <th class="w-50">To</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p><?php echo e($settings->name); ?></p>
                    <p><?php echo e($settings->address); ?></p>               
                    <p>Contact :<?php echo e($settings->phone); ?></p>
                 <p>Email: <a href="mailto:<?php echo e($settings->email); ?>"><?php echo e($settings->email); ?></p>
                    <p>TIN : <?php echo e($settings->tin); ?></p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p><?php echo e($purchases->supplier->name); ?></p>
                    <p><?php echo e($purchases->supplier->address); ?></p>
                     <p>Contact : <?php echo e($purchases->supplier->phone); ?></p>
                 <p>Email: <a href="mailto:<?php echo e($purchases->supplier->email); ?>"><?php echo e($purchases->supplier->email); ?></p>
                    <p>TIN : <?php echo e(!empty($purchases->supplier->TIN)? $purchases->supplier->TIN : ''); ?></p>
                </div>
            </td>
        </tr>
</tbody>
    </table>
</div>
<!--
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Payment Method</th>
            <th class="w-50">Shipping Method</th>
        </tr>
        <tr>
            <td>Cash On Delivery</td>
            <td>Free Shipping - Free Shipping</td>
        </tr>
    </table>
</div>
-->

<?php
                               
                                 $sub_total = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>

<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
<thead>
        <tr>
            <th class="col-sm-1 w-50">#</th>
            <th class=" col-sm-2 w-50" >Route Name</th>
           <th class="col-sm-1 w-50">Charge Type</th>
            <th class="w-50">Price</th>
            <th class="w-50">Qty</th>
            <th class="w-50">Tax</th>
            <th class="w-50">Total</th>
        </tr>
</thead>
        <tbody>
             <?php if(!empty($purchase_items)): ?>
                                        <?php $__currentLoopData = $purchase_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                         $sub_total +=$row->total_cost;
                                         $gland_total +=$row->total_cost +$row->total_tax;
                                         $tax += $row->total_tax; 
                                         ?>

            <tr align="center">
                <td><?php echo e($i++); ?></td>
                 <?php
                                          //$item_name = App\Models\Pacel\PacelList::find($row->item_name);
                          $item_name = App\Models\Route::find($row->item_name);
                                        ?>
                <td>From <?php echo e($item_name->from); ?>  to  <?php echo e($item_name->to); ?> (<?php echo e($row->distance); ?> km)
                   <?php if(!empty($row->end)): ?>
                    <br>Arrival Location/Address - <?php echo e($row->end); ?>

                      <?php endif; ?>
                </td>
              <td><?php echo e($row->charge_type); ?> </td> 
             <td ><?php echo e(number_format($row->price ,2)); ?></td>               
                <td ><?php echo e($row->quantity); ?></td>
   
                <td>  <?php echo e(number_format($row->total_tax ,2)); ?> <?php echo e($purchases->currency_code); ?></td>                           
                <td ><?php echo e(number_format($row->total_cost ,2)); ?> <?php echo e($purchases->currency_code); ?></td>
                
            </tr>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
       </tbody>

  <tfoot>
<tr>
            <td colspan="5">  </td>
                <td> </td>
               <td></td> 
            </td>
        </tr>
  <tr>
       <tr>
            <td colspan="5">  </td>
                <td> <b> Sub Total</b></td>
               <td><?php echo e(number_format($sub_total,2)); ?>  <?php echo e($purchases->currency_code); ?></td> 
            </td>
        </tr>
  <tr>
            <td colspan="5">  </td>
                <td><b>  VAT  (18%)</b></td>
               <td><?php echo e(number_format($tax,2)); ?>  <?php echo e($purchases->currency_code); ?></td> 
            </td>
        </tr>

  <tr>
            <td colspan="5">  </td>
                <td><b>  Total Amount</b></td>
               <td><?php echo e(number_format($gland_total,2)); ?>  <?php echo e($purchases->currency_code); ?></td> 
            </td>
        </tr>
  </tfoot>
    </table>

  <table class="table w-100 mt-10">
<tr>
         <td style="width: 50%;">
            <div class="left" style="">
        <div><u>  <h3><b>BANK DETAILS</b></h3></u> </div>
         <div><b>Account Name</b>:  DALASHO ENTERPRISES LIMITED</div>
        <div><b>Account Number</b>:  0150386968400 </div>
        <div><b>Bank Name</b>: CRDB BANK</div>
        <div><b>Branch</b>: OYSTERBAY BRANCH</div>
        <div><b>Swift Code</b>: Corutztz</div>
          </div>     
        </tr>
<!--
    <tr>
        <td style="width: 50%;">
            <div class="right" style="">
        <div><u> <h3><b> Account Details For Us-Dollar</b></h3></u> </div>
        <div><b>Account Name</b>:  Isumba Trans Ltd</div>
        <div><b>Account Number</b>:  10201632013 </div>
        <div><b>Bank Name</b>: Bank of Africa</div>
        <div><b>Branch</b>: Business Centre</div>
        <div><b>Swift Code</b>: EUAFTZ TZ</div>
        <div></div>
        </div></td>
    </tr>
-->

      
</table>


</div>

<footer>
This is a computer generated invoice
</footer>
</body>
</html><?php /**PATH /home/admin/web/del.co.tz/public_html/resources/views/pacel/invoice_pdf.blade.php ENDPATH**/ ?>