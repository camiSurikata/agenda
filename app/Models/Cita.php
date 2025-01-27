<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'start',
    'end',
    'paciente_id',
    'sucursal_id',
    'especialidad_id',
    'medico_id',
    'estado',
    'description',
    'box_id',
  ];

  public function paciente()
  {
    return $this->belongsTo(Paciente::class, 'paciente_id');
  }

  public function sucursal()
  {
    return $this->belongsTo(Sucursal::class);
  }

  public function especialidad()
  {
    return $this->belongsTo(Especialidad::class);
  }
  public function obtenerCitas()
  {
    return Cita::select('id', 'title', 'start', 'end')
      ->get();
  }
  public function medico()
  {
    return $this->belongsTo(Medico::class, 'medico_id');
  }
  public function box()
  {
    return $this->belongsTo(Box::class, 'box_id');
  }
}
