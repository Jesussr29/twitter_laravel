<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

// Rutas de autenticación
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rutas de publicaciones protegidas por middleware de autenticación
Route::middleware('auth')->group(function () {
    Route::get('/', [TwitterController::class, 'index'])->name('publicacion.index');
    Route::get('/publicacion/{id}/edit', [TwitterController::class, 'edit'])->name('publicacion.edit');
    Route::post('/publicacion', [TwitterController::class, 'store'])->name('publicacion.store');
    Route::put('/publicacion/{id}', [TwitterController::class, 'update'])->name('publicacion.update');
    Route::delete('/publicacion/{id}', [TwitterController::class, 'destroy'])->name('publicacion.destroy');
    Route::post('/publicacion/{id}/like', [TwitterController::class, 'like'])->name('publicacion.like');
    Route::post('/publicacion/{id}/retweet', [TwitterController::class, 'retweet'])->name('publicacion.retweet');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/publicaciones/{id}/comments', [CommentController::class, 'store'])->name('comments.store');


    // Ruta protegida para el dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});