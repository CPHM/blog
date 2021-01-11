@extends('with-navigation')

@section('title', 'Categories (page' . $categories->currentPage() . ')')

@section('description', 'Topics of the blog')

@section('mainClasses', 'min-h-screen flex flex-col justify-between')

@section('content')
    @if($categories->count() > 0)
        <div class="grid w-full gird-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            @foreach($categories as $category)
                <div class="flex flex-col justify-between flex-1 p-3 bg-white dark:bg-gray-800 shadow-md">
                    <div>
                        <div class="text-xl font-roboto">
                            {{$category->title}}
                        </div>
                        <p class="font-lobster">
                            {{$category->description}}
                        </p>
                    </div>
                    @auth()
                        <div class="flex flex-row justify-center space-x-6 pt-4">
                            <a href="{{route('categories.edit', $category)}}" class="text-yellow-500 hover:text-yellow-900">
                                <i class="icon-edit"></i>
                            </a>
                            <a href="{{route('categories.show', $category)}}" class="text-blue-500 hover:text-blue-900">
                                <i class="icon-eye"></i>
                            </a>
                            <form action="{{route('categories.destroy', $category)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-900 focus:outline-none areYouSure"
                                        data-sure-message="Are you sure you want to delete this category? you won't be able to undo it.">
                                    <i class="icon-bin"></i>
                                </button>
                            </form>
                        </div>
                    @endauth
                    @guest()
                        <div class="text-right">
                            <a href="{{route('categories.show', $category)}}" class="link">
                                <?php $count = $category->posts()->count() ?>
                                {{$count}} {{$count === 1 ? 'post' : 'posts'}}
                            </a>
                        </div>
                    @endguest
                </div>
            @endforeach
        </div>
        <div>
            {{$categories->links()}}
        </div>
    @else
        <div class="w-full text-center font-2xl font-inconsolata">
            Expected Array, got NULL.
        </div>
    @endif
@endsection
