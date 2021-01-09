@extends('with-navigation')

@section('title', "Latest Articles (page" . $posts->currentPage() . ")")

@section('description', "Latest Articles (page" . $posts->currentPage() . ")");

@section('mainClasses', 'min-h-screen flex flex-col justify-between')

@section('content')
    @if($posts->count() > 0)
        <div class="grid w-full gird-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            @foreach($posts as $post)
                <div class="flex-1 flex flex-col justify-between p-3 bg-white dark:bg-gray-800 shadow-md">
                    <div>
                        <div class="mb-2">
                            <h3 class="text-xl font-roboto">
                                {{$post->title}}
                            </h3>
                            <p class="text-sm font-roboto">
                                <i class="icon-user"></i> {{$post->user->name}}
                            </p>
                            <p class="text-sm text-justify font-roboto">
                                <i class="icon-clock"></i> {{$post->created_at->toDayDateTimeString()}}
                            </p>
                        </div>
                        <div class="separator"></div>
                        <p class="font-lobster">
                            {{$post->summary}}
                        </p>
                    </div>
                    <p class="mt-1 text-right">
                        <a href="{{route('posts.show', $post)}}" class="link">Read</a>
                    </p>
                </div>
            @endforeach
        </div>
        <div>
            {{$posts->links()}}
        </div>
    @else
        <div class="w-full text-center font-2xl font-inconsolata">
            Expected Array, got NULL.
        </div>
    @endif
@endsection
