<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct(User $user) {
        $this->user = $user;
    }

    //プロフィール変更画面表示
    public function showProfileForm() {
        // 開発中: 任意のユーザーIDでログインする
        Auth::loginUsingId(1);

        //ログイン中のユーザ情報取得
        $profile = Auth::user();

        return view('user/profile_edit', compact('profile'));
    }

    //プロフィール変更処理
    public function updateProfileForm(Request $request) {
        //開発中: 任意のユーザーIDでログインする
        Auth::loginUsingId(1);
        
        //ログイン中のユーザ情報取得
        $profile = Auth::user();

        //画像ファイルのファイルパス作成
        $image = $request->file('profile_image');
        if (!empty($image)) {            
            $file_name = $image->getClientOriginalName();
            $image->storeAs('storage/images/profile', $file_name);
            $image_path = 'storage/images/profile/' . $file_name;
        }else{
            $image_path = $profile->profile_image;
        }

        //バリデーションチェック
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'name_kana' => 'required|max:255|regex:/^[ァ-ヶー\s　]+$/u',
            'email' => 'required|max:255|regex:/^[\x20-\x7E]+$/',
        ], [
            'name.required' => 'ユーザーネームは必須入力項目です。',
            'name.max' => 'ユーザーネームは255文字以内で入力してください。',

            'name_kana.required' => 'カナは必須入力項目です。',
            'name_kana.max' => 'カナは255文字以内で入力してください。',
            'name_kana.regex' => 'カナはカタカナで入力してください。',

            'email.required' => 'メールアドレスは必須入力項目です。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.regex' => 'メールアドレスは半角文字で入力してください。',
        ]);

        $updateProfile = $this->user->fillProfile($request, $profile, $image_path);
        return redirect()->route('user.show.profile')->with('success', 'プロフィールが更新されました。');
    }

    //パスワード変更画面表示
    public function showPasswordForm() {
        return view('user/password_edit');
    }

    //パスワード変更処理
    public function updatePasswordForm(Request $request) {
        //開発中: 任意のユーザーIDでログインする
        Auth::loginUsingId(1);
        
        //ログイン中のユーザ情報取得
        $profile = Auth::user();

        //バリデーションチェック
        $validatedData = $request->validate([
            'old_password' => [
                'required',
                function ($attribute, $value, $fail) use ($profile) {
                    //ログインユーザーのパスワードと旧パスワードが一致しなければエラーメッセージ表示
                    if (!Hash::check($value, $profile->password)) {
                        $fail('旧パスワードが現在登録されているパスワードと一致しません。');
                    }
                },
            ],
            'new_password' => [
                'required',
                'min:8',
                'max:255',
                'confirmed',
                function ($attribute, $value, $fail) use ($profile) {
                    //ログインユーザーのパスワードと新パスワードが一致したらエラーメッセージ表示
                    if (Hash::check($value, $profile->password)) {
                        $fail('新パスワードは現在登録されているパスワードと異なる内容で入力してください。');
                    }
                },
            ],
            'new_password_confirmation' => 'required|min:8|max:255',
        ], [
            'old_password.required' => '旧パスワードは必須入力項目です。',

            'new_password.required' => '新パスワードは必須入力項目です。',
            'new_password.max' => '新パスワードは255文字以内で入力してください。',
            'new_password.min' => '新パスワードは8文字以上で入力してください。',
            'new_password.confirmed' => '新パスワードが新パスワード確認と一致しません。',

            'new_password_confirmation.required' => '新パスワード確認は必須入力項目です。',
            'new_password_confirmation.max' => '新パスワード確認は255文字以内で入力してください。',
            'new_password_confirmation.min' => '新パスワード確認は8文字以上で入力してください。',
        ]);

        $updatePassword = $this->user->fillPassword($request, $profile);
        return redirect()->route('user.show.profile')->with('success', 'パスワードが更新されました。');
    }

}
