@extends('layouts.master_affiliate')

@section('content')

<section class="section">
<div class="section-body">
  <div class="row">
  
                                <div class="col-lg-3">
									<div class="card bg-teal text-white">
										<div class="card-body">
											<div class="d-flex"><h3 class="font-weight-semibold mb-0">0.00</h3></div>
						                	
						                	<div>No of Clients Registered By Your Reference Number</div>
												
										</div>
									</div>
									<!-- /members online -->
								</div>
								
								
								<div class="col-lg-3">
									<div class="card bg-teal text-white">
										<div class="card-body">
											<div class="d-flex"><h3 class="font-weight-semibold mb-0">0.00</h3></div>
						                	
						                	<div>Payment Already Paid By Company in this year<?php echo date('Y') ?> </div>
												
										</div>
									</div>
									<!-- /members online -->
								</div>
								
								
								
								<div class="col-lg-3">
									<div class="card bg-teal text-white">
										<div class="card-body">
											<div class="d-flex"><h3 class="font-weight-semibold mb-0">0.00</h3></div>
						                	
						                	<div>Payment Needs to Be Paid By Company in this year <?php echo date('Y') ?> </div>
												
										</div>
									</div>
									<!-- /members online -->
								</div>
								
								<div class="col-lg-3">
									<div class="card bg-primary text-white">
										<div class="card-body">
											<div class="d-flex"><h3 class="font-weight-semibold mb-0">{{auth()->user()->affiliate_no}}</h3></div>
						                	
						                	<div>Your Affiliate Number</div>
												
										</div>
									</div>
									<!-- /members online -->
								</div>
 
    </div>

    </div>

</section>  

<script src="{{url('assets/js/jquery.bootstrap-growl.min.js')}}"></script>
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

@endsection
  
  