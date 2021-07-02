<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rol')->insert([
            'descripcion' => 'Asesor',
            'rol' => '1'
 
        ]);

        DB::table('rol')->insert([
            'descripcion' => 'administrador',
            'rol' => '0'
 
        ]);
    }
}
