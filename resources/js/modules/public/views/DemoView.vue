<template>
  <PublicLayout>
    <div class="py-16 bg-zinc-950 text-white min-h-[80vh] flex items-center justify-center border-b border-zinc-800">
      <div class="max-w-md w-full mx-auto px-4 text-center">
        <!-- Hardware Terminal Frame Mockup -->
        <div class="bg-zinc-900 border border-zinc-800 rounded-xl p-7 shadow-2xl relative overflow-hidden">
          <div class="flex items-center justify-between pb-4 border-b border-zinc-800 mb-6 text-[10px] font-mono text-zinc-400">
            <span class="flex items-center gap-1.5">
              <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
              DIAGNOSTIC TEST RUNNER
            </span>
            <span>NTAG213 PROTOCOL</span>
          </div>

          <div class="w-12 h-12 rounded-lg bg-orange-950/60 border border-orange-800/80 text-orange-400 flex items-center justify-center mx-auto mb-4">
            <Radio class="w-6 h-6 animate-pulse" />
          </div>

          <h2 class="text-lg font-bold tracking-tight text-white mb-1">
            Mengarahkan ke Google Maps...
          </h2>
          <p class="text-xs text-zinc-400 mb-6">
            Membuka dialog ulasan resmi untuk <strong class="text-zinc-200">Kopi Sudut</strong>
          </p>

          <div class="p-4 rounded-md bg-zinc-950 border border-zinc-850 mb-6 text-left space-y-2.5 font-mono text-xs">
            <div class="flex justify-between">
              <span class="text-zinc-500">Jalur Masuk:</span>
              <span class="text-emerald-400 font-medium">NFC Tap (Meja Kasir KPS-001)</span>
            </div>
            <div class="flex justify-between">
              <span class="text-zinc-500">Redirect Latency:</span>
              <span class="text-orange-400">0.08 detik (In-Memory Cache)</span>
            </div>
            <div class="flex justify-between">
              <span class="text-zinc-500">Status Integritas:</span>
              <span class="text-zinc-300">Verified Google Domain</span>
            </div>
          </div>

          <a 
            href="https://maps.google.com" 
            target="_blank" 
            class="block w-full py-2.5 bg-white hover:bg-zinc-100 text-zinc-950 font-semibold text-xs uppercase tracking-wider rounded-md transition"
          >
            Lanjut ke Ulasan Google →
          </a>

          <div class="mt-4 text-[10px] font-mono text-zinc-500">
            SIMULASI PENGUJIAN JALUR PELANGGAN
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Radio } from 'lucide-vue-next';
</script>
