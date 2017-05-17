@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="page-header">
            <h1>Slot Tags</h1>
        </div>

        <div class="row">
            <div class="col-sm-10 col-lg-8">

                <p>Lijst met huidige tags voor dit slot</p>
                <table class="table">
                    @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->beschrijving }}</td>
                            <td><a href="{{ URL::current() . '/delete?tag_id=' . $tag->id }}">delete</a></td>
                        </tr>
                    @endforeach
                </table>

                <p>Tag toevoegen</p>
                <form action="" method="post">

                    <select name="new_tag" id="" class="form-control">

                        @foreach($all_tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->beschrijving }}</option>
                        @endforeach

                        <input type="submit" class="btn btn-default" value="+ Add">

                    </select>

                </form>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
@endsection