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
        Schema::create('permiso_menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipoPermisoMenu_id');
            $table->char('habilitado');
            $table->timestamps();
            $table->foreign('tipoPermisoMenu_id')->references('id')->on('tipo_permiso_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permiso_menus');
    }
};
