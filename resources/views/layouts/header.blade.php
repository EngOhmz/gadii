<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <?php
    $system = App\Models\System::first();
    ?>

    <!--<title>@yield('title', 'EMA') | {{ $system->name }}</title>-->

    <title> GAD ERP. </title>

    <style>
        .required {
            color: red;
        }

        .hr3 {
            height: 15px;
            border: 0;
            box-shadow: inset 0 12px 12px -12px rgba(9, 84, 132);
        }
         #error-msg {
            color: #EA4335;
        }
        #valid-msg {
            color: #34A853;
        }
    </style>


    

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets2/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets2/css/datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet">
    <link href="{{ asset('assets2/css/timepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dateTime.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dateTime.min.css') }}">
    <!-- /global stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://gaki.ema.co.tz/assets/amcharts/plugins/export/export.css">

    <!-- Global stylesheets -->

        
        <link href="https://demo.interface.club/limitless/demo/template/assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
	<link href="https://demo.interface.club/limitless/demo/template/assets/icons/phosphor/styles.min.csss" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
        
   <link rel="stylesheet" href="{{ asset('assets/intl/css/intlTelInput.css') }}">


    <!-- Core JS files -->

    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>


    <script src="{{ asset('global_assets/js/plugins/visualization/charts-js/charts.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/visualization/echarts/echarts.min.js') }}">
        < script src = "{{ asset('assets/js/bootstrap3-typeahead.min.js') }}" >
    </script>
    <!-- /core JS files -->

    <!-- /dropzone -->
    <script src="{{ asset('assets/dropzone/js/dropzone.min.js') }}"></script>
    <link href="{{ asset('assets/dropzone/css/dropzone.min.css') }}" rel="stylesheet" />
    <!-- dropzone -->


    <script src="https://demo.interface.club/limitless/demo/template/assets/js/vendor/uploaders/fileinput/fileinput.min.js">
    </script>
    <script
        src="https://demo.interface.club/limitless/demo/template/assets/js/vendor/uploaders/fileinput/plugins/sortable.min.js">
    </script>
    <script src="https://demo.interface.club/limitless/demo/template/assets/demo/pages/uploader_bootstrap.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js">
    </script>

    <script src="{{ asset('global_assets/js/plugins/pickers/daterangepicker.js') }}"></script>



    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#timepicker1,#timepicker2").datetimepicker({
                format: 'LT'
            });
        })
    </script>
    <!--chart-->
    <script src="https://d3js.org/d3.v4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/billboard.js/dist/billboard.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/billboard.js/dist/billboard.min.css" />
    <link rel="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" type="text/css" />

    <!-- button short cut -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>


    <!-- new js -->


    <!-- end new js -->

    </script>
    <script src="{{ url('assets/js/jquery.bootstrap-growl.min.js') }}"></script>


    <script>
        $(function() {

            @if (Session::has('success'))
                $.bootstrapGrowl('{{ Session::get('success') }}', {
                    type: 'success',
                    delay: 4000,
                });
            @endif

            @if (Session::has('error'))
                $.bootstrapGrowl('{{ Session::get('error') }}', {
                    type: 'danger',
                    delay: 4000,
                });
            @endif

            @if (Session::has('info'))
                $.bootstrapGrowl('{{ Session::get('info') }}', {
                    type: 'info',
                    delay: 4000,
                });
            @endif

            @if (Session::has('warning'))
                $.bootstrapGrowl('{{ Session::get('warning') }}', {
                    type: 'warning',
                    delay: 4000,
                });
            @endif
        });
    </script>



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
