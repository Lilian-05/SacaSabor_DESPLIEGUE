@extends('layouts.panel')

@section('titulo', 'Editar producto')
@section('panel-tipo', 'del Propietario')
@section('panel-ruta', 'Editar producto')

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
    <h2>✏️ Editar producto</h2>
    <p>Modifica la información de <strong>{{ $producto->nombre }}</strong></p>
</div>

<div class="tarjeta-panel" style="max-width:650px">
    <div style="display:flex;gap:16px;align-items:center;margin-bottom:20px">
        <img src="{{ $producto->foto ? asset('storage/' . $producto->foto) : asset('storage/imagenes/producto-1.svg') }}" style="width:70px;height:70px;border-radius:12px;object-fit:cover" alt="">
        <div>
            <strong style="font-size:18px">{{ $producto->nombre }}</strong>
            @if($producto->disponible)
                <div><span class="etiqueta etiqueta-verde">🟢 Disponible</span></div>
            @else
                <div><span class="etiqueta etiqueta-roja">🔴 Agotado</span></div>
            @endif
        </div>
    </div>

    <form method="POST" action="{{ route('propietario.productos.update', $producto) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-grupo">
            <label>Nombre del producto *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>
        <div class="form-grupo">
            <label>Descripción</label>
            <textarea name="descripcion">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>
        <div class="form-grupo">
            <label>Precio (Bs) *</label>
            <input type="number" name="precio" value="{{ old('precio', $producto->precio) }}" min="0" step="0.5" required>
        </div>
        <div class="form-grupo">
            <label>Categoría *</label>
            <select name="categoria_id" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ (old('categoria_id', $producto->categoria_id) == $categoria->id) ? 'selected' : '' }}>{{ $categoria->icono }} {{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-grupo">
            <label>Cambiar fotografía</label>
            <input type="file" name="foto" accept="image/*">
        </div>
        <div class="form-grupo">
            <label style="display:flex;align-items:center;gap:10px;cursor:pointer">
                <input type="checkbox" name="disponible" {{ $producto->disponible ? 'checked' : '' }} style="width:auto"> 🟢 Disponible
            </label>
        </div>
        <button type="submit" class="btn btn-primario">💾 Guardar cambios</button>
        <a href="{{ route('propietario.productos.index') }}" class="btn btn-secundario">Cancelar</a>
    </form>
</div>

@endsection
