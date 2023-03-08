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
        Schema::create('colaboradors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agencia_id');
            $table->unsignedBigInteger('detalleDepartamentoCargo_id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dui');
            $table->string('clave');
            $table->string('telefono');
            $table->string('correo');
            $table->string('foto');
            $table->integer('intentos');
            $table->char('habilitado');
            $table->timestamps();
            $table->foreign('agencia_id')->references('id')->on('agencias')->onDelete('cascade');
            $table->foreign('detalleDepartamentoCargo_id')->references('id')->on('detalle_departamento_cargos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colaboradors');
    }
};
