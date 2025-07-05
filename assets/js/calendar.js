$(document).ready(function () {
    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        editable: true,
        dayMaxEvents: true,
        displayEventTime: false,
        eventLimit: true,
        dayMaxEventRows: true,

        events: {
            url: "Admin/loadEventData",
            type: "POST",
            error: function () {
                alert("Failed to load events.");
            }
        },
    eventDataTransform: function (event) {
        if (event.task_id && event.end) {
            let newStart = event.end;
            let newEnd = moment(event.end).add(1, 'days').format('YYYY-MM-DDTHH:mm:ss');
            event.start = newStart;
            event.end = newEnd;
        }
        return event;
    },
        eventRender: function (event, element) {
            // If task_id exists and end date is available, shift the event 1 day forward
            if (event.task_id && event.end) {
                const newStart = event.end;
                const newEnd = moment(event.end).add(1, 'days').format('YYYY-MM-DDTHH:mm:ss');

                event.start = newStart;
                event.end = newEnd;
            }

            if (event.client_name) {
                const clientUrl = "https://thecreditrepairxperts.com/dashboard/" + event.client_id;
                element.find('.fc-title').html(
                    `${event.title} (<a href="${clientUrl}" target="_blank" class="text-white">${event.client_name}</a>)`
                );
            }

            if (event.task_id) {
                element.css({
                    'background-color': '#1cc94e',
                    'border-color': '#1cc94e',
                    'color': '#fff'
                });
            }

            event.allDay = event.allDay === 'true' || event.allDay === true;
        },

        selectable: true,
        selectHelper: true,

        select: function (start, end) {
            var select = $("#team_members").val();
            let formattedStart = moment(start).format('YYYY-MM-DDTHH:mm:ss');
            let formattedEnd = moment(end).format('YYYY-MM-DDTHH:mm:ss');
            let displayWhen = moment(start).format('dddd, MMMM Do YYYY, h:mm A') + ' - ' + moment(end).format('h:mm A');

            $('#createEventModal #startTime').val(formattedStart);
            $('#createEventModal #select').val(select);
            $('#createEventModal #endTime').val(formattedEnd);
            $('#createEventModal #when').text(displayWhen);
        },

        eventDrop: function (event) {
            let start = moment(event.start).format("YYYY-MM-DD HH:mm:ss");
            let end = moment(event.end).format("YYYY-MM-DD HH:mm:ss");

            $.ajax({
                url: 'Admin/edit_event',
                type: "POST",
                data: {
                    title: event.title,
                    start: start,
                    end: end,
                    id: event.id
                },
                success: function () {
                    updateevent("Event date changed successfully");
                }
            });
        },

        eventClick: function (event) {
            let date = moment(event.start).format('ddd, MMM D, YYYY');
            let dateend = moment(event.end).format('ddd, MMM D, YYYY');

            $('#eventTitle').html(`<strong>${event.title}</strong>`);
            $('#eventDate').text(date);
            $('#eventDateend').text(dateend);
            $('#eventClient').html(`<b>Client:</b> ${event.client_name || 'N/A'}`);
            $('#eventDetailsModal').data('event-id', event.id);

            $('#editEventBtn').off('click').on('click', function () {
                $('#eventDetailsModal').modal('hide');
            });

            $('#deleteEventBtn').off('click').on('click', function () {
                openmydeletepopup(event.id);
                $('#eventDetailsModal').modal('hide');
            });

            $('#eventDetailsModal').modal('show');
        }
    });

    // Filtering by team members
    $("#team_members").on("change", function () {
        var select = $(this).val();

        $('#calendar').fullCalendar('removeEvents');
        $('#calendar').fullCalendar('removeEventSources');

        $('#calendar').fullCalendar('addEventSource', {
            url: "Admin/loadEventData",
            type: "POST",
            data: { select: select },
            error: function () {
                alert("Failed to reload filtered events.");
            }
        });

        $('#calendar').fullCalendar('refetchEvents');
    });
});

function displayMessage(message) {
    $(".response").html("<div class='success'>" + message + "</div>");
    setTimeout(function () {
        $(".success").fadeOut();
    }, 1000);
}
