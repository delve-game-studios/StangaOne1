@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Word</div>

                <div class="panel-body">
                    @if ($errors->count() > 0)
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <form action="{{ route('words.update', $word->id) }}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        Word:
                        <br />
                        <input type="text" name="word" value="{{ $word->word }}" />
                        <br /><br />
                        Meaning:
                        <br />
                        <textarea name="meaning">{{ $word->meaning }}</textarea>
                        <br /><br />
                        <input type="submit" value="Submit" class="btn btn-default" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection