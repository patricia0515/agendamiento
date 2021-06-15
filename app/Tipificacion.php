<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipificacion extends Model
{
    protected $table = 'tipificacion';
    protected $primaryKey = 'idtipificacion';
    protected $fillable = [
                            'idtipificacion',
                            'detalle',
                            'estado',
                        ];
}
