@extends('with-navigation')

@section('title', 'Articles by ' . $user->name . ' (page ' . $articles->currentPage() . ')')

@section('description', 'Articles written by ' . $user->name)

@section('content')

@endsection
