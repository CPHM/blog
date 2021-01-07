@extends('with-navigation')

@section('content')
    @if($users->count() > 0)
        <div class="min-h-full flex flex-row flex-wrap">
            @foreach($users as $user)
                <div
                    class="flex flex-col justify-between p-3 m-3 flex-1 min-w-240px max-w-360px bg-white dark:bg-gray-800 shadow-md">
                    <div>
                        <div class="flex items-center">
                            <img src="{{$user->avatar}}" alt="Avatar of {{$user->name}}" class="h-6 rounded-full mr-1"/>
                            <h4 class="text-lg">{{$user->name}}</h4>
                        </div>
                        <h6><i class="icon-envelop"></i> {{$user->email}}</h6>
                        <p class="text-sm">{{$user->about}}</p>
                    </div>
                    <div class="flex justify-center space-x-6 pt-4">
                        <a href="{{route('users.edit', $user)}}" class="text-yellow-500 hover:text-yellow-900">
                            <i class="icon-edit"></i>
                        </a>
                        <a href="{{route('users.show', $user)}}" class="text-blue-500 hover:text-blue-900">
                            <i class="icon-eye"></i>
                        </a>
                        <form action="{{route('users.destroy', $user)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-900 focus:outline-none">
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
        <div class="w-full h-full flex justify-center items-center">
            <div>
                Nothing found!
            </div>
        </div>
    @endif
@endsection
