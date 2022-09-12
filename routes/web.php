<?php

use App\Commands\GitCommand;
use App\Http\Controllers\FakerController;
use App\Http\Controllers\HelperArrayController;
use App\Http\Controllers\HelperPathController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/app', function () {
    $laravel = app();
    return ["version" => $laravel::VERSION];
});
Route::prefix('git')->group(function () {
    Route::get('/status', function () {
        return response()->json(['resultado' => (new GitCommand())->status()]);
    });
    Route::get('/pull', function () {
        return response()->json(['resultado' => (new GitCommand())->pull()[0]]);
    });
    Route::get('/add/all', function () {
        return response()->json(['resultado' => (new GitCommand())->addAll()[0]]);
    });
    Route::get('/commit', function () {
        return response()->json(['resultado' => (new GitCommand())->commit()[0]]);
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::get('/location', function () {
        return view('pages.location');
    })->name('location');

    Route::prefix('helpers')->group(function () {
        Route::get('/array', [HelperArrayController::class, "index"])->name('helpers.array');
        Route::get('/path', [HelperPathController::class, "index"])->name('helpers.path');
        Route::get('/path/teste', [HelperPathController::class, "indexDD"]);
    });
});

# Usando o FAker PHP
Route::prefix('faker')->group(function () { 
    Route::get('/usuario', [ FakerController::class, 'usuario'])->name('faker.usuario');
});


require __DIR__.'/auth.php';
