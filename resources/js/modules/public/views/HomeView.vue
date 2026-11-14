<template>
  <PublicLayout>
    <!-- Hero Section -->
    <section class="relative pt-14 pb-20 lg:pt-20 lg:pb-28 border-b border-zinc-200 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
          <!-- Left Text Content -->
          <div class="lg:col-span-7 space-y-6">
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded bg-zinc-100 border border-zinc-200 text-zinc-800 text-[11px] font-mono font-medium">
              <span class="w-2 h-2 rounded-full bg-orange-600 animate-pulse"></span>
              RETAIL NFC HARDWARE & STAND
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-zinc-950 tracking-tight leading-[1.12]">
              Stand Akrilik & Stiker NFC Pintar untuk <span class="underline decoration-orange-500 underline-offset-8 decoration-2">Ulasan Google</span> di Meja Kasir.
            </h1>

            <p class="text-sm sm:text-base text-zinc-600 max-w-xl leading-relaxed">
              Tingkatkan jumlah ulasan bintang 5 Google Maps tanpa meminta pelanggan mencari nama usaha secara manual. Cukup dekatkan ponsel pintar ke chip NTAG213 atau scan QR instan di meja kasir.
            </p>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
              <router-link 
                to="/pesan" 
                class="px-6 py-3 rounded-md bg-zinc-950 hover:bg-zinc-800 text-white font-semibold text-xs uppercase tracking-wider shadow-sm transition flex items-center justify-center gap-2"
              >
                <span>Pesan Stand Akrilik</span>
                <ArrowRight class="w-4 h-4 text-orange-400" />
              </router-link>
              <router-link 
                to="/generator" 
                class="px-6 py-3 rounded-md bg-white hover:bg-zinc-50 text-zinc-800 font-semibold text-xs uppercase tracking-wider border border-zinc-300 transition flex items-center justify-center gap-2"
              >
                <QrCode class="w-4 h-4 text-zinc-600" />
                <span>Buat Kartu QR Mandiri</span>
              </router-link>
            </div>

            <!-- Hardware Spec Tags -->
            <div class="pt-4 border-t border-zinc-100 grid grid-cols-3 gap-4 text-left font-mono text-[11px] text-zinc-500">
              <div>
                <div class="text-zinc-900 font-bold">NTAG213</div>
                <div>Anti-tamper chip</div>
              </div>
              <div>
                <div class="text-zinc-900 font-bold">&lt; 100 MS</div>
                <div>Fast redirect engine</div>
              </div>
              <div>
                <div class="text-zinc-900 font-bold">100% LEGAL</div>
                <div>No review gatekeeping</div>
              </div>
            </div>
          </div>

          <!-- Right: Physical Acrylic Stand Mockup -->
          <div class="lg:col-span-5 flex justify-center">
            <div class="relative w-full max-w-sm flex flex-col items-center">
              <!-- Clear Acrylic Bevel Container -->
              <div class="acrylic-dark w-64 rounded-xl p-5 text-white shadow-2xl relative z-10">
                <div class="flex items-center justify-between mb-4 border-b border-zinc-800 pb-3">
                  <div class="flex items-center gap-1.5 text-[10px] font-mono text-zinc-400">
                    <Radio class="w-3.5 h-3.5 text-orange-400" />
                    <span>NFC ACTIVE</span>
                  </div>
                  <div class="flex gap-0.5 text-amber-400">
                    <Star v-for="i in 5" :key="i" class="w-3.5 h-3.5 fill-current text-amber-400" />
                  </div>
                </div>

                <div class="text-center my-3">
                  <h3 class="font-bold text-base tracking-tight text-white mb-1">Kopi Sudut</h3>
                  <p class="text-[11px] text-zinc-400 leading-snug">
                    Dekatkan HP Anda ke sini atau scan kode QR untuk ulasan Google
                  </p>
                </div>

                <!-- High-contrast QR insert inside acrylic stand -->
                <div class="bg-white p-3 rounded-lg mx-auto w-36 h-36 flex items-center justify-center shadow-inner my-4">
                  <div class="text-center">
                    <QrCode class="w-28 h-28 text-zinc-950 mx-auto" />
                  </div>
                </div>

                <div class="text-center pt-2 border-t border-zinc-850">
                  <span class="text-[9px] font-mono tracking-widest text-zinc-300 uppercase">
                    TAP HERE WITH SMARTPHONE
                  </span>
                </div>
              </div>

              <!-- Physical Acrylic Stand Base / Foot -->
              <div class="w-72 h-4 bg-zinc-200/90 rounded-sm -mt-2 shadow-md border-t border-white/60 relative z-0 flex items-center justify-center">
                <div class="w-32 h-1 bg-zinc-400/40 rounded-full"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3-Step Functional Pipeline -->
    <section class="py-16 bg-zinc-50 border-b border-zinc-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-12">
          <div class="text-[11px] font-mono uppercase tracking-wider text-orange-600 font-semibold mb-1">
            ALUR TRANSAKSI FISIK
          </div>
          <h2 class="text-2xl font-bold text-zinc-950 tracking-tight">Satu Detik Dari Meja ke Ulasan Resmi</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-white p-6 rounded-lg border border-zinc-200/90 shadow-sm flex flex-col justify-between">
            <div>
              <div class="w-9 h-9 rounded-md bg-zinc-100 border border-zinc-200 flex items-center justify-center text-zinc-900 mb-4">
                <Smartphone class="w-5 h-5 text-zinc-800" />
              </div>
              <div class="font-mono text-[10px] text-zinc-600 mb-1">LANGKAH 01</div>
              <h3 class="font-bold text-sm text-zinc-950 mb-2">Tap NFC atau Scan QR</h3>
              <p class="text-xs text-zinc-600 leading-relaxed">
                Pelanggan mendekatkan smartphone ber-NFC (iPhone atau Android) ke stand meja akrilik, atau memindai QR code jika HP model lama.
              </p>
            </div>
          </div>

          <div class="bg-white p-6 rounded-lg border border-zinc-200/90 shadow-sm flex flex-col justify-between">
            <div>
              <div class="w-9 h-9 rounded-md bg-zinc-100 border border-zinc-200 flex items-center justify-center text-zinc-900 mb-4">
                <Zap class="w-5 h-5 text-orange-600" />
              </div>
              <div class="font-mono text-[10px] text-zinc-600 mb-1">LANGKAH 02</div>
              <h3 class="font-bold text-sm text-zinc-950 mb-2">Redirect Mesin Cepat</h3>
              <p class="text-xs text-zinc-600 leading-relaxed">
                Server mengalihkan kunjungan dalam kurang dari 100 milidetik langsung ke form bintang Google Maps resmi tanpa perantara form lain.
              </p>
            </div>
          </div>

          <div class="bg-white p-6 rounded-lg border border-zinc-200/90 shadow-sm flex flex-col justify-between">
            <div>
              <div class="w-9 h-9 rounded-md bg-zinc-100 border border-zinc-200 flex items-center justify-center text-zinc-900 mb-4">
                <Star class="w-5 h-5 text-amber-500" />
              </div>
              <div class="font-mono text-[10px] text-zinc-600 mb-1">LANGKAH 03</div>
              <h3 class="font-bold text-sm text-zinc-950 mb-2">Ulasan Bintang 5 Masuk</h3>
              <p class="text-xs text-zinc-600 leading-relaxed">
                Rating Google Profil Bisnis Anda bertambah secara organik, mendorong ranking pencarian lokal Google Maps toko Anda.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Mengapa Stand Kami Berbeda -->
    <section class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="space-y-2">
            <ShieldCheck class="w-6 h-6 text-emerald-600 mb-3" />
            <h3 class="font-bold text-sm text-zinc-950">Bebas Risiko Penalti Google</h3>
            <p class="text-xs text-zinc-600 leading-relaxed">
              Google secara tegas melarang praktik <em>review gatekeeping</em> (menyaring ulasan buruk). TapReview 100% mematuhi aturan resmi Google Maps.
            </p>
          </div>

          <div class="space-y-2">
            <Layers class="w-6 h-6 text-zinc-800 mb-3" />
            <h3 class="font-bold text-sm text-zinc-950">Link Dinamis Seumur Hidup</h3>
            <p class="text-xs text-zinc-600 leading-relaxed">
              Jika link ulasan Google Maps berubah di kemudian hari, ubah link target melalui portal klien tanpa perlu mencetak ulang stiker fisik.
            </p>
          </div>

          <div class="space-y-2">
            <Radio class="w-6 h-6 text-orange-600 mb-3" />
            <h3 class="font-bold text-sm text-zinc-950">Chip NTAG213 Terkunci</h3>
            <p class="text-xs text-zinc-600 leading-relaxed">
              Setiap chip NFC dikunci secara permanen di tingkat memori (password lock) sehingga aman dari upaya pembajakan atau penimpaan link oleh pihak lain.
            </p>
          </div>
        </div>
      </div>
    </section>
  </PublicLayout>
</template>

<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { ArrowRight, QrCode, Radio, Smartphone, Zap, Star, ShieldCheck, Layers } from 'lucide-vue-next';
</script>
