<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


Route::get('/', [PageController::class , 'login_show'])->name('login_show');


Route::get('/admin/index/{id?}', [PageController::class , 'admin_index'])->name('admin_index');

// Route::get('/login_show', [PageController::class, 'login_show'])->name('login_show');
Route::post('/login', [PageController::class, 'login'])->name('login');
Route::get('/reg_show', [PageController::class, 'reg_show'])->name('reg_show');
Route::post('/reg', [PageController::class, 'reg'])->name('reg');

Route::get('/logout', [PageController::class, 'logout'])->name('logout');


Route::get('/my_appls', [PageController::class, 'my_appls'])->name('my_appls');
Route::get('/appl', [PageController::class, 'appl'])->name('appl');
 