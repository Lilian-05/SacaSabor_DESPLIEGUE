<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar ubicación · SacaSabor</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="background:#f45fd4;padding:20px">
    <div style="max-width:600px;margin:auto">
        <div style="background:#fff;border-radius:16px;padding:20px;margin-bottom:15px;box-shadow:var(--sombra)">
            <h3 style="margin-bottom:5px">📍 Selecciona tu ubicación</h3>
            <p style="font-size:14px;color:var(--gris-oscuro);margin-bottom:15px">
                Mueve el pin sobre el mapa de Sacaba o escribe tus coordenadas, luego haz clic en "Guardar ubicación".
            </p>

            <div class="form-grupo">
                <label>Latitud</label>
                <input type="text" id="lat" value="-17.4032">
            </div>
            <div class="form-grupo">
                <label>Longitud</label>
                <input type="text" id="lng" value="-66.0390">
            </div>

            <div style="text-align:center;margin-bottom:10px">
                <button class="btn btn-dorado btn-pequeno" onclick="guardarUbicacion()">✅ Guardar ubicación</button>
            </div>
            <p style="font-size:12px;color:var(--gris-oscuro);text-align:center">Los valores de latitud y longitud representan tu establecimiento en Sacaba.</p>
        </div>

        <div style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:var(--sombra)">
            <svg id="mapaSvg" viewBox="0 0 600 400" width="100%" style="cursor:crosshair">
                <defs>
                    <pattern id="cuadricula" width="40" height="40" patternUnits="userSpaceOnUse">
                        <rect width="40" height="40" fill="#f7f9fb"/>
                        <rect width="40" height="40" fill="none" stroke="#e0e5ea"/>
                    </pattern>
                </defs>
                <rect width="600" height="400" fill="url(#cuadricula)"/>
                <path d="M50,90 L200,60 L320,110 L450,80 L540,150 L480,300 L350,340 L200,310 L80,240 Z" fill="#d3dbe3" stroke="#9fb0c0" stroke-width="2"/>
                <text x="300" y="210" text-anchor="middle" fill="#5a6a79" font-size="22" font-weight="bold">SACABA</text>
                <text x="300" y="235" text-anchor="middle" fill="#7a8a99" font-size="13">Cochabamba · Bolivia</text>
                <circle cx="300" cy="200" r="10" fill="#e63946" stroke="#fff" stroke-width="2"/>
                <circle id="pinMapa" cx="300" cy="200" r="6" fill="#e63946" stroke="#fff" stroke-width="2"/>
            </svg>
        </div>
    </div>

    <script>
        var centro = { x: 300, y: 200 };
        var rangoLat = 0.05;   // aproximado para el área de Sacaba
        var rangoLng = 0.06;
        var baseLat = -17.40;
        var baseLng = -66.04;

        function latLngAPixel(lat, lng) {
            var x = centro.x + (lng - baseLng) / rangoLng * 300;
            var y = centro.y - (lat - baseLat) / rangoLat * 200;
            return { x: x, y: y };
        }

        function pixelALatLng(x, y) {
            var lat = baseLat - (centro.y - y) / 200 * rangoLat;
            var lng = baseLng + (x - centro.x) / 300 * rangoLng;
            return { lat: lat, lng: lng };
        }

        var pin = document.getElementById('pinMapa');
        var svg = document.getElementById('mapaSvg');
        var latInput = document.getElementById('lat');
        var lngInput = document.getElementById('lng');

        function moverPinALatLng() {
            var lat = parseFloat(latInput.value);
            var lng = parseFloat(lngInput.value);
            var p = latLngAPixel(lat, lng);
            pin.setAttribute('cx', p.x);
            pin.setAttribute('cy', p.y);
        }

        svg.addEventListener('click', function(e) {
            var rect = svg.getBoundingClientRect();
            var x = (e.clientX - rect.left) * (600 / rect.width);
            var y = (e.clientY - rect.top) * (400 / rect.height);
            pin.setAttribute('cx', x);
            pin.setAttribute('cy', y);
            var coord = pixelALatLng(x, y);
            latInput.value = coord.lat.toFixed(6);
            lngInput.value = coord.lng.toFixed(6);
        });

        latInput.addEventListener('change', moverPinALatLng);
        lngInput.addEventListener('change', moverPinALatLng);

        function guardarUbicacion() {
            var lat = parseFloat(latInput.value);
            var lng = parseFloat(lngInput.value);
            if (window.opener) {
                window.opener.postMessage({ tipo: 'ubicacion', latitud: lat, longitud: lng }, '*');
            }
            alert('📍 Ubicación seleccionada: ' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '\nPuedes cerrar esta ventana.');
            window.close();
        }

        moverPinALatLng();
    </script>
</body>
</html>
