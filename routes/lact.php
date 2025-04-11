<?php

declare(strict_types=1);

Route::post(
    '85906367-216d-4f44-b463-4c3508478b52/{user}',
    [App\Http\Controllers\LactTestController::class, 'testFunction']
)->name('test.function')->middleware(['auth', 'verified'])->prefix('action');
