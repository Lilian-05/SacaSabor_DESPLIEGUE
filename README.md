<div align="center">

# 🌶️ SacaSabor

**Plataforma web para la gestión y difusión de la oferta gastronómica de las chicharronerías del municipio de Sacaba**

Sacaba · Cochabamba · Bolivia 🇧🇴

</div>

---

## 📌 Descripción

**SacaSabor** es una plataforma web que permite a las chicharronerías de Sacaba **mostrar y administrar su información gastronómica**, mientras que los clientes pueden **buscar, conocer y comparar** la oferta disponible: menús, precios, disponibilidad, ubicación, calificaciones y comentarios.

> ⚠️ **Importante:** SacaSabor **NO** es una aplicación de delivery ni de ventas en línea. No tiene carrito, pedidos, pagos ni repartidores. Su función es **gestionar, actualizar, organizar y difundir la información gastronómica**.

---

## 👥 Tipos de usuarios

| Usuario | Acceso |
|--------|--------|
| 👤 **Cliente / Visitante** | Consulta todas las chicharronerías, menús, precios, disponibilidad, califica y comenta |
| 👩‍🍳 **Propietario** | Administra **solo su** chicharronería (productos, disponibilidad, ubicación, perfil) |
| 🛡️ **Administrador** | Supervisa toda la plataforma (usuarios, chicharronerías, productos, comentarios, estadísticas) |

### 🔐 Regla de acceso

```
PROPIETARIO → administra SOLO SU chicharronería
CLIENTE     → consulta TODAS las chicharronerías
ADMIN       → supervisa TODA la plataforma
```

Un propietario **nunca** puede ver ni modificar el panel de otra chicharronería (protegido con verificación por propietario).

---

## 💻 Tecnologías

| Tecnología | Utilidad |
|-----------|----------|
| **HTML5 / CSS3 / JavaScript** | Estructura, diseño e interactividad |
| **Laravel 12** | Framework PHP backend |
| **PHP 8.2+** | Lenguaje de programación |
| **MySQL / SQLite** | Base de datos |
| **XAMPP** | Servidor local (Apache + MySQL) |
| **Blade** | Motor de plantillas |

---

## 🚀 Instalación rápida (funciona de inmediato con SQLite)

Este proyecto está configurado por defecto con **SQLite**, por lo que funciona sin necesidad de crear una base de datos.

```bash
# 1. Clonar o copiar el proyecto
cd sacasabor

# 2. Instalar dependencias de PHP
composer install

# 3. Copiar configuración de entorno
copy .env.example .env

# 4. Generar clave de aplicación
php artisan key:generate

# 5. Crear enlace simbólico para imágenes
php artisan storage:link

# 6. Ejecutar migraciones y sembrar datos de ejemplo
php artisan migrate:fresh --seed

# 7. Iniciar el servidor
php artisan serve
```

Abre **http://localhost:8000** en tu navegador.

---

## 🐬 Usar con MySQL (XAMPP) — requerimiento del proyecto

1. Abre **XAMPP** y activa **Apache** y **MySQL**.
2. Ve a **phpMyAdmin** → Nueva → crea una base de datos llamada `sacasabor`.
3. Edita el archivo `.env` y cambia la conexión:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sacasabor
DB_USERNAME=root
DB_PASSWORD=
```

4. Ejecuta:
```bash
php artisan config:clear
php artisan migrate:fresh --seed
php artisan serve
```

---

## 🔑 Cuentas de prueba (creadas por el seeder)

| Rol | Correo | Contraseña |
|-----|--------|------------|
| 🛡️ **Administrador** | `admin@sacasabor.com` | `password` |
| 👩‍🍳 **Propietario** | `juan@propietario.com` | `password` |
| 👤 **Cliente** | `carlos@cliente.com` | `password` |

---

## 🗂️ Estructura de la base de datos

```
usuarios
  ├── rol (cliente | propietario | administrador)
chicharronerias  → propietario (usuario)
categorias
productos        → chicharronería + categoría
calificaciones   → usuario + chicharronería (única por par)
comentarios      → usuario + chicharronería
```

Relaciones:
- **Usuario → realiza → Calificación**
- **Usuario → escribe → Comentario**
- **Chicharronería → tiene → Productos**
- **Categoría → clasifica → Productos**

---

## 📱 Funcionalidades principales

### Página pública
- Hero dinámico con buscador por nombre
- Chicharronerías destacadas
- Categorías y productos destacados
- Sección de identidad gastronómica de Sacaba
- Listado con filtros (nombre, zona, categoría, calificación)
- Perfil de chicharronería con pestañas: Menú / Información / Opiniones
- Sistema de calificación con estrellas y comentarios

### Panel del propietario
- Dashboard con estadísticas de su negocio
- Registro y edición de su chicharronería
- Gestión de productos (crear, editar, eliminar)
- Cambio rápido de disponibilidad (🟢 Disponible / 🔴 Agotado)
- Gestión de ubicación (fácil, con selector de mapa de Sacaba)
- Perfil personal

### Panel del administrador
- Dashboard general con estadísticas
- Gestión de usuarios (cambiar rol, eliminar)
- Gestión de chicharronerías (destacar, activar/desactivar, eliminar)
- Supervisión de productos, calificaciones y comentarios
- Gestión de categorías
- Estadísticas con gráficos (por zona y distribución de calificaciones)

---

## 🎨 Identidad visual

Colores gastronómicos: 🔴 rojo, 🟠 naranja, 🟡 dorado, ⚫ tonos oscuros y ⚪ blanco. Diseño moderno, adaptable a computadora, celular y tablet.

---

## 📄 Licencia

Proyecto de grado académico.
