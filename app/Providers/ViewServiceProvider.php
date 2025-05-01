<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::component('components.flux.table', 'flux.table');
        Blade::component('components.flux.table.columns', 'flux.table.columns');
        Blade::component('components.flux.table.column', 'flux.table.column');
        Blade::component('components.flux.table.rows', 'flux.table.rows');
        Blade::component('components.flux.table.row', 'flux.table.row');
    }
}