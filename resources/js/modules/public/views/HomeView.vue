<template>
  <PublicLayout>
    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-16 pb-20 lg:pt-24 lg:pb-32 bg-gradient-to-b from-indigo-50/60 to-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
          <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-semibold mb-6">
            <span>✨</span> Solusi Cerdas Tingkatkan Reputasi Google Maps
          </div>
          <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15] mb-6">
            Ulasan Google Bintang 5 Cuma <span class="text-indigo-600 underline decoration-indigo-300 decoration-wavy underline-offset-8">Satu Tap</span>
          </h1>
          <p class="text-lg sm:text-xl text-slate-600 mb-8 leading-relaxed">
            Stiker NFC dan kartu QR pintar untuk meja kasir, meja makan, dan area usaha Anda. Pelanggan puas langsung diarahkan ke halaman ulasan Google tanpa perlu repot mengetik atau mencari nama usaha.
          </p>

          <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <router-link to="/pesan" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-base shadow-lg shadow-indigo-200 transition-all hover:scale-[1.02]">
              Pesan Stiker Usaha Anda
            </router-link>
            <router-link to="/generator" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-semibold text-base border border-slate-300 shadow-sm transition-all hover:border-slate-400">
              Coba Generator QR Gratis
            </router-link>
          </div>
        </div>

        <!-- Visual Flow Graphic -->
        <div class="mt-16 max-w-4xl mx-auto bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-200 p-6 sm:p-8">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center relative">
            <div class="flex flex-col items-center">
              <div class="w-16 h-16 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-3xl mb-4 shadow-sm">
                📲
              </div>
              <h3 class="font-bold text-slate-900 mb-2">1. Pelanggan Tap / Scan</h3>
              <p class="text-sm text-slate-500">
                Dekatkan HP ke stiker NFC akrilik atau scan kode QR jika HP belum mendukung NFC.
              </p>
            </div>

            <div class="flex flex-col items-center">
              <div class="w-16 h-16 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-3xl mb-4 shadow-sm">
                ⚡
              </div>
              <h3 class="font-bold text-slate-900 mb-2">2. Pengalihan Instan</h3>
              <p class="text-sm text-slate-500">
                Dalam hitungan kurang dari 1 detik, browser HP langsung membuka form ulasan resmi Google Maps.
              </p>
            </div>

            <div class="flex flex-col items-center">
              <div class="w-16 h-16 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-3xl mb-4 shadow-sm">
                ⭐
              </div>
              <h3 class="font-bold text-slate-900 mb-2">3. Ulasan Bintang 5</h3>
              <p class="text-sm text-slate-500">
                Pelanggan memberi rating dan ulasan seketika. Rating Google bisnis Anda melesat naik!
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Kenapa TapReview? -->
    <section class="py-20 bg-white border-t border-slate-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
          <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Mengapa Memilih TapReview?</h2>
          <p class="text-slate-600">Teknologi stiker cerdas yang dirancang untuk kepatuhan dan keawetan jangka panjang.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
            <div class="text-2xl mb-3">🛡️</div>
            <h3 class="font-bold text-lg text-slate-900 mb-2">100% Patuh Aturan Google</h3>
            <p class="text-sm text-slate-600 leading-relaxed">
              Kami tidak melakukan manipulasi bintang atau gatekeeping ulasan yang melanggar ketentuan Google. Ulasan Anda dijamin aman dari risiko penghapusan.
            </p>
          </div>

          <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
            <div class="text-2xl mb-3">🔄</div>
            <h3 class="font-bold text-lg text-slate-900 mb-2">Link Pendek Dinamis</h3>
            <p class="text-sm text-slate-600 leading-relaxed">
              Jika alamat toko atau link Google Maps berubah di masa depan, Anda cukup mengganti link di portal klien tanpa perlu mencetak ulang stiker!
            </p>
          </div>

          <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
            <div class="text-2xl mb-3">🔒</div>
            <h3 class="font-bold text-lg text-slate-900 mb-2">Chip NFC Anti-Tamper</h3>
            <p class="text-sm text-slate-600 leading-relaxed">
              Menggunakan chip NTAG213 berstandar industri yang dikunci secara permanen sehingga tidak dapat ditimpa atau dibajak oleh pihak lain.
            </p>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
</script>
