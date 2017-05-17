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

        #zalen-wrapper .zaal, #zalen-wrapper .times {
            font-weight: bold;
        }

        #zalen-wrapper table > tbody > tr:last-child > td {
            border: none;
        }

        .slot {
            padding: 2px;
            cursor: pointer;
            border: 2px solid;
            font-size: small;
        }

        .slot:hover {
            opacity: 0.9;
        }

        .slot-open {
            /*border-color: #4DD84D;*/
            /*background-color: #67F167;*/
        }

        .slot-voorbehoud {
            /*border-color: #FFAD16;*/
            /*background-color: #FDC660;*/
        }

        .slot-bezet {
            border-color: #4DD84D;
            background-color: #67F167;
        }

    </style>

    <div class="container">

        <div class="page-header">
            <h1>Voorreservering maken</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

                <div class="alert alert-info">
                    <p>
                        <b>Letop</b> u kunt max. 4 voorreserveringen maken per dag.
                    </p>
                </div>

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
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="reservation_id">Reservatie ID</label>
                        <input type="text" name="reservation_id" id="reservation_id" class="form-control" value="{{ old('reservation_id') }}">
                    </div>

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
                        <p><b>Gekozen spreker</b></p>
                        <ul class="list-group">
                            <li id="chosen-slot" class="list-group-item"></li>
                        </ul>
                        <input type="hidden" id="chosen-slot-id" name="chosen-slot-id">
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

            var today = new Date(2016, 10 - 1, 14);

            var picker = $('#datetimepicker1');

            picker.datetimepicker({
                locale: 'nl',
                format: 'dddd D-MM-YYYY',
                defaultDate: today
            });

            var table_template = $(
                    '<table class="table">' +
                    '<tbody>' +
                    '<tr class="times"><td></td></tr>' +
                    '<tr class="slots"><td class="zaal"></td></tr>' +
                    '</tbody>' +
                    '</table>'
            );

            // wrapper voor alle zaal tables
            var wrapper = null;

            // array met slotdata opgehaald
            var slots = null;

            var chosenSlot = null;

            var updateChosenSlotsElements = function () {

                var chosenSlotElement = $('#chosen-slot').empty();
                var chosenSlotField = $('#chosen-slot-id').val('');

                if (chosenSlot != null) {

                    var slot = getObjectByValue(slots, 'id', chosenSlot);

                    chosenSlotElement.html(
                            '<p>Zaal ' + slot['zaal'] + '&nbsp;' +
                            slot['tijdstart'].slice(0, -3) + ' - ' + slot['tijdeind'].slice(0, -3) + '</p>' +
                            '<p>Spreker: naam: ' + slot['spreker']['naam'] + ' email ' + slot['spreker']['email'] + '</p>' +
                            '<p>Onderwerp: CSS</p>'
                    );

                    console.log(slot);

                    chosenSlotField.val(chosenSlot);
                }
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

                        if (slotData['status'] == 'bezet') {

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

                        } else {
                            alert('Dit slot heeft (nog) geen spreker.')
                        }
                    }

                    updateChosenSlotsElements();
                }
            };

            var updateSlots = function (dateString) {

                chosenSlot = null;

                wrapper = $('#zalen-wrapper').empty();

                wrapper.off('click', '.slots', onSlotClick);

                $.ajax({
                    method: 'GET',
                    url: '{{ url('/specific-reservation/slots') }}',
                    data: {date: dateString},
                    dataType: 'json',
                    success: function (data) {
                        slots = data['slots'];

                        slots.forEach(function (slot) {

                            if (!wrapper.has('#zaal-' + slot['zaal']).length) {
                                var clone = table_template.clone();
                                clone.attr('id', 'zaal-' + slot['zaal']);
                                clone.find('.zaal').text(slot['beschrijving']);
                                wrapper.append(clone);
                            }

                            var table = wrapper.find('#zaal-' + slot['zaal']);

                            var hasSpreker = slot['status'] == 'bezet';

                            var disabled = hasSpreker ? '' : 'disabled';

                            table.find('.times').append(
                                    '<td>' + slot['tijdstart'].slice(0, -3) + ' - ' + slot['tijdeind'].slice(0, -3) + '</td>'
                            );

                            if (hasSpreker) {
                                table.find('.slots').append('<td>' +
                                        '<div id="slot-' + slot['id'] + '" class="slot ' + 'slot-' + slot['status'] + '">' +
                                        '<input type="checkbox" ' + disabled + '>&nbsp;' + slot['spreker']['naam'] + '</div>' +
                                        '</td>'
                                );
                            } else {
                                table.find('.slots').append('<td>' +
                                        '<div id="slot-' + slot['id'] + '" class="slot ' + 'slot-' + slot['status'] + '">' +
                                        '&nbsp;' +
                                        '</td>'
                                );
                            }

                        });

                        wrapper.on('click', '.slots', onSlotClick);
                    },
                    error: function () {
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