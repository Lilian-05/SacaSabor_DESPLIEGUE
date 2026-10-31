<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo') · SacaSabor Panel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon-sacasabor.png') }}">
    @stack('styles')
</head>
<body>
    <aside class="panel-lateral" id="panelLateral">
        <div class="panel-lateral-head">
            <img src="{{ asset('img/logo-sacasabor.png') }}" alt="Logo SacaSabor" class="logo-img">
            <div class="logo-texto">
                <h1 style="font-size:20px;color:var(--dorado)">SacaSabor</h1>
                <span>Panel @yield('panel-tipo', '')</span>
            </div>
        </div>
        <nav class="panel-nav">
            @yield('menu')
        </nav>
        <div class="panel-lateral-foot">
            <div class="panel-usuario">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div style="flex:1;min-width:0">
                    <div style="font-weight:700;font-size:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ auth()->user()->name }}</div>
                    <div style="font-size:12px;color:#aaa;text-transform:capitalize">{{ auth()->user()->rol }}</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="panel-topbar">
        <button class="menu-panel" onclick="document.getElementById('panelLateral').classList.toggle('abierto')">☰</button>
        <span style="font-size:14px;color:var(--gris-oscuro);margin-right:auto;padding-left:10px">@yield('panel-ruta', 'Panel de administración')</span>
        <a href="{{ route('home') }}" class="btn btn-outline btn-pequeno">🌶️ Ver sitio</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-peligro btn-pequeno">Salir</button>
        </form>
    </div>

    <main class="panel-contenido">
        @if(session('success'))
            <div class="alerta alerta-exito">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alerta alerta-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alerta alerta-error">
                @foreach($errors->all() as $error) {{ $error }} @endforeach
            </div>
        @endif

        @yield('contenido')
    </main>

    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    @stack('scripts')
</body>
</html>
