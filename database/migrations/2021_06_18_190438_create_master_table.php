<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master', function (Blueprint $table) {
            $table->bigIncrements('idmaster');

            $table->string('f_gestion');
            $table->string('f_gestion_asesor');
            $table->string('f_gestion_agendamiento');
            $table->string('f_actualizacion');
            $table->string('nombre_persona');
            $table->string('apellido_persona');
            $table->string('tipo_doc_persona');
            $table->string('num_doc_persona');
            $table->string('telefono1_persona');
            $table->string('telefono2_persona');
            $table->string('correo_persona');
            $table->string('fecha_agendamiento');
            $table->string('usuario_agendamiento');
            $table->string('mensajet_persona');
            $table->string('observ_persona');
            $table->string('tipificacion');
            $table->string('sub_tipificacion');
            $table->string('tipo_gestion');
            $table->string('hora_agendamiento');
            $table->string('usuario_gestion');
            $table->string('fase_venta');
            $table->string('direcc_residencia_persona');
            $table->string('barrio_persona');
            $table->string('ciudad_persona');


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
        Schema::dropIfExists('master');
    }
}
