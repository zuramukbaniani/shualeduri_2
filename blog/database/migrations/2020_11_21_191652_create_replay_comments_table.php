<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplayCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replay_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("post_id");
            $table->text("comment");
            $table->integer("post_owner_id");
            $table->integer("user_id");
            $table->integer("CommentId");
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
        Schema::dropIfExists('replay_comments');
    }
}
