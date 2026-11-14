<template>
  <PublicLayout>
    <div class="py-16 bg-slate-900 text-white min-h-[80vh] flex items-center justify-center">
      <div class="max-w-md w-full mx-auto px-4 text-center">
        <!-- Phone Frame Mockup -->
        <div class="bg-slate-950 border-4 border-slate-700 rounded-[2.5rem] p-6 shadow-2xl relative overflow-hidden">
          <div class="w-24 h-4 bg-slate-800 rounded-full mx-auto mb-6"></div>

          <div class="w-16 h-16 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-3xl mx-auto mb-4 animate-pulse">
            ⚡
          </div>

          <h2 class="text-xl font-bold mb-1">Mengarahkan ke Google Review...</h2>
          <p class="text-xs text-slate-400 mb-6">
            Membuka halaman ulasan resmi untuk <strong class="text-white">Kopi Sudut</strong>
          </p>

          <div class="p-4 rounded-xl bg-slate-900 border border-slate-800 mb-6 text-left space-y-2">
            <div class="flex justify-between text-xs text-slate-400">
              <span>Metode Masuk:</span>
              <span class="text-emerald-400 font-mono font-semibold">NFC Tap (Meja Kasir)</span>
            </div>
            <div class="flex justify-between text-xs text-slate-400">
              <span>Waktu Pengalihan:</span>
              <span class="text-indigo-400 font-mono">0.08 detik</span>
            </div>
            <div class="flex justify-between text-xs text-slate-400">
              <span>Status Link:</span>
              <span class="text-emerald-400 font-medium">Google Verified</span>
            </div>
          </div>

          <a 
            href="https://maps.google.com" 
            target="_blank" 
            class="block w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs rounded-xl shadow-lg transition"
          >
            Lanjut ke Halaman Ulasan Google →
          </a>

          <div class="mt-4 text-[10px] text-slate-500">
            *Ini adalah halaman simulasi yang dilihat pelanggan saat melakukan tap.
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>
