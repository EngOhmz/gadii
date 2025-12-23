<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

   <?php
$settings= App\Models\System::first();

?>

	<title>{{$settings->name}}</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{asset('global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('assets2/css/all.min.css')}}" rel="stylesheet" type="text/css">

	<link href="{{asset('assets/css/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">



  
	<!-- /global stylesheets -->

	<!-- Core JS files -->


<script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
<script src="../../../../global_assets/js/demo_pages/components_modals.js"></script>




        <script src="{{url('assets/js/sweetalert2.all.min.js')}}"></script>
          <script src="{{url('assets/js/sweetalert2.min.js')}}"></script>
	<script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>

	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('global_assets/js/plugins/visualization/d3/d3.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script src="{{asset('global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>

	<script src="{{asset('assets2/js/app.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_pages/dashboard.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/streamgraph.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/sparklines.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/lines.js')}}"></script>	
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/areas.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/donuts.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/bars.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/progress.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/heatmaps.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/pies.js')}}"></script>
	<script src="{{asset('global_assets/js/demo_charts/pages/dashboard/light/bullets.js')}}"></script>

		<!-- Theme JS files -->
	<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>


    

	<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>

	<script src="{{asset('global_assets/js/demo_pages/datatables_basic.js')}}"></script>




<!-- /theme JS files -->
	<!-- /theme JS files -->

<script type="text/javascript" src="{{asset('assets2/js/downloadFile.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>
   
	  
  <!-- General JS Scripts -->
  <script src="{{url('assets/js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{url('assets/bundles/apexcharts/apexcharts.min.js')}}"></script>
  <script src="assets/bundles/select2/dist/js/select2.full.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="{{url('assets/js/page/index.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{url('assets/js/scripts.js')}}"></script>
  <script src="{{url('assets/bundles/prism/prism.js')}}"></script>
  <!-- Custom JS File -->
  <script src="{{url('assets/js/custom.js')}}"></script>
 <script src="{{url('assets/js/jautocalc.js')}}"></script>



  <script src="{{url('assets/bundles/datatables/datatables.min.js')}}"></script>
  <script src="{{url('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{url('assets/bundles/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{url('assets/js/page/datatables.js')}}"></script>
 <script src="{{url('assets/js/dateTime.min.js')}}"></script>
 <script src="{{url('assets/js/moment.min.js')}}"></script>

  <script src="{{url('assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js')}}"></script>
  <script src="{{url('assets/js/page/auth-register.js')}}"></script>
  <script src="{{url('assets/bundles/jquery-selectric/jquery.selectric.min.js')}}"></script>
  
   <script src="{{url('assets/bundles/chartjs/chart.min.js')}}"></script>
  <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>



	<script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>

  <!-- General JS Scripts -->
  <script src="{{url('assets/js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{url('assets/bundles/apexcharts/apexcharts.min.js')}}"></script>
  <script src="assets/bundles/select2/dist/js/select2.full.min.js"></script>


  




<script src="{{url('assets/js/jquery.bootstrap-growl.min.js')}}"></script>


<script>
$(function(){

    @if(Session::has('success'))
        $.bootstrapGrowl('{{ Session::get("success") }}',{
            type: 'success',
            delay: 4000,
        });
    @endif

    @if(Session::has('error'))
        $.bootstrapGrowl('{{ Session::get("error") }}',{
            type: 'danger',
            delay: 4000,
        });
    @endif

    @if(Session::has('info'))
        $.bootstrapGrowl('{{ Session::get("info") }}',{
            type: 'info',
            delay: 4000,
        });
    @endif

    @if(Session::has('warning'))
        $.bootstrapGrowl('{{ Session::get("warning") }}',{
            type: 'warning',
            delay: 4000,
        });
    @endif
});
</script>



	 <script type="text/javascript" >
    function CheckAll(obj){
        var row = obj.parentNode.parentNode;
        var inputs = row.getElementsByTagName("input");

        for(var i = 0; i < inputs.length; i++){
            if(inputs[i].type == "checkbox") {
                inputs[i].checked = obj.checked;
            }

        }
    }

    </script>

    <script>

$(document).ready(function(){

        $(#select-all).click( function()  {

    $('input[type="checkbox"]').prop('checked', this.checked);

})

});

</script>

  <!-- select2 JS File -->
  <script src="{{url('assets/js/select2.min.js')}}"></script>
 <script src="{{url('assets/js/form_select2.js')}}"></script>
<script>
    $(document).ready(function(){
   /*
                * Multiple drop down select
                */
$('.m-b').select2({ width: '100%', });
 

   
    });
   </script>

</head>