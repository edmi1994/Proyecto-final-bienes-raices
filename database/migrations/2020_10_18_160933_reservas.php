<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reservas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('id_cliente');
            $table->string('nombre_cliente');
            $table->string('nombre_propiedad');
            $table->string('tipo');
            $table->string('precio_noche');
            $table->string('precio_total');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('estado');
            $table->foreign('propiedad_id')->references('id')->on('propiedades');
            $table->unsignedBigInteger('propiedad_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
