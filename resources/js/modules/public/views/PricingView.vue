<template>
  <PublicLayout>
    <div class="py-16 bg-slate-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
          <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">
            Paket Stand Akrilik & Stiker NFC Cerdas
          </h1>
          <p class="text-slate-600 text-base">
            Pilih paket yang paling sesuai dengan jumlah meja atau kasir usaha Anda. Tanpa biaya bulanan tersembunyi.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
          <!-- Paket Starter -->
          <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm flex flex-col justify-between">
            <div>
              <div class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Paket Starter</div>
              <div class="flex items-baseline gap-1 mb-6">
                <span class="text-3xl font-extrabold text-slate-900">Rp 149.000</span>
                <span class="text-xs text-slate-500">/ 1 Stand</span>
              </div>
              <p class="text-xs text-slate-600 mb-6">
                Cocok untuk toko kecil, barbershop, atau kasir tunggal.
              </p>
              <ul class="space-y-3 text-xs text-slate-600 mb-8">
                <li class="flex items-center gap-2">✓ 1 Stand Akrilik Meja Premium</li>
                <li class="flex items-center gap-2">✓ 1 Chip NFC NTAG213 Terkunci</li>
                <li class="flex items-center gap-2">✓ QR Code Resolusi Tinggi Siap Scan</li>
                <li class="flex items-center gap-2">✓ Link Pendek Dinamis Selamanya</li>
                <li class="flex items-center gap-2 text-slate-400">✗ Portal Analitik Tap</li>
              </ul>
            </div>
            <a 
              href="https://wa.me/6281234567890?text=Halo%20Admin%20TapReview,%20saya%20tertarik%20pesan%20Paket%20Starter" 
              target="_blank"
              class="w-full py-2.5 rounded-xl border border-slate-300 hover:border-slate-400 text-slate-800 text-center text-xs font-semibold transition"
            >
              Pesan via WhatsApp
            </a>
          </div>

          <!-- Paket Popular / Bisnis -->
          <div class="bg-white rounded-2xl border-2 border-indigo-600 p-8 shadow-xl relative flex flex-col justify-between">
            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-[10px] uppercase font-bold tracking-wider py-1 px-3 rounded-full">
              Paling Populer
            </div>
            <div>
              <div class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-2">Paket Cafe & Resto</div>
              <div class="flex items-baseline gap-1 mb-6">
                <span class="text-3xl font-extrabold text-slate-900">Rp 349.000</span>
                <span class="text-xs text-slate-500">/ 3 Stand</span>
              </div>
              <p class="text-xs text-slate-600 mb-6">
                Ideal untuk kafe, resto, dan klinik dengan beberapa meja & kasir.
              </p>
              <ul class="space-y-3 text-xs text-slate-600 mb-8">
                <li class="flex items-center gap-2">✓ 3 Stand Akrilik Meja Premium</li>
                <li class="flex items-center gap-2">✓ 3 Chip NFC NTAG213 Terkunci</li>
                <li class="flex items-center gap-2">✓ Link Pendek Dinamis (Bisa Diganti)</li>
                <li class="flex items-center gap-2">✓ Akses Portal Klien TapReview</li>
                <li class="flex items-center gap-2">✓ Statistik Jumlah Tap NFC vs Scan QR</li>
                <li class="flex items-center gap-2">✓ Bebas Ganti Tema & Download Ulang</li>
              </ul>
            </div>
            <a 
              href="https://wa.me/6281234567890?text=Halo%20Admin%20TapReview,%20saya%20tertarik%20pesan%20Paket%20Cafe%20dan%20Resto" 
              target="_blank"
              class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-center text-xs font-semibold shadow-md shadow-indigo-200 transition"
            >
              Pesan Paket Sekarang
            </a>
          </div>

          <!-- Paket Multi-Cabang -->
          <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm flex flex-col justify-between">
            <div>
              <div class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Paket Multi-Cabang</div>
              <div class="flex items-baseline gap-1 mb-6">
                <span class="text-3xl font-extrabold text-slate-900">Rp 899.000</span>
                <span class="text-xs text-slate-500">/ 10 Stand</span>
              </div>
              <p class="text-xs text-slate-600 mb-6">
                Untuk jaringan restoran, hotel, dan usaha dengan banyak cabang.
              </p>
              <ul class="space-y-3 text-xs text-slate-600 mb-8">
                <li class="flex items-center gap-2">✓ 10 Stand Akrilik Kustom Logo Usaha</li>
                <li class="flex items-center gap-2">✓ 10 Chip NFC NTAG213 Terkunci</li>
                <li class="flex items-center gap-2">✓ Pengaturan Multi-Titik & Multi-Cabang</li>
                <li class="flex items-center gap-2">✓ Portal Klien Lengkap + Riwayat Tap</li>
                <li class="flex items-center gap-2">✓ Desain Khusus Sesuai Warna Brand</li>
              </ul>
            </div>
            <a 
              href="https://wa.me/6281234567890?text=Halo%20Admin%20TapReview,%20saya%20tertarik%20pesan%20Paket%20Multi-Cabang" 
              target="_blank"
              class="w-full py-2.5 rounded-xl border border-slate-300 hover:border-slate-400 text-slate-800 text-center text-xs font-semibold transition"
            >
              Konsultasi Cabang
            </a>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>
