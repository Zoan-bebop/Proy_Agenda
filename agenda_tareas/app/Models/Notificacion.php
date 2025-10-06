<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

    protected $fillable = [
        'tarea_id',
        'mensaje',
        'fecha_envio',
        'estado'
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }
}
