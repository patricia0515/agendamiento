<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master_historico extends Model
{
    protected $table = 'master_historico';
    protected $primaryKey = 'idmaster_historico';
    protected $fillable = [
                            'idmaster_historico',
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
