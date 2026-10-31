@extends('layouts.panel')

@section('titulo', 'Inicio')
@section('panel-tipo', 'del Propietario')
@section('panel-ruta', 'Mi chicharronería')

@section('menu')
    <div class="nav-titulo">Principal</div>
    <a href="{{ route('propietario.dashboard') }}" class="{{ request()->routeIs('propietario.dashboard') ? 'activo' : '' }}"><span class="icono">🏠</span> Inicio</a>
    <div class="nav-titulo">Mi negocio</div>
    <a href="{{ route('propietario.chicharroneria.editar') }}" class="{{ request()->routeIs('propietario.chicharroneria.*') && !request()->routeIs('propietario.productos.*') ? 'activo' : '' }}"><span class="icono">🏪</span> Mi chicharronería</a>
    <a href="{{ route('propietario.ubicacion') }}" class="{{ request()->routeIs('propietario.ubicacion') ? 'activo' : '' }}"><span class="icono">📍</span> Ubicación</a>
    <a href="{{ route('propietario.productos.index') }}" class="{{ request()->routeIs('propietario.productos.*') ? 'activo' : '' }}"><span class="icono">🍽️</span> Menú / Productos</a>
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

@php
    $promedio = $chicharroneria->calificacionPromedio();
@endphp

<div class="panel-encabezado">
    <h2>¡Hola, {{ auth()->user()->name }}! 👋</h2>
    <p>Bienvenido al panel de <strong>{{ $chicharroneria->nombre }}</strong></p>
</div>

<div class="grid-stats">
    <div class="tarjeta-stat roja">
        <div class="stat-icono">🍽️</div>
        <div class="stat-numero">{{ $chicharroneria->cantidadProductos() }}</div>
        <div class="stat-label">Productos totales</div>
    </div>
    <div class="tarjeta-stat verde">
        <div class="stat-icono">🟢</div>
        <div class="stat-numero">{{ $chicharroneria->productosDisponibles() }}</div>
        <div class="stat-label">Disponibles</div>
    </div>
    <div class="tarjeta-stat naranja">
        <div class="stat-icono">🔴</div>
        <div class="stat-numero">{{ $chicharroneria->productosAgotados() }}</div>
        <div class="stat-label">Agotados</div>
    </div>
    <div class="tarjeta-stat dorada">
        <div class="stat-icono">⭐</div>
        <div class="stat-numero">{{ $promedio }}</div>
        <div class="stat-label">Calificación</div>
    </div>
    <div class="tarjeta-stat azul">
        <div class="stat-icono">💬</div>
        <div class="stat-numero">{{ $chicharroneria->comentarios->count() }}</div>
        <div class="stat-label">Comentarios recibidos</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:24px">
    <div class="tarjeta-panel">
        <div class="titulo-panel">
            <h3>📊 Resumen rápido</h3>
            <a href="{{ route('propietario.productos.index') }}" class="btn btn-dorado btn-pequeno">Gestionar productos</a>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px">
            @foreach($chicharroneria->productos->take(6) as $producto)
                <div style="display:flex;align-items:center;gap:12px;padding:10px;border-radius:10px;background:#f7f7f9">
                    <img src="{{ $producto->foto ? asset('storage/' . $producto->foto) : asset('storage/imagenes/producto-1.svg') }}" style="width:48px;height:48px;border-radius:8px;object-fit:cover" alt="">
                    <div style="flex:1">
                        <div style="font-weight:600;font-size:14px">{{ $producto->nombre }}</div>
                        <div style="font-size:13px;color:var(--gris-oscuro)">{{ $producto->precio }} Bs</div>
                    </div>
                    @if($producto->disponible)
                        <span class="etiqueta etiqueta-verde">🟢 Disponible</span>
                    @else
                        <span class="etiqueta etiqueta-roja">🔴 Agotado</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="tarjeta-panel">
        <div class="titulo-panel">
            <h3>💬 Comentarios recientes</h3>
            <a href="{{ route('home') }}#opiniones" class="btn btn-outline btn-pequeno">Ver en sitio</a>
        </div>
        @if($chicharroneria->comentarios->count())
            @foreach($chicharroneria->comentarios->take(4) as $comentario)
                <div style="padding:12px;border-radius:10px;background:#f7f7f9;margin-bottom:8px">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
                        <div class="avatar-mini" style="width:30px;height:30px;font-size:12px">{{ strtoupper(substr($comentario->usuario->name,0,1)) }}</div>
                        <strong style="font-size:13px">{{ $comentario->usuario->name }}</strong>
                    </div>
                    <p style="font-size:14px">"{{ $comentario->contenido }}"</p>
                </div>
            @endforeach
        @else
            <p style="color:var(--gris-oscuro)">Aún no tienes comentarios.</p>
        @endif
    </div>
</div>

@endsection
