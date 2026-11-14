<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (TapReview)
|--------------------------------------------------------------------------
*/

// Fast Redirect Route for NFC & QR Stikers (e.g. /kopisudut?src=nfc&p=KPS-001)
// Kecepatan di bawah 1 detik, mencatat tap ke database queue.
Route::get('/r/{slug}', function (string $slug, Request $request) {
    $source = $request->query('src', 'nfc'); // 'nfc' or 'qr'
    $pointCode = $request->query('p');

    // Default demo fallback URL
    $targetGoogleReviewUrl = 'https://maps.app.goo.gl/kopi-sudut-official';

    // Dispatch asynchronous job here: RecordTapJob::dispatch($slug, $source, $pointCode, $request->userAgent());

    return redirect()->away($targetGoogleReviewUrl, 302);
});

// Single Page Application (Vue 3 + TypeScript fallback)
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '.*');
