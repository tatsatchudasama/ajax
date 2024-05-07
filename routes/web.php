<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('category/index', [CategoryController::class, 'index'])->name('category.index');
Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::delete('category/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy.edit');



// ============ ajax_2 ============
Route::get('create', [CreateController::class, 'create_view'])->name('create');

Route::post('stored', [CreateController::class, 'stored'])->name('stored');

Route::get('index', [CreateController::class, 'index'])->name('index');

Route::get('data-get/{id}', [CreateController::class, 'show_id'])->name('data_id_get');

Route::post('data-update/{id}', [CreateController::class, 'update'])->name('data_update');

Route::delete('data-delete/{id}', [CreateController::class, 'delete'])->name('data_delete');

