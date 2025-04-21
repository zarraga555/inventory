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
        Volt::route('users','user-management.users.index')->name('user-management.users.index');
        Volt::route('users/create','user-management.users.create')->name('user-management.users.create');
        Volt::route('users/{user}/edit','user-management.users.edit')->name('user-management.users.edit');
    });
});

require __DIR__.'/auth.php';
