<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
  use HasFactory;
  public $timestamps = false; // Desactiva los timestamps automáticos
  protected $fillable = [
    'nombre',
    'telefono',
    'rut',
    'email',
    'especialidad',
    'estado', // 1 activo, 0 deshabilitado
  ];

  public function horarios()
  {
    return $this->hasMany(HorariosMedico::class);
  }

  public function bloqueos()
  {
    return $this->hasMany(BloqueoProgramado::class);
  }
}
