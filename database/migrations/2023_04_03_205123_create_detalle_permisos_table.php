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
        Schema::create('detalle_permisos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('colaborador_id');
            $table->unsignedBigInteger('departamento_id');
            $table->unsignedBigInteger('documento_id');
            $table->unsignedBigInteger('permiso_id');
            $table->char('habilitado');
            $table->timestamps();
            $table->foreign('colaborador_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');
            $table->foreign('permiso_id')->references('id')->on('permisos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('detalle_permisos');
        Schema::drop('detalle_permisos');
    }
};
