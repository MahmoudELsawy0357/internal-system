<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/administration', function () {
        return Inertia::render('Administration/Index', [
            'stats' => [
                'employees' => ['count' => 122, 'new' => 2],
            ],
        ]);
    })->name('administration');

    Route::get('/ranks', function () {
        return Inertia::render('Administration/Ranks/Index', [
            'ranks' => [
                ['id' => 1, 'name' => 'Admin'],
                ['id' => 2, 'name' => 'Admin'],
                ['id' => 3, 'name' => 'Admin'],
            ],
        ]);
    })->name('ranks');

    Route::get('/ranks/create', function () {
        return Inertia::render('Administration/Ranks/Create');
    })->name('ranks.create');

    Route::get('/ranks/{id}/edit', function ($id) {
        $rank = ['id' => $id, 'name' => 'Admin', 'permissions' => []];
        return Inertia::render('Administration/Ranks/Edit', ['rank' => $rank]);
    })->name('ranks.edit');

    Route::patch('/ranks/{id}', function ($id) {
        return redirect()->route('ranks');
    })->name('ranks.update');
});

require __DIR__.'/auth.php';
