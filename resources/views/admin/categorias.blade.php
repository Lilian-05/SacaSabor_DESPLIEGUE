@extends('layouts.panel')

@section('titulo', 'Categorías')
@section('panel-tipo', 'del Administrador')
@section('panel-ruta', 'Gestión de categorías')

@section('menu')
    @include('partials.menu-admin')
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>📂 Categorías</h2>
    <p>Administra las categorías de productos de la plataforma</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:24px">
    <div class="tarjeta-panel">
        <div class="titulo-panel">
            <h3>➕ Nueva categoría</h3>
        </div>
        <form method="POST" action="{{ route('admin.categorias.guardar') }}">
            @csrf
            <div class="form-grupo">
                <label>Nombre</label>
                <input type="text" name="nombre" placeholder="Ej: Postres" required>
            </div>
            <div class="form-grupo">
                <label>Icono (emojis)</label>
                <input type="text" name="icono" placeholder="Ej: 🍰">
            </div>
            <div class="form-grupo">
                <label>Descripción</label>
                <textarea name="descripcion" placeholder="Breve descripción"></textarea>
            </div>
            <button type="submit" class="btn btn-primario">💾 Crear categoría</button>
        </form>
    </div>

    <div class="tarjeta-panel">
        <div class="titulo-panel">
            <h3>📋 Categorías existentes</h3>
        </div>
        @foreach($categorias as $categoria)
            <div style="padding:12px;border-radius:12px;background:#f7f7f9;margin-bottom:10px">
                <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                    <span style="font-size:26px">{{ $categoria->icono }}</span>
                    <strong style="flex:1">{{ $categoria->nombre }}</strong>
                    <span class="etiqueta etiqueta-gris">{{ $categoria->productos_count }} prod.</span>
                </div>
                <div style="font-size:13px;color:var(--gris-oscuro);margin-top:6px">{{ $categoria->descripcion }}</div>
                <div style="display:flex;gap:8px;margin-top:8px;flex-wrap:wrap">
                    <form method="POST" action="{{ route('admin.categorias.actualizar', $categoria) }}">
                        @csrf @method('PUT')
                        <input type="text" name="nombre" value="{{ $categoria->nombre }}" placeholder="Nombre" style="width:140px;padding:6px;border-radius:8px;border:1px solid #ddd">
                        <input type="text" name="icono" value="{{ $categoria->icono }}" placeholder="Icono" style="width:70px;padding:6px;border-radius:8px;border:1px solid #ddd">
                        <input type="text" name="descripcion" value="{{ $categoria->descripcion }}" placeholder="Descripción" style="width:180px;padding:6px;border-radius:8px;border:1px solid #ddd">
                        <button class="btn btn-dorado btn-pequeno">✏️ Guardar</button>
                    </form>
                    <form method="POST" action="{{ route('admin.categorias.eliminar', $categoria) }}" onsubmit="return confirm('¿Eliminar esta categoría?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-peligro btn-pequeno">🗑️</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
