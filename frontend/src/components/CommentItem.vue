<template>
  <li class="bg-gray-800 p-4 rounded-xl">
    <p class="text-gray-200">{{ comment.text }}</p>
    <p class="text-gray-500 text-sm mt-1">Автор: {{ comment.author }}</p>
  </li>
</template>

<script setup>
const props = defineProps({
  comment: Object
})
</script>
