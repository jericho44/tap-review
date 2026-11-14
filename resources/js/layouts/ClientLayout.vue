<template>
  <div class="min-h-screen flex bg-zinc-100">
    <!-- Industrial Sidebar -->
    <aside class="w-64 bg-zinc-950 text-white flex flex-col shrink-0 border-r border-zinc-800">
      <div class="h-16 flex items-center px-6 border-b border-zinc-850 justify-between">
        <div class="flex items-center gap-2.5">
          <div class="w-7 h-7 rounded bg-white text-zinc-950 font-mono font-bold text-xs flex items-center justify-center">
            TR
          </div>
          <div>
            <div class="font-bold text-xs tracking-tight uppercase">Portal Klien</div>
            <div class="text-[10px] text-zinc-400 font-mono">KOPI SUDUT</div>
          </div>
        </div>
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" title="System Online"></span>
      </div>

      <nav class="p-3 space-y-1 flex-1 text-xs font-medium">
        <router-link 
          to="/portal" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <LayoutDashboard class="w-4 h-4 text-zinc-400" />
          <span>Ringkasan Tap</span>
        </router-link>

        <router-link 
          to="/portal/points" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <Tag class="w-4 h-4 text-zinc-400" />
          <span>Titik Stiker (NFC/QR)</span>
        </router-link>

        <router-link 
          to="/portal/destination" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <Link2 class="w-4 h-4 text-zinc-400" />
          <span>Link Ulasan Google</span>
        </router-link>

        <router-link 
          to="/portal/materials" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <Printer class="w-4 h-4 text-zinc-400" />
          <span>Materi Siap Cetak</span>
        </router-link>
      </nav>

      <div class="p-4 border-t border-zinc-850 space-y-2">
        <router-link to="/" class="flex items-center gap-2 text-xs text-zinc-400 hover:text-white transition-colors">
          <ArrowLeft class="w-3.5 h-3.5" />
          <span>Kembali ke Website</span>
        </router-link>
        <router-link to="/masuk" class="flex items-center justify-center gap-1.5 w-full py-1.5 px-3 text-[11px] font-semibold text-rose-400 hover:bg-rose-950/30 rounded border border-rose-900/40 transition">
          <LogOut class="w-3.5 h-3.5" />
          <span>Keluar Sesi</span>
        </router-link>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="h-16 bg-white border-b border-zinc-200 px-6 flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs font-mono text-zinc-500 uppercase">
          <span>PORTAL</span>
          <span>/</span>
          <span class="text-zinc-900 font-bold">TERMINAL PELAPORAN</span>
        </div>
        <div class="flex items-center gap-3">
          <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-mono font-medium bg-emerald-50 text-emerald-800 border border-emerald-200">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
            STATUS: AKTIF
          </span>
          <span class="text-xs font-mono text-zinc-400">PAKET KAFE & RESTO</span>
        </div>
      </header>

      <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { LayoutDashboard, Tag, Link2, Printer, ArrowLeft, LogOut } from 'lucide-vue-next';
</script>
