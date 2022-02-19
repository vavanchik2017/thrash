<?
    require_once($_SERVER["DOCUMENT_ROOT"]."/inc/config.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/inc/db_func.php");
    require_once('ajax.php');
    $prop = getAllVarietes();
    $prop1 = getAllCities();
?>
<!DOCTYPE html>
<html>

<head>
    <title>FullCalendar</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel='stylesheet' type='text/css' href='css/style.css' />
    <link rel='stylesheet' type='text/css' href='css/fullcalendar.css' />
    <link rel='stylesheet' type='text/css' href='css/jquery-ui-1.8.11.custom.css' />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
    <script src="js/jquery-ui-1.8.11.custom.min.js"></script>
    <script src='js/fullcalendar.min.js'></script>
    <script src="js/jquery-ui-timepicker-addon.js"></script>
    <script src='https://unpkg.com/popper.js/dist/umd/popper.min.js'></script>
    <script src='https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js'></script>
    <script type="text/javascript">
        $(function() {
            /* глобальные переменные */
            var event_id = $('#event_id');
            var event_start = $('#event_start');
            var event_end = $('#event_end');
            var event_meetName = $('#event_meetName');
            var event_cityName = $('#event_cityName');
            var event_streetName = $('#event_streetName');
            var calendar = $('#calendar');
            var calendarEl = document.getElementById('calendar');
            var form = $('#dialog-form');
            var format = "MM/dd/yyyy HH:mm";
            var streets;
            var events;
            /* кнопка добавления события */
            $('#add_event_button').button().click(function() {
                formOpen('add');
            });
            $('#bestTime').button().click(function() {
                $('#dialogTime').dialog("open")
            });
            /** функция очистки формы */
            function emptyForm() {
                event_id.val("");
                event_start.val("");
                event_end.val("");
                event_meetName.val("");
                event_cityName.val("");
                event_streetName.val("");
            }
            /* режимы открытия формы */
            function formOpen(mode) {
                if (mode == 'add') {
                    /* скрываем кнопки Удалить, Изменить и отображаем Добавить*/
                    $('#add').show();
                    $('#edit').hide();
                    $("#delete").button("option", "disabled", true);
                } else if (mode == 'edit') {
                    /* скрываем кнопку Добавить, отображаем Изменить и Удалить*/
                    $('#edit').show();
                    $('#add').hide();
                    $("#delete").button("option", "disabled", false);
                }
                form.dialog('open');
            }
            /* инициализируем Datetimepicker */
            event_start.datetimepicker({
                hourGrid: 4,
                minuteGrid: 10,
                dateFormat: 'mm/dd/yy'
            });
            event_end.datetimepicker({
                hourGrid: 4,
                minuteGrid: 10,
                dateFormat: 'mm/dd/yy'
            });
            /* инициализируем FullCalendar */
            calendar.fullCalendar({
                firstDay: 1,
                height: 500,
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
                monthNamesShort: ['Янв.', 'Фев.', 'Март', 'Апр.', 'Май', 'Июнь', 'Июль', 'Авг.', 'Сент.', 'Окт.', 'Ноя.', 'Дек.'],
                dayNames: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
                dayNamesShort: ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"],
                buttonText: {
                    prev: "&nbsp;&#9668;&nbsp;",
                    next: "&nbsp;&#9658;&nbsp;",
                    prevYear: "&nbsp;&lt;&lt;&nbsp;",
                    nextYear: "&nbsp;&gt;&gt;&nbsp;",
                    today: "Сегодня",
                    month: "Месяц",
                    week: "Неделя",
                    day: "День"
                },
                /* формат времени выводимый перед названием события*/
                timeFormat: 'H:mm',
                /* обработчик события клика по определенному дню */
                dayClick: function(date, allDay, jsEvent, view) {
                    var newDate = $.fullCalendar.formatDate(date, format);
                    event_start.val(newDate);
                    event_end.val(newDate);
                    formOpen('add');
                },
                /* обработчик кликак по событияю */
                eventClick: function(calEvent, jsEvent, view) {
                    console.log(calEvent)
                    event_id.val(calEvent.id);
                    event_meetName.val(calEvent.title);
                    event_cityName.val(calEvent.cityName);
                    event_streetName.val(calEvent.streetName);
                    event_start.val($.fullCalendar.formatDate(calEvent.start, format));
                    event_end.val($.fullCalendar.formatDate(calEvent.end, format));
                    formOpen('edit');
                },

                // eventRender: function(element, event) {
                //     element.attr("categories", event.cityName)

                // },
                /* источник записей */
                eventSources: [{
                    url: 'ajax.php',
                    type: 'POST',
                    data: {
                        op: 'source'
                    },
                    error: function() {
                        alert('Ошибка соединения с источником данных!');
                    },
                    success: function(id) {
                        events = id
                        console.log(events)
                        bestTimePlace(events)
                    }
                }]
            });

            /* обработчик формы добавления */
            form.dialog({
                autoOpen: false,
                buttons: [{
                        id: 'add',
                        text: 'Добавить',
                        click: function() {
                            console.log(event_cityName.val())
                            $.ajax({
                                type: "POST",
                                url: "ajax.php",
                                data: {
                                    start: event_start.val(),
                                    end: event_end.val(),
                                    meetName: event_meetName.val(),
                                    cityName: event_cityName.val(),
                                    streetName: event_streetName.val(),
                                    op: 'add'
                                },

                                success: function(id) {
                                    calendar.fullCalendar('renderEvent', {
                                        id: id,
                                        title: event_meetName.val(),
                                        start: event_start.val(),
                                        end: event_end.val(),
                                        allDay: false
                                    });

                                    calendar.fullCalendar('refetchEvents')
                                }
                            });
                            $(this).dialog('close');

                        }
                    },
                    {
                        id: 'edit',
                        text: 'Изменить',
                        click: function() {

                            $.ajax({
                                type: "POST",
                                url: "ajax.php",
                                data: {
                                    id: event_id.val(),
                                    start: event_start.val(),
                                    end: event_end.val(),
                                    meetName: event_meetName.val(),
                                    op: 'edit'
                                },
                                success: function(id) {
                                    calendar.fullCalendar('refetchEvents');

                                }
                            });
                            $(this).dialog('close');
                            emptyForm();
                        }
                    },
                    {
                        id: 'cancel',
                        text: 'Отмена',
                        click: function() {
                            $(this).dialog('close');
                            emptyForm();
                        }
                    },
                    {
                        id: 'delete',
                        text: 'Удалить',
                        click: function() {
                            $.ajax({
                                type: "POST",
                                url: "ajax.php",
                                data: {
                                    id: event_id.val(),
                                    op: 'delete'
                                },
                                success: function(id) {
                                    console.log('delete', id)
                                    calendar.fullCalendar('removeEvents', id);
                                    calendar.fullCalendar('refetchEvents');
                                }
                            });
                            $(this).dialog('close');
                            emptyForm();
                        },
                        disabled: true
                    },
                    {
                        id: 'showStreets',
                        text: 'Показать',
                        click: function() {
                            console.log(event_cityName.val())
                            $.ajax({
                                type: "POST",
                                url: "ajax.php",
                                data: {
                                    cityName: event_cityName.val(),
                                    op: 'showStreets'
                                },
                                success: function(id) {
                                    streets = JSON.parse(id)
                                    console.log(streets)
                                    showStreets()
                                }
                            });

                        },

                    },


                ]

            });

            $('#dialogTime').dialog({
                buttons: [{
                    text: "Close",
                    click: () => $('#dialogTime').dialog("close")
                }, ],
                modal: true,
                autoOpen: false,
                width: 340,
            })

            function showStreets() {
                var arrayHtml = '';
                for (var i = 0; i < streets.length; i++) {
                    var streetVal = streets[i].streetName
                    arrayHtml += '<option>' + streets[i].streetName + '</option>'
                }
                document.getElementById('event_streetName').innerHTML = arrayHtml
                addValues()
            }

            function addValues() {
                var qwe = document.getElementById("event_streetName").options
                console.log(qwe[0])
                for (var i = 0; i < qwe.length; i++) {
                    qwe[i].value = streets[i].streetName
                }
            }

            function mostCommonDay(eventDates) {
                console.log('----------------------------')
                var max_frk = 1
                var num = eventDates[0]
                for (var i = 0; i < eventDates.length; i++) {
                    console.log('eventDates[i]', eventDates[i])
                    var frk = 1
                    for (var j = i + 1; j < eventDates.length; j++) {
                        console.log('eventDates[j]', eventDates[j])
                        if (eventDates[i] == eventDates[j]) {
                            frk += 1
                        }
                    }
                    console.log('frk', frk)
                    if (frk > max_frk) {
                        max_frk = frk;
                        num = eventDates[i]
                    }
                    console.log('num', num)
                }
                console.log('----------------------------')
                return num


            }

            function bestTimePlace(events) {
                console.log(calendar.fullCalendar.eventSources)
                var starthours = 0;
                var endhours = 0;
                var averageStartDate
                var averageEndDate;
                var eventDates = [];
                var max = 0;
                console.log(events)
                events.map((item, i) => {
                    console.log('!!!!!!!!!!!!!!!!!!!', i)
                    var date = new Date(item.start)
                    // qwe[i] = new Object({title: item.title, cityName: item.cityName, streetName: item.streetName, start: date.getDate()})
                    eventDates[i] = date.getDate()
                    //console.log(date.getDate())
                })
                delete eventDates[0]
                var eventDates = eventDates.filter(Number)
                console.log(eventDates)
                var day = mostCommonDay(eventDates)
                console.log('day', day)
                events.map(item => {
                    var date = new Date(item.start)
                    if (date.getDate() == day) {
                        console.log(date)
                        var date = new Date(item.start)
                        starthours += parseInt(date.getHours())
                        console.log('starthours', starthours)
                        var date = new Date(item.end)
                        endhours += parseInt(date.getHours())
                    }
                })
                averageStartDate = starthours / events.length
                averageEndDate = endhours / events.length

                console.log(averageStartDate)
                console.log(averageEndDate)
                $('#dialogTime').dialog().text("Лучше всего провести встречу: " + day + " числа, с " + parseInt(averageStartDate) + " до " + parseInt(averageEndDate) + " часов");
            }


        });
    </script>

