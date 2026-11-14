<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-xl font-bold tracking-tight text-zinc-950">Dashboard Administrator</h2>
        <p class="text-xs text-zinc-500 font-mono mt-0.5">SISTEM KONTROL HARDWARE & MONITORING KLIEN</p>
      </div>

      <router-link to="/admin/clients" class="px-3 py-1.5 rounded-md bg-zinc-950 hover:bg-zinc-800 text-white font-semibold text-xs uppercase tracking-wider shadow-sm transition">
        + Daftarkan Klien Baru
      </router-link>
    </div>

    <!-- Metrik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-sm">
        <div class="text-[11px] font-mono font-semibold text-zinc-400 uppercase tracking-wider mb-1">TOTAL KLIEN AKTIF</div>
        <div class="text-2xl font-mono font-extrabold text-zinc-950">18 Usaha</div>
        <div class="text-[11px] text-zinc-500 font-mono mt-1">100% berlangganan aktif</div>
      </div>

      <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-sm">
        <div class="text-[11px] font-mono font-semibold text-zinc-400 uppercase tracking-wider mb-1">STAND MEJA TERPASANG</div>
        <div class="text-2xl font-mono font-extrabold text-zinc-950">64 Titik</div>
        <div class="text-[11px] text-emerald-600 font-mono mt-1">Chip NFC terkunci aman</div>
      </div>

      <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-sm">
        <div class="text-[11px] font-mono font-semibold text-zinc-400 uppercase tracking-wider mb-1">TOTAL TAP BULAN INI</div>
        <div class="text-2xl font-mono font-extrabold text-zinc-950">4.820 Tap</div>
        <div class="text-[11px] text-zinc-500 font-mono mt-1">↑ 24% dari bulan lalu</div>
      </div>

      <div class="bg-white p-5 rounded-lg border border-zinc-200/90 shadow-sm">
        <div class="text-[11px] font-mono font-semibold text-zinc-400 uppercase tracking-wider mb-1">PESANAN MENUNGGU</div>
        <div class="text-2xl font-mono font-extrabold text-orange-600">3 Pesanan</div>
        <div class="text-[11px] text-zinc-500 font-mono mt-1">Siap diprogram & dicetak</div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
// Admin Dashboard
</script>
