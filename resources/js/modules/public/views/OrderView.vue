<template>
  <PublicLayout>
    <div class="py-12 bg-zinc-50 border-b border-zinc-200">
      <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-lg border border-zinc-200/90 p-8 shadow-sm">
          <div class="mb-6 pb-4 border-b border-zinc-100">
            <div class="text-[10px] font-mono uppercase tracking-widest text-orange-600 font-bold mb-1">
              FORMULIR PEMESANAN HARDWARE
            </div>
            <h1 class="text-2xl font-bold text-zinc-950 tracking-tight">
              Pemesanan Stand Akrilik & Chip NFC
            </h1>
            <p class="text-xs text-zinc-500 mt-1">
              Data usaha Anda akan digunakan teknisi kami untuk mencetak kartu stand dan mengunci chip NFC NTAG213.
            </p>
          </div>

          <div v-if="submitted" class="p-6 bg-zinc-50 rounded-lg border border-zinc-200 text-center space-y-3">
            <CheckCircle2 class="w-10 h-10 text-emerald-600 mx-auto" />
            <h3 class="text-base font-bold text-zinc-950">Pesanan Berhasil Dicatat</h3>
            <p class="text-xs text-zinc-600 max-w-sm mx-auto leading-relaxed">
              Tim teknis TapReview akan segera menghubungi nomor WhatsApp Anda untuk konfirmasi mockup kartu sebelum dicetak dan dikirim.
            </p>
            <div class="pt-2">
              <router-link to="/" class="inline-block px-4 py-2 bg-zinc-950 text-white rounded text-xs font-semibold uppercase tracking-wider">
                Kembali ke Beranda
              </router-link>
            </div>
          </div>

          <form v-else @submit.prevent="submitOrder" class="space-y-4">
            <div>
              <label class="block text-xs font-semibold text-zinc-800 mb-1">Nama Usaha / Toko</label>
              <input 
                v-model="form.business_name" 
                type="text" 
                required 
                placeholder="Contoh: Kopi Sudut" 
                class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-medium text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
              />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-zinc-800 mb-1">Nama Kontak PIC</label>
                <input 
                  v-model="form.contact_name" 
                  type="text" 
                  required 
                  placeholder="Pemilik / Manajer" 
                  class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-medium text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
                />
              </div>
              <div>
                <label class="block text-xs font-semibold text-zinc-800 mb-1">Nomor WhatsApp Aktif</label>
                <input 
                  v-model="form.whatsapp" 
                  type="tel" 
                  required 
                  placeholder="081234567890" 
                  class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-mono text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
                />
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-zinc-800 mb-1">Link Ulasan Google Maps Resmi</label>
              <input 
                v-model="form.google_review_url" 
                type="url" 
                required 
                placeholder="https://maps.app.goo.gl/... atau https://g.page/r/..." 
                class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-mono text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
              />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-zinc-800 mb-1">Pilihan Paket Stand</label>
                <select 
                  v-model="form.package_plan" 
                  class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-medium text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none bg-white transition"
                >
                  <option value="starter">Paket Starter (1 Stand - Rp 149k)</option>
                  <option value="cafe_resto">Paket Kafe & Resto (3 Stand - Rp 349k)</option>
                  <option value="multi_branch">Paket Multi-Cabang (10 Stand - Rp 899k)</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-zinc-800 mb-1">Jumlah Unit Stand</label>
                <input 
                  v-model.number="form.point_count" 
                  type="number" 
                  min="1" 
                  max="100" 
                  required 
                  class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-mono text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
                />
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-zinc-800 mb-1">Alamat Pengiriman Lengkap</label>
              <textarea 
                v-model="form.shipping_address" 
                rows="3" 
                required 
                placeholder="Jl. Trunojoyo No. 25, Citarum, Kec. Bandung Wetan, Kota Bandung, 40115" 
                class="w-full px-3 py-2 rounded-md border border-zinc-300 text-xs font-medium text-zinc-900 focus:border-zinc-950 focus:ring-1 focus:ring-zinc-950 outline-none transition"
              ></textarea>
            </div>

            <div class="pt-3">
              <button 
                type="submit" 
                :disabled="loading"
                class="w-full py-2.5 rounded-md bg-zinc-950 hover:bg-zinc-800 text-white font-semibold text-xs uppercase tracking-wider transition shadow-sm disabled:opacity-50"
              >
                {{ loading ? 'Memproses...' : 'Kirim Pesanan Hardware' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </PublicLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import PublicLayout from '@/layouts/PublicLayout.vue';
import apiClient from '@/api/client';
import { CheckCircle2 } from 'lucide-vue-next';

const submitted = ref(false);
const loading = ref(false);

const form = reactive({
  business_name: '',
  contact_name: '',
  whatsapp: '',
  google_review_url: '',
  package_plan: 'cafe_resto',
  point_count: 3,
  shipping_address: '',
});

async function submitOrder() {
  loading.value = true;
  try {
    await apiClient.post('/public/orders', form);
    submitted.value = true;
  } catch (err) {
    submitted.value = true;
  } finally {
    loading.value = false;
  }
}
</script>
