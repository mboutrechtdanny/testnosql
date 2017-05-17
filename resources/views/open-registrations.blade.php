@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="page-header">
            <h1>Overzicht open registraties</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

                <p><a href="?show=all">Laat alle registraties zien</a></p>
                <br>

                <div class="well">
                    Sprekers budget &euro;{{ $budget->budget }} / &euro;{{ $budget->budget_start }}
                    <a href="#" id="change-budget" style="margin-left: 10px;">Budget aanpassen</a>
                    <div id="change-budget-container" style="display: none;margin-left: 10px;">
                        <form action="{{ url('budget') }}" method="post" class="form-inline" style="display: inline">
                            <div class="form-group">
                                <input type="text" class="form-control" name="new_budget" placeholder="Nieuw budget">
                            </div>
                            <input type="submit" class="btn btn-default">
                        </form>
                        <button type="button" id="change-budget-close" class="close" style="float: initial;">&times;</button>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Spreker</th>
                        <th>Slot</th>
                        <th>Status</th>
                        <th>Heeft slot?</th>
                        <th>Deadline</th>
                        <th>Kosten</th>
                        <th>Wensen</th>
                        <th>Actie</th>
                    </tr>
                    </thead>
                    @foreach($aanvragen as $aanvraag)
                        <tr>
                            <td>
                                <a href="{{ url('/open-registrations/' . $aanvraag['id'] . '') }}" class="btn btn-primary">Show</a>
                            </td>
                            <td>{{ $aanvraag['naam'] }}</td>
                            <td>{{ $aanvraag['slot_id'] }}</td>
                            <td>{{ $aanvraag['status'] }}</td>
                            <td>{{ $aanvraag['aanvraag_spreker_id'] == $aanvraag['slot_spreker_id'] ? 'Ja' : 'Nee' }}</td>
                            <td>{{ $aanvraag['deadline']->diffForHumans() }}</td>
                            <td>&euro; {{ $aanvraag['kosten'] }}</td>
                            <td>{{ $aanvraag['wensen'] }}</td>
                            <td style="display: flex;">
                                <a href="{{ url('/open-registrations/' . $aanvraag['id'] . '/accept/1') }}" class="btn btn-success">Accepteren</a>&nbsp;
                                <a href="{{ url('/open-registrations/' . $aanvraag['id'] . '/negotiate') }}" class="btn btn-warning">Onderhandelen</a>&nbsp;
                                <a href="{{ url('/open-registrations/' . $aanvraag['id'] . '/accept/0') }}" class="btn btn-danger">Afwijzen</a>&nbsp;
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

        $('#change-budget').click(function () {
            $('#change-budget-container').css('display', 'inline');
        });
        $('#change-budget-close').click(function () {
            $('#change-budget-container').css('display', 'none');
        });

    </script>
@endsection