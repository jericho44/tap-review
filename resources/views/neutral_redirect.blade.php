<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $client->business_name ?? 'Google Maps Review' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="h-full bg-slate-100 flex items-center justify-center p-4 font-sans text-slate-800">
    <div class="max-w-md w-full bg-white rounded-2xl border border-slate-200 p-8 shadow-sm text-center">
        <div class="w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-3xl mx-auto mb-4">
            📍
        </div>

        <h1 class="text-xl font-bold text-slate-900 mb-2">
            {{ $client->business_name ?? 'Halaman Bisnis' }}
        </h1>

        <p class="text-xs text-slate-500 mb-6 leading-relaxed">
            Terima kasih telah mengunjungi kami. Silakan klik tombol di bawah untuk membuka halaman informasi dan ulasan di Google Maps.
        </p>

        @if(!empty($googleReviewUrl))
            <a href="{{ $googleReviewUrl }}" 
               class="block w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-md transition">
                Buka di Google Maps →
            </a>
        @else
            <a href="https://maps.google.com" 
               class="block w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-md transition">
                Buka Google Maps →
            </a>
        @endif

        <div class="mt-6 pt-4 border-t border-slate-100 text-[10px] text-slate-400">
            Smart Review Stand
        </div>
    </div>
</body>
</html>
