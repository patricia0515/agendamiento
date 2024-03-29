<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $table = 'master';
    protected $primaryKey = 'idmaster';
    protected $fillable = [
                            'idmaster',
                            'nombre_persona',
                            'apellido_persona',
                            'tipo_doc_persona',
                            'num_doc_persona',
                            'correo_persona',
                            'ciudad_persona',
                            'telefono1_persona',
                            'telefono2_persona',
                            'direcc_residencia_persona',
                            'barrio_persona',
                            'fecha_agendamiento',
                            'hora_agendamiento',
                            'tipificacion',
                            'observ_persona',
                        ];
}
