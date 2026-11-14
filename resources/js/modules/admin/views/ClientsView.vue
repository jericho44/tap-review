<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Kelola Klien</h2>
        <p class="text-xs text-slate-500">Daftar pemilik usaha yang menggunakan layanan TapReview.</p>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
          <tr>
            <th class="py-3 px-4">Nama Usaha</th>
            <th class="py-3 px-4">Slug URL</th>
            <th class="py-3 px-4">Kontak / WA</th>
            <th class="py-3 px-4">Paket</th>
            <th class="py-3 px-4">Total Titik</th>
            <th class="py-3 px-4">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          <tr v-for="client in clients" :key="client.slug" class="hover:bg-slate-50/60">
            <td class="py-3 px-4 font-bold text-slate-900">{{ client.name }}</td>
            <td class="py-3 px-4 font-mono text-indigo-600">/{{ client.slug }}</td>
            <td class="py-3 px-4">{{ client.wa }}</td>
            <td class="py-3 px-4">{{ client.plan }}</td>
            <td class="py-3 px-4 font-medium">{{ client.points }} titik</td>
            <td class="py-3 px-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-100 text-emerald-800">
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
  { name: 'Kopi Sudut', slug: 'kopisudut', wa: '081234567890', plan: 'Cafe & Resto', points: 4, status: 'Aktif' },
  { name: 'Barbershop Masbro', slug: 'masbrobarber', wa: '081298765432', plan: 'Starter', points: 1, status: 'Aktif' },
  { name: 'Klinik Gigi Senyum', slug: 'gigisenyum', wa: '081122334455', plan: 'Multi-Cabang', points: 8, status: 'Aktif' },
]);
</script>
