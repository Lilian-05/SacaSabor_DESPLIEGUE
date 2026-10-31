@extends('layouts.app')

@section('titulo', 'Inicio')

@section('contenido')

{{-- HERO --}}
<section class="hero">
    <div class="contenedor">
        <div class="hero-grid">
            <div class="hero-texto">
                <span class="hero-badge">📍 Sacaba · Cochabamba</span>
                <h2>El verdadero <span>sabor</span> de Sacaba</h2>
                <p class="descripcion">Descubre las mejores chicharronerías de Sacaba. Busca y conoce la oferta gastronómica de nuestro municipio en un solo lugar.</p>

                <form action="{{ route('chicharronerias.index') }}" method="GET" class="hero-busqueda">
                    <span style="font-size:20px;margin-left:8px">🔎</span>
                    <input type="text" name="buscar" placeholder="¿Qué chicharronería buscas?" value="{{ request('buscar') }}">
                    <button type="submit" class="btn btn-primario">Buscar</button>
                </form>

                <div class="hero-estadisticas">
                    <div class="hero-estadistica">
                        <div class="numero">{{ $chicharronerias->count() }}</div>
                        <div class="label">Chicharronerías</div>
                    </div>
                    <div class="hero-estadistica">
                        <div class="numero">{{ $productos->count() }}+</div>
                        <div class="label">Productos</div>
                    </div>
                    <div class="hero-estadistica">
                        <div class="numero">⭐ 4.6</div>
                        <div class="label">Calificación</div>
                    </div>
                </div>
            </div>

            <div class="hero-imagen">
                <img src="{{ asset('img/hero-chicharron.jpg') }}" alt="Chicharrón de Sacaba">
            </div>
        </div>
    </div>
</section>

{{-- ALERTAS --}}
@if(session('success'))
    <div class="contenedor" style="margin-top:30px">
        <div class="alerta alerta-exito">{{ session('success') }}</div>
    </div>
@endif

{{-- CHICHARRONERÍAS DESTACADAS --}}
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <span class="etiqueta">Lo mejor de Sacaba</span>
            <h3>🏪 Chicharronerías destacadas</h3>
            <p>Los establecimientos favoritos de la gente</p>
        </div>
        <div class="grid-chicharronerias">
            @forelse($destacadas as $chicharroneria)
                @include('partials.tarjeta-chicharroneria', ['chi' => $chicharroneria])
            @empty
                <p>No hay chicharronerías destacadas aún.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- CATEGORÍAS --}}
<section class="seccion" id="categorias" style="background:rgba(255,255,255,0.6);border-radius:60px;margin:0 12px;backdrop-filter:blur(6px)">
    <div class="contenedor">
        <div class="seccion-titulo">
            <span class="etiqueta">Explora por categoría</span>
            <h3>🍽️ Nuestras categorías</h3>
            <p>Encuentra fácilmente lo que buscas</p>
        </div>
        <div class="grid-categorias">
            @foreach($categorias as $categoria)
                <a href="{{ route('categorias.show', $categoria) }}" class="tarjeta-categoria">
                    <div class="icono">{{ $categoria->icono }}</div>
                    <h4>{{ $categoria->nombre }}</h4>
                    <p>{{ $categoria->descripcion }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- PRODUCTOS DESTACADOS --}}
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <span class="etiqueta">Menú destacado</span>
            <h3>🍖 Productos destacados</h3>
            <p>Lo más pedido de las chicharronerías de Sacaba</p>
        </div>
        <div class="grid-productos">
            @foreach($productos as $producto)
                @include('partials.tarjeta-producto', ['producto' => $producto, 'conEnlace' => true])
            @endforeach
        </div>
    </div>
</section>

