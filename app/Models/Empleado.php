<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'puesto_id',
        'company_id',
        'fecha_ingreso',
    ];

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'puesto_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno;
    }
}
