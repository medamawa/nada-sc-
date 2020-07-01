<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(User $user)
    {
        // ログインユーザー情報を取得
        $login_user = auth()->user();

        // 同じ所有者のアカウントを取得
        $accounts = $user->getAccounts($login_user->student_code, $login_user->id);

        return view('me', ['user' => $login_user, 'accounts' => $accounts]);
    }

    // ページの管理画面を表示
    public function admin()
    {
        return view('admin.home');
    }
}
