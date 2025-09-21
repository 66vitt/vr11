<?php

use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])
    ->name('platform.index')
    ->breadcrumbs(fn(Trail $trail) => $trail
        ->push('Главная', route('platform.index')));;
