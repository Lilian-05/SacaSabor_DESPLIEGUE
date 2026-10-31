@extends('layouts.panel')

@section('titulo', 'Registrar mi chicharronería')
@section('panel-tipo', 'del Propietario')
@section('panel-ruta', 'Registrar mi chicharronería')

@section('menu')
    <div class="nav-titulo">Principal</div>
    <a href="{{ route('propietario.dashboard') }}" class="{{ request()->routeIs('propietario.dashboard') ? 'activo' : '' }}"><span class="icono">🏠</span> Inicio</a>
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>🏪 Registrar tu chicharronería</h2>
    <p>Completa estos datos para darle presencia digital a tu negocio en SacaSabor.</p>
</div>

<div class="tarjeta-panel" style="max-width:700px">
    <form method="POST" action="{{ route('propietario.chicharroneria.crear') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grupo">
            <label>Nombre del establecimiento *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Chicharronería La Tradición" required>
        </div>
        <div class="form-grupo">
            <label>Descripción</label>
            <textarea name="descripcion" placeholder="Cuéntanos sobre tu chicharronería, tu historia, tus especialidades...">{{ old('descripcion') }}</textarea>
        </div>
        <div class="form-grupo">
            <label>Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Ej: Av. Pando esq. Cochabamba">
        </div>
        <div class="form-grupo">
            <label>Zona</label>
            <input type="text" name="zona" value="{{ old('zona') }}" placeholder="Ej: Centro, Villa Obrera, Huayllani...">
        </div>
        <div class="form-grupo">
            <label>Referencia</label>
            <input type="text" name="referencia" value="{{ old('referencia') }}" placeholder="Ej: A dos cuadras de la plaza principal">
        </div>
        <div class="form-grupo">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 72234567">
        </div>
        <div class="form-grupo">
            <label>Fotografía del establecimiento</label>
            <input type="file" name="foto" accept="image/*">
        </div>
        <div class="form-grupo">
            <label>Fotografía de portada</label>
            <input type="file" name="foto_portada" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primario btn-bloque">✅ Crear mi chicharronería</button>
    </form>
</div>

@endsection
