<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'markAsCompleted'])->name('tasks.complete');
    Route::get('/tasks/{task}/confirm-complete', [TaskController::class, 'confirmComplete'])->name('tasks.confirmComplete');

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    Route::get('/test-email', [StatisticsController::class, 'sendTestEmail'])->name('test.email');

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'index'])->name('home');

});
