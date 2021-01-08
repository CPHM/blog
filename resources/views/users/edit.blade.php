@extends('with-navigation')

@section('content')
    <span class="hidden"><?php var_dump($errors) ?></span>
    <form action="{{route('users.update', $user)}}" method="POST"
          class="w-80 p-3 m-auto rounded-md bg-white dark:bg-gray-800 shadow-lg">
        @csrf
        @method('PUT')
        <h1 class="text-xl text-center mb-4">
            Edit User
        </h1>
        <div class="mb-2 font-roboto">
            <label for="email" class="block mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{$user->email}}" class="w-full h-10"/>
            @error('email')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <div class="mb-2 font-roboto">
            <label for="name" class="block mb-1">Name</label>
            <input type="text" name="name" id="name" value="{{$user->name}}" class="w-full h-10"/>
            @error('name')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <div class="mb-2 font-lobster">
            <label for="about" class="block mb-1">About</label>
            <textarea name="about" id="about" class="w-full resize-none">{{$user->about}}</textarea>
            @error('about')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <div class="mb-4 font-roboto">
            <label class="flex block justify-between items-center">
                <span>Admin</span>
                <input type="checkbox" name="admin" value="1" {{$user->admin ? 'checked' : ''}}
                @if(Auth::user()->id === $user->id) disabled @endif/>
            </label>
            @error('admin')
            <p class="text-red-500 text-sm">
                {{$message}}
            </p>
            @enderror
        </div>
        <button type="submit" class="btn block h-10 w-full">Update</button>
    </form>
@endsection
