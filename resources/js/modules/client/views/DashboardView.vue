<template>
  <div class="space-y-6">
    <!-- Top Greeting -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h2 class="text-xl font-bold tracking-tight text-zinc-950">
          Metrik Kunjungan: {{ summary.business_name || 'Kopi Sudut' }}
        </h2>
        <p class="text-xs text-zinc-500 font-mono mt-0.5">
          LIVE HARDWARE TELEMETRY · DATABASE SYNC
        </p>
      </div>

      <div class="flex items-center gap-2">
        <button 
          @click="fetchSummary" 
          :disabled="loading"
          class="px-3 py-1.5 rounded-md bg-white border border-zinc-300 text-zinc-700 hover:bg-zinc-50 text-xs font-semibold uppercase tracking-wider transition flex items-center gap-1.5 shadow-sm"
        >
          <RefreshCw class="w-3.5 h-3.5" :class="{'animate-spin': loading}" />
          <span>Refresh</span>
        </button>
        <router-link to="/portal/destination" class="px-3 py-1.5 rounded-md bg-white border border-zinc-300 text-xs font-semibold text-zinc-800 hover:bg-zinc-50 shadow-sm transition">
          Ganti Link Ulasan
        </router-link>
        <router-link to="/portal/materials" class="px-3.5 py-1.5 rounded-md bg-zinc-950 hover:bg-zinc-800 text-xs font-semibold uppercase tracking-wider text-white shadow-sm transition">
          Cetak Kartu Stand
        </router-link>
      </div>
    </div>

    <!-- Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <!-- Hari Ini -->
      <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-sm">
        <div class="flex items-center justify-between text-zinc-400 mb-2">
          <span class="text-[11px] font-mono font-semibold uppercase tracking-wider">HARI INI</span>
          <Calendar class="w-4 h-4 text-zinc-400" />
        </div>
        <div class="text-2xl font-mono font-extrabold text-zinc-950">{{ summary.today_taps }}</div>
        <div class="text-[11px] text-zinc-500 mt-1 font-mono">
          {{ summary.today_taps > 0 ? '+ Interaksi tercatat' : 'Belum ada kunjungan' }}
        </div>
      </div>

      <!-- 7 Hari Terakhir -->
      <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-sm">
        <div class="flex items-center justify-between text-zinc-400 mb-2">
          <span class="text-[11px] font-mono font-semibold uppercase tracking-wider">7 HARI TERAKHIR</span>
          <TrendingUp class="w-4 h-4 text-zinc-400" />
        </div>
        <div class="text-2xl font-mono font-extrabold text-zinc-950">{{ summary.last_7_days }}</div>
        <div class="text-[11px] text-zinc-500 mt-1 font-mono">Total tap seminggu</div>
      </div>

      <!-- 30 Hari Terakhir -->
      <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-sm">
        <div class="flex items-center justify-between text-zinc-400 mb-2">
          <span class="text-[11px] font-mono font-semibold uppercase tracking-wider">30 HARI TERAKHIR</span>
          <Radio class="w-4 h-4 text-orange-600" />
        </div>
        <div class="text-2xl font-mono font-extrabold text-zinc-950">{{ summary.last_30_days }}</div>
        <div class="text-[11px] text-emerald-600 font-medium mt-1 font-mono">Pelanggan dialihkan</div>
      </div>

      <!-- Rasio Sumber -->
      <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-sm">
        <div class="flex items-center justify-between text-zinc-400 mb-2">
          <span class="text-[11px] font-mono font-semibold uppercase tracking-wider">RASIO JALUR</span>
          <QrCode class="w-4 h-4 text-zinc-400" />
        </div>
        <div class="text-2xl font-mono font-extrabold text-zinc-950">{{ summary.nfc_percentage }}% NFC</div>
        <div class="text-[11px] text-zinc-500 mt-1 font-mono">{{ summary.qr_percentage }}% Scan QR</div>
      </div>
    </div>

    <!-- Visual Chart & Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <div class="lg:col-span-8 bg-white p-6 rounded-lg border border-zinc-200/90 shadow-sm">
        <div class="flex items-center justify-between mb-4 border-b border-zinc-100 pb-3">
          <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-zinc-900">
            DISTRIBUSI TAP HARIAN (7 HARI)
          </h3>
          <span class="text-[11px] font-mono text-zinc-400">SUMBER: NFC & QR COMBINED</span>
        </div>

        <div class="h-44 flex items-end justify-between gap-3 pt-6 border-b border-zinc-100 pb-2">
          <div v-for="(day, idx) in chartDays" :key="idx" class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
            <span class="text-[10px] font-mono text-zinc-600 font-bold">{{ day.taps }}</span>
            <div class="w-full bg-zinc-100 rounded-t relative flex flex-col justify-end overflow-hidden max-w-[40px]" :style="{ height: '100px' }">
              <div 
                class="w-full bg-zinc-900 hover:bg-orange-600 rounded-t transition-colors duration-300" 
                :style="{ height: calculateHeight(day.taps) }"
              ></div>
            </div>
            <span class="text-[11px] font-mono text-zinc-600 uppercase font-semibold">{{ day.label }}</span>
          </div>
        </div>
      </div>

      <div class="lg:col-span-4 bg-white p-6 rounded-lg border border-zinc-200/90 shadow-sm flex flex-col justify-between">
        <div>
          <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-zinc-900 mb-2">
            TARGET URL ULASAN AKTIF
          </h3>
          <p class="text-xs text-zinc-500 mb-4 leading-relaxed">
            Semua chip NFC & kode QR di meja kasir Anda saat ini mengarah ke endpoint ini:
          </p>
          <div class="p-3 bg-zinc-50 rounded border border-zinc-200 text-xs text-zinc-900 font-mono break-all mb-4 select-all">
            {{ summary.current_destination || 'https://maps.app.goo.gl/kopi-sudut-official' }}
          </div>
        </div>

        <router-link 
          to="/portal/destination" 
          class="w-full py-2 rounded-md border border-zinc-300 hover:border-zinc-900 text-zinc-900 text-center text-xs font-semibold uppercase tracking-wider transition"
        >
          Konfigurasi Target URL →
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import apiClient from '@/api/client';
import type { ApiResponse } from '@/types/api';
import { Calendar, TrendingUp, Radio, QrCode, RefreshCw } from 'lucide-vue-next';

