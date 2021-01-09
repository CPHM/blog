@extends('with-navigation')

@section('title', $post->title)

@section('description', $post->summary)

@section('head')
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{$post->title}}",
        "datePublished": "{{$post->created_at->toAtomString()}}",
        "dateModified": "{{$post->updated_at->toAtomString()}}",
        "description": "{{$post->summary}}"
    }
    </script>
@endsection

@section('content')
    <div class="w-full min-h-full p-3 bg-white dark:bg-gray-800 shadow-lg">
        <div>
            <h1 class="text-3xl mb-2">
                {{$post->title}}
                @can('update', $post)
                    <a href="{{route('posts.edit', $post)}}" class="text-sm mx-1" title="edit"><i class="icon-edit"></i></a>
                @endcan
                @can('delete', $post)
                    <form action="{{route('posts.destroy', $post)}}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="focus:outline-none text-sm mx-1 areYouSure" title="delete"><i class="icon-bin"></i></button>
                    </form>
                @endcan
            </h1>
            <p class="mb-1 flex flex-row items-center">
                <img src="{{$post->user->avatar}}" alt="Avatar of {{$post->user->name}}" class="inline-block h-6 mr-2 rounded-full"/>
                <span>{{$post->user->name}}</span>
            </p>
            <p class="flex flex-row items-center text-sm mb-1">
                <i class="icon-clock mr-2 text-2xl"></i>
                <span>Published on {{$post->created_at->toDayDateTimeString()}}</span>
            </p>
            @if($post->created_at->notEqualTo($post->updated_at))
                <p class="flex flex-row items-center text-sm mb-1">
                    <i class="icon-clock mr-2 text-2xl"></i>
                    <span>Last edited on {{$post->updated_at->toDayDateTimeString()}}</span>
                </p>
            @endif
        </div>
        <div class="separator"></div>
        <div class="showdownResult">
            {!! $post->parsed !!}
        </div>
    </div>
@endsection
