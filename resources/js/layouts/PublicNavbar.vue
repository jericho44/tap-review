<template>
  <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-zinc-200/90">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <!-- Brand Logo -->
      <router-link to="/" class="flex items-center gap-3 group">
        <div class="w-8 h-8 rounded-lg bg-zinc-950 border border-zinc-800 flex items-center justify-center text-white font-mono font-bold text-sm tracking-wider shadow-sm group-hover:border-zinc-600 transition-colors">
          TR
        </div>
        <div class="flex flex-col">
          <div class="flex items-center gap-1.5">
            <span class="font-bold text-sm tracking-tight text-zinc-900 uppercase">TapReview</span>
            <span class="w-1.5 h-1.5 rounded-full bg-orange-600"></span>
          </div>
          <span class="text-[10px] text-zinc-600 font-mono tracking-wider">HARDWARE & NFC LABS</span>
        </div>
      </router-link>

      <!-- Nav Links -->
      <nav class="hidden md:flex items-center gap-7 text-xs font-semibold uppercase tracking-wider text-zinc-600">
        <router-link to="/" class="hover:text-zinc-950 transition-colors" active-class="text-zinc-950 font-bold">Produk</router-link>
        <router-link to="/generator" class="hover:text-zinc-950 transition-colors" active-class="text-zinc-950 font-bold">Generator QR</router-link>
        <router-link to="/harga" class="hover:text-zinc-950 transition-colors" active-class="text-zinc-950 font-bold">Stand & Harga</router-link>
        <router-link to="/demo" class="hover:text-zinc-950 transition-colors" active-class="text-zinc-950 font-bold">Alur Tap</router-link>
      </nav>

      <!-- Action Buttons -->
      <div class="flex items-center gap-2.5">
        <router-link 
          to="/masuk" 
          class="text-xs font-semibold uppercase tracking-wider text-zinc-700 hover:text-zinc-950 px-3 py-2 rounded-md hover:bg-zinc-100 transition-colors"
        >
          Portal Klien
        </router-link>
        <router-link 
          to="/pesan" 
          class="text-xs font-semibold uppercase tracking-wider text-white bg-zinc-950 hover:bg-zinc-800 px-4 py-2 rounded-md shadow-sm border border-zinc-800 transition-all flex items-center gap-1.5"
        >
          <span>Pesan Stand</span>
          <span class="text-orange-400">→</span>
        </router-link>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
// Industrial Navbar
</script>
