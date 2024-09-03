<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isAdmin()) {
                return redirect('admin.login')->withErrors('権限がありません');
            }
            return $next($request);
        });
    }

    public function adminRegisterForm() {
        return view('admin.register');
    }

    public function adminRegister(RegisterRequest $request) {
        $validated = $request->validated();

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

    public function adminLogin(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->isAdmin()) {
            return redirect()->route('admin.shop_owners.index');
        }
        return redirect()->back()->withErrors('ログインできません');
    }

    public function shopOwnersIndex() {
        $shopOwners = User::where('role', 'shop_owner')->get();
        return view('admin.shop_owners.index', compact('shopOwners'));
    }
    
    public function shopOwnersEdit($id) {
        $shopOwner = User::findOrFail($id);
        return view('admin.shop_owners.form', compact('shopOwner'));
    }
    
    public function shopOwnersUpdate(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,shop_owner,regular_user',
        ]);
    
        $shopOwner = User::findOrFail($id);
        $shopOwner->update($validated);
    
        return redirect()->route('admin.shop_owners.index')->with('success', 'ショップオーナーの情報を更新しました');
    }
    
}
