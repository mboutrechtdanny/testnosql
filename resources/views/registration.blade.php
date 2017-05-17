@extends('layouts.app')

@section('content')

    <style>
        .disabled {
            z-index: 1000;
            opacity: 0.6;
            pointer-events: none;
        }

        #zalen-wrapper table {
            table-layout: fixed;
            margin-bottom: 5px;
        }

        #zalen-wrapper table tr td:first-child {
            width: 120px;
        }

        #zalen-wrapper .zaal, #zalen-wrapper .times {
            font-weight: bold;
        }

        #zalen-wrapper table > tbody > tr:last-child > td {
            border: none;
        }

        .slot {
            color: #3F4850;
            font-size: 1.4em;
            padding: 2px;
            cursor: pointer;
            border: 2px solid;
        }

        .slot:hover {
            opacity: 0.9;
        }

        .slot-open {
            border-color: #4DD84D;
            background-color: #67F167;
        }

        .slot-voorbehoud {
            border-color: #FFAD16;
            background-color: #FDC660;
        }

        .slot-bezet {
            border-color: #F74343;
            background-color: #FF7B7B;
        }

    </style>

    <div class="container">

        <div class="page-header">
            <h1>Inschrijven als spreker</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong><br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/registration') }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="day">Dag</label>
                        <div class='input-group date' id='datetimepicker1'>
                            <input name="day" id="day" type='text' class="form-control"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="zalen-wrapper"></div>
                    </div>

                    <div class="form-group">
                        <p><b>Gekozen slot</b></p>
                        <ul class="list-group">
                            <li id="chosen-slot" class="list-group-item"></li>
                        </ul>
                        <p><b>Gekozen slot(s) onder voorbehoud</b></p>
                        <ul class="list-group">
                            <li id="chosen-slots-in-progress" class="list-group-item"></li>
                        </ul>

                        <input type="hidden" id="chosen-slot-id" name="chosen-slot-id">
                        <input type="hidden" id="chosen-slots-in-progress-ids" name="chosen-slots-in-progress-ids">
                    </div>

                    <div class="alert alert-info">
                        <p>Indien u kosten moet maken dient u dat hier op te geven.</p>
                    </div>

                    <div class="form-group">
                        <label for="kosten">Kosten in euro's</label>
                        <div class="input-group">
                            <div class="input-group-addon">&euro;</div>
                            <input type="text" class="form-control" name="kosten" id="kosten"
                                   value="{{ old('kosten') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Naam</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="address">Adres</label>
                        <input type="text" name="address" id="address" class="form-control"
                               value="{{ old('address') }}">
                    </div>

                    <div class="form-group">
                        <label for="subject">Onderwerp</label>
                        <input type="text" name="subject" id="subject" class="form-control"
                               value="{{ old('subject') }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Beschrijving</label>
                        <input type="text" name="description" id="description" class="form-control"
                               value="{{ old('description') }}">
                    </div>

                    <div class="form-group">
                        <label for="wishes">Wensen</label>
                        @foreach($wishes as $wish)
                            <br>
                            @if(is_array(old('wishes')) && in_array($wish, old('wishes')))
                                <input type="checkbox" name="wishes[]" value="{{ $wish }}" checked> {{ ucfirst($wish) }}
                            @else
                                <input type="checkbox" name="wishes[]" value="{{ $wish }}"> {{ ucfirst($wish) }}
                            @endif
                        @endforeach
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Inschrijven</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {

            var getObjectByValue = function (arr, key, val) {
                var items = jQuery.grep(arr, function (a) {
                    return a[key] == val;
                });
                if (items.length)
                    return items[0];
                else return {};
            };

            var today = new Date(2016, 11 - 1, 4);

            var picker = $('#datetimepicker1');

            picker.datetimepicker({
                locale: 'nl',
                format: 'dddd D-MM-YYYY',
                defaultDate: today
            });

            var table_template = $(
                '<table class="table agenda-table">' +
                '<tbody>' +
                '<tr class="times"><td></td></tr>' +
                '<tr class="slots"><td class="zaal"></td></tr>' +
                '</tbody>' +
                '</table>'
            );

            var slots = [];

            // wrapper voor alle zaal tables
            var wrapper = $('#zalen-wrapper');

            var chosenSlot = null;
            var chosenSlotsInProgress = [];

            var updateChosenSlotsElements = function () {

                var chosenSlotElement = $('#chosen-slot').empty();
                var chosenSlotsInProgressElement = $('#chosen-slots-in-progress').empty();

                var chosenSlotField = $('#chosen-slot-id').val('');
                var chosenSlotsInProgressField = $('#chosen-slots-in-progress-ids').val('');

                if (chosenSlot != null) {

                    var slot = getObjectByValue(slots, 'id', chosenSlot);

                    chosenSlotElement.html(
                        'Zaal ' + slot['zaal'] + '&nbsp;' +
                        slot['tijdstart'].slice(0, -3) + ' - ' + slot['tijdeind'].slice(0, -3)
                    );

                    chosenSlotField.val(chosenSlot);
                }

                chosenSlotsInProgress.forEach(function (chosenSlotInProgress, index) {

                    var slot = getObjectByValue(slots, 'id', chosenSlotInProgress);

                    chosenSlotsInProgressElement.append(
                        '<b>' + (index + 1) + 'e keuze</b>&nbsp;Zaal ' + slot['zaal'] + '&nbsp;' +
                        slot['tijdstart'].slice(0, -3) + ' - ' + slot['tijdeind'].slice(0, -3) +
                        '<br>'
                    );

                    chosenSlotsInProgressField.val(chosenSlotsInProgressField.val() + chosenSlotInProgress + ',')
                });
            };

            var onSlotClick = function (e) {

                var slotClicked = $(e.target);
                var clickedElement = false;

                if (slotClicked.is('div')) {
                    clickedElement = true;

                } else if (slotClicked.is('input')) {
                    // klikt op checkbox ipv element
                    clickedElement = true;
                    // reset checkbox (dit verwerken we later)
                    slotClicked[0].checked = !slotClicked[0].checked;
                    slotClicked = slotClicked.parent();
                }

                if (clickedElement) {

                    var slotId = slotClicked.attr('id').slice(5);
                    var slotData = getObjectByValue(slots, 'id', slotId);

                    if (slotData) {

                        var checkbox = slotClicked.find('input');
                        var isChecked = checkbox.prop('checked');

                        if (slotData['status'] == 'open') {

                            // kan slot op elk moment op disabled zetten
                            if (isChecked) {
                                chosenSlot = null;
                                checkbox.prop('checked', false);
                            } else {
                                // als slot aangevinkt moet worden moeten
                                // we eerst kijken of er al een chosenSlot is
                                // en het slot element zoeken en checkbox false maken

                                if (chosenSlot != null) {

                                    wrapper.find('#slot-' + chosenSlot).find('input').prop('checked', false);
                                }

                                chosenSlot = slotId;

                                checkbox.prop('checked', true);
                            }
                        } else if (slotData['status'] == 'voorbehoud') {

                            if (isChecked) {
                                chosenSlotsInProgress.splice($.inArray(slotId, chosenSlotsInProgress), 1);

                                checkbox.prop('checked', false);
                            } else {

                                if (chosenSlotsInProgress.length < 3) {

                                    if ($.inArray(slotId, chosenSlotsInProgress) == -1) {
                                        chosenSlotsInProgress.push(slotId);
                                    }

                                    checkbox.prop('checked', true);
                                }
                                else {
                                    alert('Maximaal 3 keuzes voor slots onder voorbehoud')
                                }
                            }
                        } else if (slotData['status'] == 'bezet') {
                            alert('Dit slot is bezet.')
                        }
                    }

                    updateChosenSlotsElements();
                }
            };

            var updateSlots = function (dateString) {

                chosenSlot = null;
                chosenSlotsInProgress = [];

                wrapper.css('opacity', 0.5);

                $.ajax({
                    method: 'GET',
                    url: '{{ url('registration/slots') }}',
                    data: {date: dateString},
                    dataType: 'json',
                    success: function (data) {

                        wrapper.css('opacity', 1);

                        wrapper = wrapper.empty();
                        wrapper.off('click', '.slots', onSlotClick);

                        slots = data['slots'];

                        slots.forEach(function (slot) {

                            if (!wrapper.has('#zaal-' + slot['zaal']).length) {
                                var clone = table_template.clone();
                                clone.attr('id', 'zaal-' + slot['zaal']);
                                clone.find('.zaal').text(slot['beschrijving']);
                                wrapper.append(clone);
                            }

                            var table = wrapper.find('#zaal-' + slot['zaal']);

                            var disabled = slot['status'] == 'bezet' ? 'disabled' : '';

                            table.find('.times').append(
                                '<td>' + slot['tijdstart'].slice(0, -3) + ' - ' + slot['tijdeind'].slice(0, -3) + '</td>'
                            );
                            table.find('.slots').append('<td>' +
                                '<div id="slot-' + slot['id'] + '" class="slot ' + 'slot-' + slot['status'] + '">' +
                                '<input type="checkbox" ' + disabled + '>&nbsp;' + slot['status'] + '</div>' +
                                '</td>'
                            );
                        });

                        wrapper.on('click', '.slots', onSlotClick);
                    },
                    error: function () {

                        wrapper.css('opacity', 1);
                        wrapper.html('<p class="alert alert-warning">Geen slots gevonden voor deze dag</p>');

                    }
                });

                updateChosenSlotsElements();
            };

            updateSlots(today.toDateString());

            picker.on("dp.change", function (e) {
                updateSlots(e.date.toDate().toDateString());
            });

        });
    </script>
@endsection