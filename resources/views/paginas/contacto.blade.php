@extends('layouts.app')

@section('titulo', 'Contacto')

@section('contenido')

<section class="hero" style="padding:60px 0 70px">
    <div class="contenedor" style="text-align:center">
        <h2 style="font-size:38px;margin-bottom:10px">📞 Contacto</h2>
        <p style="color:#e0e0e0">¿Tienes dudas o quieres registrar tu chicharronería?</p>
    </div>
</section>

<section class="seccion">
    <div class="contenedor">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px">
            <div>
                <div class="tarjeta-panel" style="margin:0">
                    <h3 style="margin-bottom:18px">💌 Escríbenos</h3>
                    @if(session('success'))
                        <div class="alerta alerta-exito">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('contacto') }}">
                        @csrf
                        <div class="form-grupo">
                            <label>Nombre</label>
                            <input type="text" name="nombre" required placeholder="Tu nombre">
                        </div>
                        <div class="form-grupo">
                            <label>Correo</label>
                            <input type="email" name="email" required placeholder="tucorreo@ejemplo.com">
                        </div>
                        <div class="form-grupo">
                            <label>Mensaje</label>
                            <textarea name="mensaje" required placeholder="Cuéntanos en qué podemos ayudarte..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primario btn-bloque">Enviar mensaje</button>
                    </form>
                </div>
            </div>
            <div>
                <div class="tarjeta-panel" style="margin:0">
                    <h3 style="margin-bottom:18px">📍 Información de contacto</h3>
                    <ul class="lista-info">
                        <li><span class="icono-info">📍</span><div><span class="etiqueta-info">Ubicación</span><span class="valor-info">Sacaba, Cochabamba, Bolivia</span></div></li>
                        <li><span class="icono-info">📞</span><div><span class="etiqueta-info">Teléfono</span><span class="valor-info">4 4 XXXXXX</span></div></li>
                        <li><span class="icono-info">📧</span><div><span class="etiqueta-info">Correo</span><span class="valor-info">info@sacasabor.com</span></div></li>
                        <li><span class="icono-info">🕐</span><div><span class="etiqueta-info">Horario</span><span class="valor-info">Lun a Dom · 8:00 - 20:00</span></div></li>
                    </ul>
                </div>
                <div class="mapa-facil" style="margin-top:24px;cursor:default">
                    <div class="icono">🌶️</div>
                    <h4>SacaSabor</h4>
                    <p>Plataforma web · Proyecto de grado</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
