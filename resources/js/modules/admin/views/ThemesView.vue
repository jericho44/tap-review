<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Katalog Tema Desain Stiker</h2>
        <p class="text-xs text-slate-500">Pilihan template kartu akrilik & stiker meja untuk dicetak klien.</p>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div v-for="theme in themes" :key="theme.name" class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm flex flex-col justify-between">
        <div class="p-4" :style="{ backgroundColor: theme.bg, color: theme.color }">
          <div class="text-[10px] uppercase font-bold tracking-wider opacity-75 mb-1">{{ theme.size }}</div>
          <div class="font-extrabold text-sm mb-1">{{ theme.name }}</div>
          <div class="text-xs text-amber-300">★★★★★</div>
          <div class="mt-4 p-2 bg-white/10 rounded-lg text-center text-[10px]">
            QR Placeholder
          </div>
        </div>

        <div class="p-4">
          <h4 class="text-xs font-bold text-slate-900 mb-1">{{ theme.name }}</h4>
          <p class="text-[11px] text-slate-500 mb-3">{{ theme.desc }}</p>
          <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700">
            Aktif
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const themes = ref([
  { name: 'Dark Navy & Gold', bg: '#0f172a', color: '#ffffff', size: 'A6 Stand', desc: 'Gaya modern elegan untuk kafe & resto kekinian.' },
  { name: 'Pure Minimalist Light', bg: '#f8fafc', color: '#0f172a', size: 'A6 Stand', desc: 'Gaya minimalis bersih cocok untuk klinik & salon.' },
  { name: 'Coffee Artisan Brown', bg: '#451a03', color: '#fef3c7', size: 'Stiker Bulat 8cm', desc: 'Nuansa hangat kayu dan biji kopi.' },
  { name: 'Luxury Emerald', bg: '#064e3b', color: '#ecfdf5', size: 'A6 Stand', desc: 'Nuansa premium eksklusif untuk hotel & butik.' },
]);
</script>
