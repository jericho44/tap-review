<template>
  <div class="min-h-screen flex bg-slate-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-900 text-white flex flex-col shrink-0">
      <div class="h-16 flex items-center px-6 border-b border-slate-800 gap-3">
        <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center font-bold text-white">T</div>
        <div>
          <div class="font-bold text-sm tracking-tight">TapReview Portal</div>
          <div class="text-[11px] text-slate-400">Kopi Sudut (Client)</div>
        </div>
      </div>

      <nav class="p-4 space-y-1 flex-1 text-sm">
        <router-link to="/portal" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-indigo-600 text-white font-medium">
          <span>📊</span> Ringkasan
        </router-link>
        <router-link to="/portal/points" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-indigo-600 text-white font-medium">
          <span>🏷️</span> Titik Stiker (NFC & QR)
        </router-link>
        <router-link to="/portal/destination" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-indigo-600 text-white font-medium">
          <span>🔗</span> Link Ulasan Google
        </router-link>
        <router-link to="/portal/materials" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-indigo-600 text-white font-medium">
          <span>🖨️</span> Materi Siap Cetak
        </router-link>
      </nav>

      <div class="p-4 border-t border-slate-800">
        <router-link to="/" class="flex items-center gap-2 text-xs text-slate-400 hover:text-white mb-3">
          ← Kembali ke Website
        </router-link>
        <router-link to="/masuk" class="flex items-center justify-center w-full py-2 px-3 text-xs font-medium text-rose-400 hover:bg-rose-950/40 rounded-md border border-rose-900/50">
          Keluar
        </router-link>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between">
        <h1 class="text-base font-semibold text-slate-800">Portal Klien</h1>
        <div class="flex items-center gap-3">
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
            Status: Aktif
          </span>
          <span class="text-xs text-slate-500">Paket Pro</span>
        </div>
      </header>

      <main class="flex-1 p-6 overflow-y-auto">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
// Client Layout
</script>
