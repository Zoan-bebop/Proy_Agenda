<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'contrasenia',
        'estado',
    ];

    // Relación con el rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // Un usuario tiene muchas materias
    public function materias()
    {
        return $this->hasMany(Materia::class, 'usuario_id');
    }

    // Un usuario tiene muchas tareas
    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'usuario_id');
    }
}

