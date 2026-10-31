@extends('layouts.panel')

@section('titulo', 'Productos')
@section('panel-tipo', 'del Propietario')
@section('panel-ruta', 'Administrar menú')

@section('menu')
    <div class="nav-titulo">Principal</div>
    <a href="{{ route('propietario.dashboard') }}" class="{{ request()->routeIs('propietario.dashboard') ? 'activo' : '' }}"><span class="icono">🏠</span> Inicio</a>
    <div class="nav-titulo">Mi negocio</div>
    <a href="{{ route('propietario.chicharroneria.editar') }}" class="{{ request()->routeIs('propietario.chicharroneria.editar') ? 'activo' : '' }}"><span class="icono">🏪</span> Mi chicharronería</a>
    <a href="{{ route('propietario.ubicacion') }}" class="{{ request()->routeIs('propietario.ubicacion') ? 'activo' : '' }}"><span class="icono">📍</span> Ubicación</a>
    <a href="{{ route('propietario.productos.index') }}" class="activo"><span class="icono">🍽️</span> Menú / Productos</a>
    <div class="nav-titulo">Cuenta</div>
    <a href="{{ route('propietario.perfil') }}" class="{{ request()->routeIs('propietario.perfil') ? 'activo' : '' }}"><span class="icono">👤</span> Mi perfil</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button style="display:flex;align-items:center;gap:12px;padding:12px 14px;width:100%;background:none;border:none;color:#aab;font-size:14px;cursor:pointer;border-radius:10px;font-family:var(--fuente)">
            <span class="icono">🚪</span> Cerrar sesión
        </button>
    </form>
@endsection

@section('contenido')

<div class="panel-encabezado">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:15px">
        <div>
            <h2>🍽️ Menú / Productos</h2>
            <p>Administra los productos de {{ $chicharroneria->nombre }}</p>
        </div>
        <a href="{{ route('propietario.productos.create') }}" class="btn btn-primario">➕ Agregar producto</a>
    </div>
</div>

@if($productos->count())
    <div class="tarjeta-panel">
        <div class="tabla-container">
            <table class="tabla">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                        <tr>
                            <td><img src="{{ $producto->foto ? asset('storage/' . $producto->foto) : asset('storage/imagenes/producto-1.svg') }}" style="width:50px;height:50px;border-radius:8px;object-fit:cover" alt=""></td>
                            <td>
                                <strong>{{ $producto->nombre }}</strong>
                                <div style="font-size:12px;color:var(--gris-oscuro)">{{ \Illuminate\Support\Str::limit($producto->descripcion, 40) }}</div>
                            </td>
                            <td>{{ $producto->categoria->nombre ?? '-' }}</td>
                            <td><strong>{{ number_format($producto->precio, 0, ',', '.') }} Bs</strong></td>
                            <td>
                                @if($producto->disponible)
                                    <span class="etiqueta etiqueta-verde">🟢 Disponible</span>
                                @else
                                    <span class="etiqueta etiqueta-roja">🔴 Agotado</span>
                                @endif
                            </td>
                            <td>
                                <div class="acciones">
                                    <form method="POST" action="{{ route('propietario.productos.disponibilidad', $producto) }}">
                                        @csrf
                                        <button class="btn btn-verde btn-pequeno" title="Cambiar disponibilidad">
                                            {{ $producto->disponible ? '🔴 Agotar' : '🟢 Disponible' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('propietario.productos.edit', $producto) }}" class="btn btn-dorado btn-pequeno">✏️ Editar</a>
                                    <form method="POST" action="{{ route('propietario.productos.destroy', $producto) }}" onsubmit="return confirm('¿Eliminar este producto?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-peligro btn-pequeno">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="tarjeta-panel" style="text-align:center;padding:60px">
        <div style="font-size:60px">🍽️</div>
        <h3>Aún no tienes productos</h3>
        <p style="color:var(--gris-oscuro);margin:10px 0 20px">Agrega tu primer producto para que los clientes puedan ver tu menú.</p>
        <a href="{{ route('propietario.productos.create') }}" class="btn btn-primario">➕ Agregar producto</a>
    </div>
@endif

@endsection
