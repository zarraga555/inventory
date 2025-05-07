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

        Volt::route('roles', 'user-management.roles.index')->name('user-management.roles.index')->middleware('can:roles.view');
        Volt::route('roles/create', 'user-management.roles.create')->name('user-management.roles.create')->middleware('can:roles.create');
        Volt::route('roles/{role}/edit', 'user-management.roles.edit')->name('user-management.roles.edit')->middleware('can:roles.update');
    });

    Route::prefix('contacts')->group(function () {
        Volt::route('customer', 'contacts.customer.index')->name('contacts.customer.index')->middleware('can:customer.view');
        Volt::route('customer/create', 'contacts.customer.create')->name('contacts.customer.create')->middleware('can:customer.create');
        Volt::route('customer/{customer}/edit', 'contacts.customer.edit')->name('contacts.customer.edit')->middleware('can:customer.update');

        Volt::route('supplier', 'contacts.supplier.index')->name('contacts.supplier.index')->middleware('can:supplier.view');
        Volt::route('supplier/create', 'contacts.supplier.create')->name('contacts.supplier.create')->middleware('can:supplier.create');
        Volt::route('supplier/{supplier}/edit', 'contacts.supplier.edit')->name('contacts.supplier.edit')->middleware('can:supplier.update');

        Volt::route('customer-group', 'contacts.customer-group.index')->name('contacts.customer-group.index')->middleware('can:customer-group.view');
        Volt::route('customer-group/create', 'contacts.customer-group.create')->name('contacts.customer-group.create')->middleware('can:customer-group.create');
        Volt::route('customer-group/{customerGroup}/edit', 'contacts.customer-group.edit')->name('contacts.customer-group.edit')->middleware('can:customer-group.update');

        Volt::route('import-contacts', 'contacts.import-contact.index')->name('contacts.import-contact.index')->middleware('can:import-contact.view');
    });
});

// Route::prefix('wizard')->group(function () {
//     Volt::route('form', 'wizard.form-wizard')->name('wizzard.form');
// });

require __DIR__ . '/auth.php';
