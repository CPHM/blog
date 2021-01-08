<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $this->checkAdmin();
        return view('users.list', ['users' => User::orderBy('name', 'asc')->paginate(12)]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
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
        if (Auth::user()->admin || Auth::user()->id === $user->id) {
            return view('users.edit', [
                'user' => $user
            ]);
        } else {
            abort(403);
        }
    }

    public function update(Request $request, User $user)
    {
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
        $this->checkAdmin();
        $user->delete();
        return redirect()->route('users.index');
    }

    private function checkAdmin()
    {
        if (!Auth::user()->admin)
            abort(403);
    }
}
