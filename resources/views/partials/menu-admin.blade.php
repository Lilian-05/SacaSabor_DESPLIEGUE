    <div class="nav-titulo">General</div>
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'activo' : '' }}"><span class="icono">🏠</span> Inicio</a>
    <a href="{{ route('admin.estadisticas') }}" class="{{ request()->routeIs('admin.estadisticas') ? 'activo' : '' }}"><span class="icono">📊</span> Estadísticas</a>
    <div class="nav-titulo">Gestión</div>
    <a href="{{ route('admin.usuarios') }}" class="{{ request()->routeIs('admin.usuarios') ? 'activo' : '' }}"><span class="icono">👥</span> Usuarios</a>
    <a href="{{ route('admin.chicharronerias') }}" class="{{ request()->routeIs('admin.chicharronerias') ? 'activo' : '' }}"><span class="icono">🏪</span> Chicharronerías</a>
    <a href="{{ route('admin.productos') }}" class="{{ request()->routeIs('admin.productos') ? 'activo' : '' }}"><span class="icono">🍽️</span> Productos</a>
    <a href="{{ route('admin.categorias') }}" class="{{ request()->routeIs('admin.categorias') ? 'activo' : '' }}"><span class="icono">📂</span> Categorías</a>
    <div class="nav-titulo">Contenido</div>
    <a href="{{ route('admin.calificaciones') }}" class="{{ request()->routeIs('admin.calificaciones') ? 'activo' : '' }}"><span class="icono">⭐</span> Calificaciones</a>
    <a href="{{ route('admin.comentarios') }}" class="{{ request()->routeIs('admin.comentarios') ? 'activo' : '' }}"><span class="icono">💬</span> Opiniones</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button style="display:flex;align-items:center;gap:12px;padding:12px 14px;width:100%;background:none;border:none;color:#aab;font-size:14px;cursor:pointer;border-radius:10px;font-family:var(--fuente);margin-top:10px">
            <span class="icono">🚪</span> Cerrar sesión
        </button>
    </form>
