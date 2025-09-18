<?php

use App\Http\Controllers\Admin\AsistenciasController;
use App\Http\Controllers\Admin\EconomicoController;
use App\Http\Controllers\Admin\PersonasController;
use App\Http\Controllers\Admin\ReforestacionController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\ServiciosController;
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


        // ──────────────── SECCIONES DEL FORMULARIO (PERSONAS, ECONÓMICO, SERVICIOS, ETC.) ────────────────
        // Agrupamos todas bajo el mismo prefijo y name-space
        Route::prefix('formularios/{formulario}')->name('admin.formularios.')->group(function () {

            // PERSONAS
            Route::prefix('personas')->name('personas.')->controller(PersonasController::class)->group(function () {
                Route::get('/edit-add', 'editAdd')->name('edit-add');
                Route::post('/',        'store')  ->name('store');
                Route::put('/{persona}','update') ->name('update');

                 Route::post('/matriz-rapido',     'matrizRapido')       ->name('matriz.rapido');
            });

            // ECONÓMICO
            Route::prefix('economico')->name('economico.')->controller(EconomicoController::class)->group(function () {
                Route::get('/edit-add', 'editAdd')->name('edit-add');
                Route::post('/',        'store')  ->name('store');
                // Route::put('/{economico}','update')->name('update');
                Route::put('/',         'update') ->name('update');

                // ➜➜➜  MATRIZ RÁPIDA (nueva)
                Route::post('/matriz-rapido', 'matrizRapido')->name('matriz.rapido');
            });

            // SERVICIOS
            Route::prefix('servicios')->name('servicios.')->controller(ServiciosController::class)->group(function () {
                Route::get('/edit-add', 'editAdd')->name('edit-add');
                Route::post('/',        'store')  ->name('store');
                Route::put('/','update')->name('update');

                // ➜➜➜  MATRIZ RÁPIDA (nueva)
                Route::post('/matriz-rapido', 'matrizRapido')->name('matriz.rapido');
            });

            // REPORTE
            Route::prefix('reporte')->name('reporte.')->controller(ReporteController::class)->group(function () {
                Route::get('/edit-add', 'editAdd')->name('edit-add');
                Route::post('/',        'store')  ->name('store');
                Route::put('/{reporte}','update')->name('update');
            });

            // ASISTENCIAS
            Route::prefix('asistencias')->name('asistencias.')->controller(AsistenciasController::class)->group(function () {
                Route::get('/edit-add', 'editAdd')->name('edit-add');
                Route::post('/',        'store')  ->name('store');
                Route::put('/{asistencia}','update')->name('update');
            });

            // REFORESTACIONES
            Route::prefix('reforestaciones')->name('reforestaciones.')->controller(ReforestacionController::class)->group(function () {
                Route::get('/edit-add', 'editAdd')->name('edit-add');
                Route::post('/',        'store')  ->name('store');
                Route::put('/{reforestacion}','update')->name('update');
            });
        });

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
