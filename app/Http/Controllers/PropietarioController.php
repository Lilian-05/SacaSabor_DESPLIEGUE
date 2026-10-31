<?php

namespace App\Http\Controllers;

use App\Models\Chicharroneria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropietarioController extends Controller
{
    public function dashboard()
    {
        $chicharroneria = auth()->user()->chicharroneria;
        if (!$chicharroneria) {
            return redirect()->route('propietario.chicharroneria.crear');
        }

        return view('propietario.dashboard', compact('chicharroneria'));
    }

    public function crearChicharroneria()
    {
        if (auth()->user()->chicharroneria) {
            return redirect()->route('propietario.dashboard');
        }
        return view('propietario.chicharroneria-crear');
    }

    public function guardarChicharroneria(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'zona' => ['nullable', 'string', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'latitud' => ['nullable', 'string'],
            'longitud' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:9'],
            'foto' => ['nullable', 'image', 'max:4096'],
            'foto_portada' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('chicharronerias', 'public');
        }
        if ($request->hasFile('foto_portada')) {
            $data['foto_portada'] = $request->file('foto_portada')->store('chicharronerias', 'public');
        }

        auth()->user()->chicharroneria()->create($data);

        return redirect()->route('propietario.dashboard')->with('success', 'Tu chicharronería fue creada con éxito.');
    }

    public function editarChicharroneria()
    {
        $chicharroneria = auth()->user()->chicharroneria;
        abort_unless($chicharroneria, 404);
        return view('propietario.chicharroneria-editar', compact('chicharroneria'));
    }

    public function actualizarChicharroneria(Request $request)
    {
        $chicharroneria = auth()->user()->chicharroneria;
        abort_unless($chicharroneria, 404);

        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'zona' => ['nullable', 'string', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'latitud' => ['nullable', 'string'],
            'longitud' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:9'],
            'foto' => ['nullable', 'image', 'max:4096'],
            'foto_portada' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('chicharronerias', 'public');
        }
        if ($request->hasFile('foto_portada')) {
            $data['foto_portada'] = $request->file('foto_portada')->store('chicharronerias', 'public');
        }

        $chicharroneria->update($data);

        return redirect()->route('propietario.chicharroneria.editar')->with('success', 'Datos actualizados correctamente.');
    }

    public function ubicacion()
    {
        $chicharroneria = auth()->user()->chicharroneria;
        abort_unless($chicharroneria, 404);
        return view('propietario.ubicacion', compact('chicharroneria'));
    }

    public function actualizarUbicacion(Request $request)
    {
        $chicharroneria = auth()->user()->chicharroneria;
        abort_unless($chicharroneria, 404);

        $data = $request->validate([
            'direccion' => ['nullable', 'string', 'max:255'],
            'zona' => ['nullable', 'string', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'latitud' => ['nullable', 'string'],
            'longitud' => ['nullable', 'string'],
        ]);

        $chicharroneria->update($data);

        return redirect()->route('propietario.ubicacion')->with('success', 'Ubicación actualizada.');
    }

    public function perfil()
    {
        return view('propietario.perfil');
    }

    public function actualizarPerfil(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'regex:/^[^@\s]+@[^@\s]+\.[^@\s]+$/', 'unique:users,email,' . $user->id],
            'telefono' => ['nullable', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('usuarios', 'public');
        }

        $user->update($data);

        return redirect()->route('propietario.perfil')->with('success', 'Perfil actualizado.');
    }
}
