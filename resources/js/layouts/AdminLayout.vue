<template>
  <div class="min-h-screen flex bg-slate-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-950 text-white flex flex-col shrink-0">
      <div class="h-16 flex items-center px-6 border-b border-slate-800 gap-3">
        <div class="w-8 h-8 rounded-lg bg-amber-500 flex items-center justify-center font-bold text-slate-950">A</div>
        <div>
          <div class="font-bold text-sm tracking-tight">TapReview Admin</div>
          <div class="text-[11px] text-amber-400 font-mono">SuperAdmin Panel</div>
        </div>
      </div>

      <nav class="p-4 space-y-1 flex-1 text-sm">
        <router-link to="/admin" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-amber-500 text-slate-950 font-bold">
          <span>⚡</span> Dashboard Admin
        </router-link>
        <router-link to="/admin/clients" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-amber-500 text-slate-950 font-bold">
          <span>👥</span> Kelola Klien
        </router-link>
        <router-link to="/admin/points" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-amber-500 text-slate-950 font-bold">
          <span>🏷️</span> Titik & Chip NFC
        </router-link>
        <router-link to="/admin/themes" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-amber-500 text-slate-950 font-bold">
          <span>🎨</span> Katalog Tema Cetak
        </router-link>
        <router-link to="/admin/orders" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-amber-500 text-slate-950 font-bold">
          <span>📦</span> Pesanan Baru
        </router-link>
        <router-link to="/admin/audit-logs" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-colors" active-class="bg-amber-500 text-slate-950 font-bold">
          <span>🛡️</span> Log & Audit Trail
        </router-link>
      </nav>

      <div class="p-4 border-t border-slate-800">
        <router-link to="/" class="flex items-center gap-2 text-xs text-slate-400 hover:text-white mb-3">
          ← Kembali ke Website
        </router-link>
        <router-link to="/masuk" class="flex items-center justify-center w-full py-2 px-3 text-xs font-medium text-rose-400 hover:bg-rose-950/40 rounded-md border border-rose-900/50">
          Keluar Admin
        </router-link>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between">
        <h1 class="text-base font-semibold text-slate-800">Backoffice Administrasi</h1>
        <div class="flex items-center gap-2 text-xs text-slate-500">
          <span>Database: PostgreSQL</span>
          <span>•</span>
          <span class="text-emerald-600 font-medium">Workers: Running</span>
        </div>
      </header>

      <main class="flex-1 p-6 overflow-y-auto">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
// Admin Layout
</script>
