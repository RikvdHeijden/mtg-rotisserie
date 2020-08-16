<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->bigInteger('draft_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->boolean('admin')->default(false);
            $table->timestamps();
        });

        Schema::table('players', function (Blueprint $table) {
            $table->foreign('draft_id')->references('id')->on('drafts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
