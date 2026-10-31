@extends('layouts.panel')

@section('titulo', 'Usuarios')
@section('panel-tipo', 'del Administrador')
@section('panel-ruta', 'Gestión de usuarios')

@section('menu')
    @include('partials.menu-admin')
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>👥 Usuarios</h2>
    <p>Gestiona las cuentas de los usuarios de SacaSabor ({{ $usuarios->total() }} en total)</p>
</div>

<div class="tarjeta-panel">
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Chicharronería</th>
                    <th>Calif./Coment.</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div class="avatar-mini" style="width:36px;height:36px">{{ strtoupper(substr($usuario->name,0,1)) }}</div>
                                <strong>{{ $usuario->name }}</strong>
                                @if($usuario->id === auth()->id())<span class="etiqueta etiqueta-dorada">Tú</span>@endif
                            </div>
                        </td>
                        <td>{{ $usuario->email }}</td>
                        <td>
                            <span class="etiqueta {{ $usuario->rol == 'administrador' ? 'etiqueta-dorada' : ($usuario->rol == 'propietario' ? 'etiqueta-azul' : 'etiqueta-gris') }}">
                                {{ ucfirst($usuario->rol) }}
                            </span>
                        </td>
                        <td>{{ $usuario->chicharroneria->nombre ?? '-' }}</td>
                        <td>{{ $usuario->calificaciones_count }} / {{ $usuario->comentarios_count }}</td>
                        <td>
                            @if($usuario->id !== auth()->id())
                                <div class="acciones">
                                    <form method="POST" action="{{ route('admin.usuarios.actualizar', $usuario) }}">
                                        @csrf @method('PUT')
                                        <select name="rol" onchange="this.form.submit()">
                                            <option value="cliente" {{ $usuario->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
                                            <option value="propietario" {{ $usuario->rol == 'propietario' ? 'selected' : '' }}>Propietario</option>
                                            <option value="administrador" {{ $usuario->rol == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                        </select>
                                    </form>
                                    <form method="POST" action="{{ route('admin.usuarios.eliminar', $usuario) }}" onsubmit="return confirm('¿Eliminar a {{ $usuario->name }}?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-peligro btn-pequeno">🗑️</button>
                                    </form>
                                </div>
                            @else
                                <span style="color:var(--gris-oscuro);font-size:13px">Sin acciones</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginacion">{{ $usuarios->links() }}</div>
</div>

@endsection
