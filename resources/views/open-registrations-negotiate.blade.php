@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="page-header">
            <h1>Prijs onderhandelen met spreker</h1>
        </div>

        <div class="row">

            <div class="col-sm-10 col-lg-8">

                <p>U bent het niet eens met de opgegeven kosten van de spreker of ze vallen boven het budget.</p>
                <p>Hier kunt u een email sturen naar met het nieuwe aanbod bedrag.</p>
                <p>De spreker heeft 2 dagen om te reageren anders wordt de aanvraag afgewezen.</p>

                <form action="" method="post">

                    <br>
                    <p>Email naar {{ $aanvraag->email }}</p>
                    <p>Gevraagd door spreker &euro; {{ $aanvraag->kosten }}</p>
                    <div class="form-group">
                        <label for="nieuwe_kosten">Nieuw aanbod in euro's</label>
                        <div class="input-group">
                            <div class="input-group-addon">&euro;</div>
                            <input type="text" class="form-control" name="nieuwe_kosten" id="nieuwe_kosten" value="{{ old('nieuwe_kosten') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-default" value="Send">
                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection