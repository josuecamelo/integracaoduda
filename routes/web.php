<?php

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

/*Route::get('/', function () {
    return view('welcome');
    //return redirect()->route('login');
});*/

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

/*Route::get('/novo-site', [\App\Http\Controllers\SiteController::class, 'create'])->name('novo-site');
Route::get('/sites', \App\Http\Livewire\Site::class)->name('site');*/

Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])->name('teste');
//Route::post('/wp/enviar-mensagem', [\App\Http\Controllers\SiteController::class, 'sendMessage'])->name('sendMessage');




//Route::get('lerarquivo', [\App\Http\Controllers\SiteController::class, 'lerArquivo'])->name('lerArquivo');



