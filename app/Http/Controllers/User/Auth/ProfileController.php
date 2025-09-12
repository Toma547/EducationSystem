<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    // プロフィール編集画面
    public function edit()
    {
        $user = Auth::user();
        return view('user.layouts.profile_edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    
     // プロフィール更新処理
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users','email')->ignore($user->id)
            ],
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null; // 未定義エラー防止

        // 画像がアップロードされた場合
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('images/profile', 'public');
        }

        $user->update([
            'name' => $request->name,
            'name_kana' => $request->name_kana,
            'email' => $request->email,
            'profile_image' => $path ?? $user->profile_image,
        ]);

        return redirect()->route('user.profile.edit')->with('status', 'プロフィールを更新しました');
    }

    /**
     * Delete the user's account.
     */

    // パスワード変更画面 
    public function editPassword()
    {
        return view('user.layouts.password_edit');
    }

    // パスワード更新処理
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        // 現在のパスワードチェック
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => '現在のパスワードが正しくありません']);
        }

        // パスワード更新
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.profile.edit')->with('status', 'パスワードを変更しました');
    }
}
