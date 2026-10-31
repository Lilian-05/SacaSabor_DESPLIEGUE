@extends('layouts.panel')

@section('titulo', 'Panel Administrador')
@section('panel-tipo', 'del Administrador')
@section('panel-ruta', 'Panel general')

@section('menu')
    @include('partials.menu-admin')
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>🛡️ Panel de administración</h2>
    <p>Supervisa y gestiona toda la plataforma SacaSabor</p>
</div>

<div class="grid-stats">
    <div class="tarjeta-stat azul">
        <div class="stat-icono">👥</div>
        <div class="stat-numero">{{ $stats['usuarios'] }}</div>
        <div class="stat-label">Usuarios registrados</div>
    </div>
    <div class="tarjeta-stat roja">
        <div class="stat-icono">🏪</div>
        <div class="stat-numero">{{ $stats['chicharronerias'] }}</div>
        <div class="stat-label">Chicharronerías</div>
    </div>
    <div class="tarjeta-stat naranja">
        <div class="stat-icono">🍽️</div>
        <div class="stat-numero">{{ $stats['productos'] }}</div>
        <div class="stat-label">Productos</div>
    </div>
    <div class="tarjeta-stat dorada">
        <div class="stat-icono">⭐</div>
        <div class="stat-numero">{{ $stats['promedio'] }}</div>
        <div class="stat-label">Calificación promedio</div>
    </div>
    <div class="tarjeta-stat verde">
        <div class="stat-icono">🟢</div>
        <div class="stat-numero">{{ $stats['disponibles'] }}</div>
        <div class="stat-label">Productos disponibles</div>
    </div>
    <div class="tarjeta-stat morada">
        <div class="stat-icono">💬</div>
        <div class="stat-numero">{{ $stats['comentarios'] }}</div>
        <div class="stat-label">Comentarios</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:24px">
    <div class="tarjeta-panel">
        <div class="titulo-panel">
            <h3>🏪 Chicharronerías recientes</h3>
            <a href="{{ route('admin.chicharronerias') }}" class="btn btn-dorado btn-pequeno">Ver todas</a>
        </div>
        @foreach($recientes as $chi)
            <div style="display:flex;align-items:center;gap:12px;padding:10px;border-radius:10px;background:#f7f7f9;margin-bottom:8px">
                <img src="{{ $chi->foto ? asset('storage/' . $chi->foto) : asset('storage/imagenes/chicharroneria-1.svg') }}" style="width:46px;height:46px;border-radius:8px;object-fit:cover" alt="">
                <div style="flex:1">
                    <div style="font-weight:600;font-size:14px">{{ $chi->nombre }}</div>
                    <div style="font-size:12px;color:var(--gris-oscuro)">{{ $chi->propietario->name ?? '-' }} · {{ $chi->productos_count }} productos</div>
                </div>
                @if($chi->activa)
                    <span class="etiqueta etiqueta-verde">Activa</span>
                @else
                    <span class="etiqueta etiqueta-roja">Inactiva</span>
                @endif
            </div>
        @endforeach
    </div>

    <div class="tarjeta-panel">
        <div class="titulo-panel">
            <h3>⭐ Últimas calificaciones</h3>
            <a href="{{ route('admin.calificaciones') }}" class="btn btn-dorado btn-pequeno">Ver todas</a>
        </div>
        @foreach($ultimasCalificaciones as $cal)
            <div style="display:flex;align-items:center;gap:12px;padding:10px;border-radius:10px;background:#f7f7f9;margin-bottom:8px">
                <div style="font-size:24px">{!! str_repeat('⭐', $cal->puntaje) !!}</div>
                <div style="flex:1">
                    <div style="font-weight:600;font-size:14px">{{ $cal->usuario->name ?? '-' }}</div>
                    <div style="font-size:12px;color:var(--gris-oscuro)">{{ $cal->chicharroneria->nombre ?? '-' }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