{{-- SOBRE SACABA --}}
<section class="seccion" style="background:linear-gradient(135deg, var(--oscuro), var(--oscuro-suave));color:#fff">
    <div class="contenedor" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:40px;align-items:center">
        <div>
            <span class="etiqueta" style="background:var(--gradiente);color:#fff;padding:5px 16px;border-radius:20px;font-size:13px;display:inline-block;margin-bottom:15px">🌽 Identidad gastronómica</span>
            <h3 style="font-size:32px;margin-bottom:15px;color:var(--dorado)">La gastronomía de Sacaba</h3>
            <p style="color:#d0d0d0;margin-bottom:20px">
                Sacaba, tierra de tradición y sabor, es conocida por su delicioso chicharrón de cerdo. SacaSabor nace para digitalizar y centralizar la información de las chicharronerías del municipio, ayudando a los establecimientos a tener presencia digital y facilitando a los clientes encontrar la mejor experiencia gastronómica.
            </p>
            <a href="{{ route('nosotros') }}" class="btn btn-dorado">Conoce más</a>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div style="background:rgba(255,255,255,0.08);border-radius:16px;padding:24px;text-align:center">
                <div style="font-size:40px">🌶️</div>
                <div style="font-size:24px;font-weight:800;color:var(--dorado)">+50</div>
                <div style="font-size:13px;color:#ccc">Recetas típicas</div>
            </div>
            <div style="background:rgba(255,255,255,0.08);border-radius:16px;padding:24px;text-align:center">
                <div style="font-size:40px">🏪</div>
                <div style="font-size:24px;font-weight:800;color:var(--dorado)">{{ $chicharronerias->count() }}</div>
                <div style="font-size:13px;color:#ccc">Establecimientos</div>
            </div>
            <div style="background:rgba(255,255,255,0.08);border-radius:16px;padding:24px;text-align:center">
                <div style="font-size:40px">⭐</div>
                <div style="font-size:24px;font-weight:800;color:var(--dorado)">4.6</div>
                <div style="font-size:13px;color:#ccc">Calificación</div>
            </div>
            <div style="background:rgba(255,255,255,0.08);border-radius:16px;padding:24px;text-align:center">
                <div style="font-size:40px">👨‍👩‍👧</div>
                <div style="font-size:24px;font-weight:800;color:var(--dorado)">100%</div>
                <div style="font-size:13px;color:#ccc">Sacabeño</div>
            </div>
        </div>
    </div>
</section>

{{-- MÁS VALORADAS --}}
<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <span class="etiqueta">Las favoritas</span>
            <h3>⭐ Más valoradas por los clientes</h3>
            <p>Las mejores calificaciones de la plataforma</p>
        </div>
        <div class="grid-chicharronerias">
            @foreach($masValoradas as $chi)
                @include('partials.tarjeta-chicharroneria', ['chi' => $chi])
            @endforeach
        </div>
    </div>
</section>

{{-- CÓMO FUNCIONA --}}
<section class="seccion" style="background:#fff">
    <div class="contenedor">
        <div class="seccion-titulo">
            <span class="etiqueta">Fácil de usar</span>
            <h3>🔄 ¿Cómo funciona?</h3>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:24px;text-align:center">
            <div style="padding:30px;border-radius:16px;background:var(--claro)">
                <div style="font-size:48px">🔎</div>
                <h4 style="margin:12px 0">1. Busca</h4>
                <p style="font-size:14px;color:var(--gris-oscuro)">Encuentra la chicharronería que buscas por nombre, ubicación o categoría.</p>
            </div>
            <div style="padding:30px;border-radius:16px;background:var(--claro)">
                <div style="font-size:48px">🍽️</div>
                <h4 style="margin:12px 0">2. Conoce</h4>
                <p style="font-size:14px;color:var(--gris-oscuro)">Revisa el menú, precios, disponibilidad, ubicación y fotografías.</p>
            </div>
            <div style="padding:30px;border-radius:16px;background:var(--claro)">
                <div style="font-size:48px">⭐</div>
                <h4 style="margin:12px 0">3. Opina</h4>
                <p style="font-size:14px;color:var(--gris-oscuro)">Lee comentarios, califica y comparte tu experiencia.</p>
            </div>
            <div style="padding:30px;border-radius:16px;background:var(--claro)">
                <div style="font-size:48px">🏪</div>
                <h4 style="margin:12px 0">4. Disfruta</h4>
                <p style="font-size:14px;color:var(--gris-oscuro)">Elige dónde consumir el mejor chicharrón de Sacaba.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA PROPIETARIO --}}
<section class="seccion">
    <div class="contenedor">
        <div style="background:var(--gradiente);border-radius:24px;padding:50px;text-align:center;color:#fff;box-shadow:var(--sombra-fuerte)">
            <h3 style="font-size:30px;margin-bottom:10px">¿Tienes una chicharronería?</h3>
            <p style="margin-bottom:25px;color:#ffe">Regístrate y administra tu información gastronómica en SacaSabor. ¡Dale presencia digital a tu negocio!</p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
                <a href="{{ route('register') }}" class="btn btn-blanco">Registrarme gratis</a>
                <a href="{{ route('contacto') }}" class="btn btn-secundario">Contactar</a>
            </div>
        </div>
    </div>
</section>

@endsection
