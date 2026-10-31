<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión · SacaSabor</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon-sacasabor.png') }}">
</head>
<body>
    <div class="auth-contenedor">
        <div class="auth-tarjeta">
            <a href="{{ route('home') }}" class="logo-auth">
                <img src="{{ asset('img/logo-sacasabor.png') }}" alt="SacaSabor" style="width:88px;height:88px;object-fit:contain;margin:0 auto 10px">
                <div style="font-size:24px;font-weight:800;color:var(--oscuro)">SacaSabor</div>
                <div style="font-size:12px;color:var(--gris-oscuro)">Sacaba · Bolivia</div>
            </a>
            <h2>🔐 Iniciar sesión</h2>
            <p class="sub">Accede a tu cuenta para continuar</p>

            @if($errors->any())
                <div class="alerta alerta-error">
                    @foreach($errors->all() as $error) {{ $error }} @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-grupo">
                    <label>📧 Correo o usuario</label>
                    <input type="text" name="login" value="{{ old('login') }}" placeholder="tucorreo@ejemplo.com o tu usuario" required autofocus autocomplete="username">
                </div>
                <div class="form-grupo">
                    <label>🔑 Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primario btn-bloque">Iniciar sesión</button>
            </form>

            <div class="auth-enlace">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></div>
            <div style="margin-top:20px;padding:14px;background:#fff5f5;border-radius:12px;font-size:12px;color:var(--gris-oscuro)">
                <strong>Cuentas de prueba:</strong><br>
                👤 Cliente: <strong>carlos@cliente.com</strong> / password<br>
                👩‍🍳 Propietario: <strong>juan@propietario.com</strong> / password<br>
                🛡️ Administrador: <strong>admin@sacasabor.com</strong> / password
            </div>
        </div>
    </div>
</body>
</html>
