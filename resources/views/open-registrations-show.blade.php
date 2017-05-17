@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="page-header">
            <h1>Individuele open inschrijving</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

                <div class="well">
                    Sprekers budget &euro;{{ $budget->budget }} / &euro;{{ $budget->budget_start }}
                </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Spreker</th>
                        <th>Slot</th>
                        <th>Status</th>
                        <th>Heeft slot?</th>
                        <th>Onderwerp</th>
                        <th>Deadline</th>
                        <th>Kosten</th>
                        <th>Wensen</th>
                        <th>Actie</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>{{ $aanvraag['naam'] }}</td>
                        <td>{{ $aanvraag['slot_id'] }}</td>
                        <td>{{ $aanvraag['status'] }}</td>
                        <td>{{ $aanvraag['aanvraag_spreker_id'] == $aanvraag['slot_spreker_id'] ? 'Ja' : 'Nee' }}</td>
                        <td>{{ $aanvraag['onderwerp'] }}</td>
                        <td>{{ $aanvraag['deadline']->diffForHumans() }}</td>
                        <td>&euro; {{ $aanvraag['kosten'] }}</td>
                        <td>{{ $aanvraag['wensen'] }}</td>
                        <td style="display: flex;">
                            <a href="{{ url('/open-registrations/' . $aanvraag['id'] . '/accept/1') }}" class="btn btn-success">Accepteren</a>&nbsp;
                            <a href="{{ url('/open-registrations/' . $aanvraag['id'] . '/negotiate') }}" class="btn btn-warning">Onderhandelen</a>&nbsp;
                            <a href="{{ url('/open-registrations/' . $aanvraag['id'] . '/accept/0') }}" class="btn btn-danger">Afwijzen</a>&nbsp;
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection