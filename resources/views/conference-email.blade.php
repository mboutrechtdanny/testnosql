@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="page-header">
            <h1>Conferentie
                <small>Stuur email naar bezoekers</small>
            </h1>
        </div>

        <div class="row">

            <div class="col-sm-10 col-lg-8">

                <p>U kunt een email versturen naar de bezoekers om ze te informeren over de conferentie.</p>
                <p>Conferentie overzicht wordt dan verstuurd naar alle bezoekers in pdf.</p>

                <form action="" method="post">

                    <div class="form-group">
                        <textarea name="email" id="" cols="30" rows="4" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-default" value="OK">
                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection