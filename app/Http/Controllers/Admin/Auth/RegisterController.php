<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;




class RegisterController extends Controller
{

    use RegistersUsers;

    protected $redirectTo = '/admin/auth/login';

    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'name_kana' => $data['name_kana'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // public function register(RegisterRequest $request)
    // {
    //     try {
    //         $validatedData = $request->validated();

    //         $admins = new Admin;
    //         $admins->name = $validatedData['name'];
    //         $admins->name_kana = $validatedData['name_kana'];
    //         $admins->email = $validatedData['email'];
    //         $admins->password = Hash::make($validatedData['password']);

    //         $admins->save();


    //         // 登録後、ログイン画面にリダイレクト
    //         return redirect()->route('show.login');
    //     } catch (ValidationException $e) {
    //         return back()->withErrors($e->validator)->withInput();
    //     }
    // }
}
