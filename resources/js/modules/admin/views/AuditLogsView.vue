<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold tracking-tight text-zinc-950">Log Audit Sistem & Keamanan</h2>
        <p class="text-xs text-zinc-500 font-mono mt-0.5">APPEND-ONLY AUDIT TRAIL · GOOGLE COMPLIANCE LOG</p>
      </div>
    </div>

    <div class="bg-white rounded-lg border border-zinc-200/90 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 font-mono font-semibold uppercase text-[10px]">
          <tr>
            <th class="py-3 px-4">TIMESTAMP (UTC)</th>
            <th class="py-3 px-4">AKTOR</th>
            <th class="py-3 px-4">ENTITAS</th>
            <th class="py-3 px-4">TINDAKAN</th>
            <th class="py-3 px-4">DETAIL PERUBAHAN</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-zinc-100 text-zinc-700">
          <tr v-for="log in logs" :key="log.time" class="hover:bg-zinc-50/70 transition">
            <td class="py-3 px-4 font-mono text-zinc-500 text-[11px]">{{ log.time }}</td>
            <td class="py-3 px-4 font-mono font-semibold text-zinc-900">{{ log.actor }}</td>
            <td class="py-3 px-4 font-mono text-zinc-800">{{ log.client }}</td>
            <td class="py-3 px-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold uppercase bg-zinc-100 text-zinc-800 border border-zinc-200">
                {{ log.action }}
              </span>
            </td>
            <td class="py-3 px-4 font-mono text-[11px] text-zinc-600 truncate max-w-sm">{{ log.detail }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const logs = ref([
  { time: '2026-11-14 03:55:05Z', actor: 'client:owner@kopisudut.com', client: 'Client:kopisudut', action: 'update_destination_url', detail: 'URL updated to maps.app.goo.gl/kopi-sudut-new-branch' },
  { time: '2026-11-14 03:39:09Z', actor: 'telemetry_worker', client: 'Point:KPS-001', action: 'record_nfc_tap', detail: 'iPhone (iOS) tapped KPS-001 at Meja Kasir' },
  { time: '2026-11-13 14:30:22Z', actor: 'admin:superadmin@tapreview.id', client: 'Point:KPS-001', action: 'lock_nfc_chip', detail: 'NTAG213 UID 04:7A:B2:91:3F:80 locked permanently' },
]);
</script>
