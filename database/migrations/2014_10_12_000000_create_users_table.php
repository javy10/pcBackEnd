<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agencia_id');
            $table->unsignedBigInteger('departamento_id');
            $table->unsignedBigInteger('cargo_id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dui')->unique();
            $table->string('password');
            $table->string('telefono');
            $table->string('correo')->unique();
            $table->string('foto')->nullable();
            $table->integer('intentos');
            $table->char('habilitado');
            $table->timestamps();
            $table->foreign('agencia_id')->references('id')->on('agencias')->onDelete('cascade');
            $table->foreign('departamento_id')->references('id')->on('departamentos')->onDelete('cascade');
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
