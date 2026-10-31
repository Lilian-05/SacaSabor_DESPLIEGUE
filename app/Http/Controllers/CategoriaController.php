<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;

class CategoriaController extends Controller
{
    public function show(Categoria $categoria)
    {
        $productos = Producto::with('chicharroneria', 'categoria')
            ->where('categoria_id', $categoria->id)
            ->where('disponible', true)
            ->paginate(12);

        return view('categorias.show', compact('categoria', 'productos'));
    }
}
