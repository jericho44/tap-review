<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold text-slate-900">Dashboard Administrator</h2>
        <p class="text-xs text-slate-500">Pemantauan seluruh klien, titik stiker NFC, dan antrean pesanan.</p>
      </div>

      <router-link to="/admin/clients" class="px-3.5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs shadow-sm transition">
        + Tambah Klien Baru
      </router-link>
    </div>

    <!-- Metrik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Total Klien Aktif</div>
        <div class="text-2xl font-extrabold text-slate-900">18 Usaha</div>
        <div class="text-[11px] text-emerald-600 font-medium mt-1">100% berlangganan aktif</div>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Titik Stiker Terpasang</div>
        <div class="text-2xl font-extrabold text-slate-900">64 Titik</div>
        <div class="text-[11px] text-slate-500 mt-1">Chip NFC terkunci aman</div>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Total Tap Bulan Ini</div>
        <div class="text-2xl font-extrabold text-indigo-600">4.820 Tap</div>
        <div class="text-[11px] text-emerald-600 font-medium mt-1">↑ 24% dari bulan lalu</div>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase mb-1">Pesanan Menunggu</div>
        <div class="text-2xl font-extrabold text-amber-600">3 Pesanan</div>
        <div class="text-[11px] text-slate-500 mt-1">Perlu dicetak & diprogram</div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// Admin Dashboard
</script>
