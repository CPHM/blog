@extends('with-navigation')

@section('title', $title)

@section('description', $summary)

@section('head')
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{$title}}",
        "datePublished": "{{$created_at->toAtomString()}}",
        "dateModified": "{{$updated_at->toAtomString()}}",
        "description": "{{$summary}}"
    }
    </script>
@endsection

@section('content')
    <div class="w-full min-h-full p-3 bg-white dark:bg-gray-800 shadow-lg">
        <div>
            <h1 class="text-3xl mb-2">{{$title}}</h1>
            <p class="mb-1"><i class="icon-user"></i> {{$user->name}}</p>
            <p class="text-sm"><i class="icon-clock"></i> Created at {{$created_at->toDayDateTimeString()}}</p>
            @if($created_at !== $updated_at)
                <p class="text-sm"><i class="icon-clock"></i> Updated at {{$updated_at->toDayDateTimeString()}}</p>
            @endif
        </div>
        <div class="separator"></div>
        <div class="showdownResult">
            {!! $parsed !!}
        </div>
    </div>
@endsection
