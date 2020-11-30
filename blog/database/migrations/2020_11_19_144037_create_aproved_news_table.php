<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAprovedNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aproved_news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("team_id");
            $table->integer("likes")->default(0);
            $table->string("title");
            $table->text("short_description");
            $table->text("description");
            $table->string("image");
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
        Schema::dropIfExists('aproved_news');
    }
}
