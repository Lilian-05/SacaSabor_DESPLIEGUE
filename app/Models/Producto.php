<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'chicharroneria_id', 'categoria_id', 'nombre',
        'descripcion', 'precio', 'foto', 'disponible',
    ];

    protected $casts = [
        'disponible' => 'boolean',
    ];

    public function chicharroneria()
    {
        return $this->belongsTo(Chicharroneria::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
