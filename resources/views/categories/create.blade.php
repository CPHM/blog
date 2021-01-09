@extends('with-navigation')

@section('title', 'Add new category')

@section('content')
    <form action="{{route('categories.store')}}" method="POST"
          class="w-80 p-3 m-auto rounded-md bg-white dark:bg-gray-800 shadow-lg">
        @csrf
        <h1 class="text-xl text-center mb-4">
            Create New Categories
        </h1>
        <div class="mb-2">
            <label for="title" class="block mb-1">Title</label>
            <input type="text" name="title" id="title" value="{{old('title')}}" maxlength="50" class="w-full h-10"/>
            @error('title')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <div class="mb-2">
            <label for="description" class="block mb-1">Description</label>
            <textarea name="description" id="description" class="w-full resize-none" rows="4"
                      maxlength="160">{{old('description')}}</textarea>
            @error('description')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <button type="submit" class="btn block h-10 w-full">Add</button>
    </form>
@endsection
