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
        $this->middleware('auth')->except(['index', 'show']);
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
            'parsed' => ['required']
        ]);
        $post = Auth::user()->posts()->create($validatedData);
        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'title' => $post->title,
            'summary' => $post->summary,
            'markdown' => $post->markdown,
            'parsed' => $post->parsed,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'user' => $post->user
        ]);
    }

    public function edit(Post $post)
    {
        if (!Auth::user()->admin && Auth::user()->id !== $post)
            abort(403);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (!Auth::user()->admin && Auth::user()->id !== $post)
            abort(403);
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:50'],
            'summary' => ['required', 'string', 'max:160'],
            'markdown' => ['required'],
            'parsed' => ['required']
        ]);
        $post->fill($validatedData);
        $post->save();
        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        if (!Auth::user()->admin && Auth::user()->id !== $post)
            abort(403);
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
