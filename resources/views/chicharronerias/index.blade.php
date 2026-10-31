@extends('layouts.app')

@section('titulo', 'Chicharronerías')

@section('contenido')

<section class="hero" style="padding:60px 0 70px">
    <div class="contenedor" style="text-align:center">
        <h2 style="font-size:38px;margin-bottom:10px">🏪 Chicharronerías de Sacaba</h2>
        <p style="color:#e0e0e0">Encuentra el establecimiento perfecto para disfrutar del mejor chicharrón</p>
    </div>
</section>

<section class="seccion">
    <div class="contenedor">

        {{-- Filtros --}}
        <div class="filtros">
            <form method="GET" action="{{ route('chicharronerias.index') }}" class="filtros-grid">
                <div class="form-grupo">
                    <label>🔎 Buscar por nombre</label>
                    <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Ej: El Buen Sabor">
                </div>
                <div class="form-grupo">
                    <label>📍 Zona</label>
                    <select name="zona">
                        <option value="">Todas las zonas</option>
                        @foreach($zonas as $zona)
                            <option value="{{ $zona }}" {{ request('zona') == $zona ? 'selected' : '' }}>{{ $zona }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-grupo">
                    <label>🍽️ Categoría</label>
                    <select name="categoria">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-grupo">
                    <label>⭐ Calificación mínima</label>
                    <select name="calificacion">
                        <option value="">Cualquiera</option>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ request('calificacion') == $i ? 'selected' : '' }}>{{ $i }} ⭐ o más</option>
                        @endfor
                    </select>
                </div>
                <div class="acciones">
                    <button type="submit" class="btn btn-primario">Filtrar</button>
                    <a href="{{ route('chicharronerias.index') }}" class="btn btn-secundario">Limpiar</a>
                </div>
            </form>
        </div>

        {{-- Listado --}}
        <div class="grid-chicharronerias">
            @forelse($chicharronerias as $chi)
                @include('partials.tarjeta-chicharroneria', ['chi' => $chi])
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:60px 0">
                    <div style="font-size:60px">🔍</div>
                    <h3>No se encontraron resultados</h3>
                    <p style="color:var(--gris-oscuro);margin:10px 0 20px">Intenta con otros términos de búsqueda.</p>
                    <a href="{{ route('chicharronerias.index') }}" class="btn btn-primario">Ver todas</a>
                </div>
            @endforelse
        </div>

        <div class="paginacion">
            {{ $chicharronerias->links() }}
        </div>

    </div>
</section>

@endsection
