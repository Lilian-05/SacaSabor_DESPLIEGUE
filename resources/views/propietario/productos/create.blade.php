@extends('layouts.panel')

@section('titulo', 'Agregar producto')
@section('panel-tipo', 'del Propietario')
@section('panel-ruta', 'Agregar producto')

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
    <h2>➕ Agregar producto</h2>
    <p>Registra un nuevo producto en el menú de <strong>{{ $chicharroneria->nombre }}</strong></p>
</div>

<div class="tarjeta-panel" style="max-width:650px">
    <form method="POST" action="{{ route('propietario.productos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grupo">
            <label>Nombre del producto *</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Chicharrón tradicional" required>
        </div>
        <div class="form-grupo">
            <label>Descripción</label>
            <textarea name="descripcion" placeholder="Describe el producto">{{ old('descripcion') }}</textarea>
        </div>
        <div class="form-grupo">
            <label>Precio (Bs) *</label>
            <input type="number" name="precio" value="{{ old('precio') }}" min="0" step="0.5" placeholder="35" required>
        </div>
        <div class="form-grupo">
            <label>Categoría *</label>
            <select name="categoria_id" required>
                <option value="">Selecciona una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->icono }} {{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-grupo">
            <label>Fotografía</label>
            <input type="file" name="foto" accept="image/*">
        </div>
        <div class="form-grupo">
            <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                <input type="checkbox" name="disponible" checked style="width:auto"> 🟢 Disponible inmediatamente
            </label>
        </div>
        <button type="submit" class="btn btn-primario">💾 Guardar producto</button>
        <a href="{{ route('propietario.productos.index') }}" class="btn btn-secundario">Cancelar</a>
    </form>
</div>

@endsection
