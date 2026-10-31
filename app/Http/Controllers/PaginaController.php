<?php

namespace App\Http\Controllers;

use App\Models\Chicharroneria;
use Illuminate\Http\Request;

class PaginaController extends Controller
{
    public function nosotros()
    {
        $total = Chicharroneria::where('activa', true)->count();
        return view('paginas.nosotros', compact('total'));
    }

    public function contacto()
    {
        return view('paginas.contacto');
    }

    public function enviarContacto(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string'],
            'email' => ['required', 'email'],
            'mensaje' => ['required', 'string'],
        ]);

        return back()->with('success', '¡Gracias por tu mensaje! Te responderemos pronto.');
    }
}
