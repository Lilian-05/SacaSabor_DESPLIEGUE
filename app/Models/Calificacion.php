<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = ['usuario_id', 'chicharroneria_id', 'puntaje'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function chicharroneria()
    {
        return $this->belongsTo(Chicharroneria::class);
    }
}
