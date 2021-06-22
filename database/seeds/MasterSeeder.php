<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master')->insert([
            'f_gestion' => '2021-03-02 10:59:28',
            'f_gestion_asesor' => '2021-03-02 10:59:28',
            'f_gestion_agendamiento' => '',
            'f_actualizacion' => '',
            'nombre_persona' => 'YENNI ANDREA ',
            'apellido_persona' => 'MORA BORDA',
            'tipo_doc_persona' => '1',
            'num_doc_persona' => '1032385789',
            'telefono1_persona' => '3133442802',
            'telefono2_persona' => '3133442802',
            'correo_persona' => '',
            'fecha_agendamiento' => '2021-03-03',
            'usuario_agendamiento' => '',
            'mensajet_persona' => '',
            'observ_persona' => '02 03 2021 CUMPLE OBJETIVO',
            'tipificacion' => '1',
            'sub_tipificacion' => '1',
            'tipo_gestion' => '',
            'hora_agendamiento' => '09:00-11:00',
            'usuario_gestion' => '1005929545',
            'fase_venta' => 'g_agendamiento',
            'direcc_residencia_persona' => 'CRA 17 A NRO 63 B 09 SUR',
            'barrio_persona' => 'MEXICO',
            'ciudad_persona' => '525'

        ]);
    }
}
