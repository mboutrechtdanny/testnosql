@extends('layouts.app')

@section('content')

    <table class="table">
        <tr>
            <td>Tag</td>
            <td>Aanvraag</td>
            <td>Spreker</td>
            <td>Onderwerp</td>
            <td>Deadline</td>
        </tr>
        @foreach($results as $result)
            <tr>
                <td>{{ $result->tag_beschrijving }}</td>
                <td>{{ $result->aanvraag_beschrijving }}</td>
                <td>{{ $result->spreker_id }}</td>
                <td>{{ $result->onderwerp }}</td>
                <td>{{ $result->deadline }}</td>
            </tr>
        @endforeach
    </table>

@endsection