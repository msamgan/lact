<?php

declare(strict_types=1);

Route::get('d0cc4d67-d857-4f7e-91d7-417de6620e6a', [App\Http\Controllers\UserController::class, 'users'])->name('user.users')->middleware(['web'])->prefix('action');

Route::get('443c0339-0f14-4712-9d04-5be9dd1146cb', [App\Http\Controllers\TestOneController::class, 'functionOne'])->name('testone.function.one')->middleware(['web'])->prefix('action');

Route::post('98e7def3-1173-4e00-87d6-b0f652e580c9', [App\Http\Controllers\TestOneController::class, 'functionTwo'])->name('testone.function.two')->middleware(['web'])->prefix('action');

Route::get('3e74730d-4845-4a9d-b941-b0195ae9e582', [App\Http\Controllers\TestOneController::class, 'functionThree'])->name('blabla.function.three')->middleware(['web'])->prefix('action');

Route::get('fa4513a0-2bf7-443f-aa3d-77061f6ff09a/{user}', [App\Http\Controllers\TestOneController::class, 'functionFour'])->name('testone.function.four')->middleware(['web'])->prefix('action');

Route::get('samgan-rocks/awesome', [App\Http\Controllers\TestOneController::class, 'functionFive'])->name('testone.function.five')->middleware(['web'])->prefix('action');
