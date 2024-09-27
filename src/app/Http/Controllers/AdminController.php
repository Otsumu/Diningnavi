<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isAdmin()) {
                return redirect()->route('admin.login'); 
            }
            return $next($request);
        })->except(['loginForm', 'login']);
    }

    public function loginForm() {
        return view('admin.login');
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            if (Auth::user()->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->route('admin.menu');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => '管理者アカウントでログインしてください',
                ]);
            }
        }
    
        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが正しくありません',
        ]);
    }

    public function menu() {
        return view('admin.menu');
    }

    public function showRegisterForm() {
        return view('admin.form');
    }

    public function ownerRegister(RegisterRequest $request) {
        $request->session()->put('register_data', $request->validated());
        return redirect()->route('admin.shop_owners');
    }

    public function confirm() {
        $registerData = session('register_data');
        return view('admin.confirm', ['data' => $registerData]);
    }

    public function destroy(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->flash('success', 'ログアウトしました');

        return redirect()->route('admin.login');
    }
}