</head>

<body>

    <div id="calendar" class='calendar'></div>
    <? 
    if ($_SESSION["logUser"]) {
    ?>
    <button id="add_event_button">Добавить событие</button>
    <div id="dialog-form" title="Событие">
        <p class="validateTips"></p>
        <form>
            <p><label for="event_meetName">Название встречи</label>
                <input type="text" id="event_meetName" name="event_meetName" value=""></p>
            <p><label for="event_cityName">Город</label>
                <select id="event_cityName" name="event_cityName">
                    <? 
                        foreach($prop1 as $pItem) {
                            echo <<< NItem
                            <option value="{$pItem['cityName']}">{$pItem['cityName']}</option>
NItem;
                        }
                    ?>
                </select>
            </p>
            <p><label for="event_streetName">Улица</label>
                <select id="event_streetName" name="event_streetName">

                </select>
            </p>
            <p><label for="event_start">Начало</label>
                <input type="text" name="event_start" id="event_start" /></p>
            <p><label for="event_end">Конец</label>
                <input type="text" name="event_end" id="event_end" /></p>
            <input type="hidden" name="event_id" id="event_id" value="">
        </form>
    </div>
    <button id="bestTime">Расчитать удобное время</button>
    <div id="dialogTime" title="Удобное время">
        <div class="container">
            <div class="input_wrapper">

            </div>
        </div>
    </div>
    <? }?>


</body>

</html>