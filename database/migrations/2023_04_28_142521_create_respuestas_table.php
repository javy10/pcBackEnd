<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pregunta_id');
            $table->string('valorRespuesta');
            $table->string('respuestaCorrecta');
            $table->char('habilitado');
            $table->timestamps();
            $table->foreign('pregunta_id')->references('id')->on('preguntas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respuestas');
    }
};
