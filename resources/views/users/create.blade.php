@extends('with-navigation')

@section('content')
    <form action="{{route('users.store')}}" method="POST"
          class="w-80 p-3 m-auto rounded-md bg-white dark:bg-gray-800 shadow-lg">
        @csrf
        <h1 class="text-xl text-center mb-4">
            Create New User
        </h1>
        <div class="mb-2">
            <label for="email" class="block mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{old('email')}}" class="w-full h-10"/>
            @error('email')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <div class="mb-2">
            <label for="name" class="block mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{old('name')}}" class="w-full h-10"/>
            @error('name')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <div class="mb-2">
            <label for="about" class="block mb-1">About</label>
            <textarea name="about" id="about" class="w-full resize-none"></textarea>
            @error('about')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <div class="mb-2">
            <label for="password" class="block mb-1">Password</label>
            <input type="text" name="password" id="password" value="{{old('password')}}" class="w-full h-10"/>
            @error('password')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="flex block justify-between items-center">
                <span>Admin</span>
                <input type="checkbox" name="admin" value="1"/>
            </label>
            @error('admin')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <button type="submit" class="btn block h-10 w-full">Add</button>
    </form>
@endsection
