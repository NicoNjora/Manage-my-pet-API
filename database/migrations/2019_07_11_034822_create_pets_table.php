<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->date('date_born');
            $table->integer('breed_id');
            $table->string('gender');
            $table->string('color')->nullable();
            $table->integer('category_id');
            $table->string('photo_url')->default('pet-placeholder.png');;
            $table->timestamps();
    
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('breed_id')
                ->references('id')
                ->on('breeds');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
