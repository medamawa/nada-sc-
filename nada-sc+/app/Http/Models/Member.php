<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class Member extends Model
{
    use Notifiable;

    protected $carbon;
    protected $now;
    protected $keyType = 'string';
    public $incrementing = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // newした時に自動的にuuidを設定する。
        $this->attributes['id'] = Uuid::uuid4()->toString();
    }

    public function addAdminUser(String $club_id, String $user_id)
    {
        // DBへ登録
        $this->club_id = $club_id;
        $this->user_id = $user_id;
        $this->isAdmin = true;
        $this->save();

        return ;
    }

    public function addUser(String $club_id, String $user_id)
    {
        // DBへ登録(isAdminはデフォルトでfalseとなるので飛ばしている)
        $this->club_id = $club_id;
        $this->user_id = $user_id;
        $this->save();

        return ;
    }

    public function removeUser(String $club_id, String $user_id)
    {
        // DBから指定されたユーザーを消去
        // TODO: softdeleteを実装
        // TODO: 管理者は一人は必ず残しておかなければいけない
        $user = $this->where('club_id', $club_id)->where('user_id', $user_id)->get();
        $user->delete();

        return ;
    }

    public function getMembers(String $club_id)
    {
        $members = $this->leftJoin('users', 'users.id', '=', 'members.user_id')
        ->where('club_id', $club_id)
        ->select('users.user_name', 'members.isAdmin')
        ->get();

        return $members;
    }
}
