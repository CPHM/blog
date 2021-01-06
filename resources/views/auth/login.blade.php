@extends('base')

@section('body')
    <div class="w-screen h-screen flex justify-center items-center">
        <form action="{{route('login')}}" method="POST" class="w-72">
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
            <div class="mb-5">
                <label for="password" class="block">Password</label>
                <input type="password" name="password" id="password" class="block w-full h-10"/>
                @error('password')
                <p class="text-red-500">
                    {{$message}}
                </p>
                @enderror
            </div>
            <div>
                <button type="submit" class="btn block w-full mb-2 h-10">
                    Login
                </button>
                <a href="{{route('password.request')}}" class="link block w-full text-center">
                    Forgot your password?
                </a>
            </div>
        </form>
    </div>
@endsection
