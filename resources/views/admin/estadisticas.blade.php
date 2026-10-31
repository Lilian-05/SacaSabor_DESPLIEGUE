@extends('layouts.panel')

@section('titulo', 'Estadísticas')
@section('panel-tipo', 'del Administrador')
@section('panel-ruta', 'Estadísticas de la plataforma')

@section('menu')
    @include('partials.menu-admin')
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>📊 Estadísticas de SacaSabor</h2>
    <p>Información general de la plataforma</p>
</div>

<div class="grid-stats">
    <div class="tarjeta-stat azul">
        <div class="stat-icono">👥</div>
        <div class="stat-numero">{{ $stats['usuarios'] }}</div>
        <div class="stat-label">Usuarios</div>
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
    <div class="tarjeta-stat verde">
        <div class="stat-icono">🟢</div>
        <div class="stat-numero">{{ $stats['disponibles'] }}</div>
        <div class="stat-label">Disponibles</div>
    </div>
    <div class="tarjeta-stat morada">
        <div class="stat-icono">🔴</div>
        <div class="stat-numero">{{ $stats['agotados'] }}</div>
        <div class="stat-label">Agotados</div>
    </div>
    <div class="tarjeta-stat dorada">
        <div class="stat-icono">⭐</div>
        <div class="stat-numero">{{ $stats['promedio'] }}</div>
        <div class="stat-label">Promedio</div>
    </div>
    <div class="tarjeta-stat roja">
        <div class="stat-icono">💬</div>
        <div class="stat-numero">{{ $stats['comentarios'] }}</div>
        <div class="stat-label">Comentarios</div>
    </div>
    <div class="tarjeta-stat azul">
        <div class="stat-icono">⭐</div>
        <div class="stat-numero">{{ $stats['calificaciones'] }}</div>
        <div class="stat-label">Calificaciones</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:24px">
    <div class="tarjeta-panel">
        <div class="titulo-panel"><h3>🏘️ Chicharronerías por zona</h3></div>
        @foreach($porZona as $zona)
            <div style="margin-bottom:14px">
                <div style="display:flex;justify-content:space-between;font-size:14px;margin-bottom:5px">
                    <strong>{{ $zona->zona }}</strong><span>{{ $zona->total }}</span>
                </div>
                <div style="background:#eee;border-radius:8px;height:12px;overflow:hidden">
                    @php $max = $porZona->max('total'); $ancho = $max > 0 ? ($zona->total / $max) * 100 : 0; @endphp
                    <div style="background:var(--gradiente);height:100%;width:{{ $ancho }}%;border-radius:8px"></div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="tarjeta-panel">
        <div class="titulo-panel"><h3>⭐ Distribución de calificaciones</h3></div>
        @for($i = 5; $i >= 1; $i--)
            @php
                $total = $calificacionesDistribucion->where('puntaje', $i)->first();
                $cantidad = $total->total ?? 0;
                $max = $calificacionesDistribucion->max('total') ?: 1;
                $ancho = ($cantidad / $max) * 100;
            @endphp
            <div style="margin-bottom:10px">
                <div style="display:flex;justify-content:space-between;font-size:14px;margin-bottom:5px">
                    <strong>{!! str_repeat('⭐', $i) !!}</strong><span>{{ $cantidad }}</span>
                </div>
                <div style="background:#eee;border-radius:8px;height:12px;overflow:hidden">
                    <div style="background:var(--dorado);height:100%;width:{{ $ancho }}%;border-radius:8px"></div>
                </div>
            </div>
        @endfor
    </div>
</div>

@endsection
