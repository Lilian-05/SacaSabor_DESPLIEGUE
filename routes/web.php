<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ChicharroneriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PropietarioController;
use Illuminate\Support\Facades\Route;
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});

Route::get('/mapa-seleccion', function () {
    return view('mapa-seleccion');
})->name('mapa.seleccion');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/chicharronerias', [ChicharroneriaController::class, 'index'])->name('chicharronerias.index');
Route::get('/chicharronerias/{chicharroneria}', [ChicharroneriaController::class, 'show'])->name('chicharronerias.show');
Route::get('/categorias/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');
Route::get('/nosotros', [PaginaController::class, 'nosotros'])->name('nosotros');
Route::get('/contacto', [PaginaController::class, 'contacto'])->name('contacto');
Route::post('/contacto', [PaginaController::class, 'enviarContacto']);

Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
Route::post('/registro', [AuthController::class, 'register']);
Route::get('/iniciar-sesion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/iniciar-sesion', [AuthController::class, 'login']);
Route::post('/cerrar-sesion', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::post('/chicharronerias/{chicharroneria}/opiniones', [OpinionController::class, 'store'])->name('opiniones.store');
    Route::delete('/comentarios/{comentario}', [OpinionController::class, 'destruirComentario'])->name('opiniones.destruir');
});

Route::middleware('role:propietario')->prefix('propietario')->name('propietario.')->group(function () {
    Route::get('/dashboard', [PropietarioController::class, 'dashboard'])->name('dashboard');

    Route::get('/chicharroneria/crear', [PropietarioController::class, 'crearChicharroneria'])->name('chicharroneria.crear');
    Route::post('/chicharroneria/crear', [PropietarioController::class, 'guardarChicharroneria']);
    Route::get('/chicharroneria', [PropietarioController::class, 'editarChicharroneria'])->name('chicharroneria.editar');
    Route::put('/chicharroneria', [PropietarioController::class, 'actualizarChicharroneria']);

    Route::get('/ubicacion', [PropietarioController::class, 'ubicacion'])->name('ubicacion');
    Route::put('/ubicacion', [PropietarioController::class, 'actualizarUbicacion']);

    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    Route::post('/productos/{producto}/disponibilidad', [ProductoController::class, 'toggleDisponibilidad'])->name('productos.disponibilidad');

    Route::get('/perfil', [PropietarioController::class, 'perfil'])->name('perfil');
    Route::put('/perfil', [PropietarioController::class, 'actualizarPerfil']);
});

Route::middleware('role:administrador')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdministradorController::class, 'dashboard'])->name('dashboard');

    Route::get('/usuarios', [AdministradorController::class, 'usuarios'])->name('usuarios');
    Route::put('/usuarios/{usuario}', [AdministradorController::class, 'actualizarUsuario'])->name('usuarios.actualizar');
    Route::delete('/usuarios/{usuario}', [AdministradorController::class, 'eliminarUsuario'])->name('usuarios.eliminar');

    Route::get('/chicharronerias', [AdministradorController::class, 'chicharronerias'])->name('chicharronerias');
    Route::put('/chicharronerias/{chicharroneria}', [AdministradorController::class, 'actualizarChicharroneria'])->name('chicharronerias.actualizar');
    Route::delete('/chicharronerias/{chicharroneria}', [AdministradorController::class, 'eliminarChicharroneria'])->name('chicharronerias.eliminar');

    Route::get('/productos', [AdministradorController::class, 'productos'])->name('productos');
    Route::delete('/productos/{producto}', [AdministradorController::class, 'eliminarProducto'])->name('productos.eliminar');

    Route::get('/comentarios', [AdministradorController::class, 'comentarios'])->name('comentarios');
    Route::delete('/comentarios/{comentario}', [AdministradorController::class, 'eliminarComentario'])->name('comentarios.eliminar');

    Route::get('/calificaciones', [AdministradorController::class, 'calificaciones'])->name('calificaciones');

    Route::get('/categorias', [AdministradorController::class, 'categorias'])->name('categorias');
    Route::post('/categorias', [AdministradorController::class, 'guardarCategoria'])->name('categorias.guardar');
    Route::put('/categorias/{categoria}', [AdministradorController::class, 'actualizarCategoria'])->name('categorias.actualizar');
    Route::delete('/categorias/{categoria}', [AdministradorController::class, 'eliminarCategoria'])->name('categorias.eliminar');

    Route::get('/estadisticas', [AdministradorController::class, 'estadisticas'])->name('estadisticas');
});
