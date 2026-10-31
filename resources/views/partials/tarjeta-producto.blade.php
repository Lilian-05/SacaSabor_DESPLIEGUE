<div class="tarjeta-producto">
    <div class="imagen">
        <img src="{{ $producto->foto ? asset('storage/' . $producto->foto) : asset('storage/imagenes/producto-1.svg') }}" alt="{{ $producto->nombre }}">
        <span class="cat-chip">{{ $producto->categoria->icono ?? '🍽️' }} {{ $producto->categoria->nombre ?? 'Producto' }}</span>
        @if($producto->disponible)
            <span class="estado-disponible">🟢 Disponible</span>
        @else
            <span class="estado-agotado">🔴 Agotado</span>
        @endif
    </div>
    <div class="info">
        <h4>{{ $producto->nombre }}</h4>
        @if($producto->descripcion)
            <p class="desc">{{ $producto->descripcion }}</p>
        @endif
        <div class="abajo">
            <span class="precio">{{ number_format($producto->precio, 0, ',', '.') }} <small>Bs</small></span>
            @if(isset($conEnlace) && $conEnlace)
                <a href="{{ route('chicharronerias.show', $producto->chicharroneria) }}" class="btn btn-dorado btn-pequeno">Ver</a>
            @endif
        </div>
    </div>
</div>
