<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        if (!Auth::user()->admin)
            return response('', 403);
    }

    public function index()
    {
        return view('users.list', ['users' => User::paginate(15)]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'about' => ['nullable', 'string', 'max:100'],
            'admin' => ['boolean']
        ]);
        $user = User::create($validatedData);
        return redirect()->route('users.show', $user);
    }

    public function show(User $user)
    {
        return view('users.posts', [
            'user' => $user,
            'posts' => $user->posts()->paginate(10)
        ]);
    }

    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'about' => ['nullable', 'string', 'max:100'],
            'admin' => ['boolean']
        ]);
        $user->fill($validatedData);
        $user->save();
        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
