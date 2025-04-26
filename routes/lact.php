<?php

Route::get('action-eye-nature-wood-water-way-action-house-year-case', [App\Http\Controllers\UserController::class, 'users'])
    ->name('user.users')->middleware(['web'])->prefix('action');

Route::get('girl-view-way-world-friend-girl-wood-science-mind-part/{user}', [App\Http\Controllers\UserController::class, 'user'])
    ->name('user.user')->middleware(['web'])->prefix('action');

Route::post('rock-team-air-question-friend-idea-water-price-month-fire', [App\Http\Controllers\UserController::class, 'store'])
    ->name('user.store')->middleware(['web'])->prefix('action');

Route::post('thing-side-art-food-thing-plant-voice-power-scene-name', [App\Http\Controllers\UserController::class, 'storeByForm'])
    ->name('user.store.by.form')->middleware(['web'])->prefix('action');

Route::patch('fire-friend-nature-price-name-home-field-hand-scene-light/{user}', [App\Http\Controllers\UserController::class, 'updateByForm'])
    ->name('user.update.by.form')->middleware(['web'])->prefix('action');

