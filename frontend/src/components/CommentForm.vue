<template>
  <form @submit.prevent="onSubmit" class="space-y-4">
    <input
        v-model="localComment.author"
        type="text"
        placeholder="Ваше имя"
        class="w-full p-3 rounded-lg bg-gray-800 text-gray-100"
    />
    <textarea
        v-model="localComment.text"
        placeholder="Текст комментария"
        class="w-full p-3 rounded-lg bg-gray-800 text-gray-100 min-h-[100px]"
    ></textarea>
    <button
        type="submit"
        class="px-4 py-2 bg-indigo-500 rounded-lg hover:bg-indigo-400 transition"
        :disabled="loading"
    >
      {{ loading ? "Отправка..." : "Отправить" }}
    </button>
  </form>
</template>

<script setup>
import {ref, watch} from "vue"

const props = defineProps({
  loading: Boolean
})

const emit = defineEmits(["submit"])

const localComment = ref({author: "", text: ""})

function onSubmit() {
  if (!localComment.value.text.trim()) return
  emit("submit", {...localComment.value})
  localComment.value = {author: "", text: ""}
}
</script>
