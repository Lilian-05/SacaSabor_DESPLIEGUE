@extends('layouts.panel')

@section('titulo', 'Calificaciones')
@section('panel-tipo', 'del Administrador')
@section('panel-ruta', 'Consulta de calificaciones')

@section('menu')
    @include('partials.menu-admin')
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>⭐ Calificaciones</h2>
    <p>Consulta las valoraciones de los clientes ({{ $calificaciones->total() }} en total)</p>
</div>

<div class="tarjeta-panel">
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Chicharronería</th>
                    <th>Calificación</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($calificaciones as $cal)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div class="avatar-mini" style="width:34px;height:34px;font-size:13px">{{ strtoupper(substr($cal->usuario->name ?? '?',0,1)) }}</div>
                                <strong>{{ $cal->usuario->name ?? 'Usuario eliminado' }}</strong>
                            </div>
                        </td>
                        <td>{{ $cal->chicharroneria->nombre ?? '-' }}</td>
                        <td><span class="estrellas-display" style="font-size:18px">{!! str_repeat('⭐', $cal->puntaje) !!}</span></td>
                        <td>{{ $cal->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginacion">{{ $calificaciones->links() }}</div>
</div>

@endsection
