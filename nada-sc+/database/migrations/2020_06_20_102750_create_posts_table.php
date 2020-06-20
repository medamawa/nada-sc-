<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('投稿ID');
            $table->string('club_id')->comment('クラブID');
            $table->string('user_id')->comment('ユーザーID');
            $table->string('title')->comment('タイトル');
            $table->string('body')->comment('本文');
            $table->timestamps();

            $table->index('club_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
