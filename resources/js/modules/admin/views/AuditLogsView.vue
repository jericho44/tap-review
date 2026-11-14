<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Log Aktivitas & Audit Trail</h2>
        <p class="text-xs text-slate-500">Rekam jejak perubahan link tujuan ulasan dan tindakan penting sistem.</p>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
          <tr>
            <th class="py-3 px-4">Waktu (UTC+7)</th>
            <th class="py-3 px-4">Pelaku / Aktor</th>
            <th class="py-3 px-4">Entitas Klien</th>
            <th class="py-3 px-4">Aktivitas</th>
            <th class="py-3 px-4">Detail Perubahan</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          <tr v-for="log in logs" :key="log.time" class="hover:bg-slate-50/60">
            <td class="py-3 px-4 font-mono text-slate-500">{{ log.time }}</td>
            <td class="py-3 px-4 font-medium text-slate-900">{{ log.actor }}</td>
            <td class="py-3 px-4 font-semibold text-indigo-600">{{ log.client }}</td>
            <td class="py-3 px-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-50 text-indigo-700">
                {{ log.action }}
              </span>
            </td>
            <td class="py-3 px-4 font-mono text-[11px] text-slate-600">{{ log.detail }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const logs = ref([
  { time: '2026-11-14 09:12:00', actor: 'owner@kopisudut.com', client: 'Kopi Sudut', action: 'Update Destination URL', detail: 'Changed to maps.app.goo.gl/kopi-sudut-official' },
  { time: '2026-11-13 14:30:22', actor: 'admin@tapreview.com', client: 'Kopi Sudut', action: 'Lock NFC Chip', detail: 'NTAG213 UID 04:7A:B2:91:3F:80 locked permanently' },
  { time: '2026-11-12 10:05:11', actor: 'admin@tapreview.com', client: 'Barbershop Masbro', action: 'Create Client', detail: 'Assigned slug: /masbrobarber' },
]);
</script>
