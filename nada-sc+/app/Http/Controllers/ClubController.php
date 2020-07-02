<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Club;
use App\Models\Member;

class ClubController extends Controller
{
    // クラブのhomeを表示
    public function home()
    {
        return view('club.home');
    }
    
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

        return redirect(route('club.n.home', ['name' => $name]));
    }

    // クラブの入会リクエスト画面を返す
    public function join_request(Request $request, Club $club)
    {
        // クラブidとユーザーidを取得
        $club_id = $request->id;

        // クラブidが無効の場合は404を返す
        // TODO: 404を改修する
        if (!$this->checkClubId($club_id)) {
            return view('error.error', ['msg' => 'Invalid clubID.']);
        } else {
            // クラブ名を取得
            $name = $club->getName($club_id);

            // viewを返す
            return view('club.join.request', ['id' => $club_id, 'name' => $name]);
        }

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
    
            // TODO: 改修
            return view('club.n.home', ['name' => $club_id . 'OK']);
        }
    }

    // 退会リクエスト画面を返す
    public function leave_request(Request $request)
    {
        return view('club.leave.request', ['name' => $request->name]);
    }

    // ユーザーの退会処理を行う
    public function leave(Request $request, Club $club, Member $member)
    {
        // クラブ名を取得
        $name = $request->name;

        // クラブidを取得
        $club_id = $club->getId($name);

        // ユーザーidを取得
        $user = auth()->user();
        $user_id = $user->id;

        // ユーザーを消去
        $member->removeUser($club_id, $user_id);
        return redirect(route('club.home'));
    }

    // クラブのホーム画面を表示
    public function n_home(Request $request)
    {
        return view('club.n.home', ['name' => $request->name]);
    }

    // クラブに所属しているメンバーの一覧を表示
    public function members(Request $request, Club $club, Member $member)
    {
        // クラブ名を取得
        $name = $request->name;

        // クラブidを取得
        $club_id = $club->getId($name);

        // メンバー一覧を取得
        $members = $member->getMembers($club_id);

        return view('club.n.members', ['name' => $request->name, 'members' => $members]);
    }

    // クラブの管理画面を表示
    public function admin(Request $request)
    {
        return view('club.n.admin', ['name' => $request->name]);
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
        $member = Member::where('club_id', $id)->where('user_id', $user_id)->first();
        if (!$member) {
            return false;
        }

        return true;
    }
}
