<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

class Club extends Model
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

    public function store(String $name)
    {
        // DBへ登録
        $this->name = $name;
        $this->save();
        
        // idを返す
        return $this->where('name', $name)->value('id');
    }

    public function getId(String $name)
    {
        return $this->where('name', $name)->value('id');
    }

    public function getName(String $id)
    {
        return $this->where('id', $id)->value('name');
    }
}
