<?php

use App\Modules\Tap\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (TapReview)
|--------------------------------------------------------------------------
*/

// Explicit Fast Redirect Route (e.g. /r/kopisudut?src=nfc&p=KPS-001)
Route::get('/r/{slug}', [RedirectController::class, 'handle'])->name('tap.redirect');

// Explicit Login Route for Framework/Named Route Resolution
Route::get('/masuk', function () {
    return view('app');
})->name('login');

// SPA Frontend Reserved Routes
$reservedPrefixes = 'generator|harga|pesan|demo|portal|admin|api';

// Any reserved route serves the Vue 3 SPA
Route::get('/{any}', function () {
    return view('app');
})->where('any', "^({$reservedPrefixes})(/.*)?$");

// Root landing page
Route::get('/', function () {
    return view('app');
});

// Dynamic Client Short Link (e.g. /kopisudut?src=nfc&p=KPS-001)
Route::get('/{slug}', [RedirectController::class, 'handle'])->where('slug', '^[a-zA-Z0-9\-_]+$');
