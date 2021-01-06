<?php

namespace App\Http\Controllers;

use App\Mail\ResetLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::attempt($validatedData)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function getResetEmail(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required', 'email']
        ]);
        $user = User::where('email', $validatedData['email'])->first();
        if (!empty($user)) {
            $token = bin2hex(random_bytes(16));
            DB::table('reset-tokens')->insert([
                'user_id' => $user->id,
                'token' => $token
            ]);
            Mail::to($user)->send(new ResetLink($token));
        }
        return back()->with([
            'success' => 'You will receive an email shortly.'
        ]);
    }

    public function resetForm(Request $request, $token)
    {
        $tokenObj = DB::table('reset-tokens')->where('token', $token)->first();
        if (!empty($tokenObj)) {
            if (Carbon::now()->addHour()->gt($tokenObj->created_at))
                DB::table('reset-tokens')->where('id', $tokenObj->id)->delete();
            else
                return view('auth.reset-password', ['token' => $token]);
        }
        return response('', 404);
    }

    public function resetPassword(Request $request)
    {
        $validatedData = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
        $user = User::where('email', $validatedData['email'])->first();
        if (!empty($user)) {
            $token = Db::table('reset-tokens')
                ->where('user_id', $user->id)
                ->where('token', $validatedData['token'])
                ->first();
            if (!empty($token)) {
                if (Carbon::now()->addHour()->gt($token->created_at)) {
                    DB::table('reset-tokens')->where('id', $token->id)->delete();
                } else {
                    $user->password = Hash::make($validatedData['password']);
                    $user->save();
                    Auth::setUser($user);
                    return redirect('/');
                }
            }
        }
        return back()->withErrors([
            'email' => 'Invalid email or expired token.'
        ]);
    }
}
