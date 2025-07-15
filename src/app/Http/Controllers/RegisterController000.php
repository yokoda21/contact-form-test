<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // 登録フォームの表示
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    public function register(RegisterRequest $request)
    {
        // バリデーション済みデータ取得
        $data = $request->validated();

        // ユーザー登録
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // ログイン or サンクスページへ
        // Auth::login($user); // 自動ログインする場合
        return redirect('/thanks'); // サンクスページへリダイレクト
    }
}
