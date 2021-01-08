@extends('with-navigation')

@section('content')
    <form action="{{route('posts.update', $post)}}" method="POST" id="editPostForm"
          class="w-full p-3 bg-white dark:bg-gray-800 shadow-lg font-roboto">
        @csrf
        @method('PUT')
        <div>
            <label for="title" class="block">Title</label>
            <input type="text" name="title" id="title" required maxlength="50" value="{{$post->title}}"
                   class="w-full focus:outline-none"/>
            @error('title')
            <p class="text-red-500 text-sm">{{$message}}</p>
            @enderror
        </div>
        <div>
            <label for="summary" class="block">Summary</label>
            <textarea name="summary" id="summary" maxlength="160" class="w-full resize-y">{{$post->summary}}</textarea>
            @error('summary')
            <p class="text-red-500 text-sm">{{$message}}</p>
            @enderror
        </div>
        <div
            class="w-full h-8 bg-white dark:bg-gray-900 flex justify-between shadow-md px-3 py-1 border-t border-l border-r border-gray-600">
            <h3>
                Markdown Editor
            </h3>
            <button id="previewOnBtn" type="button" title="preview" class="focus:outline-none">
                <i class="icon-eye"></i>
            </button>
            <button id="previewOffBtn" type="button" title="edit" class="focus:outline-none hidden">
                <i class="icon-code"></i>
            </button>
        </div>
        <div class="h-80 border-b border-l border-r border-gray-600 mb-3">
            <textarea name="markdown" id="markdown"
                      class="w-full h-full focus:outline-none resize-none">{{$post->markdown}}</textarea>
            <div id="preview"
                 class="showdownResult h-full w-full hidden overflow-y-auto bg-gray-200 dark:bg-gray-700"></div>
            <input type="hidden" name="parsed" id="parsed"/>
        </div>
        <div class="flex justify-center">
            <button type="submit" class="btn h-10 w-48 max-w-full">Update</button>
        </div>
    </form>
    {{--  seperate from app.js because most users(readers) won't need this  --}}
    <script src="{{asset('js/markdownEditor.js')}}"></script>
    <script>
        initializeMdEditor('editPostForm', 'markdown', 'preview', 'parsed', 'previewOnBtn', 'previewOffBtn');
    </script>
@endsection
