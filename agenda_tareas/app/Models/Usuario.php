<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

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
        'remember_token', // 👈 ocultamos el token
    ];

    /**
     * 🔐 Laravel busca 'password' por defecto, pero usamos 'contrasenia'.
     */
    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    /**
     * ⚙️ Mutador opcional: si asignas $usuario->contrasenia = '123456',
     * se guarda automáticamente hasheado.
     */
    public function setContraseniaAttribute($value)
    {
        $this->attributes['contrasenia'] = Hash::make($value);
    }

    /**
     * 🔗 Relaciones
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function materias()
    {
        return $this->hasMany(Materia::class, 'usuario_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'usuario_id');
    }
}
