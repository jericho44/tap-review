<template>
  <div class="space-y-6">
    <div>
      <h2 class="text-xl font-bold text-slate-900">Materi Cetak QR Mandiri</h2>
      <p class="text-xs text-slate-500">Unduh kartu QR beresolusi tinggi siap cetak untuk cadangan atau cetak tambahan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
      <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col items-center">
        <div class="w-64 rounded-xl bg-slate-900 text-white p-5 text-center shadow-lg mb-4">
          <div class="text-xs font-bold text-amber-400 mb-1">★★★★★</div>
          <div class="font-extrabold text-sm mb-1">Kopi Sudut</div>
          <p class="text-[10px] text-slate-300 mb-3">Scan atau tap HP Anda di sini untuk ulasan Google</p>
          <div class="bg-white p-3 rounded-lg mx-auto w-36 h-36 flex items-center justify-center">
            <canvas ref="canvasRef" class="w-32 h-32 block"></canvas>
          </div>
          <div class="mt-3 text-[9px] text-slate-400 font-mono">STAND MEJA RESMI</div>
        </div>

        <button @click="downloadCard" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm transition">
          Unduh File Cetak (PNG)
        </button>
      </div>

      <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-sm font-bold text-slate-900 mb-2">Panduan Cetak Mandiri</h3>
        <ul class="text-xs text-slate-600 space-y-2 leading-relaxed">
          <li>• Gunakan kertas foto atau art paper minimal 260 gsm untuk hasil terbaik.</li>
          <li>• Ukuran rekomendasi kartu meja adalah A6 (10.5 x 14.8 cm).</li>
          <li>• Masukkan ke dalam stand akrilik bening model T-shape atau L-shape.</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import QRCode from 'qrcode';

const canvasRef = ref<HTMLCanvasElement | null>(null);

onMounted(async () => {
  if (canvasRef.value) {
    await QRCode.toCanvas(canvasRef.value, 'https://tapin.id/kopisudut?src=qr', {
      width: 128,
      margin: 1,
    });
  }
});

function downloadCard() {
  if (!canvasRef.value) return;
  const link = document.createElement('a');
  link.download = 'kopisudut-stand-qr.png';
  link.href = canvasRef.value.toDataURL('image/png');
  link.click();
}
</script>
