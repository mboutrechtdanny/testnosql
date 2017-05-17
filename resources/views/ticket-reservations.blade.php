@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="page-header">
            <h1>Ticket / maaltijd reservaties</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

                <table class="table">
                    <tr>
                        <td>Dag</td>
                        <td>Aantal tickets gekocht</td>
                    </tr>
                    @foreach($ticket_counts as $ticket_count)
                        <tr>
                            <td>{{ $ticket_count->titel }}</td>
                            <td>{{ $ticket_count->count }}</td>
                        </tr>
                    @endforeach
                </table>

                <table class="table">
                    <tr>
                        <td>Dag</td>
                        <td>Aantal maaltijden gekocht</td>
                    </tr>
                    @foreach($meal_counts as $meal_count)
                        <tr>
                            <td>{{ $meal_count->titel }}</td>
                            <td>{{ $meal_count->count }}</td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection