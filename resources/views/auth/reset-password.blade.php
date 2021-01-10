@extends('base')

@section('title', 'Reset Password')

@section('body')
    <div class="w-screen h-screen flex justify-center items-center">
        <form action="{{route('password.request')}}" method="POST" class="w-72">
            @csrf
            <input type="hidden" value="{{$token}}" />
            <div class="mb-2">
                <label for="email" class="block">Email</label>
                <input type="email" name="email" id="email" value="{{old('email')}}" class="block w-full h-10"/>
                @error('email')
                <p class="text-red-500">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="password" class="block">Email</label>
                <input type="password" name="password" id="password" class="block w-full h-10"/>
                @error('password')
                <p class="text-red-500">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div class="mb-2">
                <label for="password_confirmation" class="block">Email</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full h-10"/>
                @error('password_confirmation')
                <p class="text-red-500">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div>
                <button type="submit" class="btn block w-full mb-2 h-10">
                    Reset Password
                </button>
                <a href="{{route('login')}}" class="link block w-full text-center">
                    Login
                </a>
            </div>
        </form>
    </div>
@endsection
