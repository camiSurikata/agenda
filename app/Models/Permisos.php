<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    protected $table = "permisos";
    protected $fillable = ['idUser', 'idModulo'];
    public $timestamps= true;
    use HasFactory;
}

