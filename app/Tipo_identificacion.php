<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_identificacion extends Model
{
    protected $table = 'tipo_identificacion';
    protected $primaryKey = 'idtipo_identificacion';
    protected $fillable = [
                            'idtipo_identificacion',
                            'detalle',
                            'estado',
                        ];

}
