<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_kana',
        'email',
        'password',
        'profile_image',
        'grade_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //プロフィール更新処理
    public function fillProfile($request, $profile, $image_path) {
        DB::beginTransaction();

        try{
            //リクエストデータを基に商品情報を更新する
            $result = $profile->fill([
                'profile_image' => $image_path,
                'name' => $request->name,
                'name_kana' => $request->name_kana,
                'email' => $request->email
            ])->save();

            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }        
    }

    //パスワード更新処理
    public function fillPassword($request, $profile) {
        DB::beginTransaction();

        try{
            //リクエストデータを基に商品情報を更新する
            $result = $profile->fill([
                'password' => Hash::make($request['new_password'])
            ])->save();

            DB::commit();
            return $result;

        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }        
    }

}
