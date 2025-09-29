<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminRegisterController extends Controller
{
    /**
     * 登録フォーム表示
     */
    public function showRegistrationForm()
    {
        return view('auth.admin-register');
    }

    /**
     * 登録処理
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'kana' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 管理者ガードでログイン
        Auth::guard('admin')->login($admin);

        // 管理者のお知らせ一覧へ
        return redirect()->route('admin.articles.index');
    }
}
