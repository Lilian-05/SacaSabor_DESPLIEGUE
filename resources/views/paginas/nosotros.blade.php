@extends('layouts.app')

@section('titulo', 'Nosotros')

@section('contenido')

<section class="hero" style="padding:60px 0 70px">
    <div class="contenedor" style="text-align:center">
        <h2 style="font-size:38px;margin-bottom:10px">🌽 Sobre SacaSabor</h2>
        <p style="color:#e0e0e0">Nuestra misión: digitalizar la gastronomía de Sacaba</p>
    </div>
</section>

<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <span class="etiqueta">Nuestra historia</span>
            <h3>¿Qué es SacaSabor?</h3>
        </div>
        <div class="card-info" style="max-width:800px;margin:0 auto">
            <p style="margin-bottom:15px;font-size:16px">
                <strong>SacaSabor</strong> es una plataforma web creada como proyecto de grado, dedicada a la <strong>gestión y difusión de la oferta gastronómica de las chicharronerías del municipio de Sacaba</strong>, Cochabamba, Bolivia.
            </p>
            <p style="margin-bottom:15px;font-size:16px">
                Nuestra misión es digitalizar y centralizar la información de las chicharronerías de Sacaba para facilitar su gestión y mejorar la experiencia de consulta de los clientes. Conectamos a los propietarios de establecimientos con los amantes del buen chicharrón.
            </p>
            <p style="font-size:16px">
                Actualmente contamos con <strong>{{ $total }} chicharronerías registradas</strong> que comparten su menú, precios, disponibilidad, ubicación, calificaciones y comentarios.
            </p>
        </div>
    </div>
</section>

<section class="seccion" style="background:#fff">
    <div class="contenedor">
        <div class="seccion-titulo">
            <span class="etiqueta">¿Qué ofrecemos?</span>
            <h3>Nuestros propósitos</h3>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:24px">
            <div class="tarjeta-panel" style="text-align:center;margin:0">
                <div style="font-size:46px">🏪</div>
                <h4 style="margin:12px 0">Presencia digital</h4>
                <p style="font-size:14px;color:var(--gris-oscuro)">Las chicharronerías pueden mostrar y administrar su información en un solo lugar.</p>
            </div>
            <div class="tarjeta-panel" style="text-align:center;margin:0">
                <div style="font-size:46px">🔎</div>
                <h4 style="margin:12px 0">Fácil búsqueda</h4>
                <p style="font-size:14px;color:var(--gris-oscuro)">Los clientes encuentran rápido lo que buscan: menú, precios y disponibilidad.</p>
            </div>
            <div class="tarjeta-panel" style="text-align:center;margin:0">
                <div style="font-size:46px">⭐</div>
                <h4 style="margin:12px 0">Opiniones reales</h4>
                <p style="font-size:14px;color:var(--gris-oscuro)">Calificaciones y comentarios que ayudan a elegir mejor.</p>
            </div>
            <div class="tarjeta-panel" style="text-align:center;margin:0">
                <div style="font-size:46px">📍</div>
                <h4 style="margin:12px 0">Ubicación clara</h4>
                <p style="font-size:14px;color:var(--gris-oscuro)">Cada establecimiento muestra su ubicación y referencia en Sacaba.</p>
            </div>
        </div>
    </div>
</section>

<section class="seccion">
    <div class="contenedor">
        <div class="seccion-titulo">
            <span class="etiqueta">Ciudad</span>
            <h3>🇧🇴 Sacaba · Cochabamba</h3>
            <p>Una tierra llena de tradición y sabor</p>
        </div>
        <div class="card-info" style="max-width:800px;margin:0 auto">
            <p style="font-size:16px;text-align:center">
                Sacaba es un municipio del departamento de Cochabamba, reconocido por su identidad gastronómica, especialmente por su delicioso <strong>chicharrón de cerdo</strong>. A través de SacaSabor queremos poner en valor y difundir esta riqueza culinaria, apoyando a los pequeños y medianos establecimientos locales.
            </p>
        </div>
    </div>
</section>

@endsection
