<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('card_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('card_id')->unsigned();
            
            $table->string('heading')->nullable();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('button_text')->nullable();
            $table->string('image_alt')->nullable();
            
            $table->string('locale')->index();
            $table->unique(['card_id', 'locale']);
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('card_translations');
    }
}
