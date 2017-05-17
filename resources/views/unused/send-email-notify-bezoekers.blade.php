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

                <p>U kunt een engelse email versturen naar de bezoekers om ze te informeren dat de voorreserveringen nu open zijn.</p>
                <p>Deze email wordt dan verstuurd naar alle bezoekers die een of meerdere kaartjes hebben gekocht.</p>

                <form action="">

                    <div class="form-group">
                        <textarea name="email" id="" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-default" value="OK">
                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection