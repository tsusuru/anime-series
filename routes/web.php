<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\PublisherController;

use App\Models\Publisher;

use App\Http\Controllers\LandingController;

Route::get('/', [LandingController::class, 'index'])->name('landing');


Route::resource('anime', SerieController::class);

Route::resource('publishers', PublisherController::class);
// => levert o.a. op: publishers.index, publishers.create, publishers.store, publishers.show,
//                    publishers.edit, publishers.update, publishers.destroy

// Extra: aan/uit-knop
Route::patch('/publishers/{publisher}/toggle', [PublisherController::class, 'toggle'])
    ->name('publishers.toggle');

// (optioneel) snelkoppeling om het eerste item te tonen:
Route::get('/publishers-first', [PublisherController::class, 'showFirst'])->name('publishers.first');


Route::get('/contact', function() {
    $company = 'Hogeschool Rotterdam';
    return view('contact', [
        'company' => $company
    ]);
});

Route::get('/products/productdetails/{id?}', function ($id) {
    return "Product details voor product met ID: " . $id;
})->name('product.details');

Route::get('products/{id}', function(string $id) {
    return view('product', [
        'id' => $id
    ]);
});

Route::resource('series', SerieController::class)
    ->parameters(['series' => 'serie']); // {serie} → App\Models\Serie

// Aan/uit toggle
Route::patch('/series/{serie}/toggle', [SerieController::class, 'toggle'])
    ->name('series.toggle');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
