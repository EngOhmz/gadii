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


    //
    // Setup module components
    //

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
                    url : '{{ route('calendar.edit', $project->id) }}'
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

            // Initialize the external events
            new FullCalendar.Draggable(calendarEventsContainerElement, {
                itemSelector: '.fc-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText.trim(),
                        backgroundColor: eventEl.getAttribute('data-color'),
                        borderColor: eventEl.getAttribute('data-color')
                    }
                }
            });

            // Initialize the calendar
            const calendarEventsInit = new FullCalendar.Calendar(calendarEventsElement, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                
                direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                events: events,
                drop: function(arg) {
                    if (checkboxElement.checked) {
                        arg.draggedEl.parentNode.removeChild(arg.draggedEl);
                    }
                }
            });

            // Init
            calendarEventsInit.render();

            // Resize calendar when sidebar toggler is clicked
            $('.sidebar-control').on('click', function() {
                calendarEventsInit.updateSize();
            });
        }
    };

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
                    url : '{{ route('calendar.edit', $project->id) }}'
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
                selectable: true,
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
                eventClick: function(arg) {
                    if (confirm('Are you sure you want to delete this event?')) {
                        arg.event.remove();
                    }
                },
                editable: true,
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
