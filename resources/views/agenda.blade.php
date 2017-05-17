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

        .slot-bezet {
            border-color: #4DD84D;
            background-color: #67F167;
        }
    </style>

    <div class="container">

        <select name="" id="day_template" style="display: none">
            <option value="vrijdag">Vrijdag</option>
            <option value="donderdag">Donderdag</option>
            <option value="wfewf">wefwef</option>
        </select>

        <div class="page-header">
            <h1>Agenda</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

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

                <!-- Modal -->
                <div id="sprekerModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Spreker <span id="modal-title"></span></h4>
                            </div>
                            <div class="modal-body">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Slot</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p>Zaal: <span id="modal-zaal"></span></p>
                                        <p>Datum: <span id="modal-date"></span></p>
                                        <p>Tijd: <span id="modal-tijd"></span></p>
                                        <p>Onderwerp: <span id="modal-onderwerp"></span></p>
                                        <p>Beschrijving: <span id="modal-beschrijving"></span></p>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Tags</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="modal-tags"></div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Contact Spreker</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p>Naam: <span id="modal-spreker-naam"></span></p>
                                        <p>Email: <span id="modal-spreker-email"></span></p>
                                        <p>Adres: <span id="modal-spreker-adres"></span></p>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

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

            var slots = [];

            // wrapper voor alle zaal tables
            var wrapper = $('#zalen-wrapper');

            var modal = $("#sprekerModal");

            var onSlotClick = function (e) {

                var slotClicked = $(e.target);

                var slotId = slotClicked.attr('id').slice(5);
                var slotData = getObjectByValue(slots, 'id', slotId);

                modal.find('#modal-title').text(slotData['naam']);

                modal.find('#modal-zaal').text(slotData['zaal_beschrijving']);
                modal.find('#modal-date').text(today.toLocaleDateString());
                modal.find('#modal-tijd').text(slotData['tijdstart'] + ' - ' + slotData['tijdeind']);
                modal.find('#modal-onderwerp').text(slotData['aanvraag_onderwerp']);
                modal.find('#modal-beschrijving').text(slotData['aanvraag_beschrijving']);

                modal.find('#modal-spreker-naam').text(slotData['naam']);
                modal.find('#modal-spreker-email').text(slotData['email']);
                modal.find('#modal-spreker-adres').text(slotData['adres']);

                var tags_list = '<ul>';
                for (var i in slotData['slots_tags']) {
                    tags_list += '<li>' + slotData['slots_tags'][i] + '</li>';
                }
                tags_list += '</ul>';

                modal.find('#modal-tags').html(tags_list);

                modal.modal('show');

            };

            var table_template = $(
                '<table class="table agenda-table">' +
                '<tbody>' +
                '<tr class="times"><td></td></tr>' +
                '<tr class="slots"><td class="zaal"></td></tr>' +
                '</tbody>' +
                '</table>'
            );

            var updateSlots = function (dateString) {

                wrapper.css('opacity', 0.5);

                $.ajax({
                    method: 'GET',
                    url: '{{ url('agenda/slots') }}',
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
                                clone.find('.zaal').text(slot['zaal_beschrijving']);
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
                                    slot['aanvraag_onderwerp'] + '</div>' +
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

                        // add click listener to slots
                        wrapper.on('click', '.slots', onSlotClick);
                    },
                    error: function () {

                        wrapper.css('opacity', 1);
                        wrapper.html('<p class="alert alert-warning">Geen slots gevonden voor deze dag</p>');

                    }
                });

            };

            updateSlots(today.toDateString());

            picker.on("dp.change", function (e) {
                updateSlots(e.date.toDate().toDateString());
            });

        });
    </script>
@endsection