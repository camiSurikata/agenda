<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloqueoProgramado extends Model
{
  protected $table = 'bloqueos_programados';
  public $timestamps = false;
  protected $fillable = ['medico_id', 'sucursal', 'fecha', 'hora_inicio', 'hora_termino', 'creado_por', 'recurso'];

  public function medico()
  {
    return $this->belongsTo(Medico::class);
  }
}
