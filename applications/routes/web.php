<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FileController::class, 'index']);
Route::post('/upload', [FileController::class, 'upload'])->name('upload');
Route::get('/d/{slug}', [FileController::class, 'show'])->name('show');
Route::post('/d/{slug}', [FileController::class, 'download'])->name('download');

Route::match(['get', 'post'], '/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::patch('/admin/files/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/files/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
