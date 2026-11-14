<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold tracking-tight text-zinc-950">Kelola Klien Usaha</h2>
        <p class="text-xs text-zinc-500 font-mono mt-0.5">DAFTAR KLIEN AKTIF & INVENTARIS TITIK STIKER</p>
      </div>
    </div>

    <div class="bg-white rounded-lg border border-zinc-200/90 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 font-mono font-semibold uppercase text-[10px]">
          <tr>
            <th class="py-3 px-4">NAMA USAHA</th>
            <th class="py-3 px-4">SLUG LINK</th>
            <th class="py-3 px-4">KONTAK WHATSAPP</th>
            <th class="py-3 px-4">PAKET</th>
            <th class="py-3 px-4 text-center">TITIK</th>
            <th class="py-3 px-4">STATUS</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-zinc-100 text-zinc-700">
          <tr v-for="client in clients" :key="client.slug" class="hover:bg-zinc-50/70 transition">
            <td class="py-3 px-4 font-bold text-zinc-950">{{ client.name }}</td>
            <td class="py-3 px-4 font-mono text-zinc-700">/{{ client.slug }}</td>
            <td class="py-3 px-4 font-mono text-zinc-600">{{ client.wa }}</td>
            <td class="py-3 px-4 font-mono">{{ client.plan }}</td>
            <td class="py-3 px-4 text-center font-mono font-semibold">{{ client.points }}</td>
            <td class="py-3 px-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-mono font-semibold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                {{ client.status }}
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

const clients = ref([
  { name: 'Kopi Sudut', slug: 'kopisudut', wa: '081234567890', plan: 'Kafe & Resto', points: 4, status: 'Aktif' },
  { name: 'Barbershop Masbro', slug: 'masbrobarber', wa: '081298765432', plan: 'Starter', points: 1, status: 'Aktif' },
  { name: 'Klinik Gigi Senyum', slug: 'gigisenyum', wa: '081122334455', plan: 'Multi-Cabang', points: 8, status: 'Aktif' },
]);
</script>
