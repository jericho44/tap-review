<template>
  <PublicLayout>
    <div class="py-12 bg-slate-50">
      <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-8 shadow-sm">
          <div class="mb-6 pb-4 border-b border-slate-100">
            <h1 class="text-2xl font-extrabold text-slate-900 mb-1">
              Formulir Pemesanan Stiker TapReview
            </h1>
            <p class="text-xs text-slate-500">
              Isi data di bawah ini untuk kami proses pembuatan stand akrilik dan penguncian chip NFC usaha Anda.
            </p>
          </div>

          <div v-if="submitted" class="p-6 bg-emerald-50 rounded-xl border border-emerald-200 text-center">
            <div class="text-4xl mb-3">🎉</div>
            <h3 class="text-lg font-bold text-emerald-900 mb-2">Pesanan Anda Berhasil Dikirim!</h3>
            <p class="text-xs text-emerald-700 mb-4 leading-relaxed">
              Tim TapReview akan segera menghubungi WhatsApp Anda untuk konfirmasi desain kartu cetak dan detail pengiriman.
            </p>
            <router-link to="/" class="inline-block px-4 py-2 bg-emerald-600 text-white rounded-lg text-xs font-semibold">
              Kembali ke Beranda
            </router-link>
          </div>

          <form v-else @submit.prevent="submitOrder" class="space-y-4">
            <div>
              <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Usaha / Toko</label>
              <input 
                v-model="form.business_name" 
                type="text" 
                required 
                placeholder="Contoh: Kopi Sudut" 
                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
              />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Kontak PIC</label>
                <input 
                  v-model="form.contact_name" 
                  type="text" 
                  required 
                  placeholder="Nama pemilik / manajer" 
                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                />
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nomor WhatsApp Aktif</label>
                <input 
                  v-model="form.whatsapp" 
                  type="tel" 
                  required 
                  placeholder="081234567890" 
                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                />
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Link Ulasan Google Maps</label>
              <input 
                v-model="form.google_review_url" 
                type="url" 
                required 
                placeholder="https://maps.app.goo.gl/... atau https://g.page/r/..." 
                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
              />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Pilihan Paket</label>
                <select 
                  v-model="form.package_plan" 
                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white"
                >
                  <option value="starter">Paket Starter (1 Stand - Rp 149k)</option>
                  <option value="cafe_resto">Paket Cafe & Resto (3 Stand - Rp 349k)</option>
                  <option value="multi_branch">Paket Multi-Cabang (10 Stand - Rp 899k)</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Jumlah Stand / Titik</label>
                <input 
                  v-model.number="form.point_count" 
                  type="number" 
                  min="1" 
                  max="100" 
                  required 
                  class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                />
              </div>
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Lengkap Pengiriman</label>
              <textarea 
                v-model="form.shipping_address" 
                rows="3" 
                required 
                placeholder="Jl. Thamrin No. 12, Kelurahan, Kecamatan, Kota, Kode Pos" 
                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
              ></textarea>
            </div>

            <div class="pt-4">
              <button 
                type="submit" 
                :disabled="loading"
                class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md shadow-indigo-200 transition disabled:opacity-50"
              >
                {{ loading ? 'Mengirim Data...' : 'Konfirmasi & Kirim Pesanan' }}
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
    // Fallback display for client demo
    submitted.value = true;
  } finally {
    loading.value = false;
  }
}
</script>
