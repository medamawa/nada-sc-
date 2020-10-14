<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class Post extends Model
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

    public function post(String $club_id, String $user_id, String $title, String $body)
    {
        // DBへ新しい投稿を登録
        $this->club_id = $club_id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->body = $body;
        $this->save();
    }

    public function getPosts(String $club_id)
    {
        return $this->where('club_id', $club_id)->orderBy('created_at', 'DESC')->paginate(50);
    }
}
