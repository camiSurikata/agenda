<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorariosMedico extends Model
{
  public $timestamps = false;
  protected $fillable = [
    'medico_id',
    'dia_semana',
    'hora_inicio',
    'hora_termino',
    'descanso_inicio',
    'descanso_termino',
    'camillas_simultaneas',
    'box_atencion',
    'no_atiende',
    'fecha_medico'
  ];

  public function medico()
  {
    return $this->belongsTo(Medico::class);
  }

  public function sucursal()
  {
    return $this->belongsTo(Sucursal::class);
  }

  public function especialidad()
  {
    return $this->belongsTo(Especialidad::class);
  }
}
