<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;


Route::get('/', [PageController::class , 'limit_3'])->name('limit_3');
Route::get('/all_events', [PageController::class , 'get_all_events'])->name('get_all_events');
Route::get('/all_news', [PageController::class , 'all_news'])->name('all_news');
Route::get('/one_new', function(){return view('one_new');})->name('one_new');

Route::get('/admin/index/{id?}', [PageController::class , 'admin_index'])->name('admin_index');

Route::get('/login_show', [PageController::class, 'login_show'])->name('login_show');
Route::post('/login', [PageController::class, 'login'])->name('login');
Route::get('/logout', [PageController::class, 'logout'])->name('logout');

// LOGIN
Route::post('/login', [PageController::class, 'login'])->name('login');


// AFISHA
// Route::get('/', [PageController::class, 'get_all_events']);
// INDEX LIMIT 3 EVENT 
// Route::get('/limit_3', [PageController::class , 'limit_3'])->name('limit_3');
// INDEX NEWS LIMIT 4
Route::get('/news', [PageController::class, 'limit_4'])->name('news');


// ADMIN

// ROUTE LINK ONE EVENT TO UPDATE
// Route::get('/events/{id?}', [PageController::class, 'get_all_events'])->name('index');
// POST QUERY CREATE EVENT
Route::post('/create_event', [PageController::class, 'create_event'])->name('create_event');
// POST QUERY UPDATE EVENT
Route::post('/update_event', [PageController::class, 'update_event'])->name('update_event');
// ADMIN DELETE EVENT
Route::get('/delete_event/{id}', [PageController::class, 'delete_event'])->name('delete_event');


// POST CRAETE NEWS
Route::post('/create_news', [PageController::class, 'create_news'])->name('create_news');
// UPDATE GET VIEW
Route::get('/news/{id?}', [PageController::class, 'limit_4'])->name('news_u');
// UPDATE POST UPDATE NEWS
Route::post('/update_news', [PageController::class, 'update_news'])->name('update_news');
// DELETE NEWS ADMIN 
Route::get('/news_d/{id}', [PageController::class, 'news_d'])->name('news_d');


// MORE INFO
Route::get('/one_news/{id}', [PageController::class, 'news_more'])->name('one_news');
Route::get('/one_events/{id}', [PageController::class, 'event_more'])->name('one_events');