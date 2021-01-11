<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        return $post->comments()->orderBy('created_at', 'desc')->paginate(5);
    }

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name' => ['max:50'],
            'content' => ['required', 'string', 'max:10000']
        ]);
        return $post->comments()->create($validated);
    }

    public function destroy(Comment $comment)
    {
        if (!(Auth::user()->admin || Auth::user()->id === $comment->user->id))
            abort(403);
        $comment->delete();
        return response('', 204);
    }
}
