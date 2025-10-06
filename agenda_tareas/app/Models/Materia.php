<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'materias';

    protected $fillable = [
        'usuario_id',
        'nombre',
        'descripcion',
        'estado',
    ];

    // Relación: una materia pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación: una materia tiene muchas tareas
    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'materia_id');
    }
}
