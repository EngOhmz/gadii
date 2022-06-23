@extends('layouts.master')

@section('content')

<section class="section">
  <div class="row ">
 
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
   <script src="{{ asset('assets/amcharts/amcharts.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/serial.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/pie.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/themes/light.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/plugins/export/export.min.js') }}"
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

            "dataProvider": {!! $monthly_actual_expected_data !!},
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
                    "path": "{{asset('assets/amcharts/plugins/export/libs')}}/"
                }
            }, "legend": {
                "position": "bottom",
                "marginRight": 100,
                "autoMargins": false
            },


        });

    </script>



</section>

@endsection