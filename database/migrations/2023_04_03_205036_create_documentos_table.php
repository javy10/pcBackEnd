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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('colaborador_id');
            $table->unsignedBigInteger('tipoDocumento_id');
            $table->string('titulo');
            $table->string('descripcion');
            $table->char('habilitado');
            $table->timestamps();
            $table->foreign('colaborador_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tipoDocumento_id')->references('id')->on('tipo_documentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
};
