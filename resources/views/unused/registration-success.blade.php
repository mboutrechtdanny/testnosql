@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="page-header">
            <h1>Ingeschreven</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

                <div class="alert alert-success" role="alert">
                    <p>U heeft zich succesvol ingeschreven.</p>
                    <p>Klik <a href="{{ url('/') }}">hier</a> om terug te keren naar de homepagina.</p>
                </div>

            </div>
        </div>
    </div>

@endsection