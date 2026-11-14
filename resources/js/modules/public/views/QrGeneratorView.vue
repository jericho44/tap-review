<template>
  <PublicLayout>
    <div class="py-12 bg-slate-50">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-semibold mb-3">
            <span>🎁</span> Gratis 100% Tanpa Registrasi
          </div>
          <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-3">
            Generator Kartu QR Google Review
          </h1>
          <p class="text-slate-600 max-w-xl mx-auto text-sm sm:text-base">
            Buat kartu QR ulasan Google Anda sendiri sekarang. Cetak langsung di atas kertas atau kartu akrilik meja Anda.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
          <!-- Form Input -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100">
              Data Usaha & Link Ulasan
            </h2>

            <div class="space-y-4">
              <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Usaha Anda</label>
                <input 
                  v-model="businessName" 
                  type="text" 
                  placeholder="Misal: Kopi Sudut Senja" 
                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                />
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Link Ulasan Google Maps</label>
                <input 
                  v-model="reviewUrl" 
                  type="url" 
                  placeholder="https://g.page/r/... atau https://maps.app.goo.gl/..." 
                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                  :class="{'border-rose-400': urlError}"
                />
                <p v-if="urlError" class="text-xs text-rose-500 mt-1 font-medium">
                  {{ urlError }}
                </p>
                <p v-else class="text-[11px] text-slate-500 mt-1">
                  Dapatkan dari menu Google Profil Bisnis → "Minta Ulasan" → Salin link.
                </p>
              </div>

              <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Teks Ajakan (Call to Action)</label>
                <input 
                  v-model="callToAction" 
                  type="text" 
                  placeholder="Bantu ulas kami di Google Review ya!" 
                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                />
              </div>

              <div class="pt-2">
                <button 
                  @click="generateQr" 
                  class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-200 transition"
                >
                  Perbarui Kartu QR
                </button>
              </div>
            </div>

            <!-- Panduan NFC -->
            <div class="mt-8 pt-6 border-t border-slate-100">
              <h3 class="text-xs font-bold uppercase text-slate-900 mb-2 flex items-center gap-1.5">
                <span>💡</span> Panduan Tulis ke Chip NFC Sendiri
              </h3>
              <p class="text-xs text-slate-500 leading-relaxed">
                Ingin pasang chip NFC sendiri? Unduh aplikasi <strong>NFC Tools</strong> di Play Store / App Store, pilih menu <em>Write</em> → <em>Add a record</em> → <em>URL/URI</em>, lalu masukkan link ulasan Anda di atas dan tempelkan stiker NTAG213.
              </p>
            </div>
          </div>

          <!-- Preview Kartu Siap Cetak -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm flex flex-col items-center">
            <h2 class="text-base font-bold text-slate-900 mb-4 pb-2 border-b border-slate-100 w-full text-center">
              Pratinjau Kartu Siap Cetak
            </h2>

            <div 
              ref="cardRef"
              class="w-72 rounded-2xl bg-gradient-to-b from-indigo-900 via-indigo-950 to-slate-950 text-white p-6 shadow-xl flex flex-col items-center text-center relative overflow-hidden"
            >
              <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-xl mb-2">
                ⭐
              </div>
              <h3 class="font-extrabold text-base tracking-tight mb-1 text-white">
                {{ businessName || 'Nama Usaha Anda' }}
              </h3>
              <div class="flex items-center gap-1 text-amber-400 text-xs mb-3">
                ★★★★★
              </div>
              <p class="text-xs text-indigo-200 mb-4 px-2">
                {{ callToAction || 'Puas dengan pelayanan kami? Tap atau scan untuk memberi ulasan!' }}
              </p>

              <!-- QR Container -->
              <div class="bg-white p-3 rounded-xl shadow-inner mb-3">
                <canvas ref="qrCanvas" class="w-40 h-40 block"></canvas>
              </div>

              <div class="flex items-center gap-2 text-[10px] text-slate-400 font-mono">
                <span>NFC & QR SMART STAND</span>
              </div>
            </div>

            <div class="mt-6 w-full flex flex-col gap-2">
              <button 
                @click="downloadPng" 
                class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-medium text-xs shadow-sm transition flex items-center justify-center gap-2"
              >
                <span>💾</span> Unduh Gambar Kartu (PNG)
              </button>
              <router-link 
                to="/pesan" 
                class="w-full py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 font-medium text-xs border border-amber-200 text-center transition"
              >
                Ingin Stand Akrilik Jadi & Chip Siap Pakai? Pesan di Sini →
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, watch } from 'vue';
import QRCode from 'qrcode';
import PublicLayout from '@/layouts/PublicLayout.vue';

const businessName = ref('Kopi Sudut');
const reviewUrl = ref('https://maps.app.goo.gl/sample-review');
const callToAction = ref('Scan kode QR atau tap HP Anda di sini untuk ulasan Google!');
const urlError = ref('');
const qrCanvas = ref<HTMLCanvasElement | null>(null);

function validateUrl(url: string): boolean {
  if (!url) {
    urlError.value = 'URL ulasan tidak boleh kosong.';
    return false;
  }
  const allowed = ['google.com', 'g.page', 'maps.app.goo.gl', 'search.google.com'];
  try {
    const parsed = new URL(url);
    const isGoogle = allowed.some((domain) => parsed.hostname.endsWith(domain));
    if (!isGoogle) {
      urlError.value = 'URL harus mengarah ke link resmi Google (g.page, maps.app.goo.gl, google.com).';
      return false;
    }
  } catch {
    urlError.value = 'Format URL tidak valid.';
    return false;
  }
  urlError.value = '';
  return true;
}

async function renderQr() {
  if (!qrCanvas.value) return;
  const target = reviewUrl.value || 'https://google.com';
  try {
    await QRCode.toCanvas(qrCanvas.value, target, {
      width: 160,
      margin: 1,
      color: {
        dark: '#0f172a',
        light: '#ffffff',
      },
    });
  } catch (err) {
    console.error('QR Render Error', err);
  }
}

function generateQr() {
  if (validateUrl(reviewUrl.value)) {
    renderQr();
  }
}

function downloadPng() {
  if (!qrCanvas.value) return;
  const link = document.createElement('a');
  link.download = `${businessName.value.replace(/\s+/g, '-').toLowerCase()}-qr-review.png`;
  link.href = qrCanvas.value.toDataURL('image/png');
  link.click();
}

onMounted(() => {
  renderQr();
});

watch([reviewUrl], () => {
  validateUrl(reviewUrl.value);
});
</script>