interface DayActivity {
  label: string;
  date: string;
  taps: number;
}

interface SummaryData {
  business_name: string;
  slug: string;
  today_taps: number;
  last_7_days: number;
  last_30_days: number;
  total_taps: number;
  nfc_percentage: number;
  qr_percentage: number;
  current_destination: string;
  chart_days?: DayActivity[];
}

const loading = ref(false);
const summary = ref<SummaryData>({
  business_name: '',
  slug: '',
  today_taps: 0,
  last_7_days: 0,
  last_30_days: 0,
  total_taps: 0,
  nfc_percentage: 50,
  qr_percentage: 50,
  current_destination: '',
});

const chartDays = ref<DayActivity[]>([
  { label: 'Min', date: '', taps: 0 },
  { label: 'Sen', date: '', taps: 0 },
  { label: 'Sel', date: '', taps: 0 },
  { label: 'Rab', date: '', taps: 0 },
  { label: 'Kam', date: '', taps: 0 },
  { label: 'Jum', date: '', taps: 0 },
  { label: 'Sab', date: '', taps: 0 },
]);

function calculateHeight(taps: number): string {
  const max = Math.max(...chartDays.value.map(d => d.taps), 4);
  const percentage = Math.round((taps / max) * 100);
  return `${Math.max(percentage, 8)}%`;
}

async function fetchSummary() {
  loading.value = true;
  try {
    const res = await apiClient.get<ApiResponse<SummaryData>>('/client/dashboard/summary');
    if (res.data.success && res.data.data) {
      summary.value = res.data.data;
      if (res.data.data.chart_days && res.data.data.chart_days.length > 0) {
        chartDays.value = res.data.data.chart_days;
      }
    }
  } catch (err) {
    console.error('Failed to fetch summary', err);
  } finally {
    loading.value = false;
  }
}

onMounted(() => {
  fetchSummary();
});
</script>
