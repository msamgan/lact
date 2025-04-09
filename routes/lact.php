<?php

declare(strict_types=1);

// test URL will be removed after installation.
Route::post(
    '85906367-216d-4f44-b463-4c3508478b52/{user}',
    [App\Http\Controllers\DashboardController::class, 'userUpdate']
)->name('user.update')
    ->middleware(['auth', 'verified'])
    ->prefix('action');
