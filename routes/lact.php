<?php

declare(strict_types=1);

Route::post('9acaf401-34ee-4bd3-904b-6f867ecf04a2', [App\Http\Controllers\Settings\ProfileController::class, 'updateData'])->name('profile.update.data')->middleware(['web'])->prefix('action');

Route::get('7fa5236a-b089-48ab-ac3c-8a29f077968d', [App\Http\Controllers\Settings\ProfileController::class, 'getUserData'])->name('profile.get.user.data')->middleware(['web'])->prefix('action');

Route::post('user/update/{user}', [App\Http\Controllers\DashboardController::class, 'updateUser'])->name('user.update')->middleware(['web', 'auth', 'verified'])->prefix('action');
