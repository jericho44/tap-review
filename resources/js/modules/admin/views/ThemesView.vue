<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold tracking-tight text-zinc-950">Katalog Desain Stand Meja</h2>
        <p class="text-xs text-zinc-500 font-mono mt-0.5">TEMPLATE DESAIN AKRILIK & STIKER ROUND/CARD</p>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div v-for="theme in themes" :key="theme.name" class="bg-white rounded-lg border border-zinc-200/90 overflow-hidden shadow-sm flex flex-col justify-between">
        <div class="p-5 flex flex-col items-center text-center" :style="{ backgroundColor: theme.bg, color: theme.color }">
          <div class="text-[9px] font-mono uppercase tracking-widest opacity-60 mb-2">{{ theme.size }}</div>
          <div class="font-bold text-sm mb-1 tracking-tight">{{ theme.name }}</div>
          <div class="flex gap-0.5 text-amber-400 mb-4">
            <Star v-for="i in 5" :key="i" class="w-3 h-3 fill-current" />
          </div>
          <div class="p-2 bg-white/10 rounded border border-white/20 text-center text-[10px] font-mono">
            QR CODE CUTOUT
          </div>
        </div>

        <div class="p-4 bg-zinc-50 border-t border-zinc-100">
          <h4 class="text-xs font-bold text-zinc-950 mb-1">{{ theme.name }}</h4>
          <p class="text-[11px] text-zinc-500 mb-3 leading-relaxed">{{ theme.desc }}</p>
          <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold uppercase bg-zinc-200 text-zinc-800">
            PRODUKSI AKTIF
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Star } from 'lucide-vue-next';

const themes = ref([
  { name: 'Dark Navy & Gold', bg: '#09090b', color: '#ffffff', size: 'A6 Stand (Acrylic)', desc: 'Desain elegan kontras tinggi untuk kafe & bar modern.' },
  { name: 'Pure Minimalist Light', bg: '#f8fafc', color: '#09090b', size: 'A6 Stand (Acrylic)', desc: 'Desain bersih presisi untuk klinik estetika & salon.' },
  { name: 'Coffee Artisan Brown', bg: '#271c19', color: '#fef3c7', size: 'Round-8cm Sticker', desc: 'Nuansa hangat kayu dan biji kopi specialty.' },
  { name: 'Luxury Emerald', bg: '#062c22', color: '#ecfdf5', size: 'A6 Stand (Acrylic)', desc: 'Gaya premium eksklusif untuk butik dan hotel.' },
]);
</script>
