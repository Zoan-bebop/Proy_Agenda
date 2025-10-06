<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // Un estado tiene muchas tareas
    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'estado_id');
    }
}
