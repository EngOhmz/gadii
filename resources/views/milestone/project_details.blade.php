@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Milestone->{{$data->name}}</h4>
                    </div>
                    <div class="card-body">
                       <div class="row">
						<div class="col-lg-8 offset-2">
							<div class="card">
								<div class="card-header">
									
								</div>

								<div class="card-body">
									<div class="d-lg-flex">
										<ul class="nav nav-tabs nav-tabs-vertical flex-column mr-lg-3 wmin-lg-200 mb-lg-0 border-bottom-0">
											<li class="nav-item"><a href="#vertical-left-tab1" class="nav-link active" data-toggle="tab"><i class="icon-menu7 mr-2"></i> Milestone Details</a></li>
											<li class="nav-item"><a href="#vertical-left-tab2" class="nav-link" data-toggle="tab"><i class="icon-mention mr-2"></i> Comments</a></li>
											<li class="nav-item"><a href="#vertical-left-tab3" class="nav-link" data-toggle="tab"><i class="icon-mention mr-2"></i> Attachment</a></li>
											<li class="nav-item"><a href="#vertical-left-tab4" class="nav-link" data-toggle="tab"><i class="icon-mention mr-2"></i> Tasks</a></li>
											<li class="nav-item"><a href="#vertical-left-tab5" class="nav-link" data-toggle="tab"><i class="icon-mention mr-2"></i> Notes</a></li>
											
												<li class="nav-item"><a href="#vertical-left-tab6" class="nav-link" data-toggle="tab"><i class="icon-mention mr-2"></i> Invoice</a></li>
													<li class="nav-item"><a href="#vertical-left-tab7" class="nav-link" data-toggle="tab"><i class="icon-mention mr-2"></i> Credit Note</a></li>
														<li class="nav-item"><a href="#vertical-left-tab8" class="nav-link" data-toggle="tab"><i class="icon-mention mr-2"></i> Expenses</a></li>
															<li class="nav-item"><a href="#vertical-left-tab9" class="nav-link" data-toggle="tab"><i class="icon-mention mr-2"></i> Estimate</a></li>
										
										</ul>

										<div class="tab-content flex-lg-fill">
											<div class="tab-pane fade show active" id="vertical-left-tab1">
												Basic vertical tabs with left nav using <code>.nav-tabs-vertical</code> class.
											</div>

											<div class="tab-pane fade" id="vertical-left-tab2">
											Number 2
											</div>

											<div class="tab-pane fade" id="vertical-left-tab3">
											Number 3
											</div>

											<div class="tab-pane fade" id="vertical-left-tab4">
												Number 4
											</div>
											<div class="tab-pane fade" id="vertical-left-tab5">
												Number 5.
											</div>
											
											<div class="tab-pane fade" id="vertical-left-tab6">
												Number 6.
											</div>
											<div class="tab-pane fade" id="vertical-left-tab7">
												Number 7.
											</div>
											<div class="tab-pane fade" id="vertical-left-tab8">
												Number 8.
											</div>
											
											<div class="tab-pane fade" id="vertical-left-tab9">
												Number 9.
											</div>
										</div>
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



@endsection

@section('scripts')


<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [
                {"targets": [3]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>
<script>
var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[5] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);



</script>
<script>
$(document).ready(function() {

    $(document).on('change', '.account_id', function() {
        var id = $(this).val();
  console.log(id);
      
 $.ajax({
            url: '{{url("gl_setup/findSupplier")}}',
            type: "GET",
            data: {
                id: id,
            },
 dataType: "json",
            success: function(data) {
              console.log(data); 
          $("#supplier").css("display", "none");
         if (data == 'OK') {
           $("#supplier").css("display", "block");   
}
     

 }

        });

    });



});

</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection