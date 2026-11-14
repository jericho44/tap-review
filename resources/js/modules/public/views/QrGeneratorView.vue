<template>
  <PublicLayout>
    <div class="py-12 bg-zinc-50 border-b border-zinc-200">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
          <div class="inline-flex items-center gap-1.5 text-[11px] font-mono text-zinc-500 uppercase tracking-wider mb-2">
            <span>//</span> GENERATOR STAND MEJA MANDIRI
          </div>
          <h1 class="text-2xl sm:text-3xl font-bold text-zinc-950 tracking-tight">
            Pembuat Kartu QR Ulasan Google
          </h1>
          <p class="text-xs sm:text-sm text-zinc-600 max-w-2xl mt-1">
            Konfigurasikan kartu QR ulasan Google Anda secara mandiri. Unduh file resolusi tinggi untuk dicetak langsung pada kertas art paper atau stand meja.
          </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
          <!-- Form Configuration (Left) -->
          <div class="lg:col-span-7 bg-white rounded-lg border border-zinc-200/90 p-6 shadow-sm space-y-4">
            <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-zinc-900 pb-3 border-b border-zinc-100 flex items-center justify-between">
              <span>PARAMETER KARTU</span>
              <span class="text-[10px] text-zinc-400 font-normal">FORMAT RESMI GOOGLE</span>
            </h2>

            <div>
              <label class="block text-xs font-semibold text-zinc-800 mb-1">Nama Usaha / Toko</label>
              <input 
                v-model="businessName" 
                type="text" 
                placeholder="Contoh: Kopi Sudut" 
                class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-medium text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-zinc-800 mb-1">Link Ulasan Google Maps Resmi</label>
              <input 
                v-model="reviewUrl" 
                type="url" 
                placeholder="https://maps.app.goo.gl/... atau https://g.page/r/..." 
                class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-mono text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
                :class="{'border-rose-500': urlError}"
              />
              <p v-if="urlError" class="text-[11px] text-rose-600 mt-1 font-medium">
                {{ urlError }}
              </p>
              <p v-else class="text-[11px] text-zinc-500 mt-1">
                Dapatkan dari menu Google Business Profile → "Minta Ulasan" → Salin link pendek.
              </p>
            </div>

            <div>
              <label class="block text-xs font-semibold text-zinc-800 mb-1">Teks Ajakan (Call to Action)</label>
              <input 
                v-model="callToAction" 
                type="text" 
                placeholder="Dekatkan HP Anda ke sini atau scan kode QR untuk ulasan Google" 
                class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-medium text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
              />
            </div>

            <div class="pt-2">
              <button 
                @click="generateQr" 
                class="w-full py-2.5 rounded-md bg-zinc-950 hover:bg-zinc-800 text-white font-semibold text-xs uppercase tracking-wider transition shadow-sm"
              >
                Perbarui Pratinjau Kartu
              </button>
            </div>

            <!-- Technical NFC Self-Write Guide -->
            <div class="mt-6 pt-5 border-t border-zinc-100 bg-zinc-50 rounded-md p-4 border border-zinc-200">
              <div class="flex items-center gap-2 mb-2 text-xs font-bold text-zinc-900 font-mono">
                <Radio class="w-4 h-4 text-orange-600" />
                <span>PANDUAN PEMROGRAMAN CHIP NFC MANDIRI</span>
              </div>
              <p class="text-xs text-zinc-600 leading-relaxed">
                Gunakan aplikasi gratis <strong>NFC Tools</strong> (iOS/Android). Pilih menu <em>Write</em> → <em>Add a record</em> → <em>URL</em> → Masukkan link ulasan Google Anda, lalu tempelkan stiker NFC tipe <strong>NTAG213</strong>. Kunci chip dengan fitur <em>Lock Tag</em> agar link tidak dapat diubah orang lain.
              </p>
            </div>
          </div>

          <!-- Preview Stand Akrilik (Right) -->
          <div class="lg:col-span-5 bg-white rounded-lg border border-zinc-200/90 p-6 shadow-sm flex flex-col items-center">
            <h2 class="text-xs font-mono font-bold uppercase tracking-wider text-zinc-400 mb-6 text-center w-full">
              PRATINJAU FISIK STAND (A6)
            </h2>

            <!-- Real Acrylic Stand Assembly -->
            <div class="flex flex-col items-center w-full">
              <div class="acrylic-dark w-64 rounded-xl p-5 text-white shadow-xl relative z-10 text-center">
                <div class="flex items-center justify-between mb-3 border-b border-zinc-800 pb-2">
                  <span class="text-[9px] font-mono text-zinc-400">SMART STAND</span>
                  <div class="flex gap-0.5 text-amber-400">
                    <Star v-for="i in 5" :key="i" class="w-3 h-3 fill-current" />
                  </div>
                </div>

                <h3 class="font-bold text-sm tracking-tight text-white mb-1">
                  {{ businessName || 'Nama Usaha' }}
                </h3>

                <p class="text-[11px] text-zinc-400 mb-3 leading-snug px-2">
                  {{ callToAction || 'Scan atau tap HP di sini untuk memberi ulasan' }}
                </p>

                <!-- High-contrast QR canvas -->
                <div class="bg-white p-2.5 rounded-lg mx-auto w-36 h-36 flex items-center justify-center shadow-inner my-2">
                  <canvas ref="qrCanvas" class="w-32 h-32 block"></canvas>
                </div>

                <div class="text-[9px] font-mono text-zinc-300 tracking-wider pt-2 border-t border-zinc-850">
                  NFC CHIP & QR READY
                </div>
              </div>

              <!-- Base Acrylic Foot -->
              <div class="w-72 h-3.5 bg-zinc-200 rounded-sm -mt-1.5 shadow border-t border-white/60"></div>
            </div>

            <!-- Download Button -->
            <div class="mt-6 w-full space-y-2">
              <button 
                @click="downloadPng" 
                class="w-full py-2.5 rounded-md bg-zinc-950 hover:bg-zinc-800 text-white font-semibold text-xs uppercase tracking-wider transition shadow-sm flex items-center justify-center gap-2"
              >
                <Download class="w-4 h-4 text-orange-400" />
                <span>Unduh File Kartu (PNG)</span>
              </button>

              <router-link 
                to="/pesan" 
                class="block w-full py-2 rounded-md bg-zinc-100 hover:bg-zinc-200 text-zinc-800 text-center text-xs font-semibold uppercase tracking-wider border border-zinc-200 transition"
              >
                Pesan Stand Jadi & Chip Terkunci →
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
import { Download, Radio, Star } from 'lucide-vue-next';

const businessName = ref('Kopi Sudut');
const reviewUrl = ref('https://maps.app.goo.gl/kopi-sudut-sample');
const callToAction = ref('Dekatkan HP Anda ke sini atau scan kode QR untuk ulasan Google');
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
  const target = reviewUrl.value || 'https://maps.google.com';
  try {
    await QRCode.toCanvas(qrCanvas.value, target, {
      width: 140,
      margin: 1,
      color: {
        dark: '#09090b',
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
  link.download = `${businessName.value.replace(/\s+/g, '-').toLowerCase()}-qr-stand.png`;
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
