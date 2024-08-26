<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isAdmin()) {
                return redirect('admin.register')->withErrors('権限がありません');
            }
            return $next($request);
        });
    }

    public function adminRegisterForm() {
        return view('admin.register');
    }

    public function adminRegister(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'admin',
        ]);

        Auth::login($user);
        return redirect()->route('admin.login')->with('success', '管理者アカウントが作成されました');
    }

    public function adminLoginForm() {
        return view('admin.login');
    }

    public function adminLogin(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->isAdmin()) {
            return redirect()->route('admin.users.index');
        }
        return redirect()->back()->withErrors('ログインできません');
    }

    public function usersIndex() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function usersEdit($id) {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,shop_owner,regular_user',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'ユーザー情報を更新しました');
    }
}
