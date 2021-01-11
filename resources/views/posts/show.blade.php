@extends('with-navigation')

@section('title', $post->title)

@section('description', $post->summary)

@section('mainClasses', 'min-h-screen flex flex-col justify-between')

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
    <div class="w-full max-w-800px mx-auto p-3 bg-white dark:bg-gray-800 shadow-lg">
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
                        <button type="submit" class="focus:outline-none text-sm mx-1 areYouSure" title="delete"><i
                                class="icon-bin"></i></button>
                    </form>
                @endcan
            </h1>
            <p class="mb-1 flex flex-row items-center">
                <img src="{{$post->user->avatar}}" alt="Avatar of {{$post->user->name}}"
                     class="inline-block h-6 mr-2 rounded-full"/>
                <span>{{$post->user->name}}</span>
            </p>
            <p class="flex flex-row items-center text-sm mb-1">
                Published on {{$post->created_at->toFormattedDateString()}}
            @if($post->created_at->notEqualTo($post->updated_at))
                - updated on {{$post->updated_at->toFormattedDateString()}}
            @endif
            </p>
        </div>
        <div class="separator"></div>
        <div class="showdownResult">
            {!! $post->parsed !!}
        </div>
        <div class="mt-10 separator"></div>
        <div class="text-center">
            <span class="m-2">Tags:</span>
            @foreach($post->categories as $category)
                <a href="{{route('categories.show', $category)}}"
                   class="link py-1 leading-loose px-3 m-2 bg-opacity-20 bg-gray-500 rounded-xl">
                    {{$category->title}}
                </a>
            @endforeach
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            comments('{{route('posts.comments.index', $post)}}')
        });
    </script>
@endsection
