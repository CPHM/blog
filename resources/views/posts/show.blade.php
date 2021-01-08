@extends('with-navigation')

@section('content')
    <h1>{{$title}}</h1>
    <div class="showdownResult">
        {!! $parsed !!}
    </div>
@endsection
