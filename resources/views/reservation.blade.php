@extends('layouts.app')

@section('content')

    <style>
        .disabled {
            z-index: 1000;
            opacity: 0.6;
            pointer-events: none;
        }
    </style>

    <div class="container">

        <div class="page-header">
            <h1>Tickets reserveren</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

                <div class="alert alert-info">
                    <p>
                        <b>Letop</b> u kunt max. {{ env('MAX_TICKETS') }} tickets en max. {{ env('MAX_MEALS') }}
                        maaltijden bestellen per reservering.
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

                <form action="{{ url('/reservation') }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="naam" class="col-sm-2 control-label">Naam</label>
                        <div class="col-sm-10">
                            <input type="text" name="naam" class="form-control" id="naam" placeholder="Naam"
                                   value="{{ old('naam') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email"
                                   value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">Ticket overzicht</div>
                        <div class="panel-body">
                            <table class="table">
                                @foreach($ticket_types as $ticket_type)
                                    <tr class="price-block">
                                        <td>
                                            <label for="ticket-{{ $ticket_type->id }}">{{ $ticket_type->titel }}</label>
                                        </td>
                                        <td>&euro;&nbsp;<span class="price">{{ $ticket_type->prijs }}</span></td>
                                        <td>
                                            <input type="number" name="ticket-{{ $ticket_type->id }}"
                                                   id="ticket-{{ $ticket_type->id }}" class="form-control"
                                                   placeholder="Aantal"
                                                   value="{{ old('ticket-' . $ticket_type->id) }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <input type="checkbox" class="checkbox-inline" name="order-meal" id="order-meal"
                                   {{ old('order-meal') ? 'checked' : '' }} style="padding: 0;">
                            <label for="order-meal">Maaltijd bestellen</label>
                        </div>
                        <div class="panel-body">
                            <table class="table disabled" id="meal-table">
                                @foreach($maaltijd_types as $maaltijd_type)
                                    <tr class="price-block">
                                        <td>
                                            <label for="maaltijd-{{ $maaltijd_type->id }}">{{ $maaltijd_type->titel }}</label>
                                        </td>
                                        <td>&euro;&nbsp;<span class="price">{{ $maaltijd_type->prijs }}</span></td>
                                        <td>{{ $maaltijd_type->omschrijving }}</td>
                                        <td>{{ $maaltijd_type->tijdstart }} - {{ $maaltijd_type->tijdeind }}</td>
                                        <td>
                                            <input type="number" name="maaltijd-{{ $maaltijd_type->id }}"
                                                   id="maaltijd-{{ $maaltijd_type->id }}" class="form-control"
                                                   placeholder="Aantal"
                                                   value="{{ old('maaltijd-' . $maaltijd_type->id) }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                    <p>Totale prijs: &euro;&nbsp;<span id="total-price">0</span></p>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <select name="payment" id="payment" class="form-control">
                                <option value="ideal">iDeal</option>
                                <option value="factuur">Factuur</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-default">Reserveer</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        var order_meal = $("input#order-meal");

        if (order_meal.attr('checked')) {
            $('#meal-table').removeClass('disabled');
        }

        order_meal.change(function () {
            if (this.checked) {
                $('#meal-table').removeClass('disabled');
            } else {
                $('#meal-table').addClass('disabled');
            }
        });

        var total_price = $('#total-price');

        var calculate_total_price = function () {
            var values = $('form').find('input[type=number]');

            var total = 0;
            values.each(function (i, e) {
                var count = parseInt(e.value);
                if (count) {
                    var value = $(e).closest('.price-block').find('.price').text();
                    total += count * parseFloat(value);
                }
            });

            total_price.text(Math.round(total * 100) / 100);
        };

        calculate_total_price();

        $('form').on('change', 'input[type=number]', calculate_total_price);
    </script>
@endsection