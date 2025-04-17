<?php

Route::get('1d06eaa9-616f-4112-97b7-959dda9d8891', [App\Http\Controllers\TaskController::class, 'tasks'])->name('task.tasks')->middleware(['web', 'auth'])->prefix('action');

Route::post('da4d7e4d-f23a-48e7-9f72-0357fcd01292', [App\Http\Controllers\TaskController::class, 'store'])->name('task.store')->middleware(['web', 'auth'])->prefix('action');

Route::get('e763eb63-082e-4b2f-859f-181075fec7d4/{task}', [App\Http\Controllers\TaskController::class, 'show'])->name('task.show')->middleware(['web', 'auth'])->prefix('action');

Route::patch('a0eecf5d-0974-4c5b-80e3-3844d525ba31/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('task.update')->middleware(['web', 'auth'])->prefix('action');

Route::delete('797ec4a3-93ca-41c8-af92-27913fc1a988/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('task.destroy')->middleware(['web', 'auth'])->prefix('action');

