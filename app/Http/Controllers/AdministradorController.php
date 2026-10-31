<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Categoria;
use App\Models\Chicharroneria;
use App\Models\Comentario;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'usuarios' => User::count(),
            'clientes' => User::where('rol', 'cliente')->count(),
            'propietarios' => User::where('rol', 'propietario')->count(),
            'chicharronerias' => Chicharroneria::count(),
            'productos' => Producto::count(),
            'disponibles' => Producto::where('disponible', true)->count(),
            'agotados' => Producto::where('disponible', false)->count(),
            'comentarios' => Comentario::count(),
            'calificaciones' => Calificacion::count(),
            'promedio' => round(Calificacion::avg('puntaje') ?? 0, 1),
        ];

        $recientes = Chicharroneria::with('propietario')->withCount('productos')->latest()->take(6)->get();
        $ultimasCalificaciones = Calificacion::with(['usuario', 'chicharroneria'])->latest()->take(6)->get();

        return view('admin.dashboard', compact('stats', 'recientes', 'ultimasCalificaciones'));
    }

    public function usuarios()
    {
        $usuarios = User::withCount('chicharroneria', 'calificaciones', 'comentarios')->paginate(15);
        return view('admin.usuarios', compact('usuarios'));
    }

    public function actualizarUsuario(Request $request, User $usuario)
    {
        $data = $request->validate([
            'rol' => ['required', 'in:cliente,propietario,administrador'],
        ]);

        $usuario->update([
            'rol' => $data['rol'],
        ]);

        return back()->with('success', 'Usuario actualizado.');
    }

    public function eliminarUsuario(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }
        $usuario->delete();
        return back()->with('success', 'Usuario eliminado.');
    }

    public function chicharronerias()
    {
        $chicharronerias = Chicharroneria::with('propietario')->withCount(['productos', 'calificaciones'])->paginate(15);
        return view('admin.chicharronerias', compact('chicharronerias'));
    }

    public function actualizarChicharroneria(Request $request, Chicharroneria $chicharroneria)
    {
        if ($request->has('destacado')) {
            $chicharroneria->update(['destacado' => !$chicharroneria->destacado]);
            return back()->with('success', 'Estado de destacado actualizado.');
        }

        if ($request->has('activa')) {
            $chicharroneria->update(['activa' => !$chicharroneria->activa]);
            return back()->with('success', 'Estado de la chicharronería actualizado.');
        }

        return back();
    }

    public function eliminarChicharroneria(Chicharroneria $chicharroneria)
    {
        $chicharroneria->delete();
        return back()->with('success', 'Chicharronería eliminada.');
    }

    public function productos()
    {
        $productos = Producto::with('chicharroneria', 'categoria')->paginate(15);
        return view('admin.productos', compact('productos'));
    }

    public function eliminarProducto(Producto $producto)
    {
        $producto->delete();
        return back()->with('success', 'Producto eliminado.');
    }

    public function comentarios()
    {
        $comentarios = Comentario::with(['usuario', 'chicharroneria'])->latest()->paginate(15);
        return view('admin.comentarios', compact('comentarios'));
    }

    public function eliminarComentario(Comentario $comentario)
    {
        $comentario->delete();
        return back()->with('success', 'Comentario eliminado.');
    }

    public function calificaciones()
    {
        $calificaciones = Calificacion::with(['usuario', 'chicharroneria'])->latest()->paginate(15);
        return view('admin.calificaciones', compact('calificaciones'));
    }

    public function categorias()
    {
        $categorias = Categoria::withCount('productos')->get();
        return view('admin.categorias', compact('categorias'));
    }

    public function guardarCategoria(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'icono' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
        ]);

        Categoria::create($data);
        return back()->with('success', 'Categoría creada.');
    }

    public function actualizarCategoria(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nombre' => ['nullable', 'string', 'max:255'],
            'icono' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $filtered = array_filter($data, function ($v) {
            return $v !== null && $v !== '';
        });

        if (empty($filtered)) {
            return back()->with('error', 'No hay datos para actualizar.');
        }

        $categoria->update($filtered);
        return back()->with('success', 'Categoría actualizada.');
    }

    public function eliminarCategoria(Categoria $categoria)
    {
        if ($categoria->productos()->count() > 0) {
            return back()->with('error', 'No se puede eliminar una categoría con productos asociados.');
        }

        $categoria->delete();
        return back()->with('success', 'Categoría eliminada.');
    }

    public function estadisticas()
    {
        $stats = [
            'usuarios' => User::count(),
            'chicharronerias' => Chicharroneria::count(),
            'productos' => Producto::count(),
            'disponibles' => Producto::where('disponible', true)->count(),
            'agotados' => Producto::where('disponible', false)->count(),
            'comentarios' => Comentario::count(),
            'calificaciones' => Calificacion::count(),
            'promedio' => round(Calificacion::avg('puntaje') ?? 0, 1),
        ];

        $porZona = Chicharroneria::whereNotNull('zona')->selectRaw('zona, count(*) as total')->groupBy('zona')->get();

        $calificacionesDistribucion = Calificacion::selectRaw('puntaje, count(*) as total')->groupBy('puntaje')->orderBy('puntaje')->get();

        return view('admin.estadisticas', compact('stats', 'porZona', 'calificacionesDistribucion'));
    }
}
