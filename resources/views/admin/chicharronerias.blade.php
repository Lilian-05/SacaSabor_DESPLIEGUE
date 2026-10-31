@extends('layouts.panel')

@section('titulo', 'Chicharronerías')
@section('panel-tipo', 'del Administrador')
@section('panel-ruta', 'Gestión de chicharronerías')

@section('menu')
    @include('partials.menu-admin')
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>🏪 Chicharronerías</h2>
    <p>Supervisa los establecimientos registrados ({{ $chicharronerias->total() }} en total)</p>
</div>

<div class="tarjeta-panel">
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Establecimiento</th>
                    <th>Propietario</th>
                    <th>Prods.</th>
                    <th>⭐</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chicharronerias as $chi)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <img src="{{ $chi->foto ? asset('storage/' . $chi->foto) : asset('storage/imagenes/chicharroneria-1.svg') }}" style="width:44px;height:44px;border-radius:8px;object-fit:cover" alt="">
                                <div>
                                    <strong>{{ $chi->nombre }}</strong>
                                    <div style="font-size:12px;color:var(--gris-oscuro)">📍 {{ $chi->zona ?? 'Sacaba' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $chi->propietario->name ?? 'Sin propietario' }}</td>
                        <td>{{ $chi->productos_count }}</td>
                        <td><span class="estrellas-display">⭐ {{ $chi->calificacionPromedio() }}</span></td>
                        <td>
                            <span class="etiqueta {{ $chi->activa ? 'etiqueta-verde' : 'etiqueta-roja' }}">{{ $chi->activa ? 'Activa' : 'Inactiva' }}</span>
                            @if($chi->destacado)<span class="etiqueta etiqueta-dorada">⭐ Destacada</span>@endif
                        </td>
                        <td>
                            <div class="acciones">
                                <a href="{{ route('chicharronerias.show', $chi) }}" target="_blank" class="btn btn-dorado btn-pequeno">👁️ Ver</a>
                                <form method="POST" action="{{ route('admin.chicharronerias.actualizar', $chi) }}">
                                    @csrf @method('PUT')
                                    <button name="destacado" class="btn btn-pequeno {{ $chi->destacado ? 'btn-secundario' : 'btn-verde' }}">
                                        {{ $chi->destacado ? 'Quitar destacado' : '⭐ Destacar' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.chicharronerias.actualizar', $chi) }}">
                                    @csrf @method('PUT')
                                    <button name="activa" class="btn btn-pequeno {{ $chi->activa ? 'btn-peligro' : 'btn-verde' }}">
                                        {{ $chi->activa ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.chicharronerias.eliminar', $chi) }}" onsubmit="return confirm('¿Eliminar esta chicharronería? Se eliminarán también sus productos, comentarios y calificaciones.')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-peligro btn-pequeno">🗑️ Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginacion">{{ $chicharronerias->links() }}</div>
</div>

@endsection
