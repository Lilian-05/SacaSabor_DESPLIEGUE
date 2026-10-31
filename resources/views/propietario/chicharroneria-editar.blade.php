@extends('layouts.panel')

@section('titulo', 'Mi chicharronería')
@section('panel-tipo', 'del Propietario')
@section('panel-ruta', 'Administrar mi chicharronería')

@section('menu')
    <div class="nav-titulo">Principal</div>
    <a href="{{ route('propietario.dashboard') }}" class="{{ request()->routeIs('propietario.dashboard') ? 'activo' : '' }}"><span class="icono">🏠</span> Inicio</a>
    <div class="nav-titulo">Mi negocio</div>
    <a href="{{ route('propietario.chicharroneria.editar') }}" class="activo"><span class="icono">🏪</span> Mi chicharronería</a>
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

<div class="panel-encabezado">
    <h2>🏪 Administrar mi chicharronería</h2>
    <p>Mantén actualizada la información de tu establecimiento.</p>
</div>

<div class="tarjeta-panel" style="max-width:700px">
    <div style="display:flex;gap:16px;align-items:center;margin-bottom:20px;flex-wrap:wrap">
        <img src="{{ $chicharroneria->foto ? asset('storage/' . $chicharroneria->foto) : asset('storage/imagenes/chicharroneria-1.svg') }}" style="width:90px;height:90px;border-radius:16px;object-fit:cover" alt="">
        <div>
            <h3 style="font-size:20px">{{ $chicharroneria->nombre }}</h3>
            <div style="color:var(--gris-oscuro);font-size:14px">📍 {{ $chicharroneria->zona ?? 'Sacaba' }}</div>
            <a href="{{ route('chicharronerias.show', $chicharroneria) }}" target="_blank" class="btn btn-dorado btn-pequeno" style="margin-top:8px">Ver en el sitio ↗</a>
        </div>
    </div>

    <form method="POST" action="{{ route('propietario.chicharroneria.editar') }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-grupo">
            <label>Nombre del establecimiento *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $chicharroneria->nombre) }}" required>
        </div>
        <div class="form-grupo">
            <label>Descripción</label>
            <textarea name="descripcion">{{ old('descripcion', $chicharroneria->descripcion) }}</textarea>
        </div>
        <div class="form-grupo">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $chicharroneria->telefono) }}">
        </div>
        <div class="form-grupo">
            <label>Cambiar fotografía</label>
            <input type="file" name="foto" accept="image/*">
        </div>
        <div class="form-grupo">
            <label>Cambiar portada</label>
            <input type="file" name="foto_portada" accept="image/*">
        </div>
        <div class="form-grupo">
            <label>Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion', $chicharroneria->direccion) }}">
        </div>
        <div class="form-grupo">
            <label>Zona</label>
            <input type="text" name="zona" value="{{ old('zona', $chicharroneria->zona) }}">
        </div>
        <div class="form-grupo">
            <label>Referencia</label>
            <input type="text" name="referencia" value="{{ old('referencia', $chicharroneria->referencia) }}">
        </div>
        <div class="form-grupo">
            <label>🎨 Color de tu chicharronería <span class="form-ayuda">(se verá en tu perfil público)</span></label>
            <div class="selector-colores">
                @php
                    $colores = ['#e63946', '#f77f00', '#2a9d8f', '#3b82f6', '#8b5cf6', '#ec4899', '#16a34a', '#1d1d1d'];
                @endphp
                @foreach($colores as $color)
                    <label class="opcion-color {{ (old('color', $chicharroneria->color) ?? '#e63946') === $color ? 'seleccionada' : '' }}">
                        <input type="radio" name="color" value="{{ $color }}" class="oculto"
                            {{ (old('color', $chicharroneria->color) ?? '#e63946') === $color ? 'checked' : '' }}
                            onclick="seleccionarColor(this)">
                        <span style="background:{{ $color }}"></span>
                    </label>
                @endforeach
            </div>
        </div>
        <input type="hidden" name="latitud" value="{{ $chicharroneria->latitud }}">
        <input type="hidden" name="longitud" value="{{ $chicharroneria->longitud }}">
        <button type="submit" class="btn btn-primario">💾 Guardar cambios</button>
    </form>
</div>

<script>
    function seleccionarColor(radio) {
        document.querySelectorAll('.opcion-color').forEach(function(o) { o.classList.remove('seleccionada'); });
        radio.closest('.opcion-color').classList.add('seleccionada');
    }
</script>

@endsection
