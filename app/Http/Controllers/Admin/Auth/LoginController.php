<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    use AuthenticatesUsers {
        logout as performLogout;
    }

    public function login(LoginRequest $request)
    {
        // 入力内容をチェックする
        $credentials = $request->only('email', 'password');

        // ログイン成功
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/top');
        }

        // ログイン失敗
        return back()->withErrors([
            'email' => "メールアドレスまたはパスワードが違います。"
        ]);
    }
}
