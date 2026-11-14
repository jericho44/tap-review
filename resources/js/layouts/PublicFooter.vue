<template>
  <footer class="bg-zinc-950 text-zinc-400 border-t border-zinc-800 mt-auto py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
        <div class="md:col-span-2">
          <div class="flex items-center gap-3 mb-3">
            <div class="w-7 h-7 rounded bg-white text-zinc-950 font-mono font-bold text-xs flex items-center justify-center">
              TR
            </div>
            <span class="font-bold text-sm tracking-tight text-white uppercase">TapReview Labs</span>
          </div>
          <p class="text-xs text-zinc-400 max-w-sm mb-4 leading-relaxed">
            Perangkat stand akrilik presisi dan stiker chip NTAG213 untuk menghubungkan pelanggan fisik ke halaman ulasan Google Maps dalam satu tap.
          </p>
          <div class="text-[11px] font-mono text-zinc-400">
            ENGINEERED FOR RETAIL & HOSPITALITY — 2026
          </div>
        </div>

        <div>
          <h4 class="text-[11px] font-mono font-semibold uppercase tracking-wider text-zinc-300 mb-3">Spesifikasi</h4>
          <ul class="space-y-2 text-xs">
            <li><router-link to="/generator" class="hover:text-white transition-colors">Generator QR Resolusi Tinggi</router-link></li>
            <li><router-link to="/harga" class="hover:text-white transition-colors">Katalog Stand Akrilik</router-link></li>
            <li><router-link to="/demo" class="hover:text-white transition-colors">Simulasi Kecepatan Pengalihan</router-link></li>
            <li><router-link to="/pesan" class="hover:text-white transition-colors">Formulir Pemesanan Hardware</router-link></li>
          </ul>
        </div>

        <div>
          <h4 class="text-[11px] font-mono font-semibold uppercase tracking-wider text-zinc-300 mb-3">Akses Sistem</h4>
          <ul class="space-y-2 text-xs">
            <li><router-link to="/portal" class="hover:text-white transition-colors">Portal Usaha (Client)</router-link></li>
            <li><router-link to="/admin" class="hover:text-white transition-colors">Backoffice Administrasi</router-link></li>
            <li><a href="https://wa.me/6281234567890" target="_blank" class="hover:text-white transition-colors">Bantuan Teknis WhatsApp</a></li>
          </ul>
        </div>
      </div>

      <div class="pt-6 border-t border-zinc-850 flex flex-col sm:flex-row items-center justify-between text-[11px] font-mono text-zinc-400 gap-2">
        <div>100% COMPLIANT WITH GOOGLE MAPS REVIEW POLICIES — NO REVIEW GATEKEEPING</div>
        <div>NTAG213 PROTOCOL · ISO 14443-A</div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
// Industrial Footer
</script>
