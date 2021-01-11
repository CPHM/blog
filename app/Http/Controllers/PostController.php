<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'autocomplete']);
    }

    public function index()
    {
        return view('posts.list', [
            'posts' => Post::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    public function create()
    {
        return view('posts.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'summary' => ['required', 'string', 'max:160'],
            'markdown' => ['required'],
            'parsed' => ['required'],
            'categories' => ['array']
        ]);
        $post = Auth::user()->posts()->create($validatedData);
        if (array_key_exists('categories', $validatedData)) {
            foreach ($validatedData['categories'] as $category) {
                $post->categories()->attach($category);
            }
        }
        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'summary' => ['required', 'string', 'max:160'],
            'markdown' => ['required'],
            'parsed' => ['required'],
            'categories' => ['array']
        ]);
        $post->fill($validatedData);
        $post->save();
        if (array_key_exists('categories', $validatedData)) {
            foreach ($validatedData['categories'] as $category) {
                if (!$post->categories->contains($category))
                    $post->categories()->attach($category);
            }
        }
        foreach ($post->categories as $category) {
            if (!array_key_exists('categories', $validatedData) || !in_array($category->id, $validatedData['categories']))
                $post->categories()->detach($category);
        }
        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->back();
    }

    public function autocomplete(Request $request)
    {
        $term = $request->get('term');
        $fromMiddle = $request->get('middle', false);
        if ($fromMiddle)
            $posts = Post::where('title', 'LIKE', "%$term%")->orderBy('title', 'asc')->take(5)->get();
        else
            $posts = Post::where('title', 'LIKE', "$term%")->orderBy('title', 'asc')->take(5)->get();
        return response()->json(array_map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'summary' => $post->summary,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
        }, $posts));
    }
}
