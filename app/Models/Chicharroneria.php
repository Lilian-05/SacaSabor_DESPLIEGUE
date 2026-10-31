<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chicharroneria extends Model
{
    use HasFactory;

    protected $table = 'chicharronerias';

    protected $fillable = [
        'propietario_id', 'nombre', 'descripcion', 'direccion', 'zona',
        'referencia', 'telefono', 'foto', 'foto_portada',
        'latitud', 'longitud', 'destacado', 'activa', 'color',
    ];

    protected $casts = [
        'destacado' => 'boolean',
        'activa' => 'boolean',
    ];

    public function propietario()
    {
        return $this->belongsTo(User::class, 'propietario_id');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function calificacionPromedio()
    {
        return round($this->calificaciones()->avg('puntaje') ?? 0, 1);
    }

    public function cantidadProductos()
    {
        return $this->productos()->count();
    }

    public function productosDisponibles()
    {
        return $this->productos()->where('disponible', true)->count();
    }

    public function productosAgotados()
    {
        return $this->productos()->where('disponible', false)->count();
    }

    public function hexColor(): string
    {
        return $this->color ?: '#e63946';
    }

    public function temaClaro(): string
    {
        return $this->color ? $this->color . '22' : '#e6394622';
    }
}
