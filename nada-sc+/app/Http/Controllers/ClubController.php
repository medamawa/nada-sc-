<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Club;
use App\Models\Member;

class ClubController extends Controller
{
    // 新しいクラブを登録するための画面を表示する
    public function create()
    {
        return view('club.create', ['msg' => 'Fill in the blanks']);
    }

    // 新しいクラブを登録する
    public function store(Request $request, Club $club, Member $member)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('clubs')],
        ]);

        $user = auth()->user();
        $name = $request->name;
        
        // DBへ登録、追加したclubのidを取得
        $id = $club->store($name);

        // 作成したユーザーを管理者ユーザーとして登録
        $member->addAdminUser($id, $user->id);

        // 作成したクラブのurlを作成する
        $appUrl = config('app.url');
        $url = $appUrl . '/club/n/' . $name;

        return view('club.create', ['msg' => $url]);
    }

    // idを受け取ってその該当するクラブにログインしているユーザーを追加する
    public function join(Request $request, Member $member)
    {
        // クラブidとユーザーidを取得
        $club_id = $request->id;
        $user = auth()->user();
        $user_id = $user->id;

        // 追加するのに適切がどうか確認してから追加する
        if (!$this->checkClubId($club_id)) {
            return view('error.error', ['msg' => 'Invalid clubID.']);
        } else if (!$this->checkUser($club_id)) {
            return view('error.error', ['msg' => 'You have already joined.']);
        } else {
            // ユーザーを登録
            $member->addUser($club_id, $user_id);
    
            return view('club.n.home', ['name' => $club_id . 'OK']);
        }
    }

    // クラブのホーム外面を表示
    public function home(Request $request)
    {
        return view('club.n.home', ['name' => $request->name]);
    }

    /**
     * クラブidの検証
     *
     * 1. 与えられたクラブidがclubs.idに存在するか？
     * 
     * @param  string $id - クラブid
     * @return boolean
     */
    private function checkClubId(String $id)
    {
        $club = Club::where('id', $id)->first();
        if (!$club) {
            return false;
        }

        return true;
    }

    /**
     * ユーザーの検証
     *
     * 1. ユーザーが既にmembersに登録されているかどうか？(idを確認する)
     * 
     * @param  string $id - クラブid
     * @return boolean
     */
    private function checkUser(String $id)
    {
        $user_id = auth()->user()->id;
        $member = Member::where('id', $id)->where('user_id', $user_id)->first();
        if (!$member) {
            return false;
        }

        return true;
    }
}
