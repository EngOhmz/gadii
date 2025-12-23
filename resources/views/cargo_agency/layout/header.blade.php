<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



    <title>@yield('title', '') | Madekenya Logistics</title>

    @livewireStyles
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets2/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <!-- Core JS files -->

    <!-- Core JS files -->


    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->


    <!-- Theme JS files -->
    <script src="{{ asset('global_assets/js/plugins/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>

    <script src="{{ asset('assets2/js/app.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/dashboard.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/streamgraph.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/sparklines.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/lines.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/areas.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/donuts.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/bars.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/progress.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/heatmaps.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/pies.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_charts/pages/dashboard/light/bullets.js') }}"></script>

    <!-- Theme JS files -->
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('global_assets/js/demo_pages/datatables_basic.js') }}"></script>



    <!-- /theme JS files -->
    <!-- /theme JS files -->

    <script type="text/javascript" src="{{ asset('assets2/js/downloadFile.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>





    <!-- new js -->
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>

    <script src="{{ asset('assets2/js/app.js') }}"></script>
    <script src="{{ asset('global_assets/js/demo_pages/datatables_extension_buttons_html5.js') }}"></script>

    <!-- end new js -->


    <script src="https://logistic.ema.co.tz/assets/bundles/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ asset('assets/js/all.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/jautocalc.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <script src="{{ asset('assets/jQuery/jQuery.print.js') }}"></script>

    {!! Html::script('assets/js/loader.js') !!}
    {!! Html::script('plugins/table/datatable/datatables.js') !!}
    <!--  The following JS library files are loaded to use Copy CSV Excel Print Options-->
    {!! Html::script('plugins/table/datatable/button-ext/dataTables.buttons.min.js') !!}
    {!! Html::script('plugins/table/datatable/button-ext/jszip.min.js') !!}
    {!! Html::script('plugins/table/datatable/button-ext/buttons.html5.min.js') !!}
    {!! Html::script('plugins/table/datatable/button-ext/buttons.print.min.js') !!}
    <!-- The following JS library files are loaded to use PDF Options-->
    {!! Html::script('plugins/table/datatable/button-ext/pdfmake.min.js') !!}
    {!! Html::script('plugins/table/datatable/button-ext/vfs_fonts.js') !!}
    {!! Html::script('global_assets/js/main/bootstrap.bundle.min.js') !!}

    <script>
        $(document).ready(function() {
            /*
             * Multiple drop down select
             */
            $('.m-b').select2({
                width: '100%',
            });



        });
    </script>
    <!-- Stack array for including inline js or scripts -->
    @stack('plugin-scripts')

    @stack('custom-scripts')


    <!-- Stack array for including inline css or head elements -->
    @stack('plugin-styles')





    <script type="text/javascript">
        function CheckAll(obj) {
            var row = obj.parentNode.parentNode;
            var inputs = row.getElementsByTagName("input");

            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == "checkbox") {
                    inputs[i].checked = obj.checked;
                }

            }
        }
    </script>

    <script>
        $(document).ready(function() {

            $('#select-all').click(function() {

                $('input[type="checkbox"]').prop('checked', this.checked);

            })

        });
    </script>



</head>
