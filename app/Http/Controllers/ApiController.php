<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Chicharroneria;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function chicharronerias(): JsonResponse
    {
        $chicharronerias = Chicharroneria::with('productos')
            ->where('activa', true)
            ->orderBy('nombre')
            ->get()
            ->map(fn ($c) => [
                'id' => $c->id,
                'nombre' => $c->nombre,
                'descripcion' => $c->descripcion,
                'direccion' => $c->direccion,
                'zona' => $c->zona,
                'telefono' => $c->telefono,
                'latitud' => $c->latitud,
                'longitud' => $c->longitud,
                'color' => $c->hexColor(),
                'calificacion_promedio' => $c->calificacionPromedio(),
                'cantidad_productos' => $c->productos()->count(),
                'productos_disponibles' => $c->productosDisponibles(),
            ]);

        return response()->json([
            'mensaje' => 'Lista de chicharronerías de Sacaba',
            'total' => $chicharronerias->count(),
            'datos' => $chicharronerias->values(),
        ], 200);
    }

    public function chicharroneria(Chicharroneria $chicharroneria): JsonResponse
    {
        return response()->json([
            'id' => $chicharroneria->id,
            'nombre' => $chicharroneria->nombre,
            'descripcion' => $chicharroneria->descripcion,
            'direccion' => $chicharroneria->direccion,
            'zona' => $chicharroneria->zona,
            'referencia' => $chicharroneria->referencia,
            'telefono' => $chicharroneria->telefono,
            'latitud' => $chicharroneria->latitud,
            'longitud' => $chicharroneria->longitud,
            'color' => $chicharroneria->hexColor(),
            'calificacion_promedio' => $chicharroneria->calificacionPromedio(),
            'total_calificaciones' => $chicharroneria->calificaciones()->count(),
            'cantidad_productos' => $chicharroneria->cantidadProductos(),
            'productos_disponibles' => $chicharroneria->productosDisponibles(),
            'productos_agotados' => $chicharroneria->productosAgotados(),
        ], 200);
    }

    public function productos(Chicharroneria $chicharroneria): JsonResponse
    {
        $productos = $chicharroneria->productos()->with('categoria')->get()->map(fn ($p) => [
            'id' => $p->id,
            'nombre' => $p->nombre,
            'descripcion' => $p->descripcion,
            'precio' => $p->precio,
            'disponible' => $p->disponible,
            'categoria' => $p->categoria?->nombre,
        ]);

        return response()->json([
            'chicharroneria' => $chicharroneria->nombre,
            'total' => $productos->count(),
            'productos' => $productos->values(),
        ], 200);
    }

    public function categorias(): JsonResponse
    {
        $categorias = Categoria::orderBy('nombre')->get()->map(fn ($c) => [
            'id' => $c->id,
            'nombre' => $c->nombre,
            'icono' => $c->icono,
            'descripcion' => $c->descripcion,
        ]);

        return response()->json([
            'total' => $categorias->count(),
            'categorias' => $categorias->values(),
        ], 200);
    }
}