<style>
.p-md {
    padding: 12px !important;
}

.bg-items {
    background: #303252;
    color: #ffffff;
}
.ml-13 {
    margin-left: -13px !important;
}
</style>

<?php $__env->startSection('content'); ?>
<section class="section">
    <div class="section-body">


        <div class="row">


            <div class="col-12 col-md-12 col-lg-12">

               <div class="col-lg-10">
  
             
             <a class="btn btn-xs btn-success"  href="<?php echo e(route('production_pdfview',['download'=>'pdf','id'=>$data->id])); ?>"  title="" > Download PDF </a>         
                                         
    </div>

<br>


<br>
 
                <div class="card">
                    <div class="padding-20">
                       
                        <?php
$settings= App\Models\System::first();


?>
                        <div class="tab-content" id="myTab3Content">
                            <div class="tab-pane fade show active" id="about" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="row">
                                   <div class="col-lg-3 col-xs-3 ">
                <img class="pl-lg" style="width: 100px;height: 100px;" src="<?php echo e(url('public/assets/img/logo')); ?>/<?php echo e($settings->picture); ?>">
            </div>
                                  


                                      <div class="col-lg-9 col-xs-9">
                                        <table cellpadding=0 cellspacing=0 style="border-collapse: collapse;">
                                        <tr>
                                       <td > <h4 class="mb0 text-center">GAKI INVESTIMENT CO.LTD</h4></td>
                                        </tr>
                                        <tr>
                                       <td > <p class="text-center"><small ><b>GINNERY OIL MILL & RICE MILL</b></small></p></td>
                                        </tr>
                                         <tr>
                                       <td > <p class="text-center"><small ><b>P.O.BOX 707 SHINYANGA</b></small></p></td>
                                        </tr>
                                          <tr>
                                       <td > <p class=""><small ><b>TEL:+255 28 2765022/2765024, FAX +255 28 2765023; MOBILE: +255 767 650806</b></small></p></td>
                                        </tr>
                                        
                                        </table>
                                       
                                      
                                     

                    
                    
                
            </div>
                                </div>


                               <br><br>
                               <div class="row mb-lg">
                                    <div class="col-lg-4 col-xs-4 pull-left">
                                 
                     <p class="pull-left">
               
                  <br><b>  Weight Note No :</b><?php echo e($data->weight_note); ?>                                                             
                   <br><b> Location/Ginnery :</b> <?php echo e($data->location); ?>

                   <?php $client=App\Models\AccountCodes::find(65) ?>
                   <br><b> Client : </b><?php echo e(!empty($client)? $client->account_name : ""); ?>

                   </p>
                                    </div>
                                       <div class="col-lg-4 col-xs-4">
                                       </div>

                                    <div class="col-lg-4 col-xs-4 pull-right ">

                                   <p class="pull-right">
                                    <br><b> Date :</b> <?php echo e($data->date); ?> 
                                    <br> <b> Lot No :</b> <?php echo e($data->lot_no); ?>                   
                                    <br> <b> Total balance Weight :</b><?php echo e($data->bale_weight); ?>                                                               
                                    </p>
                                        

                                        </div>
 </div>

                                    </div>
                                </div>

                                
                                <?php
                               
                                 $sub_total1 = 0;
                                 $sub_total2 = 0;
                                 $sub_total3 = 0;
                                 $sub_total4 = 0;
                                 $sub_total5 = 0;
                                 $gland_total = 0;
                                 $tax=0;
                                 $i =1;
       
                                 ?>

                               <div class="table-responsive mb-lg">
            <table class="table items invoice-items-preview" page-break-inside:="" auto;="">
                <thead class="bg-items">
                    <tr>
                        <th style="color:white; text-align:center;"  colspan="10" class="align-centre"><centre>SPECIFICATION FOR 100 BALES FULL PRESSED LIT AR/BR</centre></th>
                      
                    </tr>
                     <tr>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Bale</centre></th>
                        <th style="color:white; text-align:center;"class="align-centre"><centre>Kg</centre></th>
                      
                    </tr>
                </thead>
                                    <tbody>
                                      
                                        <?php
                                     
                                         ?>
                                       <tr>
                                       <?php $i=0; ?>
                                       <?php $__currentLoopData = $data->productionList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php 
                                       $i++; 
                                       if($i <21)
                                       $sub_total1 += $row->bale;
                                        if($i <41 && $i >20)
                                       $sub_total2 += $row->bale;
                                       if($i <61 && $i >40)
                                       $sub_total3 += $row->bale;
                                        if($i <81 && $i >60)
                                       $sub_total4 += $row->bale;
                                        if($i <101 && $i >80)
                                       $sub_total5 += $row->bale;
                                       ?>
                                       <td><?php echo e($i); ?></td>
                                       <td><?php echo e($row->bale); ?></td>
                                       
                                       <?php if(fmod($i, 5) == 0 ): ?>
                                       </tr>
                                       <tr>
                                       <?php elseif($i == count($data->productionList)): ?>
                                        </tr>
                                       <?php endif; ?>
                                       
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      

                                       
                                    </tbody>
</table>
                            </div>

                                     <div class="row" >
                                     <div class="col-lg-4">    <p class="pull-left">
                    <table style="border:1px;">
                 
                <tr><td><b>Avg Bale weight Gross</b></td><td><?php echo e($data->gross_weight/$i); ?></td><td><b>Unit</b></td><td>Kg</td></tr>
                <tr><td><b>Avg Bale weight Net</b></td><td><?php echo e($data->net_weight/$i); ?></td><td><b>Unit</b></td><td>Kg</td></tr>
                 <tr><td></td><td>.</td><td></td><td></td></tr>
                <tr><td clospan="1">No of Bales Sampled Nos</td><td><?php echo e($i); ?></td><td></td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                
              
                
                </table>
                </p></div>
                                              <div class="col-lg-4"> </div>
                                        <div class="col-lg-4 pv">

                <div class="clearfix">
                    <p class="pull-right">
                    <table style="border:1px;">
                 <tr><td colspan="2">RECALCULATION</td></tr>
                <tr><td>1-20</td><td><?php echo e($sub_total1); ?> Kg</td></tr>
                <tr><td>21-40</td><td><?php echo e($sub_total2); ?> Kg</td></tr>
                <tr><td>41-60</td><td><?php echo e($sub_total3); ?> Kg</td></tr>
                <tr><td>61-80</td><td><?php echo e($sub_total4); ?> Kg</td></tr>
                <tr><td>81-100</td><td><?php echo e($sub_total5); ?> Kg</td></tr>
                <tr><td>GROSS</td><td><?php echo e($data->gross_weight); ?> Kg</td></tr>
                <tr><td>TALE</td><td><?php echo e($data->tale); ?></td> Kg</tr>
                <tr><td>NET</td><td><?php echo e($data->net_weight); ?> Kg</td></tr>
                <tr><td></td><td>.</td><td></td><td></td></tr>
                
                
                  
                
                </table>
                </p>
                </div>

</div>


                                
                             
                            </div>

                        </div>

                    </div>
                </div>
            </div>

         

        </div>
    </div>
</section>


   
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/cotton/productionDetails.blade.php ENDPATH**/ ?>