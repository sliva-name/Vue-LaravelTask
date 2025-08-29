<template>
  <div class="min-h-screen bg-gray-900 text-gray-100 p-8">
    <h1 class="text-3xl font-bold mb-6">Список статей</h1>

    <div v-if="loading" class="text-gray-400">Загрузка...</div>
    <div v-else-if="articles.length === 0" class="text-gray-400">
      Статей пока нет
    </div>
    <div v-else class="space-y-6">
      <ArticleCard
          v-for="article in articles"
          :key="article.id"
          :article="article"
      />
    </div>
  </div>
</template>

<script setup>
import {ref, onMounted} from "vue"
import ArticleCard from "../components/ArticleCard.vue"
import {getArticles} from "../api/articles.js"

const articles = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    articles.value = await getArticles()
  } catch (err) {
    console.error("Ошибка загрузки статей:", err)
  } finally {
    loading.value = false
  }
})
</script>
