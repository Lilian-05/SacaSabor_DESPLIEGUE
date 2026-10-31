<div class="tarjeta-chicharroneria">
    <div class="tarjeta-imagen">
        <img src="{{ $chi->foto ? asset('storage/' . $chi->foto) : asset('storage/imagenes/chicharroneria-1.svg') }}" alt="{{ $chi->nombre }}">
        @if($chi->destacado)
            <span class="tarjeta-badge destacado">⭐ Destacada</span>
        @else
            <span class="tarjeta-badge">🍖 Chicharronería</span>
        @endif
    </div>
    <div class="tarjeta-cuerpo">
        <h4>{{ $chi->nombre }}</h4>
        <div class="tarjeta-meta">
            <span>📍 {{ $chi->zona ?? 'Sacaba' }}</span>
            <span class="estrellas">⭐ {{ $chi->calificacionPromedio() }}</span>
            <span>🍽️ {{ $chi->cantidadProductos() }} productos</span>
        </div>
        <p class="tarjeta-descripcion">{{ \Illuminate\Support\Str::limit($chi->descripcion, 90) }}</p>
        <div class="tarjeta-botones">
            <a href="{{ route('chicharronerias.show', $chi) }}" class="btn btn-primario btn-bloque">Ver chicharronería</a>
        </div>
    </div>
</div>
