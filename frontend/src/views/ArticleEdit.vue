<template>
  <div class="min-h-screen bg-gray-900 text-gray-100 p-8">
    <h2 class="text-3xl font-bold mb-6">Редактирование статьи</h2>

    <!-- Форма редактирования -->
    <ArticleForm
        ref="formRef"
        :loading="loading"
        submitText="Сохранить изменения"
        loadingText="Сохраняем..."
        :clearOnSubmit="false"
        @submit="updateArticle"
    />

    <!-- Кнопка удаления статьи -->
    <button
        class="mt-4 px-4 py-2 bg-red-600 rounded hover:bg-red-500"
        @click="removeArticle"
        :disabled="loading"
    >
      Удалить статью
    </button>

    <!-- Комментарии -->
    <div class="mt-10">
      <h3 class="text-2xl font-semibold mb-4">Комментарии</h3>

      <ul v-if="comments.length" class="space-y-3">
        <li
            v-for="comment in comments"
            :key="comment.id"
            class="bg-gray-800 p-4 rounded flex justify-between items-center"
        >
          <div>
            <p>{{ comment.text }}</p>
            <p class="text-gray-400 text-sm mt-1">Автор: {{ comment.author }}</p>
          </div>
          <button
              class="px-2 py-1 bg-red-600 rounded hover:bg-red-500"
              @click="deleteComment(comment.id)"
          >
            Удалить
          </button>
        </li>
      </ul>

      <p v-else class="text-gray-500">Комментариев пока нет.</p>
    </div>
  </div>
</template>

<script setup>
import {ref, onMounted} from "vue"
import {useRoute, useRouter} from "vue-router"
import ArticleForm from "../components/ArticleForm.vue"
import {
  getArticle,
  updateArticle as apiUpdate,
  deleteArticle,
  deleteComment as apiDeleteComment
} from "../api/articles.js"

const route = useRoute()
const router = useRouter()
const formRef = ref(null)
const loading = ref(false)
const comments = ref([])

// Загружаем данные статьи и комментарии
onMounted(async () => {
  try {
    const data = await getArticle(route.params.id)

    if (formRef.value?.localArticle) {
      formRef.value.localArticle.title = data.title
      formRef.value.localArticle.author = data.author
      formRef.value.localArticle.content = data.content
    }

    comments.value = data.comments || []
  } catch (e) {
    console.error("Ошибка загрузки статьи:", e)
  }
})

async function updateArticle(data) {
  loading.value = true
  try {
    await apiUpdate(route.params.id, data)
    // После успешного обновления переходим на страницу статьи
    router.push(`/articles/${route.params.id}`)
  } catch (e) {
    formRef.value?.setServerErrors({general: "Ошибка при обновлении статьи"})
  } finally {
    loading.value = false
  }
}

async function removeArticle() {
  if (!confirm("Вы уверены, что хотите удалить эту статью?")) return

  loading.value = true
  try {
    await deleteArticle(route.params.id)
    router.push("/")
  } catch (e) {
    console.error("Ошибка удаления статьи:", e)
    alert("Не удалось удалить статью")
  } finally {
    loading.value = false
  }
}

async function deleteComment(commentId) {
  if (!confirm("Вы уверены, что хотите удалить этот комментарий?")) return

  try {
    await apiDeleteComment(commentId)
    comments.value = comments.value.filter(c => c.id !== commentId)
  } catch (e) {
    console.error("Ошибка удаления комментария:", e)
    alert("Не удалось удалить комментарий")
  }
}
</script>
