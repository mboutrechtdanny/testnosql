@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="page-header">
            <h1>Plaats reserveren</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

                <div class="alert alert-success" role="alert">
                    <p>Ticket(s) zijn gekocht.</p>
                    <p>De ticket en maaltijd bonnen zijn naar uw emailadres verstuurd.</p>
                    <p>Klik <a href="{{ url('/') }}">hier</a> om terug te keren naar de homepagina.</p>
                </div>

            </div>
        </div>
    </div>

@endsection