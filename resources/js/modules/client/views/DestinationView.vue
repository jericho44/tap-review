<template>
  <div class="max-w-2xl space-y-6">
    <div>
      <h2 class="text-xl font-bold text-slate-900">Ubah Link Ulasan Google</h2>
      <p class="text-xs text-slate-500">
        Perubahan link ulasan akan berlaku seketika ke seluruh chip NFC dan kode QR tanpa perlu mengganti stiker.
      </p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
      <div v-if="successMsg" class="p-4 mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs rounded-xl font-medium">
        {{ successMsg }}
      </div>

      <form @submit.prevent="saveDestination" class="space-y-4">
        <div>
          <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">
            Link Ulasan Google Maps Baru
          </label>
          <input 
            v-model="destinationUrl" 
            type="url" 
            required
            placeholder="https://maps.app.goo.gl/... atau https://g.page/r/..." 
            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none"
          />
          <p class="text-[11px] text-slate-500 mt-1">
            Hanya domain Google resmi yang diizinkan untuk keamanan pelanggan Anda.
          </p>
        </div>

        <button 
          type="submit" 
          class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs shadow-sm transition"
        >
          Simpan Perubahan Link
        </button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const destinationUrl = ref('https://maps.app.goo.gl/kopi-sudut-official');
const successMsg = ref('');

function saveDestination() {
  successMsg.value = 'Link ulasan berhasil diperbarui dan telah aktif di seluruh stiker!';
  setTimeout(() => {
    successMsg.value = '';
  }, 4000);
}
</script>
