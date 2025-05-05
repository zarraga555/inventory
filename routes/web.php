<?php

use App\Livewire\UserManagement\Users\Index;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::prefix('user-management')->group(function () {
        Volt::route('users', 'user-management.users.index')->name('user-management.users.index')->middleware('can:users.view');
        Volt::route('users/create', 'user-management.users.create')->name('user-management.users.create')->middleware('can:users.create');
        Volt::route('users/{user}/edit', 'user-management.users.edit')->name('user-management.users.edit')->middleware('can:users.update');
        Volt::route('users/{user}/logs', 'user-management.logs.index')->name('user-management.users.logs.view')->middleware('can:users.logs.view');
    });

    Route::prefix('user-management')->group(function () {
        Volt::route('roles', 'user-management.roles.index')->name('user-management.roles.index')->middleware('can:roles.view');
        Volt::route('roles/create', 'user-management.roles.create')->name('user-management.roles.create')->middleware('can:roles.create');
        Volt::route('roles/{role}/edit', 'user-management.roles.edit')->name('user-management.roles.edit')->middleware('can:roles.update');
    });
});

// Route::prefix('wizard')->group(function () {
//     Volt::route('form', 'wizard.form-wizard')->name('wizzard.form');
// });

require __DIR__ . '/auth.php';
