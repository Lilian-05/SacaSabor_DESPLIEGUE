<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro · SacaSabor</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon-sacasabor.png') }}">
</head>
<body>
    <div class="auth-contenedor">
        <div class="auth-tarjeta" style="max-width:520px">
            <a href="{{ route('home') }}" class="logo-auth">
                <img src="{{ asset('img/logo-sacasabor.png') }}" alt="SacaSabor" style="width:88px;height:88px;object-fit:contain;margin:0 auto 10px">
                <div style="font-size:24px;font-weight:800;color:var(--oscuro)">SacaSabor</div>
                <div style="font-size:12px;color:var(--gris-oscuro)">Sacaba · Bolivia</div>
            </a>
            <h2>📝 Crear cuenta</h2>
            <p class="sub">Únete a la comunidad gastronómica de Sacaba</p>

            @if($errors->any())
                <div class="alerta alerta-error">
                    @foreach($errors->all() as $error) {{ $error }} @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-grupo">
                    <label>📧 Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="tucorreo@ejemplo.com" autofocus autocomplete="email">
                </div>

                <div style="text-align:center;font-size:12px;font-weight:700;color:var(--gris-oscuro);margin:-4px 0 14px">— o regístrate con un nombre de usuario —</div>

                <div class="form-grupo">
                    <label>👤 Nombre de usuario</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej: Juan Pérez" autocomplete="username">
                </div>

                <div class="form-grupo">
                    <label>🔑 Contraseña</label>
                    <input type="password" name="password" placeholder="Mínimo 6 caracteres" required autocomplete="new-password">
                </div>

                <div class="form-grupo">
                    <label>Tipo de cuenta</label>
                    <div class="tipo-cuenta">
                        <label class="tipo-cuenta-opcion seleccionado">
                            <input type="radio" name="rol" value="cliente" class="oculto" checked onclick="seleccionarTipo(this)">
                            <div class="icono">👤</div>
                            <div class="titulo">Cliente</div>
                            <div class="desc">Consultar y opinar</div>
                        </label>
                        <label class="tipo-cuenta-opcion">
                            <input type="radio" name="rol" value="propietario" class="oculto" onclick="seleccionarTipo(this)">
                            <div class="icono">👩‍🍳</div>
                            <div class="titulo">Propietario</div>
                            <div class="desc">Gestiono mi chicharronería</div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primario btn-bloque">Crear cuenta</button>
            </form>

            <div class="auth-enlace">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></div>
        </div>
    </div>

    <script>
        function seleccionarTipo(radio) {
            document.querySelectorAll('.tipo-cuenta-opcion').forEach(function(op) {
                op.classList.remove('seleccionado');
            });
            radio.closest('.tipo-cuenta-opcion').classList.add('seleccionado');
        }
    </script>
</body>
</html>
