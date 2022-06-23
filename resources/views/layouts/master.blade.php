<!DOCTYPE html>
<html lang="en">

 @include('layouts.header')

<body>
<!-- Main navbar -->
	@include('layouts.main_navbar')
<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">
	<!-- Main sidebar -->
	@include('layouts.aside2')
	<!-- /main sidebar -->
	


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
				<div class="page-header page-header-light">
					<div class="page-header-content header-elements-lg-inline">
						<div class="page-title d-flex">
							<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">@yield('title-left')</span> - @yield('title-right')</h4>
							<a href="#" class="header-elements-toggle text-body d-lg-none"><i class="icon-more"></i></a>
						</div>
						</div>
					</div>
				</div>
				<!-- /page header -->


				<!-- Content area -->
				<div class="content">
				@include('layouts.alerts.message')
				@yield('content')

				</div>
				<!-- /content area -->


				<!-- Footer -->
				<div class="navbar navbar-expand-lg navbar-light">
					@include('layouts.footer2')
				</div>
				<!-- /footer -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>
