@extends('layouts.panel')

@section('titulo', 'Ubicación')
@section('panel-tipo', 'del Propietario')
@section('panel-ruta', 'Administrar ubicación')

@section('menu')
    <div class="nav-titulo">Principal</div>
    <a href="{{ route('propietario.dashboard') }}" class="{{ request()->routeIs('propietario.dashboard') ? 'activo' : '' }}"><span class="icono">🏠</span> Inicio</a>
    <div class="nav-titulo">Mi negocio</div>
    <a href="{{ route('propietario.chicharroneria.editar') }}" class="{{ request()->routeIs('propietario.chicharroneria.editar') ? 'activo' : '' }}"><span class="icono">🏪</span> Mi chicharronería</a>
    <a href="{{ route('propietario.ubicacion') }}" class="activo"><span class="icono">📍</span> Ubicación</a>
    <a href="{{ route('propietario.productos.index') }}" class="{{ request()->routeIs('propietario.productos.*') ? 'activo' : '' }}"><span class="icono">🍽️</span> Menú / Productos</a>
    <div class="nav-titulo">Cuenta</div>
    <a href="{{ route('propietario.perfil') }}" class="{{ request()->routeIs('propietario.perfil') ? 'activo' : '' }}"><span class="icono">👤</span> Mi perfil</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button style="display:flex;align-items:center;gap:12px;padding:12px 14px;width:100%;background:none;border:none;color:#aab;font-size:14px;cursor:pointer;border-radius:10px;font-family:var(--fuente)">
            <span class="icono">🚪</span> Cerrar sesión
        </button>
    </form>
@endsection

@section('contenido')

<div class="panel-encabezado">
    <h2>📍 Administra tu ubicación</h2>
    <p>Haz clic en el mapa para ubicar tu establecimiento y completa la dirección.</p>
</div>

<div class="tarjeta-panel" style="max-width:760px">
    <form method="POST" action="{{ route('propietario.ubicacion') }}">
        @csrf @method('PUT')
        <div class="form-grupo">
            <label>🏠 Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion', $chicharroneria->direccion) }}" placeholder="Ej: Av. Pando, esquina Cochabamba">
        </div>
        <div class="form-grupo">
            <label>🏘️ Zona</label>
            <input type="text" name="zona" value="{{ old('zona', $chicharroneria->zona) }}" placeholder="Ej: Centro, Villa Obrera, Huayllani">
        </div>
        <div class="form-grupo">
            <label>🗺️ Referencia</label>
            <input type="text" name="referencia" value="{{ old('referencia', $chicharroneria->referencia) }}" placeholder="Ej: A dos cuadras de la plaza">
        </div>

        <div class="form-grupo">
            <label>📍 Tu ubicación en el mapa <span class="form-ayuda">(haz clic o arrastra el pin)</span></label>
            <div class="mapa-tarjeta">
                <div class="mapa-head">
                    <div class="mapa-titulo">
                        <span class="mapa-icono">🗺️</span>
                        <div>
                            <strong>Ubica tu chicharronería</strong>
                            <span>Arrastra el pin o haz clic en cualquier punto</span>
                        </div>
                    </div>
                    <button type="button" id="btnMiUbicacion" class="mapa-btn-geo">📡 Usar mi ubicación</button>
                </div>
                <div id="mapaPropietario" style="height:420px;width:100%;z-index:0"></div>
                <div class="mapa-pie">
                    <div class="mapa-coords">
                        <span id="coordTexto">Selecciona un punto en el mapa para fijar tu ubicación.</span>
                    </div>
                    <span class="mapa-badge">📍 Sacaba</span>
                </div>
            </div>
            <p class="form-ayuda" style="margin-top:8px">Haz clic o arrastra el pin rosa para ubicar tu establecimiento con precisión.</p>
        </div>

        @if($chicharroneria->latitud && $chicharroneria->longitud)
            <div class="coordenadas-guardadas">
                <strong>📍 Ubicación guardada</strong> — Latitud: <span id="latVista">{{ $chicharroneria->latitud }}</span> · Longitud: <span id="lngVista">{{ $chicharroneria->longitud }}</span>
            </div>
        @endif

        <div class="form-grupo">
            <label>Coordenadas</label>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                <input type="text" name="latitud" id="latitud" value="{{ $chicharroneria->latitud }}" placeholder="Latitud" readonly>
                <input type="text" name="longitud" id="longitud" value="{{ $chicharroneria->longitud }}" placeholder="Longitud" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-primario">💾 Guardar ubicación</button>
    </form>
</div>

@endsection

@push('scripts')
<script>
(function() {
    if (typeof L === 'undefined' || !document.getElementById('mapaPropietario')) return;
    var latInicial = parseFloat(document.getElementById('latitud').value);
    var lngInicial = parseFloat(document.getElementById('longitud').value);
    if (isNaN(latInicial) || isNaN(lngInicial)) { latInicial = -17.3987; lngInicial = -66.0423; } // Sacaba centro
    var mapa = L.map('mapaPropietario').setView([latInicial, lngInicial], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(mapa);

    var iconoTunel = L.divIcon({
        className: 'pin-sacasabor',
        html: '<div class="pin-circulo">📍</div>',
        iconSize: [40, 40],
        iconAnchor: [20, 38]
    });
    var pin = L.marker([latInicial, lngInicial], { draggable: true, icon: iconoTunel }).addTo(mapa);

    var latInput = document.getElementById('latitud');
    var lngInput = document.getElementById('longitud');
    var latVista = document.getElementById('latVista');
    var lngVista = document.getElementById('lngVista');
    var coordTexto = document.getElementById('coordTexto');

    function actualizar(lat, lng) {
        latInput.value = lat.toFixed(6);
        lngInput.value = lng.toFixed(6);
        if (latVista) latVista.textContent = lat.toFixed(6);
        if (lngVista) lngVista.textContent = lng.toFixed(6);
        if (coordTexto) coordTexto.textContent = '📍 ' + lat.toFixed(5) + ', ' + lng.toFixed(5) + ' — ubicación fijada';
    }

    mapa.on('click', function(e) {
        pin.setLatLng(e.latlng);
        actualizar(e.latlng.lat, e.latlng.lng);
    });
    pin.on('dragend', function() {
        var c = pin.getLatLng();
        actualizar(c.lat, c.lng);
    });

    var btnGeo = document.getElementById('btnMiUbicacion');
    if (btnGeo && navigator.geolocation) {
        btnGeo.addEventListener('click', function() {
            btnGeo.textContent = '⏳ Localizando...';
            navigator.geolocation.getCurrentPosition(function(pos) {
                var lat = pos.coords.latitude;
                var lng = pos.coords.longitude;
                mapa.setView([lat, lng], 16);
                pin.setLatLng([lat, lng]);
                actualizar(lat, lng);
                btnGeo.textContent = '✓ Ubicación detectada';
                setTimeout(function() { btnGeo.textContent = '📡 Usar mi ubicación'; }, 3000);
            }, function() {
                btnGeo.textContent = '📡 Usar mi ubicación';
                alert('No se pudo obtener tu ubicación. Permite el acceso a la ubicación o haz clic en el mapa.');
            });
        });
    } else if (btnGeo) {
        btnGeo.style.display = 'none';
    }

    actualizar(latInicial, lngInicial);
})();
</script>
@endpush
