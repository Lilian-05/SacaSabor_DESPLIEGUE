<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'SacaSabor') · SacaSabor Sacaba</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon-sacasabor.png') }}">
    @stack('styles')
</head>
<body>
    <header class="header">
        <div class="header-inner">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('img/logo-sacasabor.png') }}" alt="Logo SacaSabor" class="logo-img">
                <div class="logo-texto">
                    <h1>SacaSabor</h1>
                    <span>Sacaba · Bolivia</span>
                </div>
            </a>

            <button class="menu-toggle" onclick="document.getElementById('menuNav').classList.toggle('abierto')">☰</button>

            <nav class="nav" id="menuNav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'activo' : '' }}">Inicio</a>
                <a href="{{ route('chicharronerias.index') }}" class="{{ request()->routeIs('chicharronerias.index') ? 'activo' : '' }}">Chicharronerías</a>
                <a href="{{ route('home') }}#categorias" class="{{ request()->routeIs('categorias.show') ? 'activo' : '' }}">Categorías</a>
                <a href="{{ route('nosotros') }}" class="{{ request()->routeIs('nosotros') ? 'activo' : '' }}">Nosotros</a>
                <a href="{{ route('contacto') }}" class="{{ request()->routeIs('contacto') ? 'activo' : '' }}">Contacto</a>
            </nav>

            <div class="header-acciones">
                @auth
                    @if(auth()->user()->esAdministrador())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-dorado btn-pequeno"><span class="btn-texto">Panel Admin</span></a>
                    @elseif(auth()->user()->esPropietario())
                        <a href="{{ route('propietario.dashboard') }}" class="btn btn-dorado btn-pequeno"><span class="btn-texto">Mi Panel</span></a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button class="btn btn-secundario btn-pequeno">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secundario btn-pequeno">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-primario btn-pequeno">Registrarse</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        @yield('contenido')
    </main>

    <footer class="footer">
        <div class="contenedor footer-contenido">
            <div>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:15px">
                    <img src="{{ asset('img/logo-sacasabor.png') }}" alt="Logo SacaSabor" style="width:72px;height:72px;object-fit:contain">
                    <div class="logo-texto">
                        <h1 style="color:var(--dorado);font-size:24px">SacaSabor</h1>
                        <span style="color:#aaa">Sacaba · Bolivia</span>
                    </div>
                </div>
                <p>Plataforma para la gestión y difusión de la oferta gastronómica de las chicharronerías del municipio de Sacaba.</p>
            </div>
            <div>
                <h4>Enlaces</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('chicharronerias.index') }}">Chicharronerías</a></li>
                    <li><a href="{{ route('nosotros') }}">Nosotros</a></li>
                    <li><a href="{{ route('contacto') }}">Contacto</a></li>
                </ul>
            </div>
            <div>
                <h4>Para negocios</h4>
                <ul>
                    <li><a href="{{ route('register') }}">Registrar mi chicharronería</a></li>
                    <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                </ul>
            </div>
            <div>
                <h4>Contacto</h4>
                <p>📍 Sacaba, Cochabamba, Bolivia</p>
                <p>📞 4 4 XXXXXX</p>
                <p>✉️ info@sacasabor.com</p>
            </div>
        </div>
        <div class="footer-fondo">
            <div class="contenedor">© {{ date('Y') }} SacaSabor · Proyecto de grado · Sacaba, Bolivia 🇧🇴</div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var links = document.querySelectorAll('.nav a');
            for (var i = 0; i < links.length; i++) {
                links[i].addEventListener('click', function() {
                    document.getElementById('menuNav').classList.remove('abierto');
                });
            }
        });
    </script>
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    @stack('scripts')
</body>
</html>
