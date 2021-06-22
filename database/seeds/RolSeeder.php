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
        DB::table('roles')->insert([
            'descripcion' => 'test',
            'rol' => 'asesor'
 
        ]);

        DB::table('roles')->insert([
            'descripcion' => 'test',
            'rol' => 'administrador'
 
        ]);
    }
}
