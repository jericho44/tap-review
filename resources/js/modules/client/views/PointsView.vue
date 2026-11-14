<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Titik Stiker (NFC & QR)</h2>
        <p class="text-xs text-slate-500">Daftar lokasi stiker yang terpasang di tempat usaha Anda.</p>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
          <tr>
            <th class="py-3 px-4">Kode Titik</th>
            <th class="py-3 px-4">Lokasi</th>
            <th class="py-3 px-4">Tap NFC</th>
            <th class="py-3 px-4">Scan QR</th>
            <th class="py-3 px-4">Total</th>
            <th class="py-3 px-4">Status Fisik</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          <tr v-for="point in points" :key="point.code" class="hover:bg-slate-50/60">
            <td class="py-3 px-4 font-mono font-medium text-indigo-600">{{ point.code }}</td>
            <td class="py-3 px-4 font-semibold text-slate-900">{{ point.location }}</td>
            <td class="py-3 px-4">{{ point.nfc }} tap</td>
            <td class="py-3 px-4">{{ point.qr }} scan</td>
            <td class="py-3 px-4 font-bold text-slate-900">{{ point.nfc + point.qr }}</td>
            <td class="py-3 px-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800">
                Terpasang
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const points = ref([
  { code: 'KPS-001', location: 'Meja Kasir Utama', nfc: 342, qr: 189 },
  { code: 'KPS-002', location: 'Meja Makan 01 (Indoor)', nfc: 120, qr: 98 },
  { code: 'KPS-003', location: 'Meja Makan 02 (Indoor)', nfc: 115, qr: 88 },
  { code: 'KPS-004', location: 'Area Outdoor Depan', nfc: 94, qr: 72 },
]);
</script>
