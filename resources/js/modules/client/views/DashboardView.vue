<template>
  <div class="space-y-6">
    <!-- Top Greeting -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Ringkasan Ulasan & Kunjungan</h2>
        <p class="text-xs text-slate-500">Data analitik tap NFC dan scan QR usaha Anda secara realtime.</p>
      </div>

      <div class="flex items-center gap-2">
        <router-link to="/portal/destination" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-sm transition">
          Ganti Link Ulasan
        </router-link>
        <router-link to="/portal/materials" class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-semibold text-white shadow-sm transition">
          Cetak Materi QR
        </router-link>
      </div>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center justify-between text-slate-400 mb-2">
          <span class="text-xs font-semibold uppercase">Hari Ini</span>
          <span class="text-base">📅</span>
        </div>
        <div class="text-2xl font-extrabold text-slate-900">28</div>
        <div class="text-[11px] text-emerald-600 font-medium mt-1">↑ 14% dari kemarin</div>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center justify-between text-slate-400 mb-2">
          <span class="text-xs font-semibold uppercase">7 Hari Terakhir</span>
          <span class="text-base">📈</span>
        </div>
        <div class="text-2xl font-extrabold text-slate-900">194</div>
        <div class="text-[11px] text-slate-500 mt-1">Rata-rata 27 tap/hari</div>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center justify-between text-slate-400 mb-2">
          <span class="text-xs font-semibold uppercase">30 Hari Terakhir</span>
          <span class="text-base">🚀</span>
        </div>
        <div class="text-2xl font-extrabold text-indigo-600">812</div>
        <div class="text-[11px] text-emerald-600 font-medium mt-1">↑ 22 ulasan baru di Google</div>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center justify-between text-slate-400 mb-2">
          <span class="text-xs font-semibold uppercase">Sumber Terbanyak</span>
          <span class="text-base">📲</span>
        </div>
        <div class="text-2xl font-extrabold text-slate-900">62% NFC</div>
        <div class="text-[11px] text-slate-500 mt-1">38% dari scan kode QR</div>
      </div>
    </div>

    <!-- Simple Visual Chart & Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 mb-4">Aktivitas Tap 7 Hari Terakhir</h3>
        <div class="h-44 flex items-end justify-between gap-2 pt-6">
          <div v-for="(day, idx) in chartDays" :key="idx" class="flex-1 flex flex-col items-center gap-2">
            <div class="w-full bg-slate-100 rounded-t-lg relative flex flex-col justify-end overflow-hidden" :style="{ height: '120px' }">
              <div 
                class="w-full bg-indigo-600 rounded-t-md transition-all duration-500" 
                :style="{ height: `${(day.taps / 40) * 100}%` }"
              ></div>
            </div>
            <span class="text-[10px] text-slate-400 font-medium">{{ day.label }}</span>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col justify-between">
        <div>
          <h3 class="text-sm font-bold text-slate-900 mb-3">Link Ulasan Terpasang</h3>
          <p class="text-xs text-slate-500 mb-4 leading-relaxed">
            Semua stiker di meja kasir dan meja makan saat ini mengarah ke:
          </p>
          <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-700 font-mono break-all mb-4">
            https://maps.app.goo.gl/kopi-sudut-official
          </div>
        </div>

        <router-link to="/portal/destination" class="w-full py-2.5 rounded-xl border border-indigo-200 text-indigo-600 text-center text-xs font-semibold hover:bg-indigo-50 transition">
          Ubah URL Tujuan →
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const chartDays = ref([
  { label: 'Sen', taps: 22 },
  { label: 'Sel', taps: 19 },
  { label: 'Rab', taps: 28 },
  { label: 'Kam', taps: 31 },
  { label: 'Jum', taps: 38 },
  { label: 'Sab', taps: 35 },
  { label: 'Min', taps: 28 },
]);
</script>
