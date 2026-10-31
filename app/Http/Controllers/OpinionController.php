<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\Chicharroneria;
use App\Models\Comentario;
use Illuminate\Http\Request;

class OpinionController extends Controller
{
    public function store(Request $request, Chicharroneria $chicharroneria)
    {
        $request->validate([
            'puntaje' => ['required', 'integer', 'between:1,5'],
            'contenido' => ['nullable', 'string', 'max:1000'],
        ]);

        if (auth()->check() && auth()->user()->esPropietario()) {
            $propietaria = auth()->user()->chicharroneria;
            if ($propietaria && $propietaria->id === $chicharroneria->id) {
                return back()->with('error', 'No puedes calificar o comentar tu propia chicharronería.');
            }
        }

        Calificacion::updateOrCreate(
            ['usuario_id' => auth()->id(), 'chicharroneria_id' => $chicharroneria->id],
            ['puntaje' => $request->puntaje]
        );

        if (!empty($request->contenido)) {
            $existe = Comentario::where('usuario_id', auth()->id())
                ->where('chicharroneria_id', $chicharroneria->id)
                ->where('contenido', $request->contenido)
                ->exists();

            if (!$existe) {
                Comentario::create([
                    'usuario_id' => auth()->id(),
                    'chicharroneria_id' => $chicharroneria->id,
                    'contenido' => $request->contenido,
                ]);
            }
        }

        return back()->with('success', '¡Gracias por tu opinión!');
    }

    public function destruirComentario(Comentario $comentario)
    {
        abort_unless(auth()->id() === $comentario->usuario_id, 403);
        $comentario->delete();
        return back()->with('success', 'Comentario eliminado.');
    }
}
