<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Chicharroneria;
use App\Models\Producto;

class HomeController extends Controller
{
    public function index()
    {
        $destacadas = Chicharroneria::where('activa', true)
            ->where('destacado', true)
            ->withCount('productos')
            ->get();

        $chicharronerias = Chicharroneria::where('activa', true)
            ->withCount('productos')
            ->get();

        $categorias = Categoria::all();

        $productos = Producto::with('chicharroneria', 'categoria')
            ->where('disponible', true)
            ->take(8)
            ->get();

        $masValoradas = Chicharroneria::where('activa', true)
            ->withCount(['calificaciones'])
            ->get()
            ->sortByDesc(fn ($c) => $c->calificacionPromedio())
            ->take(3);

        return view('home', compact(
            'destacadas',
            'chicharronerias',
            'categorias',
            'productos',
            'masValoradas',
        ));
    }
}
