<?php

Route::post('025d7c1e-4ffb-458d-9e79-848c05ddd119', [App\Http\Controllers\Settings\ProfileController::class, 'updateData'])->name('profile.update.data')->middleware(['web'])->prefix('action');

Route::get('d12a77d2-05ea-4cdb-9ce7-b7790e480826', [App\Http\Controllers\Settings\ProfileController::class, 'getUserData'])->name('profile.get.user.data')->middleware(['web'])->prefix('action');

Route::post('user/update/{user}', [App\Http\Controllers\DashboardController::class, 'updateUser'])->name('user.update')->middleware(['web', 'auth', 'verified'])->prefix('action');

