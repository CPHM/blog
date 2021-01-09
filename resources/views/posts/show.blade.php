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
            <p class="mb-1"><i class="icon-user"></i> {{$post->user->name}}</p>
            <p class="text-sm"><i class="icon-clock"></i> Created at {{$post->created_at->toDayDateTimeString()}}</p>
            @if($post->created_at->notEqualTo($post->updated_at))
                <p class="text-sm"><i class="icon-clock"></i> Updated at {{$post->updated_at->toDayDateTimeString()}}</p>
            @endif
        </div>
        <div class="separator"></div>
        <div class="showdownResult">
            {!! $post->parsed !!}
        </div>
    </div>
@endsection
