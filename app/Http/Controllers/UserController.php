<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', User::class);
        return view('users.list', ['users' => User::orderBy('name', 'asc')->paginate(12)]);
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);
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
        $this->authorize('view', $user);
        return view('users.posts', [
            'user' => $user,
            'posts' => $user->posts()->paginate(10)
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        if (Auth::user()->id === $user->id) {
            $validatedData = $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users,email'],
                'about' => ['nullable', 'string', 'max:100']
            ]);
        } else if (Auth::user()->admin) {
            $validatedData = $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users,email'],
                'about' => ['nullable', 'string', 'max:100'],
                'admin' => ['boolean']
            ]);
        }
        $user->fill($validatedData);
        $user->save();
        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index');
    }
}
