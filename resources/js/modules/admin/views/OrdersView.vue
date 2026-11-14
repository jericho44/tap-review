<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold tracking-tight text-zinc-950">Antrean Pesanan Stand</h2>
        <p class="text-xs text-zinc-500 font-mono mt-0.5">PERMINTAAN PEMBUATAN HARDWARE DARI WEBSITE</p>
      </div>
    </div>

    <div class="bg-white rounded-lg border border-zinc-200/90 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-zinc-50 border-b border-zinc-200 text-zinc-500 font-mono font-semibold uppercase text-[10px]">
          <tr>
            <th class="py-3 px-4">NO. ORDER</th>
            <th class="py-3 px-4">USAHA & KONTAK</th>
            <th class="py-3 px-4">WHATSAPP</th>
            <th class="py-3 px-4">PAKET STAND</th>
            <th class="py-3 px-4">ALAMAT PENGIRIMAN</th>
            <th class="py-3 px-4">STATUS ORDER</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-zinc-100 text-zinc-700">
          <tr v-for="order in orders" :key="order.id" class="hover:bg-zinc-50/70 transition">
            <td class="py-3 px-4 font-mono font-bold text-zinc-950">{{ order.id }}</td>
            <td class="py-3 px-4">
              <div class="font-bold text-zinc-950">{{ order.business }}</div>
              <div class="text-[11px] text-zinc-500">PIC: {{ order.pic }}</div>
            </td>
            <td class="py-3 px-4 font-mono text-zinc-700">{{ order.wa }}</td>
            <td class="py-3 px-4 font-mono font-medium">{{ order.package }} ({{ order.count }} unit)</td>
            <td class="py-3 px-4 max-w-xs truncate text-zinc-600 font-mono text-[11px]">{{ order.address }}</td>
            <td class="py-3 px-4 font-mono">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-orange-50 text-orange-900 border border-orange-200">
                {{ order.status }}
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

const orders = ref([
  { id: 'ORD-2026-001', business: 'Warung Bu Kris', pic: 'Krisdayanti', wa: '081344556677', package: 'Kafe & Resto', count: 3, address: 'Jl. Senopati No. 44, Jakarta Selatan', status: 'Antrean Baru' },
  { id: 'ORD-2026-002', business: 'Optik Mata Hati', pic: 'dr. Hendra', wa: '081299887766', package: 'Starter', count: 1, address: 'Ruko Mall Kelapa Gading Blok A-12', status: 'Proses Cetak' },
]);
</script>
