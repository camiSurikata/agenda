<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
  use HasFactory;
  protected $table = 'pacientes';
  protected $primaryKey = 'idpaciente';
  public $timestamps = true;
  protected $fillable = [
    'nombre',
    'apellido',
    'prevision',
    'telefono',
    'email',
    'sexo',
    'fecha_nacimiento',
    'rut',
  ];

  // Modelo Paciente
  public function previsionConvenio(){
    return $this->belongsTo(Convenio::class, 'prevision', 'id');
  }

}
