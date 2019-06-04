<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_file_name')->nullable();
            $table->string('img_alignment')->nullable();
            $table->integer('img_col_size')->nullable();
            $table->string('bkg_color')->nullable();
            $table->string('text_color')->nullable();
            
            $table->string('button_url')->nullable();
            $table->string('button_color')->nullable();
            $table->string('button_corners')->nullable();
            $table->string('button_icon')->nullable();
            $table->boolean('container_wrap')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
