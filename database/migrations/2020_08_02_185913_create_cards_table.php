<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->integer('set_id')->unsigned();
            $table->text('name');
            $table->text('text');
            $table->text('small_image');
            $table->text('normal_image');
            $table->text('large_image');
            $table->text('colors');
            $table->text('cmc');
            $table->text('type_line');
            $table->text('rarity');
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
        Schema::dropIfExists('cards');
    }
}
