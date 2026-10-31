@extends('layouts.panel')

@section('titulo', 'Comentarios')
@section('panel-tipo', 'del Administrador')
@section('panel-ruta', 'Revisión de comentarios')

@section('menu')
    @include('partials.menu-admin')
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>💬 Comentarios</h2>
    <p>Revisa el contenido publicado por los usuarios ({{ $comentarios->total() }} en total)</p>
</div>

<div class="tarjeta-panel">
    @forelse($comentarios as $comentario)
        <div style="padding:16px;border-radius:12px;background:#f7f7f9;margin-bottom:12px">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;flex-wrap:wrap">
                <div class="avatar-mini">{{ strtoupper(substr($comentario->usuario->name ?? '?',0,1)) }}</div>
                <div style="flex:1;min-width:150px">
                    <strong>{{ $comentario->usuario->name ?? 'Usuario eliminado' }}</strong>
                    <div style="font-size:12px;color:var(--gris-oscuro)">{{ $comentario->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <span class="etiqueta etiqueta-azul">🏪 {{ $comentario->chicharroneria->nombre ?? '-' }}</span>
                <form method="POST" action="{{ route('admin.comentarios.eliminar', $comentario) }}" onsubmit="return confirm('¿Eliminar este comentario?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-peligro btn-pequeno">🗑️ Eliminar</button>
                </form>
            </div>
            <p>"{{ $comentario->contenido }}"</p>
        </div>
    @empty
        <p style="color:var(--gris-oscuro);text-align:center;padding:40px">Aún no hay comentarios.</p>
    @endforelse
    <div class="paginacion">{{ $comentarios->links() }}</div>
</div>

@endsection
