<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold tracking-tight text-zinc-950">Titik & Status Chip NFC</h2>
        <p class="text-xs text-zinc-500 font-mono mt-0.5">MANAJEMEN CHIP UID NTAG213 & STATUS HARDWARE</p>
      </div>
    </div>

    <div class="bg-white rounded-lg border border-zinc-200/90 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 font-mono font-semibold uppercase text-[10px]">
          <tr>
            <th class="py-3 px-4">KODE TITIK</th>
            <th class="py-3 px-4">KLIEN</th>
            <th class="py-3 px-4">NFC CHIP UID</th>
            <th class="py-3 px-4">STATUS CHIP</th>
            <th class="py-3 px-4">STATUS FISIK</th>
            <th class="py-3 px-4">UJI HARDWARE</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-zinc-100 text-zinc-700">
          <tr v-for="point in points" :key="point.code" class="hover:bg-zinc-50/70 transition">
            <td class="py-3 px-4 font-mono font-bold text-zinc-950">{{ point.code }}</td>
            <td class="py-3 px-4 font-semibold text-zinc-900">{{ point.client }}</td>
            <td class="py-3 px-4 font-mono text-zinc-500">{{ point.uid }}</td>
            <td class="py-3 px-4 font-mono text-[11px]">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-emerald-50 text-emerald-800 border border-emerald-200">
                {{ point.chip_status }}
              </span>
            </td>
            <td class="py-3 px-4 font-mono text-[11px] text-zinc-600">{{ point.physical_status }}</td>
            <td class="py-3 px-4 text-emerald-700 font-mono text-[11px] font-medium flex items-center gap-1.5">
              <Check class="w-3.5 h-3.5" />
              <span>PASSED (iOS/Android)</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Check } from 'lucide-vue-next';

const points = ref([
  { code: 'KPS-001', client: 'Kopi Sudut', uid: '04:7A:B2:91:3F:80', chip_status: 'LOCKED', physical_status: 'Installed' },
  { code: 'KPS-002', client: 'Kopi Sudut', uid: '04:88:C1:92:4A:81', chip_status: 'LOCKED', physical_status: 'Installed' },
  { code: 'MBR-001', client: 'Barbershop Masbro', uid: '04:12:33:AA:BB:CC', chip_status: 'LOCKED', physical_status: 'Installed' },
]);
</script>
