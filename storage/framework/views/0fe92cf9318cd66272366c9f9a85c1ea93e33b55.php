<?php $__env->startSection('content'); ?>

<section class="section">
  <div class="row ">
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="card bg-cyan">
        <div class="card-statistic-4">
          <div class="align-items-center justify-content-between">
            <div class="row ">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 pr-0 pt-3">
                <div class="card-content">
                  <h5 class="font-15">Total Cash </h5>
                  <h5 class="font-15">Issued</h5>
                  <h4 class="mb-3 font-18"><?php echo e(number_format($cash_issued)); ?> Tsh</h4>
                 
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>


     <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="card bg-green">
        <div class="card-statistic-4">
          <div class="align-items-center justify-content-between">
            <div class="row ">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 pr-0 pt-3">
                <div class="card-content">
                  <h5 class="font-15">Available Stock</h5>
                  <h5 class="font-15">Balance</h5>
                 <h4 class="mb-3 font-18"><?php echo e(number_format($balance)); ?> Kg</h4>
                
                 
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
      <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="card bg-blue ">
        <div class="card-statistic-4">
          <div class="align-items-center justify-content-between">
            <div class="row ">
              <div class="col-lg-8 col-md-12 col-sm-12 col-xs-6 pr-0 pt-3">
                <div class="card-content">
                  <h5 class="font-15">Expected Cotton in Kg</h5>
                 <table class="table">
                  <tr>
                  <td><strong>Expected Cotton:</strong></td>             
                  <td><?php echo e($expected['raw']); ?> KG</td>
                  </tr>
                  <tr>
                  <td><strong>Expected Seed:<strong></td>
                  <td><?php echo e($expected['seed']); ?> KG</td>
                     </tr>
                   <tr>
                  <td><strong>Expected Dust:<strong></td>
                  <td><?php echo e($expected['dust']); ?> KG</td></tr>
                  </table>
                
                 
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
         <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="card">
        <div class="card-statistic-4">
          <div class="align-items-center justify-content-between">
            <div class="row ">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 pr-0 pt-3">
                <div class="card-content">
                  <h5 class="font-15">Cotton Received By District </h5>
                  <p>
                   <table id="data-table" class="table table-striped table-condensed table-hover">
                <thead>
                   <tr>
                  <td><strong>District</strong></td>
                   <td><strong>Quantity in Kg</strong></td>
                   
                   <td><strong>Value in Tsh</strong></td>
</thead>
                  </tr>
                  <?php $__currentLoopData = $district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                  <td><strong><?php echo e($row->name); ?></strong></td> 
                  <?php 
                  $movement = \App\Models\Cotton\CottonMovement::where('district_id',$row->id)->sum('quantity');
                  $amount = \App\Models\Cotton\CottonMovement::where('district_id',$row->id)->sum('amount');
                 // $quantity = \App\Models\Cotton\PurchaseCotton::where('district_id',$row->id)->sum('quantity')-$movement;
                  //$value = \App\Models\Cotton\PurchaseCotton::where('district_id',$row->id)->sum('purchase_amount')-$amount;
                  ?>
                  <td style=""><?php echo e(!empty($movement) ? number_format($movement) : "0.00"); ?></td>
                  
                  <td style=""><?php echo e(!empty($amount) ? number_format($amount) : "0.00"); ?></td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </table>
                  </p>
                 
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="card">
        <div class="card-statistic-4">
          <div class="align-items-center justify-content-between">
            <div class="row ">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 pr-0 pt-3">
                <div class="card-content">
                  <h5 class="font-15">Latest Price By District in (Tsh)</h5>
                  <p class="pull-left">
                  <table id="data-table" class="table table-striped table-condensed table-hover">
                   <tr>
                  <td><strong>District</strong></td>
                   <td><strong>Price</strong></td>
                  </tr>
                  <?php $__currentLoopData = $district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <tr>
                  <td><strong><?php echo e($row->name); ?></strong></td>
                  <?php
                  $data = \App\Models\Cotton\PurchaseCotton::all()->where('district_id',$row->id)->last();
                  ?>
                  <td style=""><?php echo e(!empty($data) ? number_format($data->price) : "Not Set"); ?></td>
                  </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </table>
                 </p>
                 
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
            <div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="card">
        <div class="card-statistic-4">
          <div class="align-items-center justify-content-between">
            <div class="row ">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6 pr-0 pt-3">
                <div class="card-content">
                  <h5 class="font-15">Cash Graph (Tsh)</h5>
                      <div id="monthly_actual_expected_data" class="chart" style="height: 320px;">
                        </div>
                 
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
   <script src="<?php echo e(asset('assets/amcharts/amcharts.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/amcharts/serial.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/amcharts/pie.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/amcharts/themes/light.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/amcharts/plugins/export/export.min.js')); ?>"
            type="text/javascript"></script>
    <script>
        AmCharts.makeChart("monthly_actual_expected_data", {
            "type": "serial",
            "theme": "light",
            "autoMargins": true,
            "marginLeft": 30,
            "marginRight": 8,
            "marginTop": 10,
            "marginBottom": 26,
            "fontFamily": 'Open Sans',
            "color": '#888',

            "dataProvider": <?php echo $monthly_actual_expected_data; ?>,
            "valueAxes": [{
                "axisAlpha": 0,

            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b> [[value]]</b> [[additional]]</span>",
                "bullet": "round",
                "bulletSize": 8,
                "lineColor": "#370fc6",
                "lineThickness": 4,
                "negativeLineColor": "#0dd102",
                "title": "Revenue",
                "type": "smoothedLine",
                "valueField": "cash"
            }, {
                "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b> [[value]]</b> [[additional]]</span>",
                "bullet": "round",
                "bulletSize": 8,
                "lineColor": "#d1655d",
                "lineThickness": 4,
                "negativeLineColor": "#d1cf0d",
                "title": "Expenses",
                "type": "smoothedLine",
                "valueField": "value_village"
            }],
            "categoryField": "month",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "tickLength": 0,
                "labelRotation": 30,

            }, "export": {
                "enabled": true,
                "libs": {
                    "path": "<?php echo e(asset('assets/amcharts/plugins/export/libs')); ?>/"
                }
            }, "legend": {
                "position": "bottom",
                "marginRight": 100,
                "autoMargins": false
            },


        });

    </script>



</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/web/gaki.ema.co.tz/public_html/resources/views/agrihub/dashboard.blade.php ENDPATH**/ ?>