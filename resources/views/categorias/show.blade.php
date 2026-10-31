@extends('layouts.app')

@section('titulo', $categoria->nombre)

@section('contenido')

<section class="hero" style="padding:60px 0 70px">
    <div class="contenedor" style="text-align:center">
        <div style="font-size:60px;margin-bottom:10px">{{ $categoria->icono }}</div>
        <h2 style="font-size:38px;margin-bottom:10px">{{ $categoria->nombre }}</h2>
        <p style="color:#e0e0e0">{{ $categoria->descripcion }}</p>
    </div>
</section>

<section class="seccion">
    <div class="contenedor">
        @if($productos->count())
            <div class="grid-productos">
                @foreach($productos as $producto)
                    <div class="tarjeta-producto">
                        <div class="imagen">
                            <img src="{{ $producto->foto ? asset('storage/' . $producto->foto) : asset('storage/imagenes/producto-1.svg') }}" alt="{{ $producto->nombre }}">
                            <span class="estado-disponible">🟢 Disponible</span>
                        </div>
                        <div class="info">
                            <h4>{{ $producto->nombre }}</h4>
                            <span class="desc">{{ $producto->chicharroneria->nombre }}</span>
                            <p class="desc">{{ $producto->descripcion }}</p>
                            <div class="abajo">
                                <span class="precio">{{ number_format($producto->precio, 0, ',', '.') }} Bs</span>
                                <a href="{{ route('chicharronerias.show', $producto->chicharroneria) }}" class="btn btn-dorado btn-pequeno">Ver</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="paginacion">{{ $productos->links() }}</div>
        @else
            <div style="text-align:center;padding:60px 0">
                <div style="font-size:60px">🍽️</div>
                <h3>No hay productos en esta categoría</h3>
                <p style="color:var(--gris-oscuro);margin:10px 0 20px">Pronto habrá novedades.</p>
                <a href="{{ route('home') }}" class="btn btn-primario">Volver al inicio</a>
            </div>
        @endif
    </div>
</section>

@endsection
