@extends('with-navigation')

@section('content')
    <form action="{{route('posts.store')}}" method="POST"
          class="w-full p-3 bg-white dark:bg-gray-800 shadow-lg">
        @csrf
        <div>
            <label for="title" class="block">Title</label>
            <input type="text" name="title" id="title" required maxlength="50" value="{{old('title')}}"
                   class="w-full focus:outline-none"/>
        </div>
        <div>
            <label for="summary" class="block">Summary</label>
            <textarea name="summary" id="summary" maxlength="160" class="w-full resize-y">{{old('summary')}}</textarea>
        </div>
        <div class="w-full h-8 bg-white dark:bg-gray-900 flex justify-between shadow-md px-3 py-1 border-t border-l border-r border-gray-600">
            <h3>
                Markdown Editor
            </h3>
            <button id="previewOn" type="button" title="preview" class="focus:outline-none" onclick="window.previewOn()">
                <i class="icon-eye"></i>
            </button>
            <button id="previewOff" type="button" title="edit" class="focus:outline-none hidden" onclick="window.previewOff()">
                <i class="icon-code"></i>
            </button>
        </div>
        <div class="h-80 border-b border-l border-r border-gray-600 mb-3">
            <textarea name="content" id="content"
                      class="w-full h-full focus:outline-none resize-none">{{old('content')}}</textarea>
            <div id="target" class="showdownResult h-full w-full hidden overflow-y-auto"></div>
        </div>
        <div class="flex justify-center">
            <button type="submit" class="btn h-10 w-48 max-w-full">Post</button>
        </div>
    </form>
    <script src="{{asset('js/showdown.min.js')}}"></script>
    <script>
        const mdEditor = document.getElementById('content');
        mdEditor.addEventListener('keydown', function (e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                mdEditor.value += "    ";
            } else if (e.key === 'Enter' && e.shiftKey) {
                e.preventDefault();
                mdEditor.value += "\n<br />\n";
            }
        });
        showdown.setOption('simplifiedAutoLink', true);
        showdown.setOption('strikethrough', true);
        showdown.setOption('tables', true);
        showdown.setOption('tasklists', true);
        showdown.setOption('emoji', true);
        window.previewOn = function () {
            const previewOnBtn = document.getElementById('previewOn');
            const previewOffBtn = document.getElementById('previewOff');
            const source = document.getElementById('content');
            const target = document.getElementById('target');
            const converter = new showdown.Converter();
            const html = converter.makeHtml(source.value);
            target.innerHTML = html;
            source.classList.add('hidden');
            previewOnBtn.classList.add('hidden');
            target.classList.remove('hidden');
            previewOffBtn.classList.remove('hidden');
        };
        window.previewOff = function () {
            const previewOnBtn = document.getElementById('previewOn');
            const previewOffBtn = document.getElementById('previewOff');
            const source = document.getElementById('content');
            const target = document.getElementById('target');
            target.classList.add('hidden');
            previewOffBtn.classList.add('hidden')
            source.classList.remove('hidden');
            previewOnBtn.classList.remove('hidden');
        };
    </script>
@endsection
