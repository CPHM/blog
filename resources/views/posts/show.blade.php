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
        <div class="mt-10 separator"></div>
        <div class="text-center">
            <span class="m-2">Tags:</span>
            @foreach($post->categories as $category)
                <a href="{{route('categories.show', $category)}}"
                   class="link py-1 px-3 m-2 bg-opacity-20 bg-gray-500 rounded-xl">
                    {{$category->title}}
                </a>
            @endforeach
        </div>
    </div>
    <div class="w-full min-h-full mt-5 p-3 bg-white dark:bg-gray-800 shadow-lg">
        <h3 class="text-xl text-center mb-2">Comments</h3>
        <form id="addComment" class="grid gap-1 grid-cols-1 sm:grid-cols-2">
            @csrf
            <div>
                <label for="title" class="block h-6 mb-1">Title</label>
                <input type="text" id="title" name="title" maxlength="50" required class="block w-full"/>
                <label for="name" class="block h-6 mb-1 mt-2">Name</label>
                <input type="text" id="name" name="name" maxlength="50" required class="block w-full"/>
            </div>
            <div>
                <textarea id="commentBody" name="content"
                          class="block mt-2 sm:mt-0 w-full h-full resize-none" required></textarea>
            </div>
            <div class="col-span-2 text-right">
                <button type="submit" class="btn h-8 px-8 rounded-md">Send</button>
            </div>
        </form>
        <div class="separator my-4"></div>
        <div id="comments"></div>
    </div>
    <script>
        const commentsDiv = document.getElementById('comments');
        fetch('{{route('posts.comments.index', $post)}}')
            .then(response => response.json())
            .then(data => {
                if (data.data.length === 0) {
                    const div = document.createElement('div');
                    div.classList.add('text-center', 'font-inconsolata');
                    div.innerText = 'No comments yet.'
                    commentsDiv.append(div);
                } else {
                    for (const comment of data.data)
                        appendCommentEnd(comment);
                }

            });
        const addCommentForm = document.getElementById('addComment');
        addCommentForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const data = new FormData(addCommentForm);
            fetch('{{route('posts.comments.store', $post)}}', {
                method: "POST",
                headers: {
                    'Accept': 'application/json'
                },
                body: data
            })
                .then(response => response.json())
                .then(data => {
                    appendCommentStart(data);
                });
        });

        function appendCommentEnd(comment) {
            commentsDiv.append(createCommentCard(comment));
        }

        function appendCommentStart(comment) {
            commentsDiv.prepend(createCommentCard(comment));
        }

        function createCommentCard(comment) {
            const commentCard = document.createElement('div');
            commentCard.classList.add('m-1', 'p-2', 'border', 'border-gray-500', 'rounded');
            const title = document.createElement('h4');
            title.classList.add('text-lg');
            title.innerText = comment.title;
            const content = document.createElement('p');
            content.classList.add('font-lobster', 'text-justify')
            content.innerText = comment.content;
            const name = document.createElement('div');
            name.classList.add('text-sm', 'text-right', 'mt-2')
            name.innerHTML = '<span class="border-t border-gray-500">' + 'By ' + comment.name + ', ' + new Date(comment.created_at).toDateString() + '</span>';
            commentCard.append(title);
            commentCard.append(content);
            commentCard.append(name);
            return commentCard;
        }
    </script>
@endsection
