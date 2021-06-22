<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    protected $table = 'municipios';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'id',
                            'nombre_municipio',
                            'departamento',
                        ];
}
