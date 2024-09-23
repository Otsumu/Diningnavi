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
                return redirect('admin.login');
            }
            return $next($request);
        })->except(['loginForm', 'login']);
    }

    public function loginForm() {
        return view('admin.login');
    }

    public function login(LoginRequest $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->isAdmin()) {
            return redirect()->route('admin.shop_owners.index');
        }
        return redirect()->back()->withErrors('ログインできません');
    }

    public function shopOwnersIndex() {
        $shopOwners = User::shopOwner()->get();

        return view('admin.shop_owners.index', compact('shopOwners'));
    }
    
    public function inviteShopOwner(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        Mail::to($validated['email'])->send(new ShopOwnerInvitation());

        return redirect()->back()->with('message','招待メールをお送りしました');
    }

    public function shopOwnersEdit($id) {
        $shopOwner = User::findOrFail($id);

        return view('admin.shop_owners.form', compact('shopOwner'));
    }
    
    public function shopOwnersUpdate(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'sometimes|required|in:admin,shop_owner,regular_user',
        ]);
    
        $shopOwner = User::findOrFail($id);
        
        if (Auth::user()->isAdmin()) {
            $shopOwner->update($validated);
        } else {
            $shopOwner->update($validated->except('role'));
        }
        
        return redirect()->route('admin.shop_owners.index')->with('success', 'ショップオーナーの情報を更新しました');
    }
}
