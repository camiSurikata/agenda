<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
  use HasFactory;

  protected $table = 'sucursales';

  public function horarios()
  {
    return $this->hasMany(HorariosMedico::class, 'id_sucursal');
  }
}
