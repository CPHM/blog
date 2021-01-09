@extends('with-navigation')

@section('title', 'Users')

@section('description', 'Writers of the blog')

@section('mainClasses', 'min-h-screen flex flex-col justify-between')

@section('content')
    @if($users->count() > 0)
        <div class="grid w-full gird-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            @foreach($users as $user)
                <div
                    class="flex flex-col justify-between p-3 m-3 flex-1 max-w-360px bg-white dark:bg-gray-800 shadow-md">
                    <div>
                        <div class="flex items-center font-roboto">
                            <img src="{{$user->avatar}}" alt="Avatar of {{$user->name}}" class="h-6 rounded-full mr-1"/>
                            <h4 class="text-lg">{{$user->name}}</h4>
                        </div>
                        <h6 class="font-roboto"><i class="icon-envelop"></i> {{$user->email}}</h6>
                        <p class="text-sm font-lobster">{{$user->about}}</p>
                    </div>
                    <div class="flex flex-row justify-center space-x-6 pt-4">
                        <a href="{{route('users.edit', $user)}}" class="text-yellow-500 hover:text-yellow-900">
                            <i class="icon-edit"></i>
                        </a>
                        <a href="{{route('users.show', $user)}}" class="text-blue-500 hover:text-blue-900">
                            <i class="icon-eye"></i>
                        </a>
                        <form action="{{route('users.destroy', $user)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-900 focus:outline-none areYouSure"
                                    data-sure-message="Are you sure you want to delete this use? You won't be able to undo this.">
                                <i class="icon-bin"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            <div>
                <a href="{{route('users.create')}}"
                   class="inline-block flex items-center justify-center h-9 w-20 mb-1 ml-auto bg-white text-black hover:text-gray-700 rounded-md border border-gray-300">
                    Add
                </a>
            </div>
            {{$users->links()}}
        </div>
    @else
        <div class="w-full text-center font-2xl font-inconsolata">
            Expected Array, got NULL.
        </div>
    @endif
@endsection
