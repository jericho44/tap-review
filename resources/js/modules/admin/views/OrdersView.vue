<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Pesanan Masuk</h2>
        <p class="text-xs text-slate-500">Daftar pesanan stand akrilik & stiker dari formulir website.</p>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
      <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase">
          <tr>
            <th class="py-3 px-4">No. Order</th>
            <th class="py-3 px-4">Nama Usaha & PIC</th>
            <th class="py-3 px-4">WhatsApp</th>
            <th class="py-3 px-4">Paket & Jumlah</th>
            <th class="py-3 px-4">Alamat Kirim</th>
            <th class="py-3 px-4">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-slate-700">
          <tr v-for="order in orders" :key="order.id" class="hover:bg-slate-50/60">
            <td class="py-3 px-4 font-mono font-medium text-indigo-600">{{ order.id }}</td>
            <td class="py-3 px-4">
              <div class="font-bold text-slate-900">{{ order.business }}</div>
              <div class="text-[11px] text-slate-500">{{ order.pic }}</div>
            </td>
            <td class="py-3 px-4">{{ order.wa }}</td>
            <td class="py-3 px-4 font-medium">{{ order.package }} ({{ order.count }} stand)</td>
            <td class="py-3 px-4 max-w-xs truncate">{{ order.address }}</td>
            <td class="py-3 px-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-100 text-amber-800">
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
  { id: 'ORD-2026-001', business: 'Warung Bu Kris', pic: 'Krisdayanti', wa: '081344556677', package: 'Cafe & Resto', count: 3, address: 'Jl. Senopati No. 44, Jakarta Selatan', status: 'Baru Masuk' },
  { id: 'ORD-2026-002', business: 'Optik Mata Hati', pic: 'dr. Hendra', wa: '081299887766', package: 'Starter', count: 1, address: 'Ruko Mall Kelapa Gading Blok A-12', status: 'Diproses Cetak' },
]);
</script>
