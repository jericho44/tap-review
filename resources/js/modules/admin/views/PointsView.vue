<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Titik & Status Chip NFC</h2>
        <p class="text-xs text-slate-500">Pencatatan UID chip NTAG213, status penguncian, dan pengujian titik.</p>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
          <tr>
            <th class="py-3 px-4">Kode Titik</th>
            <th class="py-3 px-4">Klien</th>
            <th class="py-3 px-4">NFC Chip UID</th>
            <th class="py-3 px-4">Status Chip</th>
            <th class="py-3 px-4">Status Fisik</th>
            <th class="py-3 px-4">Uji Tap</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          <tr v-for="point in points" :key="point.code" class="hover:bg-slate-50/60">
            <td class="py-3 px-4 font-mono font-medium text-indigo-600">{{ point.code }}</td>
            <td class="py-3 px-4 font-semibold text-slate-900">{{ point.client }}</td>
            <td class="py-3 px-4 font-mono text-slate-500">{{ point.uid }}</td>
            <td class="py-3 px-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800">
                {{ point.chip_status }}
              </span>
            </td>
            <td class="py-3 px-4">{{ point.physical_status }}</td>
            <td class="py-3 px-4 text-emerald-600 font-medium">✓ Lolos Uji (iOS & Android)</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const points = ref([
  { code: 'KPS-001', client: 'Kopi Sudut', uid: '04:7A:B2:91:3F:80', chip_status: 'Terkunci (Locked)', physical_status: 'Terpasang' },
  { code: 'KPS-002', client: 'Kopi Sudut', uid: '04:88:C1:92:4A:81', chip_status: 'Terkunci (Locked)', physical_status: 'Terpasang' },
  { code: 'MBR-001', client: 'Barbershop Masbro', uid: '04:12:33:AA:BB:CC', chip_status: 'Terkunci (Locked)', physical_status: 'Terpasang' },
]);
</script>
