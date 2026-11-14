<template>
  <div class="min-h-screen flex flex-col bg-slate-50 text-slate-800">
    <PublicNavbar />
    <main class="flex-grow">
      <slot />
    </main>
    <PublicFooter />
  </div>
</template>

<script setup lang="ts">
import PublicNavbar from './PublicNavbar.vue';
import PublicFooter from './PublicFooter.vue';
</script>
