<?php

namespace App\Modules\Tap\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tap\Services\RedirectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RedirectController extends Controller
{
    public function __construct(
        protected RedirectService $redirectService
    ) {}

    /**
     * Handle incoming NFC / QR short link redirect.
     */
    public function handle(string $slug, Request $request): RedirectResponse|Response
    {
        return $this->redirectService->handle($slug, $request);
    }
}
