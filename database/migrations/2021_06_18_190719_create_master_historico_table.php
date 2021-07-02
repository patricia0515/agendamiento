<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterHistoricoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_historico', function (Blueprint $table) {
            $table->bigIncrements('idmaster_historico');

            $table->string('nombre_persona');
            $table->string('apellido_persona');
            $table->integer('tipo_doc_persona');
            $table->string('num_doc_persona');
            $table->string('telefono1_persona');
            $table->string('telefono2_persona');
            $table->string('correo_persona');
            $table->string('fecha_agendamiento');
            $table->string('usuario_agendamiento');
            $table->string('mensajet_persona')->nullable();
            $table->string('observ_persona');
            $table->integer('tipificacion');
            $table->integer('sub_tipificacion');
            $table->string('tipo_gestion')->nullable();
            $table->string('hora_agendamiento');
            $table->string('log_historico');
            $table->string('fase_venta');
            $table->string('direcc_residencia_persona');
            $table->string('barrio_persona');
            $table->integer('ciudad_persona');


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
        Schema::dropIfExists('master_historico');
    }
}
