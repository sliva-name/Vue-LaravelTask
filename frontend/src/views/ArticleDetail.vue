<template>
  <div class="min-h-screen bg-gray-900 text-gray-100 p-8">
    <div v-if="loading" class="text-gray-400">Загрузка...</div>
    <div v-else-if="error" class="text-red-400">{{ error }}</div>
    <div v-else class="space-y-6">
      <!-- Заголовок статьи -->
      <h2 class="text-3xl font-bold text-indigo-400">{{ article.title }}</h2>
      <p class="text-gray-400">Автор: {{ article.author }}</p>
      <p class="mt-4 whitespace-pre-line">{{ article.content }}</p>


      <button
          @click="goToEdit"
          class="px-4 py-2 bg-indigo-500 rounded hover:bg-indigo-400 transition"
      >
        Редактировать статью
      </button>


      <ArticleComments
          :articleId="article.id"
          :comments="article.comments"
          @comment-added="onCommentAdded"
      />
    </div>
  </div>
</template>

<script setup>
import {ref, onMounted} from "vue"
import {useRoute, useRouter} from "vue-router"
import {getArticle} from "../api/articles.js"
import ArticleComments from "../components/ArticleComments.vue"

const route = useRoute()
const router = useRouter()
const article = ref(null)
const loading = ref(true)
const error = ref(null)

onMounted(fetchArticle)

async function fetchArticle() {
  try {
    const res = await getArticle(route.params.id)
    article.value = res
  } catch (e) {
    console.error("Ошибка загрузки статьи:", e)
    error.value = "Не удалось загрузить статью"
  } finally {
    loading.value = false
  }
}

function goToEdit() {
  router.push(`/articles/${article.value.id}/edit`)
}

function onCommentAdded(comment) {
  if (!article.value.comments) article.value.comments = []
  article.value.comments.push(comment)
}
</script>
