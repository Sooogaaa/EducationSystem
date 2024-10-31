<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view("admin.auth.login");
    }

    public function login(AdminLoginRequest $request)
    {
        // 入力内容をチェックする
        $credentials = $request->only('email', 'password');

        // ログイン成功
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('/admin/top');
        }

        // ログイン失敗
        return back()->withErrors([
            'email' => "メールアドレスまたはパスワードが違います。"
        ]);
    }
}
