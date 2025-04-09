<?php declare(strict_types=1);
Route::post('4f981038-ed30-454c-862e-0b222823e771', [App\Http\Controllers\Settings\ProfileController::class, 'updateData'])->name('profile.update.data')->middleware([])->prefix('action');
Route::post('25682c36-2c37-41ee-905c-f9a94bd964a2', [App\Http\Controllers\Settings\ProfileController::class, 'updateData'])->name('profile.update.data')->middleware([])->prefix('action');

Route::post('4935c9e7-8703-49fb-bef0-b4035a5ddf75/{user}', [App\Http\Controllers\DashboardController::class, 'updateUser'])->name('user.update')->middleware(['auth','verified'])->prefix('action');

