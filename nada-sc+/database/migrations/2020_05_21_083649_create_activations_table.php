<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activations', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('アクティベーションテーブル主キー');
            $table->string('student_code')->comment('生徒コード');
            $table->string('user_name')->comment('ユーザー名');
            $table->string('class')->comment('回生');
            $table->string('email')->unique('メールアドレス');
            $table->string('password')->comment('パスワード');
            $table->string('code')->comment('認証用コード');
            $table->string('email_verified_at')->nullable()->comment('メール認証完了日時');
            $table->timestamps();

            $table->index('email');
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activations');
    }
}
