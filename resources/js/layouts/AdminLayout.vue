<template>
  <div class="min-h-screen flex bg-zinc-100">
    <!-- Industrial Admin Sidebar -->
    <aside class="w-64 bg-zinc-950 text-white flex flex-col shrink-0 border-r border-zinc-800">
      <div class="h-16 flex items-center px-6 border-b border-zinc-850 justify-between">
        <div class="flex items-center gap-2.5">
          <div class="w-7 h-7 rounded bg-orange-600 text-white font-mono font-bold text-xs flex items-center justify-center">
            TR
          </div>
          <div>
            <div class="font-bold text-xs tracking-tight uppercase">Admin Backoffice</div>
            <div class="text-[10px] text-orange-400 font-mono">SUPERADMIN CONSOLE</div>
          </div>
        </div>
        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
      </div>

      <nav class="p-3 space-y-1 flex-1 text-xs font-medium">
        <router-link 
          to="/admin" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <LayoutDashboard class="w-4 h-4 text-zinc-400" />
          <span>Dashboard Admin</span>
        </router-link>

        <router-link 
          to="/admin/clients" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <Users class="w-4 h-4 text-zinc-400" />
          <span>Kelola Klien Usaha</span>
        </router-link>

        <router-link 
          to="/admin/points" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <Radio class="w-4 h-4 text-zinc-400" />
          <span>Titik & Chip NFC</span>
        </router-link>

        <router-link 
          to="/admin/themes" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <Palette class="w-4 h-4 text-zinc-400" />
          <span>Katalog Desain Stand</span>
        </router-link>

        <router-link 
          to="/admin/orders" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <PackageCheck class="w-4 h-4 text-zinc-400" />
          <span>Antrean Pesanan Baru</span>
        </router-link>

        <router-link 
          to="/admin/audit-logs" 
          class="flex items-center gap-2.5 px-3 py-2 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-900 transition-colors"
          active-class="bg-zinc-800 text-white font-semibold"
        >
          <ShieldCheck class="w-4 h-4 text-zinc-400" />
          <span>Log & Audit Trail</span>
        </router-link>
      </nav>

      <div class="p-4 border-t border-zinc-850 space-y-2">
        <div class="px-2 py-1 bg-zinc-900 rounded text-[10px] font-mono text-zinc-400 truncate">
          {{ authStore.user?.email || 'SuperAdmin' }}
        </div>
        <router-link to="/" class="flex items-center gap-2 text-xs text-zinc-400 hover:text-white transition-colors">
          <ArrowLeft class="w-3.5 h-3.5" />
          <span>Kembali ke Website</span>
        </router-link>
        <button 
          @click="authStore.logout()"
          type="button"
          class="flex items-center justify-center gap-1.5 w-full py-1.5 px-3 text-[11px] font-semibold text-rose-400 hover:bg-rose-950/30 rounded border border-rose-900/40 transition"
        >
          <LogOut class="w-3.5 h-3.5" />
          <span>Keluar Sesi</span>
        </button>
      </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="h-16 bg-white border-b border-zinc-200 px-6 flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs font-mono text-zinc-500 uppercase">
          <span>BACKOFFICE</span>
          <span>/</span>
          <span class="text-zinc-900 font-bold">PUSAT KONTROL HARDWARE</span>
        </div>
        <div class="flex items-center gap-3 text-xs font-mono text-zinc-500">
          <span class="text-orange-600 font-bold">ADMIN: {{ authStore.user?.name || 'Administrator' }}</span>
          <span>•</span>
          <span class="text-emerald-700 font-semibold flex items-center gap-1">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
            WORKER RUNNING
          </span>
        </div>
      </header>

      <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useAuthStore } from '@/stores/auth';
import { LayoutDashboard, Users, Radio, Palette, PackageCheck, ShieldCheck, ArrowLeft, LogOut } from 'lucide-vue-next';

const authStore = useAuthStore();
</script>
