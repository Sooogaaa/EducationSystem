<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max;255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスは必須です。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'email.email' => '正しいメールアドレス形式で入力してください。',
            'password.required' => 'パスワードは必須です。',
            'password.min' => 'パスワードは8文字以上で指定してください。',
        ];
    }
}
