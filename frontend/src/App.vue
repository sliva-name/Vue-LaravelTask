<template>
  <div class="min-h-screen bg-gray-950 text-gray-100">
    <AppHeader />
    <main class="max-w-7xl mx-auto p-6">
      <router-view />
    </main>
  </div>
</template>

<script setup>
import AppHeader from "./components/AppHeader.vue"
</script>
