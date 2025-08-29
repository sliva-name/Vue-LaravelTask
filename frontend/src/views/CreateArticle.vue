<template>
  <div class="min-h-screen bg-gray-900 text-gray-100 p-8">
    <h1 class="text-3xl font-bold mb-6">Создать статью</h1>

    <ArticleForm
        ref="formRef"
        :loading="loading"
        @submit="createNewArticle"
    />
  </div>
</template>

<script setup>
import {ref} from "vue"
import {useRouter} from "vue-router"
import ArticleForm from "../components/ArticleForm.vue"
import {createArticle} from "../api/articles.js"

const loading = ref(false)
const router = useRouter()
const formRef = ref(null)

async function createNewArticle(data) {
  loading.value = true
  try {
    const created = await createArticle(data)
    router.push(`/articles/${created.id}`)
  } catch (err) {
    if (err?.response?.status === 422 && err.response.data?.errors) {
      const e = err.response.data.errors
      formRef.value?.setServerErrors({
        title: e.title?.[0],
        content: e.content?.[0],
        general: e.message || "Ошибка валидации",
      })
    } else {
      formRef.value?.setServerErrors({
        general: "Ошибка при создании статьи",
      })
    }
  } finally {
    loading.value = false
  }
}
</script>
