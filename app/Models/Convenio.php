<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    use HasFactory;

    
    public $timestamps = false;
    
    protected $fillable = ['convenio', 'fecha_afiliacion', 'tipo', 'porcentaje_descuento', 'estado'];

}
