<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_keys', function (Blueprint $table) {
            $table->increments('id')->comment('アクセスキーテーブル主キー');
            $table->string('student_code')->comment('生徒コード');
            $table->string('name')->comment('生徒名');
            $table->string('class')->comment('回生');
            $table->string('access_password')->comment('アクセスパスワード');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_keys');
    }
}
