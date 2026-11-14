<template>
  <footer class="bg-white border-t border-slate-200 mt-auto py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
        <div class="md:col-span-2">
          <div class="flex items-center gap-2 mb-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg">
              T
            </div>
            <span class="font-bold text-lg text-slate-900">Tap<span class="text-indigo-600">Review</span></span>
          </div>
          <p class="text-sm text-slate-500 max-w-sm mb-4">
            Layanan stiker NFC & QR pintar untuk membawa pelanggan Anda langsung ke halaman ulasan Google dalam satu tap atau scan.
          </p>
          <div class="text-xs text-slate-400">
            &copy; 2026 TapReview. Sesuai kebijakan ulasan resmi Google.
          </div>
        </div>

        <div>
          <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-900 mb-4">Produk</h4>
          <ul class="space-y-2 text-sm text-slate-600">
            <li><router-link to="/generator" class="hover:text-indigo-600">Generator QR Gratis</router-link></li>
            <li><router-link to="/harga" class="hover:text-indigo-600">Paket & Harga</router-link></li>
            <li><router-link to="/demo" class="hover:text-indigo-600">Demo Alur Pelanggan</router-link></li>
            <li><router-link to="/pesan" class="hover:text-indigo-600">Formulir Pesanan</router-link></li>
          </ul>
        </div>

        <div>
          <h4 class="text-xs font-semibold uppercase tracking-wider text-slate-900 mb-4">Akses & Bantuan</h4>
          <ul class="space-y-2 text-sm text-slate-600">
            <li><router-link to="/masuk" class="hover:text-indigo-600">Portal Klien</router-link></li>
            <li><router-link to="/admin" class="hover:text-indigo-600">Panel Admin</router-link></li>
            <li><a href="https://wa.me/6281234567890" target="_blank" class="hover:text-indigo-600">Konsultasi WhatsApp</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup lang="ts">
// Public Footer
</script>
