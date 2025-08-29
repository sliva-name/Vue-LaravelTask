<template>
  <form @submit.prevent="onSubmit" class="space-y-4" novalidate>
    <!-- Заголовок -->
    <div>
      <input
          v-model="localArticle.title"
          type="text"
          placeholder="Заголовок"
          class="w-full p-3 rounded-lg bg-gray-800 text-gray-100"
          :aria-invalid="!!errors.title"
      />
      <p v-if="errors.title" class="text-red-400 text-sm mt-1">{{ errors.title }}</p>
    </div>

    <!-- Автор -->
    <div>
      <input
          v-model="localArticle.author"
          type="text"
          placeholder="Автор (необязательно)"
          class="w-full p-3 rounded-lg bg-gray-800 text-gray-100"
      />
    </div>

    <!-- Содержание -->
    <div>
      <textarea
          v-model="localArticle.content"
          placeholder="Содержание статьи"
          class="w-full p-3 rounded-lg bg-gray-800 text-gray-100 min-h-[200px]"
          :aria-invalid="!!errors.content"
      ></textarea>
      <p v-if="errors.content" class="text-red-400 text-sm mt-1">{{ errors.content }}</p>
    </div>

    <!-- Ошибка сервера -->
    <p v-if="generalError" class="text-red-400 text-sm">{{ generalError }}</p>

    <!-- Кнопка отправки -->
    <button
        type="submit"
        class="px-4 py-2 bg-indigo-500 rounded-lg hover:bg-indigo-400 transition disabled:opacity-50"
        :disabled="loading || !localArticle.title.trim() || !localArticle.content.trim()"
    >
      {{ loading ? loadingText : submitText }}
    </button>
  </form>
</template>

<script setup>
import {reactive, ref} from "vue"

const props = defineProps({
  loading: {type: Boolean, default: false},
  submitText: {type: String, default: "Создать статью"},
  loadingText: {type: String, default: "Сохранение..."},
  clearOnSubmit: {type: Boolean, default: true},
})

const emit = defineEmits(["submit"])

const localArticle = reactive({title: "", author: "", content: ""})
const errors = reactive({title: "", content: ""})
const generalError = ref("")

function validate() {
  errors.title = ""
  errors.content = ""
  let ok = true

  if (!localArticle.title.trim()) {
    errors.title = "Заголовок обязателен"
    ok = false
  }
  if (!localArticle.content.trim()) {
    errors.content = "Содержание обязательно"
    ok = false
  }

  return ok
}

function onSubmit() {
  generalError.value = ""
  if (!validate()) return
  emit("submit", {...localArticle})
  if (props.clearOnSubmit) {
    localArticle.title = ""
    localArticle.author = ""
    localArticle.content = ""
  }
}

const setServerErrors = (payload = {}) => {
  if (payload.title) errors.title = payload.title
  if (payload.content) errors.content = payload.content
  if (payload.general) generalError.value = payload.general
}

defineExpose({setServerErrors, localArticle})
</script>
