<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Voyager\FormularioController;
use TCG\Voyager\Facades\Voyager;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirección raíz y login
Route::redirect('login', 'admin/login')->name('login');
Route::redirect('/', 'admin');


// Grupo principal con middleware personalizado
Route::prefix('admin')->middleware(['loggin', 'system'])->group(function () {

    // Rutas de Voyager
    Voyager::routes();

    Route::resource('formularios', FormularioController::class)->middleware('auth');
        Route::get('formularios/ajax/list', [FormularioController::class, 'list'])->name('formularios.list');
        Route::get('formularios/create/provincia/{id_provincia}', [FormularioController::class, 'buscar_municipio'])->name('admin.formulario.buscar_municipio');
        Route::get('formularios/create/municipio/{id_municipio}', [FormularioController::class, 'buscar_comunidad'])->name('admin.formulario.buscar_comunidad');
        Route::get('formularios/create/get-alcalde/{municipioId}', [FormularioController::class, 'getAlcalde'])->name('admin.formulario.getAlcalde');
        Route::get('formularios/create/get-poblacion/{municipioId}', [FormularioController::class, 'getPoblacion'])->name('admin.formulario.getPoblacion');

        Route::get('formularios/{id}/delete', [FormularioController::class, 'destroy'])->name('formularios.destroy');
        Route::get('formularios/{id}/restore', [FormularioController::class, 'restore'])->name('formularios.restore');
        Route::get('formularios/{id}/ver', [FormularioController::class, 'ver'])->name('formularios.ver');
        Route::get('formularios/trashed', [FormularioController::class, 'trashed'])->name('formularios.trashed');

        // ──────────────── COMUNIDADES (QUICK STORE) ────────────────
        Route::post('comunidades/quick-store', [FormularioController::class, 'quickStoreComunidad'])->name('admin.comunidades.quick-store');

    // ──────────────── PERSONAS ────────────────
    Route::prefix('people')->group(function () {
        Route::get('/', [PersonController::class, 'index'])->name('voyager.people.index');
        Route::get('/ajax/list', [PersonController::class, 'list'])->name('voyager.people.ajax.list');
        Route::post('/', [PersonController::class, 'store'])->name('voyager.people.store');
        Route::put('/{id}', [PersonController::class, 'update'])->name('voyager.people.update');
    });

    // ──────────────── USUARIOS ────────────────
    Route::prefix('users')->group(function () {
        Route::get('/ajax/list', [UserController::class, 'list'])->name('voyager.users.ajax.list');
        Route::post('/store', [UserController::class, 'store'])->name('voyager.users.store');
        Route::put('/{id}', [UserController::class, 'update'])->name('voyager.users.update');
        Route::delete('/{id}/deleted', [UserController::class, 'destroy'])->name('voyager.users.destroy');
    });

    // ──────────────── ROLES ────────────────
    Route::prefix('roles')->group(function () {
        Route::get('/ajax/list', [RoleController::class, 'list'])->name('voyager.roles.ajax.list');
    });

    // ──────────────── AJAX GENÉRICO ────────────────
    Route::prefix('ajax')->group(function () {
        Route::get('/personList', [AjaxController::class, 'personList']);
        Route::post('/person/store', [AjaxController::class, 'personStore']);
    });

    // ──────────────── UTILIDADES ────────────────
    Route::get('/clear-cache', function () {
        Artisan::call('optimize:clear');
        return redirect('/admin/profile')->with([
            'message' => 'Cache eliminada.',
            'alert-type' => 'success'
        ]);
    })->name('clear.cache');
});
