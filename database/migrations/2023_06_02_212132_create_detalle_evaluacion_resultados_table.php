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
        Schema::create('detalle_evaluacion_resultados', function (Blueprint $table) {


            $table->id();
            $table->unsignedBigInteger('pregunta_id');
            $table->unsignedBigInteger('respuesta_id');
            $table->unsignedBigInteger('resultado_id');
            $table->char('habilitado');
            $table->timestamps();

            $table->foreign('pregunta_id')->references('id')->on('preguntas')->onDelete('cascade');
            $table->foreign('respuesta_id')->references('id')->on('respuestas')->onDelete('cascade');
            $table->foreign('resultado_id')->references('id')->on('resultados')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_evaluacion_resultados');
    }
};
