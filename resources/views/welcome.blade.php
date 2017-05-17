@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="page-header">
            <h1>Conferentie
                <small>Bootstrap 3</small>
            </h1>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-4">
                <a href="#" class="thumbnail">
                    <img src="/img/iCT2016-kl.jpg" alt="ict">
                </a>
            </div>

            <div class="col-sm-6 col-md-8">

                <h4>Welcome to the conference</h4>
                <p>Programme:</p>
                <p>Non-destructive Testing 3D Materials Characterization Dimensional Measurement Industry Day - Lectures for CT users and operators (free entry)</p>
                <p>Venue: University of Applied Sciences Upper Austria, Campus Wels, Stelzhamerstrasse 23, 4600 Wels / Austria</p>
                <p>Conference Language: English Organiser: University of Applied Sciences Upper Austria, Wels Campus</p>
                <p>Important Dates: July 19th 2015: Abstract Submission ** the prolonged deadline ** September 2015: Acceptance Notification September 2015: Conference Programme available December 18th 2015: Paper Submission</p>

                <br>

                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="{{ url('/agenda') }}">Agenda</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ url('/reservation') }}">Make a reservation</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ url('/registration') }}">Register as a speaker</a>
                    </li>
                    <li class="list-group-item">
                        <a href="{{ url('/open-registrations') }}">Open registrations (organist)</a>
                    </li>
                    <li class="list-group-item">
                        <a href="/">Contact</a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

@endsection