<template>
  <div class="bg-gray-800 p-6 rounded-xl shadow hover:shadow-lg transition">
    <router-link :to="`/articles/${article.id}`" class="block">
      <h2 class="text-xl font-semibold text-indigo-400 hover:text-indigo-300">
        {{ article.title }}
      </h2>
      <p class="text-gray-400 mt-2">Автор: {{ article.author || "Аноним" }}</p>
    </router-link>
  </div>
</template>

<script setup>
const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
})
</script>
