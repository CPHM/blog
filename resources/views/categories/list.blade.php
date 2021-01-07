@extends('with-navigation')

@section('content')
    <div class="grid w-full gird-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        @foreach($categories as $category)
            <div class="bg-white p-3 dark:bg-gray-800 shadow-lg">
                <div class="text-lg">
                    {{$category->title}}
                </div>
                <p>
                    {{$category->description}}
                </p>
            </div>
        @endforeach
    </div>
@endsection
