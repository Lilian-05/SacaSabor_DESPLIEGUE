@extends('layouts.panel')

@section('titulo', 'Productos')
@section('panel-tipo', 'del Administrador')
@section('panel-ruta', 'Supervisión de productos')

@section('menu')
    @include('partials.menu-admin')
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>🍽️ Productos</h2>
    <p>Supervisa todos los productos publicados ({{ $productos->total() }} en total)</p>
</div>

<div class="tarjeta-panel">
    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Chicharronería</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <img src="{{ $producto->foto ? asset('storage/' . $producto->foto) : asset('storage/imagenes/producto-1.svg') }}" style="width:44px;height:44px;border-radius:8px;object-fit:cover" alt="">
                                <strong>{{ $producto->nombre }}</strong>
                            </div>
                        </td>
                        <td>{{ $producto->chicharroneria->nombre ?? '-' }}</td>
                        <td>{{ $producto->categoria->nombre ?? '-' }}</td>
                        <td><strong>{{ number_format($producto->precio, 0, ',', '.') }} Bs</strong></td>
                        <td>
                            @if($producto->disponible)
                                <span class="etiqueta etiqueta-verde">🟢 Disponible</span>
                            @else
                                <span class="etiqueta etiqueta-roja">🔴 Agotado</span>
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.productos.eliminar', $producto) }}" onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-peligro btn-pequeno">🗑️ Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="paginacion">{{ $productos->links() }}</div>
</div>

@endsection
