<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ para usar autenticación
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'contrasenia',
        'estado',
        'rol_id',
    ];

    protected $hidden = [
        'contrasenia',
    ];

    /**
     * ⚙️ Laravel busca una columna 'password' por defecto.
     * Aquí le indicamos que use nuestra columna 'contrasenia'.
     */
    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    // ✅ Relación con el rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    // ✅ Un usuario tiene muchas materias
    public function materias()
    {
        return $this->hasMany(Materia::class, 'usuario_id');
    }

    // ✅ Un usuario tiene muchas tareas
    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'usuario_id');
    }
}
