@extends('layouts.app')

@section('titulo', $chicharroneria->nombre)

@section('contenido')

@php $colorCh = $chicharroneria->hexColor(); @endphp
<style>
    :root { --rojo: {{ $colorCh }}; --rojo-oscuro: {{ $colorCh }}; }
    .tarjeta-producto .precio { color: {{ $colorCh }}; }
    .categoria-menu-head .etiqueta { background: linear-gradient(135deg, {{ $colorCh }}, #ff8c42); }
    .pestana.activa { color: {{ $colorCh }}; border-bottom-color: {{ $colorCh }}; }
    .perfil-calificacion { background: {{ $colorCh }}; }
</style>

<div class="perfil-portada">
    <img src="{{ $chicharroneria->foto_portada ? asset('storage/' . $chicharroneria->foto_portada) : asset('storage/imagenes/chicharroneria-1.svg') }}" alt="{{ $chicharroneria->nombre }}">
</div>

<section class="seccion" style="padding-top:0">
    <div class="contenedor">

        @if(session('success'))
            <div class="alerta alerta-exito" style="margin-top:20px">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alerta alerta-error" style="margin-top:20px">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alerta alerta-error" style="margin-top:20px">
                @foreach($errors->all() as $error) {{ $error }} @endforeach
            </div>
        @endif

        <div class="perfil-header-info">
            <div class="perfil-top">
                <div class="perfil-avatar">
                    <img src="{{ $chicharroneria->foto ? asset('storage/' . $chicharroneria->foto) : asset('storage/imagenes/chicharroneria-1.svg') }}" alt="{{ $chicharroneria->nombre }}">
                </div>
                <div class="perfil-datos">
                    <h2>{{ $chicharroneria->nombre }}</h2>
                    @if($chicharroneria->descripcion)
                        <p style="color:var(--gris-oscuro);margin-top:8px">{{ $chicharroneria->descripcion }}</p>
                    @endif
                    <div style="margin-top:12px">
                        @if($chicharroneria->direccion)
                            <div class="dato">📍 {{ $chicharroneria->direccion }}</div>
                        @endif
                        @if($chicharroneria->zona)
                            <div class="dato">🏘️ {{ $chicharroneria->zona }}</div>
                        @endif
                        @if($chicharroneria->telefono)
                            <div class="dato">📞 {{ $chicharroneria->telefono }}</div>
                        @endif
                    </div>
                </div>
                <div class="perfil-calificacion">
                    <div class="promedio">{{ $chicharroneria->calificacionPromedio() }}</div>
                    <div class="estrellas">{!! str_repeat('⭐', round($chicharroneria->calificacionPromedio())) !!}</div>
                    <div style="font-size:13px;color:#bbb">{{ $chicharroneria->calificaciones->count() }} calificaciones</div>
                </div>
            </div>
        </div>

        {{-- Pestañas --}}
        <div class="pestanas">
            <button class="pestana activa" onclick="cambiarPestana('menu', this)">🍽️ Menú</button>
            <button class="pestana" onclick="cambiarPestana('info', this)">📍 Información</button>
            <button class="pestana" onclick="cambiarPestana('opiniones', this)">💬 Opiniones</button>
        </div>

        {{-- MENÚ --}}
        <div class="panel-pestana activa" id="panel-menu">
            @php
                $porCategoria = $chicharroneria->productos->groupBy(fn($p) => $p->categoria_id);
                $categorias = \App\Models\Categoria::whereIn('id', $porCategoria->keys())->orderBy('id')->get();
                $tienePromo = $categorias->contains('nombre', 'Promociones');
                $categoriasNormales = $categorias->reject(fn($c) => $c->nombre === 'Promociones');
            @endphp

            @php
                $promoCat = $categorias->firstWhere('nombre', 'Promociones');
            @endphp
            @if($promoCat && $porCategoria->has($promoCat->id))
                <div class="categoria-menu promo">
                    <div class="categoria-menu-head promo-head">
                        <h3>🔥 Promociones</h3>
                        <p>Ofertas especiales y combos imperdibles</p>
                    </div>
                    <div class="grid-productos">
                        @foreach($porCategoria[$promoCat->id] as $producto)
                            @include('partials.tarjeta-producto', ['producto' => $producto])
                        @endforeach
                    </div>
                </div>
            @endif

            @foreach($categoriasNormales as $categoria)
                @if(!$porCategoria->has($categoria->id)) @continue @endif
                <div class="categoria-menu">
                    <div class="categoria-menu-head">
                        <h3>{{ $categoria->icono }} {{ $categoria->nombre }}</h3>
                        <p>{{ $categoria->descripcion }}</p>
                    </div>
                    <div class="grid-productos">
                        @foreach($porCategoria[$categoria->id] as $producto)
                            @include('partials.tarjeta-producto', ['producto' => $producto])
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if(!$chicharroneria->productos->count())
                <div style="text-align:center;padding:50px;background:#fff;border-radius:16px;box-shadow:var(--sombra)">
                    <div style="font-size:50px">🍽️</div>
                    <p style="color:var(--gris-oscuro)">Este establecimiento aún no registra productos.</p>
                </div>
            @endif
        </div>

        {{-- INFORMACIÓN --}}
        <div class="panel-pestana" id="panel-info">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px">
                <div class="card-info">
                    <h3>📍 Ubicación</h3>
                    <ul class="lista-info">
                        @if($chicharroneria->direccion)
                            <li><span class="icono-info">🏠</span><div><span class="etiqueta-info">Dirección</span><span class="valor-info">{{ $chicharroneria->direccion }}</span></div></li>
                        @endif
                        @if($chicharroneria->zona)
                            <li><span class="icono-info">🏘️</span><div><span class="etiqueta-info">Zona</span><span class="valor-info">{{ $chicharroneria->zona }}</span></div></li>
                        @endif
                        @if($chicharroneria->referencia)
                            <li><span class="icono-info">🗺️</span><div><span class="etiqueta-info">Referencia</span><span class="valor-info">{{ $chicharroneria->referencia }}</span></div></li>
                        @endif
                    </ul>
                    @if($chicharroneria->latitud && $chicharroneria->longitud)
                        <div class="mapa-publico">
                            <div class="mapa-tarjeta">
                                <div class="mapa-head">
                                    <div class="mapa-titulo">
                                        <span class="mapa-icono">🗺️</span>
                                        <div>
                                            <strong>Mapa de ubicación</strong>
                                            <span>{{ $chicharroneria->zona ?: 'Sacaba' }} · Cochabamba</span>
                                        </div>
                                    </div>
                                    <span class="mapa-badge">📍 Live</span>
                                </div>
                                <div id="mapaPublico" style="height:360px;width:100%;position:relative;z-index:0"></div>
                                <div class="mapa-pie">
                                    <div class="mapa-coords">
                                        <span>Lat {{ $chicharroneria->latitud }}</span>
                                        <span>Lng {{ $chicharroneria->longitud }}</span>
                                    </div>
                                    <a class="btn btn-primario btn-pequeno" target="_blank" href="https://www.openstreetmap.org/?mlat={{ $chicharroneria->latitud }}&mlon={{ $chicharroneria->longitud }}#map=17/{{ $chicharroneria->latitud }}/{{ $chicharroneria->longitud }}">Abrir en mapa ↗</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="mapa-placeholder" style="margin-top:18px">
                            <div class="pin">📍</div>
                            <div>Sacaba · Cochabamba · Bolivia</div>
                        </div>
                    @endif
                </div>
                <div class="card-info">
                    <h3>📞 Contacto</h3>
                    <ul class="lista-info">
                        @if($chicharroneria->telefono)
                            <li><span class="icono-info">📞</span><div><span class="etiqueta-info">Teléfono</span><span class="valor-info">{{ $chicharroneria->telefono }}</span></div></li>
                        @else
                            <li><span class="icono-info">📞</span><div><span class="valor-info">No registrado</span></div></li>
                        @endif
                        <li><span class="icono-info">🍽️</span><div><span class="etiqueta-info">Productos</span><span class="valor-info">{{ $chicharroneria->cantidadProductos() }} en total</span></div></li>
                        <li><span class="icono-info">🟢</span><div><span class="etiqueta-info">Disponibles</span><span class="valor-info">{{ $chicharroneria->productosDisponibles() }}</span></div></li>
                        <li><span class="icono-info">🔴</span><div><span class="etiqueta-info">Agotados</span><span class="valor-info">{{ $chicharroneria->productosAgotados() }}</span></div></li>
                        <li><span class="icono-info">⭐</span><div><span class="etiqueta-info">Calificación</span><span class="valor-info">{{ $chicharroneria->calificacionPromedio() }}/5</span></div></li>
                        <li><span class="icono-info">📍</span><div><span class="etiqueta-info">Municipio</span><span class="valor-info">Sacaba, Cochabamba, Bolivia</span></div></li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- OPINIONES --}}
        <div class="panel-pestana" id="panel-opiniones">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px">
                <div>
                    <div class="card-info">
                        <h3>💬 Comentarios ({{ $chicharroneria->comentarios->count() }})</h3>
                        @if($chicharroneria->comentarios->count())
                            @foreach($chicharroneria->comentarios as $comentario)
                                <div class="tarjeta-comentario">
                                    <div class="autor">
                                        <div class="avatar-mini">{{ strtoupper(substr($comentario->usuario->name, 0, 1)) }}</div>
                                        <div>
                                            <div class="nombre">{{ $comentario->usuario->name }}</div>
                                            <div class="fecha">{{ $comentario->created_at->diffForHumans() }}</div>
                                        </div>
                                        @auth
                                            @if(auth()->id() === $comentario->usuario_id)
                                                <form method="POST" action="{{ route('opiniones.destruir', $comentario) }}" style="margin-left:auto">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-pequeno btn-peligro" onclick="return confirm('¿Eliminar este comentario?')">🗑️</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                    <div class="contenido">"{{ $comentario->contenido }}"</div>
                                </div>
                            @endforeach
                        @else
                            <p style="color:var(--gris-oscuro)">Aún no hay comentarios. ¡Sé el primero en opinar!</p>
                        @endif
                    </div>
                </div>
                <div>
                    @auth
                        @php $miCal = $chicharroneria->calificaciones->firstWhere('usuario_id', auth()->id()); @endphp
                        <div class="formulario-opinion">
                            <h3 style="margin-bottom:8px">{{ $miCal ? '⭐ Actualizar tu opinión' : '⭐ Deja tu opinión' }}</h3>
                            <p style="font-size:13px;color:var(--gris-oscuro);margin-bottom:15px">Tu valoración ayuda a otros clientes de Sacaba.</p>
                            <form method="POST" action="{{ route('opiniones.store', $chicharroneria) }}">
                                @csrf
                                <div class="form-grupo">
                                    <label>Tu calificación</label>
                                    <div class="seleccion-estrellas">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" class="estrella {{ $miCal && $miCal->puntaje >= $i ? 'activa' : '' }}" data-valor="{{ $i }}" onclick="seleccionarEstrellas({{ $i }})">★</button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="puntaje" id="puntaje" value="{{ $miCal->puntaje ?? 5 }}">
                                </div>
                                <div class="form-grupo">
                                    <label>Tu comentario</label>
                                    <textarea name="contenido" placeholder="Ej: Muy buena atención y excelente chicharrón.">{{ $chicharroneria->comentarios->firstWhere('usuario_id', auth()->id())->contenido ?? '' }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primario btn-bloque">Enviar opinión</button>
                            </form>
                        </div>
                    @else
                        <div class="card-info" style="text-align:center">
                            <div style="font-size:50px">⭐</div>
                            <h3>¿Quieres opinar?</h3>
                            <p style="color:var(--gris-oscuro);margin:10px 0 20px">Inicia sesión para calificar y comentar esta chicharronería.</p>
                            <a href="{{ route('login') }}" class="btn btn-primario" style="margin-bottom:8px">Iniciar sesión</a>
                            <br>
                            <a href="{{ route('register') }}" class="btn btn-outline">Crear cuenta</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
    function cambiarPestana(nombre, elemento) {
        var pestanas = document.querySelectorAll('.pestana');
        var paneles = document.querySelectorAll('.panel-pestana');
        pestanas.forEach(function(p) { p.classList.remove('activa'); });
        paneles.forEach(function(pan) { pan.classList.remove('activa'); });
        elemento.classList.add('activa');
        document.getElementById('panel-' + nombre).classList.add('activa');
        if (nombre === 'info') {
            iniciarMapaPublico();
            if (mapaPublico) {
                setTimeout(function() { mapaPublico.invalidateSize(); }, 120);
            }
        }
    }
function seleccionarEstrellas(valor) {
        var estrellas = document.querySelectorAll('.seleccion-estrellas .estrella');
        estrellas.forEach(function(e) {
            e.classList.toggle('activa', parseInt(e.dataset.valor) <= valor);
        });
        document.getElementById('puntaje').value = valor;
    }

    var mapaPublico = null;
    function iniciarMapaPublico() {
        if (mapaPublico || typeof L === 'undefined') return;
        var contenedor = document.getElementById('mapaPublico');
        if (!contenedor) return;
        var lat = {{ $chicharroneria->latitud ?? 'null' }};
        var lng = {{ $chicharroneria->longitud ?? 'null' }};
        if (lat === null || lng === null) return;
        mapaPublico = L.map(contenedor, { scrollWheelZoom: false }).setView([lat, lng], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(mapaPublico);
        var iconoPin = L.icon({
            iconUrl: '{{ asset('vendor/leaflet/images/marker-icon.png') }}',
            iconRetinaUrl: '{{ asset('vendor/leaflet/images/marker-icon-2x.png') }}',
            shadowUrl: '{{ asset('vendor/leaflet/images/marker-shadow.png') }}',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
        L.marker([lat, lng], { icon: iconoPin }).addTo(mapaPublico)
            .bindPopup('<b>{{ $chicharroneria->nombre }}</b><br>{{ $chicharroneria->direccion ?? '' }}')
            .openPopup();
    }
    document.addEventListener('DOMContentLoaded', function() {
        iniciarMapaPublico();
        setTimeout(function() { if (mapaPublico) mapaPublico.invalidateSize(); }, 300);
    });
</script>
@endpush
