<template>
  <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <router-link to="/" class="flex items-center gap-2 group">
        <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-md shadow-indigo-200 group-hover:scale-105 transition-transform">
          T
        </div>
        <div class="flex flex-col">
          <span class="font-extrabold text-lg tracking-tight text-slate-900 leading-tight">Tap<span class="text-indigo-600">Review</span></span>
          <span class="text-[10px] text-slate-500 font-medium">Smart Google Reviews</span>
        </div>
      </router-link>

      <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
        <router-link to="/" class="hover:text-indigo-600 transition-colors" active-class="text-indigo-600 font-semibold">Beranda</router-link>
        <router-link to="/generator" class="hover:text-indigo-600 transition-colors" active-class="text-indigo-600 font-semibold">Generator QR Gratis</router-link>
        <router-link to="/harga" class="hover:text-indigo-600 transition-colors" active-class="text-indigo-600 font-semibold">Paket & Harga</router-link>
        <router-link to="/demo" class="hover:text-indigo-600 transition-colors" active-class="text-indigo-600 font-semibold">Demo Pelanggan</router-link>
      </nav>

      <div class="flex items-center gap-3">
        <router-link to="/masuk" class="text-sm font-medium text-slate-700 hover:text-indigo-600 px-3 py-2 transition-colors">
          Masuk Portal
        </router-link>
        <router-link to="/pesan" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-xl shadow-sm shadow-indigo-200 transition-all hover:shadow-md">
          Pesan Stiker
        </router-link>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
// Public Navbar
</script>
