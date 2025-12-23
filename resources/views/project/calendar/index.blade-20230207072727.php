@extends('layouts.master')

@push('plugin-styles')

<!-- Theme JS files -->

	<script src="{{asset('global_assets/js/plugins/ui/fullcalendar/main.min.js')}}"></script>

    <script>
    
    /* ------------------------------------------------------------------------------
 *
 *  # Fullcalendar advanced options
 *
 *  Demo JS code for extra_fullcalendar_advanced.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

const FullCalendarAdvanced = function() {


    // External events
    const _componentFullCalendarEvents = function() {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar is not loaded.');
            return;
        }

        // Add demo events
        // ------------------------------

        // Default events
        const events = [
                @foreach($projects as $project)
                {
                    title : '{{ $project->project_name }}',
                    start : '{{ $project->end_date }}',
                    url : '{{ route('project.show',$project->id) }}'
                },
                @endforeach
        ];


        //
        // External events
        //

        // Define components
        const calendarEventsContainerElement = document.getElementById('external-events-list');
        const calendarEventsElement = document.querySelector('.fullcalendar-external');
        const checkboxElement = document.getElementById('drop-remove');

        // Initialize
        if(calendarEventsElement) {

            // Use custom colors for external events
            const eventColors = calendarEventsContainerElement.querySelectorAll('.fc-event');
            eventColors.forEach(function(element) {
                element.style.borderColor = element.getAttribute('data-color');
                element.style.backgroundColor = element.getAttribute('data-color');
            });

          

            // Initialize the calendar
            const calendarEventsInit = new FullCalendar.Calendar(calendarEventsElement, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                
                direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                events: events,
                
            });

            // Init
            calendarEventsInit.render();

            // Resize calendar when sidebar toggler is clicked
            $('.sidebar-control').on('click', function() {
                calendarEventsInit.updateSize();
            });
        }
    };


//change the calendar here

    // FullCalendar RTL direction
    const _componentFullCalendarSelectable = function() {
        if (typeof FullCalendar == 'undefined') {
            console.warn('Warning - Fullcalendar files are not loaded.');
            return;
        }


        // Add demo events
        // ------------------------------

        // Default events
        const events = [
                @foreach($projects as $project)
                {
                    title : '{{ $project->project_name }}',
                    start : '{{ $project->end_date }}',
                    url : '{{ route('project.show',$project->id) }}'
                },
                @endforeach
        ];


        //
        // Selectable
        //

        // Define element
        const calendarSelectableElement = document.querySelector('.fullcalendar-selectable');

        // Initialize
        if(calendarSelectableElement) {
            const calendarSelectableInit = new FullCalendar.Calendar(calendarSelectableElement, {
                headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                
                navLinks: true, // can click day/week names to navigate views
                // selectable: true,
                selectMirror: true,
                events: events,
                select: function(arg) {
                    const title = prompt('Event Title:');
                    if (title) {
                        calendarSelectableInit.addEvent({
                            title: title,
                            start: arg.start,
                            end: arg.end,
                            allDay: arg.allDay
                        });
                    }
                    calendarSelectableInit.unselect();
                },
                
                direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                dayMaxEvents: true // allow "more" link when too many events
            });

            // Init
            calendarSelectableInit.render();

            // Resize calendar when sidebar toggler is clicked
            $('.sidebar-control').on('click', function() {
                calendarSelectableInit.updateSize();
            });
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentFullCalendarEvents();
            _componentFullCalendarSelectable();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FullCalendarAdvanced.init();
});

    
    
    
    </script>
	
	<!-- /theme JS files -->
@endpush
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                

                <!-- Selectable -->
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Project According To Due Date in Calendar</h5>
						</div>
						
						<div class="card-body">
				
			<!--	<p class="mb-3">In this example, Fullcalendar allows a user to highlight multiple days or timeslots by clicking and dragging. To let the user make selections by clicking and dragging, the <code>interaction</code> plugin must be loaded and this option must be set to <code>true</code>. You can either load it separately or use a global bundle (default). To use, set <code>selectable</code> option to <code>true</code>.</p> -->

							<div class="fullcalendar-selectable"></div>
						</div>
					</div>
					<!-- /selectable -->


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