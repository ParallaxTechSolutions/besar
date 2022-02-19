$(function () {
    function groupBy(objectArray, property) {
        return objectArray.reduce(function (acc, obj) {
          var key = obj[property];
          if (!acc[key]) {
            acc[key] = [];
          }
          var data = {
              name: key
          };
          acc[key].push(obj);
          return acc;
        }, {});
      }
    
    function bookRoom(data) {
        $("#save-room-booking").attr("disabled", true);
        $.ajax({
            url: "/web88cms/placeorder",
            method: "POST",
            data: data,
            success: function(response) {
                window.location.reload();
            },
            error: function(err) {}
        });
    }

    $(document).ready(function () {


        /* initialize the external events
         -----------------------------------------------------------------*/

        var eventDrag = function (el) {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            console.log( el.data('color'));
            var eventObject = {
                title: $.trim(el.text()) + ', '+ $.trim(el.data("email"))+', '+$.trim(el.data('telephone')), // use the element's text as the event title
                backgroundColor: el.data('color'),
                id: el.data('id'),
                product_id: el.data('product_id'),
                email: el.data('email')
            };

            // store the Event Object in the DOM element so we can get to it later
            el.data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            el.draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        }

        $('#external-events div.external-event').each(function () {
            eventDrag($(this));
        });


        /* initialize the calendar
         -----------------------------------------------------------------*/
        var _clients;
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped
                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');
                
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                var client = _clients.filter(client => client.id === copiedEventObject.id);
                console.log("_clients_clients", client);
                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                copiedEventObject.backgroundColor = client[0]['backgroundColor'];

                var checkin_date = moment(date).format("YYYY-MM-DD");
                var checkout_date = moment(date).add(1, 'days').format("YYYY-MM-DD");
               
                var data = {
                    shipping_email: copiedEventObject.email,
                    checkin_date: checkin_date,
                    checkout_date: checkout_date,
                    avail_rooms: copiedEventObject.product_id,
                    _token: $("._token").val()
                };
                bookRoom(data);
                console.log(copiedEventObject, data);

                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }

            },
            events: {
                url: '/web88cms/get_order',
                method: "GET",
                success: function(response) {
                    console.log(response);
                    var grouped = groupBy(response, 'title');
                    let clients = [];
                    var clientList = "";
                    for (var key in grouped) {
                        if (grouped.hasOwnProperty(key)) {
                            console.log(key + " -> ", grouped[key]);
                            var client = {
                                name: grouped[key][0]['full_name'],
                                id: grouped[key][0]['customer_id'],
                                backgroundColor: grouped[key][0]['backgroundColor'],
                                total: grouped[key].length
                            };
                            clientList += '<div style="background:'+client.backgroundColor+'" class="external-event label">'+ client.name +' ('+ client.total +')</div>';
                            clients.push(client);
                            $('div[data-id="'+client.id+'"]')
                                .removeClass("display-none")
                                .css("background", client.backgroundColor)
                                .attr("data-color", client.backgroundColor);
                        }
                    }
                    _clients = clients;
                    console.log(clients, clientList);
                }
            },
            dayClick:  function(date, allDay, jsEvent, view) {

                if (allDay) {
                  console.log('Clicked on the entire day: ' + moment(date).format("DD-MM-YYYY"));
                }else{
                    console.log('Clicked on the slot: ' + moment(date).format("DD-MM-YYYY"));
                }
            
                console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
                var checkin_date = moment(date).format("YYYY-MM-DD");
                var checkout_date = moment(date).add(1, 'days').format("YYYY-MM-DD");
                $.ajax({
                    url: '/web88cms/get-available-rooms?start_date='+checkin_date+'&end_date='+checkout_date,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        let rooms = '';
                        response.forEach(function(room) {
                            console.log(room);
                            rooms += '<option value="'+room.id+'">'+room.type+' (RM '+room.sale_price+') </option>';
                        });

                        $(".avail_rooms").html(rooms);
                    }
                })
                console.log('Current view: ' + view.name);
                $(".checkin_date").val(checkin_date);
                $(".checkout_date").val(checkout_date);
                $("#open-booking-modal").modal("show");
                // change the day's background color just for fun
                // $(this).css('background-color', 'red');
            
              }
            // events: [
            //     {
            //         title: "Yi Mei, yi.mei@webqom.com, 0166269561",
            //         start: "2020-06-20"
            //     }
            //     // etc...
            // ]
        });

        var addEvent = function (name) {
            name = name.length == 0 ? "Untitled Event" : name;
            var html = $('<div class="external-event label label-default">' + name + '</div>');
            $('#event-block').append(html);
            eventDrag(html);
        }

        $('#event-add').on('click', function () {
            var name = $('#event-name').val();
            addEvent(name);
        });

        $('#save-room-booking').click(function(e) {
            let isFilled = false;
            let formData = $("#room-booking").serializeArray().reduce(function(obj, item) {
                isFilled = false;
                if(item.value) {
                    isFilled = true;
                }
                obj[item.name] = item.value;
                return obj;
            }, {});
            var checkin = $('#Ldate-arrival').val();
            var checkout = $('#Ldate-departure').val();
            console.log('checkin', checkin);
            console.log('checkout', checkout);
            if(formData.shipping_email && formData.shipping_name && formData.shipping_telephone) {
                console.log(formData);
                bookRoom(formData);
            } else {
                console.log("Fill data");
                $("#booking-notification").modal("show");
            }
        });

    });

});