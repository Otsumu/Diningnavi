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
        $registerData = session('register_data', []);
        return view('admin.form')->withInput($registerData);
    }

    public function ownerRegister(RegisterRequest $request) {
        $request->session()->put('register_data', $request->validated());
        return redirect()->route('admin.confirm');
    }

    public function confirm() {
        $registerData = session('register_data');
        return view('admin.confirm', ['data' => $registerData]);
    }

    public function ownerConfirm(RegisterRequest $request) {
        $validatedData = $request->validated();

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'shop_owner',
        ]);

        $request->session()->forget('register_data');

        return redirect()->route('admin.shop_owners')->with('success','ShopOwner情報が登録されました');
    }

    public function showShopOwners() {
        $shopOwners = User::where('role', 'shop_owner')->with('shops')->paginate(5);
        return view('admin.shop_owners', compact('shopOwners'));
    }

    public function editShopOwner($id) {
        $shopOwner = User::with('shops')->findOrFail($id);
        $data = [
            'name' => $shopOwner->name,
            'email' => $shopOwner->email,
            'password' => '',
        ];
        return view('admin.edit', compact('shopOwner','data'));
    }

    public function updateShopOwner(Request $request, $id) {
        $shopOwner = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $shopOwner->name = $validatedData['name'];
        $shopOwner->email = $validatedData['email'];

        if (!empty($validatedData['password'])) {
            $shopOwner->password = Hash::make($validatedData['password']);
        }

        $shopOwner->save();

        return redirect()->route('admin.shop_owners')->with('success', '情報が更新されました');
    }

    public function deleteShopOwner($id) {
        $shopOwner = User::findOrFail($id);
        $shopOwner->shops()->delete();
        $shopOwner->delete();

        return redirect()->route('admin.shop_owners')->with('success', '情報を削除しました');
    }

    public function destroy(Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $request->session()->flash('success', 'ログアウトしました');

        return redirect()->route('admin.login');
    }
}