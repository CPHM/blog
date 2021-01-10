@extends('base')

@section('title', 'Forgot Password')

@section('body')
    <div class="w-screen h-screen flex justify-center items-center">
        <form action="{{route('password.request')}}" method="POST" class="w-72">
            @csrf
            <div class="mb-2">
                <label for="email" class="block">Email</label>
                <input type="email" name="email" id="email" value="{{old('email')}}" class="block w-full h-10"/>
                @error('email')
                <p class="text-red-500">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div>
                <button type="submit" class="btn block w-full mb-2 h-10">
                    Get Reset Link
                </button>
                <a href="{{route('login')}}" class="link block w-full text-center">
                    Login
                </a>
            </div>
        </form>
    </div>
@endsection
