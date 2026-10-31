<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Chicharroneria;
use Illuminate\Http\Request;

class ChicharroneriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Chicharroneria::where('activa', true)
            ->withCount('productos')
            ->withAvg('calificaciones as promedio_calificaciones', 'puntaje');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('zona')) {
            $query->where('zona', 'like', '%' . $request->zona . '%');
        }

        if ($request->filled('categoria')) {
            $query->whereHas('productos', function ($q) use ($request) {
                $q->where('categoria_id', $request->categoria);
            });
        }

        if ($request->filled('calificacion')) {
            $minCalificacion = (float) $request->calificacion;
            $query->whereRaw('COALESCE((select avg(puntaje) from calificaciones where calificaciones.chicharroneria_id = chicharronerias.id), 0) >= ?', [$minCalificacion]);
        }

        $chicharronerias = $query->orderBy('nombre')->paginate(12)->withQueryString();

        $categorias = Categoria::all();
        $zonas = Chicharroneria::where('activa', true)->whereNotNull('zona')->distinct()->pluck('zona');

        return view('chicharronerias.index', compact('chicharronerias', 'categorias', 'zonas'));
    }

    public function show(Chicharroneria $chicharroneria)
    {
        abort_unless($chicharroneria->activa, 404);

        $chicharroneria->load([
            'productos.categoria',
            'comentarios.usuario',
            'calificaciones.usuario',
        ]);

        return view('chicharronerias.show', compact('chicharroneria'));
    }
}
