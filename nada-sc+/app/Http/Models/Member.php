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
}
