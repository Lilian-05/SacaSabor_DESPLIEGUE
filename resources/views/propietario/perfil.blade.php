@extends('layouts.panel')

@section('titulo', 'Mi perfil')
@section('panel-tipo', 'del Propietario')
@section('panel-ruta', 'Mi perfil')

@section('menu')
    <div class="nav-titulo">Principal</div>
    <a href="{{ route('propietario.dashboard') }}" class="{{ request()->routeIs('propietario.dashboard') ? 'activo' : '' }}"><span class="icono">🏠</span> Inicio</a>
    <div class="nav-titulo">Mi negocio</div>
    <a href="{{ route('propietario.chicharroneria.editar') }}" class="{{ request()->routeIs('propietario.chicharroneria.editar') ? 'activo' : '' }}"><span class="icono">🏪</span> Mi chicharronería</a>
    <a href="{{ route('propietario.ubicacion') }}" class="{{ request()->routeIs('propietario.ubicacion') ? 'activo' : '' }}"><span class="icono">📍</span> Ubicación</a>
    <a href="{{ route('propietario.productos.index') }}" class="{{ request()->routeIs('propietario.productos.*') ? 'activo' : '' }}"><span class="icono">🍽️</span> Menú / Productos</a>
    <div class="nav-titulo">Cuenta</div>
    <a href="{{ route('propietario.perfil') }}" class="activo"><span class="icono">👤</span> Mi perfil</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button style="display:flex;align-items:center;gap:12px;padding:12px 14px;width:100%;background:none;border:none;color:#aab;font-size:14px;cursor:pointer;border-radius:10px;font-family:var(--fuente)">
            <span class="icono">🚪</span> Cerrar sesión
        </button>
    </form>
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>👤 Mi perfil</h2>
    <p>Administra tus datos personales de acceso.</p>
</div>

<div class="tarjeta-panel" style="max-width:650px">
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px">
        <div class="avatar-mini" style="width:64px;height:64px;font-size:28px">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
        <div>
            <h3 style="font-size:20px">{{ auth()->user()->name }}</h3>
            <div style="color:var(--gris-oscuro)">{{ auth()->user()->email }}</div>
            <span class="etiqueta etiqueta-dorada" style="margin-top:6px">👩‍🍳 Propietario</span>
        </div>
    </div>

    <form method="POST" action="{{ route('propietario.perfil') }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="form-grupo">
            <label>Nombre completo</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" required>
        </div>
        <div class="form-grupo">
            <label>Correo electrónico</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" required>
        </div>
        <div class="form-grupo">
            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ auth()->user()->telefono }}">
        </div>
        <div class="form-grupo">
            <label>Fotografía de perfil</label>
            <input type="file" name="foto" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primario">💾 Guardar perfil</button>
    </form>
</div>

@endsection
