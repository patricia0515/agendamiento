<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_tipificacion extends Model
{
    protected $table = 'sub_tipificacion';
    protected $primaryKey = 'idsub_tipificacion';
    protected $fillable = [
                            'idsub_tipificacion',
                            'idtipificacion',
                            'detalle',
                            'prioridad',
                            'estado',
                        ];
}
