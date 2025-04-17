<?php

declare(strict_types=1);

Route::get('63af76b3-86b0-43a8-bca7-e1b39862b559', [App\Http\Controllers\TaskController::class, 'tasks'])->name('task.tasks')->middleware(['web', 'auth'])->prefix('action');

Route::post('c1e03b8f-73cf-48be-8395-8ec8a41006b3', [App\Http\Controllers\TaskController::class, 'store'])->name('task.store')->middleware(['web', 'auth'])->prefix('action');

Route::get('b2e41bb0-4b41-4bc8-a568-a3429626a311/{task}', [App\Http\Controllers\TaskController::class, 'show'])->name('task.show')->middleware(['web', 'auth'])->prefix('action');

Route::patch('26a0b94f-c1d8-4ab5-ae03-491e2bef45d9/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('task.update')->middleware(['web', 'auth'])->prefix('action');

Route::delete('7495f27f-d521-465b-b1ba-7900ddaa9518/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('task.destroy')->middleware(['web', 'auth'])->prefix('action');
