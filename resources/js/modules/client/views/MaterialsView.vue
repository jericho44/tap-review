<template>
  <div class="space-y-6">
    <div>
      <h2 class="text-xl font-bold text-slate-900">Materi Siap Cetak (Kartu & Stiker)</h2>
      <p class="text-xs text-slate-500">
        Unduh kartu stand akrilik dan QR resolusi tinggi yang telah dipersonalisasi dengan tema usaha Anda.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
      <!-- Live Card Canvas Preview -->
      <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center">
        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-6">
          Pratinjau Kartu Stand Meja (Ukuran {{ theme.print_size || 'A6' }})
        </h3>

        <div 
          class="w-72 rounded-2xl text-white p-6 shadow-2xl flex flex-col items-center text-center relative overflow-hidden transition-all duration-300"
          :style="{ backgroundColor: theme.primary_color || '#0f172a' }"
        >
          <div 
            class="w-10 h-10 rounded-full flex items-center justify-center text-xl mb-2"
            :style="{ backgroundColor: 'rgba(255, 255, 255, 0.1)' }"
          >
            ⭐
          </div>

          <h3 class="font-extrabold text-base tracking-tight mb-1 text-white">
            {{ businessName || 'Kopi Sudut' }}
          </h3>

          <div 
            class="flex items-center gap-1 text-xs mb-3 font-bold"
            :style="{ color: theme.accent_color || '#fbbf24' }"
          >
            ★★★★★
          </div>

          <p class="text-xs text-slate-200 mb-4 px-2 leading-relaxed">
            {{ theme.call_to_action || 'Puas dengan pelayanan kami? Tap atau scan untuk ulasan Google!' }}
          </p>

          <!-- QR Code Canvas -->
          <div class="bg-white p-3 rounded-xl shadow-inner mb-3">
            <canvas ref="canvasRef" class="w-36 h-36 block"></canvas>
          </div>

          <div class="flex items-center gap-2 text-[10px] text-slate-400 font-mono">
            <span>SMART NFC & QR REVIEW</span>
          </div>
        </div>

        <div class="mt-6 w-full max-w-xs space-y-2">
          <button 
            @click="downloadPng" 
            class="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs shadow-md shadow-indigo-100 transition flex items-center justify-center gap-2"
          >
            <span>💾</span> Unduh Berkas Cetak (PNG)
          </button>
          <p class="text-center text-[10px] text-slate-400">
            Dapat langsung dicetak pada kertas foto art paper 260 gsm.
          </p>
        </div>
      </div>

      <!-- Info & Print Specification -->
      <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h3 class="text-sm font-bold text-slate-900 mb-3">Informasi Tema Desain</h3>
          <div class="space-y-2.5 text-xs text-slate-600">
            <div class="flex justify-between py-1.5 border-b border-slate-100">
              <span class="text-slate-400">Nama Tema:</span>
              <span class="font-semibold text-slate-800">{{ theme.name }}</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-slate-100">
              <span class="text-slate-400">Ukuran Rekomendasi:</span>
              <span class="font-semibold text-slate-800">{{ theme.print_size }} (10.5 x 14.8 cm)</span>
            </div>
            <div class="flex justify-between py-1.5 border-b border-slate-100">
              <span class="text-slate-400">Warna Utama:</span>
              <span class="font-mono text-slate-800 font-semibold flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full border border-slate-300" :style="{ backgroundColor: theme.primary_color }"></span>
                {{ theme.primary_color }}
              </span>
            </div>
            <div class="flex justify-between py-1.5">
              <span class="text-slate-400">Warna Bintang / Aksen:</span>
              <span class="font-mono text-slate-800 font-semibold flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full border border-slate-300" :style="{ backgroundColor: theme.accent_color }"></span>
                {{ theme.accent_color }}
              </span>
            </div>
          </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h3 class="text-sm font-bold text-slate-900 mb-2">Panduan Pasang Sendiri</h3>
          <ol class="text-xs text-slate-600 space-y-2 list-decimal list-inside leading-relaxed">
            <li>Cetak berkas PNG yang telah diunduh dengan rasio 100%.</li>
            <li>Gunting sesuai garis batas dan masukkan ke stand akrilik meja.</li>
            <li>Jika memasang stiker chip NFC, tempelkan chip di belakang stand tepat di area logo bintang.</li>
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

const businessName = ref('Kopi Sudut');
const qrUrl = ref('http://127.0.0.1:8000/r/kopisudut?src=qr');
const canvasRef = ref<HTMLCanvasElement | null>(null);

const theme = ref({
  name: 'Dark Navy & Gold',
  primary_color: '#0f172a',
  accent_color: '#fbbf24',
  call_to_action: 'Puas dengan pelayanan kami? Tap atau scan untuk ulasan Google!',
  print_size: 'A6',
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
      width: 144,
      margin: 1,
      color: {
        dark: '#0f172a',
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
