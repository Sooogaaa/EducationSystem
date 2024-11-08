<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class TopController extends Controller
{
    use AuthenticatesUsers;

    // 管理者トップページを表示する
    public function showTop()
    {
        $adminUser = Auth::guard('admin')->user();
        return view('admin.top', ['adminUser' => $adminUser]);
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/auth/login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
