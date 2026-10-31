<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $chicharroneria = auth()->user()->chicharroneria;
        abort_unless($chicharroneria, 404);

        $productos = Producto::where('chicharroneria_id', $chicharroneria->id)
            ->with('categoria')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('propietario.productos.index', compact('productos', 'chicharroneria'));
    }

    public function create()
    {
        $chicharroneria = auth()->user()->chicharroneria;
        abort_unless($chicharroneria, 404);

        $categorias = Categoria::all();
        return view('propietario.productos.create', compact('chicharroneria', 'categorias'));
    }

    public function store(Request $request)
    {
        $chicharroneria = auth()->user()->chicharroneria;
        abort_unless($chicharroneria, 404);

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'foto' => ['nullable', 'image', 'max:4096'],
            'disponible' => ['nullable'],
        ]);

        $data['disponible'] = $request->has('disponible');
        $data['chicharroneria_id'] = $chicharroneria->id;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('productos', 'public');
        }

        Producto::create($data);

        return redirect()->route('propietario.productos.index')->with('success', 'Producto agregado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $this->verificarPropietario($producto);

        $chicharroneria = auth()->user()->chicharroneria;
        $categorias = Categoria::all();

        return view('propietario.productos.edit', compact('producto', 'chicharroneria', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $this->verificarPropietario($producto);

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'precio' => ['required', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'foto' => ['nullable', 'image', 'max:4096'],
            'disponible' => ['nullable'],
        ]);

        $data['disponible'] = $request->has('disponible');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('productos', 'public');
        }

        $producto->update($data);

        return redirect()->route('propietario.productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Producto $producto)
    {
        $this->verificarPropietario($producto);
        $producto->delete();

        return redirect()->route('propietario.productos.index')->with('success', 'Producto eliminado.');
    }

    public function toggleDisponibilidad(Producto $producto)
    {
        $this->verificarPropietario($producto);
        $producto->update(['disponible' => !$producto->disponible]);

        return back()->with('success', $producto->disponible ? 'Producto marcado como disponible.' : 'Producto marcado como agotado.');
    }

    protected function verificarPropietario(Producto $producto)
    {
        $chicharroneria = auth()->user()->chicharroneria;
        abort_unless($chicharroneria && $producto->chicharroneria_id === $chicharroneria->id, 403);
    }
}
