<?php

declare(strict_types=1);

Route::get('01902a77-4519-4bdf-8656-ccb1222aa6f4', [App\Http\Controllers\UserController::class, 'users'])->name('user.users')->middleware(['web'])->prefix('action');

Route::get('15c8b2d2-f6e9-4d81-a517-30e7b7a349e0', [App\Http\Controllers\TestOneController::class, 'functionOne'])->name('testone.function.one')->middleware(['web'])->prefix('action');

Route::post('ed60dc2a-61fa-489e-95d5-38f645f58e71', [App\Http\Controllers\TestOneController::class, 'functionTwo'])->name('testone.function.two')->middleware(['web'])->prefix('action');

Route::get('1447d671-ef99-4d6f-87f5-153eb31a47a6', [App\Http\Controllers\TestOneController::class, 'functionThree'])->name('blabla.function.three')->middleware(['web'])->prefix('action');

Route::get('a7ef6075-1866-4833-bb59-5b59d513a0a3/{user}', [App\Http\Controllers\TestOneController::class, 'functionFour'])->name('testone.function.four')->middleware(['web'])->prefix('action');

Route::get('samgan-rocks/awesome', [App\Http\Controllers\TestOneController::class, 'functionFive'])->name('testone.function.five')->middleware(['web'])->prefix('action');
