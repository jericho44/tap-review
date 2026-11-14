<template>
  <div class="space-y-6">
    <div>
      <h2 class="text-xl font-bold tracking-tight text-zinc-950">Materi Siap Cetak (Kartu Stand & Stiker)</h2>
      <p class="text-xs text-zinc-500 font-mono mt-0.5">
        HIGH-DENSITY QR VECTOR · READY TO PRINT (A6 / 300 DPI)
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
      <!-- Live Physical Acrylic Stand Assembly -->
      <div class="lg:col-span-6 bg-white p-6 sm:p-8 rounded-lg border border-zinc-200/90 shadow-sm flex flex-col items-center">
        <h3 class="text-[11px] font-mono font-bold uppercase tracking-wider text-zinc-400 mb-6 text-center">
          PRATINJAU KARTU STAND AKRILIK (A6)
        </h3>

        <!-- Physical Acrylic Stand Mockup -->
        <div class="flex flex-col items-center w-full">
          <div 
            class="acrylic-dark w-64 rounded-xl p-5 text-white shadow-2xl relative z-10 text-center transition-all duration-300"
            :style="{ backgroundColor: theme.primary_color || '#18181b' }"
          >
            <div class="flex items-center justify-between mb-3 border-b border-zinc-800 pb-2">
              <span class="text-[9px] font-mono text-zinc-400">SMART STAND</span>
              <div class="flex gap-0.5 text-amber-400">
                <Star v-for="i in 5" :key="i" class="w-3 h-3 fill-current" />
              </div>
            </div>

            <h3 class="font-bold text-sm tracking-tight text-white mb-1">
              {{ businessName || 'Kopi Sudut' }}
            </h3>

            <p class="text-[11px] text-zinc-300 mb-3 leading-snug px-2">
              {{ theme.call_to_action || 'Dekatkan HP Anda ke sini atau scan kode QR untuk ulasan Google' }}
            </p>

            <!-- QR Canvas inside white cutout -->
            <div class="bg-white p-2.5 rounded-lg mx-auto w-36 h-36 flex items-center justify-center shadow-inner my-2">
              <canvas ref="canvasRef" class="w-32 h-32 block"></canvas>
            </div>

            <div class="text-[9px] font-mono text-zinc-300 tracking-wider pt-2 border-t border-zinc-850">
              NFC CHIP & QR READY
            </div>
          </div>

          <!-- Base Acrylic Foot -->
          <div class="w-72 h-3.5 bg-zinc-200 rounded-sm -mt-1.5 shadow border-t border-white/60"></div>
        </div>

        <div class="mt-6 w-full max-w-xs space-y-2">
          <button 
            @click="downloadPng" 
            class="w-full py-2.5 rounded-md bg-zinc-950 hover:bg-zinc-800 text-white font-semibold text-xs uppercase tracking-wider transition shadow-sm flex items-center justify-center gap-2"
          >
            <Download class="w-4 h-4 text-orange-400" />
            <span>Unduh Berkas Cetak (PNG)</span>
          </button>
          <p class="text-center text-[10px] text-zinc-400 font-mono">
            Rekomendasi cetak: Kertas art paper / photo paper minimal 260 gsm.
          </p>
        </div>
      </div>

      <!-- Specification Details (Right) -->
      <div class="lg:col-span-6 space-y-6">
        <div class="bg-white p-6 rounded-lg border border-zinc-200/90 shadow-sm space-y-4">
          <h3 class="text-xs font-mono font-bold uppercase tracking-wider text-zinc-900 border-b border-zinc-100 pb-2">
            SPESIFIKASI TEMPLATE CETAK
          </h3>

          <div class="space-y-2.5 text-xs text-zinc-600 font-mono">
            <div class="flex justify-between py-1.5 border-b border-zinc-100">
              <span class="text-zinc-400">Nama Tema:</span>
              <span class="font-bold text-zinc-900">{{ theme.name }}</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-zinc-100">
              <span class="text-zinc-400">Ukuran Stand:</span>
              <span class="font-bold text-zinc-900">{{ theme.print_size }} (10.5 × 14.8 cm)</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-zinc-100">
              <span class="text-zinc-400">Warna Background:</span>
              <span class="font-semibold text-zinc-900 flex items-center gap-1.5">
                <span class="w-3 h-3 rounded border border-zinc-300" :style="{ backgroundColor: theme.primary_color }"></span>
                {{ theme.primary_color }}
              </span>
            </div>
            <div class="flex justify-between py-1.5">
              <span class="text-zinc-400">Target QR Link:</span>
              <span class="font-semibold text-zinc-900 truncate max-w-xs">{{ qrUrl }}</span>
            </div>
          </div>
        </div>

        <div class="bg-zinc-50 rounded-lg border border-zinc-200 p-5 space-y-2 text-xs text-zinc-700 leading-relaxed">
          <div class="flex items-center gap-2 font-mono text-[11px] font-bold text-zinc-950 uppercase">
            <Printer class="w-4 h-4 text-zinc-800" />
            <span>PANDUAN PEMASANGAN MANDIRI</span>
          </div>
          <ol class="list-decimal list-inside space-y-1.5 text-zinc-600">
            <li>Cetak berkas PNG yang telah diunduh dengan skala 100% tanpa margin printer tambahan.</li>
            <li>Potong rapi sesuai garis batas dan sisipkan ke dalam stand akrilik T-shape bening.</li>
            <li>Jika menggunakan stiker chip NFC fisik, tempelkan chip tepat di bagian belakang kartu stand.</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import QRCode from 'qrcode';
import apiClient from '@/api/client';
import type { ApiResponse } from '@/types/api';
import { Download, Printer, Star } from 'lucide-vue-next';

const businessName = ref('Kopi Sudut');
const qrUrl = ref('http://127.0.0.1:8000/r/kopisudut?src=qr');
const canvasRef = ref<HTMLCanvasElement | null>(null);

const theme = ref({
  name: 'Dark Navy & Gold',
  primary_color: '#18181b',
  accent_color: '#fbbf24',
  call_to_action: 'Dekatkan HP Anda ke sini atau scan kode QR untuk ulasan Google',
  print_size: 'A6 Stand',
});

async function fetchMaterials() {
  try {
    const res = await apiClient.get<ApiResponse<any>>('/client/materials');
    if (res.data.success && res.data.data) {
      businessName.value = res.data.data.business_name;
      qrUrl.value = res.data.data.qr_url;
      if (res.data.data.theme) {
        theme.value = res.data.data.theme;
      }
    }
  } catch (err) {
    console.error('Failed to fetch materials', err);
  } finally {
    renderQr();
  }
}

async function renderQr() {
  if (!canvasRef.value) return;
  try {
    await QRCode.toCanvas(canvasRef.value, qrUrl.value, {
      width: 140,
      margin: 1,
      color: {
        dark: '#09090b',
        light: '#ffffff',
      },
    });
  } catch (err) {
    console.error('Failed to render canvas QR', err);
  }
}

function downloadPng() {
  if (!canvasRef.value) return;
  const link = document.createElement('a');
  link.download = `${businessName.value.replace(/\s+/g, '-').toLowerCase()}-stand-review.png`;
  link.href = canvasRef.value.toDataURL('image/png');
  link.click();
}

onMounted(() => {
  fetchMaterials();
});
</script>
