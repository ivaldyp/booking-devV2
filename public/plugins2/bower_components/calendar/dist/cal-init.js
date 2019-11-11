

!function($) {
    "use strict";

    var CalendarApp = function() {
        this.$body = $("body")
        this.$calendar = $('#calendar'),
        this.$event = ('#calendar-events div.calendar-events'),
        this.$categoryForm = $('#add-new-event form'),
        this.$extEvents = $('#calendar-events'),
        this.$modal = $('#my-event'),
        this.$saveCategoryBtn = $('.save-category'),
        this.$calendarObj = null
    };


    /* on drop */
    CalendarApp.prototype.onDrop = function (eventObj, date) { 
        var $this = this;
            // retrieve the dropped element's stored Event Object
            var originalEventObject = eventObj.data('eventObject');
            var $categoryClass = eventObj.attr('data-class');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            // assign it the date that was reported
            copiedEventObject.start = date;
            if ($categoryClass)
                copiedEventObject['className'] = [$categoryClass];
            // render the event on the calendar
            $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                eventObj.remove();
            }
    },
    /* on click on event */
    CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view) {
        var $this = this;
            var form = $("<form></form>");
            form.append("<div class='col-sm-12' style='padding-top:10px'>")
            form.append("<label style='padding-top:6px' class='col-sm-2 control-label'>Acara</label>");
            form.append("<div class='input-group col-sm-9'><input class='form-control' type=text disabled value='" + calEvent.title + "' /></div></div>");

            form.append("<div class='col-sm-12' style='padding-top:10px'>")
            form.append("<label style='padding-top:6px' class='col-sm-2 control-label'>Ruang</label>");
            form.append("<div class='input-group col-sm-9'><input class='form-control' type=text disabled value='" + calEvent.room_name + "' /></div></div>");

            form.append("<div class='col-sm-12' style='padding-top:10px'>")
            form.append("<label style='padding-top:6px' class='col-sm-2 control-label'>Tanggal</label>");
            form.append("<div class='input-group col-sm-9'><input class='form-control' type=text disabled value='" + calEvent.book_date + "' /></div></div>");

            form.append("<div class='col-sm-12' style='padding-top:10px'>")
            form.append("<label style='padding-top:6px' class='col-sm-2 control-label'>Waktu</label>");
            form.append("<div class='input-group col-sm-9'><input class='form-control' type=text disabled value='" + calEvent.time_start + " - " + calEvent.time_end + "' /></div></div>");

            form.append("<div class='col-sm-12' style='padding-top:10px'>")
            form.append("<label style='padding-top:6px' class='col-sm-2 control-label'>Deskripsi</label>");
            form.append("<div class='input-group col-sm-9'><textarea rows='5' disabled class='form-control'>"+ calEvent.detail +"</textarea></div></div>");


            $this.$modal.modal({
                backdrop: 'static'
            });
            $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                    return (ev._id == calEvent._id);
                });
                $this.$modal.modal('hide');
            });
            $this.$modal.find('form').on('submit', function () {
                calEvent.title = form.find("input[type=text]").val();
                $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                $this.$modal.modal('hide');
                return false;
            });
    },
    /* on select */
    CalendarApp.prototype.onSelect = function (start, end, allDay) {
        var $this = this;
            $this.$modal.modal({
                backdrop: 'static'
            });
            var form = $("<form></form>");
            form.append("<div class='row'></div>");
            form.find(".row")
                .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>")
                .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>")
                .find("select[name='category']")
                .append("<option value='bg-danger'>Danger</option>")
                .append("<option value='bg-success'>Success</option>")
                .append("<option value='bg-purple'>Purple</option>")
                .append("<option value='bg-primary'>Primary</option>")
                .append("<option value='bg-pink'>Pink</option>")
                .append("<option value='bg-info'>Info</option>")
                .append("<option value='bg-warning'>Warning</option></div></div>");
            $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                form.submit();
            });
            $this.$modal.find('form').on('submit', function () {
                var title = form.find("input[name='title']").val();
                var beginning = form.find("input[name='beginning']").val();
                var ending = form.find("input[name='ending']").val();
                var categoryClass = form.find("select[name='category'] option:checked").val();
                if (title !== null && title.length != 0) {
                    $this.$calendarObj.fullCalendar('renderEvent', {
                        title: title,
                        start:start,
                        end: end,
                        allDay: false,
                        className: categoryClass
                    }, true);  
                    $this.$modal.modal('hide');
                }
                else{
                    alert('You have to give a title to your event');
                }
                return false;
                
            });
            $this.$calendarObj.fullCalendar('unselect');
    },
    CalendarApp.prototype.enableDrag = function() {
        //init events
        $(this.$event).each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
    }
    /* Initializing */
    CalendarApp.prototype.init = function() {
        // this.enableDrag();
        /*  Initialize the calendar  */
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';
        var today = new Date($.now());

        var datas;
        $.ajax({
            url: "/booking-dev/home/read",
            type: "get",
            success: function(data){

                for(var i=0; i<data.length; i++)
                {
                    var safeColors = ['#800000','#ffa500','#808000','#800080','#008000','#000080','#008080','#808080','#3a87ad'];
                    var rand = function() {
                        return Math.floor(Math.random()*6);
                    };
                    var randomColor = function() {
                        var colorrand = safeColors[rand()];
                        return colorrand;
                    };

                    var booking_date2 = data[i].booking_date.split("-");

                    var time1 = data[i].time1.time_name.split(" ");
                    var time_start = time1[1].split(":");

                    var time2 = data[i].time2.time_name.split(" ");
                    var time_end = time2[1].split(":");

                    var newEvent = {
                        title: data[i].surat.surat_judul   ,
                        start: (data[i].booking_date + " " + time_start[0] + ":" + time_start[1]),
                        end: (data[i].booking_date + " " + time_end[0] + ":" + time_end[1]),
                        detail: data[i].surat.surat_deskripsi,
                        book_date: booking_date2[2] + "-" + booking_date2[1] + "-" + booking_date2[0],
                        time_start: time_start[0] + ":" + time_start[1],
                        time_end: time_end[0] + ":" + time_end[1],
                        room_name: data[i].room.room_name,
                        color: randomColor()
                    };
                    $('#calendar').fullCalendar( 'renderEvent', newEvent , 'stick');    
                }
            }
        });

        var $this = this;
        $this.$calendarObj = $this.$calendar.fullCalendar({
            plugins: [ 'list' ],
            slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
            minTime: '07:00:00',
            maxTime: '17:00:00',  
            defaultView: 'month',  
            // aspectRatio: 0.5,
            handleWindowResize: true,   
             
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
            },
            // events: defaultEvents,
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            // drop: function(date) { $this.onDrop($(this), date); },
            // select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
            eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }

        });

        //on new event
        this.$saveCategoryBtn.on('click', function(){
            var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
            var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
            if (categoryName !== null && categoryName.length != 0) {
                $this.$extEvents.append('<div class="calendar-events bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-move"></i>' + categoryName + '</div>')
                $this.enableDrag();
            }

        });
    },

   //init CalendarApp
    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
    
}(window.jQuery),

//initializing CalendarApp
function($) {
    "use strict";
    $.CalendarApp.init()
}(window.jQuery);