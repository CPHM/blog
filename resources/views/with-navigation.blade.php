@extends('base')

@section('body')
    <div
        class="fixed top-0 left-0 right-0 h-12 flex justify-between items-center px-4 text-xl bg-gray-100 dark:bg-gray-800 shadow-lg">
        <div class="flex items-center">
            <button type="button" class="focus:outline-none" onclick="toggleMenu()">
                &#9776;
            </button>
            <div class="mx-4">
                <a href="{{route('posts.index')}}">
                    {{env('APP_NAME', 'Blog')}}
                </a>
            </div>
        </div>
        <div class="flex items-center">
            <button type="button" title="toggle dark mode" class="focus:outline-none" onclick="toggleDarkMode()">
                <i class="icon-contrast"></i>
            </button>
            @auth()
                <div class="relative pt-1">
                    <button type="button" class="mx-4 focus:outline-none" onclick="toggleVisibility('user-dropdown')">
                        <img src="{{auth()->user()->avatar}}" alt="your avatar" class="h-6 rounded-full"/>
                    </button>
                    <div id="user-dropdown"
                         class="hidden origin-top-right absolute right-4 w-32 rounded-md shadow-lg bg-gray-100 dark:bg-gray-700 ring-1 ring-black ring-opacity-5">
                        <div class="py-1">
                            <a href="{{route('users.edit', auth()->user())}}"
                               class="block px-4 py-2 text-sm hover:bg-gray-200 dark:hover:bg-gray-600">
                                <i class="icon-user mr-1"></i>
                                Account
                            </a>
                            <form method="POST" action="{{route('logout')}}">
                                @csrf
                                <button type="submit"
                                        class="block w-full flex items-center text-left px-4 py-2 text-sm hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none">
                                    <i class="icon-exit mr-1"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
    <nav id="menu"
         class="fixed top-12 bottom-0 -left-32 w-32 flex items-center bg-gray-100 dark:bg-gray-800 shadow-lg transition-menu">
        <div class="w-full">
            <a href="{{route('posts.index')}}"
               class="block w-full h-10 flex items-center px-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                Articles
            </a>
            <a href="{{route('categories.index')}}"
               class="block w-full h-10 flex items-center px-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                Categories
            </a>
            @auth()
                <a href="{{route('posts.create')}}"
                   class="block w-full h-10 flex items-center px-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                    New Article
                </a>
                <a href="{{route('categories.create')}}"
                   class="block w-full h-10 flex items-center px-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                    New Category
                </a>
                @if(auth()->user()->admin)
                    <a href="{{route('users.index')}}"
                       class="block w-full h-10 flex items-center px-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                        Manage Users
                    </a>
                @endif
            @endauth()
            @guest()
                <a href="{{route('login')}}"
                   class="block w-full h-10 flex items-center px-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                    Login
                </a>
            @endguest
        </div>
    </nav>
    <div id="main" class="transition-main px-4 pb-4 pt-16 @yield('mainClasses')">
        @yield('content')
    </div>
@endsection
