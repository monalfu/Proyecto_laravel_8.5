<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->id();

            $table->string('titulo', 255);
            $table->string('tema', 255)->nullable();
            $table->text('texto');
            $table->string('imagen', 255)->nullable();
            $table->softDeletes()->nullable();
            $table->boolean('rejected')->default(0);
            $table->unsignedBigInteger('user_id');

            $table->timestamps();

            // Relación de los campos
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noticias');
    }
}
