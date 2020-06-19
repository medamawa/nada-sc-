<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->primary()->comment('メンバーID');
            $table->string('club_id')->comment('クラブID');
            $table->string('user_id')->comment('ユーザーID');
            $table->boolean('isAdmin')->default(false)->comment('管理者');
            $table->timestamps();

            $table->index('club_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
